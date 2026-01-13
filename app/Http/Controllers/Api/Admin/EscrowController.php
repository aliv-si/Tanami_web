<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EscrowController extends Controller
{
    /**
     * Get all escrow transactions
     * GET /api/v1/admin/escrow
     */
    public function index(Request $request): JsonResponse
    {
        $query = Escrow::with([
            'pesanan:id_pesanan,id_pembeli,total_bayar,status_pesanan,tgl_dibuat',
            'pesanan.pembeli:id_pengguna,nama_lengkap',
            'penerima:id_pengguna,nama_lengkap',
        ])->orderByDesc('tgl_ditahan');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_escrow', $request->status);
        }

        // Filter by date range
        if ($request->filled('dari')) {
            $query->whereDate('tgl_ditahan', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tgl_ditahan', '<=', $request->sampai);
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $escrow = $query->paginate($perPage);

        // Transform data
        $escrow->getCollection()->transform(function ($item) {
            return $this->transformEscrow($item);
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar escrow berhasil diambil.',
            'data' => $escrow,
        ]);
    }

    /**
     * Get escrow detail
     * GET /api/v1/admin/escrow/{id}
     */
    public function show(int $id): JsonResponse
    {
        $escrow = Escrow::with([
            'pesanan.pembeli',
            'pesanan.items.produk',
            'pesanan.kota',
            'penerima',
        ])->find($id);

        if (!$escrow) {
            return response()->json([
                'success' => false,
                'message' => 'Escrow tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail escrow berhasil diambil.',
            'data' => $this->transformEscrow($escrow, true),
        ]);
    }

    /**
     * Get escrow statistics
     * GET /api/v1/admin/escrow/stats
     */
    public function stats(): JsonResponse
    {
        // Overall stats
        $totalDitahan = Escrow::ditahan()->sum('jumlah');
        $countDitahan = Escrow::ditahan()->count();

        $totalDikirim = Escrow::dikirimKePetani()->sum('jumlah');
        $countDikirim = Escrow::dikirimKePetani()->count();

        $totalRefund = Escrow::direfundKePembeli()->sum('jumlah');
        $countRefund = Escrow::direfundKePembeli()->count();

        // Monthly stats (current month)
        $bulanIni = [
            'ditahan' => Escrow::ditahan()
                ->whereMonth('tgl_ditahan', now()->month)
                ->whereYear('tgl_ditahan', now()->year)
                ->sum('jumlah'),
            'dikirim' => Escrow::dikirimKePetani()
                ->whereMonth('tgl_kirim', now()->month)
                ->whereYear('tgl_kirim', now()->year)
                ->sum('jumlah'),
            'refund' => Escrow::direfundKePembeli()
                ->whereMonth('tgl_kirim', now()->month)
                ->whereYear('tgl_kirim', now()->year)
                ->sum('jumlah'),
        ];

        // Average hold time for released escrows
        $avgHoldDays = Escrow::whereNotNull('tgl_kirim')
            ->whereNotNull('tgl_ditahan')
            ->selectRaw('AVG(DATEDIFF(tgl_kirim, tgl_ditahan)) as avg_days')
            ->value('avg_days');

        return response()->json([
            'success' => true,
            'message' => 'Statistik escrow berhasil diambil.',
            'data' => [
                'total' => [
                    'ditahan' => [
                        'jumlah' => (float) $totalDitahan,
                        'jumlah_formatted' => 'Rp ' . number_format((float) $totalDitahan, 0, ',', '.'),
                        'count' => $countDitahan,
                    ],
                    'dikirim_ke_petani' => [
                        'jumlah' => (float) $totalDikirim,
                        'jumlah_formatted' => 'Rp ' . number_format((float) $totalDikirim, 0, ',', '.'),
                        'count' => $countDikirim,
                    ],
                    'refund_ke_pembeli' => [
                        'jumlah' => (float) $totalRefund,
                        'jumlah_formatted' => 'Rp ' . number_format((float) $totalRefund, 0, ',', '.'),
                        'count' => $countRefund,
                    ],
                ],
                'bulan_ini' => [
                    'ditahan' => (float) $bulanIni['ditahan'],
                    'dikirim' => (float) $bulanIni['dikirim'],
                    'refund' => (float) $bulanIni['refund'],
                ],
                'rata_rata_hold_days' => round($avgHoldDays ?? 0, 1),
            ],
        ]);
    }

    /**
     * Transform escrow for response
     */
    private function transformEscrow(Escrow $escrow, bool $detailed = false): array
    {
        $data = [
            'id' => $escrow->id_escrow,
            'jumlah' => (float) $escrow->jumlah,
            'jumlah_formatted' => 'Rp ' . number_format((float) $escrow->jumlah, 0, ',', '.'),
            'status' => $escrow->status_escrow,
            'tgl_ditahan' => $escrow->tgl_ditahan?->toIso8601String(),
            'tgl_kirim' => $escrow->tgl_kirim?->toIso8601String(),
            'catatan' => $escrow->catatan,
            'pesanan' => $escrow->pesanan ? [
                'id' => $escrow->pesanan->id_pesanan,
                'total_bayar' => (float) $escrow->pesanan->total_bayar,
                'status' => $escrow->pesanan->status_pesanan,
                'pembeli' => $escrow->pesanan->pembeli?->nama_lengkap,
            ] : null,
            'penerima' => $escrow->penerima?->nama_lengkap,
        ];

        if ($detailed && $escrow->pesanan) {
            $data['pesanan']['tgl_dibuat'] = $escrow->pesanan->tgl_dibuat?->toIso8601String();
            $data['pesanan']['kota'] = $escrow->pesanan->kota?->nama_kota;
            $data['pesanan']['items'] = $escrow->pesanan->items->map(function ($item) {
                return [
                    'produk' => $item->produk?->nama_produk,
                    'jumlah' => $item->jumlah,
                    'subtotal' => (float) $item->subtotal,
                ];
            });
        }

        return $data;
    }
}
