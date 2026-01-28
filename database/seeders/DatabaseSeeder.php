<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 
     * Production-ready seeder - only essential data
     */
    public function run(): void
    {
        // Only seed essential data for production
        $this->call([
            PenggunaSeeder::class,      // Users (admin, petani, pembeli)
            KategoriSeeder::class,      // Product categories
            KotaSeeder::class,          // Cities with shipping cost
            ProdukSeeder::class,        // Products
        ]);
    }
}
