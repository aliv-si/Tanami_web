<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PenggunaSeeder::class,
            KategoriSeeder::class,
            KotaSeeder::class,
            KuponSeeder::class,
            ProdukSeeder::class,
            RekeningPetaniSeeder::class,
            PesananSeeder::class,
            UlasanSeeder::class,
        ]);
    }
}
