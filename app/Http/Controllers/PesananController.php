<?php

namespace App\Http\Controllers;

use App\Mail\OrderCompletedMail;
use App\Mail\OrderCreatedMail;
use App\Mail\PaymentUploadedMail;
use App\Mail\RefundRequestedMail;
use App\Models\Keranjang;
use App\Models\Kota;
use App\Models\Kupon;
use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\PemakaianKupon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PesananController extends Controller
{
    /**
     * Show checkout page
     * - Load keranjang dengan relasi produk.petani
     * - Load list kota untuk pilihan tujuan
     */
    public function checkout(): View|RedirectResponse
    {
        $items = Keranjang::with(['produk.petani', 'produk.kategori'])
            ->where('id_pengguna', Auth::id())
            ->get();

        // Redirect jika keranjang kosong
        if ($items->isEmpty()) {
            return redirect()->route('keranjang')
                ->with('error', 'Keranjang belanja kosong');
        }

        // Hitung subtotal
        $subtotal = $items->sum('subtotal');

        // Load kota aktif
        $listKota = Kota::aktif()->orderBy('nama_kota')->get();

        return view('pembeli.checkout', compact('items', 'subtotal', 'listKota'));
    }

    /**
     * Process checkout
     * - Validasi keranjang tidak kosong
     * - Validasi kota tujuan
     * - Validasi kupon (opsional)
     * - Reserve stock
     * - Create pesanan + item_pesanan
     * - Record pemakaian_kupon jika ada
     * - Clear keranjang
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_kota_tujuan' => 'required|exists:kota,id_kota',
            'kode_kupon' => 'nullable|string|max:50',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Load keranjang dengan produk
        $items = Keranjang::with('produk')
            ->where('id_pengguna', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang')
                ->with('error', 'Keranjang belanja kosong');
        }

        // Validasi stok tersedia untuk semua item
        foreach ($items as $item) {
            if (!$item->produk->cekStok($item->jumlah)) {
                return back()->withErrors([
                    'stok' => "Stok {$item->produk->nama_produk} tidak mencukupi. Tersedia: {$item->produk->stokTersedia()}"
                ]);
            }
        }

        // Load kota untuk ongkir
        $kota = Kota::aktif()->findOrFail($request->id_kota_tujuan);

        // Hitung subtotal
        $subtotal = $items->sum('subtotal');
        $ongkir = $kota->ongkir;
        $diskon = 0;
        $kupon = null;

        // Validasi kupon jika ada
        if ($request->filled('kode_kupon')) {
            $kupon = Kupon::where('kode_kupon', $request->kode_kupon)->first();

            if (!$kupon) {
                return back()->withErrors(['kode_kupon' => 'Kode kupon tidak ditemukan']);
            }

            if (!$kupon->isValid()) {
                return back()->withErrors(['kode_kupon' => 'Kupon sudah tidak berlaku']);
            }

            // Cek minimum belanja
            if ($subtotal < $kupon->min_belanja) {
                return back()->withErrors([
                    'kode_kupon' => "Minimum belanja Rp " . number_format((float) $kupon->min_belanja, 0, ',', '.') . " untuk menggunakan kupon ini"
                ]);
            }

            // Cek limit total pemakaian
            if ($kupon->limit_total !== null) {
                $totalPemakaian = $kupon->pemakaian()->count();
                if ($totalPemakaian >= $kupon->limit_total) {
                    return back()->withErrors(['kode_kupon' => 'Kupon sudah habis digunakan']);
                }
            }

            // Cek limit per user
            if ($kupon->limit_per_user !== null) {
                $userPemakaian = $kupon->pemakaian()
                    ->where('id_pengguna', Auth::id())
                    ->count();
                if ($userPemakaian >= $kupon->limit_per_user) {
                    return back()->withErrors(['kode_kupon' => 'Anda sudah mencapai batas pemakaian kupon ini']);
                }
            }

            $diskon = $kupon->hitungDiskon($subtotal);
        }

        // Hitung total
        $totalBayar = $subtotal + $ongkir - $diskon;

        // Process dalam transaction
        $pesanan = DB::transaction(function () use ($items, $kota, $subtotal, $ongkir, $diskon, $totalBayar, $kupon, $request) {
            // 1. Reserve stock untuk semua item
            foreach ($items as $item) {
                $item->produk->reserveStok($item->jumlah);
            }

            // 2. Create pesanan
            $pesanan = Pesanan::create([
                'id_pembeli' => Auth::id(),
                'id_kota_tujuan' => $kota->id_kota,
                'subtotal' => $subtotal,
                'ongkir' => $ongkir,
                'diskon' => $diskon,
                'total_bayar' => $totalBayar,
                'status_pesanan' => Pesanan::STATUS_PENDING,
                'batas_bayar' => now()->addHours(24),
                'catatan' => $request->catatan,
            ]);

            // 3. Create item_pesanan
            foreach ($items as $item) {
                ItemPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $item->produk->id_produk,
                    'id_petani' => $item->produk->id_petani,
                    'jumlah' => $item->jumlah,
                    'harga_snapshot' => $item->produk->harga,
                    'subtotal' => $item->subtotal,
                ]);
            }

            // 4. Record pemakaian kupon jika ada
            if ($kupon) {
                PemakaianKupon::create([
                    'id_kupon' => $kupon->id_kupon,
                    'id_pengguna' => Auth::id(),
                    'id_pesanan' => $pesanan->id_pesanan,
                    'diskon_dipakai' => $diskon,
                ]);
            }

            // 5. Clear keranjang
            Keranjang::where('id_pengguna', Auth::id())->delete();

            return $pesanan;
        });

        // Send order created emails
        try {
            $pesanan->load(['pembeli', 'items.produk.petani']);

            // Email to pembeli
            Mail::to($pesanan->pembeli->email)->queue(new OrderCreatedMail($pesanan, 'pembeli'));

            // Email to each petani
            $petaniEmails = $pesanan->items->pluck('produk.petani.email')->unique()->filter();
            foreach ($petaniEmails as $email) {
                Mail::to($email)->queue(new OrderCreatedMail($pesanan, 'petani'));
            }
        } catch (Exception $e) {
            Log::error('Failed to send order created email: ' . $e->getMessage());
        }

        return redirect()->route('pesanan.detail', $pesanan->id_pesanan)
            ->with('success', 'Pesanan berhasil dibuat! Silakan upload bukti pembayaran sebelum ' . $pesanan->batas_bayar->format('d M Y H:i'));
    }

    /**
     * Show user's orders
     * - Filter by status (optional)
     * - Order by tgl_dibuat DESC
     */
    public function index(Request $request): View
    {
        $query = Pesanan::with(['kota', 'items.produk'])
            ->where('id_pembeli', Auth::id())
            ->orderByDesc('tgl_dibuat');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->status);
        }

        $pesanan = $query->paginate(10);

        // Status untuk filter tabs
        $statusList = [
            'pending' => 'Menunggu Bayar',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'dibayar' => 'Dibayar',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'terkirim' => 'Terkirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        return view('pembeli.pesanan', compact('pesanan', 'statusList'));
    }

    /**
     * Show order detail
     * - Load relasi lengkap
     * - Cek ownership
     */
    public function show(int $id): View
    {
        $pesanan = Pesanan::with([
            'pembeli',
            'kota',
            'items.produk.petani.rekening' => fn($q) => $q->where('is_utama', true),
            'historiStatus.pengubah',
            'pemakaianKupon.kupon',
        ])
            ->where('id_pembeli', Auth::id())
            ->findOrFail($id);

        // echo "<pre>";
        // print_r($pesanan);
        // die;

        return view('pembeli.pesanan-detail', compact('pesanan'));
    }

    /**
     * Upload payment proof
     * - Validasi: JPG/PNG, max 2MB
     * - Simpan ke storage/app/public/bukti-bayar/
     * - Update status → menunggu_verifikasi
     */
    public function uploadBukti(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti_bayar.required' => 'Bukti pembayaran wajib diupload.',
            'bukti_bayar.image' => 'File harus berupa gambar.',
            'bukti_bayar.mimes' => 'Format file harus JPG atau PNG.',
            'bukti_bayar.max' => 'Ukuran file maksimal 2MB.',
        ]);

        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        $pesanan = Pesanan::where('id_pembeli', $user->id_pengguna)
            ->findOrFail($id);

        if (!$pesanan->bisaUploadBukti()) {
            return back()->withErrors([
                'error' => 'Pesanan tidak bisa diupload bukti bayar. Status saat ini: ' . $pesanan->status_pesanan
            ]);
        }

        // Simpan file ke disk public
        $file = $request->file('bukti_bayar');
        $filename = 'bukti_' . $pesanan->id_pesanan . '_' . time() . '.' . $file->getClientOriginalExtension();
        $stored = $file->storeAs('bukti-bayar', $filename, 'public');

        if (!$stored) {
            return back()->withErrors(['bukti_bayar' => 'Gagal menyimpan file. Silakan coba lagi.']);
        }

        // Update pesanan
        $pesanan->update([
            'bukti_bayar' => 'bukti-bayar/' . $filename,
            'status_pesanan' => Pesanan::STATUS_MENUNGGU_VERIFIKASI,
        ]);

        // Send email to petani
        try {
            $pesanan->load('items.produk.petani');
            $petaniEmails = $pesanan->items->pluck('produk.petani.email')->unique()->filter();
            foreach ($petaniEmails as $email) {
                Mail::to($email)->queue(new PaymentUploadedMail($pesanan));
            }
        } catch (Exception $e) {
            Log::error('Failed to send payment uploaded email: ' . $e->getMessage());
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi dari petani.');
    }

    /**
     * Cancel order
     * - Hanya bisa jika status pending atau menunggu_verifikasi
     * - Release reserved stock
     * - Set alasan_batal, tgl_dibatalkan
     */
    public function batal(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'alasan_batal' => 'nullable|string|max:500',
        ]);

        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        $pesanan = Pesanan::with('items.produk')
            ->where('id_pembeli', $user->id_pengguna)
            ->findOrFail($id);

        if (!$pesanan->bisaDibatalkan()) {
            return back()->withErrors([
                'error' => 'Pesanan tidak bisa dibatalkan. Status saat ini: ' . $pesanan->status_pesanan
            ]);
        }

        DB::transaction(function () use ($pesanan, $request) {
            // Release reserved stock untuk semua item
            foreach ($pesanan->items as $item) {
                $item->produk->releaseStok($item->jumlah);
            }

            // Update pesanan
            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_DIBATALKAN,
                'alasan_batal' => $request->alasan_batal ?? 'Dibatalkan oleh pembeli',
                'tgl_dibatalkan' => now(),
            ]);
        });

        return redirect()->route('pesanan')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Confirm order received
     * - Hanya bisa jika status terkirim
     * - Update status → selesai
     * - Set tgl_selesai, id_konfirmasi
     * - Release escrow ke petani
     */
    public function konfirmasi(int $id): RedirectResponse
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        $pesanan = Pesanan::with(['escrow', 'items.produk'])
            ->where('id_pembeli', $user->id_pengguna)
            ->findOrFail($id);

        if (!$pesanan->bisaDikonfirmasi()) {
            return back()->withErrors([
                'error' => 'Pesanan tidak bisa dikonfirmasi. Status saat ini: ' . $pesanan->status_pesanan
            ]);
        }

        DB::transaction(function () use ($pesanan, $user) {
            // Update pesanan
            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_SELESAI,
                'tgl_selesai' => now(),
                'id_konfirmasi' => $user->id_pengguna,
            ]);

            // Release escrow ke petani
            if ($pesanan->escrow) {
                $idPetani = $pesanan->items->first()->produk->id_petani;
                $pesanan->escrow->kirimKePetani($idPetani, 'Dikonfirmasi oleh pembeli');
            }
        });

        // Send order completed emails
        try {
            $pesanan->load(['pembeli', 'items.produk.petani']);

            // Email to pembeli
            Mail::to($pesanan->pembeli->email)->queue(new OrderCompletedMail($pesanan, 'pembeli'));

            // Email to petani
            $petaniEmails = $pesanan->items->pluck('produk.petani.email')->unique()->filter();
            foreach ($petaniEmails as $email) {
                Mail::to($email)->queue(new OrderCompletedMail($pesanan, 'petani'));
            }
        } catch (Exception $e) {
            Log::error('Failed to send order completed email: ' . $e->getMessage());
        }

        return redirect()->route('pesanan.detail', $id)
            ->with('success', 'Terima kasih! Pesanan telah dikonfirmasi selesai.');
    }

    /**
     * Request refund
     * - Hanya bisa jika status terkirim
     * - Update status → minta_refund
     */
    public function mintaRefund(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'alasan_refund' => 'required|string|max:500',
        ], [
            'alasan_refund.required' => 'Alasan refund wajib diisi.',
            'alasan_refund.max' => 'Alasan refund maksimal 500 karakter.',
        ]);

        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        $pesanan = Pesanan::where('id_pembeli', $user->id_pengguna)
            ->findOrFail($id);

        if (!$pesanan->bisaRefund()) {
            return back()->withErrors([
                'error' => 'Pesanan tidak bisa diajukan refund. Status saat ini: ' . $pesanan->status_pesanan
            ]);
        }

        $pesanan->update([
            'status_pesanan' => Pesanan::STATUS_MINTA_REFUND,
            'alasan_refund' => $request->alasan_refund,
        ]);

        // Send email to admins
        try {
            $pesanan->load('pembeli');
            $adminEmails = Pengguna::where('role_pengguna', 'admin')->pluck('email');
            foreach ($adminEmails as $email) {
                Mail::to($email)->queue(new RefundRequestedMail($pesanan));
            }
        } catch (Exception $e) {
            Log::error('Failed to send refund requested email: ' . $e->getMessage());
        }

        return back()->with('success', 'Permintaan refund berhasil dikirim. Admin akan meninjau permintaan Anda.');
    }

    /**
     * View payment proof image
     * - Serve file directly to bypass symlink issues
     */
    public function viewBuktiBayar(int $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Check authorization - only owner or related petani can view
        $userId = Auth::id();
        $isPembeli = $pesanan->id_pembeli === $userId;
        $isPetani = $pesanan->items()->whereHas('produk', fn($q) => $q->where('id_petani', $userId))->exists();

        if (!$isPembeli && !$isPetani && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        if (!$pesanan->bukti_bayar) {
            abort(404, 'Payment proof not found');
        }

        $path = storage_path('app/public/' . $pesanan->bukti_bayar);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path);
    }
}
