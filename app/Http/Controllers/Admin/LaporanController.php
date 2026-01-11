<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\Pesanan;
use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Show reports page with filters
     */
    public function index(Request $request): View
    {
        // Date range (default: this month)
        $dari = $request->input('dari', now()->startOfMonth()->toDateString());
        $sampai = $request->input('sampai', now()->toDateString());

        // Tipe laporan
        $tipe = $request->input('tipe', 'penjualan');

        $data = match ($tipe) {
            'penjualan' => $this->getLaporanPenjualan($dari, $sampai),
            'produk' => $this->getLaporanProduk($dari, $sampai),
            'petani' => $this->getLaporanPetani($dari, $sampai),
            'pembeli' => $this->getLaporanPembeli($dari, $sampai),
            default => $this->getLaporanPenjualan($dari, $sampai),
        };

        return view('admin.laporan', [
            'data' => $data,
            'dari' => $dari,
            'sampai' => $sampai,
            'tipe' => $tipe,
        ]);
    }

    /**
     * Laporan Penjualan
     */
    private function getLaporanPenjualan(string $dari, string $sampai): array
    {
        // Summary
        $summary = [
            'total_pesanan' => Pesanan::whereBetween('tgl_dibuat', [$dari, $sampai])->count(),
            'pesanan_selesai' => Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereBetween('tgl_selesai', [$dari, $sampai])->count(),
            'pesanan_dibatalkan' => Pesanan::where('status_pesanan', Pesanan::STATUS_DIBATALKAN)
                ->whereBetween('tgl_dibatalkan', [$dari, $sampai])->count(),
            'gmv' => Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereBetween('tgl_selesai', [$dari, $sampai])->sum('total_bayar'),
            'total_ongkir' => Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereBetween('tgl_selesai', [$dari, $sampai])->sum('ongkir'),
            'total_diskon' => Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereBetween('tgl_selesai', [$dari, $sampai])->sum('diskon'),
        ];

        // Daily breakdown
        $daily = Pesanan::select(
            DB::raw('DATE(tgl_dibuat) as tanggal'),
            DB::raw('COUNT(*) as jumlah_pesanan'),
            DB::raw('SUM(CASE WHEN status_pesanan = "selesai" THEN total_bayar ELSE 0 END) as total_penjualan')
        )
            ->whereBetween('tgl_dibuat', [$dari, $sampai])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return [
            'summary' => $summary,
            'daily' => $daily,
        ];
    }

    /**
     * Laporan Produk Terlaris
     */
    private function getLaporanProduk(string $dari, string $sampai): array
    {
        // Top selling products
        $topProducts = DB::table('item_pesanan')
            ->join('produk', 'item_pesanan.id_produk', '=', 'produk.id_produk')
            ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
            ->select(
                'produk.id_produk',
                'produk.nama_produk',
                'kategori.nama_kategori',
                DB::raw('SUM(item_pesanan.jumlah) as total_terjual'),
                DB::raw('SUM(item_pesanan.subtotal) as total_pendapatan'),
                DB::raw('COUNT(DISTINCT item_pesanan.id_pesanan) as jumlah_pesanan')
            )
            ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
            ->groupBy('produk.id_produk', 'produk.nama_produk', 'kategori.nama_kategori')
            ->orderByDesc('total_terjual')
            ->limit(20)
            ->get();

        // Category breakdown
        $categoryBreakdown = DB::table('item_pesanan')
            ->join('produk', 'item_pesanan.id_produk', '=', 'produk.id_produk')
            ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
            ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->select(
                'kategori.nama_kategori',
                DB::raw('SUM(item_pesanan.jumlah) as total_terjual'),
                DB::raw('SUM(item_pesanan.subtotal) as total_pendapatan')
            )
            ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
            ->groupBy('kategori.nama_kategori')
            ->orderByDesc('total_pendapatan')
            ->get();

        return [
            'topProducts' => $topProducts,
            'categoryBreakdown' => $categoryBreakdown,
        ];
    }

    /**
     * Laporan Petani
     */
    private function getLaporanPetani(string $dari, string $sampai): array
    {
        // Top petani by sales
        $topPetani = DB::table('item_pesanan')
            ->join('pengguna', 'item_pesanan.id_petani', '=', 'pengguna.id_pengguna')
            ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->select(
                'pengguna.id_pengguna',
                'pengguna.nama_lengkap',
                DB::raw('COUNT(DISTINCT item_pesanan.id_pesanan) as jumlah_pesanan'),
                DB::raw('SUM(item_pesanan.subtotal) as total_penjualan'),
                DB::raw('COUNT(DISTINCT item_pesanan.id_produk) as jumlah_produk_terjual')
            )
            ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
            ->groupBy('pengguna.id_pengguna', 'pengguna.nama_lengkap')
            ->orderByDesc('total_penjualan')
            ->limit(20)
            ->get();

        // Escrow summary for petani
        $escrowSummary = [
            'total_dikirim' => Escrow::where('status_escrow', Escrow::STATUS_DIKIRIM_KE_PETANI)
                ->whereBetween('tgl_kirim', [$dari, $sampai])->sum('jumlah'),
            'total_transaksi' => Escrow::where('status_escrow', Escrow::STATUS_DIKIRIM_KE_PETANI)
                ->whereBetween('tgl_kirim', [$dari, $sampai])->count(),
        ];

        return [
            'topPetani' => $topPetani,
            'escrowSummary' => $escrowSummary,
        ];
    }

    /**
     * Laporan Pembeli
     */
    private function getLaporanPembeli(string $dari, string $sampai): array
    {
        // New users
        $newUsers = [
            'pembeli' => Pengguna::where('role_pengguna', 'pembeli')
                ->whereBetween('tgl_daftar', [$dari, $sampai])->count(),
            'petani' => Pengguna::where('role_pengguna', 'petani')
                ->whereBetween('tgl_daftar', [$dari, $sampai])->count(),
        ];

        // Top buyers
        $topBuyers = Pesanan::select(
            'id_pembeli',
            DB::raw('COUNT(*) as jumlah_pesanan'),
            DB::raw('SUM(total_bayar) as total_belanja')
        )
            ->with('pembeli:id_pengguna,nama_lengkap,email')
            ->where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])
            ->groupBy('id_pembeli')
            ->orderByDesc('total_belanja')
            ->limit(20)
            ->get();

        // Repeat buyers (more than 1 order)
        $repeatBuyers = Pesanan::select('id_pembeli', DB::raw('COUNT(*) as jumlah'))
            ->where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])
            ->groupBy('id_pembeli')
            ->having('jumlah', '>', 1)
            ->count();

        return [
            'newUsers' => $newUsers,
            'topBuyers' => $topBuyers,
            'repeatBuyers' => $repeatBuyers,
        ];
    }
}
