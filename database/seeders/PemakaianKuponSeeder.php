<?php

namespace Database\Seeders;

use App\Models\PemakaianKupon;
use App\Models\Kupon;
use App\Models\Pesanan;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class PemakaianKuponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates coupon usage records for orders with discounts.
     */
    public function run(): void
    {
        $kupon = Kupon::where('is_aktif', true)->get();
        $pesananWithDiskon = Pesanan::where('diskon', '>', 0)->get();

        if ($kupon->isEmpty()) {
            $this->command->warn('Tidak ada kupon aktif!');
            return;
        }

        $this->command->info('Creating coupon usage records...');

        // For orders that already have discount, create usage record
        foreach ($pesananWithDiskon as $order) {
            if (PemakaianKupon::where('id_pesanan', $order->id_pesanan)->exists()) {
                continue;
            }

            $selectedKupon = $kupon->random();
            PemakaianKupon::create([
                'id_kupon' => $selectedKupon->id_kupon,
                'id_pengguna' => $order->id_pembeli,
                'id_pesanan' => $order->id_pesanan,
                'diskon_dipakai' => $order->diskon,
                'tgl_pakai' => $order->tgl_dibuat,
            ]);

            $this->command->line("  ✓ Pesanan #{$order->id_pesanan} - kupon {$selectedKupon->kode}");
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

            $selectedKupon = $kupon->random();
            $diskon = min($selectedKupon->nilai_diskon, $order->subtotal * 0.2); // Max 20% of subtotal

            // Update order with discount
            $order->update([
                'diskon' => $diskon,
                'total_bayar' => $order->subtotal + $order->ongkir - $diskon,
            ]);

            PemakaianKupon::create([
                'id_kupon' => $selectedKupon->id_kupon,
                'id_pengguna' => $order->id_pembeli,
                'id_pesanan' => $order->id_pesanan,
                'diskon_dipakai' => $diskon,
                'tgl_pakai' => $order->tgl_dibuat,
            ]);

            $this->command->line("  ✓ Updated Pesanan #{$order->id_pesanan} with kupon {$selectedKupon->kode}");
        }

        $count = PemakaianKupon::count();
        $this->command->info("✅ PemakaianKuponSeeder completed! Total: {$count} records");
    }
}
