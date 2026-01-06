<!DOCTYPE html>

<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Halaman Dashboard Pengguna - AgriMart</title>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Theme Configuration -->
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#37ec13",
                        "background-light": "#f6f8f6",
                        "background-dark": "#0a1108",
                        "surface-light": "#ffffff",
                        "surface-dark": "#132210",
                        "border-light": "#e9f3e7",
                        "border-dark": "#1f351a",
                        "text-main": "#101b0d",
                        "text-muted": "#599a4c",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-text-main dark:text-white transition-colors duration-200">
<!-- Main Layout Wrapper -->
<div class="flex flex-col min-h-screen w-full">
<!-- Header / TopNavBar -->
<header class="sticky top-0 z-50 flex items-center justify-between whitespace-nowrap border-b border-solid border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark px-4 lg:px-10 py-3 shadow-sm transition-colors duration-200">
<div class="flex items-center gap-4 lg:gap-8 w-full max-w-[1440px] mx-auto">
<!-- Logo -->
<div class="flex items-center gap-2 lg:gap-4 text-text-main dark:text-white">
<div class="size-8 text-primary flex items-center justify-center rounded-lg bg-background-light dark:bg-background-dark">
<span class="material-symbols-outlined text-3xl">potted_plant</span>
</div>
<h2 class="text-text-main dark:text-white text-xl font-bold leading-tight tracking-[-0.015em] hidden sm:block">AgriMart</h2>
</div>
<!-- Search Bar -->
<label class="hidden md:flex flex-col min-w-40 h-10 max-w-96 flex-1 ml-4 lg:ml-8">
<div class="flex w-full flex-1 items-stretch rounded-lg h-full border border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark overflow-hidden focus-within:ring-2 focus-within:ring-primary/50 transition-all">
<div class="text-text-muted flex items-center justify-center pl-4 pr-2">
<span class="material-symbols-outlined text-[20px]">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden border-none bg-transparent focus:outline-0 focus:ring-0 h-full placeholder:text-text-muted/70 px-0 text-base font-normal leading-normal text-text-main dark:text-white" placeholder="Cari bibit, pupuk, atau alat..." value=""/>
</div>
</label>
<!-- Right Actions -->
<div class="flex flex-1 justify-end gap-3 lg:gap-6 items-center">
<div class="flex gap-2">
<button class="flex items-center justify-center size-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-main dark:text-white transition-colors relative group">
<span class="material-symbols-outlined">shopping_cart</span>
<span class="absolute top-1 right-1 size-2.5 bg-primary rounded-full border-2 border-surface-light dark:border-surface-dark"></span>
</button>
<button class="flex items-center justify-center size-10 rounded-full hover:bg-background-light dark:hover:bg-gray-800 text-text-main dark:text-white transition-colors">
<span class="material-symbols-outlined">notifications</span>
</button>
</div>
<!-- User Avatar -->
<div class="bg-center bg-no-repeat bg-cover rounded-full size-10 border-2 border-primary cursor-pointer hover:ring-2 hover:ring-primary/30 transition-all" data-alt="User profile picture showing a smiling person" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB71mFxcNeX4cZezH3M3jiy9T0kj0Z395c_tclQz1xzZactFi8Z5LWQpqindbV_m_BJVV19DDZST72jvzPpBRstsUSdek6QFJxJkkX-bClYSvtmabkr6cl6byOxIvVbWrW1WpOj7F-RhRFpkOt6cyiBV2vMFzDkcU7-39DXlNPx21D-08c9GJrEYy_ByA1UiqCiANitf2zt84SdiieWZsse0wdNhc-i2fTiupibWwjRIqL3qYykx54Irshj7zwL7JB7bMPMlJBfjXY");'>
</div>
</div>
</div>
</header>
<!-- Main Content Area -->
<main class="flex-1 w-full max-w-[1440px] mx-auto flex flex-col md:flex-row p-4 lg:p-6 gap-6">
<!-- SideNavBar (Desktop Sidebar) -->
<aside class="hidden md:flex w-64 flex-col gap-4 shrink-0">
<div class="flex flex-col justify-between bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark p-4 shadow-sm h-fit sticky top-24 transition-colors duration-200">
<div class="flex flex-col gap-4">
<h1 class="text-text-muted text-xs font-bold uppercase tracking-wider px-3 mt-2">Menu Utama</h1>
<div class="flex flex-col gap-1">
<!-- Dashboard Active -->
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 dark:bg-primary/20 text-primary-dark dark:text-primary font-medium transition-colors" href="#">
<span class="material-symbols-outlined fill-current">dashboard</span>
<span class="text-sm font-semibold text-text-main dark:text-white">Dashboard</span>
</a>
<!-- Inactive Links -->
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-background-light dark:hover:bg-background-dark text-text-main dark:text-gray-300 transition-colors group" href="#">
<span class="material-symbols-outlined text-text-muted group-hover:text-text-main dark:group-hover:text-white transition-colors">shopping_bag</span>
<span class="text-sm font-medium">Pesanan Saya</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-background-light dark:hover:bg-background-dark text-text-main dark:text-gray-300 transition-colors group" href="#">
<span class="material-symbols-outlined text-text-muted group-hover:text-text-main dark:group-hover:text-white transition-colors">favorite</span>
<span class="text-sm font-medium">Wishlist</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-background-light dark:hover:bg-background-dark text-text-main dark:text-gray-300 transition-colors group" href="#">
<span class="material-symbols-outlined text-text-muted group-hover:text-text-main dark:group-hover:text-white transition-colors">location_on</span>
<span class="text-sm font-medium">Buku Alamat</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-background-light dark:hover:bg-background-dark text-text-main dark:text-gray-300 transition-colors group" href="#">
<span class="material-symbols-outlined text-text-muted group-hover:text-text-main dark:group-hover:text-white transition-colors">settings</span>
<span class="text-sm font-medium">Pengaturan</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-background-light dark:hover:bg-background-dark text-text-main dark:text-gray-300 transition-colors group" href="#">
<span class="material-symbols-outlined text-text-muted group-hover:text-text-main dark:group-hover:text-white transition-colors">support_agent</span>
<span class="text-sm font-medium">Bantuan</span>
</a>
</div>
</div>
<div class="pt-4 border-t border-border-light dark:border-border-dark mt-4">
<button class="flex w-full cursor-pointer items-center justify-start gap-3 rounded-lg h-10 px-3 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 text-sm font-bold leading-normal tracking-[0.015em] transition-colors">
<span class="material-symbols-outlined">logout</span>
<span class="truncate">Keluar</span>
</button>
</div>
</div>
<!-- Promo Card Sidebar -->
<div class="bg-gradient-to-br from-[#132210] to-[#2c4e25] rounded-xl p-5 text-white shadow-lg hidden lg:block" data-alt="Dark green abstract leaf texture background" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBDq4KlmZW427G0Zl0J-772wfY2VYGk-6qYrQdAD2DPxmtjj2HhssfZuUTFZEjv-zpcCPJgRqKXuDy3xZtLWPjqh88H2n3eR9j9dCRCDhdhjRgMm1DlN-Q6ou_v4OV2UxX0effQRS6dfqEApjJxtURGbSvetcm_vj0zitq0sd49qozfG6_eIQlGmI5buDuLYjQ7aEBxgt06LH9kiDErBqmcfZn7McRTwIQUXOuxHsI7qbvJrzwEwkxWqr1Pt32m-k2wUSxOZ3f4WTU'); background-blend-mode: overlay; background-size: cover;">
<h3 class="font-bold text-lg mb-2">Panen Raya?</h3>
<p class="text-sm opacity-90 mb-4">Dapatkan diskon khusus pupuk majemuk untuk persiapan musim tanam.</p>
<button class="bg-primary text-text-main text-xs font-bold py-2 px-4 rounded-lg w-full hover:bg-white transition-colors">Cek Promo</button>
</div>
</aside>
<!-- Dashboard Content -->
<div class="flex-1 flex flex-col gap-6 w-full min-w-0">
<!-- Welcome & Stats Section -->
<section class="flex flex-col gap-6">
<!-- Welcome Card -->
<div class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 border border-border-light dark:border-border-dark shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-colors duration-200">
<div class="flex flex-col gap-1">
<h1 class="text-text-main dark:text-white text-2xl md:text-3xl font-bold leading-tight">Halo, Budi Santoso! 👋</h1>
<div class="flex items-center gap-2">
<span class="text-text-muted dark:text-gray-400 text-sm md:text-base font-normal">Member Level:</span>
<span class="bg-primary/20 text-green-800 dark:text-green-300 px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide">Petani Pemula</span>
</div>
</div>
<button class="bg-primary hover:bg-[#2ed60e] text-text-main px-5 py-2.5 rounded-lg text-sm font-bold shadow-sm transition-all flex items-center gap-2">
<span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                            Belanja Lagi
                        </button>
