<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tanami - @yield('title', 'Admin Dashboard')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#53be20",
                        "tanami-dark": "#1e3f1b",
                        "background-body": "#f7f7f7",
                    },
                    fontFamily: {
                        "sans": ["Inter", "sans-serif"],
                        "heading": ["Plus Jakarta Sans", "sans-serif"]
                    }
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            body { @apply font-sans; }
            h1,h2,h3,h4 { @apply font-heading; }
        }
    </style>
</head>

<body class="@yield('body-class','bg-background-body antialiased flex h-screen overflow-hidden')">

    {{-- LOGIKA SIDEBAR --}}
    @php
    $activePage = $activePage ?? (
    request()->routeIs('admin.dashboard') ? 'dashboard' :
    (request()->routeIs('admin.pengguna*') ? 'pengguna' :
    (request()->routeIs('admin.kategori*') ? 'kategori' :
    (request()->routeIs('admin.kota*') ? 'kota' :
    (request()->routeIs('admin.kupon*') ? 'kupon' :
    (request()->routeIs('admin.pesanan*') ? 'pesanan' :
    (request()->routeIs('admin.escrow*') ? 'escrow' :
    (request()->routeIs('admin.refund*') ? 'refund' :
    (request()->routeIs('admin.laporan*') ? 'laporan' : '')))))))));

    $adminNavLinks = $adminNavLinks ?? [
    ['key' => 'dashboard', 'route' => 'admin.dashboard', 'icon' => 'dashboard', 'label' => 'Dashboard'],
    ['key' => 'pengguna', 'route' => 'admin.pengguna', 'icon' => 'group', 'label' => 'Pengguna'],
    ['key' => 'kategori', 'route' => 'admin.kategori', 'icon' => 'category', 'label' => 'Kategori'],
    ['key' => 'kota', 'route' => 'admin.kota', 'icon' => 'location_city', 'label' => 'Kota'],
    ['key' => 'kupon', 'route' => 'admin.kupon', 'icon' => 'local_offer', 'label' => 'Kupon'],
    ['key' => 'pesanan', 'route' => 'admin.pesanan', 'icon' => 'shopping_cart', 'label' => 'Pesanan'],
    ['key' => 'escrow', 'route' => 'admin.escrow', 'icon' => 'gavel', 'label' => 'Escrow'],
    ['key' => 'refund', 'route' => 'admin.refund', 'icon' => 'keyboard_return', 'label' => 'Refund'],
    ['key' => 'laporan', 'route' => 'admin.laporan', 'icon' => 'bar_chart', 'label' => 'Laporan'],
    ];
    @endphp

    <x-sidebar-admin :active="$activePage ?? ''" :links="$adminNavLinks" />

    {{-- WRAPPER KANAN --}}
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

        {{-- HEADER GLOBAL (HARDCODED) --}}
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-8 flex-shrink-0 z-20 sticky top-0">
            <div class="flex-1 max-w-xl">
                @hasSection('header_title')
                {{-- Tampilkan Judul Halaman jika ada --}}
                <div class="flex flex-col justify-center h-full">
                    <h2 class="text-2xl font-heading font-extrabold text-tanami-dark">
                        @yield('header_title')
                    </h2>
                </div>
                @else
                {{-- Default: Tampilkan Search Bar --}}
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[22px]">search</span>
                    </span>
                    <input class="w-full pl-11 pr-4 py-2.5 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 text-sm font-sans placeholder-gray-400 text-gray-700 transition-all"
                        placeholder="Search for analytics, orders, or users..." type="text" />
                </div>
                @endif
            </div>

            <div class="flex items-center gap-6">
                <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 size-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <div class="h-10 w-[1px] bg-gray-100"></div>
                <button class="flex items-center gap-3 p-1 hover:bg-gray-50 rounded-full transition-colors">
                    <div class="size-9 rounded-lg bg-tanami-dark text-white flex items-center justify-center font-bold text-xs">AD</div>
                    <div class="hidden lg:block text-left mr-2">
                        <p class="text-sm font-heading font-bold text-tanami-dark leading-none">Admin User</p>
                        <p class="text-[11px] text-gray-400 font-sans mt-1">Super Admin</p>
                    </div>
                    <span class="material-symbols-outlined text-gray-400 text-sm">expand_more</span>
                </button>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto bg-background-body p-8">
            @yield('content')
        </main>

    </div>
</body>

</html>