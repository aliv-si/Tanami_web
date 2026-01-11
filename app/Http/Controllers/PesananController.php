<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Kota;
use App\Models\Kupon;
use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\PemakaianKupon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'kota',
            'items.produk.petani',
            'historiStatus.pengubah',
            'pemakaianKupon.kupon',
        ])
            ->where('id_pembeli', Auth::id())
            ->findOrFail($id);

        return view('pembeli.pesanan-detail', compact('pesanan'));
    }

    /**
     * Upload payment proof
     */
    public function uploadBukti(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement (3.5)
        return back();
    }

    /**
     * Cancel order
     */
    public function batal(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement (3.5)
        return back();
    }

    /**
     * Confirm order received
     */
    public function konfirmasi(int $id): RedirectResponse
    {
        // TODO: Implement (3.5)
        return back();
    }

    /**
     * Request refund
     */
    public function mintaRefund(Request $request, int $id): RedirectResponse
    {
        // TODO: Implement (3.5)
        return back();
    }
}
