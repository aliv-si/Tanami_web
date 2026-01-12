@extends('layouts.app')

@section('title', 'Checkout | Tanami')

@section('content')
    <main class="flex-1 py-10">
        <div class="container mx-auto px-4 md:px-10 max-w-[1280px]">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight">Checkout
                </h1>
                <p class="text-gray-500 dark:text-gray-400 font-sans mt-2">Please enter your shipping details to proceed.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-8 space-y-6">
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-white/5">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="flex items-center justify-center size-8 rounded-full bg-[#f0fdf4] text-primary">
                                <span class="material-symbols-outlined text-xl">local_shipping</span>
                            </span>
                            <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">Shipping Information
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label
                                    class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">Full
                                    Name</label>
                                <input
                                    class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="John Doe" type="text" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">Phone
                                    Number</label>
                                <input
                                    class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="+1 (555) 000-0000" type="tel" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">Email
                                    Address</label>
                                <input
                                    class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="john@example.com" type="email" />
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">Address</label>
                                <input
                                    class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="123 Green Street, Farmville" type="text" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">City</label>
                                <input
                                    class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="New York" type="text" />
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">Postal
                                    Code</label>
                                <input
                                    class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="10001" type="text" />
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-white/5">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="flex items-center justify-center size-8 rounded-full bg-[#f0fdf4] text-primary">
                                <span class="material-symbols-outlined text-xl">package_2</span>
                            </span>
                            <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">Delivery Method</h3>
                        </div>
                        <div class="space-y-4">
                            <label
                                class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-white/5 transition-colors border-[#53be20] bg-green-50/30 dark:bg-green-900/10">
                                <input checked="" class="h-4 w-4 text-[#53be20] border-gray-300 focus:ring-[#53be20]"
                                    name="delivery" type="radio" />
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <span
                                            class="block text-sm font-medium text-[#1e3f1b] dark:text-white font-heading">Standard
                                            Delivery</span>
                                        <span class="block text-sm font-bold text-[#1e3f1b] dark:text-white">$5.00</span>
                                    </div>
                                    <span class="block text-sm text-gray-500 font-sans mt-1">Estimated 3-5 business
                                        days</span>
                                </div>
                            </label>
                            <label
                                class="relative flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                <input class="h-4 w-4 text-[#53be20] border-gray-300 focus:ring-[#53be20]" name="delivery"
                                    type="radio" />
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <span
                                            class="block text-sm font-medium text-[#1e3f1b] dark:text-white font-heading">Express
                                            Delivery</span>
                                        <span class="block text-sm font-bold text-[#1e3f1b] dark:text-white">$15.00</span>
                                    </div>
                                    <span class="block text-sm text-gray-500 font-sans mt-1">Estimated 1-2 business
                                        days</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-white/5">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="flex items-center justify-center size-8 rounded-full bg-[#f0fdf4] text-primary">
                                <span class="material-symbols-outlined text-xl">payments</span>
                            </span>
                            <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">Payment Method</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input checked="" class="peer sr-only" name="payment" type="radio" />
                                <div
                                    class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 peer-checked:border-[#53be20] peer-checked:bg-green-50/30 dark:peer-checked:bg-green-900/10 hover:bg-gray-50 dark:hover:bg-white/5 transition-all h-full">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span
                                            class="material-symbols-outlined text-gray-600 dark:text-gray-300">account_balance</span>
                                        <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">Bank
                                            Transfer</span>
                                    </div>
                                    <p class="text-sm text-gray-500 font-sans">Direct transfer to our corporate account.</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input class="peer sr-only" name="payment" type="radio" />
                                <div
                                    class="p-4 rounded-xl border border-gray-200 dark:border-gray-700 peer-checked:border-[#53be20] peer-checked:bg-green-50/30 dark:peer-checked:bg-green-900/10 hover:bg-gray-50 dark:hover:bg-white/5 transition-all h-full">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span
                                            class="material-symbols-outlined text-gray-600 dark:text-gray-300">account_balance_wallet</span>
                                        <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">E-Wallet</span>
                                    </div>
                                    <p class="text-sm text-gray-500 font-sans">Pay securely with your preferred digital
                                        wallet.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4">
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 sticky top-24">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-5">Order Summary</h3>
                        <div class="space-y-4 mb-6">
                            <div class="flex gap-4">
                                <div
                                    class="size-16 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-2xl text-primary">sensors</span>
                                </div>
                                <div class="flex-1">
                                    <h4
                                        class="font-heading font-semibold text-sm text-[#1e3f1b] dark:text-white leading-tight">
                                        Smart Soil Sensor</h4>
                                    <p class="text-xs text-gray-500 font-sans mt-1">Qty: 1</p>
                                </div>
                                <div class="font-heading font-bold text-sm text-[#1e3f1b] dark:text-white">$129.00</div>
                            </div>
                        </div>
                        <div class="h-px bg-gray-100 dark:bg-white/10 my-6"></div>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between font-sans text-sm text-gray-500 dark:text-gray-400">
                                <span>Subtotal</span>
                                <span class="font-medium text-[#1e3f1b] dark:text-white">$129.00</span>
                            </div>
                            <div class="flex justify-between font-sans text-sm text-gray-500 dark:text-gray-400">
                                <span>Delivery Fee</span>
                                <span class="font-medium text-[#1e3f1b] dark:text-white">$5.00</span>
                            </div>
                            <div class="flex justify-between font-sans text-sm text-primary">
                                <span>Discount</span>
                                <span class="font-medium">-$0.00</span>
                            </div>
                        </div>
                        <div class="h-px bg-gray-100 dark:bg-white/10 mb-6"></div>
                        <div class="flex justify-between items-center mb-8">
                            <span class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white">Total</span>
                            <span
                                class="font-heading font-extrabold text-2xl text-[#1e3f1b] dark:text-white">$134.00</span>
                        </div>
                        <button
                            class="w-full bg-[#53be20] text-white py-4 rounded-xl font-heading font-bold text-base hover:bg-[#45a01b] transition-all shadow-lg shadow-[#53be20]/20 hover:shadow-[#53be20]/40 transform hover:-translate-y-0.5 mb-6">
                            Place Order
                        </button>
                        <div class="bg-[#f7f7f7] dark:bg-white/5 rounded-lg p-4 text-center">
                            <div class="flex justify-center gap-3 mb-3 text-gray-400">
                                <span class="material-symbols-outlined text-xl">lock</span>
                                <span class="material-symbols-outlined text-xl">verified_user</span>
                                <span class="material-symbols-outlined text-xl">shield</span>
                            </div>
                            <p class="text-xs font-heading font-semibold text-[#1e3f1b] dark:text-white mb-1">
                                Fresh from Farmer Guarantee
                            </p>
                            <p class="text-[10px] text-gray-500 font-sans">
                                Your purchase supports sustainable agriculture directly. Secure SSL Encrypted payment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
