<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>AgriMart - Segar Langsung dari Ladang</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#37ec13",
              "background-light": "#f6f8f6",
              "background-dark": "#132210",
              "surface-light": "#ffffff",
              "surface-dark": "#1c2e18",
            },
            fontFamily: {
              "display": ["Inter", "sans-serif"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
          },
        },
      }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-[#101b0d] dark:text-[#f9fcf8] min-h-screen flex flex-col overflow-x-hidden">
<!-- Top Navigation Bar -->
<header class="sticky top-0 z-50 w-full bg-surface-light/95 dark:bg-surface-dark/95 backdrop-blur-md border-b border-[#e9f3e7] dark:border-[#2a3f25]">
<div class="px-4 md:px-10 lg:px-40 py-3 flex items-center justify-between gap-4">
<!-- Logo -->
<div class="flex items-center gap-2 md:gap-4 shrink-0 cursor-pointer">
<div class="size-8 text-primary">
<svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_6_535)">
<path clip-rule="evenodd" d="M47.2426 24L24 47.2426L0.757355 24L24 0.757355L47.2426 24ZM12.2426 21H35.7574L24 9.24264L12.2426 21Z" fill="currentColor" fill-rule="evenodd"></path>
</g>
<defs>
<clippath id="clip0_6_535"><rect fill="white" height="48" width="48"></rect></clippath>
</defs>
</svg>
</div>
<h2 class="text-xl font-bold tracking-tight hidden sm:block">AgriMart</h2>
</div>
<!-- Search Bar -->
<div class="hidden md:flex flex-1 max-w-xl mx-8">
<div class="flex w-full items-center rounded-lg bg-[#e9f3e7] dark:bg-[#2a3f25] h-10 px-3 transition-colors focus-within:ring-2 focus-within:ring-primary/50">
<span class="material-symbols-outlined text-[#599a4c] dark:text-[#8abe7f]">search</span>
<input class="w-full bg-transparent border-none focus:ring-0 text-sm ml-2 placeholder-[#599a4c] dark:placeholder-[#8abe7f] text-[#101b0d] dark:text-white" placeholder="Cari sayur, buah, atau alat tani..." type="text"/>
</div>
</div>
<!-- Right Actions -->
<div class="flex items-center gap-3 md:gap-6">
<nav class="hidden lg:flex items-center gap-6 text-sm font-medium">
<a class="hover:text-primary transition-colors" href="#">Katalog</a>
<a class="hover:text-primary transition-colors" href="#">Promo</a>
<a class="hover:text-primary transition-colors" href="#">Petani Mitra</a>
</nav>
<div class="flex items-center gap-2">
<button class="flex items-center justify-center size-10 rounded-lg bg-[#e9f3e7] dark:bg-[#2a3f25] hover:bg-primary/20 dark:hover:bg-primary/20 transition-colors text-[#101b0d] dark:text-white">
<span class="material-symbols-outlined">shopping_cart</span>
</button>
<button class="flex items-center justify-center size-10 rounded-lg bg-[#e9f3e7] dark:bg-[#2a3f25] hover:bg-primary/20 dark:hover:bg-primary/20 transition-colors text-[#101b0d] dark:text-white">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="hidden sm:flex h-10 px-5 items-center justify-center rounded-lg bg-primary hover:bg-primary/90 text-[#101b0d] text-sm font-bold tracking-wide transition-colors">
                    Masuk
                </button>
</div>
</div>
</div>
<!-- Mobile Search (Visible only on small screens) -->
<div class="md:hidden px-4 pb-3">
<div class="flex w-full items-center rounded-lg bg-[#e9f3e7] dark:bg-[#2a3f25] h-10 px-3">
<span class="material-symbols-outlined text-[#599a4c]">search</span>
<input class="w-full bg-transparent border-none focus:ring-0 text-sm ml-2 placeholder-[#599a4c] text-[#101b0d] dark:text-white" placeholder="Cari produk..." type="text"/>
</div>
</div>
</header>
<main class="flex-1 w-full max-w-[1440px] mx-auto flex flex-col">
<!-- Hero Section -->
<div class="px-4 md:px-10 lg:px-40 py-6">
<div class="@container">
<div class="flex min-h-[400px] md:min-h-[480px] flex-col gap-6 rounded-xl bg-cover bg-center bg-no-repeat items-start justify-end px-6 pb-10 md:px-12 md:pb-16 shadow-lg overflow-hidden relative group" data-alt="Fresh vegetables and fruits arranged aesthetically on a wooden table in a farm setting" style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.6) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuBuJbAWYrojmWhwAA0BmkkOMP3nrRv-VEjmrQFO206ETYikrfVLzhD4kjnvuhedUfaeKZNONVWKfFQaUNh_KJoecYgkO1pvF1XT6QDOJ51WTnWdKYvyWweRviKzQHYqjjnXPJROhBzHkFFUrNAUIZBWvG4p4oi4ZK39xuzw1a7CVkXVs_k0Umua5WXz7YcNN3Air0nGaKV_TZoJUoXyiRpnkHhjzDsCw3_YYexD5QlvSUwMvK1yfv0W0pp8Gwpu3V7E89woQNcqH58");'>
<div class="flex flex-col gap-3 text-left max-w-2xl relative z-10">
<span class="inline-block px-3 py-1 bg-primary text-[#101b0d] text-xs font-bold rounded-full w-fit mb-2">PROMO MINGGU INI</span>
<h1 class="text-white text-3xl md:text-5xl font-black leading-tight tracking-tight drop-shadow-sm">
                        Segar Langsung dari Ladang ke Meja Anda
                    </h1>
<h2 class="text-gray-100 text-sm md:text-lg font-medium leading-relaxed max-w-lg drop-shadow-sm">
                        Dapatkan hasil panen terbaik dengan jaminan kesegaran dan harga tangan pertama dari petani lokal.
                    </h2>
</div>
<div class="relative z-10 pt-2">
<button class="flex h-12 px-6 cursor-pointer items-center justify-center rounded-lg bg-primary hover:bg-[#32d611] text-[#101b0d] text-base font-bold transition-all transform hover:scale-105 shadow-lg shadow-green-900/20">
                        Belanja Sekarang
                    </button>
</div>
</div>
</div>
</div>
<!-- Features / Trust Indicators -->
<div class="px-4 md:px-10 lg:px-40 py-2">
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-6 bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-[#e9f3e7] dark:border-[#2a3f25]">
<div class="flex flex-col items-center text-center gap-2">
<div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full text-green-700 dark:text-green-400">
<span class="material-symbols-outlined">local_shipping</span>
</div>
<div>
<h3 class="font-bold text-sm">Pengiriman Cepat</h3>
<p class="text-xs text-gray-500 dark:text-gray-400">Sampai dalam 24 jam</p>
</div>
</div>
<div class="flex flex-col items-center text-center gap-2">
<div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full text-green-700 dark:text-green-400">
<span class="material-symbols-outlined">verified</span>
</div>
<div>
<h3 class="font-bold text-sm">Jaminan Segar</h3>
<p class="text-xs text-gray-500 dark:text-gray-400">Garansi uang kembali</p>
</div>
</div>
<div class="flex flex-col items-center text-center gap-2">
<div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full text-green-700 dark:text-green-400">
<span class="material-symbols-outlined">handshake</span>
</div>
<div>
<h3 class="font-bold text-sm">Mitra Petani</h3>
<p class="text-xs text-gray-500 dark:text-gray-400">Langsung dari sumber</p>
</div>
</div>
<div class="flex flex-col items-center text-center gap-2">
<div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full text-green-700 dark:text-green-400">
<span class="material-symbols-outlined">support_agent</span>
</div>
<div>
<h3 class="font-bold text-sm">Layanan 24/7</h3>
<p class="text-xs text-gray-500 dark:text-gray-400">Bantuan setiap saat</p>
</div>
</div>
</div>
</div>
<!-- Categories -->
<section class="px-4 md:px-10 lg:px-40 py-8">
<div class="flex items-center justify-between mb-6">
<h2 class="text-xl md:text-2xl font-bold tracking-tight">Kategori Pilihan</h2>
<a class="text-sm font-semibold text-primary hover:underline" href="#">Lihat Semua</a>
</div>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
<!-- Category Item 1 -->
<a class="group flex flex-col items-center gap-3 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-transparent hover:border-primary/30 hover:shadow-md transition-all" href="#">
<div class="w-20 h-20 rounded-full bg-cover bg-center shadow-sm group-hover:scale-105 transition-transform" data-alt="Close up of fresh green vegetables" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD6z5apnz3erTV27tzrCr5H_lYdF-E3YeJ_iHu806ObwerAxRZTVwN3VJ-ruBnk2SpVb5VoZ-QBFmJk-WD1MB8Bg0D8TaOd1cSENs_fBuhEzJ0seFi56GBBuqLYQbkrIjVKhSRSZ1saf4gF7JEke45y8JhmHPl8u82tkA0EWERwptSVFUIWNWGyYGf41b0bimV3j2FrPtNa52ftSClxdewZmncYcpWL5pfoyvg5DLGN5BwTcqwMQoqdiWqJqgPCfWnOmW3m52abm0k");'></div>
<div class="text-center">
<p class="font-semibold text-sm group-hover:text-primary transition-colors">Sayur</p>
<p class="text-xs text-gray-500 dark:text-gray-400">Segar Harian</p>
</div>
</a>
<!-- Category Item 2 -->
<a class="group flex flex-col items-center gap-3 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-transparent hover:border-primary/30 hover:shadow-md transition-all" href="#">
<div class="w-20 h-20 rounded-full bg-cover bg-center shadow-sm group-hover:scale-105 transition-transform" data-alt="Various fresh colorful fruits" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDnDi10JOwweCBW4vdgUtOrBmz38qfLtg5AnuZ0_DLV16DvIg6RvWlhRar1pzZlekWSZbcipYSuAydDu_pxoBb3L5JSjcWelWNmyptYbSp9fHpfMBelX3mKLNO4iR6bMKDa5-N25s320mTzraOkN3qxAjyoUSJ374hBWmdTAEki50cnjPR_f9XsP526sDZjGhzuYO9kzHxCBIFAVIQPejVuZmkuHIdAs84NhuNVta0zJzYsEoagYWHdxQGZ5ZQfr83bXC8Vgbgm_ZE");'></div>
<div class="text-center">
<p class="font-semibold text-sm group-hover:text-primary transition-colors">Buah</p>
<p class="text-xs text-gray-500 dark:text-gray-400">Manis Alami</p>
</div>
</a>
<!-- Category Item 3 -->
<a class="group flex flex-col items-center gap-3 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-transparent hover:border-primary/30 hover:shadow-md transition-all" href="#">
<div class="w-20 h-20 rounded-full bg-cover bg-center shadow-sm group-hover:scale-105 transition-transform" data-alt="Small plant seedlings in soil" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuClCi2EnG4MiMsntDpc8jh3fGSKkJwj8nIPPkGCyn8bpBQpQjV1GAKlmH-9dASxnIHbB2BkTf8TWysRmFx98BsnAxocXl7Z0IJ0CH1AW0HhL_967ADNOpEuA1UyqunDsbcmOwJ7qX5EK8L-m_LnwbqIRJMp4CCzMaUYMqPhdxECPNtjCA4c9DJuRXLADUp8wBESzXVKFDHi8oBStWS1BobBVi7IHXrHts2Mc9os72x2fgSjCtgWbxo-KiCkddfcfP5K4dN-X5HZ5go");'></div>
<div class="text-center">
<p class="font-semibold text-sm group-hover:text-primary transition-colors">Bibit</p>
<p class="text-xs text-gray-500 dark:text-gray-400">Siap Tanam</p>
</div>
</a>
<!-- Category Item 4 -->
<a class="group flex flex-col items-center gap-3 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-transparent hover:border-primary/30 hover:shadow-md transition-all" href="#">
<div class="w-20 h-20 rounded-full bg-cover bg-center shadow-sm group-hover:scale-105 transition-transform" data-alt="Organic fertilizer packaging" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAqCUWrwAjMxBOzZD6qiFSSWzAwXFXQEdo-2SXeYAJ6Xg-iKP8bSu5vt9aP_5NwR_KjtMtCpG0nEX2hKQOzXRj6a5wupE8QwBXhiZ6R8YB4vWf5CAUNmvS9_2VpC-2-GdkfZz2bkBv0HJZ-QjrTX4nxgqD-UwkhFU_sjkgc08mv4GnWuWcPnXUDGRxZ15wAeAOuWb_ZPFV0ruyCu4sDjrCawMZv1KPFZ_X1hjeD3saKM4fYRzbO-7ersvEzY0ubqdcrN91f1kDtFVY");'></div>
<div class="text-center">
<p class="font-semibold text-sm group-hover:text-primary transition-colors">Pupuk</p>
<p class="text-xs text-gray-500 dark:text-gray-400">Nutrisi Tepat</p>
</div>
</a>
<!-- Category Item 5 -->
<a class="group flex flex-col items-center gap-3 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-transparent hover:border-primary/30 hover:shadow-md transition-all" href="#">
<div class="w-20 h-20 rounded-full bg-cover bg-center shadow-sm group-hover:scale-105 transition-transform" data-alt="Gardening tools on soil" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBGzOQEORNgBgo3IQ7QqDB89UdXhDl-31h4jhjC3LNakO8_ortoW-w_ZodI-wkirzcR6mioIB65yh2ff21HL8D5KTdEt4Y2nWxzH3l20YG0pn0iAKtUcSU6TyQ80fo6DXIgWX1kKsTrr3tporwdoGp6hFKXc3SFnVWdk4cVMbnZRErFRVGSuWEVvSHwZujMba84oXCcFFnPelMCDOZp2F5IjHLttJgwcR3-0r0uYngQW6d8acHgJy6st3nxiWm_zBspxSu_uGhgz0E");'></div>
<div class="text-center">
<p class="font-semibold text-sm group-hover:text-primary transition-colors">Alat Tani</p>
<p class="text-xs text-gray-500 dark:text-gray-400">Modern</p>
</div>
</a>
<!-- Category Item 6 -->
<a class="group flex flex-col items-center gap-3 p-4 bg-surface-light dark:bg-surface-dark rounded-xl border border-transparent hover:border-primary/30 hover:shadow-md transition-all" href="#">
<div class="w-20 h-20 rounded-full bg-cover bg-center shadow-sm group-hover:scale-105 transition-transform bg-gray-100 flex items-center justify-center text-primary" data-alt="Abstract pattern for more categories">
<span class="material-symbols-outlined text-4xl">grid_view</span>
</div>
<div class="text-center">
<p class="font-semibold text-sm group-hover:text-primary transition-colors">Lainnya</p>
<p class="text-xs text-gray-500 dark:text-gray-400">Lihat Semua</p>
</div>
</a>
</div>
</section>
<!-- Flash Sale Section -->
<section class="px-4 md:px-10 lg:px-40 py-8 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-950/20 dark:to-emerald-950/20">
<div class="flex items-center gap-4 mb-6">
<h2 class="text-xl md:text-2xl font-bold tracking-tight flex items-center gap-2">
<span class="material-symbols-outlined text-orange-500 filled">bolt</span>
                Penawaran Spesial
            </h2>
<div class="bg-red-100 text-red-600 px-3 py-1 rounded text-xs font-bold">Berakhir dalam 04:23:12</div>
</div>
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
<!-- Product Card 1 -->
<div class="bg-surface-light dark:bg-surface-dark rounded-lg overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow group flex flex-col">
<div class="relative aspect-square overflow-hidden bg-gray-100">
<div class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">-20%</div>
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Red ripe strawberries in a basket" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAad8WZaDvJi-szOmG1HdSLRy0P9-tdbQjucc4Rb2KQh43pZBmicim9bCuUwkwTe0Kvxk_iewzGeS0Ab8risUpQYVjkMUIavRwirapHwTAsxrMMum97XA83QY0d06XGZpCCRNSYNM4S_pGSJpd-INe6RoZmkNcVwC0I2v1XK3diXNOAPVHOqg7h6JMPPyb-bmKjKYkLhLTppvB0ZrzQxZ8bOcrGkJ1ku6-h_0CAel2ohCwJHcAP-0luFgPR2xVYL4XEva-bp0uaVEI");'></div>
</div>
<div class="p-3 flex flex-col flex-1">
<p class="text-xs text-gray-500 mb-1">Petani Ciwidey</p>
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white line-clamp-2 mb-2">Strawberry Segar Premium (500g)</h3>
<div class="mt-auto">
<div class="flex items-baseline gap-2 mb-2">
<span class="font-bold text-base">Rp 25.000</span>
<span class="text-xs text-gray-400 line-through">Rp 31.000</span>
</div>
<button class="w-full h-9 rounded bg-primary hover:bg-[#32d611] text-[#101b0d] text-sm font-bold flex items-center justify-center gap-2 transition-colors">
<span class="material-symbols-outlined text-[18px]">add_shopping_cart</span> Beli
                        </button>
</div>
</div>
</div>
<!-- Product Card 2 -->
<div class="bg-surface-light dark:bg-surface-dark rounded-lg overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow group flex flex-col">
<div class="relative aspect-square overflow-hidden bg-gray-100">
<div class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">-15%</div>
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Fresh broccoli head" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDH3IoaxiXwysJ6wkEOFVAIu_1_2eWbCCDj2LV2Qs3o0-GwboUhl4f_O9_tG2QaXpJEPVLjXvIVgdS-cMxew2cYr4Ju_bG95IArpXWEeuRxcN3nqy8gd8mlg6e5jBWw6Vp7jPFOYH1O0MEgu-ZcGlOateSPxW9GcBe5zheWLYS2KeR63BmaazXDAI1QtXVj3pgm3he3fxcp-xOyBLDNUfcdWuFLLFU618ZDGeQvDzhbLf9iClO27dk-uGab-LFhHNQFd9J-p4qfNVc");'></div>
</div>
<div class="p-3 flex flex-col flex-1">
<p class="text-xs text-gray-500 mb-1">Farm Organic</p>
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white line-clamp-2 mb-2">Brokoli Organik Segar (1kg)</h3>
<div class="mt-auto">
<div class="flex items-baseline gap-2 mb-2">
<span class="font-bold text-base">Rp 18.500</span>
<span class="text-xs text-gray-400 line-through">Rp 22.000</span>
</div>
<button class="w-full h-9 rounded bg-surface-light dark:bg-[#1f351a] border border-primary text-primary hover:bg-primary hover:text-[#101b0d] text-sm font-bold flex items-center justify-center gap-2 transition-colors">
                             + Keranjang
                        </button>
</div>
</div>
</div>
<!-- Product Card 3 -->
<div class="bg-surface-light dark:bg-surface-dark rounded-lg overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow group flex flex-col">
<div class="relative aspect-square overflow-hidden bg-gray-100">
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Yellow corn cobs" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCD4HJYEIIpoNAm-yoDbtLg0nGkWdJW6ohX-GfCxhKvcms2saG-Y_mdadVTiI47Zi-4Mhv0cp0nPMqsQ1zOPdAi_hsUkN5ntPoOklK3C3_mT_6r2T7_a7KrRVntOcgkORa3Kui7v5as_rwhkvfXrG3rvtQlEXV76UYv8JlgTb1IEHRxN4Oci0hsdXvrX1qNryxNMzRi8WpD_Io9E1sR9tRiJMUtdg6-BvbPjInHJeGwB0-ks1WjLj8DzTlw-sC0CYnl45dYLMEviT8");'></div>
</div>
<div class="p-3 flex flex-col flex-1">
<p class="text-xs text-gray-500 mb-1">Ladang Subur</p>
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white line-clamp-2 mb-2">Jagung Manis Kupas (3 Pcs)</h3>
<div class="mt-auto">
<div class="flex items-baseline gap-2 mb-2">
<span class="font-bold text-base">Rp 12.000</span>
</div>
<button class="w-full h-9 rounded bg-surface-light dark:bg-[#1f351a] border border-primary text-primary hover:bg-primary hover:text-[#101b0d] text-sm font-bold flex items-center justify-center gap-2 transition-colors">
                             + Keranjang
                        </button>
</div>
</div>
</div>
<!-- Product Card 4 -->
<div class="bg-surface-light dark:bg-surface-dark rounded-lg overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow group flex flex-col">
<div class="relative aspect-square overflow-hidden bg-gray-100">
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Red hot chili peppers" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBOJ91MxCoh9fpVlBS2tpOXzKMurFB-6swJIjHpyP-UjDpqft1wi_g5KsW2wxzFOkNjAcUL0KuS7F4Au7vMeeMV2O3n0gbRRG2dMMYlv3gv8C26aKObUyatUf0O_7McpDarb7J7YYi3rz0Rf9RqPt8-I3WrRBKKpfP2Y_RUJ08tFEZI9admm8AIP-ju1YQPLL9JUmVwWdgJAqxWU9UetUbhSQpLFHc22lL2iFTD3ssmj2JCuHf2Ov_D3_JOWDI9Rx5uistGGI4zqfk");'></div>
</div>
<div class="p-3 flex flex-col flex-1">
<p class="text-xs text-gray-500 mb-1">Petani Cabai</p>
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white line-clamp-2 mb-2">Cabai Merah Keriting (250g)</h3>
<div class="mt-auto">
<div class="flex items-baseline gap-2 mb-2">
<span class="font-bold text-base">Rp 15.000</span>
</div>
<button class="w-full h-9 rounded bg-surface-light dark:bg-[#1f351a] border border-primary text-primary hover:bg-primary hover:text-[#101b0d] text-sm font-bold flex items-center justify-center gap-2 transition-colors">
                             + Keranjang
                        </button>
</div>
</div>
</div>
<!-- Product Card 5 -->
<div class="bg-surface-light dark:bg-surface-dark rounded-lg overflow-hidden border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow group flex flex-col hidden lg:flex">
<div class="relative aspect-square overflow-hidden bg-gray-100">
<div class="absolute top-2 left-2 bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">-10%</div>
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Fresh spinach leaves" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBZ1NIEHQVnEUFwtaGUIZ-HCisxUNW8jfzgZY78R0iJyBfT8P-JLGqmGkSj5zJTqhCm7R_1geJDd0NVG-XKWr6VK6poEJjXTKc4CTa0Q29-0s50gx3Io27K3nWyZL-wQKWCDtIn5YrdYoilliC4DloqNlgR8DS6WaENOcxQ95FR_7_NaTlgUwYlGWv_nR0-JlMbK2UjxiYvis5FyFY6pjtxwbQX0lhA_iDIaUBHKxCeYyz18cT3iFg2BCwvH3xy00hNdIU-HhyexTA");'></div>
</div>
<div class="p-3 flex flex-col flex-1">
<p class="text-xs text-gray-500 mb-1">Green Farm</p>
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white line-clamp-2 mb-2">Bayam Hijau Segar Ikat Besar</h3>
<div class="mt-auto">
<div class="flex items-baseline gap-2 mb-2">
<span class="font-bold text-base">Rp 4.500</span>
<span class="text-xs text-gray-400 line-through">Rp 5.000</span>
</div>
<button class="w-full h-9 rounded bg-surface-light dark:bg-[#1f351a] border border-primary text-primary hover:bg-primary hover:text-[#101b0d] text-sm font-bold flex items-center justify-center gap-2 transition-colors">
                             + Keranjang
                        </button>
