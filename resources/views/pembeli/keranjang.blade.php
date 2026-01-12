@extends('layouts.app')

@section('title', 'Shopping Cart | Tanami')

@section('content')
    <main class="flex-1 py-10">
        <div class="container mx-auto px-4 md:px-10 max-w-[1280px]">
            <div class="mb-8 hidden sm:block">
                <nav class="flex text-sm font-sans text-gray-500">
                    <a class="hover:text-primary" href="#">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-[#1e3f1b] font-medium">Shopping Cart</span>
                </nav>
            </div>
            <div class="mb-10">
                <h1 class="text-4xl md:text-5xl font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight mb-3">
                    Shopping Cart</h1>
                <p class="text-gray-500 dark:text-gray-400 font-sans text-lg">Review your items before checkout</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-8 space-y-6">
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 flex flex-col sm:flex-row items-center gap-6 group hover:border-primary/20 transition-colors">
                        <div
                            class="w-full sm:w-32 h-32 shrink-0 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-4xl">sensors</span>
                        </div>
                        <div class="flex-1 w-full text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">Smart Soil
                                        Sensor</h3>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm font-sans mt-1">Category: Tech</p>
                                </div>
                                <button
                                    class="hidden sm:block text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                                <div class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white">$129.00</div>
                                <div
                                    class="flex items-center bg-white dark:bg-white/5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <button
                                        class="px-3 py-1.5 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 rounded-l-lg transition-colors">-</button>
                                    <input
                                        class="w-12 text-center border-none focus:ring-0 text-[#1e3f1b] dark:text-white font-medium p-0 bg-transparent"
                                        type="text" value="1" />
                                    <button
                                        class="px-3 py-1.5 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 rounded-r-lg transition-colors">+</button>
                                </div>
                                <div class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white">
                                    <span
                                        class="text-sm font-sans font-normal text-gray-500 dark:text-gray-400 mr-2">Subtotal:</span>$129.00
                                </div>
                            </div>
                            <button
                                class="sm:hidden mt-6 text-gray-400 hover:text-red-500 flex items-center justify-center gap-2 w-full py-2 border border-dashed border-gray-300 rounded-lg">
                                <span class="material-symbols-outlined text-sm">delete</span> Remove Item
                            </button>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4">
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 sticky top-24">
                        <h3 class="font-heading font-bold text-2xl text-[#1e3f1b] dark:text-white mb-6">Order Summary</h3>
                        <div class="space-y-4 mb-6 pb-6 border-b border-gray-100 dark:border-white/10">
                            <div class="flex justify-between font-sans text-gray-500 dark:text-gray-400">
                                <span>Subtotal</span>
                                <span class="font-medium text-[#1e3f1b] dark:text-white">$129.00</span>
                            </div>
                            <div class="flex justify-between font-sans text-gray-500 dark:text-gray-400">
                                <span>Delivery Fee</span>
                                <span class="font-medium text-[#1e3f1b] dark:text-white">$5.00</span>
                            </div>
                        </div>
                        <div
                            class="flex justify-between font-heading font-bold text-2xl text-[#1e3f1b] dark:text-white mb-8">
                            <span>Total</span>
                            <span>$134.00</span>
                        </div>
                        <div class="mb-8">
                            <label class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">Promo
                                Code</label>
                            <div class="flex gap-2">
                                <input
                                    class="flex-1 rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400"
                                    placeholder="Enter code" type="text" />
                                <button
                                    class="bg-gray-100 dark:bg-white/10 text-[#1e3f1b] dark:text-white px-5 py-2.5 rounded-lg font-heading font-semibold hover:bg-gray-200 dark:hover:bg-white/20 transition-colors">Apply</button>
                            </div>
                        </div>
                        <button
                            class="w-full bg-[#53be20] text-white py-4 rounded-xl font-heading font-bold text-lg hover:bg-[#45a01b] transition-all shadow-lg shadow-[#53be20]/20 hover:shadow-[#53be20]/40 transform hover:-translate-y-0.5">
                            Proceed to Checkout
                        </button>
                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-400 font-sans">Secure checkout provided by Tanami</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
