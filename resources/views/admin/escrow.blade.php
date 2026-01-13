@extends('layouts.admin')

@section('title', 'Tanami - Admin Escrow Management')
@section('header_title', 'Escrow Management')

@section('content')
    <div class="max-w-[1600px] mx-auto space-y-6">
        
        {{-- Breadcrumb & Subtitle --}}
        <div class="flex flex-col gap-1">
            <div class="flex items-center text-xs text-gray-500 font-sans">
                <a class="hover:text-primary transition-colors" href="#">Dashboard</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-900 font-medium">Escrow Management</span>
            </div>
            <h1 class="text-2xl font-heading font-bold text-[#1e3f1b]">Escrow Overview</h1>
        </div>

        {{-- Cards Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center bg-green-50 text-green-700 rounded-lg">
                        <span class="material-symbols-outlined text-2xl">account_balance</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Funds in Escrow</p>
                        <h3 class="text-2xl font-heading font-bold text-[#1e3f1b]">Rp 458.290.000</h3>
                    </div>
                </div>
            </div>
            {{-- Card Pending & Released (Sama polanya) --}}
        </div>

        {{-- Main Table Area --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    {{-- Local Search --}}
                    <div class="relative w-full max-w-md">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                        </span>
                        <input class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-200 text-sm focus:ring-2 focus:ring-primary/20 transition-all"
                            placeholder="Search Order ID, Buyer, or Farmer..." type="text" />
                    </div>
                    {{-- Filter Dropdown --}}
                    <select class="text-sm border-gray-200 rounded-lg text-gray-600 focus:ring-primary/20 py-2.5 pr-10">
                        <option>All Status</option>
                        <option>Held</option>
                        <option>Released</option>
                    </select>
                </div>
                <button class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 hover:bg-gray-50 rounded-lg text-sm font-medium text-gray-600 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">download</span> Export Data
                </button>
            </div>
            
            {{-- Tabel Escrow --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-xs text-gray-500 font-bold uppercase border-b border-gray-100 font-heading tracking-wider">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Transaction Info</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-sans divide-y divide-gray-100">
                        {{-- Isi baris table --}}
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5 font-bold text-[#1e3f1b]">#ORD-9901</td>
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-blue-50 text-blue-600">BUYER</span>
                                        <span class="font-semibold text-gray-800">Robert Fox</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-green-50 text-green-600">FARMER</span>
                                        <span class="text-gray-500">Jenny Wilson</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 font-bold text-[#1e3f1b]">Rp 4.500.000</td>
                            <td class="px-6 py-5 text-gray-500">Oct 24, 2024</td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">
                                    <span class="size-1.5 rounded-full bg-yellow-600"></span> Held in Escrow
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"><span class="material-symbols-outlined text-xl">payments</span></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection