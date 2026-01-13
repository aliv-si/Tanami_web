@extends('layouts.app')

@section('title', 'Detail Pesanan | Tanami')

@section('content')
    <main class="flex-1 py-10">
        <div class="container mx-auto px-4 md:px-10 max-w-[1200px]">
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6 font-sans">
                <a class="hover:text-primary transition-colors" href="#">My Orders</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-[#1e3f1b] dark:text-white font-medium">Order Details</span>
            </nav>
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <h1 class="text-3xl md:text-4xl font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight">
                            Order Details</h1>
                        <span
                            class="px-3 py-1 rounded-full text-sm font-bold bg-[#53be20] text-white flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">local_shipping</span>
                            Shipped
                        </span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-sans text-lg">Order ID: <span
                            class="font-bold text-[#1e3f1b] dark:text-white">#TNM-88291</span> • Placed on Oct 24, 2023</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button
                        class="px-6 py-2.5 rounded-lg border border-[#1e3f1b] dark:border-white text-[#1e3f1b] dark:text-white font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">location_on</span>
                        Track Courier
                    </button>
                    <button
                        class="px-6 py-2.5 rounded-lg bg-[#53be20] text-white font-heading font-semibold text-sm hover:bg-[#45a01b] transition-colors shadow-lg shadow-[#53be20]/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        Confirm Receipt
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                        <h3
                            class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#53be20]">inventory_2</span>
                            Ordered Items
                        </h3>
                        <div class="space-y-6">
                            <div class="flex gap-4 md:gap-6 items-start">
                                <div
                                    class="size-24 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center shrink-0 border border-gray-50 dark:border-white/5">
                                    <span class="material-symbols-outlined text-4xl text-primary">sensors</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <h4 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-1">
                                                Smart Soil Sensor</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 font-sans mb-1">Provides
                                                real-time moisture &amp; nutrient data.</p>
                                            <div class="text-sm text-[#1e3f1b] dark:text-gray-300 font-medium">Farmer: Agus
                                                Setiawan</div>
                                        </div>
                                        <div
                                            class="text-lg font-bold font-heading text-[#1e3f1b] dark:text-white whitespace-nowrap">
                                            $129.00</div>
                                    </div>
                                    <div class="mt-4 flex items-center text-sm font-sans text-gray-500 dark:text-gray-400">
                                        <span>Qty: 1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-6">Price Breakdown</h3>
                        <div class="space-y-3 font-sans text-gray-600 dark:text-gray-300">
                            <div class="flex justify-between items-center">
                                <span>Subtotal (1 item)</span>
                                <span>$129.00</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Delivery Fee</span>
                                <span>$5.00</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Tax (Included)</span>
                                <span>$0.00</span>
                            </div>
                            <div class="h-px bg-gray-100 dark:bg-white/10 my-2"></div>
                            <div
                                class="flex justify-between items-center text-lg font-heading font-bold text-[#1e3f1b] dark:text-white">
                                <span>Total Price</span>
                                <span>$134.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-6">Order Timeline</h3>
                        <div class="relative pl-2 font-sans">
                            <div class="flex gap-4 mb-8 relative z-10">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="size-8 rounded-full bg-[#1e3f1b] text-white flex items-center justify-center shrink-0 z-10">
                                        <span class="material-symbols-outlined text-sm">check</span>
                                    </div>
                                    <div class="w-0.5 h-full bg-[#1e3f1b] absolute top-8 left-[15px] -z-0"></div>
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold text-[#1e3f1b] dark:text-white text-sm">Order Placed
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">24 Oct, 10:30 AM</p>
                                </div>
                            </div>
                            <div class="flex gap-4 mb-8 relative z-10">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="size-8 rounded-full bg-[#1e3f1b] text-white flex items-center justify-center shrink-0 z-10">
                                        <span class="material-symbols-outlined text-sm">check</span>
                                    </div>
                                    <div class="w-0.5 h-full bg-[#1e3f1b] absolute top-8 left-[15px] -z-0"></div>
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold text-[#1e3f1b] dark:text-white text-sm">Payment
                                        Confirmed</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">24 Oct, 10:35 AM</p>
                                </div>
                            </div>
                            <div class="flex gap-4 relative z-10">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="size-8 rounded-full bg-[#53be20] text-white flex items-center justify-center shrink-0 ring-4 ring-[#53be20]/20 z-10">
                                        <span class="material-symbols-outlined text-sm">local_shipping</span>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold text-[#53be20] text-sm">Shipped</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">25 Oct, 08:00 AM</p>
                                    <p class="text-xs text-[#1e3f1b] dark:text-gray-300 mt-2 font-medium">Courier is on the
                                        way</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-4">Shipping Information
                        </h3>
                        <div class="flex gap-4 items-start">
                            <div class="mt-1">
                                <span class="material-symbols-outlined text-gray-400">person_pin_circle</span>
                            </div>
                            <div>
                                <p class="font-heading font-semibold text-[#1e3f1b] dark:text-white">Budi Santoso</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                                    Jl. Merdeka No. 45, Kecamatan Sukun,<br />
                                    Malang, Jawa Timur, 65118<br />
                                    Indonesia
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">+62 812-3456-7890</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-4">Payment Information
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-lg bg-gray-50 dark:bg-white/5 flex items-center justify-center border border-gray-100 dark:border-white/10">
                                        <span
                                            class="material-symbols-outlined text-gray-600 dark:text-gray-300">account_balance</span>
                                    </div>
                                    <div>
                                        <p class="font-heading font-semibold text-[#1e3f1b] dark:text-white text-sm">Bank
                                            Transfer</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">BCA Ends in 8899</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#1e3f1b]/10 dark:bg-white/10 text-[#1e3f1b] dark:text-white">
                                    Paid
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
