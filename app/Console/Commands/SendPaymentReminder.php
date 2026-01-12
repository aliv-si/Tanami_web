<?php

namespace App\Console\Commands;

use App\Models\Pesanan;
use App\Mail\PaymentReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:send-payment-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payment reminder email for orders approaching deadline (within 6 hours)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting payment reminder...');

        // Get orders yang akan timeout dalam 6 jam
        // Status: pending, batas_bayar - 6 jam < now < batas_bayar, bukti_bayar null
        $orders = Pesanan::with(['pembeli', 'items.produk', 'kota'])
            ->where('status_pesanan', Pesanan::STATUS_PENDING)
            ->whereNull('bukti_bayar')
            ->where('batas_bayar', '>', now()) // Belum expired
            ->where('batas_bayar', '<', now()->addHours(6)) // Akan expire dalam 6 jam
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No orders need reminder.');
            return Command::SUCCESS;
        }

        $this->info("Found {$orders->count()} orders approaching deadline.");

        $sent = 0;
        $failed = 0;

        foreach ($orders as $order) {
            try {
                // Cek apakah pembeli punya email
                if (!$order->pembeli || !$order->pembeli->email) {
                    $this->warn("  ⚠ Order #{$order->id_pesanan}: No email address");
                    continue;
                }

                // Kirim email
                Mail::to($order->pembeli->email)->send(new PaymentReminderMail($order));

                $sent++;
                $this->line("  ✓ Order #{$order->id_pesanan}: Reminder sent to {$order->pembeli->email}");
            } catch (\Exception $e) {
                $failed++;
                $this->error("  ✗ Order #{$order->id_pesanan} failed: {$e->getMessage()}");
                Log::error("SendPaymentReminder failed for order {$order->id_pesanan}: {$e->getMessage()}");
            }
        }

        $this->info("Completed: {$sent} sent, {$failed} failed.");

        // Log summary
        Log::info("SendPaymentReminder: {$sent} emails sent, {$failed} failed");

        return $failed > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
