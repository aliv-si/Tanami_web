<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengguna')->insert([
            [
                'nama_lengkap' => 'Admin System',
                'email' => 'admin@tanami.com',
                'password' => Hash::make('password'),
                'role_pengguna' => 'admin',
                'alamat' => null,
                'no_hp' => '081234567890',
                'is_verified' => true,
                'tgl_daftar' => now(),
                'tgl_update' => now(),
            ],
            [
                'nama_lengkap' => 'Pak Tono',
                'email' => 'tono@petani.com',
                'password' => Hash::make('password'),
                'role_pengguna' => 'petani',
                'alamat' => 'Bogor, Jawa Barat',
                'no_hp' => '081234567891',
                'is_verified' => true,
                'tgl_daftar' => now(),
                'tgl_update' => now(),
            ],
            [
                'nama_lengkap' => 'Bu Siti',
                'email' => 'siti@petani.com',
                'password' => Hash::make('password'),
                'role_pengguna' => 'petani',
                'alamat' => 'Bandung, Jawa Barat',
                'no_hp' => '081234567892',
                'is_verified' => true,
                'tgl_daftar' => now(),
                'tgl_update' => now(),
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi@pembeli.com',
                'password' => Hash::make('password'),
                'role_pengguna' => 'pembeli',
                'alamat' => 'Jakarta Selatan',
                'no_hp' => '081234567893',
                'is_verified' => true,
                'tgl_daftar' => now(),
                'tgl_update' => now(),
            ],
            [
                'nama_lengkap' => 'Ani Wijaya',
                'email' => 'ani@pembeli.com',
                'password' => Hash::make('password'),
                'role_pengguna' => 'pembeli',
                'alamat' => 'Tangerang',
                'no_hp' => '081234567894',
                'is_verified' => true,
                'tgl_daftar' => now(),
                'tgl_update' => now(),
            ],
            [
                'nama_lengkap' => 'Dedi Kurniawan',
                'email' => 'dedi@pembeli.com',
                'password' => Hash::make('password'),
                'role_pengguna' => 'pembeli',
                'alamat' => 'Bekasi',
                'no_hp' => '081234567895',
                'is_verified' => true,
                'tgl_daftar' => now(),
                'tgl_update' => now(),
            ],
        ]);
    }
}
