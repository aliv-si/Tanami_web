<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\RefundApprovedMail;
use App\Models\Escrow;
use App\Models\HistoriStatus;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RefundController extends Controller
{
    /**
     * Show refund requests
     */
    public function index(): View
    {
        // Pesanan dengan status minta_refund
        $refundRequests = Pesanan::where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)
            ->with([
                'pembeli:id_pengguna,nama_lengkap,email,no_hp',
                'kota:id_kota,nama_kota',
                'escrow',
                'items.produk:id_produk,nama_produk',
                'items.petani:id_pengguna,nama_lengkap',
            ])
            ->orderBy('tgl_update', 'desc')
            ->paginate(15);

        // Histori refund yang sudah diproses
        $refundHistory = Pesanan::where('status_pesanan', Pesanan::STATUS_DIREFUND)
            ->with([
                'pembeli:id_pengguna,nama_lengkap',
                'escrow.penerima:id_pengguna,nama_lengkap',
            ])
            ->orderBy('tgl_dibatalkan', 'desc')
            ->limit(20)
            ->get();

        // Stats
        $stats = [
            'pending_count' => Pesanan::where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)->count(),
            'pending_amount' => Pesanan::where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)->sum('total_bayar'),
            'completed_count' => Pesanan::where('status_pesanan', Pesanan::STATUS_DIREFUND)->count(),
            'completed_amount' => Escrow::where('status_escrow', Escrow::STATUS_DIREFUND_KE_PEMBELI)->sum('jumlah'),
        ];

        return view('admin.refund', [
            'refundRequests' => $refundRequests,
            'refundHistory' => $refundHistory,
            'stats' => $stats,
        ]);
    }

    /**
     * Show refund detail
     */
    public function show(int $id): View
    {
        $pesanan = Pesanan::with([
            'pembeli',
            'kota',
            'escrow',
            'items.produk',
            'items.petani:id_pengguna,nama_lengkap',
            'historiStatus.pengubah:id_pengguna,nama_lengkap',
        ])->findOrFail($id);

        return view('admin.refund-detail', [
            'pesanan' => $pesanan,
        ]);
    }

    /**
     * Approve refund request
     */
    public function approve(int $id): RedirectResponse
    {
        $pesanan = Pesanan::with(['pembeli', 'escrow'])->findOrFail($id);

        if ($pesanan->status_pesanan !== Pesanan::STATUS_MINTA_REFUND) {
            return back()->with('error', 'Pesanan tidak dalam status minta refund.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pesanan->status_pesanan;

            // Update pesanan status
            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_DIREFUND,
                'tgl_dibatalkan' => now(),
                'alasan_batal' => 'Refund disetujui oleh admin',
            ]);

            // Refund escrow to pembeli
            if ($pesanan->escrow && $pesanan->escrow->status_escrow === Escrow::STATUS_DITAHAN) {
                $pesanan->escrow->refundKePembeli(
                    $pesanan->pembeli->id_pengguna,
                    'Refund disetujui oleh admin'
                );
            }

            // Log histori
            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_DIREFUND,
                'id_pengubah' => Auth::id(),
                'alasan' => 'Refund disetujui oleh admin',
            ]);

            DB::commit();

            // Send email to pembeli
            try {
                Mail::to($pesanan->pembeli->email)->queue(new RefundApprovedMail($pesanan));
            } catch (\Exception $e) {
                \Log::error('Failed to send refund approved email: ' . $e->getMessage());
            }

            return back()->with('success', 'Refund berhasil disetujui. Dana akan dikembalikan ke pembeli.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reject refund request
     */
    public function reject(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'alasan' => ['required', 'string', 'max:500'],
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status_pesanan !== Pesanan::STATUS_MINTA_REFUND) {
            return back()->with('error', 'Pesanan tidak dalam status minta refund.');
        }

        DB::beginTransaction();
        try {
            $statusLama = $pesanan->status_pesanan;

            // Revert status ke terkirim (pembeli bisa konfirmasi lagi)
            $pesanan->update([
                'status_pesanan' => Pesanan::STATUS_TERKIRIM,
            ]);

            // Log histori
            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => Pesanan::STATUS_TERKIRIM,
                'id_pengubah' => Auth::id(),
                'alasan' => 'Refund ditolak: ' . $request->input('alasan'),
            ]);

            DB::commit();

            return back()->with('success', 'Refund ditolak. Status pesanan dikembalikan ke terkirim.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
