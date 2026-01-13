@extends('layouts.admin')

@php $active = 'pengguna'; @endphp

@section('title', 'Tanami - User Management')
@section('header_title', 'User Management')

@section('content')
    {{-- Wrapper Utama --}}
    <div class="max-w-[1400px] mx-auto space-y-8">
        
        {{-- HEADER CUSTOM (Berisi Judul, Tombol Verifikasi Petani, dan Add User) --}}
        <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">
                <span>Dashboard</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">User Management</span>
            </div>

        <div class="bg-white border-b border-gray-100 px-6 py-3 flex-shrink-0 z-10 rounded-2xl">
            
            <div class="flex flex-col md:flex-row items-center gap-4">
                {{-- Search Bar --}}
                <div class="relative flex-1 w-full md:max-w-md group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input class="w-full pl-11 pr-4 py-2.5 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 text-sm font-sans placeholder-gray-400 text-gray-700 transition-all" 
                    placeholder="Search name, email, or role..." type="text"/>
                </div>
                
                
                {{-- Filter Role --}}
                <div class="relative w-full md:w-auto min-w-[160px]">
                    <select class="w-full appearance-none pl-4 pr-10 py-2.5 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 text-sm font-sans font-medium text-gray-700 transition-all cursor-pointer">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="farmer">Farmer</option>
                        <option value="buyer">Buyer</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 w-full md:w-auto md:ml-auto justify-end">
                    
                    {{-- TOMBOL 1: VERIFIKASI PETANI (Link ke halaman Petani) --}}
                    <a href="{{ route('pengguna.petani') }}" 
                       class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-primary/20 text-primary font-bold text-sm hover:bg-primary/5 transition-all">
                        <span>Verifikasi Petani</span>
                    </a>
        
                    {{-- TOMBOL 2: ADD USER --}}
                    <button class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-primary text-white font-bold text-sm hover:bg-[#49a81c] transition-all shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        Add User
                    </button>
                </div>
            </div>
        </div>
        
        {{-- KONTEN UTAMA: STATISTIK & TABEL --}}
        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-[1400px] mx-auto space-y-8">
                
                {{-- Grid Statistik --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="size-12 flex items-center justify-center bg-gray-50 text-tanami-dark rounded-xl">
                                <span class="material-symbols-outlined text-2xl">groups</span>
                            </div>
                            <div>
                                <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Total Users</p>
                                <h3 class="text-2xl font-heading font-extrabold text-tanami-dark leading-none mt-1">12,482</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="size-12 flex items-center justify-center bg-orange-50 text-orange-600 rounded-xl">
                                <span class="material-symbols-outlined text-2xl">shopping_cart</span>
                            </div>
                            <div>
                                <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Total Buyers</p>
                                <h3 class="text-2xl font-heading font-extrabold text-tanami-dark leading-none mt-1">8,294</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="size-12 flex items-center justify-center bg-green-50 text-primary rounded-xl">
                                <span class="material-symbols-outlined text-2xl">agriculture</span>
                            </div>
                            <div>
                                <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Total Farmers</p>
                                <h3 class="text-2xl font-heading font-extrabold text-tanami-dark leading-none mt-1">4,153</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="size-12 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl">
                                <span class="material-symbols-outlined text-2xl">admin_panel_settings</span>
                            </div>
                            <div>
                                <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Total Admins</p>
                                <h3 class="text-2xl font-heading font-extrabold text-tanami-dark leading-none mt-1">35</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel Users --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider border-b border-gray-100">
                                    <th class="px-6 py-4 w-16">No</th>
                                    <th class="px-6 py-4">User</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Role</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Joined Date</th>
                                    <th class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                {{-- Data 1: Admin --}}
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4 text-gray-400 font-medium">01</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img alt="User" class="size-9 rounded-full border border-gray-100 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2FFsaegNFK-wUMoVYb02fpvVLxlyPRLTYdqlCo5sI2W_VLJAK0dw_2aC7YvjTKwEWAfF5vq0X4TdDP6AJeRWNpue7-iDuIwkFq1TiF8rOAQrOeguRKoUc5PhtQT6g0zCzVQyLBxHD7Mv5SRAY5ogBOPaX9W8B5Lmd-aLH_SI5B28iN1zeJnZ6ZrFwrS9cl4ooBnQGwmbsunhtadAMcNNFgDadxcmth12Ti-90PByqqCvmUQWCRds6PllX866P8RdLl9x4Knj2YPV5"/>
                                            <span class="font-bold text-tanami-dark">Robert Fox</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">robert.fox@example.com</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-wide">Admin</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase tracking-wide">Active</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">Oct 24, 2024</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('pengguna.show', 1) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                            <button class="p-1.5 text-gray-400 hover:text-primary hover:bg-green-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </button>
                                            <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Data 2: Farmer --}}
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4 text-gray-400 font-medium">02</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="size-9 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xs">AW</div>
                                            <span class="font-bold text-tanami-dark">Aris Wijaya</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">aris.farm@tanami.co.id</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-green-50 text-green-600 border border-green-100 uppercase tracking-wide">Farmer</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase tracking-wide">Active</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">Oct 22, 2024</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('pengguna.show', 2) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                            <button class="p-1.5 text-gray-400 hover:text-primary hover:bg-green-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </button>
                                            <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Data 3: Buyer --}}
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4 text-gray-400 font-medium">03</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="size-9 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center font-bold text-xs">SJ</div>
                                            <span class="font-bold text-tanami-dark">Siti Jamilah</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">siti.j@gmail.com</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-orange-50 text-orange-600 border border-orange-100 uppercase tracking-wide">Buyer</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 uppercase tracking-wide">Inactive</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">Oct 20, 2024</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('pengguna.show', 3) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                            <button class="p-1.5 text-gray-400 hover:text-primary hover:bg-green-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </button>
                                            <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- Data 4: Suspended --}}
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4 text-gray-400 font-medium">04</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="size-9 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center font-bold text-xs">
                                                <span class="material-symbols-outlined text-sm">person</span>
                                            </div>
                                            <span class="font-bold text-tanami-dark">Budi Santoso</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">budi.s@outlook.com</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold bg-orange-50 text-orange-600 border border-orange-100 uppercase tracking-wide">Buyer</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase tracking-wide">Suspended</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">Oct 15, 2024</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('pengguna.show', 4) }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                            <button class="p-1.5 text-gray-400 hover:text-primary hover:bg-green-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </button>
                                            <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    <div class="p-6 border-t border-gray-50 flex items-center justify-between">
                        <p class="text-xs text-gray-500 font-medium">Showing <span class="text-tanami-dark font-bold">4</span> of <span class="text-tanami-dark font-bold">12,482</span> users</p>
                        <div class="flex items-center gap-2">
                            <button class="size-8 flex items-center justify-center rounded-lg border border-gray-100 text-gray-400 hover:bg-gray-50 transition-colors">
                                <span class="material-symbols-outlined text-sm">chevron_left</span>
                            </button>
                            <button class="size-8 flex items-center justify-center rounded-lg bg-primary text-white text-xs font-bold">1</button>
                            <button class="size-8 flex items-center justify-center rounded-lg border border-gray-100 text-gray-600 hover:bg-gray-50 text-xs font-bold">2</button>
                            <button class="size-8 flex items-center justify-center rounded-lg border border-gray-100 text-gray-600 hover:bg-gray-50 text-xs font-bold">3</button>
                            <span class="text-gray-400 text-xs">...</span>
                            <button class="size-8 flex items-center justify-center rounded-lg border border-gray-100 text-gray-400 hover:bg-gray-50 transition-colors">
                                <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection