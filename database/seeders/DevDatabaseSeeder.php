<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevDatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Complete seeder for local development
     * Includes all data: users, products, orders, carts, reviews, etc.
     * 
     * Usage: php artisan db:seed --class=DevDatabaseSeeder
     * Or: php artisan migrate:fresh --seed --seeder=DevDatabaseSeeder
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Development Database Seeding...');
        $this->command->line('');

        $this->call([
            // 1. Core data (must run first)
            PenggunaSeeder::class,      // 2 admin, 7 petani, 10 pembeli
            KategoriSeeder::class,      // Product categories
            KotaSeeder::class,          // Cities with shipping cost
            KuponSeeder::class,         // Discount coupons

            // 2. Product data
            ProdukSeederDev::class,        // Products per petani
            RekeningPetaniSeeder::class, // Bank accounts for petani

            // 3. Transaction data
            KeranjangSeeder::class,     // Cart items per pembeli
            PesananSeeder::class,       // Orders with all status scenarios

            // 4. Related transaction data
            HistoriStatusSeeder::class,  // Order status history
            PemakaianKuponSeeder::class, // Coupon usage records
            UlasanSeeder::class,         // Reviews for completed orders
        ]);

        $this->command->line('');
        $this->command->info('✅ Development database seeding completed!');
        $this->command->line('');
        $this->command->info('📋 Test Credentials (password: password):');
        $this->command->line('   Admin:   admin@tanami.com');
        $this->command->line('   Petani:  tono@petani.com, siti@petani.com');
        $this->command->line('   Pembeli: budi@pembeli.com, ani@pembeli.com');
    }
}
