@extends('layouts.admin')

@section('title', 'Tanami - Master Kupon')
@section('header_title', 'Master Kupon')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">
                    <span class="hover:text-primary cursor-pointer">Dashboard</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span>Master Data</span>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-gray-600">Kupon</span>
                </nav>
                
                {{-- Search Lokal --}}
                <div class="relative group w-full md:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input class="w-full pl-10 pr-4 py-2 rounded-lg bg-white border border-gray-200 text-sm transition-all focus:ring-2 focus:ring-primary/20" 
                           placeholder="Cari kode kupon..." type="text" />
                </div>
            </div>
            
            <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-[#49a91b] text-white rounded-xl text-sm font-bold shadow-sm shadow-primary/20 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Kupon
            </button>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 w-16">No</th>
                            <th class="px-6 py-4">Kode Kupon</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Nilai</th>
                            <th class="px-6 py-4">Min. Belanja</th>
                            <th class="px-6 py-4">Berlaku Sampai</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-6 py-4 text-gray-400 font-medium">01</td>
                            <td class="px-6 py-4"><span class="font-mono font-bold text-tanami-dark uppercase tracking-wider">MERDEKA45</span></td>
                            <td class="px-6 py-4"><span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-600 uppercase">Persen</span></td>
                            <td class="px-6 py-4 font-semibold text-gray-700">10%</td>
                            <td class="px-6 py-4 text-gray-600">Rp 150.000</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">31 Aug 2024</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 uppercase">
                                    <span class="size-1.5 rounded-full bg-green-600"></span> Active
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                    <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection