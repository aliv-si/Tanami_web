@extends('layouts.admin')

@php $active = 'pengguna'; @endphp

@section('title', 'Tanami - Detail Pengguna')
@section('header_title', 'Detail Pengguna')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-6">

        {{-- Breadcrumb & Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex items-center text-sm font-medium text-gray-500">
                    <a class="hover:text-tanami-dark transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span class="material-symbols-outlined text-sm mx-2">chevron_right</span>
                    <a class="hover:text-tanami-dark transition-colors" href="{{ route('admin.pengguna') }}">User Management</a>
                    <span class="material-symbols-outlined text-sm mx-2">chevron_right</span>
                    <span class="text-primary font-semibold">Detail</span>
                </nav>
                <h2 class="text-2xl font-heading font-extrabold text-tanami-dark">Detail Pengguna</h2>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.pengguna') }}"
                    class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Kembali
                </a>
                
                {{-- Verify Button (only for unverified petani) --}}
                @if($pengguna->isPetani() && !$pengguna->is_verified)
                <form action="{{ route('admin.pengguna.verify', $pengguna->id_pengguna) }}" method="POST"
                      onsubmit="return confirm('Verifikasi akun petani ini?');">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-green-700 shadow-sm shadow-green-200 transition-all">
                        <span class="material-symbols-outlined text-lg">verified</span>
                        Verifikasi
                    </button>
                </form>
                @endif
                
                {{-- Delete Button --}}
                @if(!$pengguna->isAdmin())
                <form action="{{ route('admin.pengguna.destroy', $pengguna->id_pengguna) }}" method="POST"
                      onsubmit="return confirm('Hapus pengguna ini? Aksi ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2.5 border border-red-200 text-red-600 rounded-xl text-sm font-bold hover:bg-red-50 transition-colors">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined text-red-600">error</span>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: Profile Card --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 p-6 sticky top-6">
                    <div class="flex flex-col items-center text-center pb-6 border-b border-gray-50">
                        <div class="relative mb-4">
                            <img alt="{{ $pengguna->nama_lengkap }}"
                                class="size-24 rounded-full object-cover border-4 border-gray-50"
                                src="https://ui-avatars.com/api/?name={{ urlencode($pengguna->nama_lengkap) }}&size=200&background=random" />
                            @if($pengguna->is_verified)
                            <div class="absolute bottom-1 right-1 bg-green-500 border-2 border-white size-6 rounded-full flex items-center justify-center"
                                title="Verified">
                                <span class="material-symbols-outlined text-white text-[14px] font-bold">check</span>
                            </div>
                            @endif
                        </div>
                        <h3 class="text-xl font-heading font-bold text-tanami-dark mb-1">{{ $pengguna->nama_lengkap }}</h3>
                        <p class="text-gray-400 text-sm font-medium mb-4">{{ $pengguna->email }}</p>
                        <div class="flex items-center gap-2 flex-wrap justify-center">
                            {{-- Role Badge --}}
                            @if($pengguna->isPetani())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 uppercase tracking-wide border border-green-100">
                                <span class="material-symbols-outlined text-sm">agriculture</span> Petani
                            </span>
                            @elseif($pengguna->isPembeli())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-700 uppercase tracking-wide border border-orange-100">
                                <span class="material-symbols-outlined text-sm">shopping_cart</span> Pembeli
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 uppercase tracking-wide border border-blue-100">
                                <span class="material-symbols-outlined text-sm">admin_panel_settings</span> Admin
                            </span>
                            @endif
                            
                            {{-- Verification Status Badge --}}
                            @if($pengguna->is_verified)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 uppercase tracking-wide border border-green-100">
                                Verified
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 uppercase tracking-wide border border-amber-100">
                                Pending
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="pt-6 space-y-5">
                        {{-- Phone --}}
                        <div class="flex items-start gap-4">
                            <div class="size-9 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-lg">call</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">No. Telepon</p>
                                <p class="text-sm font-semibold text-tanami-dark">{{ $pengguna->no_hp ?? '-' }}</p>
                            </div>
                        </div>
                        {{-- Joined Date --}}
                        <div class="flex items-start gap-4">
                            <div class="size-9 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-lg">calendar_month</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Tanggal Daftar</p>
                                <p class="text-sm font-semibold text-tanami-dark">{{ \Carbon\Carbon::parse($pengguna->tgl_daftar)->format('d M Y') }}</p>
                            </div>
                        </div>
                        {{-- Location --}}
                        <div class="flex items-start gap-4">
                            <div class="size-9 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-lg">location_on</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Alamat</p>
                                <p class="text-sm font-semibold text-tanami-dark">{{ $pengguna->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Details --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Statistics Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if($pengguna->isPembeli() && isset($relatedData['totalBelanja']))
                    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Belanja</p>
                                <p class="text-lg font-heading font-bold text-tanami-dark">Rp {{ number_format($relatedData['totalBelanja'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($pengguna->isPetani() && isset($relatedData['totalProduk']))
                    <div class="bg-white rounded-xl p-5 border border-gray-100 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-lg bg-green-50 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined">inventory_2</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total Produk</p>
                                <p class="text-lg font-heading font-bold text-tanami-dark">{{ $relatedData['totalProduk'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Pesanan Terakhir (untuk Pembeli) --}}
                @if($pengguna->isPembeli() && isset($relatedData['pesanan']) && $relatedData['pesanan']->count() > 0)
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 overflow-hidden">
                    <div class="p-6 border-b border-gray-50">
                        <h3 class="text-lg font-heading font-bold text-tanami-dark">Pesanan Terakhir</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1">10 pesanan terakhir dari pembeli ini</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider border-b border-gray-50">
                                    <th class="px-6 py-4">ID Pesanan</th>
                                    <th class="px-6 py-4">Tanggal</th>
                                    <th class="px-6 py-4">Total</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @foreach($relatedData['pesanan'] as $pesanan)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4 font-semibold text-tanami-dark">#{{ $pesanan->id_pesanan }}</td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">{{ \Carbon\Carbon::parse($pesanan->tgl_dibuat)->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 font-bold text-tanami-dark">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-50 text-amber-700',
                                                'dibayar' => 'bg-blue-50 text-blue-700',
                                                'diproses' => 'bg-indigo-50 text-indigo-700',
                                                'dikirim' => 'bg-purple-50 text-purple-700',
                                                'selesai' => 'bg-green-50 text-green-700',
                                                'dibatalkan' => 'bg-red-50 text-red-700',
                                                'direfund' => 'bg-gray-100 text-gray-700',
                                            ];
                                            $color = $statusColors[$pesanan->status_pesanan] ?? 'bg-gray-100 text-gray-700';
                                        @endphp
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $color }}">
                                            {{ ucfirst($pesanan->status_pesanan) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{-- Produk (untuk Petani) --}}
                @if($pengguna->isPetani() && isset($relatedData['produk']) && $relatedData['produk']->count() > 0)
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 overflow-hidden">
                    <div class="p-6 border-b border-gray-50">
                        <h3 class="text-lg font-heading font-bold text-tanami-dark">Produk</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1">10 produk terakhir dari petani ini</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider border-b border-gray-50">
                                    <th class="px-6 py-4">Produk</th>
                                    <th class="px-6 py-4">Harga</th>
                                    <th class="px-6 py-4">Stok</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @foreach($relatedData['produk'] as $produk)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img class="size-10 rounded-lg object-cover border border-gray-100" 
                                                 src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : 'https://ui-avatars.com/api/?name=' . urlencode($produk->nama_produk) . '&background=22c55e&color=fff' }}" 
                                                 alt="{{ $produk->nama_produk }}">
                                            <span class="font-semibold text-tanami-dark">{{ $produk->nama_produk }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-tanami-dark">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $produk->stok }} {{ $produk->satuan }}</td>
                                    <td class="px-6 py-4">
                                        @if($produk->is_active)
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 uppercase tracking-wide">Aktif</span>
                                        @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 uppercase tracking-wide">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                {{-- Rekening Bank (untuk Petani) --}}
                @if($pengguna->isPetani() && isset($relatedData['rekening']) && $relatedData['rekening']->count() > 0)
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 overflow-hidden">
                    <div class="p-6 border-b border-gray-50">
                        <h3 class="text-lg font-heading font-bold text-tanami-dark">Rekening Bank</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1">Daftar rekening bank petani</p>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($relatedData['rekening'] as $rek)
                        <div class="border border-gray-100 rounded-xl p-4 {{ $rek->is_utama ? 'bg-green-50/50 border-green-200' : 'bg-gray-50' }}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-tanami-dark">{{ $rek->nama_bank }}</span>
                                @if($rek->is_utama)
                                <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded-full uppercase">Utama</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600">{{ $rek->no_rekening }}</p>
                            <p class="text-xs text-gray-400 mt-1">a.n. {{ $rek->nama_pemilik }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Empty State jika tidak ada data terkait --}}
                @if(
                    ($pengguna->isPembeli() && (!isset($relatedData['pesanan']) || $relatedData['pesanan']->count() == 0)) ||
                    ($pengguna->isPetani() && (!isset($relatedData['produk']) || $relatedData['produk']->count() == 0))
                )
                <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 p-12 text-center">
                    <div class="size-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl text-gray-400">inbox</span>
                    </div>
                    <p class="text-gray-700 font-semibold">Belum ada aktivitas</p>
                    <p class="text-gray-500 text-sm mt-1">Pengguna ini belum memiliki data aktivitas.</p>
                </div>
                @endif

            </div>
        </div>
    </div>
@endsection