@extends('layouts.petani')

@section('title', 'Detail Pesanan #' . $pesanan->id_pesanan)

@section('content')
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-8 py-4">
        <div class="flex items-center gap-4">
            <a href="{{ url('/pesanan') }}" class="p-2 hover:bg-gray-100 rounded-full text-gray-500">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold font-heading text-text-dark">Detail Pesanan</h1>
                <span class="text-gray-400 font-medium font-heading">#{{ $pesanan->id_pesanan }}</span>
                @switch($pesanan->status_pesanan)
                    @case('menunggu_verifikasi')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">Menunggu Verifikasi</span>
                        @break
                    @case('dibayar')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">Dibayar</span>
                        @break
                    @case('diproses')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700">Diproses</span>
                        @break
                    @case('dikirim')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-700">Dikirim</span>
                        @break
                    @case('selesai')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-[#53be20]/10 text-[#53be20]">Selesai</span>
                        @break
                    @case('dibatalkan')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">Dibatalkan</span>
                        @break
                    @default
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-700">{{ ucfirst(str_replace('_', ' ', $pesanan->status_pesanan)) }}</span>
                @endswitch
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="flex items-center gap-2 px-4 py-2 border border-gray-200 rounded-lg text-sm font-semibold hover:bg-gray-50">
                <span class="material-symbols-outlined text-lg">print</span> Cetak Invoice
            </button>
        </div>
    </div>
</header>

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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Buyer Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h2 class="text-lg font-bold font-heading">Informasi Pembeli</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Nama Pembeli</p>
                            <p class="font-semibold text-text-dark">{{ $pesanan->pembeli->nama_lengkap ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Nomor Telepon</p>
                            <p class="font-semibold text-text-dark">{{ $pesanan->pembeli->no_hp ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Alamat Pengiriman</p>
                            <p class="font-semibold text-text-dark leading-relaxed">
                                {{ $pesanan->alamat_lengkap }}<br>
                                {{ $pesanan->kota->nama_kota ?? '' }} {{ $pesanan->kode_pos }}
                            </p>
                        </div>
                        @if($pesanan->catatan_pembeli)
                        <div class="md:col-span-2">
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Catatan Pembeli</p>
                            <p class="font-semibold text-text-dark">{{ $pesanan->catatan_pembeli }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">inventory_2</span>
                    <h2 class="text-lg font-bold font-heading">Daftar Produk</h2>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($pesanan->items as $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div class="flex items-center gap-4">
                            @if($item->produk && $item->produk->foto)
                                <img alt="{{ $item->produk->nama_produk }}" class="w-16 h-16 rounded-lg object-cover" src="{{ asset('storage/produk/' . $item->produk->foto) }}"/>
                            @else
                                <div class="w-16 h-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-gray-400">image</span>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-bold font-heading text-text-dark">{{ $item->produk->nama_produk ?? 'Produk' }}</h3>
                                <p class="text-sm text-gray-500">{{ $item->produk->kategori->nama_kategori ?? '' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-500">{{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
                            <p class="font-bold text-text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Timeline -->
            @if($pesanan->historiStatus && $pesanan->historiStatus->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    <h2 class="text-lg font-bold font-heading">Riwayat Status</h2>
                </div>
                <div class="p-8">
                    <div class="relative space-y-8">
                        <div class="absolute left-[11px] top-0 h-full w-[2px] bg-gray-100"></div>
                        @foreach($pesanan->historiStatus->sortByDesc('tgl_diubah') as $histori)
                        <div class="relative flex gap-6">
                            <div class="w-6 h-6 rounded-full bg-primary flex items-center justify-center z-10">
                                <span class="material-symbols-outlined text-white text-xs">check</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-text-dark">{{ ucfirst(str_replace('_', ' ', $histori->status_baru)) }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $histori->tgl_diubah->format('d M Y - H:i') }}</p>
                                @if($histori->alasan)
                                    <p class="text-xs text-gray-400 mt-1">{{ $histori->alasan }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">receipt_long</span>
                    <h2 class="text-lg font-bold font-heading">Ringkasan Pesanan</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal ({{ $pesanan->items->count() }} produk)</span>
                        <span class="font-medium text-text-dark">Rp {{ number_format($subtotalPetani, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex justify-between">
                        <span class="font-bold text-text-dark">Total Bagian Anda</span>
                        <span class="font-bold text-2xl text-text-dark">Rp {{ number_format($subtotalPetani, 0, ',', '.') }}</span>
                    </div>
                    @if($pesanan->escrow)
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-primary text-lg">lock</span>
                            <span class="text-gray-500">Status Escrow:</span>
                            <span class="font-semibold text-primary">{{ ucfirst(str_replace('_', ' ', $pesanan->escrow->status_escrow)) }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">local_shipping</span>
                    <h2 class="text-lg font-bold font-heading">Aksi Pesanan</h2>
                </div>
                <div class="p-6 space-y-4">
                    @if($pesanan->status_pesanan == 'menunggu_verifikasi')
                        <!-- Bukti Pembayaran -->
                        @if($pesanan->bukti_transfer)
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Bukti Pembayaran:</p>
                            <a href="{{ asset('storage/bukti_transfer/' . $pesanan->bukti_transfer) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/bukti_transfer/' . $pesanan->bukti_transfer) }}" alt="Bukti Transfer" class="w-full max-h-48 object-contain rounded-lg border border-gray-200"/>
                            </a>
                        </div>
                        @endif

                        <form action="{{ url('/pesanan/' . $pesanan->id_pesanan . '/verifikasi') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-bold font-heading hover:bg-primary/90 transition-all shadow-md shadow-primary/20 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-xl">check_circle</span>
                                Verifikasi Pembayaran
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('tolak-modal').classList.remove('hidden')" class="w-full py-3 rounded-xl font-bold font-heading text-red-500 border border-red-200 hover:bg-red-50 transition-all">
                            Tolak Pembayaran
                        </button>

                    @elseif($pesanan->status_pesanan == 'dibayar')
                        <form action="{{ url('/pesanan/' . $pesanan->id_pesanan . '/proses') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold font-heading hover:bg-blue-700 transition-all shadow-md flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-xl">sync</span>
                                Proses Pesanan
                            </button>
                        </form>

                    @elseif($pesanan->status_pesanan == 'diproses')
                        <form action="{{ url('/pesanan/' . $pesanan->id_pesanan . '/kirim') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2" for="no_resi">Nomor Resi</label>
                                <input class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary" id="no_resi" name="no_resi" placeholder="Masukkan nomor resi..." type="text" required/>
                            </div>
                            <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-xl font-bold font-heading hover:bg-purple-700 transition-all shadow-md flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-xl">local_shipping</span>
                                Kirim Pesanan
                            </button>
                        </form>

                    @elseif($pesanan->status_pesanan == 'dikirim')
                        <div class="p-4 bg-purple-50 rounded-lg">
                            <p class="text-sm font-semibold text-purple-700 mb-1">Pesanan Dalam Pengiriman</p>
                            @if($pesanan->no_resi)
                                <p class="text-xs text-purple-600">Nomor Resi: <span class="font-bold">{{ $pesanan->no_resi }}</span></p>
                            @endif
                            <p class="text-xs text-purple-600 mt-2">Menunggu konfirmasi penerimaan dari pembeli</p>
                        </div>

                    @elseif($pesanan->status_pesanan == 'selesai')
                        <div class="p-4 bg-green-50 rounded-lg">
                            <p class="text-sm font-semibold text-green-700 mb-1">Pesanan Selesai</p>
                            <p class="text-xs text-green-600">Dana telah/akan dicairkan ke rekening Anda</p>
                        </div>

                    @elseif($pesanan->status_pesanan == 'dibatalkan')
                        <div class="p-4 bg-red-50 rounded-lg">
                            <p class="text-sm font-semibold text-red-700 mb-1">Pesanan Dibatalkan</p>
                            @if($pesanan->alasan_batal)
                                <p class="text-xs text-red-600">{{ $pesanan->alasan_batal }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
@if($pesanan->status_pesanan == 'menunggu_verifikasi')
<div id="tolak-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold font-heading mb-4">Tolak Pembayaran</h3>
        <form action="{{ url('/pesanan/' . $pesanan->id_pesanan . '/tolak') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Penolakan <span class="text-red-500">*</span></label>
                <textarea name="alasan" required rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary" placeholder="Jelaskan alasan penolakan..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('tolak-modal').classList.add('hidden')" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg font-semibold text-gray-600 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection