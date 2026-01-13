@php
$active = $active ?? (
    request()->routeIs('dashboard') ? 'dashboard' :
    (request()->routeIs('pengguna*') ? 'pengguna' :
    (request()->routeIs('kategori') ? 'kategori' :
    (request()->routeIs('kota') ? 'kota' :
    (request()->routeIs('kupon') ? 'kupon' :
    (request()->routeIs('pesanan*') ? 'pesanan' :
    (request()->routeIs('escrow') ? 'escrow' :
    (request()->routeIs('refund') ? 'refund' :
    (request()->routeIs('laporan') ? 'laporan' : '')))))))));

$links = $links ?? [
    ['key' => 'dashboard', 'route' => 'dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
    ['key' => 'pengguna', 'route' => 'pengguna', 'icon' => 'group', 'label' => 'Pengguna'],
    ['key' => 'kategori', 'route' => 'kategori', 'icon' => 'category', 'label' => 'Categories'],
    ['key' => 'kota', 'route' => 'kota', 'icon' => 'location_city', 'label' => 'Cities'],
    ['key' => 'kupon', 'route' => 'kupon', 'icon' => 'local_offer', 'label' => 'Coupons'],
    ['key' => 'pesanan', 'route' => 'pesanan', 'icon' => 'shopping_cart', 'label' => 'Orders'],
    ['key' => 'escrow', 'route' => 'escrow', 'icon' => 'gavel', 'label' => 'Escrow'],
    ['key' => 'refund', 'route' => 'refund', 'icon' => 'keyboard_return', 'label' => 'Refunds'],
    ['key' => 'laporan', 'route' => 'laporan', 'icon' => 'bar_chart', 'label' => 'Reports'],
];
@endphp

<style type="text/tailwindcss">
    .sidebar-link-active {
        @apply bg-white/5 text-white border-l-[3px] border-[#53be20];
    }
    .sidebar-link {
        @apply flex items-center gap-3 px-6 py-3.5 text-gray-200 hover:text-white hover:bg-white/5 border-l-[3px] border-transparent transition-all duration-200;
    }
    .sidebar-link .material-symbols-outlined {
        @apply text-[22px];
    }
    .sidebar-link-active .material-symbols-outlined {
        @apply text-[#53be20];
    }
</style>

<aside class="w-64 bg-[#1e3f1b] text-white flex flex-col flex-shrink-0 z-20">
    <div class="h-20 flex items-center px-6 border-b border-white/5">
        <div class="flex items-center gap-2.5">
            <img src="{{ asset('images/logotext.png') }}" alt="Tanami Logo" class="h-8 w-auto object-contain" />
        </div>
    </div>
    <nav class="flex-1 overflow-y-auto py-6">

        @foreach($links as $link)
            <a class="sidebar-link {{ ($active ?? '') == $link['key'] ? 'sidebar-link-active' : '' }}" href="{{ route($link['route']) }}">
                <span class="material-symbols-outlined">{{ $link['icon'] }}</span>
                <span class="font-heading font-medium text-sm">{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="p-4 border-t border-white/5">
        <a class="flex items-center gap-3 px-6 py-3 text-gray-400 hover:text-white transition-colors" href="#">
            <span class="material-symbols-outlined">logout</span>
            <span class="font-heading font-medium text-sm">Logout</span>
        </a>
    </div>
</aside>