</div>
</div>
</div>
</div>
</section>
<!-- Featured Products Grid -->
<section class="px-4 md:px-10 lg:px-40 py-10">
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
<h2 class="text-xl md:text-2xl font-bold tracking-tight">Rekomendasi Untuk Anda</h2>
<div class="flex gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-hide">
<button class="px-4 py-2 rounded-full bg-primary text-[#101b0d] text-sm font-bold whitespace-nowrap">Semua</button>
<button class="px-4 py-2 rounded-full bg-[#e9f3e7] dark:bg-[#2a3f25] hover:bg-gray-200 dark:hover:bg-[#344e2e] text-sm font-medium whitespace-nowrap transition-colors">Sayuran</button>
<button class="px-4 py-2 rounded-full bg-[#e9f3e7] dark:bg-[#2a3f25] hover:bg-gray-200 dark:hover:bg-[#344e2e] text-sm font-medium whitespace-nowrap transition-colors">Buah</button>
<button class="px-4 py-2 rounded-full bg-[#e9f3e7] dark:bg-[#2a3f25] hover:bg-gray-200 dark:hover:bg-[#344e2e] text-sm font-medium whitespace-nowrap transition-colors">Bumbu Dapur</button>
</div>
</div>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-y-8 gap-x-4">
<!-- Repeat product card structure with different data -->
<!-- Card 1 -->
<div class="group flex flex-col gap-2">
<div class="relative aspect-[4/3] rounded-lg overflow-hidden bg-gray-100">
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Fresh carrots with green tops" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD-C94ubXdpfKCzwBEYP6ahdEHRjNf_oWlFXK_ZVNSUe5KRdt8XT6TspPg3bwB9NmoC5Sr6EkmO7oOoWGkZnGlFLYLSqPTxFSaTl5Z0UkzyMweRfB4XmdktBWy5YMJ4NZyjFNPwKtz-6eCT0igSD03v-ySMe0eWOmjvNk4GY3hnvNpxLjhyNdSBzAoSEQh0qPn7YxjeGtnY2q5p94UvFRRNc0nkuFPQCBC-8WKvQ0zDdyHMS2wN9xwOktWlutzgZP4fILTrHi52tZU");'></div>
<button class="absolute bottom-2 right-2 size-8 bg-white dark:bg-[#101b0d] rounded-full flex items-center justify-center shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-primary text-[20px]">add</span>
</button>
</div>
<div>
<div class="flex justify-between items-start">
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white">Wortel Berastagi</h3>
<div class="flex items-center gap-0.5 text-xs text-orange-500 font-bold">
<span class="material-symbols-outlined text-[14px] filled">star</span> 4.8
                        </div>
</div>
<p class="text-xs text-gray-500 mb-1">500 gram</p>
<p class="font-bold text-base text-primary">Rp 8.000</p>
</div>
</div>
<!-- Card 2 -->
<div class="group flex flex-col gap-2">
<div class="relative aspect-[4/3] rounded-lg overflow-hidden bg-gray-100">
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Purple eggplant" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCSfkumhHbkdaheifVsyWMTvSJJILuo8_xZ_a4B_Dlmcnp0TKcC1U0u0gl-nVyHAACROx4Jm-F88EdktdgqMtBR9q17-ZpTXmT4GECk8evAlC_7ub1gXYcz2efVwqnXZV2Wxg5bUQsLB_TPIN1n4uwbv3zcOOyzAVUNqtquuBnxq9pA2xCgndXZDk-fUJXJmHLze9q9ZYnBIhmElGSLF3LCq3PynTIuBAOyruYtZqgasp2SmeB3YWL1VKooEt_VuwfyXLz3-2XOIwA");'></div>
<button class="absolute bottom-2 right-2 size-8 bg-white dark:bg-[#101b0d] rounded-full flex items-center justify-center shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-primary text-[20px]">add</span>
</button>
</div>
<div>
<div class="flex justify-between items-start">
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white">Terong Ungu</h3>
<div class="flex items-center gap-0.5 text-xs text-orange-500 font-bold">
<span class="material-symbols-outlined text-[14px] filled">star</span> 4.5
                        </div>
</div>
<p class="text-xs text-gray-500 mb-1">500 gram</p>
<p class="font-bold text-base text-primary">Rp 7.500</p>
</div>
</div>
<!-- Card 3 -->
<div class="group flex flex-col gap-2">
<div class="relative aspect-[4/3] rounded-lg overflow-hidden bg-gray-100">
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Fresh tomatoes" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBG78PMnBEL3BSGYaaWIy8MWZUhFxZcLaR7fN-QyTLFRabu9NYa89oDQA7Palh-tc3xhFVfJGdTnxx_JY0bWtSonLZbpTXkSD1IbpAwNoiTvG31GU2yV1TtxedX9GNuksSGvPsd7DvM4uOrGPONgbDcaGjmEGKZCFqfgR4fKCCaYnvW6HCf4lWcpJDotkjj0xuLXalk1VecvCTw5rJ36DolsD-ApthLlF8jrJkr6g5q957FuFehvrezffCZyPggN5ycI_w1aZ4YSm0");'></div>
<button class="absolute bottom-2 right-2 size-8 bg-white dark:bg-[#101b0d] rounded-full flex items-center justify-center shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-primary text-[20px]">add</span>
</button>
</div>
<div>
<div class="flex justify-between items-start">
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white">Tomat Merah</h3>
<div class="flex items-center gap-0.5 text-xs text-orange-500 font-bold">
<span class="material-symbols-outlined text-[14px] filled">star</span> 4.9
                        </div>
