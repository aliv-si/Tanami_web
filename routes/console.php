<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ==================== SCHEDULED TASKS ====================

/**
 * 4.1 Auto-Cancel Timeout Payment (24 jam)
 * Jalankan setiap jam untuk cancel pesanan yang belum bayar
 * dalam 24 jam setelah checkout
 */
Schedule::command('orders:cancel-timeout-payment')
    ->hourly()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/scheduler.log'));

/**
 * 4.2 Auto-Cancel Timeout Verifikasi (48 jam)
 * Jalankan setiap jam untuk cancel pesanan yang tidak diverifikasi petani
 * dalam 48 jam setelah upload bukti bayar
 */
Schedule::command('orders:cancel-timeout-verification')
    ->hourly()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/scheduler.log'));

/**
 * 4.3 Auto-Complete Order (3 hari)
 * Jalankan setiap 6 jam untuk auto-complete pesanan yang sudah terkirim
 * lebih dari 3 hari tanpa konfirmasi dari pembeli
 */
Schedule::command('orders:auto-complete')
    ->everySixHours()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/scheduler.log'));
