<x-mail::message>
@if($recipientType === 'pembeli')
# Pesanan Selesai! 🎉

Halo **{{ $pesanan->pembeli->nama_lengkap ?? 'Pelanggan' }}**,

Terima kasih telah berbelanja di TANAMI! Pesanan Anda telah selesai.

## Ringkasan Pesanan
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **Total:** Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
- **Tanggal Selesai:** {{ $pesanan->tgl_selesai?->format('d M Y, H:i') ?? now()->format('d M Y, H:i') }}

## Bagikan Pengalaman Anda
Bantu petani dan pembeli lain dengan memberikan ulasan untuk produk yang Anda beli.

<x-mail::button :url="$reviewUrl">
Beri Ulasan
</x-mail::button>

Terima kasih telah mendukung petani lokal! 🌱

@else
# Pesanan Selesai - Dana Dikirim! 💰

Halo **Petani**,

Pesanan berikut telah dikonfirmasi selesai oleh pembeli:

## Detail Pesanan
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **Pembeli:** {{ $pesanan->pembeli->nama_lengkap ?? '-' }}
- **Total:** Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}

## Dana Escrow
Dana dari pesanan ini telah dikirimkan ke rekening Anda. Silakan cek saldo rekening Anda.

Terima kasih telah berjualan di TANAMI! 🌾
@endif

Salam,<br>
Tim {{ config('app.name') }}
</x-mail::message>
