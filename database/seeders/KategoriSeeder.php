<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            [
                'nama_kategori' => 'Sayuran',
                'slug_kategori' => 'sayuran',
                'deskripsi' => 'Berbagai jenis sayuran segar',
                'tgl_dibuat' => now(),
            ],
            [
                'nama_kategori' => 'Buah',
                'slug_kategori' => 'buah',
                'deskripsi' => 'Buah-buahan segar berkualitas',
                'tgl_dibuat' => now(),
            ],
            [
                'nama_kategori' => 'Tanaman Hias',
                'slug_kategori' => 'tanaman-hias',
                'deskripsi' => 'Tanaman hias untuk dekorasi',
                'tgl_dibuat' => now(),
            ],
            [
                'nama_kategori' => 'Bibit',
                'slug_kategori' => 'bibit',
                'deskripsi' => 'Bibit tanaman berkualitas',
                'tgl_dibuat' => now(),
            ],
        ]);
    }
}