</div>
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
<!-- Stat 1 -->
<div class="flex flex-col justify-between rounded-xl p-5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-sm hover:border-primary/50 transition-colors group">
<div class="flex justify-between items-start">
<p class="text-text-muted dark:text-gray-400 text-sm font-medium">Menunggu Pembayaran</p>
<span class="material-symbols-outlined text-orange-500 bg-orange-100 dark:bg-orange-900/30 p-1.5 rounded-lg">payments</span>
</div>
<p class="text-text-main dark:text-white text-3xl font-bold mt-2">1</p>
</div>
<!-- Stat 2 -->
<div class="flex flex-col justify-between rounded-xl p-5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-sm hover:border-primary/50 transition-colors group">
<div class="flex justify-between items-start">
<p class="text-text-muted dark:text-gray-400 text-sm font-medium">Diproses</p>
<span class="material-symbols-outlined text-blue-500 bg-blue-100 dark:bg-blue-900/30 p-1.5 rounded-lg">inventory_2</span>
</div>
<p class="text-text-main dark:text-white text-3xl font-bold mt-2">2</p>
</div>
<!-- Stat 3 -->
<div class="flex flex-col justify-between rounded-xl p-5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-sm hover:border-primary/50 transition-colors group">
<div class="flex justify-between items-start">
<p class="text-text-muted dark:text-gray-400 text-sm font-medium">Dalam Pengiriman</p>
<span class="material-symbols-outlined text-purple-500 bg-purple-100 dark:bg-purple-900/30 p-1.5 rounded-lg">local_shipping</span>
</div>
<p class="text-text-main dark:text-white text-3xl font-bold mt-2">1</p>
</div>
<!-- Stat 4 -->
<div class="flex flex-col justify-between rounded-xl p-5 bg-surface-light dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-sm hover:border-primary/50 transition-colors group">
<div class="flex justify-between items-start">
<p class="text-text-muted dark:text-gray-400 text-sm font-medium">Voucher Aktif</p>
<span class="material-symbols-outlined text-primary bg-green-100 dark:bg-green-900/30 p-1.5 rounded-lg">confirmation_number</span>
</div>
<p class="text-text-main dark:text-white text-3xl font-bold mt-2">3</p>
</div>
</div>
</section>
<!-- Two Column Lower Section -->
<div class="flex flex-col xl:flex-row gap-6">
<!-- Recent Orders List -->
<div class="flex-1 flex flex-col bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm overflow-hidden transition-colors duration-200">
<div class="flex items-center justify-between p-5 border-b border-border-light dark:border-border-dark">
<h2 class="text-text-main dark:text-white text-lg font-bold">Pesanan Terbaru</h2>
<a class="text-primary hover:text-green-600 dark:hover:text-green-300 text-sm font-semibold flex items-center" href="#">
                                Lihat Semua 
                                <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
