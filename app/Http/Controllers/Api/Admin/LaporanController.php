<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemPesanan;
use App\Models\Pesanan;
use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Get sales report
     * GET /api/v1/admin/laporan/penjualan
     */
    public function penjualan(Request $request): JsonResponse
    {
        // Period filter (default: last 30 days)
        $dari = $request->input('dari', now()->subDays(30)->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));
        $groupBy = $request->input('group_by', 'day'); // day, week, month

        // Base query for completed orders
        $baseQuery = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);

        // Summary stats
        $totalPenjualan = (clone $baseQuery)->sum('total_bayar');
        $totalTransaksi = (clone $baseQuery)->count();
        $rataRataTransaksi = $totalTransaksi > 0 ? $totalPenjualan / $totalTransaksi : 0;

        // Group data by period
        $groupFormat = match ($groupBy) {
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            default => '%Y-%m-%d',
        };

        $chartData = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->selectRaw("DATE_FORMAT(tgl_selesai, '{$groupFormat}') as periode")
            ->selectRaw('SUM(total_bayar) as total_penjualan')
            ->selectRaw('COUNT(*) as jumlah_transaksi')
            ->groupBy('periode')
            ->orderBy('periode')
            ->get()
            ->map(function ($item) {
                return [
                    'periode' => $item->periode,
                    'total_penjualan' => (float) $item->total_penjualan,
                    'total_formatted' => 'Rp ' . number_format((float) $item->total_penjualan, 0, ',', '.'),
                    'jumlah_transaksi' => (int) $item->jumlah_transaksi,
                ];
            });

        // Status breakdown
        $statusBreakdown = Pesanan::whereBetween('tgl_dibuat', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->selectRaw('status_pesanan, COUNT(*) as total, SUM(total_bayar) as nilai')
            ->groupBy('status_pesanan')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->status_pesanan => [
                    'count' => (int) $item->total,
                    'nilai' => (float) $item->nilai,
                ]];
            });

        // Payment method / city breakdown
        $kotaBreakdown = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->with('kota:id_kota,nama_kota,provinsi')
            ->selectRaw('id_kota_tujuan, COUNT(*) as total, SUM(total_bayar) as nilai')
            ->groupBy('id_kota_tujuan')
            ->orderByDesc('nilai')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'kota' => $item->kota?->nama_kota,
                    'provinsi' => $item->kota?->provinsi,
                    'count' => (int) $item->total,
                    'nilai' => (float) $item->nilai,
                    'nilai_formatted' => 'Rp ' . number_format((float) $item->nilai, 0, ',', '.'),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Laporan penjualan berhasil diambil.',
            'data' => [
                'periode' => [
                    'dari' => $dari,
                    'sampai' => $sampai,
                ],
                'ringkasan' => [
                    'total_penjualan' => (float) $totalPenjualan,
                    'total_formatted' => 'Rp ' . number_format((float) $totalPenjualan, 0, ',', '.'),
                    'total_transaksi' => $totalTransaksi,
                    'rata_rata_transaksi' => (float) $rataRataTransaksi,
                    'rata_rata_formatted' => 'Rp ' . number_format((float) $rataRataTransaksi, 0, ',', '.'),
                ],
                'chart' => $chartData,
                'status_breakdown' => $statusBreakdown,
                'kota_teratas' => $kotaBreakdown,
            ],
        ]);
    }

    /**
     * Get best selling products
     * GET /api/v1/admin/laporan/produk
     */
    public function produkTerlaris(Request $request): JsonResponse
    {
        $dari = $request->input('dari', now()->subDays(30)->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));
        $limit = min((int) $request->input('limit', 20), 100);

        $produkTerlaris = ItemPesanan::select(
                'id_produk',
                DB::raw('SUM(jumlah) as total_terjual'),
                DB::raw('SUM(subtotal) as total_pendapatan'),
                DB::raw('COUNT(DISTINCT id_pesanan) as jumlah_transaksi')
            )
            ->whereHas('pesanan', function ($q) use ($dari, $sampai) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI)
                  ->whereBetween('tgl_selesai', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);
            })
            ->groupBy('id_produk')
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->with(['produk:id_produk,nama_produk,harga,foto,id_petani,id_kategori', 
                    'produk.petani:id_pengguna,nama_lengkap',
                    'produk.kategori:id_kategori,nama_kategori'])
            ->get()
            ->map(function ($item, $index) {
                return [
                    'rank' => $index + 1,
                    'produk' => $item->produk ? [
                        'id' => $item->produk->id_produk,
                        'nama' => $item->produk->nama_produk,
                        'harga' => (float) $item->produk->harga,
                        'foto' => $item->produk->foto ? asset('storage/produk/' . $item->produk->foto) : null,
                        'petani' => $item->produk->petani?->nama_lengkap,
                        'kategori' => $item->produk->kategori?->nama_kategori,
                    ] : null,
                    'total_terjual' => (int) $item->total_terjual,
                    'total_pendapatan' => (float) $item->total_pendapatan,
                    'pendapatan_formatted' => 'Rp ' . number_format((float) $item->total_pendapatan, 0, ',', '.'),
                    'jumlah_transaksi' => (int) $item->jumlah_transaksi,
                ];
            });

        // Category breakdown
        $kategoriBreakdown = ItemPesanan::join('produk', 'item_pesanan.id_produk', '=', 'produk.id_produk')
            ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
            ->whereHas('pesanan', function ($q) use ($dari, $sampai) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI)
                  ->whereBetween('tgl_selesai', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);
            })
            ->selectRaw('kategori.nama_kategori, SUM(item_pesanan.jumlah) as total_terjual, SUM(item_pesanan.subtotal) as total_pendapatan')
            ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
            ->orderByDesc('total_pendapatan')
            ->get()
            ->map(function ($item) {
                return [
                    'kategori' => $item->nama_kategori,
                    'total_terjual' => (int) $item->total_terjual,
                    'total_pendapatan' => (float) $item->total_pendapatan,
                    'pendapatan_formatted' => 'Rp ' . number_format((float) $item->total_pendapatan, 0, ',', '.'),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Laporan produk terlaris berhasil diambil.',
            'data' => [
                'periode' => [
                    'dari' => $dari,
                    'sampai' => $sampai,
                ],
                'produk_terlaris' => $produkTerlaris,
                'kategori_breakdown' => $kategoriBreakdown,
            ],
        ]);
    }

    /**
     * Get top farmers
     * GET /api/v1/admin/laporan/petani
     */
    public function petaniTerbaik(Request $request): JsonResponse
    {
        $dari = $request->input('dari', now()->subDays(30)->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));
        $limit = min((int) $request->input('limit', 20), 100);

        $petaniTerbaik = ItemPesanan::select(
                'id_petani',
                DB::raw('SUM(subtotal) as total_pendapatan'),
                DB::raw('SUM(jumlah) as total_item_terjual'),
                DB::raw('COUNT(DISTINCT id_pesanan) as jumlah_transaksi')
            )
            ->whereHas('pesanan', function ($q) use ($dari, $sampai) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI)
                  ->whereBetween('tgl_selesai', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);
            })
            ->groupBy('id_petani')
            ->orderByDesc('total_pendapatan')
            ->limit($limit)
            ->with('petani:id_pengguna,nama_lengkap,email,no_hp,tgl_daftar')
            ->get()
            ->map(function ($item, $index) {
                // Get product count and average rating for this farmer
                $produkCount = Produk::where('id_petani', $item->id_petani)->count();
                
                return [
                    'rank' => $index + 1,
                    'petani' => $item->petani ? [
                        'id' => $item->petani->id_pengguna,
                        'nama' => $item->petani->nama_lengkap,
                        'email' => $item->petani->email,
                        'no_hp' => $item->petani->no_hp,
                        'tgl_daftar' => $item->petani->tgl_daftar?->toIso8601String(),
                    ] : null,
                    'total_produk' => $produkCount,
                    'total_pendapatan' => (float) $item->total_pendapatan,
                    'pendapatan_formatted' => 'Rp ' . number_format((float) $item->total_pendapatan, 0, ',', '.'),
                    'total_item_terjual' => (int) $item->total_item_terjual,
                    'jumlah_transaksi' => (int) $item->jumlah_transaksi,
                ];
            });

        // New farmers this period
        $petaniBaru = Pengguna::where('role_pengguna', 'petani')
            ->whereBetween('tgl_daftar', [$dari . ' 00:00:00', $sampai . ' 23:59:59'])
            ->count();

        // Active farmers (has sales in period)
        $petaniAktif = ItemPesanan::whereHas('pesanan', function ($q) use ($dari, $sampai) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI)
                  ->whereBetween('tgl_selesai', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);
            })
            ->distinct('id_petani')
            ->count('id_petani');

        return response()->json([
            'success' => true,
            'message' => 'Laporan petani terbaik berhasil diambil.',
            'data' => [
                'periode' => [
                    'dari' => $dari,
                    'sampai' => $sampai,
                ],
                'ringkasan' => [
                    'petani_baru' => $petaniBaru,
                    'petani_aktif' => $petaniAktif,
                    'total_petani' => Pengguna::where('role_pengguna', 'petani')->count(),
                ],
                'petani_terbaik' => $petaniTerbaik,
            ],
        ]);
    }
}
