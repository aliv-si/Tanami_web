<x-mail::message>
# Pesanan Anda Sedang Dikirim! 🚚

Halo **{{ $pesanan->pembeli->nama_lengkap ?? 'Pelanggan' }}**,

Pesanan Anda sudah dalam perjalanan!

## Detail Pengiriman
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **No. Resi:** {{ $pesanan->no_resi ?? '-' }}
- **Ekspedisi:** {{ $pesanan->ekspedisi ?? 'Kurir Lokal' }}

## Alamat Tujuan
{{ $pesanan->alamat_kirim ?? $pesanan->pembeli->alamat ?? '-' }}
{{ $pesanan->kota->nama_kota ?? '' }}, {{ $pesanan->kota->provinsi ?? '' }}

<x-mail::button :url="$trackUrl">
Lacak Pesanan
</x-mail::button>

Setelah pesanan diterima, jangan lupa untuk konfirmasi penerimaan agar dana dapat diteruskan ke petani.

Salam,<br>
Tim {{ config('app.name') }}
</x-mail::message>
