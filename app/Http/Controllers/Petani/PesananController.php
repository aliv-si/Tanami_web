<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Mail\OrderShippedMail;
use App\Mail\PaymentVerifiedMail;
use App\Models\Escrow;
use App\Models\HistoriStatus;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PesananController extends Controller
{
    /**
     * Get base query for petani's orders (orders containing their products)
     */
    private function getPetaniOrdersQuery()
    {
        $petaniId = Auth::id();

        return Pesanan::whereHas('items', function ($query) use ($petaniId) {
            $query->where('id_petani', $petaniId);
        })->with([
            'pembeli:id_pengguna,nama_lengkap,email,no_hp',
            'kota:id_kota,nama_kota',
            'items' => function ($query) use ($petaniId) {
                $query->where('id_petani', $petaniId)->with('produk:id_produk,nama_produk,foto');
            },
        ]);
    }

    /**
     * Show incoming orders
     */
    public function index(Request $request): View
    {
        $query = $this->getPetaniOrdersQuery();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->input('status'));
        }

        // Default: show only active orders (not cancelled/completed/refunded)
        if (!$request->has('status') && !$request->has('semua')) {
            $query->aktif();
        }

        $pesanan = $query->orderBy('tgl_dibuat', 'desc')->paginate(10);

        // Count by status for tabs
        $petaniId = Auth::id();
        $statusCounts = [
            'menunggu_verifikasi' => Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
                ->menungguVerifikasi()->count(),
            'dibayar' => Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
                ->where('status_pesanan', Pesanan::STATUS_DIBAYAR)->count(),
            'diproses' => Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
                ->where('status_pesanan', Pesanan::STATUS_DIPROSES)->count(),
            'dikirim' => Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
                ->where('status_pesanan', Pesanan::STATUS_DIKIRIM)->count(),
        ];

        return view('petani.pesanan.index', [
            'pesanan' => $pesanan,
            'statusCounts' => $statusCounts,
            'currentStatus' => $request->input('status'),
        ]);
    }

    /**
     * Show order detail
     */
    public function show(int $id): View
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
            ->with([
                'pembeli',
                'kota',
                'escrow',
                'historiStatus.pengubah:id_pengguna,nama_lengkap',
                'items' => fn($q) => $q->where('id_petani', $petaniId)->with('produk'),
            ])
            ->findOrFail($id);

        // Calculate petani's portion of the order
        $subtotalPetani = $pesanan->items->sum('subtotal');

        return view('petani.pesanan.detail', [
            'pesanan' => $pesanan,
            'subtotalPetani' => $subtotalPetani,
        ]);
    }

    /**
     * Verify payment - APPROVE
     * 
     * Actions:
     * 1. Update status → dibayar
     * 2. Set tgl_verifikasi & id_verifikator
     * 3. Kurangi stok aktual produk
     * 4. Release reserved stock
     * 5. Create escrow dengan status 'ditahan'
     * 6. Log histori status
     */
    public function verifikasi(int $id): RedirectResponse
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
            ->with(['items.produk'])
            ->findOrFail($id);

        // Validate status
        if (!$pesanan->bisaDiverifikasi()) {
            return back()->with('error', 'Pesanan tidak dapat diverifikasi.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pesanan->status_pesanan;

            // 1. Update pesanan status
            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_DIBAYAR,
                'tgl_verifikasi' => now(),
                'id_verifikator' => $petaniId,
            ]);

            // 2. Process each item - kurangi stok aktual & release reserved
            foreach ($pesanan->items as $item) {
                if ($item->produk) {
                    $item->produk->kurangiStok($item->jumlah);
                }
            }

            // 3. Create escrow - dana ditahan platform
            Escrow::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'jumlah' => $pesanan->total_bayar,
                'status_escrow' => Escrow::STATUS_DITAHAN,
                'tgl_ditahan' => now(),
                'catatan' => 'Pembayaran diverifikasi oleh petani',
            ]);

            // 4. Log histori status
            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_DIBAYAR,
                'id_pengubah' => $petaniId,
                'alasan' => 'Pembayaran diverifikasi',
            ]);

            DB::commit();

            // Send email to pembeli
            try {
                $pesanan->load('pembeli');
                Mail::to($pesanan->pembeli->email)->queue(new PaymentVerifiedMail($pesanan));
            } catch (\Exception $e) {
                \Log::error('Failed to send payment verified email: ' . $e->getMessage());
            }

            return back()->with('success', 'Pembayaran berhasil diverifikasi. Stok telah dikurangi dan dana ditahan di escrow.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reject payment - TOLAK
     * 
     * Actions:
     * 1. Update status → dibatalkan
     * 2. Set alasan_tolak & tgl_dibatalkan
     * 3. Release reserved stock
     * 4. Log histori status
     */
    public function tolak(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'alasan' => ['required', 'string', 'max:500'],
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $petaniId = Auth::id();

        $pesanan = Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
            ->with(['items.produk'])
            ->findOrFail($id);

        // Validate status
        if (!$pesanan->bisaDiverifikasi()) {
            return back()->with('error', 'Pesanan tidak dapat ditolak.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pesanan->status_pesanan;

            // 1. Update pesanan status
            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_DIBATALKAN,
                'alasan_tolak' => $request->input('alasan'),
                'alasan_batal' => 'Ditolak oleh petani: ' . $request->input('alasan'),
                'tgl_dibatalkan' => now(),
            ]);

            // 2. Release reserved stock untuk setiap item
            foreach ($pesanan->items as $item) {
                if ($item->produk) {
                    $item->produk->releaseStok($item->jumlah);
                }
            }

            // 3. Log histori status
            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_DIBATALKAN,
                'id_pengubah' => $petaniId,
                'alasan' => 'Ditolak: ' . $request->input('alasan'),
            ]);

            DB::commit();

            return back()->with('success', 'Pesanan berhasil ditolak. Stok yang direserve telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Mark as processing
     */
    public function proses(int $id): RedirectResponse
    {
        $petaniId = Auth::id();

        $pesanan = Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
            ->findOrFail($id);

        // Validate - hanya bisa dari status dibayar
        if ($pesanan->status_pesanan !== Pesanan::STATUS_DIBAYAR) {
            return back()->with('error', 'Pesanan tidak dapat diproses.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pesanan->status_pesanan;

            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_DIPROSES,
            ]);

            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_DIPROSES,
                'id_pengubah' => $petaniId,
                'alasan' => 'Pesanan sedang diproses',
            ]);

            DB::commit();

            return back()->with('success', 'Pesanan sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Ship order - input nomor resi
     */
    public function kirim(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'no_resi' => ['required', 'string', 'max:100'],
        ], [
            'no_resi.required' => 'Nomor resi wajib diisi.',
        ]);

        $petaniId = Auth::id();

        $pesanan = Pesanan::whereHas('items', fn($q) => $q->where('id_petani', $petaniId))
            ->findOrFail($id);

        // Validate - hanya bisa dari status dibayar atau diproses
        if (!in_array($pesanan->status_pesanan, [Pesanan::STATUS_DIBAYAR, Pesanan::STATUS_DIPROSES])) {
            return back()->with('error', 'Pesanan tidak dapat dikirim.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pesanan->status_pesanan;

            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_DIKIRIM,
                'no_resi' => $request->input('no_resi'),
            ]);

            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_DIKIRIM,
                'id_pengubah' => $petaniId,
                'alasan' => 'Dikirim dengan resi: ' . $request->input('no_resi'),
            ]);

            DB::commit();

            // Send email to pembeli
            try {
                $pesanan->load('pembeli');
                Mail::to($pesanan->pembeli->email)->queue(new OrderShippedMail($pesanan));
            } catch (\Exception $e) {
                \Log::error('Failed to send order shipped email: ' . $e->getMessage());
            }

            return back()->with('success', 'Pesanan berhasil dikirim dengan resi: ' . $request->input('no_resi'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
