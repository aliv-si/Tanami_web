<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\ItemPesanan;
use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get admin dashboard data
     * GET /api/v1/admin/dashboard
     */
    public function index(Request $request): JsonResponse
    {
        // === GMV (Gross Merchandise Value) ===
        $gmvTotal = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->sum('total_bayar');

        $gmvBulanIni = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereMonth('tgl_selesai', now()->month)
            ->whereYear('tgl_selesai', now()->year)
            ->sum('total_bayar');

        $gmvBulanLalu = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereMonth('tgl_selesai', now()->subMonth()->month)
            ->whereYear('tgl_selesai', now()->subMonth()->year)
            ->sum('total_bayar');

        // === Transaction Statistics ===
        $totalTransaksi = Pesanan::whereNotIn('status_pesanan', [
            Pesanan::STATUS_PENDING,
            Pesanan::STATUS_DIBATALKAN,
        ])->count();

        $transaksiHariIni = Pesanan::whereDate('tgl_dibuat', today())->count();

        $transaksiBulanIni = Pesanan::whereMonth('tgl_dibuat', now()->month)
            ->whereYear('tgl_dibuat', now()->year)
            ->count();

        // By status
        $statusCounts = Pesanan::select('status_pesanan', DB::raw('COUNT(*) as total'))
            ->groupBy('status_pesanan')
            ->pluck('total', 'status_pesanan');

        // === User Statistics ===
        $totalPembeli = Pengguna::where('role_pengguna', 'pembeli')->count();
        $totalPetani = Pengguna::where('role_pengguna', 'petani')->count();
        $petaniTerverifikasi = Pengguna::where('role_pengguna', 'petani')
            ->where('is_verified', true)->count();
        $petaniPendingVerifikasi = Pengguna::where('role_pengguna', 'petani')
            ->where('is_verified', false)->count();

        $penggunaBaru = Pengguna::whereMonth('tgl_daftar', now()->month)
            ->whereYear('tgl_daftar', now()->year)
            ->count();

        // === Product Statistics ===
        $totalProduk = Produk::count();
        $produkAktif = Produk::aktif()->count();

        // === Escrow Statistics ===
        $escrowDitahan = Escrow::ditahan()->sum('jumlah');
        $escrowDikirim = Escrow::dikirimKePetani()->sum('jumlah');
        $escrowRefund = Escrow::direfundKePembeli()->sum('jumlah');

        // === Pending Actions ===
        $pesananMenungguVerifikasi = Pesanan::where('status_pesanan', Pesanan::STATUS_MENUNGGU_VERIFIKASI)->count();
        $pesananMintaRefund = Pesanan::where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)->count();

        // === Recent Orders ===
        $pesananTerbaru = Pesanan::with(['pembeli:id_pengguna,nama_lengkap'])
            ->orderByDesc('tgl_dibuat')
            ->limit(10)
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

        // === Top Products (This Month) ===
        $produkTerlaris = ItemPesanan::select('id_produk', DB::raw('SUM(jumlah) as total_terjual'))
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI)
                    ->whereMonth('tgl_selesai', now()->month)
                    ->whereYear('tgl_selesai', now()->year);
            })
            ->groupBy('id_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->with('produk:id_produk,nama_produk')
            ->get()
            ->map(function ($item) {
                return [
                    'produk' => $item->produk?->nama_produk,
                    'total_terjual' => (int) $item->total_terjual,
                ];
            });

        // === Top Farmers (By Revenue) ===
        $petaniTerbaik = ItemPesanan::select('id_petani', DB::raw('SUM(subtotal) as total_pendapatan'))
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI);
            })
            ->groupBy('id_petani')
            ->orderByDesc('total_pendapatan')
            ->limit(5)
            ->with('petani:id_pengguna,nama_lengkap')
            ->get()
            ->map(function ($item) {
                return [
                    'petani' => $item->petani?->nama_lengkap,
                    'total_pendapatan' => (float) $item->total_pendapatan,
                    'total_formatted' => 'Rp ' . number_format((float) $item->total_pendapatan, 0, ',', '.'),
                ];
            });

        // === Monthly Revenue Chart Data (Last 6 months) ===
        $chartPendapatan = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereMonth('tgl_selesai', $date->month)
                ->whereYear('tgl_selesai', $date->year)
                ->sum('total_bayar');

            $chartPendapatan->push([
                'bulan' => $date->format('M Y'),
                'pendapatan' => (float) $revenue,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data berhasil diambil.',
            'data' => [
                'gmv' => [
                    'total' => (float) $gmvTotal,
                    'total_formatted' => 'Rp ' . number_format((float) $gmvTotal, 0, ',', '.'),
                    'bulan_ini' => (float) $gmvBulanIni,
                    'bulan_ini_formatted' => 'Rp ' . number_format((float) $gmvBulanIni, 0, ',', '.'),
                    'bulan_lalu' => (float) $gmvBulanLalu,
                    'pertumbuhan' => $gmvBulanLalu > 0 
                        ? round((($gmvBulanIni - $gmvBulanLalu) / $gmvBulanLalu) * 100, 1) 
                        : 0,
                ],
                'transaksi' => [
                    'total' => $totalTransaksi,
                    'hari_ini' => $transaksiHariIni,
                    'bulan_ini' => $transaksiBulanIni,
                    'by_status' => $statusCounts,
                ],
                'pengguna' => [
                    'total_pembeli' => $totalPembeli,
                    'total_petani' => $totalPetani,
                    'petani_terverifikasi' => $petaniTerverifikasi,
                    'petani_pending' => $petaniPendingVerifikasi,
                    'baru_bulan_ini' => $penggunaBaru,
                ],
                'produk' => [
                    'total' => $totalProduk,
                    'aktif' => $produkAktif,
                ],
                'escrow' => [
                    'ditahan' => (float) $escrowDitahan,
                    'ditahan_formatted' => 'Rp ' . number_format((float) $escrowDitahan, 0, ',', '.'),
                    'dikirim' => (float) $escrowDikirim,
                    'refund' => (float) $escrowRefund,
                ],
                'pending_actions' => [
                    'menunggu_verifikasi' => $pesananMenungguVerifikasi,
                    'minta_refund' => $pesananMintaRefund,
                ],
                'pesanan_terbaru' => $pesananTerbaru,
                'produk_terlaris' => $produkTerlaris,
                'petani_terbaik' => $petaniTerbaik,
                'chart_pendapatan' => $chartPendapatan,
            ],
        ]);
    }
}
