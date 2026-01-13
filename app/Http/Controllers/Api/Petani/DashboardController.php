<?php

namespace App\Http\Controllers\Api\Petani;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\ItemPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get farmer dashboard data
     * GET /api/v1/petani/dashboard
     */
    public function index(Request $request): JsonResponse
    {
        $petaniId = Auth::id();

        // Product statistics
        $totalProduk = Produk::where('id_petani', $petaniId)->count();
        $produkAktif = Produk::where('id_petani', $petaniId)->aktif()->count();
        $produkTersedia = Produk::where('id_petani', $petaniId)->tersedia()->count();

        // Order statistics - get orders where petani has items
        $pesananQuery = Pesanan::whereHas('items', function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId);
        });

        $totalPesanan = (clone $pesananQuery)->count();
        $pesananMenunggu = (clone $pesananQuery)
            ->where('status_pesanan', Pesanan::STATUS_MENUNGGU_VERIFIKASI)
            ->count();
        $pesananDiproses = (clone $pesananQuery)
            ->whereIn('status_pesanan', [
                Pesanan::STATUS_DIBAYAR,
                Pesanan::STATUS_DIPROSES,
                Pesanan::STATUS_DIKIRIM,
            ])
            ->count();
        $pesananSelesai = (clone $pesananQuery)
            ->where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->count();

        // Revenue statistics
        $pendapatanQuery = ItemPesanan::where('id_petani', $petaniId)
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI);
            });
        
        $totalPendapatan = (clone $pendapatanQuery)->sum('subtotal');
        
        // Monthly revenue (current month)
        $pendapatanBulanIni = (clone $pendapatanQuery)
            ->whereHas('pesanan', function ($q) {
                $q->whereMonth('tgl_selesai', now()->month)
                  ->whereYear('tgl_selesai', now()->year);
            })
            ->sum('subtotal');

        // Escrow statistics
        $escrowDitahan = Escrow::whereHas('pesanan.items', function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId);
        })->ditahan()->sum('jumlah');

        $escrowDikirim = Escrow::where('id_penerima', $petaniId)
            ->dikirimKePetani()
            ->sum('jumlah');

        // Rating statistics
        $ratingStats = Ulasan::whereHas('produk', function ($q) use ($petaniId) {
            $q->where('id_petani', $petaniId);
        });
        
        $rataRating = round($ratingStats->avg('rating') ?? 0, 1);
        $totalUlasan = $ratingStats->count();

        // Top products (by sales)
        $produkTerlaris = ItemPesanan::select('id_produk', DB::raw('SUM(jumlah) as total_terjual'))
            ->where('id_petani', $petaniId)
            ->whereHas('pesanan', function ($q) {
                $q->whereNotIn('status_pesanan', [
                    Pesanan::STATUS_DIBATALKAN,
                    Pesanan::STATUS_DIREFUND,
                ]);
            })
            ->groupBy('id_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->with('produk:id_produk,nama_produk,foto')
            ->get()
            ->map(function ($item) {
                return [
                    'produk' => $item->produk ? [
                        'id' => $item->produk->id_produk,
                        'nama' => $item->produk->nama_produk,
                        'foto' => $item->produk->foto ? asset('storage/produk/' . $item->produk->foto) : null,
                    ] : null,
                    'total_terjual' => (int) $item->total_terjual,
                ];
            });

        // Recent orders needing attention
        $pesananTerbaru = Pesanan::with(['pembeli:id_pengguna,nama_lengkap', 'kota'])
            ->whereHas('items', function ($q) use ($petaniId) {
                $q->where('id_petani', $petaniId);
            })
            ->whereIn('status_pesanan', [
                Pesanan::STATUS_MENUNGGU_VERIFIKASI,
                Pesanan::STATUS_DIBAYAR,
                Pesanan::STATUS_DIPROSES,
            ])
            ->orderByDesc('tgl_dibuat')
            ->limit(5)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id_pesanan,
                    'pembeli' => $p->pembeli?->nama_lengkap,
                    'total' => (float) $p->total_bayar,
                    'status' => $p->status_pesanan,
                    'tgl_dibuat' => $p->tgl_dibuat?->toIso8601String(),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data berhasil diambil.',
            'data' => [
                'produk' => [
                    'total' => $totalProduk,
                    'aktif' => $produkAktif,
                    'tersedia' => $produkTersedia,
                ],
                'pesanan' => [
                    'total' => $totalPesanan,
                    'menunggu_verifikasi' => $pesananMenunggu,
                    'diproses' => $pesananDiproses,
                    'selesai' => $pesananSelesai,
                ],
                'pendapatan' => [
                    'total' => (float) $totalPendapatan,
                    'total_formatted' => 'Rp ' . number_format((float) $totalPendapatan, 0, ',', '.'),
                    'bulan_ini' => (float) $pendapatanBulanIni,
                    'bulan_ini_formatted' => 'Rp ' . number_format((float) $pendapatanBulanIni, 0, ',', '.'),
                ],
                'escrow' => [
                    'ditahan' => (float) $escrowDitahan,
                    'ditahan_formatted' => 'Rp ' . number_format((float) $escrowDitahan, 0, ',', '.'),
                    'diterima' => (float) $escrowDikirim,
                    'diterima_formatted' => 'Rp ' . number_format((float) $escrowDikirim, 0, ',', '.'),
                ],
                'rating' => [
                    'rata_rata' => $rataRating,
                    'total_ulasan' => $totalUlasan,
                ],
                'produk_terlaris' => $produkTerlaris,
                'pesanan_terbaru' => $pesananTerbaru,
            ],
        ]);
    }
}
