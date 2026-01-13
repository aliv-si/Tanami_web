<x-mail::message>
# Bukti Pembayaran Diunggah 💳

Halo **Petani**,

Pembeli telah mengupload bukti pembayaran untuk pesanan berikut:

## Detail Pesanan
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **Pembeli:** {{ $pesanan->pembeli->nama_lengkap ?? '-' }}
- **Total:** Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
- **Waktu Upload:** {{ now()->format('d M Y, H:i') }}

## Tindakan Diperlukan
Silakan verifikasi bukti pembayaran dan proses pesanan ini segera.

<x-mail::button :url="$verifyUrl">
Verifikasi Pembayaran
</x-mail::button>

Salam,<br>
Tim {{ config('app.name') }}
</x-mail::message>
