@extends('layouts.admin')

@section('title', 'Tanami - Master Kota & Ongkir')
@section('header_title', 'Master Kota & Ongkir')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-6">
        
        {{-- Toolbar: Navigasi, Search Lokal, Tombol Aksi --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                    <span class="hover:text-primary cursor-pointer">Dashboard</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span>Master Data</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-gray-600">Kota</span>
                </nav>
                
                {{-- Search Lokal (Pengganti Search Global) --}}
                <div class="mt-3 md:mt-0 relative group md:max-w-sm">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input class="w-full pl-10 pr-4 py-2 rounded-lg bg-white border border-gray-200 focus:ring-2 focus:ring-primary/20 text-sm placeholder-gray-400 transition-all" 
                           placeholder="Cari kota atau provinsi..." type="text" />
                </div>
            </div>

            <button class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-xl font-heading font-bold text-sm transition-all shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                Tambah Kota
            </button>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider">
                            <th class="px-8 py-5 border-b border-gray-100 w-20">No</th>
                            <th class="px-6 py-5 border-b border-gray-100">Nama Kota</th>
                            <th class="px-6 py-5 border-b border-gray-100">Provinsi</th>
                            <th class="px-6 py-5 border-b border-gray-100">Tarif Ongkir</th>
                            <th class="px-6 py-5 border-b border-gray-100">Status</th>
                            <th class="px-8 py-5 border-b border-gray-100 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-8 py-5 text-gray-400 font-medium">01</td>
                            <td class="px-6 py-5"><span class="font-bold text-tanami-dark block">Jakarta Selatan</span></td>
                            <td class="px-6 py-5 text-gray-600 font-medium">DKI Jakarta</td>
                            <td class="px-6 py-5 text-gray-700 font-semibold font-mono">Rp 15.000</td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-green-50 text-green-700 uppercase tracking-wide">Active</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button class="size-8 flex items-center justify-center rounded-lg text-amber-500 hover:bg-amber-50 transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">edit_square</span>
                                    </button>
                                    <button class="size-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        {{-- Tambahkan baris data lain sesuai kebutuhan --}}
                    </tbody>
                </table>
            </div>
            <div class="px-8 py-5 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Showing 1 of 42 Cities</p>
                {{-- Pagination Buttons --}}
            </div>
        </div>
    </div>
@endsection