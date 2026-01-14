<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\HistoriStatus;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EscrowController extends Controller
{
    /**
     * Show escrow transactions with filter
     */
    public function index(Request $request): View
    {
        $query = Escrow::with([
            'pesanan:id_pesanan,id_pembeli,status_pesanan,total_bayar,tgl_dibuat',
            'pesanan.pembeli:id_pengguna,nama_lengkap',
            'pesanan.items.produk.petani:id_pengguna,nama_lengkap',
            'penerima:id_pengguna,nama_lengkap',
        ]);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_escrow', $request->input('status'));
        }

        // Filter by date range
        if ($request->filled('dari')) {
            $query->whereDate('tgl_ditahan', '>=', $request->input('dari'));
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tgl_ditahan', '<=', $request->input('sampai'));
        }

        $escrowList = $query->orderBy('tgl_ditahan', 'desc')->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total_ditahan' => Escrow::where('status_escrow', Escrow::STATUS_DITAHAN)->sum('jumlah'),
            'total_dikirim' => Escrow::where('status_escrow', Escrow::STATUS_DIKIRIM_KE_PETANI)->sum('jumlah'),
            'total_direfund' => Escrow::where('status_escrow', Escrow::STATUS_DIREFUND_KE_PEMBELI)->sum('jumlah'),
            'count_ditahan' => Escrow::where('status_escrow', Escrow::STATUS_DITAHAN)->count(),
            'count_dikirim' => Escrow::where('status_escrow', Escrow::STATUS_DIKIRIM_KE_PETANI)->count(),
            'count_direfund' => Escrow::where('status_escrow', Escrow::STATUS_DIREFUND_KE_PEMBELI)->count(),
        ];

        return view('admin.escrow', [
            'escrowList' => $escrowList,
            'stats' => $stats,
            'currentStatus' => $request->input('status'),
        ]);
    }

    /**
     * Release escrow to petani (manual action by admin)
     */
    public function releaseToPetani(int $id): RedirectResponse
    {
        $escrow = Escrow::with('pesanan.items.petani')->findOrFail($id);

        if ($escrow->status_escrow !== Escrow::STATUS_DITAHAN) {
            return back()->with('error', 'Escrow sudah diproses sebelumnya.');
        }

        // Get petani from pesanan items (assuming single petani per order for simplicity)
        $petani = $escrow->pesanan->items->first()?->petani;
        if (!$petani) {
            return back()->with('error', 'Petani tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            $escrow->kirimKePetani($petani->id_pengguna, 'Dirilis oleh admin');

            // Update pesanan status if terkirim -> selesai
            if ($escrow->pesanan->status_pesanan === Pesanan::STATUS_TERKIRIM) {
                $statusLama = $escrow->pesanan->status_pesanan;
                $escrow->pesanan->update([
                    'status_pesanan' => Pesanan::STATUS_SELESAI,
                    'tgl_selesai' => now(),
                ]);

                HistoriStatus::create([
                    'id_pesanan' => $escrow->pesanan->id_pesanan,
                    'status_lama' => $statusLama,
                    'status_baru' => Pesanan::STATUS_SELESAI,
                    'id_pengubah' => Auth::id(),
                    'alasan' => 'Escrow dirilis oleh admin',
                ]);
            }

            DB::commit();

            return back()->with('success', 'Dana berhasil dikirim ke petani.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Refund escrow to pembeli (manual action by admin)
     */
    public function refundToPembeli(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'alasan' => ['required', 'string', 'max:500'],
        ]);

        $escrow = Escrow::with('pesanan.pembeli')->findOrFail($id);

        if ($escrow->status_escrow !== Escrow::STATUS_DITAHAN) {
            return back()->with('error', 'Escrow sudah diproses sebelumnya.');
        }

        $pembeli = $escrow->pesanan->pembeli;
        if (!$pembeli) {
            return back()->with('error', 'Pembeli tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            $escrow->refundKePembeli($pembeli->id_pengguna, $request->input('alasan'));

            // Update pesanan status
            $statusLama = $escrow->pesanan->status_pesanan;
            $escrow->pesanan->update([
                'status_pesanan' => Pesanan::STATUS_DIREFUND,
                'alasan_batal' => 'Refund oleh admin: ' . $request->input('alasan'),
                'tgl_dibatalkan' => now(),
            ]);

            HistoriStatus::create([
                'id_pesanan' => $escrow->pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_DIREFUND,
                'id_pengubah' => Auth::id(),
                'alasan' => 'Refund oleh admin: ' . $request->input('alasan'),
            ]);

            DB::commit();

            return back()->with('success', 'Dana berhasil direfund ke pembeli.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
