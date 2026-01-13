<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefundController extends Controller
{
    /**
     * Get all refund requests
     * GET /api/v1/admin/refund
     */
    public function index(Request $request): JsonResponse
    {
        $query = Pesanan::with([
            'pembeli:id_pengguna,nama_lengkap,email,no_hp',
            'kota',
            'escrow',
        ])
            ->where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)
            ->orderByDesc('tgl_update');

        // Include processed refunds if requested
        if ($request->boolean('termasuk_selesai')) {
            $query->orWhere('status_pesanan', Pesanan::STATUS_DIREFUND);
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $pesanan = $query->paginate($perPage);

        // Transform data
        $pesanan->getCollection()->transform(function ($item) {
            return $this->transformRefundRequest($item);
        });

        // Stats
        $pendingCount = Pesanan::where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)->count();
        $pendingAmount = Pesanan::where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)->sum('total_bayar');

        return response()->json([
            'success' => true,
            'message' => 'Daftar permintaan refund berhasil diambil.',
            'data' => [
                'stats' => [
                    'pending_count' => $pendingCount,
                    'pending_amount' => (float) $pendingAmount,
                    'pending_amount_formatted' => 'Rp ' . number_format((float) $pendingAmount, 0, ',', '.'),
                ],
                'refund_requests' => $pesanan,
            ],
        ]);
    }

    /**
     * Approve refund request
     * POST /api/v1/admin/refund/{id}/approve
     * 
     * @bodyParam catatan string optional Catatan persetujuan.
     */
    public function approve(Request $request, int $id): JsonResponse
    {
        $pesanan = Pesanan::with(['escrow', 'pembeli'])->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        if ($pesanan->status_pesanan !== Pesanan::STATUS_MINTA_REFUND) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dalam status permintaan refund.',
            ], 400);
        }

        try {
            DB::transaction(function () use ($pesanan, $request) {
                // Update pesanan status
                $pesanan->status_pesanan = Pesanan::STATUS_DIREFUND;
                $pesanan->save();

                // Update escrow - refund to pembeli
                if ($pesanan->escrow) {
                    $catatan = $request->input('catatan', 'Refund disetujui oleh admin');
                    $pesanan->escrow->refundKePembeli($pesanan->id_pembeli, $catatan);
                }
            });

            $pesanan->refresh()->load('escrow');

            return response()->json([
                'success' => true,
                'message' => 'Refund berhasil disetujui. Dana akan dikembalikan ke pembeli.',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => $pesanan->status_pesanan,
                    'pembeli' => $pesanan->pembeli?->nama_lengkap,
                    'escrow' => $pesanan->escrow ? [
                        'jumlah' => (float) $pesanan->escrow->jumlah,
                        'status' => $pesanan->escrow->status_escrow,
                        'tgl_kirim' => $pesanan->escrow->tgl_kirim?->toIso8601String(),
                    ] : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui refund.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Reject refund request
     * POST /api/v1/admin/refund/{id}/reject
     * 
     * @bodyParam alasan string required Alasan penolakan.
     */
    public function reject(Request $request, int $id): JsonResponse
    {
        $pesanan = Pesanan::with('escrow')->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        if ($pesanan->status_pesanan !== Pesanan::STATUS_MINTA_REFUND) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak dalam status permintaan refund.',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'alasan' => 'required|string|max:500',
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::transaction(function () use ($pesanan, $request) {
                // Revert status back to terkirim (or selesai depending on business logic)
                $pesanan->status_pesanan = Pesanan::STATUS_TERKIRIM;
                $pesanan->alasan_refund = $pesanan->alasan_refund . ' [DITOLAK: ' . $request->alasan . ']';
                $pesanan->save();
            });

            return response()->json([
                'success' => true,
                'message' => 'Permintaan refund ditolak.',
                'data' => [
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => $pesanan->status_pesanan,
                    'alasan_penolakan' => $request->alasan,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak refund.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Transform refund request for response
     */
    private function transformRefundRequest(Pesanan $pesanan): array
    {
        return [
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => $pesanan->status_pesanan,
            'pembeli' => $pesanan->pembeli ? [
                'id' => $pesanan->pembeli->id_pengguna,
                'nama' => $pesanan->pembeli->nama_lengkap,
                'email' => $pesanan->pembeli->email,
                'no_hp' => $pesanan->pembeli->no_hp,
            ] : null,
            'kota' => $pesanan->kota ? [
                'nama' => $pesanan->kota->nama_kota,
                'provinsi' => $pesanan->kota->provinsi,
            ] : null,
            'total_bayar' => (float) $pesanan->total_bayar,
            'total_formatted' => 'Rp ' . number_format((float) $pesanan->total_bayar, 0, ',', '.'),
            'alasan_refund' => $pesanan->alasan_refund,
            'escrow' => $pesanan->escrow ? [
                'jumlah' => (float) $pesanan->escrow->jumlah,
                'status' => $pesanan->escrow->status_escrow,
            ] : null,
            'tgl_dibuat' => $pesanan->tgl_dibuat?->toIso8601String(),
            'tgl_update' => $pesanan->tgl_update?->toIso8601String(),
        ];
    }
}
