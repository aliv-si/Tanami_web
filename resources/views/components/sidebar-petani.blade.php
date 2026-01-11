@props(['active' => 'dashboard'])

@php
    $user = auth()->user();
@endphp

<aside class="w-64 bg-sidebar text-white flex flex-col fixed h-full z-50">
    <a href="/dashboard" class="p-6 flex items-center gap-3">
        <span class="material-symbols-outlined text-primary text-3xl">eco</span>
        <span class="text-xl font-extrabold font-heading tracking-tight text-white">TANAMI</span>
    </a>
    <nav class="flex-1 mt-6 px-4 space-y-2">
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-heading font-semibold text-[16px] {{ $active === 'dashboard' ? 'active-nav' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all" href="/dashboard">
            <span class="material-symbols-outlined">dashboard</span>
            Dashboard
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-heading font-semibold text-[16px] {{ $active === 'produk' ? 'active-nav' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all" href="/produk">
            <span class="material-symbols-outlined">inventory_2</span>
            Produk
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-heading font-semibold text-[16px] {{ $active === 'pesanan' ? 'active-nav' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all" href="/pesanan">
            <span class="material-symbols-outlined">shopping_cart</span>
            Pesanan
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-heading font-semibold text-[16px] {{ $active === 'rekening' ? 'active-nav' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all" href="/rekening">
            <span class="material-symbols-outlined">account_balance</span>
            Rekening
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-lg font-heading font-semibold text-[16px] {{ $active === 'ulasan' ? 'active-nav' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all" href="/ulasan">
            <span class="material-symbols-outlined">reviews</span>
            Ulasan
        </a>
    </nav>
    <div class="p-4 border-t border-white/10">
        <div class="flex items-center gap-3 px-4 py-2">
            <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary">person</span>
            </div>
            <div>
                <p class="text-sm font-heading font-bold">{{ $user->nama_lengkap ?? 'Petani' }}</p>
                <p class="text-xs text-gray-400">{{ $user->email ?? '' }}</p>
            </div>
        </div>
        <a href="/logout" class="mt-3 flex items-center gap-2 px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all">
            <span class="material-symbols-outlined text-lg">logout</span>
            Keluar
        </a>
    </div>
</aside>
