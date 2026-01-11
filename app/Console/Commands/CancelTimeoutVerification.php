<?php

namespace App\Console\Commands;

use App\Models\Pesanan;
use App\Models\HistoriStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancelTimeoutVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-timeout-verification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel orders stuck in menunggu_verifikasi for more than 48 hours';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting auto-cancel timeout verification...');

        // Get orders yang sudah timeout verifikasi
        // Status: menunggu_verifikasi, tgl_update + 48 jam < now
        $orders = Pesanan::with(['items.produk', 'escrow'])
            ->where('status_pesanan', Pesanan::STATUS_MENUNGGU_VERIFIKASI)
            ->where('tgl_update', '<', now()->subHours(48))
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No timeout verification orders found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$orders->count()} timeout verification orders.");

        $cancelled = 0;
        $failed = 0;

        foreach ($orders as $order) {
            try {
                DB::transaction(function () use ($order) {
                    $statusLama = $order->status_pesanan;

                    // 1. Release reserved stock untuk semua item
                    foreach ($order->items as $item) {
                        if ($item->produk) {
                            $item->produk->releaseStok($item->jumlah);
                        }
                    }

                    // 2. Refund escrow jika ada (seharusnya belum ada di tahap ini)
                    if ($order->escrow && $order->escrow->status_escrow === 'ditahan') {
                        $order->escrow->refundKePembeli(
                            $order->id_pembeli,
                            'Auto-refund: Petani tidak merespon dalam 48 jam'
                        );
                    }

                    // 3. Update status pesanan
                    $order->update([
                        'status_pesanan' => Pesanan::STATUS_DIBATALKAN,
                        'alasan_batal' => 'Petani tidak merespon dalam 48 jam',
                        'tgl_dibatalkan' => now(),
                    ]);

                    // 4. Log ke histori status
                    HistoriStatus::create([
                        'id_pesanan' => $order->id_pesanan,
                        'status_lama' => $statusLama,
                        'status_baru' => Pesanan::STATUS_DIBATALKAN,
                        'id_pengubah' => null, // System
                        'alasan' => 'Auto-cancel: Farmer no response - timeout 48 hours',
                    ]);
                });

                $cancelled++;
                $this->line("  ✓ Order #{$order->id_pesanan} cancelled");
            } catch (\Exception $e) {
                $failed++;
                $this->error("  ✗ Order #{$order->id_pesanan} failed: {$e->getMessage()}");
                Log::error("CancelTimeoutVerification failed for order {$order->id_pesanan}: {$e->getMessage()}");
            }
        }

        $this->info("Completed: {$cancelled} cancelled, {$failed} failed.");

        // Log summary
        Log::info("CancelTimeoutVerification: {$cancelled} orders cancelled, {$failed} failed");

        return $failed > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
