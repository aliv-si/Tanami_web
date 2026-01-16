<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\Petani\DashboardController as PetaniDashboardController;
use App\Http\Controllers\Petani\ProdukController as PetaniProdukController;
use App\Http\Controllers\Petani\PesananController as PetaniPesananController;
use App\Http\Controllers\Petani\RekeningController as PetaniRekeningController;
use App\Http\Controllers\Petani\UlasanController as PetaniUlasanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PenggunaController as AdminPenggunaController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\KotaController as AdminKotaController;
use App\Http\Controllers\Admin\KuponController as AdminKuponController;
use App\Http\Controllers\Admin\EscrowController as AdminEscrowController;
use App\Http\Controllers\Admin\RefundController as AdminRefundController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - TANAMI E-Commerce v2.0 (MVC)
|--------------------------------------------------------------------------
*/

// ============================================================================
// LOGOUT
// ============================================================================
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('success', 'Berhasil logout');
})->name('logout');

// ============================================================================
// PUBLIC PAGES
// ============================================================================

Route::get('/', function () {
    $featuredProducts = Produk::with(['kategori', 'petani'])
        ->where('stok', '>', 0)
        ->orderBy('tgl_dibuat', 'desc')
        ->take(4)
        ->get();

    return view('welcome', compact('featuredProducts'));
})->name('home');

Route::get('/beranda', function () {
    return view('pages.beranda');
})->name('beranda');

Route::get('/tentang', function () {
    return view('pages.tentang');
})->name('tentang');

Route::get('/cara-kerja', function () {
    return view('pages.cara-kerja');
})->name('cara-kerja');

Route::get('/kontak', function () {
    return view('pages.kontak');
})->name('kontak');

// Katalog & Produk (Public)
Route::get('/katalog', [ProdukController::class, 'katalog'])->name('katalog');
Route::get('/katalog/{slug}', [ProdukController::class, 'byKategori'])->name('katalog.kategori');
Route::get('/produk/{slug}', [ProdukController::class, 'show'])->name('produk.detail');


// ============================================================================
// DEV ROUTES (Development Only - Remove in Production!)
// ============================================================================

if (app()->environment('local')) {
    Route::prefix('dev')->name('dev.')->group(function () {
        // Auto-login as petani for testing
        Route::get('/login-petani', function () {
            $petani = Pengguna::where('role_pengguna', 'petani')->first();
            if ($petani) {
                Auth::login($petani);
                return redirect()->route('petani.dashboard');
            }
            return 'No petani found. Run php artisan db:seed first.';
        })->name('login-petani');

        // Auto-login as admin for testing
        Route::get('/login-admin', function () {
            $admin = Pengguna::where('role_pengguna', 'admin')->first();
            if ($admin) {
                Auth::login($admin);
                return redirect()->route('admin.dashboard');
            }
            return 'No admin found. Run php artisan db:seed first.';
        })->name('login-admin');

        // Auto-login as pembeli for testing
        Route::get('/login-pembeli', function () {
            $pembeli = Pengguna::where('role_pengguna', 'pembeli')->first();
            if ($pembeli) {
                Auth::login($pembeli);
                return redirect()->route('pesanan');
            }
            return 'No pembeli found. Run php artisan db:seed first.';
        })->name('login-pembeli');
    });
}


