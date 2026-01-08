<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RekeningPetaniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rekening_petani')->insert([
            [
                'id_petani' => 2, // Pak Tono
                'nama_bank' => 'BCA',
                'no_rekening' => '1234567890',
                'atas_nama' => 'TONO SUSILO',
                'is_utama' => true,
                'tgl_dibuat' => now(),
            ],
            [
                'id_petani' => 3, // Bu Siti
                'nama_bank' => 'Mandiri',
                'no_rekening' => '0987654321',
                'atas_nama' => 'SITI AMINAH',
                'is_utama' => true,
                'tgl_dibuat' => now(),
            ],
        ]);
    }
}
