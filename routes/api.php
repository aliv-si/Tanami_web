<?php

use App\Http\Controllers\Api\Admin\EscrowController;
use App\Http\Controllers\Api\Admin\LaporanController;
use App\Http\Controllers\Api\Admin\PenggunaController;
use App\Http\Controllers\Api\Admin\RefundController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\KeranjangController;
use App\Http\Controllers\Api\KotaController;
use App\Http\Controllers\Api\KuponController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\Petani\DashboardController;
use App\Http\Controllers\Api\Petani\RekeningController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\UlasanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - TANAMI E-Commerce v2.0
|--------------------------------------------------------------------------
|
| Di sini didefinisikan semua API routes untuk aplikasi TANAMI.
| Routes ini di-load oleh RouteServiceProvider dan akan mendapat
| prefix "api" secara otomatis.
|
*/

// ============================================================================
// PUBLIC ROUTES (Tidak perlu authentication)
// ============================================================================

Route::prefix('v1')->group(function () {

    // --------------------- AUTH ---------------------
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    });

    // --------------------- PRODUK (PUBLIC) ---------------------
    Route::get('/produk', [ProdukController::class, 'index']);
    Route::get('/produk/{slug}', [ProdukController::class, 'show']);
    Route::get('/produk/{id}/ulasan', [UlasanController::class, 'indexByProduk']);

    // --------------------- KATEGORI ---------------------
    Route::get('/kategori', [KategoriController::class, 'index']);
    Route::get('/kategori/{slug}', [KategoriController::class, 'show']);
    Route::get('/kategori/{slug}/produk', [KategoriController::class, 'produk']);

    // --------------------- KOTA ---------------------
    Route::get('/kota', [KotaController::class, 'index']);

    // --------------------- KUPON VALIDASI ---------------------
    Route::post('/kupon/validasi', [KuponController::class, 'validasi']);


    // ========================================================================
    // PROTECTED ROUTES (Memerlukan authentication)
    // ========================================================================

    Route::middleware('auth:sanctum')->group(function () {

        // --------------------- AUTH (PROTECTED) ---------------------
        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::get('/me', [AuthController::class, 'me']);
            Route::put('/profile', [AuthController::class, 'updateProfile']);
            Route::put('/password', [AuthController::class, 'updatePassword']);
        });

        // --------------------- KERANJANG ---------------------
        Route::prefix('keranjang')->group(function () {
            Route::get('/', [KeranjangController::class, 'index']);
            Route::post('/', [KeranjangController::class, 'store']);
            Route::put('/{id}', [KeranjangController::class, 'update']);
            Route::delete('/{id}', [KeranjangController::class, 'destroy']);
            Route::delete('/', [KeranjangController::class, 'clear']);
        });

        // --------------------- CHECKOUT & PESANAN ---------------------
        Route::post('/checkout', [PesananController::class, 'checkout']);

        Route::prefix('pesanan')->group(function () {
            Route::get('/', [PesananController::class, 'index']);
            Route::get('/{id}', [PesananController::class, 'show']);
            Route::post('/{id}/upload-bukti', [PesananController::class, 'uploadBukti']);
            Route::post('/{id}/batal', [PesananController::class, 'batal']);
            Route::post('/{id}/konfirmasi', [PesananController::class, 'konfirmasi']);
            Route::post('/{id}/refund', [PesananController::class, 'mintaRefund']);
        });

        // --------------------- ULASAN ---------------------
        Route::post('/ulasan', [UlasanController::class, 'store']);


        // ====================================================================
        // PETANI ROUTES (Role: petani)
        // ====================================================================

        Route::middleware('role:petani')->prefix('petani')->group(function () {

            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index']);

            // Produk Management
            Route::prefix('produk')->group(function () {
                Route::get('/', [ProdukController::class, 'index']);
                Route::post('/', [ProdukController::class, 'store']);
                Route::get('/{id}', [ProdukController::class, 'show']);
                Route::put('/{id}', [ProdukController::class, 'update']);
                Route::delete('/{id}', [ProdukController::class, 'destroy']);
                Route::post('/{id}/foto', [ProdukController::class, 'uploadFoto']);
            });

            // Pesanan Masuk
            Route::prefix('pesanan')->group(function () {
                Route::get('/', [PesananController::class, 'index']);
                Route::get('/{id}', [PesananController::class, 'show']);
                Route::post('/{id}/verifikasi', [PesananController::class, 'verifikasi']);
                Route::post('/{id}/tolak', [PesananController::class, 'tolak']);
                Route::post('/{id}/proses', [PesananController::class, 'proses']);
                Route::post('/{id}/kirim', [PesananController::class, 'kirim']);
            });

            // Rekening
            Route::prefix('rekening')->group(function () {
                Route::get('/', [RekeningController::class, 'index']);
                Route::post('/', [RekeningController::class, 'store']);
                Route::put('/{id}', [RekeningController::class, 'update']);
                Route::delete('/{id}', [RekeningController::class, 'destroy']);
                Route::post('/{id}/utama', [RekeningController::class, 'setUtama']);
            });

            // Ulasan Response
            Route::get('/ulasan', [UlasanController::class, 'index']);
        });


        // ====================================================================
        // ADMIN ROUTES (Role: admin)
        // ====================================================================

        Route::middleware('role:admin')->prefix('admin')->group(function () {

            // Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index']);

            // User Management
            Route::prefix('pengguna')->group(function () {
                Route::get('/', [PenggunaController::class, 'index']);
                Route::get('/{id}', [PenggunaController::class, 'show']);
                Route::put('/{id}', [PenggunaController::class, 'update']);
                Route::post('/{id}/verify', [PenggunaController::class, 'verify']);
                Route::delete('/{id}', [PenggunaController::class, 'destroy']);
            });

            // Kategori Management
            Route::apiResource('kategori', KategoriController::class);

            // Kota Management
            Route::apiResource('kota', KotaController::class);

            // Kupon Management
            Route::apiResource('kupon', KuponController::class);

            // Escrow Monitoring
            Route::prefix('escrow')->group(function () {
                Route::get('/', [EscrowController::class, 'index']);
                Route::get('/{id}', [EscrowController::class, 'show']);
                Route::get('/stats', [EscrowController::class, 'stats']);
            });

            // Refund Management
            Route::prefix('refund')->group(function () {
                Route::get('/', [RefundController::class, 'index']);
                Route::post('/{id}/approve', [RefundController::class, 'approve']);
                Route::post('/{id}/reject', [RefundController::class, 'reject']);
            });

            // Pesanan Monitoring
            Route::prefix('pesanan')->group(function () {
                Route::get('/', [PesananController::class, 'index']);
                Route::get('/{id}', [PesananController::class, 'show']);
                Route::get('/{id}/histori', [PesananController::class, 'histori']);
            });

            // Reports
            Route::prefix('laporan')->group(function () {
                Route::get('/penjualan', [LaporanController::class, 'penjualan']);
                Route::get('/produk', [LaporanController::class, 'produkTerlaris']);
                Route::get('/petani', [LaporanController::class, 'petaniTerbaik']);
            });
        });
    }); // End auth:sanctum middleware

}); // End v1 prefix
