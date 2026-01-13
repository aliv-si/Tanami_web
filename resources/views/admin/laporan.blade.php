@extends('layouts.admin')

@section('title', 'Tanami - Admin Reports')
@section('header_title', 'Business Reports')

@section('content')
    <div class="max-w-[1400px] mx-auto w-full space-y-8">
        
        {{-- Toolbar: Date Picker & Export (Dipindah dari Header ke Body) --}}
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 gap-3 cursor-pointer hover:border-gray-300 transition-colors">
                    <span class="material-symbols-outlined text-gray-400 text-sm">calendar_today</span>
                    <span class="text-xs font-medium text-gray-600">Oct 01, 2024 - Oct 31, 2024</span>
                    <span class="material-symbols-outlined text-gray-400 text-sm">expand_more</span>
                </div>
            </div>
            <button class="flex items-center gap-2 bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span> Export PDF
            </button>
        </div>

        {{-- Chart Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-heading font-bold text-[#1e3f1b]">Sales Performance</h3>
                    <p class="text-xs text-gray-500 mt-1">Net revenue and order volume analytics</p>
                </div>
                <div class="flex p-1 bg-gray-100 rounded-lg">
                    <button class="px-4 py-1.5 text-xs font-semibold text-gray-500 hover:text-gray-700">Daily</button>
                    <button class="px-4 py-1.5 text-xs font-semibold text-gray-500 hover:text-gray-700">Weekly</button>
                    <button class="px-4 py-1.5 text-xs font-bold bg-white text-primary shadow-sm rounded-md transition-all">Monthly</button>
                </div>
            </div>
            <div class="p-6">
                {{-- Chart Placeholder --}}
                <div class="h-80 w-full relative flex items-end justify-between px-4 pb-8 bg-gray-50/50 rounded-lg">
                    <div class="m-auto text-gray-400 text-sm">Chart Placeholder</div>
                </div>
                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t border-gray-100">
                    <div class="flex items-center gap-4 px-4">
                        <div class="size-12 bg-green-50 rounded-xl flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-3xl">payments</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Revenue</p>
                            <h4 class="text-2xl font-heading font-bold text-[#1e3f1b]">$1,245,890.00</h4>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 px-4 border-l border-gray-100">
                        <div class="size-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                            <span class="material-symbols-outlined text-3xl">shopping_bag</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Orders</p>
                            <h4 class="text-2xl font-heading font-bold text-[#1e3f1b]">12,482</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Table Section (Top Products) --}}
        {{-- ... (Isi tabel sama seperti file asli) ... --}}
    </div>
@endsection