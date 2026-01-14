@extends('layouts.app')

@section('title', 'Checkout | Tanami')

@section('content')
    <main class="flex-1 py-10">
        <div class="container mx-auto px-4 md:px-10 max-w-[1280px]">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight">Checkout</h1>
                <p class="text-gray-500 dark:text-gray-400 font-sans mt-2">Please select your destination city to proceed.</p>
            </div>

            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-8 space-y-6">
                        <!-- Buyer Information (Read-only) -->
                        <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-white/5">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center size-8 rounded-full bg-[#f0fdf4] text-primary">
                                    <span class="material-symbols-outlined text-xl">person</span>
                                </span>
                                <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">Buyer Information</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-sans font-medium text-gray-500 dark:text-gray-400 mb-1">Name</label>
                                    <p class="font-heading font-semibold text-[#1e3f1b] dark:text-white">{{ auth()->user()->nama_lengkap }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-sans font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                                    <p class="font-heading font-semibold text-[#1e3f1b] dark:text-white">{{ auth()->user()->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-sans font-medium text-gray-500 dark:text-gray-400 mb-1">Phone</label>
                                    <p class="font-heading font-semibold text-[#1e3f1b] dark:text-white">{{ auth()->user()->no_hp ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-sans font-medium text-gray-500 dark:text-gray-400 mb-1">Address</label>
                                    <p class="font-heading font-semibold text-[#1e3f1b] dark:text-white">{{ auth()->user()->alamat ?? '-' }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-4">
                                <a href="{{ route('profil') }}" class="text-[#53be20] hover:underline">Update profile</a> if information is incorrect
                            </p>
                        </div>

                        <!-- Shipping Destination -->
                        <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-white/5">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center size-8 rounded-full bg-[#f0fdf4] text-primary">
                                    <span class="material-symbols-outlined text-xl">local_shipping</span>
                                </span>
                                <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">Shipping Destination</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">Destination City *</label>
                                    <select name="id_kota_tujuan" required id="kota-select"
                                        class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white transition-colors">
                                        <option value="">Select city...</option>
                                        @foreach($listKota as $kota)
                                        <option value="{{ $kota->id_kota }}" data-ongkir="{{ $kota->ongkir }}" {{ old('id_kota_tujuan') == $kota->id_kota ? 'selected' : '' }}>
                                            {{ $kota->nama_kota }} - Rp {{ number_format($kota->ongkir, 0, ',', '.') }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('id_kota_tujuan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-sans font-medium text-[#1e3f1b] dark:text-gray-300 mb-2">Order Notes (Optional)</label>
                                    <textarea name="catatan" rows="2"
                                        class="w-full rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400 transition-colors resize-none"
                                        placeholder="Special instructions for delivery...">{{ old('catatan') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-white/5">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center size-8 rounded-full bg-[#f0fdf4] text-primary">
                                    <span class="material-symbols-outlined text-xl">local_offer</span>
                                </span>
                                <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">Promo Code</h3>
                            </div>
                            <div class="flex gap-3">
                                <input type="text" name="kode_kupon" value="{{ old('kode_kupon') }}"
                                    class="flex-1 rounded-lg border-gray-200 dark:border-gray-700 bg-[#f7f7f7] dark:bg-white/5 focus:border-[#53be20] focus:ring-[#53be20] font-sans text-sm text-[#1e3f1b] dark:text-white placeholder-gray-400 transition-colors"
                                    placeholder="Enter promo code (optional)" />
                            </div>
                            @error('kode_kupon')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method Info -->
                        <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 sm:p-8 shadow-sm border border-gray-100 dark:border-white/5">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="flex items-center justify-center size-8 rounded-full bg-[#f0fdf4] text-primary">
                                    <span class="material-symbols-outlined text-xl">payments</span>
                                </span>
                                <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white">Payment Method</h3>
                            </div>
                            <div class="p-4 rounded-xl border border-[#53be20] bg-green-50/30 dark:bg-green-900/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-300">account_balance</span>
                                    <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">Bank Transfer</span>
                                </div>
                                <p class="text-sm text-gray-500 font-sans">After placing order, you will receive payment instructions. Payment deadline: 24 hours.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Sidebar -->
                    <div class="lg:col-span-4">
                        <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 sticky top-24">
                            <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-5">Order Summary</h3>
                            
                            <!-- Items List -->
                            <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto">
                                @foreach($items as $item)
                                <div class="flex gap-4">
                                    <div class="size-16 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                                        @if($item->produk->foto)
                                        <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover">
                                        @else
                                        <span class="material-symbols-outlined text-2xl text-primary">inventory_2</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-heading font-semibold text-sm text-[#1e3f1b] dark:text-white leading-tight truncate">{{ $item->produk->nama_produk }}</h4>
                                        <p class="text-xs text-gray-500 font-sans mt-1">{{ $item->jumlah }} × Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="font-heading font-bold text-sm text-[#1e3f1b] dark:text-white whitespace-nowrap">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                </div>
                                @endforeach
                            </div>

                            <div class="h-px bg-gray-100 dark:bg-white/10 my-6"></div>

                            <!-- Price Breakdown -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between font-sans text-sm text-gray-500 dark:text-gray-400">
                                    <span>Subtotal ({{ $items->sum('jumlah') }} items)</span>
                                    <span class="font-medium text-[#1e3f1b] dark:text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between font-sans text-sm text-gray-500 dark:text-gray-400">
                                    <span>Delivery Fee</span>
                                    <span class="font-medium text-[#1e3f1b] dark:text-white" id="ongkir-display">Select city</span>
                                </div>
                            </div>

                            <div class="h-px bg-gray-100 dark:bg-white/10 mb-6"></div>

                            <div class="flex justify-between items-center mb-8">
                                <span class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white">Total</span>
                                <span class="font-heading font-extrabold text-2xl text-[#1e3f1b] dark:text-white" id="total-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <button type="submit"
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
                                    Your purchase supports sustainable agriculture directly.
                                </p>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="{{ route('keranjang') }}" class="text-[#53be20] text-sm font-sans hover:underline flex items-center justify-center gap-1">
                                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                                    Back to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Update ongkir when city changes
        const subtotal = {{ $subtotal }};
        const kotaSelect = document.getElementById('kota-select');
        const ongkirDisplay = document.getElementById('ongkir-display');
        const totalDisplay = document.getElementById('total-display');

        function updateTotal() {
            const selectedOption = kotaSelect.options[kotaSelect.selectedIndex];
            const ongkir = parseInt(selectedOption.dataset.ongkir) || 0;
            
            if (ongkir > 0) {
                ongkirDisplay.textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
                const total = subtotal + ongkir;
                totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
            } else {
                ongkirDisplay.textContent = 'Select city';
                totalDisplay.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            }
        }

        kotaSelect.addEventListener('change', updateTotal);
        
        // Initialize if city already selected
        if (kotaSelect.value) {
            updateTotal();
        }
    </script>

    @if(session('error'))
    <script>
        setTimeout(() => {
            alert('{{ session('error') }}');
        }, 100);
    </script>
    @endif

    @if($errors->any())
    <script>
        setTimeout(() => {
            alert('{{ $errors->first() }}');
        }, 100);
    </script>
    @endif
@endsection
