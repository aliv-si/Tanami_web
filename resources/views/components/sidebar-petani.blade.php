@props(['active' => 'dashboard'])

@php
$user = auth()->user();

// Definisi Menu Array menggunakan named routes
$links = [
[
'key' => 'dashboard',
'url' => route('petani.dashboard'),
'icon' => 'dashboard',
'label' => 'Dashboard'
],
[
'key' => 'produk',
'url' => route('petani.produk'),
'icon' => 'inventory_2',
'label' => 'Products'
],
[
'key' => 'pesanan',
'url' => route('petani.pesanan'),
'icon' => 'shopping_cart',
'label' => 'Orders'
],
[
'key' => 'rekening',
'url' => route('petani.rekening'),
'icon' => 'account_balance',
'label' => 'Bank Account'
],
[
'key' => 'ulasan',
'url' => route('petani.ulasan'),
'icon' => 'reviews',
'label' => 'Reviews'
],
];
@endphp

<aside class="w-64 bg-sidebar text-white flex flex-col fixed h-full z-50">
    <div class="h-20 flex items-center px-6 border-b border-white/5">
        <div class="flex items-center gap-2.5">
            <img src="{{ asset('images/logotext.png') }}" alt="Tanami Logo" class="h-8 w-auto object-contain" />
        </div>
    </div>

    <nav class="flex-1 mt-6 px-4 space-y-2">
        @foreach($links as $link)
        @php
        $isActive = $active === $link['key'];
        $activeClass = $isActive
        ? 'active-nav'
        : 'text-gray-400 hover:text-white hover:bg-white/5';
        @endphp

        <a href="{{ $link['url'] }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg font-heading font-semibold text-[16px] transition-all {{ $activeClass }}">
            <span class="material-symbols-outlined">{{ $link['icon'] }}</span>
            {{ $link['label'] }}
        </a>
        @endforeach
    </nav>

    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3 px-4 py-2">
            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary">person</span>
            </div>
            <div>
                <p class="text-sm font-heading font-bold">{{ $user->nama_lengkap ?? 'Farmer' }}</p>
                <p class="text-xs text-gray-400">{{ $user->email ?? '' }}</p>
            </div>
        </div>
        <a href="/logout" class="mt-3 flex items-center gap-2 px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all">
            <span class="material-symbols-outlined text-lg">logout</span>
            Logout
        </a>
    </div>
</aside>