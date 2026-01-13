@extends('layouts.admin')

@section('title', 'Tanami - Admin Refund Management')
@section('header_title', 'Refund Management')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-6">
        
        {{-- Toolbar: Filter & Search --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="space-y-1">
                <p class="text-sm text-gray-500">Manage refund requests from buyers</p>
            </div>
            
            <div class="flex items-center gap-3">
                {{-- Filter Status --}}
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-200 text-gray-700 py-2 pl-4 pr-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 shadow-sm cursor-pointer font-medium">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Approved</option>
                        <option>Rejected</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </div>
                </div>

                {{-- Search Lokal --}}
                <div class="relative group w-full md:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input class="w-full pl-10 pr-4 py-2 rounded-lg bg-white border border-gray-200 text-sm focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"
                        placeholder="Search Order ID..." type="text" />
                </div>
            </div>
        </div>

        {{-- Tabel Refund --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] text-gray-500 font-bold uppercase border-b border-gray-100 font-heading tracking-wider">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Reason</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50 font-sans">
                        {{-- Data Dummy --}}
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5 font-mono font-bold text-gray-600">#ORD-7721</td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-[10px]">RF</div>
                                    <span class="font-semibold text-[#1e3f1b]">Robert Fox</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-gray-600 truncate max-w-[200px]">Product damaged upon arrival</td>
                            <td class="px-6 py-5 font-bold text-[#1e3f1b]">Rp 450.000</td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 uppercase tracking-wide border border-amber-100">
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    <button class="p-2 text-primary hover:bg-green-50 rounded-lg transition-colors" title="Approve">
                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                    </button>
                                    <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Reject">
                                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400 font-medium">Showing 1-10 of 42 requests</p>
                <div class="flex gap-2">
                    <button class="p-1 rounded-md text-gray-400 hover:bg-gray-50 disabled:opacity-50"><span class="material-symbols-outlined text-lg">chevron_left</span></button>
                    <button class="p-1 rounded-md text-gray-400 hover:bg-gray-50"><span class="material-symbols-outlined text-lg">chevron_right</span></button>
                </div>
            </div>
        </div>
    </div>
@endsection