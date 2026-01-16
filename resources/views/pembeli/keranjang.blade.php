@extends('layouts.app')

@section('title', 'Shopping Cart | Tanami')

@section('content')
<main class="flex-1 py-10">
    <div class="container mx-auto px-4 md:px-10 max-w-[1280px]">
        <div class="mb-8 hidden sm:block">
            <nav class="flex text-sm font-sans text-gray-500">
                <a class="hover:text-primary" href="{{ route('home') }}">Home</a>
                <span class="mx-2">/</span>
                <span class="text-[#1e3f1b] font-medium">Shopping Cart</span>
            </nav>
        </div>
        <div class="mb-10">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight mb-3">
                Shopping Cart</h1>
            <p class="text-gray-500 dark:text-gray-400 font-sans text-lg">
                @if($jumlahItem > 0)
                {{ $jumlahItem }} item(s) in your cart
                @else
                Review your items before checkout
                @endif
            </p>
        </div>

        @if($groupedItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-8 space-y-6">
                @foreach($groupedItems as $group)
                <!-- Group by Farmer -->
                <div class="bg-white dark:bg-[#1f2b1b] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
                    <!-- Farmer Header -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-white/5 border-b border-gray-100 dark:border-white/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[#53be20]">storefront</span>
                            <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">{{ $group['petani']->nama_lengkap ?? 'Farmer' }}</span>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="divide-y divide-gray-100 dark:divide-white/10">
                        @foreach($group['items'] as $item)
                        <div class="p-6 flex flex-col sm:flex-row items-center gap-6 group hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                            <div class="w-full sm:w-32 h-32 shrink-0 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center text-primary overflow-hidden">
                                @if($item->produk->foto)
                                <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover">
                                @else
                                <span class="material-symbols-outlined text-4xl">inventory_2</span>
                                @endif
                            </div>
                            <div class="flex-1 w-full text-center sm:text-left">
                                <div class="flex flex-col sm:flex-row justify-between items-start mb-2">
                                    <div>
                                        <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">{{ $item->produk->nama_produk }}</h3>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm font-sans mt-1">Category: {{ $item->produk->kategori->nama_kategori ?? 'N/A' }}</p>
                                        @if($item->produk->stokTersedia() < $item->jumlah)
                                            <p class="text-red-500 text-xs mt-1">⚠️ Only {{ $item->produk->stokTersedia() }} available</p>
                                            @endif
                                    </div>
                                    <form action="{{ route('keranjang.destroy', $item->id_keranjang) }}" method="POST" class="hidden sm:block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                                    <div class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center bg-white dark:bg-white/5 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <form action="{{ route('keranjang.update', $item->id_keranjang) }}" method="POST" class="contents" id="qty-form-minus-{{ $item->id_keranjang }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="jumlah" value="{{ max(1, $item->jumlah - 1) }}">
                                            <button type="submit" @if($item->jumlah <= 1) disabled @endif
                                                    class="px-3 py-1.5 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 rounded-l-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">-</button>
                                        </form>
                                        <span class="w-12 text-center text-[#1e3f1b] dark:text-white font-medium">{{ $item->jumlah }}</span>
                                        <form action="{{ route('keranjang.update', $item->id_keranjang) }}" method="POST" class="contents">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="jumlah" value="{{ $item->jumlah + 1 }}">
                                            <button type="submit" @if($item->jumlah >= $item->produk->stokTersedia()) disabled @endif
                                                class="px-3 py-1.5 hover:bg-gray-50 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 rounded-r-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">+</button>
                                        </form>
                                    </div>

                                    <div class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white">
                                        <span class="text-sm font-sans font-normal text-gray-500 dark:text-gray-400 mr-2">Subtotal:</span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- Mobile Delete Button -->
                                <form action="{{ route('keranjang.destroy', $item->id_keranjang) }}" method="POST" class="sm:hidden mt-6">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-gray-400 hover:text-red-500 flex items-center justify-center gap-2 w-full py-2 border border-dashed border-gray-300 rounded-lg">
                                        <span class="material-symbols-outlined text-sm">delete</span> Remove Item
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <!-- Clear Cart Button -->
                <div class="flex justify-end">
                    <form action="{{ route('keranjang.clear') }}" method="POST" onsubmit="return confirm('Clear all items from cart?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500 text-sm font-sans flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">delete_sweep</span>
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 sticky top-24">
                    <h3 class="font-heading font-bold text-2xl text-[#1e3f1b] dark:text-white mb-6">Order Summary</h3>
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-100 dark:border-white/10">
                        <div class="flex justify-between font-sans text-gray-500 dark:text-gray-400">
                            <span>Subtotal ({{ $jumlahItem }} items)</span>
                            <span class="font-medium text-[#1e3f1b] dark:text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-sans text-gray-500 dark:text-gray-400">
                            <span>Delivery Fee</span>
                            <span class="font-medium text-gray-400 dark:text-gray-500">Calculated at checkout</span>
                        </div>
                    </div>
                    <div class="flex justify-between font-heading font-bold text-2xl text-[#1e3f1b] dark:text-white mb-8">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout') }}"
                        class="block w-full bg-[#53be20] text-white py-4 rounded-xl font-heading font-bold text-lg hover:bg-[#45a01b] transition-all shadow-lg shadow-[#53be20]/20 hover:shadow-[#53be20]/40 transform hover:-translate-y-0.5 text-center">
                        Proceed to Checkout
                    </a>
                    <div class="mt-4 text-center">
                        <p class="text-xs text-gray-400 font-sans">Secure checkout provided by Tanami</p>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-white/10">
                        <a href="{{ route('katalog') }}" class="flex items-center justify-center gap-2 text-[#53be20] text-sm font-sans hover:underline">
                            <span class="material-symbols-outlined text-lg">arrow_back</span>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">shopping_cart</span>
            <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white mb-2">Your cart is empty</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Looks like you haven't added any items yet</p>
            <a href="{{ route('katalog') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-[#53be20] text-white rounded-lg font-heading font-semibold hover:bg-[#45a01b] transition-colors">
                <span class="material-symbols-outlined">storefront</span>
                Browse Products
            </a>
        </div>
        @endif
    </div>
</main>

@endsection
