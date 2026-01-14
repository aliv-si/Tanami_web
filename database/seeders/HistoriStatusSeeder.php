<?php

namespace Database\Seeders;

use App\Models\HistoriStatus;
use App\Models\Pesanan;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class HistoriStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates status history for existing orders to test history timeline.
     */
    public function run(): void
    {
        $pesanan = Pesanan::all();
        $admin = Pengguna::where('role_pengguna', 'admin')->first();

        if ($pesanan->isEmpty()) {
            $this->command->warn('Tidak ada pesanan! Jalankan PesananSeeder dulu.');
            return;
        }

        $this->command->info('Creating status history for orders...');

        foreach ($pesanan as $order) {
            // Skip jika sudah ada histori
            if (HistoriStatus::where('id_pesanan', $order->id_pesanan)->exists()) {
                continue;
            }

            $history = $this->getHistoryPath($order->status_pesanan);
            $baseTime = $order->tgl_dibuat;

            foreach ($history as $i => $status) {
                $pengubah = $this->getChanger($status, $order);
                HistoriStatus::create([
                    'id_pesanan' => $order->id_pesanan,
                    'status_lama' => $i > 0 ? $history[$i - 1] : null,
                    'status_baru' => $status,
                    'id_pengubah' => $pengubah,
                    'alasan' => $this->getAlasan($status),
                    'tgl_dibuat' => $baseTime->copy()->addHours($i * rand(2, 12)),
                ]);
            }
        }

        $count = HistoriStatus::count();
        $this->command->info("✅ HistoriStatusSeeder completed! Total: {$count} records");
    }

    /**
     * Get the typical status path for a given final status
     */
    private function getHistoryPath(string $finalStatus): array
    {
        $paths = [
            'pending' => ['pending'],
            'menunggu_verifikasi' => ['pending', 'menunggu_verifikasi'],
            'dibayar' => ['pending', 'menunggu_verifikasi', 'dibayar'],
            'diproses' => ['pending', 'menunggu_verifikasi', 'dibayar', 'diproses'],
            'dikirim' => ['pending', 'menunggu_verifikasi', 'dibayar', 'diproses', 'dikirim'],
            'terkirim' => ['pending', 'menunggu_verifikasi', 'dibayar', 'diproses', 'dikirim', 'terkirim'],
            'selesai' => ['pending', 'menunggu_verifikasi', 'dibayar', 'diproses', 'dikirim', 'terkirim', 'selesai'],
            'dibatalkan' => ['pending', 'dibatalkan'],
            'minta_refund' => ['pending', 'menunggu_verifikasi', 'dibayar', 'diproses', 'dikirim', 'terkirim', 'minta_refund'],
            'direfund' => ['pending', 'menunggu_verifikasi', 'dibayar', 'diproses', 'dikirim', 'terkirim', 'minta_refund', 'direfund'],
        ];

        return $paths[$finalStatus] ?? ['pending'];
    }

    /**
     * Get the user who changed the status
     */
    private function getChanger(string $status, Pesanan $order): ?int
    {
        $pembeliActions = ['pending', 'menunggu_verifikasi', 'minta_refund', 'selesai'];
        $petaniActions = ['dibayar', 'diproses', 'dikirim', 'terkirim'];
        $adminActions = ['direfund'];

        if (in_array($status, $pembeliActions)) {
            return $order->id_pembeli;
        } elseif (in_array($status, $petaniActions)) {
            return $order->id_verifikator;
        } elseif (in_array($status, $adminActions)) {
            return Pengguna::where('role_pengguna', 'admin')->first()?->id_pengguna;
        }

        return null;
    }

    private function getAlasan(string $status): ?string
    {
        $reasons = [
            'dibatalkan' => 'Pesanan dibatalkan',
            'direfund' => 'Refund disetujui admin',
            'selesai' => 'Konfirmasi penerimaan barang',
        ];

        return $reasons[$status] ?? null;
    }
}
