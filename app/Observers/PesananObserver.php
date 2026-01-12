<?php

namespace App\Observers;

use App\Models\Pesanan;
use App\Models\HistoriStatus;
use Illuminate\Support\Facades\Auth;

class PesananObserver
{
    /**
     * Handle the Pesanan "created" event.
     */
    public function created(Pesanan $pesanan): void
    {
        // Log pembuatan pesanan baru
        HistoriStatus::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status_lama' => null,
            'status_baru' => $pesanan->status_pesanan,
            'id_pengubah' => Auth::id(),
            'alasan' => 'Pesanan baru dibuat',
        ]);
    }

    /**
     * Handle the Pesanan "updated" event.
     */
    public function updated(Pesanan $pesanan): void
    {
        // Cek apakah status_pesanan berubah
        if ($pesanan->isDirty('status_pesanan')) {
            $statusLama = $pesanan->getOriginal('status_pesanan');
            $statusBaru = $pesanan->status_pesanan;

            // Skip jika status tidak berubah
            if ($statusLama === $statusBaru) {
                return;
            }

            // Cek apakah sudah ada log untuk perubahan ini (hindari duplicate)
            $existingLog = HistoriStatus::where('id_pesanan', $pesanan->id_pesanan)
                ->where('status_lama', $statusLama)
                ->where('status_baru', $statusBaru)
                ->where('tgl_dibuat', '>=', now()->subSeconds(5)) // dalam 5 detik terakhir
                ->exists();

            if ($existingLog) {
                return; // Skip duplicate
            }

            // Ambil alasan dari property sementara atau generate otomatis
            $alasan = $pesanan->alasan_log ?? $this->generateReason($statusLama, $statusBaru);

            HistoriStatus::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'status_lama' => $statusLama,
                'status_baru' => $statusBaru,
                'id_pengubah' => Auth::id(), // NULL jika dari system/scheduler
                'alasan' => $alasan,
            ]);

            // Reset alasan_log setelah digunakan
            $pesanan->alasan_log = null;
        }
    }

    /**
     * Generate default reason based on status transition
     */
    private function generateReason(?string $from, string $to): string
    {
        $reasons = [
            'pending' => 'Pesanan dibuat, menunggu pembayaran',
            'menunggu_verifikasi' => 'Bukti pembayaran diupload',
            'dibayar' => 'Pembayaran diverifikasi',
            'diproses' => 'Pesanan sedang diproses',
            'dikirim' => 'Pesanan dikirim',
            'terkirim' => 'Pesanan sampai tujuan',
            'selesai' => 'Pesanan selesai',
            'dibatalkan' => 'Pesanan dibatalkan',
            'minta_refund' => 'Permintaan refund diajukan',
            'direfund' => 'Refund diproses',
        ];

        return $reasons[$to] ?? "Status berubah dari {$from} ke {$to}";
    }

    /**
     * Handle the Pesanan "deleted" event.
     */
    public function deleted(Pesanan $pesanan): void
    {
        // Log penghapusan pesanan (jika diperlukan)
        HistoriStatus::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status_lama' => $pesanan->status_pesanan,
            'status_baru' => 'deleted',
            'id_pengubah' => Auth::id(),
            'alasan' => 'Pesanan dihapus',
        ]);
    }
}
