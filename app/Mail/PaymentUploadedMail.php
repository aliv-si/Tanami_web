<?php

namespace App\Mail;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentUploadedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Pesanan $pesanan;

    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Pembayaran Diunggah - Pesanan #' . $this->pesanan->id_pesanan,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-uploaded',
            with: [
                'pesanan' => $this->pesanan,
                'verifyUrl' => url('/petani/pesanan/' . $this->pesanan->id_pesanan),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