// ============================================================================
// AUTH ROUTES (Guest only)
// ============================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// ============================================================================
// PROTECTED ROUTES (Auth required)
// ============================================================================

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --------------------- PROFILE ---------------------
    Route::get('/profil', [AuthController::class, 'showProfil'])->name('profil');
    Route::put('/profil', [AuthController::class, 'updateProfil'])->name('profil.update');
    Route::put('/profil/password', [AuthController::class, 'updatePassword'])->name('profil.password');
    Route::post('/profil/foto', [AuthController::class, 'updateFoto'])->name('profil.foto');
    Route::delete('/profil/foto', [AuthController::class, 'deleteFoto'])->name('profil.foto.hapus');

    // --------------------- KERANJANG ---------------------
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
    Route::delete('/keranjang', [KeranjangController::class, 'clear'])->name('keranjang.clear');

    // --------------------- CHECKOUT & PESANAN ---------------------
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [PesananController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.detail');
    Route::post('/pesanan/{id}/upload-bukti', [PesananController::class, 'uploadBukti'])->name('pesanan.upload-bukti');
    Route::post('/pesanan/{id}/batal', [PesananController::class, 'batal'])->name('pesanan.batal');
    Route::post('/pesanan/{id}/konfirmasi', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');
    Route::post('/pesanan/{id}/refund', [PesananController::class, 'mintaRefund'])->name('pesanan.refund');
    Route::get('/pesanan/{id}/bukti-bayar', [PesananController::class, 'viewBuktiBayar'])->name('pesanan.bukti-bayar');

    // --------------------- ULASAN ---------------------
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');


    // ========================================================================
    // PETANI ROUTES
    // ========================================================================

    Route::middleware('role:petani')->prefix('petani')->name('petani.')->group(function () {

        Route::get('/dashboard', [PetaniDashboardController::class, 'index'])->name('dashboard');

        // Produk
        Route::get('/produk', [PetaniProdukController::class, 'index'])->name('produk');
        Route::get('/produk/tambah', [PetaniProdukController::class, 'create'])->name('produk.create');
        Route::post('/produk', [PetaniProdukController::class, 'store'])->name('produk.store');
        Route::get('/produk/{id}/edit', [PetaniProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/produk/{id}', [PetaniProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [PetaniProdukController::class, 'destroy'])->name('produk.destroy');

        // Pesanan
        Route::get('/pesanan', [PetaniPesananController::class, 'index'])->name('pesanan');
        Route::get('/pesanan/{id}', [PetaniPesananController::class, 'show'])->name('pesanan.detail');
        Route::post('/pesanan/{id}/verifikasi', [PetaniPesananController::class, 'verifikasi'])->name('pesanan.verifikasi');
        Route::post('/pesanan/{id}/tolak', [PetaniPesananController::class, 'tolak'])->name('pesanan.tolak');
        Route::post('/pesanan/{id}/proses', [PetaniPesananController::class, 'proses'])->name('pesanan.proses');
        Route::post('/pesanan/{id}/kirim', [PetaniPesananController::class, 'kirim'])->name('pesanan.kirim');
        Route::get('/pesanan/{id}/invoice', [PetaniPesananController::class, 'invoice'])->name('pesanan.invoice');

        // Rekening
        Route::get('/rekening', [PetaniRekeningController::class, 'index'])->name('rekening');
        Route::post('/rekening', [PetaniRekeningController::class, 'store'])->name('rekening.store');
        Route::put('/rekening/{id}', [PetaniRekeningController::class, 'update'])->name('rekening.update');
        Route::delete('/rekening/{id}', [PetaniRekeningController::class, 'destroy'])->name('rekening.destroy');
        Route::post('/rekening/{id}/utama', [PetaniRekeningController::class, 'setUtama'])->name('rekening.utama');

        // Ulasan
        Route::get('/ulasan', [PetaniUlasanController::class, 'index'])->name('ulasan');
    });


    // ========================================================================
    // ADMIN ROUTES
    // ========================================================================

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Pengguna
        Route::get('/pengguna', [AdminPenggunaController::class, 'index'])->name('pengguna');
        Route::get('/pengguna/petani', [AdminPenggunaController::class, 'petaniPending'])->name('pengguna.petani');
        Route::get('/pengguna/{id}', [AdminPenggunaController::class, 'show'])->name('pengguna.show');
        Route::put('/pengguna/{id}', [AdminPenggunaController::class, 'update'])->name('pengguna.update');
        Route::post('/pengguna/{id}/verify', [AdminPenggunaController::class, 'verify'])->name('pengguna.verify');
        Route::delete('/pengguna/{id}', [AdminPenggunaController::class, 'destroy'])->name('pengguna.destroy');

        // Kategori
        Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori');
        Route::post('/kategori', [AdminKategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{id}', [AdminKategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');

        // Kota
        Route::get('/kota', [AdminKotaController::class, 'index'])->name('kota');
        Route::post('/kota', [AdminKotaController::class, 'store'])->name('kota.store');
        Route::put('/kota/{id}', [AdminKotaController::class, 'update'])->name('kota.update');
        Route::delete('/kota/{id}', [AdminKotaController::class, 'destroy'])->name('kota.destroy');

        // Kupon
        Route::get('/kupon', [AdminKuponController::class, 'index'])->name('kupon');
        Route::post('/kupon', [AdminKuponController::class, 'store'])->name('kupon.store');
        Route::put('/kupon/{id}', [AdminKuponController::class, 'update'])->name('kupon.update');
        Route::delete('/kupon/{id}', [AdminKuponController::class, 'destroy'])->name('kupon.destroy');

        // Pesanan
        Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan');
        Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.detail');
        Route::post('/pesanan/{id}/verifikasi', [AdminPesananController::class, 'verifikasi'])->name('pesanan.verifikasi');
        Route::post('/pesanan/{id}/tolak', [AdminPesananController::class, 'tolak'])->name('pesanan.tolak');
        Route::post('/pesanan/{id}/proses', [AdminPesananController::class, 'proses'])->name('pesanan.proses');
        Route::post('/pesanan/{id}/kirim', [AdminPesananController::class, 'kirim'])->name('pesanan.kirim');
        Route::get('/pesanan/{id}/invoice', [AdminPesananController::class, 'invoice'])->name('pesanan.invoice');

        // Escrow
        Route::get('/escrow', [AdminEscrowController::class, 'index'])->name('escrow');
        Route::post('/escrow/{id}/release', [AdminEscrowController::class, 'releaseToPetani'])->name('escrow.release');
        Route::post('/escrow/{id}/refund', [AdminEscrowController::class, 'refundToPembeli'])->name('escrow.refund');

        // Refund
        Route::get('/refund', [AdminRefundController::class, 'index'])->name('refund');
        Route::post('/refund/{id}/approve', [AdminRefundController::class, 'approve'])->name('refund.approve');
        Route::post('/refund/{id}/reject', [AdminRefundController::class, 'reject'])->name('refund.reject');

        // Laporan
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan');
    });
});
