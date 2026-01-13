<?php

namespace App\Console\Commands;

use App\Models\Pesanan;
use App\Models\HistoriStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoCompleteOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-complete orders that have been delivered (terkirim) for more than 3 days';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting auto-complete orders...');

        // Get orders yang siap auto-complete
        // Status: terkirim, tgl_update + 3 hari < now
        $orders = Pesanan::with(['items.produk', 'escrow'])
            ->siapAutoComplete()
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No orders ready for auto-complete.');
            return Command::SUCCESS;
        }

        $this->info("Found {$orders->count()} orders ready for auto-complete.");

        $completed = 0;
        $failed = 0;

        foreach ($orders as $order) {
            try {
                DB::transaction(function () use ($order) {
                    $statusLama = $order->status_pesanan;

                    // 1. Update status pesanan
                    $order->update([
                        'status_pesanan' => Pesanan::STATUS_SELESAI,
                        'tgl_selesai_otomatis' => now(),
                        // id_konfirmasi tetap null karena auto-complete oleh system
                    ]);

                    // 2. Release escrow ke petani
                    if ($order->escrow && $order->escrow->status_escrow === 'ditahan') {
                        // Get petani ID dari item pertama
                        $idPetani = $order->items->first()->produk->id_petani ?? null;

                        if ($idPetani) {
                            $order->escrow->kirimKePetani(
                                $idPetani,
                                'Auto-complete: Pembeli tidak konfirmasi dalam 3 hari'
                            );
                        }
                    }

                    // 3. Log ke histori status
                    HistoriStatus::create([
                        'id_pesanan' => $order->id_pesanan,
                        'status_lama' => $statusLama,
                        'status_baru' => Pesanan::STATUS_SELESAI,
                        'id_pengubah' => null, // System
                        'alasan' => 'Auto-complete: Pembeli tidak konfirmasi dalam 3 hari setelah pengiriman',
                    ]);
                });

                $completed++;
                $this->line("  ✓ Order #{$order->id_pesanan} auto-completed");
            } catch (\Exception $e) {
                $failed++;
                $this->error("  ✗ Order #{$order->id_pesanan} failed: {$e->getMessage()}");
                Log::error("AutoCompleteOrder failed for order {$order->id_pesanan}: {$e->getMessage()}");
            }
        }

        $this->info("Completed: {$completed} auto-completed, {$failed} failed.");

        // Log summary
        Log::info("AutoCompleteOrder: {$completed} orders completed, {$failed} failed");

        return $failed > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