</a>
</div>
<div class="flex flex-col">
<!-- Order Item 1 -->
<div class="p-5 border-b border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors">
<div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center mb-3">
<div class="flex items-center gap-2 text-xs text-text-muted dark:text-gray-400">
<span class="font-medium text-text-main dark:text-gray-300">ORD-2023-8821</span>
<span>•</span>
<span>12 Okt 2023</span>
</div>
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
<span class="size-1.5 rounded-full bg-blue-500"></span>
                                        Diproses
                                    </span>
</div>
<div class="flex gap-4 items-center">
<div class="size-16 rounded-lg bg-gray-100 dark:bg-gray-800 shrink-0 bg-cover bg-center" data-alt="Pack of organic fertilizer showing brown granules" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuABboyCfwa3hR61EuiuwUBpJ4tgfB7OBhUXkfV4_tRs6_3IbJNLTDF9YR8y13pvN0i4sWK7Cg__jHp-YOSzw3IY3dhcl-fJBK_wht8ZryXVUQJu-F3V9ngR4pLJxe-LcaeHxgE1Avk-s28NKgoyBmzX2UnfHGK1yIfVuIIFrUSKVqWkjWuw711MDJJUgnHYM9Pa9irJa9PIrqXAV3qIgYlJNOrltAPePncWtOX4Hgr3sQHm--CpvjNbyzJtXG2QTunHshCETb8-cas');">
</div>
<div class="flex-1 min-w-0">
<h3 class="text-text-main dark:text-white font-semibold truncate">Pupuk Organik Padat (5kg)</h3>
<p class="text-text-muted text-sm">+ 2 item lainnya</p>
</div>
<div class="text-right shrink-0">
<p class="text-xs text-text-muted dark:text-gray-400 mb-1">Total Belanja</p>
<p class="text-text-main dark:text-white font-bold">Rp 75.000</p>
</div>
</div>
</div>
<!-- Order Item 2 -->
<div class="p-5 border-b border-border-light dark:border-border-dark hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors">
<div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center mb-3">
<div class="flex items-center gap-2 text-xs text-text-muted dark:text-gray-400">
<span class="font-medium text-text-main dark:text-gray-300">ORD-2023-8819</span>
<span>•</span>
<span>10 Okt 2023</span>
</div>
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
<span class="size-1.5 rounded-full bg-purple-500"></span>
                                        Dikirim
                                    </span>
