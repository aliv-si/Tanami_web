@extends('layouts.admin')

@section('title', 'Tanami - Master Kategori')

{{-- MAGIC: Mengganti Search Bar di Header Layout menjadi Judul --}}
@section('header_title', 'Master Kategori')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-6">
        
        {{-- Navigasi & Tombol Aksi (Dipindah ke Body) --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <nav class="flex text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1">
                <span class="hover:text-primary cursor-pointer">Dashboard</span>
                <span class="mx-2 text-gray-300">/</span>
                <span class="hover:text-primary cursor-pointer">Master Data</span>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-600">Kategori</span>
            </nav>
            
            {{-- Tombol Tambah --}}
            <button class="bg-primary hover:bg-opacity-90 text-white px-5 py-2.5 rounded-xl font-heading font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-95">
                <span class="material-symbols-outlined text-sm">add</span>
                Tambah Kategori
            </button>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-widest border-b border-gray-50">
                            <th class="px-6 py-5 w-16">No</th>
                            <th class="px-6 py-5 w-24">Icon</th>
                            <th class="px-6 py-5">Category Name</th>
                            <th class="px-6 py-5">Slug</th>
                            <th class="px-6 py-5">Product Count</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        {{-- Data Dummy --}}
                        <tr class="hover:bg-gray-50/40 transition-colors group">
                            <td class="px-6 py-6 text-gray-400 font-medium">01</td>
                            <td class="px-6 py-6">
                                <div class="size-14 rounded-full bg-green-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform shadow-md">
                                    <span class="material-symbols-outlined text-3xl">eco</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex flex-col">
                                    <span class="font-bold text-tanami-dark text-base">Sayuran Segar</span>
                                    <span class="text-[11px] text-gray-400 font-medium">Fresh Vegetables</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <code class="px-2 py-1 bg-gray-50 text-gray-500 rounded text-xs font-medium">sayuran-segar</code>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-tanami-dark">125</span>
                                    <span class="text-gray-400 text-xs">Products</span>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 uppercase tracking-wide border border-green-100/50">
                                    <span class="size-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </button>
                                    <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-50 flex items-center justify-between">
                <p class="text-xs text-gray-500 font-medium">Showing <span class="text-tanami-dark font-bold">1</span> of <span class="text-tanami-dark font-bold">1</span> category</p>
            </div>
        </div>
    </div>
@endsection