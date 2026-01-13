<x-mail::message>
# Selamat Datang di TANAMI! 🌱

Halo **{{ $user->nama_lengkap }}**,

Terima kasih telah bergabung dengan TANAMI - Platform E-Commerce yang menghubungkan Anda langsung dengan petani lokal.

@if($user->role_pengguna === 'pembeli')
## Sebagai Pembeli, Anda dapat:
- 🛒 Belanja produk segar langsung dari petani
- 💰 Dapatkan harga terbaik tanpa perantara
- 🚚 Pengiriman cepat ke alamat Anda
@elseif($user->role_pengguna === 'petani')
## Sebagai Petani, Anda dapat:
- 📦 Jual hasil panen langsung ke konsumen
- 💵 Terima pembayaran aman via escrow
- 📊 Pantau penjualan melalui dashboard
@endif

<x-mail::button :url="$loginUrl">
Mulai Sekarang
</x-mail::button>

Jika ada pertanyaan, jangan ragu untuk menghubungi tim support kami.

Salam hangat,<br>
Tim {{ config('app.name') }}
</x-mail::message>
