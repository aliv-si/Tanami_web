<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KuponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kupon')->insert([
            [
                'kode_kupon' => 'PROMO10',
                'tipe_diskon' => 'nominal',
                'nominal_diskon' => 10000.00,
                'persen_diskon' => null,
                'min_belanja' => 50000.00,
                'limit_total' => null,
                'limit_per_user' => 1,
                'tgl_mulai' => '2025-11-29 00:00:00',
                'tgl_selesai' => '2026-01-29 23:59:59',
                'is_aktif' => true,
                'tgl_dibuat' => now(),
            ],
            [
                'kode_kupon' => 'DISKON20',
                'tipe_diskon' => 'persen',
                'nominal_diskon' => null,
                'persen_diskon' => 20.00,
                'min_belanja' => 100000.00,
                'limit_total' => null,
                'limit_per_user' => 2,
                'tgl_mulai' => '2025-12-14 00:00:00',
                'tgl_selesai' => '2026-01-14 23:59:59',
                'is_aktif' => true,
                'tgl_dibuat' => now(),
            ],
            [
                'kode_kupon' => 'NEWUSER',
                'tipe_diskon' => 'nominal',
                'nominal_diskon' => 15000.00,
                'persen_diskon' => null,
                'min_belanja' => 30000.00,
                'limit_total' => null,
                'limit_per_user' => 1,
                'tgl_mulai' => '2025-12-22 00:00:00',
                'tgl_selesai' => '2026-02-28 23:59:59',
                'is_aktif' => true,
                'tgl_dibuat' => now(),
            ],
        ]);
    }
}