</div>
<p class="text-xs text-gray-500 mb-1">1 kg</p>
<p class="font-bold text-base text-primary">Rp 12.000</p>
</div>
</div>
<!-- Card 4 -->
<div class="group flex flex-col gap-2">
<div class="relative aspect-[4/3] rounded-lg overflow-hidden bg-gray-100">
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Ginger root" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDTv38gDoFlYV7FldIGfSGXAUbX_UI72Z3wscmANhJdSiE9ST9myjbSGvAOqJwwsxmu-Gip04vmhemTvB6F2JbClm2_jAEStT0kWiWWxermLbca-8Ib2YHM-XRGwQ7i0M50wT2kRoTEXYxlaD5ZTcNm-phh8p0muK_05f67fdKyzvGz13PZxfQSamipUJ3ERTymCVWP3iQv3oahYJB-jQJRIw4bTsS-khykmhr49xC21_PLcBZ2d3oa36SCAy-AfBpN6dwR5rH49x0");'></div>
<button class="absolute bottom-2 right-2 size-8 bg-white dark:bg-[#101b0d] rounded-full flex items-center justify-center shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-primary text-[20px]">add</span>
</button>
</div>
<div>
<div class="flex justify-between items-start">
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white">Jahe Merah</h3>
<div class="flex items-center gap-0.5 text-xs text-orange-500 font-bold">
<span class="material-symbols-outlined text-[14px] filled">star</span> 5.0
                        </div>
</div>
<p class="text-xs text-gray-500 mb-1">250 gram</p>
<p class="font-bold text-base text-primary">Rp 15.000</p>
</div>
</div>
<!-- Card 5 -->
<div class="group flex flex-col gap-2">
<div class="relative aspect-[4/3] rounded-lg overflow-hidden bg-gray-100">
<div class="w-full h-full bg-cover bg-center group-hover:scale-105 transition-transform duration-300" data-alt="Pack of organic rice" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAqAYlMm_br3Mmp_lezinUg0UvCSMpom8DVa-RCSD6iTopU2FoHEBMP-0cYKHSqBWRMMTSdzxvzw3oulobETUy90d7U3O_OPDfhJyY5K6uJcZ80GkAnM7uV0tUSIH7eDHbYmTJ4K7nAPNug67ki9bdh7KL_QeCkvDetz2whvFTBg389QEb2dX4RTrIXgbUKvqnw83a3mvdVyScPlFgHFSrULhdFVe80JYvn5mFZbPO-zk_QMShZv8HmkP1irjtMAZx9LDsn3vF9hbI");'></div>
<button class="absolute bottom-2 right-2 size-8 bg-white dark:bg-[#101b0d] rounded-full flex items-center justify-center shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
<span class="material-symbols-outlined text-primary text-[20px]">add</span>
</button>
</div>
<div>
<div class="flex justify-between items-start">
<h3 class="font-bold text-sm text-[#101b0d] dark:text-white">Beras Organik Pandan</h3>
<div class="flex items-center gap-0.5 text-xs text-orange-500 font-bold">
<span class="material-symbols-outlined text-[14px] filled">star</span> 4.7
                        </div>
</div>
<p class="text-xs text-gray-500 mb-1">5 kg</p>
<p class="font-bold text-base text-primary">Rp 85.000</p>
</div>
</div>
</div>
<div class="mt-10 flex justify-center">
<button class="px-8 py-3 rounded-lg border-2 border-primary text-primary hover:bg-primary hover:text-[#101b0d] font-bold text-sm transition-colors">
                Lihat Produk Lainnya
            </button>
</div>
</section>
<!-- App Download Banner (Optional) -->
<div class="px-4 md:px-10 lg:px-40 py-10">
<div class="bg-[#101b0d] rounded-2xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
<!-- Decorative circle -->
<div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
<div class="flex flex-col gap-4 max-w-lg relative z-10">
<h2 class="text-white text-2xl md:text-3xl font-bold">Belanja Lebih Mudah dengan Aplikasi AgriMart</h2>
<p class="text-gray-300 text-sm md:text-base">Dapatkan notifikasi promo eksklusif dan lacak pesananmu secara real-time dari genggaman.</p>
<div class="flex gap-4 mt-2">
<button class="h-10 px-4 bg-white/10 hover:bg-white/20 rounded-lg flex items-center gap-2 text-white text-xs font-bold border border-white/20 transition-colors">
<span class="material-symbols-outlined">android</span> Google Play
                    </button>
<button class="h-10 px-4 bg-white/10 hover:bg-white/20 rounded-lg flex items-center gap-2 text-white text-xs font-bold border border-white/20 transition-colors">
<span class="material-symbols-outlined">phone_iphone</span> App Store
                    </button>
