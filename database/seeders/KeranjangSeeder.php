<?php

namespace Database\Seeders;

use App\Models\Keranjang;
use App\Models\Pengguna;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class KeranjangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates cart items for all pembeli users to test checkout flow.
     */
    public function run(): void
    {
        $pembeli = Pengguna::where('role_pengguna', 'pembeli')->get();
        $produk = Produk::where('is_aktif', true)->get();

        if ($pembeli->isEmpty() || $produk->isEmpty()) {
            $this->command->warn('Pastikan sudah ada Pembeli dan Produk!');
            return;
        }

        $this->command->info('Creating cart items for each pembeli...');

        foreach ($pembeli as $buyer) {
            // Each pembeli gets 2-4 random products in cart
            $productCount = rand(2, 4);
            $selectedProducts = $produk->random(min($productCount, $produk->count()));

            foreach ($selectedProducts as $prod) {
                $qty = rand(1, 3);

                // Check if already exists
                $existing = Keranjang::where('id_pengguna', $buyer->id_pengguna)
                    ->where('id_produk', $prod->id_produk)
                    ->first();

                if (!$existing) {
                    Keranjang::create([
                        'id_pengguna' => $buyer->id_pengguna,
                        'id_produk' => $prod->id_produk,
                        'jumlah' => $qty,
                    ]);
                }
            }

            $this->command->line("  ✓ {$buyer->nama_lengkap} - {$productCount} items in cart");
        }

        $this->command->info('✅ KeranjangSeeder completed!');
    }
}
