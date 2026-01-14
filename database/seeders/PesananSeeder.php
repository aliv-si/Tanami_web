<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\Kota;
use App\Models\Escrow;
use App\Models\HistoriStatus;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates comprehensive order data for testing all scenarios.
     */
    public function run(): void
    {
        $pembeli = Pengguna::where('role_pengguna', 'pembeli')->get();
        $petani = Pengguna::where('role_pengguna', 'petani')->get();
        $admin = Pengguna::where('role_pengguna', 'admin')->first();
        $produk = Produk::all();
        $kota = Kota::all();

        if ($pembeli->isEmpty() || $petani->isEmpty() || $produk->isEmpty() || $kota->isEmpty()) {
            $this->command->warn('Pastikan sudah ada data Pengguna, Produk, dan Kota!');
            return;
        }

        $this->command->info('Creating comprehensive order data...');

        // ==============================
        // SCENARIO 1: Orders for PEMBELI testing
        // ==============================
        $this->command->line('');
        $this->command->info('📦 Creating orders for Pembeli role testing...');

        // Pending orders (waiting for payment)
        for ($i = 0; $i < 3; $i++) {
            $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_PENDING, $produk->random(), rand(1, 3));
            $this->command->line("  ✓ #{$p->id_pesanan} - pending (batas: " . $p->batas_bayar->format('d M H:i') . ")");
        }

        // Menunggu verifikasi
        for ($i = 0; $i < 2; $i++) {
            $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_MENUNGGU_VERIFIKASI, $produk->random(), rand(1, 2));
            $p->update(['bukti_bayar' => 'bukti-bayar/sample_' . $p->id_pesanan . '.jpg']);
            $this->command->line("  ✓ #{$p->id_pesanan} - menunggu_verifikasi");
        }

        // Terkirim (waiting for buyer confirmation)
        for ($i = 0; $i < 2; $i++) {
            $prod = $produk->random();
            $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_TERKIRIM, $prod, rand(1, 2));
            $p->update([
                'bukti_bayar' => 'bukti-bayar/sample_' . $p->id_pesanan . '.jpg',
                'tgl_verifikasi' => now()->subDays(rand(3, 5)),
                'id_verifikator' => $prod->id_petani,
                'no_resi' => 'JNE' . rand(1000000000, 9999999999),
            ]);
            $this->createEscrow($p);
            $this->command->line("  ✓ #{$p->id_pesanan} - terkirim (siap konfirmasi)");
        }

        // Selesai (completed - can give review)
        for ($i = 0; $i < 5; $i++) {
            $prod = $produk->random();
            $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_SELESAI, $prod, rand(1, 3));
            $p->update([
                'bukti_bayar' => 'bukti-bayar/sample_' . $p->id_pesanan . '.jpg',
                'tgl_verifikasi' => now()->subDays(rand(10, 20)),
                'id_verifikator' => $prod->id_petani,
                'no_resi' => 'SICEPAT' . rand(1000000000, 9999999999),
                'tgl_selesai' => now()->subDays(rand(5, 15)),
                'id_konfirmasi' => $p->id_pembeli,
            ]);
            $this->createHistori($p, null, Pesanan::STATUS_SELESAI, $p->id_pembeli);
            $this->command->line("  ✓ #{$p->id_pesanan} - selesai (bisa review)");
        }

        // ==============================
        // SCENARIO 2: Orders for PETANI testing
        // ==============================
        $this->command->line('');
        $this->command->info('🌾 Creating orders for Petani role testing...');

        // Orders waiting for petani verification
        foreach ($petani as $pt) {
            $produkPetani = Produk::where('id_petani', $pt->id_pengguna)->first();
            if (!$produkPetani) continue;

            for ($i = 0; $i < 2; $i++) {
                $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_MENUNGGU_VERIFIKASI, $produkPetani, rand(1, 4));
                $p->update(['bukti_bayar' => 'bukti-bayar/petani_sample_' . $p->id_pesanan . '.jpg']);
                $this->command->line("  ✓ #{$p->id_pesanan} - menunggu verifikasi (petani: {$pt->nama_lengkap})");
            }

            // Dibayar (waiting for processing)
            $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_DIBAYAR, $produkPetani, rand(2, 5));
            $p->update([
                'bukti_bayar' => 'bukti-bayar/petani_verified_' . $p->id_pesanan . '.jpg',
                'tgl_verifikasi' => now()->subHours(rand(1, 12)),
                'id_verifikator' => $pt->id_pengguna,
            ]);
            $this->createEscrow($p);
            $this->command->line("  ✓ #{$p->id_pesanan} - dibayar (siap proses - petani: {$pt->nama_lengkap})");

            // Diproses
            $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_DIPROSES, $produkPetani, rand(1, 3));
            $p->update([
                'bukti_bayar' => 'bukti-bayar/petani_proses_' . $p->id_pesanan . '.jpg',
                'tgl_verifikasi' => now()->subDays(1),
                'id_verifikator' => $pt->id_pengguna,
            ]);
            $this->createEscrow($p);
            $this->command->line("  ✓ #{$p->id_pesanan} - diproses (petani: {$pt->nama_lengkap})");

            // Dikirim
            $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_DIKIRIM, $produkPetani, rand(1, 2));
            $p->update([
                'bukti_bayar' => 'bukti-bayar/petani_kirim_' . $p->id_pesanan . '.jpg',
                'tgl_verifikasi' => now()->subDays(2),
                'id_verifikator' => $pt->id_pengguna,
                'no_resi' => 'JNT' . rand(1000000000, 9999999999),
            ]);
            $this->createEscrow($p);
            $this->command->line("  ✓ #{$p->id_pesanan} - dikirim (petani: {$pt->nama_lengkap})");
        }

        // ==============================
        // SCENARIO 3: REFUND testing
        // ==============================
        $this->command->line('');
        $this->command->info('💳 Creating refund scenario orders...');

        // Minta refund
        $prod = $produk->random();
        $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_MINTA_REFUND, $prod, 2);
        $p->update([
            'bukti_bayar' => 'bukti-bayar/refund_request.jpg',
            'tgl_verifikasi' => now()->subDays(5),
            'id_verifikator' => $prod->id_petani,
            'no_resi' => 'ANTERAJA' . rand(1000000000, 9999999999),
            'alasan_refund' => 'Produk tidak sesuai dengan deskripsi',
        ]);
        $this->createEscrow($p);
        $this->command->line("  ✓ #{$p->id_pesanan} - minta_refund");

        // Direfund (completed refund)
        $prod = $produk->random();
        $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_DIREFUND, $prod, 1);
        $p->update([
            'bukti_bayar' => 'bukti-bayar/refunded.jpg',
            'tgl_verifikasi' => now()->subDays(10),
            'id_verifikator' => $prod->id_petani,
            'alasan_refund' => 'Produk rusak saat pengiriman',
        ]);
        $escrow = $this->createEscrow($p);
        $escrow->update([
            'status_escrow' => 'direfund_ke_pembeli',
            'tgl_kirim' => now()->subDays(8),
            'id_penerima' => $p->id_pembeli,
            'catatan' => 'Refund approved - produk rusak',
        ]);
        $this->command->line("  ✓ #{$p->id_pesanan} - direfund");

        // ==============================
        // SCENARIO 4: Cancelled orders
        // ==============================
        $this->command->line('');
        $this->command->info('❌ Creating cancelled orders...');

        // Dibatalkan - pembeli batal sebelum bayar
        $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_DIBATALKAN, $produk->random(), 1);
        $p->update([
            'alasan_batal' => 'Pembeli membatalkan pesanan',
            'tgl_dibatalkan' => now()->subDays(3),
        ]);
        $this->createHistori($p, Pesanan::STATUS_PENDING, Pesanan::STATUS_DIBATALKAN, $p->id_pembeli);
        $this->command->line("  ✓ #{$p->id_pesanan} - dibatalkan (by pembeli)");

        // Dibatalkan - timeout bayar
        $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_DIBATALKAN, $produk->random(), 2);
        $p->update([
            'alasan_batal' => 'Batas waktu pembayaran habis',
            'tgl_dibatalkan' => now()->subDays(5),
            'batas_bayar' => now()->subDays(6),
        ]);
        $this->command->line("  ✓ #{$p->id_pesanan} - dibatalkan (timeout)");

        // Dibatalkan - verifikasi ditolak
        $prod = $produk->random();
        $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_DIBATALKAN, $prod, 1);
        $p->update([
            'bukti_bayar' => 'bukti-bayar/rejected.jpg',
            'alasan_tolak' => 'Bukti pembayaran tidak valid/blur',
            'alasan_batal' => 'Verifikasi pembayaran ditolak',
            'tgl_dibatalkan' => now()->subDays(4),
        ]);
        $this->createHistori($p, Pesanan::STATUS_MENUNGGU_VERIFIKASI, Pesanan::STATUS_DIBATALKAN, $prod->id_petani, 'Bukti tidak valid');
        $this->command->line("  ✓ #{$p->id_pesanan} - dibatalkan (verifikasi ditolak)");

        // ==============================
        // SCENARIO 5: Historical data for reports
        // ==============================
        $this->command->line('');
        $this->command->info('📊 Creating historical orders for reports...');

        // Past month completed orders
        for ($day = 30; $day >= 1; $day -= 3) {
            $prod = $produk->random();
            $p = $this->createOrder($pembeli->random(), $kota->random(), Pesanan::STATUS_SELESAI, $prod, rand(1, 5));
            $createdAt = now()->subDays($day);
            $p->update([
                'tgl_dibuat' => $createdAt,
                'bukti_bayar' => 'bukti-bayar/historical_' . $p->id_pesanan . '.jpg',
                'tgl_verifikasi' => $createdAt->copy()->addHours(rand(1, 12)),
                'id_verifikator' => $prod->id_petani,
                'no_resi' => 'HIST' . rand(1000000000, 9999999999),
                'tgl_selesai' => $createdAt->copy()->addDays(rand(3, 7)),
                'id_konfirmasi' => $p->id_pembeli,
            ]);

            // Create completed escrow
            Escrow::create([
                'id_pesanan' => $p->id_pesanan,
                'jumlah' => $p->total_bayar,
                'status_escrow' => 'dikirim_ke_petani',
                'tgl_ditahan' => $createdAt->copy()->addHours(2),
                'tgl_kirim' => $p->tgl_selesai,
                'id_penerima' => $prod->id_petani,
            ]);
        }
        $this->command->line("  ✓ Created 10 historical completed orders");

        $this->command->info('');
        $this->command->info('✅ PesananSeeder completed! Created comprehensive test data.');
    }

    private function createOrder($pembeli, $kota, string $status, $produk, int $qty): Pesanan
    {
        $subtotal = $produk->harga * $qty;
        $ongkir = $kota->ongkir;
        $pesanan = Pesanan::create([
            'id_pembeli' => $pembeli->id_pengguna,
            'id_kota_tujuan' => $kota->id_kota,
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'diskon' => 0,
            'total_bayar' => $subtotal + $ongkir,
            'status_pesanan' => $status,
            'batas_bayar' => now()->addHours(24),
            'tgl_dibuat' => now(),
        ]);

        ItemPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_produk' => $produk->id_produk,
            'id_petani' => $produk->id_petani,
            'jumlah' => $qty,
            'harga_snapshot' => $produk->harga,
            'subtotal' => $subtotal,
        ]);

        return $pesanan;
    }

    private function createEscrow(Pesanan $pesanan): Escrow
    {
        return Escrow::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'jumlah' => $pesanan->total_bayar,
            'status_escrow' => 'ditahan',
            'tgl_ditahan' => now(),
        ]);
    }

    private function createHistori(Pesanan $pesanan, ?string $statusLama, string $statusBaru, $idPengubah, ?string $alasan = null): void
    {
        HistoriStatus::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status_lama' => $statusLama,
            'status_baru' => $statusBaru,
            'id_pengubah' => $idPengubah,
            'alasan' => $alasan,
        ]);
    }
}
