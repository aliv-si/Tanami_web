<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\ItemPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show petani dashboard with statistics
     */
    public function index(): View
    {
        $petaniId = Auth::id();

        // Get all product IDs for this petani
        $produkIds = Produk::where('id_petani', $petaniId)->pluck('id_produk');

        // ==================== STATS ====================

        // Total Products
        $totalProducts = Produk::where('id_petani', $petaniId)->count();

        // Active Orders (orders containing this petani's products with active status)
        $activeOrders = ItemPesanan::whereIn('id_produk', $produkIds)
            ->whereHas('pesanan', function ($q) {
                $q->whereIn('status_pesanan', [
                    Pesanan::STATUS_DIBAYAR,
                    Pesanan::STATUS_DIPROSES,
                    Pesanan::STATUS_DIKIRIM,
                    Pesanan::STATUS_TERKIRIM,
                ]);
            })
            ->distinct('id_pesanan')
            ->count('id_pesanan');

        // Total Sales (sum of subtotal from completed orders)
        $totalSales = ItemPesanan::whereIn('id_produk', $produkIds)
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI);
            })
            ->sum('subtotal');

        // Available Balance (escrow that has been sent to this petani)
        $availableBalance = Escrow::where('id_penerima', $petaniId)
            ->where('status_escrow', Escrow::STATUS_DIKIRIM_KE_PETANI)
            ->sum('jumlah');

        // Sales this month
        $salesThisMonth = ItemPesanan::whereIn('id_produk', $produkIds)
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI)
                    ->whereMonth('tgl_selesai', now()->month)
                    ->whereYear('tgl_selesai', now()->year);
            })
            ->sum('subtotal');

        // Sales last month (for growth calculation)
        $salesLastMonth = ItemPesanan::whereIn('id_produk', $produkIds)
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', Pesanan::STATUS_SELESAI)
                    ->whereMonth('tgl_selesai', now()->subMonth()->month)
                    ->whereYear('tgl_selesai', now()->subMonth()->year);
            })
            ->sum('subtotal');

        // Calculate growth percentage
        $salesGrowth = $salesLastMonth > 0
            ? round((($salesThisMonth - $salesLastMonth) / $salesLastMonth) * 100, 1)
            : 0;

        $stats = [
            'totalProducts' => $totalProducts,
            'productGrowth' => '+0%', // Could be calculated if needed
            'activeOrders' => $activeOrders,
            'totalSales' => $totalSales,
            'salesGrowth' => ($salesGrowth >= 0 ? '+' : '') . $salesGrowth . '%',
            'availableBalance' => $availableBalance,
        ];

        // ==================== RECENT ORDERS ====================

        $recentOrders = ItemPesanan::with(['pesanan.pembeli', 'produk'])
            ->whereIn('id_produk', $produkIds)
            ->whereHas('pesanan')
            ->orderBy('tgl_dibuat', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->pesanan->id_pesanan,
                    'product' => $item->produk->nama_produk ?? 'Produk tidak ditemukan',
                    'amount' => $item->subtotal,
                    'status' => ucfirst(str_replace('_', ' ', $item->pesanan->status_pesanan)),
                    'date' => $item->pesanan->tgl_dibuat->format('d M Y'),
                ];
            });

        // ==================== RATING ====================

        // Get average rating for all products
        $ratingData = Ulasan::whereIn('id_produk', $produkIds)
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
            ->first();

        $rating = [
            'score' => $ratingData->avg_rating ? round($ratingData->avg_rating, 1) : 0,
            'totalReviews' => $ratingData->total_reviews ?? 0,
            'productQuality' => $ratingData->avg_rating ? ($ratingData->avg_rating / 5) * 100 : 0,
            'deliverySpeed' => 80, // Placeholder - could be calculated from order processing time
        ];

        return view('petani.dashboard', compact('stats', 'recentOrders', 'rating'));
    }
}
