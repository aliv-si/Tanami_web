<x-mail::message>
@if($recipientType === 'pembeli')
# Pesanan Anda Berhasil Dibuat! 🎉

Halo **{{ $pesanan->pembeli->nama_lengkap }}**,

Terima kasih telah berbelanja di TANAMI. Pesanan Anda telah berhasil dibuat.

## Detail Pesanan
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **Tanggal:** {{ $pesanan->tgl_dibuat->format('d M Y, H:i') }}
- **Total Pembayaran:** Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}

## Langkah Selanjutnya
1. Lakukan pembayaran sebelum **{{ $pesanan->batas_bayar?->format('d M Y, H:i') ?? '-' }}**
2. Upload bukti pembayaran
3. Tunggu verifikasi dari petani

<x-mail::button :url="$orderUrl">
Lihat Pesanan
</x-mail::button>

@else
# Pesanan Baru Masuk! 📦

Halo **Petani**,

Anda mendapat pesanan baru dari pembeli.

## Detail Pesanan
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **Pembeli:** {{ $pesanan->pembeli->nama_lengkap ?? '-' }}
- **Tanggal:** {{ $pesanan->tgl_dibuat->format('d M Y, H:i') }}
- **Total:** Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}

Setelah pembeli mengupload bukti pembayaran, Anda dapat memverifikasinya melalui dashboard.

<x-mail::button :url="$orderUrl">
Lihat Pesanan
</x-mail::button>
@endif

Salam,<br>
Tim {{ config('app.name') }}
</x-mail::message>
