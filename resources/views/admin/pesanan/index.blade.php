@extends('layouts.admin')

@php $active = 'pesanan'; @endphp

@section('title', 'Tanami - Manajemen Pesanan')
@section('header_title', 'Manajemen Pesanan')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-8">
        
        {{-- Breadcrumb & Header --}}
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Manajemen Pesanan</span>
            </div>
            <h2 class="text-2xl font-heading font-extrabold text-tanami-dark">Manajemen Pesanan</h2>
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

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            {{-- Pending --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-amber-50 text-amber-600 rounded-lg">
                        <span class="material-symbols-outlined">schedule</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">{{ number_format($statusCounts['pending'] ?? 0) }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Pending</p>
                </div>
            </div>
            {{-- Menunggu Verifikasi --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg">
                        <span class="material-symbols-outlined">hourglass_top</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">{{ number_format($statusCounts['menunggu_verifikasi'] ?? 0) }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Verifikasi</p>
                </div>
            </div>
            {{-- Diproses --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-lg">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">{{ number_format($statusCounts['diproses'] ?? 0) }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Diproses</p>
                </div>
            </div>
            {{-- Dikirim --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-purple-50 text-purple-600 rounded-lg">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">{{ number_format($statusCounts['dikirim'] ?? 0) }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Dikirim</p>
                </div>
            </div>
            {{-- Selesai --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-green-50 text-green-600 rounded-lg">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">{{ number_format($statusCounts['selesai'] ?? 0) }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Selesai</p>
                </div>
            </div>
        </div>

        {{-- Filter Area --}}
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <form method="GET" action="{{ route('admin.pesanan') }}" class="flex flex-col lg:flex-row justify-between items-center gap-4">
                {{-- Search --}}
                <div class="relative w-full lg:w-96 group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input name="q" value="{{ $currentSearch }}"
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg bg-gray-50 border-transparent focus:bg-white focus:border-primary/30 focus:ring-2 focus:ring-primary/10 text-sm placeholder-gray-400 transition-all"
                        placeholder="Cari ID pesanan atau nama pembeli..." type="text" />
                </div>
                
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    {{-- Filter Status --}}
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()"
                            class="appearance-none bg-gray-50 border border-transparent text-gray-600 text-sm rounded-lg py-2.5 pl-4 pr-10 focus:bg-white focus:border-primary/30 cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ $currentStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="menunggu_verifikasi" {{ $currentStatus == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                            <option value="dibayar" {{ $currentStatus == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                            <option value="diproses" {{ $currentStatus == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ $currentStatus == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="terkirim" {{ $currentStatus == 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                            <option value="selesai" {{ $currentStatus == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $currentStatus == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="minta_refund" {{ $currentStatus == 'minta_refund' ? 'selected' : '' }}>Minta Refund</option>
                            <option value="direfund" {{ $currentStatus == 'direfund' ? 'selected' : '' }}>Direfund</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <span class="material-symbols-outlined text-sm">expand_more</span>
                        </div>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit" class="flex items-center gap-2 bg-primary text-white px-4 py-2.5 rounded-lg text-sm font-bold hover:bg-green-700 transition-colors">
                        <span class="material-symbols-outlined text-lg">filter_alt</span> Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Order Table --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] text-gray-500 font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 w-12">No</th>
                            <th class="px-6 py-4">ID Pesanan</th>
                            <th class="px-6 py-4">Pembeli</th>
                            <th class="px-6 py-4">Kota</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($pesananList as $index => $pesanan)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-400 font-medium">
                                {{ $pesananList->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4 font-mono font-bold text-gray-600">#{{ $pesanan->id_pesanan }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img alt="User" class="size-8 rounded-full border border-gray-100 object-cover"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($pesanan->pembeli->nama_lengkap ?? 'U') }}&background=random&size=64" />
                                    <div>
                                        <span class="font-bold text-tanami-dark">{{ $pesanan->pembeli->nama_lengkap ?? '-' }}</span>
                                        <p class="text-xs text-gray-400">{{ $pesanan->pembeli->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $pesanan->kota->nama_kota ?? '-' }}</td>
                            <td class="px-6 py-4 font-bold text-tanami-dark">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'menunggu_verifikasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'dibayar' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                        'diproses' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'dikirim' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'terkirim' => 'bg-violet-50 text-violet-700 border-violet-200',
                                        'selesai' => 'bg-green-50 text-green-700 border-green-200',
                                        'dibatalkan' => 'bg-red-50 text-red-700 border-red-200',
                                        'minta_refund' => 'bg-orange-50 text-orange-700 border-orange-200',
                                        'direfund' => 'bg-gray-100 text-gray-700 border-gray-200',
                                    ];
                                    $color = $statusColors[$pesanan->status_pesanan] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                    
                                    $statusLabels = [
                                        'pending' => 'Pending',
                                        'menunggu_verifikasi' => 'Verifikasi',
                                        'dibayar' => 'Dibayar',
                                        'diproses' => 'Diproses',
                                        'dikirim' => 'Dikirim',
                                        'terkirim' => 'Terkirim',
                                        'selesai' => 'Selesai',
                                        'dibatalkan' => 'Dibatalkan',
                                        'minta_refund' => 'Minta Refund',
                                        'direfund' => 'Direfund',
                                    ];
                                    $label = $statusLabels[$pesanan->status_pesanan] ?? ucfirst($pesanan->status_pesanan);
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $color }}">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ \Carbon\Carbon::parse($pesanan->tgl_dibuat)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.pesanan.detail', $pesanan->id_pesanan) }}"
                                    class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors inline-flex"
                                    title="Lihat Detail">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="size-16 rounded-full bg-gray-100 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-3xl text-gray-400">inbox</span>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 font-semibold">Tidak ada pesanan</p>
                                        <p class="text-gray-500 text-sm mt-1">Belum ada data pesanan yang ditemukan.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($pesananList->hasPages())
            <div class="p-6 border-t border-gray-50">
                {{ $pesananList->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection