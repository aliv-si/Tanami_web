<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Escrow;
use App\Models\Pengguna;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with statistics
     */
    public function index(): View
    {
        // User Statistics
        $userStats = [
            'total_pembeli' => Pengguna::where('role_pengguna', 'pembeli')->count(),
            'total_petani' => Pengguna::where('role_pengguna', 'petani')->count(),
            'petani_verified' => Pengguna::where('role_pengguna', 'petani')->where('is_verified', true)->count(),
            'petani_pending' => Pengguna::where('role_pengguna', 'petani')->where('is_verified', false)->count(),
        ];

        // Transaction Statistics
        $transactionStats = [
            'total_pesanan' => Pesanan::count(),
            'pesanan_pending' => Pesanan::where('status_pesanan', Pesanan::STATUS_PENDING)->count(),
            'pesanan_menunggu_verifikasi' => Pesanan::where('status_pesanan', Pesanan::STATUS_MENUNGGU_VERIFIKASI)->count(),
            'pesanan_diproses' => Pesanan::whereIn('status_pesanan', [
                Pesanan::STATUS_DIBAYAR,
                Pesanan::STATUS_DIPROSES,
                Pesanan::STATUS_DIKIRIM,
            ])->count(),
            'pesanan_selesai' => Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)->count(),
            'pesanan_dibatalkan' => Pesanan::where('status_pesanan', Pesanan::STATUS_DIBATALKAN)->count(),
            'pesanan_minta_refund' => Pesanan::where('status_pesanan', Pesanan::STATUS_MINTA_REFUND)->count(),
        ];

        // Financial Statistics (GMV = Gross Merchandise Value)
        $financialStats = [
            'gmv_total' => Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)->sum('total_bayar'),
            'gmv_bulan_ini' => Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
                ->whereMonth('tgl_selesai', now()->month)
                ->whereYear('tgl_selesai', now()->year)
                ->sum('total_bayar'),
            'escrow_ditahan' => Escrow::where('status_escrow', Escrow::STATUS_DITAHAN)->sum('jumlah'),
            'escrow_dikirim' => Escrow::where('status_escrow', Escrow::STATUS_DIKIRIM_KE_PETANI)->sum('jumlah'),
            'escrow_direfund' => Escrow::where('status_escrow', Escrow::STATUS_DIREFUND_KE_PEMBELI)->sum('jumlah'),
        ];

        // Product Statistics
        $productStats = [
            'total_produk' => Produk::count(),
            'produk_aktif' => Produk::where('is_aktif', true)->count(),
            'produk_stok_habis' => Produk::whereRaw('stok <= stok_direserve')->count(),
        ];

        // Recent Orders (last 10)
        $recentOrders = Pesanan::with(['pembeli:id_pengguna,nama_lengkap', 'kota:id_kota,nama_kota'])
            ->orderBy('tgl_dibuat', 'desc')
            ->limit(10)
            ->get();

        // Pending Petani Verification (last 5)
        $pendingPetani = Pengguna::where('role_pengguna', 'petani')
            ->where('is_verified', false)
            ->orderBy('tgl_daftar', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'userStats' => $userStats,
            'transactionStats' => $transactionStats,
            'financialStats' => $financialStats,
            'productStats' => $productStats,
            'recentOrders' => $recentOrders,
            'pendingPetani' => $pendingPetani,
        ]);
    }
}
