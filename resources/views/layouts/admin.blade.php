<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tanami - @yield('title', 'Admin Dashboard')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    @stack('head')
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
                <div class="h-10 w-[1px] bg-gray-100"></div>
                
                {{-- Profile Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-3 p-1 hover:bg-gray-50 rounded-full transition-colors">
                        <div class="size-9 rounded-xl bg-gradient-to-br from-tanami-dark via-green-700 to-green-900 text-white flex items-center justify-center shadow-lg shadow-green-900/30">
                            <span class="material-symbols-outlined text-lg" style="font-variation-settings: 'FILL' 1;">account_circle</span>
                        </div>
                        <div class="hidden lg:block text-left mr-2">
                            <p class="text-sm font-heading font-bold text-tanami-dark leading-none">Admin Tanami</p>
                            <p class="text-[11px] text-gray-400 font-sans mt-1">Super Admin</p>
                        </div>
                        <span class="material-symbols-outlined text-gray-400 text-sm transition-transform" :class="{ 'rotate-180': open }">expand_more</span>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
                         style="display: none;">
                        
                        {{-- Profile Header --}}
                        <div class="p-5 bg-gradient-to-br from-tanami-dark to-green-800">
                            <div class="flex items-center gap-4">
                                <div class="size-14 rounded-2xl bg-gradient-to-br from-white/30 via-white/20 to-white/10 flex items-center justify-center shadow-lg shadow-black/20 backdrop-blur-sm border border-white/20">
                                    <span class="material-symbols-outlined text-white text-3xl drop-shadow-lg" style="font-variation-settings: 'FILL' 1;">account_circle</span>
                                </div>
                                <div>
                                    <p class="text-white font-heading font-bold text-lg">Super Admin</p>
                                    <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary/30 text-primary">
                                        Full Access
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="p-5">
                            <div class="flex items-start gap-3 mb-4">
                                <span class="material-symbols-outlined text-primary text-xl mt-0.5">verified_user</span>
                                <div>
                                    <p class="text-sm font-bold text-tanami-dark mb-1">Transaction Controller</p>
                                    <p class="text-xs text-gray-500 leading-relaxed">
                                        Mengontrol dan memonitoring seluruh transaksi yang terjadi di platform Tanami.
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 mb-4">
                                <span class="material-symbols-outlined text-primary text-xl mt-0.5">monitoring</span>
                                <div>
                                    <p class="text-sm font-bold text-tanami-dark mb-1">System Monitoring</p>
                                    <p class="text-xs text-gray-500 leading-relaxed">
                                        Memantau aktivitas pengguna, pesanan, pembayaran, dan manajemen escrow.
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary text-xl mt-0.5">manage_accounts</span>
                                <div>
                                    <p class="text-sm font-bold text-tanami-dark mb-1">User Management</p>
                                    <p class="text-xs text-gray-500 leading-relaxed">
                                        Mengelola akun pembeli, petani, dan verifikasi akun baru.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto bg-background-body p-8">
            @yield('content')
        </main>

    </div>
    @stack('scripts')
</body>

</html>