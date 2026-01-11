<?php

namespace App\Console\Commands;

use App\Models\Pesanan;
use App\Models\HistoriStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancelTimeoutPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-timeout-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel orders that have exceeded 24-hour payment deadline';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting auto-cancel timeout payment...');

        // Get orders yang sudah timeout (pending, batas_bayar < now, bukti_bayar null)
        $orders = Pesanan::with('items.produk')
            ->timeout()
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No timeout orders found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$orders->count()} timeout orders.");

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

                    // 2. Update status pesanan
                    $order->update([
                        'status_pesanan' => Pesanan::STATUS_DIBATALKAN,
                        'alasan_batal' => 'Timeout pembayaran - 24 jam',
                        'tgl_dibatalkan' => now(),
                    ]);

                    // 3. Log ke histori status
                    HistoriStatus::create([
                        'id_pesanan' => $order->id_pesanan,
                        'status_lama' => $statusLama,
                        'status_baru' => Pesanan::STATUS_DIBATALKAN,
                        'id_pengubah' => null, // System
                        'alasan' => 'Auto-cancel: Timeout pembayaran 24 jam',
                    ]);
                });

                $cancelled++;
                $this->line("  ✓ Order #{$order->id_pesanan} cancelled");
            } catch (\Exception $e) {
                $failed++;
                $this->error("  ✗ Order #{$order->id_pesanan} failed: {$e->getMessage()}");
                Log::error("CancelTimeoutPayment failed for order {$order->id_pesanan}: {$e->getMessage()}");
            }
        }

        $this->info("Completed: {$cancelled} cancelled, {$failed} failed.");

        // Log summary
        Log::info("CancelTimeoutPayment: {$cancelled} orders cancelled, {$failed} failed");

        return $failed > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
