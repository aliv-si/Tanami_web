<?php

namespace App\Mail;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Pesanan $pesanan;
    public string $recipientType; // 'pembeli' or 'petani'

    public function __construct(Pesanan $pesanan, string $recipientType = 'pembeli')
    {
        $this->pesanan = $pesanan;
        $this->recipientType = $recipientType;
    }

    public function envelope(): Envelope
    {
        $subject = $this->recipientType === 'pembeli' 
            ? 'Pesanan Anda Berhasil Dibuat - #' . $this->pesanan->id_pesanan
            : 'Pesanan Baru Masuk - #' . $this->pesanan->id_pesanan;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-created',
            with: [
                'pesanan' => $this->pesanan,
                'recipientType' => $this->recipientType,
                'orderUrl' => $this->recipientType === 'pembeli' 
                    ? url('/pembeli/pesanan/' . $this->pesanan->id_pesanan)
                    : url('/petani/pesanan/' . $this->pesanan->id_pesanan),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
