<?php

namespace Database\Seeders;

use App\Models\ItemPesanan;
use App\Models\Pesanan;
use App\Models\Ulasan;
use Illuminate\Database\Seeder;

class UlasanSeeder extends Seeder
{
    /**
     * Sample reviews for seeding
     */
    private array $sampleUlasan = [
        5 => [
            'Produk sangat segar dan berkualitas! Pengiriman juga cepat. Recommended!',
            'Mantap! Wortelnya manis dan renyah. Pasti order lagi.',
            'Sayuran organik terbaik yang pernah saya beli. Petani ramah dan responsif.',
            'Kualitas premium, packaging rapi. Worth every penny!',
            'Sudah langganan dari dulu, tidak pernah mengecewakan. Terima kasih!',
        ],
        4 => [
            'Produk bagus, pengiriman agak lama tapi overall puas.',
            'Kualitas oke, harga bersaing. Next time order lebih banyak.',
            'Sayuran segar, cuma packagingnya bisa lebih ditingkatkan.',
            'Rasa enak, ukuran sesuai deskripsi. Good job!',
            'Pengalaman belanja menyenangkan, produk sesuai ekspektasi.',
        ],
        3 => [
            'Produk cukup baik, tapi ada beberapa yang kurang segar.',
            'Standar lah, tidak istimewa tapi juga tidak mengecewakan.',
            'Lumayan untuk harga segitu. Bisa lebih ditingkatkan lagi.',
        ],
        2 => [
            'Produk tidak sesuai foto, ukuran lebih kecil dari ekspektasi.',
            'Kurang puas, beberapa sayuran sudah layu saat diterima.',
        ],
        1 => [
            'Sangat mengecewakan, produk rusak dan tidak layak konsumsi.',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get completed orders with their items
        $pesananSelesai = Pesanan::where('status_pesanan', Pesanan::STATUS_SELESAI)
            ->with(['items.produk', 'pembeli'])
            ->get();

        if ($pesananSelesai->isEmpty()) {
            $this->command->warn('Tidak ada pesanan selesai. Jalankan PesananSeeder terlebih dahulu!');
            return;
        }

        $this->command->info('Creating reviews for completed orders...');

        $createdCount = 0;

        foreach ($pesananSelesai as $pesanan) {
            foreach ($pesanan->items as $item) {
                // Skip if review already exists for this item
                if (Ulasan::where('id_item_pesanan', $item->id_item)->exists()) {
                    $this->command->line("  ⏭ Item #{$item->id_item} sudah punya ulasan, skip.");
                    continue;
                }

                // Generate random rating (weighted towards positive reviews)
                $rating = $this->getWeightedRating();

                // Get random comment for this rating
                $komentar = $this->getRandomKomentar($rating);

                // Create review
                Ulasan::create([
                    'id_item_pesanan' => $item->id_item,
                    'id_pengguna' => $pesanan->id_pembeli,
                    'id_produk' => $item->id_produk,
                    'rating' => $rating,
                    'komentar' => $komentar,
                    'tgl_dibuat' => $pesanan->tgl_selesai?->addHours(rand(1, 72)) ?? now(),
                ]);

                $this->command->line("  ✓ Ulasan untuk \"{$item->produk->nama_produk}\" - Rating: {$rating}⭐");
                $createdCount++;
            }
        }

        $this->command->info("✅ UlasanSeeder completed! Created {$createdCount} reviews.");
    }

    /**
     * Get weighted random rating (more positive reviews)
     */
    private function getWeightedRating(): int
    {
        $weights = [
            5 => 40, // 40% chance
            4 => 30, // 30% chance
            3 => 15, // 15% chance
            2 => 10, // 10% chance
            1 => 5,  // 5% chance
        ];

        $rand = rand(1, 100);
        $cumulative = 0;

        foreach ($weights as $rating => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $rating;
            }
        }

        return 5;
    }

    /**
     * Get random comment for given rating
     */
    private function getRandomKomentar(int $rating): string
    {
        $comments = $this->sampleUlasan[$rating] ?? $this->sampleUlasan[5];
        return $comments[array_rand($comments)];
    }
}
