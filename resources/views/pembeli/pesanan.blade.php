@extends('layouts.app')

@section('title', 'Pesanan | Tanami')

@section('content')
    <main class="flex-1 py-10">
        <div class="container mx-auto px-4 md:px-10 max-w-[1000px]">
            <div class="mb-10">
                <h1 class="text-3xl md:text-[48px] font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight mb-2">
                    My Orders</h1>
                <p class="text-gray-500 dark:text-gray-400 font-sans text-lg">Track and manage your purchases</p>
            </div>
            <div
                class="flex items-center gap-8 border-b border-gray-200 dark:border-gray-700 mb-8 overflow-x-auto scrollbar-hide">
                <button
                    class="pb-4 border-b-2 border-[#53be20] text-[#53be20] font-heading font-semibold text-[14px] whitespace-nowrap">
                    All Orders
                </button>
                <button
                    class="pb-4 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                    Pending
                </button>
                <button
                    class="pb-4 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                    Processing
                </button>
                <button
                    class="pb-4 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                    Shipped
                </button>
                <button
                    class="pb-4 border-b-2 border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                    Completed
                </button>
            </div>
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 transition-all hover:shadow-md">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div class="flex items-center gap-4">
                            <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">#TNM-88291</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 font-sans">24 Oct 2023</span>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-[#53be20] text-white">
                            Shipped
                        </span>
                    </div>
                    <div class="flex gap-4 md:gap-6 items-start border-b border-gray-100 dark:border-white/10 pb-6 mb-6">
                        <div
                            class="size-20 md:size-24 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center shrink-0 border border-gray-50 dark:border-white/5">
                            <span class="material-symbols-outlined text-3xl text-primary">sensors</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-1">Smart Soil Sensor
                            </h3>
                            <div
                                class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-sm text-gray-500 dark:text-gray-400 font-sans mb-1">
                                <span>Qty: 1</span>
                                <span class="hidden sm:inline">•</span>
                                <span class="text-[#1e3f1b] dark:text-gray-300">Farmer: <span class="font-medium">Agus
                                        Setiawan</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white">$134.00</div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <button
                                class="w-full sm:w-auto px-6 py-2.5 rounded-lg border border-[#1e3f1b] dark:border-white text-[#1e3f1b] dark:text-white font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                View Details
                            </button>
                            <button
                                class="w-full sm:w-auto px-6 py-2.5 rounded-lg bg-[#53be20] text-white font-heading font-semibold text-sm hover:bg-[#45a01b] transition-colors shadow-lg shadow-[#53be20]/20">
                                Confirm Receipt
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 transition-all hover:shadow-md">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div class="flex items-center gap-4">
                            <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">#TNM-88295</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 font-sans">25 Oct 2023</span>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-[#53be20] text-white">
                            Pending
                        </span>
                    </div>
                    <div class="flex gap-4 md:gap-6 items-start border-b border-gray-100 dark:border-white/10 pb-6 mb-6">
                        <div
                            class="size-20 md:size-24 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center shrink-0 border border-gray-50 dark:border-white/5">
                            <span class="material-symbols-outlined text-3xl text-primary">potted_plant</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-1">Organic
                                Fertilizer Pack</h3>
                            <div
                                class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-sm text-gray-500 dark:text-gray-400 font-sans mb-1">
                                <span>Qty: 2</span>
                                <span class="hidden sm:inline">•</span>
                                <span class="text-[#1e3f1b] dark:text-gray-300">Farmer: <span class="font-medium">Budi
                                        Santoso</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white">$45.50</div>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <button
                                class="flex-1 sm:flex-none px-6 py-2.5 rounded-lg border border-[#1e3f1b] dark:border-white text-[#1e3f1b] dark:text-white font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 transition-all hover:shadow-md">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <div class="flex items-center gap-4">
                            <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">#TNM-88102</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 font-sans">10 Sep 2023</span>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold bg-[#1e3f1b] text-white">
                            Completed
                        </span>
                    </div>
                    <div class="flex gap-4 md:gap-6 items-start border-b border-gray-100 dark:border-white/10 pb-6 mb-6">
                        <div
                            class="size-20 md:size-24 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center shrink-0 border border-gray-50 dark:border-white/5">
                            <span class="material-symbols-outlined text-3xl text-primary">grain</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-1">Premium Rice
                                Seeds</h3>
                            <div
                                class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-sm text-gray-500 dark:text-gray-400 font-sans mb-1">
                                <span>Qty: 5</span>
                                <span class="hidden sm:inline">•</span>
                                <span class="text-[#1e3f1b] dark:text-gray-300">Farmer: <span class="font-medium">Siti
                                        Rahma</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white">$89.00</div>
                        <div class="flex gap-3 w-full sm:w-auto">
                            <button
                                class="flex-1 sm:flex-none px-6 py-2.5 rounded-lg border border-[#1e3f1b] dark:border-white text-[#1e3f1b] dark:text-white font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                View Details
                            </button>
                            <button
                                class="flex-1 sm:flex-none px-6 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                Buy Again
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
