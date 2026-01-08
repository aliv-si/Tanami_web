<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kota')->insert([
            [
                'nama_kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'ongkir' => 20000.00,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
            ],
            [
                'nama_kota' => 'Bogor',
                'provinsi' => 'Jawa Barat',
                'ongkir' => 15000.00,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
            ],
            [
                'nama_kota' => 'Bandung',
                'provinsi' => 'Jawa Barat',
                'ongkir' => 25000.00,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
            ],
            [
                'nama_kota' => 'Tangerang',
                'provinsi' => 'Banten',
                'ongkir' => 18000.00,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
            ],
            [
                'nama_kota' => 'Bekasi',
                'provinsi' => 'Jawa Barat',
                'ongkir' => 17000.00,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
            ],
        ]);
    }
}
