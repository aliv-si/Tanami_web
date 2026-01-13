<x-mail::message>
# Refund Disetujui! ✅

Halo **{{ $pesanan->pembeli->nama_lengkap ?? 'Pelanggan' }}**,

Permintaan refund Anda telah disetujui.

## Detail Refund
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **Jumlah Refund:** Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}
- **Status:** Disetujui

## Proses Pengembalian Dana
Dana akan dikembalikan sesuai dengan metode pembayaran awal Anda. Proses ini biasanya memakan waktu 3-7 hari kerja.

<x-mail::button :url="$orderUrl">
Lihat Detail Pesanan
</x-mail::button>

Kami mohon maaf atas ketidaknyamanan yang terjadi. Terima kasih atas pengertian Anda.

Salam,<br>
Tim {{ config('app.name') }}
</x-mail::message>
