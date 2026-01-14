<?php

namespace Database\Seeders;

use App\Models\PemakaianKupon;
use App\Models\Kupon;
use App\Models\Pesanan;
use Illuminate\Database\Seeder;

class PemakaianKuponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates coupon usage records for orders with discounts.
     */
    public function run(): void
    {
        $kuponList = Kupon::where('is_aktif', true)->get();
        $pesananWithDiskon = Pesanan::where('diskon', '>', 0)->get();

        if ($kuponList->isEmpty()) {
            $this->command->warn('Tidak ada kupon aktif!');
            return;
        }

        $this->command->info('Creating coupon usage records...');

        // For orders that already have discount, create usage record
        foreach ($pesananWithDiskon as $order) {
            if (PemakaianKupon::where('id_pesanan', $order->id_pesanan)->exists()) {
                continue;
            }

            $selectedKupon = $kuponList->random();
            PemakaianKupon::create([
                'id_kupon' => $selectedKupon->id_kupon,
                'id_pengguna' => $order->id_pembeli,
                'id_pesanan' => $order->id_pesanan,
                'diskon_dipakai' => $order->diskon,
            ]);

            $this->command->line("  ✓ Pesanan #{$order->id_pesanan} - kupon {$selectedKupon->kode_kupon}");
        }

        // Create some usage for completed orders without discount (simulate past usage)
        $completedOrders = Pesanan::where('status_pesanan', 'selesai')
            ->where('diskon', 0)
            ->take(5)
            ->get();

        foreach ($completedOrders as $order) {
            if (PemakaianKupon::where('id_pesanan', $order->id_pesanan)->exists()) {
                continue;
            }

            $selectedKupon = $kuponList->random();

            // Calculate discount based on kupon type
            $diskon = $selectedKupon->hitungDiskon($order->subtotal);

            // Skip if no discount calculated
            if ($diskon <= 0) {
                continue;
            }

            // Update order with discount
            $order->update([
                'diskon' => $diskon,
                'total_bayar' => max(0, $order->subtotal + $order->ongkir - $diskon),
            ]);

            PemakaianKupon::create([
                'id_kupon' => $selectedKupon->id_kupon,
                'id_pengguna' => $order->id_pembeli,
                'id_pesanan' => $order->id_pesanan,
                'diskon_dipakai' => $diskon,
            ]);

            $this->command->line("  ✓ Updated Pesanan #{$order->id_pesanan} with kupon {$selectedKupon->kode_kupon}");
        }

        $count = PemakaianKupon::count();
        $this->command->info("✅ PemakaianKuponSeeder completed! Total: {$count} records");
    }
}
