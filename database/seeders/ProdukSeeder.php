<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'id_petani' => 2, // Pak Tono
                'id_kategori' => 1, // Sayuran
                'nama_produk' => 'Wortel Organik',
                'slug_produk' => 'wortel-organik',
                'harga' => 10000.00,
                'stok' => 50,
                'stok_direserve' => 0,
                'satuan' => 'kg',
                'deskripsi' => 'Wortel organik segar dari Bogor',
                'foto' => null,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
                'tgl_update' => now(),
            ],
            [
                'id_petani' => 2,
                'id_kategori' => 2, // Buah
                'nama_produk' => 'Tomat Merah',
                'slug_produk' => 'tomat-merah',
                'harga' => 12000.00,
                'stok' => 40,
                'stok_direserve' => 0,
                'satuan' => 'kg',
                'deskripsi' => 'Tomat merah segar dan manis',
                'foto' => null,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
                'tgl_update' => now(),
            ],
            [
                'id_petani' => 2,
                'id_kategori' => 1,
                'nama_produk' => 'Bayam Hijau',
                'slug_produk' => 'bayam-hijau',
                'harga' => 8000.00,
                'stok' => 30,
                'stok_direserve' => 0,
                'satuan' => 'kg',
                'deskripsi' => 'Bayam hijau organik',
                'foto' => null,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
                'tgl_update' => now(),
            ],
            [
                'id_petani' => 3, // Bu Siti
                'id_kategori' => 2,
                'nama_produk' => 'Apel Malang',
                'slug_produk' => 'apel-malang',
                'harga' => 25000.00,
                'stok' => 20,
                'stok_direserve' => 0,
                'satuan' => 'kg',
                'deskripsi' => 'Apel Malang premium',
                'foto' => null,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
                'tgl_update' => now(),
            ],
            [
                'id_petani' => 3,
                'id_kategori' => 3, // Tanaman Hias
                'nama_produk' => 'Monstera Deliciosa',
                'slug_produk' => 'monstera',
                'harga' => 150000.00,
                'stok' => 10,
                'stok_direserve' => 0,
                'satuan' => 'pot',
                'deskripsi' => 'Tanaman hias Monstera cantik',
                'foto' => null,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
                'tgl_update' => now(),
            ],
            [
                'id_petani' => 3,
                'id_kategori' => 4, // Bibit
                'nama_produk' => 'Bibit Cabai Rawit',
                'slug_produk' => 'bibit-cabai',
                'harga' => 5000.00,
                'stok' => 100,
                'stok_direserve' => 0,
                'satuan' => 'pack',
                'deskripsi' => 'Bibit cabai rawit unggul',
                'foto' => null,
                'is_aktif' => true,
                'tgl_dibuat' => now(),
                'tgl_update' => now(),
            ],
        ]);
    }
}
