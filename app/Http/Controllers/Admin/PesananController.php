<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoriStatus;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PesananController extends Controller
{
    /**
     * Show all orders with filter
     */
    public function index(Request $request): View
    {
        $query = Pesanan::with([
            'pembeli:id_pengguna,nama_lengkap,email',
            'kota:id_kota,nama_kota',
        ]);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pesanan', $request->input('status'));
        }

        // Filter by date range
        if ($request->filled('dari')) {
            $query->whereDate('tgl_dibuat', '>=', $request->input('dari'));
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tgl_dibuat', '<=', $request->input('sampai'));
        }

        // Search by ID or pembeli name
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('id_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('pembeli', function ($q) use ($search) {
                      $q->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        $pesananList = $query->orderBy('tgl_dibuat', 'desc')->paginate(15)->withQueryString();

        // Status counts
        $statusCounts = [
            'pending' => Pesanan::where('status_pesanan', Pesanan::STATUS_PENDING)->count(),
            'menunggu_verifikasi' => Pesanan::where('status_pesanan', Pesanan::STATUS_MENUNGGU_VERIFIKASI)->count(),
            'dibayar' => Pesanan::where('status_pesanan', Pesanan::STATUS_DIBAYAR)->count(),
            'diproses' => Pesanan::where('status_pesanan', Pesanan::STATUS_DIPROSES)->count(),
            'dikirim' => Pesanan::where('status_pesanan', Pesanan::STATUS_DIKIRIM)->count(),
            'terkirim' => Pesanan::where('status_pesanan', Pesanan::STATUS_TERKIRIM)->count(),
            'selesai' => Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)->count(),
            'dibatalkan' => Pesanan::where('status_pesanan', Pesanan::STATUS_DIBATALKAN)->count(),
            'minta_refund' => Pesanan::where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)->count(),
            'direfund' => Pesanan::where('status_pesanan', Pesanan::STATUS_DIREFUND)->count(),
        ];

        return view('admin.pesanan.index', [
            'pesananList' => $pesananList,
            'statusCounts' => $statusCounts,
            'currentStatus' => $request->input('status'),
            'currentSearch' => $request->input('q'),
        ]);
    }

    /**
     * Show order detail with full history
     */
    public function show(int $id): View
    {
        $pesanan = Pesanan::with([
            'pembeli',
            'kota',
            'verifikator:id_pengguna,nama_lengkap',
            'konfirmator:id_pengguna,nama_lengkap',
            'escrow.penerima:id_pengguna,nama_lengkap',
            'items.produk',
            'items.petani:id_pengguna,nama_lengkap',
            'historiStatus.pengubah:id_pengguna,nama_lengkap',
            'pemakaianKupon.kupon',
        ])->findOrFail($id);

        return view('admin.pesanan.detail', [
            'pesanan' => $pesanan,
        ]);
    }

    /**
     * Cancel order by admin
     */
    public function cancel(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'alasan' => ['required', 'string', 'max:500'],
        ]);

        $pesanan = Pesanan::with('items.produk')->findOrFail($id);

        // Only can cancel certain statuses
        if (!in_array($pesanan->status_pesanan, [
            Pesanan::STATUS_PENDING,
            Pesanan::STATUS_MENUNGGU_VERIFIKASI,
        ])) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan pada status ini.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pesanan->status_pesanan;

            // Release reserved stock
            foreach ($pesanan->items as $item) {
                if ($item->produk) {
                    $item->produk->releaseStok($item->jumlah);
                }
            }

            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_DIBATALKAN,
                'alasan_batal' => 'Dibatalkan oleh admin: ' . $request->input('alasan'),
                'tgl_dibatalkan' => now(),
            ]);

            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_DIBATALKAN,
                'id_pengubah' => Auth::id(),
                'alasan' => 'Dibatalkan oleh admin: ' . $request->input('alasan'),
            ]);

            DB::commit();

            return back()->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Force complete order by admin
     */
    public function forceComplete(int $id): RedirectResponse
    {
        $pesanan = Pesanan::with('escrow')->findOrFail($id);

        // Only can force complete if status is terkirim
        if ($pesanan->status_pesanan !== Pesanan::STATUS_TERKIRIM) {
            return back()->with('error', 'Hanya pesanan dengan status terkirim yang dapat diselesaikan.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pesanan->status_pesanan;

            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_SELESAI,
                'tgl_selesai' => now(),
                'id_konfirmasi' => Auth::id(),
            ]);

            // Release escrow to petani
            if ($pesanan->escrow && $pesanan->escrow->status_escrow === 'ditahan') {
                $petaniId = $pesanan->items->first()?->id_petani;
                if ($petaniId) {
                    $pesanan->escrow->kirimKePetani($petaniId, 'Force complete oleh admin');
                }
            }

            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_SELESAI,
                'id_pengubah' => Auth::id(),
                'alasan' => 'Force complete oleh admin',
            ]);

            DB::commit();

            return back()->with('success', 'Pesanan berhasil diselesaikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