</div>
<div class="flex gap-4 items-center">
<div class="size-16 rounded-lg bg-gray-100 dark:bg-gray-800 shrink-0 bg-cover bg-center" data-alt="Close up of green durian fruit skin" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDdJ-1dBalBV3cn8SDU0zC7KnBGtl8mqw5YuxeBdV8K3KwEAB5if4r7mpaLT0QTo61aYu8N4yvWgNWHgFrO9DPoRnkgdkP3M_2mhr-7t3f6pwU0lKf7phsXtV6q_KewrDt8rvdn4FCAuG8ElMQzR3izrM7aKZMMcft9DSGOaSouUPw0ed8pd2x9DCdYTzKY2D8cupWhg6JvTDI35VKqhD6UXPIj5S_I6M8yQUa0WbNVsiG0_ql6DFY2-L71VNiPLg5BFvqbWpBWK2k');">
</div>
<div class="flex-1 min-w-0">
<h3 class="text-text-main dark:text-white font-semibold truncate">Bibit Durian Musang King</h3>
<p class="text-text-muted text-sm">1 Bibit Siap Tanam</p>
</div>
<div class="text-right shrink-0">
<p class="text-xs text-text-muted dark:text-gray-400 mb-1">Total Belanja</p>
<p class="text-text-main dark:text-white font-bold">Rp 150.000</p>
</div>
</div>
<div class="mt-4 flex justify-end">
<button class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
<span class="material-symbols-outlined text-sm">local_shipping</span>
                                        Lacak Paket
                                    </button>
</div>
</div>
<!-- Order Item 3 -->
<div class="p-5 hover:bg-background-light dark:hover:bg-background-dark/50 transition-colors">
<div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center mb-3">
<div class="flex items-center gap-2 text-xs text-text-muted dark:text-gray-400">
<span class="font-medium text-text-main dark:text-gray-300">ORD-2023-7740</span>
<span>•</span>
<span>01 Okt 2023</span>
</div>
<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">
<span class="material-symbols-outlined text-[14px]">check</span>
                                        Selesai
                                    </span>
