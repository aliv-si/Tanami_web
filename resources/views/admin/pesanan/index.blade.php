@extends('layouts.admin')

@section('title', 'Tanami - Admin Order Management')
@section('header_title', 'Order Management')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-8">
        {{-- Judul Halaman --}}
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">
                <span>Dashboard</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Order Management</span>
            </div>
            <h2 class="text-2xl font-heading font-extrabold text-tanami-dark">Order Management</h2>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Card Contoh 1 --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-gray-50 text-gray-600 rounded-lg">
                        <span class="material-symbols-outlined">shopping_bag</span>
                    </div>
                    <span class="inline-flex items-center text-[10px] font-bold text-primary bg-green-50 px-2 py-0.5 rounded-full">+12%</span>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">1,245</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Total Orders</p>
                </div>
            </div>
            {{-- Card Lainnya... --}}
        </div>

        {{-- Filter Area --}}
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="relative w-full lg:w-96">
                {{-- Search lokal tambahan jika perlu, atau gunakan yang di header --}}
                <input class="w-full pl-4 pr-4 py-2 rounded-lg bg-gray-50 border-transparent focus:bg-white focus:border-primary/30 text-sm placeholder-gray-400 transition-all"
                    placeholder="Filter results..." type="text" />
            </div>
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <select class="bg-gray-50 border border-transparent text-gray-600 text-sm rounded-lg py-2 px-3">
                    <option selected>All Status</option>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                </select>
                <button class="flex items-center gap-2 bg-tanami-dark text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-opacity-90">
                    <span class="material-symbols-outlined text-lg">download</span> Export
                </button>
            </div>
        </div>

        {{-- Order Table --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100 text-[11px] text-gray-500 font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-gray-600">#ORD-9821</td>
                            <td class="px-6 py-4">Robert Fox</td>
                            <td class="px-6 py-4 font-bold text-primary">$450.00</td>
                            <td class="px-6 py-4"><span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 uppercase">Completed</span></td>
                            <td class="px-6 py-4 text-center">
                                <button class="p-1.5 text-gray-400 hover:text-primary"><span class="material-symbols-outlined">visibility</span></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection 