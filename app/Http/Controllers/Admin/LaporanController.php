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
     * Laporan Penjualan - Enhanced with more metrics
     */
    private function getLaporanPenjualan(string $dari, string $sampai): array
    {
        // Calculate previous period for comparison
        $dariDate = \Carbon\Carbon::parse($dari);
        $sampaiDate = \Carbon\Carbon::parse($sampai);
        $periodDays = $dariDate->diffInDays($sampaiDate) + 1;
        $prevDari = $dariDate->copy()->subDays($periodDays)->toDateString();
        $prevSampai = $dariDate->copy()->subDay()->toDateString();

        // Current period summary
        $totalPesanan = Pesanan::whereBetween('tgl_dibuat', [$dari, $sampai])->count();
        $pesananSelesai = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])->count();
        $pesananDibatalkan = Pesanan::where('status_pesanan', Pesanan::STATUS_DIBATALKAN)
            ->whereBetween('tgl_dibatalkan', [$dari, $sampai])->count();
        $gmv = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])->sum('total_bayar');
        $totalOngkir = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])->sum('ongkir');
        $totalDiskon = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])->sum('diskon');

        // Previous period GMV for growth calculation
        $prevGmv = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$prevDari, $prevSampai])->sum('total_bayar');
        $prevPesanan = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$prevDari, $prevSampai])->count();

        // Calculate derived metrics
        $conversionRate = $totalPesanan > 0 ? round(($pesananSelesai / $totalPesanan) * 100, 1) : 0;
        $aov = $pesananSelesai > 0 ? round($gmv / $pesananSelesai) : 0;
        $gmvGrowth = $prevGmv > 0 ? round((($gmv - $prevGmv) / $prevGmv) * 100, 1) : ($gmv > 0 ? 100 : 0);
        $pesananGrowth = $prevPesanan > 0 ? round((($pesananSelesai - $prevPesanan) / $prevPesanan) * 100, 1) : ($pesananSelesai > 0 ? 100 : 0);
        $netRevenue = $gmv - $totalOngkir;

        $summary = [
            'total_pesanan' => $totalPesanan,
            'pesanan_selesai' => $pesananSelesai,
            'pesanan_dibatalkan' => $pesananDibatalkan,
            'pesanan_pending' => $totalPesanan - $pesananSelesai - $pesananDibatalkan,
            'gmv' => $gmv,
            'net_revenue' => $netRevenue,
            'total_ongkir' => $totalOngkir,
            'total_diskon' => $totalDiskon,
            'conversion_rate' => $conversionRate,
            'aov' => $aov,
            'gmv_growth' => $gmvGrowth,
            'pesanan_growth' => $pesananGrowth,
            'prev_gmv' => $prevGmv,
            'prev_pesanan' => $prevPesanan,
        ];

        // Daily breakdown with more details
        $daily = Pesanan::select(
            DB::raw('DATE(tgl_dibuat) as tanggal'),
            DB::raw('COUNT(*) as jumlah_pesanan'),
            DB::raw('SUM(CASE WHEN status_pesanan = "selesai" THEN 1 ELSE 0 END) as pesanan_selesai'),
            DB::raw('SUM(CASE WHEN status_pesanan = "selesai" THEN total_bayar ELSE 0 END) as total_penjualan'),
            DB::raw('SUM(CASE WHEN status_pesanan = "dibatalkan" THEN 1 ELSE 0 END) as pesanan_batal')
        )
            ->whereBetween('tgl_dibuat', [$dari, $sampai])
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc') // Changed to ASC for chart display
            ->get();

        return [
            'summary' => $summary,
            'daily' => $daily,
        ];
    }

    /**
     * Laporan Produk Terlaris - Enhanced with summary & ratings
     */
    private function getLaporanProduk(string $dari, string $sampai): array
    {
        // Summary stats
        $summary = [
            'total_produk_terjual' => DB::table('item_pesanan')
                ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
                ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
                ->sum('item_pesanan.jumlah'),
            'total_pendapatan' => DB::table('item_pesanan')
                ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
                ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
                ->sum('item_pesanan.subtotal'),
            'unique_produk' => DB::table('item_pesanan')
                ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
                ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
                ->distinct('item_pesanan.id_produk')
                ->count('item_pesanan.id_produk'),
        ];

        // Top selling products with rating
        $topProducts = DB::table('item_pesanan')
            ->join('produk', 'item_pesanan.id_produk', '=', 'produk.id_produk')
            ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
            ->leftJoin('ulasan', 'produk.id_produk', '=', 'ulasan.id_produk')
            ->select(
                'produk.id_produk',
                'produk.nama_produk',
                'kategori.nama_kategori',
                DB::raw('SUM(item_pesanan.jumlah) as total_terjual'),
                DB::raw('SUM(item_pesanan.subtotal) as total_pendapatan'),
                DB::raw('COUNT(DISTINCT item_pesanan.id_pesanan) as jumlah_pesanan'),
                DB::raw('ROUND(AVG(ulasan.rating), 1) as avg_rating'),
                DB::raw('COUNT(DISTINCT ulasan.id_ulasan) as jumlah_ulasan')
            )
            ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
            ->groupBy('produk.id_produk', 'produk.nama_produk', 'kategori.nama_kategori')
            ->orderByDesc('total_terjual')
            ->limit(20)
            ->get();

        // Category breakdown with percentage
        $categoryBreakdown = DB::table('item_pesanan')
            ->join('produk', 'item_pesanan.id_produk', '=', 'produk.id_produk')
            ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
            ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->select(
                'kategori.nama_kategori',
                DB::raw('SUM(item_pesanan.jumlah) as total_terjual'),
                DB::raw('SUM(item_pesanan.subtotal) as total_pendapatan'),
                DB::raw('COUNT(DISTINCT item_pesanan.id_produk) as jumlah_produk')
            )
            ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
            ->groupBy('kategori.nama_kategori')
            ->orderByDesc('total_pendapatan')
            ->get();

        // Calculate percentage for each category
        $totalPendapatan = $categoryBreakdown->sum('total_pendapatan');
        $categoryBreakdown = $categoryBreakdown->map(function ($item) use ($totalPendapatan) {
            $item->persentase = $totalPendapatan > 0
                ? round(($item->total_pendapatan / $totalPendapatan) * 100, 1)
                : 0;
            return $item;
        });

        return [
            'summary' => $summary,
            'topProducts' => $topProducts,
            'categoryBreakdown' => $categoryBreakdown,
        ];
    }

    /**
     * Laporan Petani - Enhanced with summary & rating
     */
    private function getLaporanPetani(string $dari, string $sampai): array
    {
        // Summary stats
        $totalPetani = Pengguna::where('role_pengguna', 'petani')->where('is_verified', true)->count();
        $activePetani = DB::table('item_pesanan')
            ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
            ->distinct('item_pesanan.id_petani')
            ->count('item_pesanan.id_petani');

        $summary = [
            'total_petani' => $totalPetani,
            'petani_aktif' => $activePetani,
            'persentase_aktif' => $totalPetani > 0 ? round(($activePetani / $totalPetani) * 100, 1) : 0,
        ];

        // Top petani by sales with rating
        $topPetani = DB::table('item_pesanan')
            ->join('pengguna', 'item_pesanan.id_petani', '=', 'pengguna.id_pengguna')
            ->join('pesanan', 'item_pesanan.id_pesanan', '=', 'pesanan.id_pesanan')
            ->leftJoin('produk', 'item_pesanan.id_produk', '=', 'produk.id_produk')
            ->leftJoin('ulasan', 'produk.id_produk', '=', 'ulasan.id_produk')
            ->select(
                'pengguna.id_pengguna',
                'pengguna.nama_lengkap',
                'pengguna.email',
                DB::raw('COUNT(DISTINCT item_pesanan.id_pesanan) as jumlah_pesanan'),
                DB::raw('SUM(item_pesanan.subtotal) as total_penjualan'),
                DB::raw('COUNT(DISTINCT item_pesanan.id_produk) as jumlah_produk_terjual'),
                DB::raw('ROUND(AVG(ulasan.rating), 1) as avg_rating')
            )
            ->where('pesanan.status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('pesanan.tgl_selesai', [$dari, $sampai])
            ->groupBy('pengguna.id_pengguna', 'pengguna.nama_lengkap', 'pengguna.email')
            ->orderByDesc('total_penjualan')
            ->limit(20)
            ->get();

        // Escrow summary with more details
        $escrowSummary = [
            'total_dikirim' => Escrow::where('status_escrow', Escrow::STATUS_DIKIRIM_KE_PETANI)
                ->whereBetween('tgl_kirim', [$dari, $sampai])->sum('jumlah'),
            'total_transaksi' => Escrow::where('status_escrow', Escrow::STATUS_DIKIRIM_KE_PETANI)
                ->whereBetween('tgl_kirim', [$dari, $sampai])->count(),
            'escrow_ditahan' => Escrow::where('status_escrow', Escrow::STATUS_DITAHAN)->sum('jumlah'),
            'escrow_pending_count' => Escrow::where('status_escrow', Escrow::STATUS_DITAHAN)->count(),
        ];

        // echo "<pre>";
        // print_r($escrowSummary);
        // die;

        return [
            'summary' => $summary,
            'topPetani' => $topPetani,
            'escrowSummary' => $escrowSummary,
        ];
    }

    /**
     * Laporan Pembeli - Enhanced with retention metrics
     */
    private function getLaporanPembeli(string $dari, string $sampai): array
    {
        // New users
        $newPembeli = Pengguna::where('role_pengguna', 'pembeli')
            ->whereBetween('tgl_daftar', [$dari, $sampai])->count();
        $newPetani = Pengguna::where('role_pengguna', 'petani')
            ->whereBetween('tgl_daftar', [$dari, $sampai])->count();

        $newUsers = [
            'pembeli' => $newPembeli,
            'petani' => $newPetani,
            'total' => $newPembeli + $newPetani,
        ];

        // Unique buyers in period
        $uniqueBuyers = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])
            ->distinct('id_pembeli')
            ->count('id_pembeli');

        // Repeat buyers (more than 1 order)
        $repeatBuyersCount = Pesanan::select('id_pembeli', DB::raw('COUNT(*) as jumlah'))
            ->where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])
            ->groupBy('id_pembeli')
            ->having('jumlah', '>', 1)
            ->get()
            ->count();

        $retention = [
            'unique_buyers' => $uniqueBuyers,
            'repeat_buyers' => $repeatBuyersCount,
            'repeat_rate' => $uniqueBuyers > 0 ? round(($repeatBuyersCount / $uniqueBuyers) * 100, 1) : 0,
            'first_time_buyers' => $uniqueBuyers - $repeatBuyersCount,
        ];

        // Top buyers with AOV
        $topBuyers = Pesanan::select(
            'id_pembeli',
            DB::raw('COUNT(*) as jumlah_pesanan'),
            DB::raw('SUM(total_bayar) as total_belanja'),
            DB::raw('ROUND(AVG(total_bayar)) as avg_order_value')
        )
            ->with('pembeli:id_pengguna,nama_lengkap,email')
            ->where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->whereBetween('tgl_selesai', [$dari, $sampai])
            ->groupBy('id_pembeli')
            ->orderByDesc('total_belanja')
            ->limit(20)
            ->get();

        return [
            'newUsers' => $newUsers,
            'retention' => $retention,
            'topBuyers' => $topBuyers,
        ];
    }
}