</div>
<div class="flex gap-4 items-center">
<div class="size-16 rounded-lg bg-gray-100 dark:bg-gray-800 shrink-0 bg-cover bg-center" data-alt="Metal garden trowel with wooden handle on soil" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDio5FbcSRsbVElaM-sk4IW0Tuq8T7zuB8f-G8pMLKNHPX5urCRze9NJcluXXC3j5ETmToG5uIKFo7GDOeeOLnrZ0OG9jX91hqQ09HnnOWryguwWxfpyGuvDG0zEu-4gMu7St9BlpoGSU4DCUV3py6q9DSCDS3aQBUuZWxlH8ci0iS1ajLHoqBRSGR4GSybG7kA6vQDwAyMlJHe0m04j-HlazgS-cgvP9483EDwNS5vadhxn42VPm05bYl0LhWnKytJk1InrrA3lPA');">
</div>
<div class="flex-1 min-w-0">
<h3 class="text-text-main dark:text-white font-semibold truncate">Sekop Taman Baja</h3>
<p class="text-text-muted text-sm">Alat Pertanian</p>
</div>
<div class="text-right shrink-0">
<p class="text-xs text-text-muted dark:text-gray-400 mb-1">Total Belanja</p>
<p class="text-text-main dark:text-white font-bold">Rp 45.000</p>
</div>
</div>
</div>
</div>
</div>
<!-- Right Side Column (Address & Profile) -->
<div class="w-full xl:w-80 flex flex-col gap-6 shrink-0">
<!-- Default Address Card -->
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm p-5 transition-colors duration-200">
<div class="flex items-center justify-between mb-4">
<h3 class="text-text-main dark:text-white font-bold text-base">Alamat Utama</h3>
<button class="text-primary hover:text-green-600 dark:hover:text-green-300 text-xs font-bold">UBAH</button>
</div>
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-text-muted mt-0.5">home_pin</span>
<div>
<p class="text-sm font-bold text-text-main dark:text-white">Rumah</p>
<p class="text-sm text-text-main dark:text-gray-300 mt-1">Budi Santoso</p>
<p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed mt-1">
                                        Jl. Merpati No. 12, RT 05 RW 02, Desa Sinduadi, Mlati, Sleman, Yogyakarta, 55284
                                    </p>
<p class="text-sm text-text-main dark:text-gray-300 mt-2 font-medium">0812-3456-7890</p>
</div>
</div>
<div class="mt-4 pt-4 border-t border-border-light dark:border-border-dark">
<div class="h-24 w-full rounded-lg bg-gray-200 dark:bg-gray-700 bg-cover bg-center" data-alt="Small map preview of Yogyakarta area" data-location="Sleman, Yogyakarta" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuADiXIWar2fPqpmnvZNodk2pL8cV0S7kE78uXOvS81hrum3KqrZD2JKp68uMdeWkgrN6-yZUTd0YbiDVZnxQRgiUxJCr4Dj3XAay2Jz5YZ7c8VdDwM8FB1pyHt3kZfMrD--H-uV_CIQo3e97dqDsVpFpP6LEnjsp4d6chfp3yUil_2nxONAZsnJIiGebVGdwH44b7pX0sNoXd6tpZwcuJ5d3yuC_5bZLIYxuRjBGZ8TFuvW_hOxkaLk75xpex7KyZys7jhSaOaO0sc')"></div>
</div>
</div>
<!-- Help Center Card -->
<div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-900/30 p-5 flex flex-col items-center text-center">
<div class="size-12 rounded-full bg-blue-100 dark:bg-blue-800 text-blue-600 dark:text-blue-200 flex items-center justify-center mb-3">
<span class="material-symbols-outlined">headset_mic</span>
</div>
<h3 class="text-text-main dark:text-white font-bold text-sm">Butuh Bantuan Pertanian?</h3>
<p class="text-xs text-text-muted dark:text-gray-400 mt-2 mb-4">Tim agronomis kami siap membantu masalah tanaman Anda.</p>
<button class="w-full bg-white dark:bg-surface-dark border border-blue-200 dark:border-blue-800 text-blue-600 dark:text-blue-300 py-2 rounded-lg text-xs font-bold hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                                Chat Agronomis
                            </button>
</div>
</div>
</div>
</div>
</main>
</div>
</body></html>