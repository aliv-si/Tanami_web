<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Seeder khusus untuk production - hanya data esensial
     * 
     * Run: php artisan db:seed --class=ProductionSeeder
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Production Seeding...');
        $this->command->line('');

        $this->call([
            // 1. Data pengguna (minimal untuk referensi produk)
            PenggunaSeeder::class,

            // 2. Kategori produk
            KategoriSeeder::class,

            // 3. Kota untuk ongkir
            KotaSeeder::class,

            // 4. Produk
            ProdukSeeder::class,
        ]);

        $this->command->line('');
        $this->command->info('✅ Production seeding completed!');
    }
}
