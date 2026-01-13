<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\Pengguna;
use App\Models\Produk;
use App\Models\Kota;
use App\Models\Escrow;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get required data
        $pembeli = Pengguna::where('role_pengguna', 'pembeli')->first();
        $petani = Pengguna::where('role_pengguna', 'petani')->first();
        $produk = Produk::where('id_petani', $petani?->id_pengguna)->first();
        $kota = Kota::first();

        if (!$pembeli || !$petani || !$produk || !$kota) {
            $this->command->warn('Pastikan sudah ada data Pengguna, Produk, dan Kota terlebih dahulu!');
            return;
        }

        $this->command->info('Creating sample orders...');

        // 1. Pesanan Pending (menunggu pembayaran)
        $pesanan1 = Pesanan::create([
            'id_pembeli' => $pembeli->id_pengguna,
            'id_kota_tujuan' => $kota->id_kota,
            'subtotal' => 100000,
            'ongkir' => $kota->ongkir,
            'diskon' => 0,
            'total_bayar' => 100000 + $kota->ongkir,
            'status_pesanan' => Pesanan::STATUS_PENDING,
            'batas_bayar' => now()->addHours(24),
        ]);
        $this->createItem($pesanan1, $produk, 2);
        $this->command->line("  ✓ Pesanan #{$pesanan1->id_pesanan} - pending");

        // 2. Pesanan Menunggu Verifikasi
        $pesanan2 = Pesanan::create([
            'id_pembeli' => $pembeli->id_pengguna,
            'id_kota_tujuan' => $kota->id_kota,
            'subtotal' => 150000,
            'ongkir' => $kota->ongkir,
            'diskon' => 0,
            'total_bayar' => 150000 + $kota->ongkir,
            'status_pesanan' => Pesanan::STATUS_MENUNGGU_VERIFIKASI,
            'bukti_bayar' => 'bukti-bayar/sample_bukti.jpg',
            'batas_bayar' => now()->addHours(20),
        ]);
        $this->createItem($pesanan2, $produk, 3);
        $this->command->line("  ✓ Pesanan #{$pesanan2->id_pesanan} - menunggu_verifikasi");

        // 3. Pesanan Dibayar (sudah diverifikasi)
        $pesanan3 = Pesanan::create([
            'id_pembeli' => $pembeli->id_pengguna,
            'id_kota_tujuan' => $kota->id_kota,
            'subtotal' => 200000,
            'ongkir' => $kota->ongkir,
            'diskon' => 10000,
            'total_bayar' => 200000 + $kota->ongkir - 10000,
            'status_pesanan' => Pesanan::STATUS_DIBAYAR,
            'bukti_bayar' => 'bukti-bayar/sample_bukti2.jpg',
            'tgl_verifikasi' => now()->subHours(2),
            'id_verifikator' => $petani->id_pengguna,
            'batas_bayar' => now()->subHours(10),
        ]);
        $this->createItem($pesanan3, $produk, 4);
        $this->createEscrow($pesanan3);
        $this->command->line("  ✓ Pesanan #{$pesanan3->id_pesanan} - dibayar");

        // 4. Pesanan Dikirim
        $pesanan4 = Pesanan::create([
            'id_pembeli' => $pembeli->id_pengguna,
            'id_kota_tujuan' => $kota->id_kota,
            'subtotal' => 75000,
            'ongkir' => $kota->ongkir,
            'diskon' => 0,
            'total_bayar' => 75000 + $kota->ongkir,
            'status_pesanan' => Pesanan::STATUS_DIKIRIM,
            'bukti_bayar' => 'bukti-bayar/sample_bukti3.jpg',
            'tgl_verifikasi' => now()->subDays(1),
            'id_verifikator' => $petani->id_pengguna,
            'no_resi' => 'JNE' . rand(1000000000, 9999999999),
            'batas_bayar' => now()->subDays(2),
        ]);
        $this->createItem($pesanan4, $produk, 1);
        $this->createEscrow($pesanan4);
        $this->command->line("  ✓ Pesanan #{$pesanan4->id_pesanan} - dikirim");

        // 5. Pesanan Terkirim (siap dikonfirmasi)
        $pesanan5 = Pesanan::create([
            'id_pembeli' => $pembeli->id_pengguna,
            'id_kota_tujuan' => $kota->id_kota,
            'subtotal' => 120000,
            'ongkir' => $kota->ongkir,
            'diskon' => 0,
            'total_bayar' => 120000 + $kota->ongkir,
            'status_pesanan' => Pesanan::STATUS_TERKIRIM,
            'bukti_bayar' => 'bukti-bayar/sample_bukti4.jpg',
            'tgl_verifikasi' => now()->subDays(3),
            'id_verifikator' => $petani->id_pengguna,
            'no_resi' => 'JNT' . rand(1000000000, 9999999999),
            'batas_bayar' => now()->subDays(4),
        ]);
        $this->createItem($pesanan5, $produk, 2);
        $this->createEscrow($pesanan5);
        $this->command->line("  ✓ Pesanan #{$pesanan5->id_pesanan} - terkirim");

        // 6. Pesanan Selesai
        $pesanan6 = Pesanan::create([
            'id_pembeli' => $pembeli->id_pengguna,
            'id_kota_tujuan' => $kota->id_kota,
            'subtotal' => 80000,
            'ongkir' => $kota->ongkir,
            'diskon' => 0,
            'total_bayar' => 80000 + $kota->ongkir,
            'status_pesanan' => Pesanan::STATUS_SELESAI,
            'bukti_bayar' => 'bukti-bayar/sample_bukti5.jpg',
            'tgl_verifikasi' => now()->subDays(7),
            'id_verifikator' => $petani->id_pengguna,
            'no_resi' => 'SICEPAT' . rand(1000000000, 9999999999),
            'tgl_selesai' => now()->subDays(5),
            'id_konfirmasi' => $pembeli->id_pengguna,
            'batas_bayar' => now()->subDays(8),
        ]);
        $this->createItem($pesanan6, $produk, 1);
        $this->command->line("  ✓ Pesanan #{$pesanan6->id_pesanan} - selesai");

        // 7. Pesanan Dibatalkan
        $pesanan7 = Pesanan::create([
            'id_pembeli' => $pembeli->id_pengguna,
            'id_kota_tujuan' => $kota->id_kota,
            'subtotal' => 50000,
            'ongkir' => $kota->ongkir,
            'diskon' => 0,
            'total_bayar' => 50000 + $kota->ongkir,
            'status_pesanan' => Pesanan::STATUS_DIBATALKAN,
            'alasan_batal' => 'Berubah pikiran',
            'tgl_dibatalkan' => now()->subDays(2),
            'batas_bayar' => now()->subDays(3),
        ]);
        $this->createItem($pesanan7, $produk, 1);
        $this->command->line("  ✓ Pesanan #{$pesanan7->id_pesanan} - dibatalkan");

        $this->command->info('✅ PesananSeeder completed! Created 7 sample orders.');
    }

    /**
     * Create order item
     */
    private function createItem(Pesanan $pesanan, Produk $produk, int $qty): void
    {
        ItemPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_produk' => $produk->id_produk,
            'id_petani' => $produk->id_petani,
            'jumlah' => $qty,
            'harga_snapshot' => $produk->harga,
            'subtotal' => $produk->harga * $qty,
        ]);
    }

    /**
     * Create escrow for paid orders
     */
    private function createEscrow(Pesanan $pesanan): void
    {
        Escrow::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'jumlah' => $pesanan->total_bayar,
            'status_escrow' => 'ditahan',
            'tgl_ditahan' => now(),
        ]);
    }
}
