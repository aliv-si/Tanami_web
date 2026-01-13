<x-mail::message>
# Pembayaran Terverifikasi! ✅

Halo **{{ $pesanan->pembeli->nama_lengkap ?? 'Pelanggan' }}**,

Kabar baik! Pembayaran Anda untuk pesanan berikut telah diverifikasi:

## Detail Pesanan
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **Total:** Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
- **Diverifikasi pada:** {{ $pesanan->tgl_verifikasi?->format('d M Y, H:i') ?? now()->format('d M Y, H:i') }}

## Langkah Selanjutnya
Pesanan Anda sedang diproses oleh petani. Anda akan menerima notifikasi saat pesanan dikirim.

<x-mail::button :url="$trackUrl">
Lacak Pesanan
</x-mail::button>

Terima kasih telah berbelanja di TANAMI! 🌱

Salam,<br>
Tim {{ config('app.name') }}
</x-mail::message>