</div>
</div>
<div class="relative z-10 hidden md:block w-64 h-40 bg-contain bg-center bg-no-repeat" data-alt="Mockup of a smartphone showing the AgriMart app" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBypnh26WKZT5gGZhDXXQjYaMmVwwFFgWCUDxWvZ25vwl1XcLTx2dVDz2iiMG7yI2CpXr4MEv1wd3y3jxEbaHCRiTmNoG_nBgLe7i6nE2cymoEVTeAYVw2B6EWk-z9ijPYONRnwOZfw225JL-IC3oQ_qv-jtmem7TnFM_4wZbhqW-BwB42IMWzi2I3pYNzFHwOXebuj5E0M_X9yJsPrZEN5tIChmfUsbboIQ8cts7d977Xhu6DEBhQ53QgvfJWK6VJ24ZTJ726rvjc"); mask-image: linear-gradient(to bottom, black 80%, transparent 100%); -webkit-mask-image: linear-gradient(to bottom, black 80%, transparent 100%);'>
</div>
</div>
</div>
</main>
<!-- Footer -->
<footer class="bg-surface-light dark:bg-surface-dark border-t border-[#e9f3e7] dark:border-[#2a3f25] pt-12 pb-6">
<div class="px-4 md:px-10 lg:px-40">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
<!-- Brand -->
<div class="flex flex-col gap-4">
<div class="flex items-center gap-2 text-[#101b0d] dark:text-white">
<div class="size-6 text-primary">
<svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_footer)">
<path clip-rule="evenodd" d="M47.2426 24L24 47.2426L0.757355 24L24 0.757355L47.2426 24ZM12.2426 21H35.7574L24 9.24264L12.2426 21Z" fill="currentColor" fill-rule="evenodd"></path>
</g>
<defs>
<clippath id="clip0_footer"><rect fill="white" height="48" width="48"></rect></clippath>
</defs>
</svg>
</div>
<h2 class="text-lg font-bold">AgriMart</h2>
</div>
<p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                    Platform e-commerce pertanian terpercaya yang menghubungkan petani lokal dengan konsumen untuk masa depan yang lebih hijau.
                </p>
</div>
<!-- Links -->
<div class="flex flex-col gap-4">
<h3 class="font-bold text-[#101b0d] dark:text-white">Perusahaan</h3>
<div class="flex flex-col gap-2 text-sm text-gray-500 dark:text-gray-400">
<a class="hover:text-primary transition-colors" href="#">Tentang Kami</a>
<a class="hover:text-primary transition-colors" href="#">Blog</a>
<a class="hover:text-primary transition-colors" href="#">Karir</a>
<a class="hover:text-primary transition-colors" href="#">Mitra Petani</a>
</div>
</div>
<!-- Links -->
<div class="flex flex-col gap-4">
<h3 class="font-bold text-[#101b0d] dark:text-white">Bantuan</h3>
<div class="flex flex-col gap-2 text-sm text-gray-500 dark:text-gray-400">
<a class="hover:text-primary transition-colors" href="#">Pusat Bantuan</a>
<a class="hover:text-primary transition-colors" href="#">Syarat &amp; Ketentuan</a>
<a class="hover:text-primary transition-colors" href="#">Kebijakan Privasi</a>
<a class="hover:text-primary transition-colors" href="#">Pengembalian Dana</a>
</div>
</div>
<!-- Newsletter -->
<div class="flex flex-col gap-4">
<h3 class="font-bold text-[#101b0d] dark:text-white">Berlangganan</h3>
<p class="text-sm text-gray-500 dark:text-gray-400">Dapatkan info promo dan panen terbaru.</p>
<div class="flex gap-2">
<input class="flex-1 bg-[#f0f5ee] dark:bg-[#1a2e16] border-none rounded-lg px-3 py-2 text-sm placeholder-gray-400 focus:ring-1 focus:ring-primary" placeholder="Email Anda" type="email"/>
<button class="bg-primary hover:bg-[#32d611] text-[#101b0d] rounded-lg px-4 py-2 text-sm font-bold transition-colors">
                        Kirim
                    </button>
</div>
</div>
</div>
<div class="pt-8 border-t border-[#e9f3e7] dark:border-[#2a3f25] flex flex-col md:flex-row items-center justify-between gap-4">
<p class="text-xs text-gray-400">© 2024 AgriMart Indonesia. All rights reserved.</p>
<div class="flex gap-4">
<a class="text-gray-400 hover:text-primary transition-colors" href="#"><span class="sr-only">Instagram</span>IG</a>
<a class="text-gray-400 hover:text-primary transition-colors" href="#"><span class="sr-only">Twitter</span>TW</a>
<a class="text-gray-400 hover:text-primary transition-colors" href="#"><span class="sr-only">Facebook</span>FB</a>
</div>
</div>
</div>
</footer>
</body></html>