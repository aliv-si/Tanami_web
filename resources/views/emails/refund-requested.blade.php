<x-mail::message>
# ⚠️ Permintaan Refund Baru

Halo **Admin**,

Ada permintaan refund baru yang perlu ditinjau:

## Detail Pesanan
- **No. Pesanan:** #{{ $pesanan->id_pesanan }}
- **Pembeli:** {{ $pesanan->pembeli->nama_lengkap ?? '-' }}
- **Email:** {{ $pesanan->pembeli->email ?? '-' }}
- **Total:** Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}

## Alasan Refund
{{ $pesanan->alasan_refund ?? 'Tidak ada alasan yang diberikan.' }}

## Tindakan Diperlukan
Silakan tinjau permintaan ini dan ambil keputusan.

<x-mail::button :url="$adminUrl">
Proses Refund
</x-mail::button>

Salam,<br>
Sistem {{ config('app.name') }}
</x-mail::message>
