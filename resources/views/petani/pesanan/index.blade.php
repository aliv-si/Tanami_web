@extends('layouts.petani')

@section('title', 'Pesanan')

@section('content')
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-8 py-4">
        <h1 class="text-2xl font-bold font-heading text-text-dark">Pesanan Masuk</h1>
        <div class="flex items-center gap-6">
            <div class="relative hidden lg:block">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input class="pl-10 pr-4 py-2 bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary w-80" placeholder="Cari ID Pesanan atau nama pembeli..." type="text"/>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full">
                    <span class="material-symbols-outlined">notifications</span>
                    @if($statusCounts['menunggu_verifikasi'] > 0)
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    @endif
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Status Tabs -->
<div class="bg-white border-b border-gray-200 px-8">
    <nav class="flex gap-6 -mb-px">
        <a href="{{ route('petani.pesanan') }}" class="py-4 px-1 border-b-2 {{ !$currentStatus ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }} font-semibold text-sm transition-all">
            Semua Aktif
        </a>
        <a href="{{ route('petani.pesanan', ['status' => 'menunggu_verifikasi']) }}" class="py-4 px-1 border-b-2 {{ $currentStatus == 'menunggu_verifikasi' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }} font-semibold text-sm transition-all flex items-center gap-2">
            Menunggu Verifikasi
            @if($statusCounts['menunggu_verifikasi'] > 0)
                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $statusCounts['menunggu_verifikasi'] }}</span>
            @endif
        </a>
        <a href="{{ route('petani.pesanan', ['status' => 'dibayar']) }}" class="py-4 px-1 border-b-2 {{ $currentStatus == 'dibayar' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }} font-semibold text-sm transition-all flex items-center gap-2">
            Dibayar
            @if($statusCounts['dibayar'] > 0)
                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $statusCounts['dibayar'] }}</span>
            @endif
        </a>
        <a href="{{ route('petani.pesanan', ['status' => 'diproses']) }}" class="py-4 px-1 border-b-2 {{ $currentStatus == 'diproses' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }} font-semibold text-sm transition-all flex items-center gap-2">
            Diproses
            @if($statusCounts['diproses'] > 0)
                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $statusCounts['diproses'] }}</span>
            @endif
        </a>
        <a href="{{ route('petani.pesanan', ['status' => 'dikirim']) }}" class="py-4 px-1 border-b-2 {{ $currentStatus == 'dikirim' ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700' }} font-semibold text-sm transition-all flex items-center gap-2">
            Dikirim
            @if($statusCounts['dikirim'] > 0)
                <span class="bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $statusCounts['dikirim'] }}</span>
            @endif
        </a>
        <a href="{{ route('petani.pesanan', ['semua' => 1]) }}" class="py-4 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-semibold text-sm transition-all">
            Semua Riwayat
        </a>
    </nav>
</div>

<div class="p-8 max-w-[1400px] mx-auto">
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined">error</span>
            {{ session('error') }}
        </div>
    @endif

    @if($pesanan->count() > 0)
    <div class="space-y-4">
        @foreach($pesanan as $order)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-heading font-bold text-text-dark">#{{ $order->id_pesanan }}</span>
                                @switch($order->status_pesanan)
                                    @case('menunggu_pembayaran')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Menunggu Pembayaran</span>
                                        @break
                                    @case('menunggu_verifikasi')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                        @break
                                    @case('dibayar')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Dibayar</span>
                                        @break
                                    @case('diproses')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Diproses</span>
                                        @break
                                    @case('dikirim')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Dikirim</span>
                                        @break
                                    @case('selesai')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#53be20]/10 text-[#53be20]">Selesai</span>
                                        @break
                                    @case('dibatalkan')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Dibatalkan</span>
                                        @break
                                    @default
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                @endswitch
                            </div>
                            <p class="text-sm text-gray-500">{{ $order->tgl_dibuat->format('d M Y, H:i') }} • {{ $order->pembeli->nama_lengkap ?? 'Pembeli' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-heading font-bold text-lg text-text-dark">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400">{{ $order->items->count() }} produk</p>
                    </div>
                </div>

                <!-- Products Preview -->
                <div class="flex items-center gap-3 py-3 border-t border-gray-100">
                    @foreach($order->items->take(3) as $item)
                    <div class="flex items-center gap-2">
                        @if($item->produk && $item->produk->foto)
                            <img src="{{ asset('storage/produk/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk ?? '' }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100"/>
                        @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <span class="material-symbols-outlined text-gray-400 text-sm">image</span>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-text-dark">{{ $item->produk->nama_produk ?? 'Produk' }}</p>
                            <p class="text-xs text-gray-400">{{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                    @if($order->items->count() > 3)
                        <span class="text-xs text-gray-400">+{{ $order->items->count() - 3 }} lainnya</span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ url('/pesanan/' . $order->id_pesanan) }}" class="text-primary font-semibold text-sm hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-lg">visibility</span>
                        Lihat Detail
                    </a>
                    <div class="flex items-center gap-2">
                        @if($order->status_pesanan == 'menunggu_verifikasi')
                            <form action="{{ url('/pesanan/' . $order->id_pesanan . '/verifikasi') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary/90 transition-all">
                                    Verifikasi Pembayaran
                                </button>
                            </form>
                        @elseif($order->status_pesanan == 'dibayar')
                            <form action="{{ url('/pesanan/' . $order->id_pesanan . '/proses') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-all">
                                    Proses Pesanan
                                </button>
                            </form>
                        @elseif($order->status_pesanan == 'diproses')
                            <button type="button" onclick="document.getElementById('kirim-modal-{{ $order->id_pesanan }}').classList.remove('hidden')" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-semibold hover:bg-purple-700 transition-all">
                                Input Resi & Kirim
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Kirim -->
        @if($order->status_pesanan == 'diproses')
        <div id="kirim-modal-{{ $order->id_pesanan }}" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <h3 class="text-lg font-bold font-heading mb-4">Input Nomor Resi</h3>
                <form action="{{ url('/pesanan/' . $order->id_pesanan . '/kirim') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Resi <span class="text-red-500">*</span></label>
                        <input type="text" name="no_resi" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary" placeholder="Masukkan nomor resi pengiriman"/>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" onclick="this.closest('.fixed').classList.add('hidden')" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg font-semibold text-gray-600 hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90">
                            Kirim Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    <div class="mt-6">
        {{ $pesanan->links() }}
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-gray-400 text-3xl">shopping_cart</span>
        </div>
        <h3 class="font-heading font-bold text-gray-600 mb-2">Belum ada pesanan</h3>
        <p class="text-sm text-gray-400">Pesanan baru akan muncul di sini</p>
    </div>
    @endif
</div>
@endsection