@php
$active = $active ?? (
request()->routeIs('admin.dashboard') ? 'dashboard' :
(request()->routeIs('admin.pengguna*') ? 'pengguna' :
(request()->routeIs('admin.kategori*') ? 'kategori' :
(request()->routeIs('admin.kota*') ? 'kota' :
(request()->routeIs('admin.kupon*') ? 'kupon' :
(request()->routeIs('admin.pesanan*') ? 'pesanan' :
(request()->routeIs('admin.escrow*') ? 'escrow' :
(request()->routeIs('admin.refund*') ? 'refund' :
(request()->routeIs('admin.laporan*') ? 'laporan' :
(request()->routeIs('admin.pesan-kontak*') ? 'pesan-kontak' : ''))))))))));

$links = $links ?? [
['key' => 'dashboard', 'route' => 'admin.dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
['key' => 'pengguna', 'route' => 'admin.pengguna', 'icon' => 'group', 'label' => 'Users'],
['key' => 'kategori', 'route' => 'admin.kategori', 'icon' => 'category', 'label' => 'Categories'],
['key' => 'kota', 'route' => 'admin.kota', 'icon' => 'location_city', 'label' => 'Cities'],
['key' => 'kupon', 'route' => 'admin.kupon', 'icon' => 'local_offer', 'label' => 'Coupons'],
['key' => 'pesanan', 'route' => 'admin.pesanan', 'icon' => 'shopping_cart', 'label' => 'Orders'],
['key' => 'escrow', 'route' => 'admin.escrow', 'icon' => 'gavel', 'label' => 'Escrow'],
['key' => 'refund', 'route' => 'admin.refund', 'icon' => 'keyboard_return', 'label' => 'Refunds'],
['key' => 'laporan', 'route' => 'admin.laporan', 'icon' => 'bar_chart', 'label' => 'Reports'],
['key' => 'pesan-kontak', 'route' => 'admin.pesan-kontak', 'icon' => 'mail', 'label' => 'Contact Messages'],
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
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-6 py-3 text-gray-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-heading font-medium text-sm">Logout</span>
            </button>
        </form>
    </div>
</aside>