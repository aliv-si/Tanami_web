<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Katalog Produk - AgriStore</title>
<!-- Material Symbols Link -->
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
              "primary-hover": "#2ec510",
              "background-light": "#f6f8f6",
              "background-dark": "#132210",
              "secondary-text": "#599a4c",
              "dark-text": "#101b0d",
              "light-border": "#e9f3e7",
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
            font-family: 'Inter', "Noto Sans", sans-serif;
        }
        /* Custom scrollbar for sidebar if needed */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #d3e7cf; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #599a4c; 
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark min-h-screen flex flex-col text-dark-text">
<!-- Top Navigation Bar -->
<header class="sticky top-0 z-50 w-full bg-[#f9fcf8] border-b border-solid border-light-border px-4 md:px-10 py-3 shadow-sm">
<div class="mx-auto max-w-7xl flex items-center justify-between gap-4">
<!-- Logo & Brand -->
<div class="flex items-center gap-2 text-dark-text shrink-0">
<div class="size-8 text-primary flex items-center justify-center">
<span class="material-symbols-outlined text-3xl">agriculture</span>
</div>
<h2 class="text-dark-text text-xl font-bold leading-tight tracking-tight hidden sm:block">AgriStore</h2>
</div>
<!-- Search Bar (Desktop) -->
<div class="hidden md:flex flex-1 max-w-xl px-8">
<label class="flex flex-col w-full h-10">
<div class="flex w-full flex-1 items-stretch rounded-lg h-full overflow-hidden border border-transparent focus-within:border-primary/50 transition-colors">
<div class="text-secondary-text flex bg-[#e9f3e7] items-center justify-center pl-4 pr-2">
<span class="material-symbols-outlined text-[20px]">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none text-dark-text focus:outline-0 focus:ring-0 border-none bg-[#e9f3e7] focus:border-none h-full placeholder:text-secondary-text/70 px-2 text-sm font-normal leading-normal" placeholder="Cari beras, pupuk, atau alat tani..." value=""/>
</div>
</label>
</div>
<!-- Right Actions -->
<div class="flex items-center gap-4 md:gap-6 shrink-0">
<div class="hidden lg:flex items-center gap-6">
<a class="text-dark-text text-sm font-medium hover:text-primary transition-colors" href="#">Beranda</a>
<a class="text-primary text-sm font-bold" href="#">Katalog</a>
<a class="text-dark-text text-sm font-medium hover:text-primary transition-colors" href="#">Promo</a>
<a class="text-dark-text text-sm font-medium hover:text-primary transition-colors" href="#">Tentang Kami</a>
</div>
<div class="flex gap-2">
<button class="relative flex items-center justify-center rounded-lg size-10 bg-[#e9f3e7] text-dark-text hover:bg-primary/20 hover:text-primary transition-colors">
<span class="material-symbols-outlined text-[20px]">shopping_cart</span>
<span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] text-white font-bold">2</span>
</button>
<button class="flex items-center justify-center rounded-lg size-10 bg-[#e9f3e7] text-dark-text hover:bg-primary/20 hover:text-primary transition-colors">
<span class="material-symbols-outlined text-[20px]">favorite</span>
</button>
<button class="hidden sm:flex items-center justify-center rounded-lg size-10 bg-[#e9f3e7] text-dark-text hover:bg-primary/20 hover:text-primary transition-colors">
<span class="material-symbols-outlined text-[20px]">account_circle</span>
</button>
</div>
<!-- Profile Image -->
<div class="bg-center bg-no-repeat bg-cover rounded-full size-10 border border-light-border cursor-pointer" data-alt="User profile picture placeholder with abstract gradient" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCvDhpVj4bJj8MIi5CiX70zp4ulieIq4q3ogvPlaCGRVAA-nF409xEU8MN3JUxVpnUkvgcAlvn0NRNgOGsenD3ZBhB30DqVLBLkxxOm2Gg653MZIJccmnQU_-C_e0LAQ0AZ8v9BMINiUNsbM22P5hGDYIoV3GrYLePAPZHfrzuEPOyC_NBxoArxyNks_C44Q738fEl7GaOA4fGdvcmgRGz2SXlhLIcJyTDCZCRFWdaCo-zjVxp6_G_eiyMdwakfp6nQUgHN_NTd_AU");'>
</div>
</div>
</div>
<!-- Mobile Search (Visible only on small screens) -->
<div class="md:hidden mt-3 w-full">
<label class="flex flex-col w-full h-10">
<div class="flex w-full flex-1 items-stretch rounded-lg h-full overflow-hidden">
<div class="text-secondary-text flex bg-[#e9f3e7] items-center justify-center pl-4 pr-2">
<span class="material-symbols-outlined text-[20px]">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none text-dark-text focus:outline-0 focus:ring-0 border-none bg-[#e9f3e7] h-full placeholder:text-secondary-text/70 px-2 text-sm" placeholder="Cari produk..."/>
</div>
</label>
</div>
</header>
<main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-10 py-6">
<!-- Breadcrumbs -->
<nav class="flex flex-wrap gap-2 py-2 mb-4 text-sm">
<a class="text-secondary-text hover:underline" href="#">Beranda</a>
<span class="text-secondary-text">/</span>
<span class="text-dark-text font-medium">Katalog</span>
</nav>
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
<div>
<h1 class="text-dark-text text-3xl font-bold tracking-tight">Katalog Produk Pertanian</h1>
<p class="text-secondary-text mt-1 text-sm">Temukan hasil tani terbaik langsung dari petani lokal.</p>
</div>
<div class="flex items-center gap-3">
<span class="text-sm font-medium text-dark-text whitespace-nowrap">Urutkan:</span>
<div class="relative min-w-[180px]">
<select class="w-full appearance-none rounded-lg bg-white border border-light-border px-4 py-2.5 pr-8 text-sm font-medium text-dark-text focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary cursor-pointer">
<option>Paling Relevan</option>
<option>Terbaru</option>
<option>Harga: Rendah ke Tinggi</option>
<option>Harga: Tinggi ke Rendah</option>
<option>Rating Tertinggi</option>
</select>
<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-dark-text">
<span class="material-symbols-outlined">expand_more</span>
</div>
</div>
</div>
</div>
<div class="flex flex-col lg:flex-row gap-8 items-start">
<!-- Sidebar Filter -->
<aside class="w-full lg:w-64 shrink-0 flex flex-col gap-6 bg-white p-5 rounded-xl border border-light-border shadow-sm">
<div class="flex items-center justify-between border-b border-light-border pb-3">
<h3 class="font-bold text-lg text-dark-text flex items-center gap-2">
<span class="material-symbols-outlined">tune</span> Filter
                    </h3>
<button class="text-xs text-primary font-medium hover:underline">Reset</button>
</div>
<!-- Kategori Filter -->
<div class="flex flex-col gap-3">
<h4 class="text-sm font-bold text-dark-text uppercase tracking-wider">Kategori</h4>
<div class="flex flex-col gap-2">
<label class="flex items-center gap-3 cursor-pointer group">
<input checked="" class="rounded border-secondary-text/30 text-primary focus:ring-primary/20 h-5 w-5 cursor-pointer" type="checkbox"/>
<span class="text-dark-text text-sm group-hover:text-primary transition-colors">Semua</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="rounded border-secondary-text/30 text-primary focus:ring-primary/20 h-5 w-5 cursor-pointer" type="checkbox"/>
<span class="text-dark-text text-sm group-hover:text-primary transition-colors">Buah Segar</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="rounded border-secondary-text/30 text-primary focus:ring-primary/20 h-5 w-5 cursor-pointer" type="checkbox"/>
<span class="text-dark-text text-sm group-hover:text-primary transition-colors">Sayuran</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="rounded border-secondary-text/30 text-primary focus:ring-primary/20 h-5 w-5 cursor-pointer" type="checkbox"/>
<span class="text-dark-text text-sm group-hover:text-primary transition-colors">Bibit Tanaman</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="rounded border-secondary-text/30 text-primary focus:ring-primary/20 h-5 w-5 cursor-pointer" type="checkbox"/>
<span class="text-dark-text text-sm group-hover:text-primary transition-colors">Pupuk &amp; Obat</span>
</label>
<label class="flex items-center gap-3 cursor-pointer group">
<input class="rounded border-secondary-text/30 text-primary focus:ring-primary/20 h-5 w-5 cursor-pointer" type="checkbox"/>
<span class="text-dark-text text-sm group-hover:text-primary transition-colors">Alat Tani</span>
</label>
</div>
</div>
<hr class="border-light-border"/>
<!-- Harga Filter -->
<div class="flex flex-col gap-3">
<h4 class="text-sm font-bold text-dark-text uppercase tracking-wider">Harga</h4>
<div class="grid grid-cols-2 gap-2">
<div class="relative">
<span class="absolute left-2 top-2 text-xs text-secondary-text">Rp</span>
<input class="w-full pl-7 pr-2 py-1.5 text-sm border border-light-border rounded-lg focus:border-primary focus:ring-0 bg-[#f9fcf8]" placeholder="Min" type="number"/>
</div>
<div class="relative">
<span class="absolute left-2 top-2 text-xs text-secondary-text">Rp</span>
<input class="w-full pl-7 pr-2 py-1.5 text-sm border border-light-border rounded-lg focus:border-primary focus:ring-0 bg-[#f9fcf8]" placeholder="Max" type="number"/>
</div>
</div>
<div class="h-1 w-full bg-[#e9f3e7] rounded-full mt-2 relative">
<div class="absolute left-0 w-1/2 h-full bg-primary rounded-full"></div>
<div class="absolute left-1/2 -ml-1 top-1/2 -mt-1.5 h-3 w-3 bg-white border-2 border-primary rounded-full cursor-pointer shadow"></div>
</div>
</div>
<hr class="border-light-border"/>
<!-- Rating Filter -->
<div class="flex flex-col gap-3">
<h4 class="text-sm font-bold text-dark-text uppercase tracking-wider">Rating</h4>
<div class="flex flex-col gap-2">
<label class="flex items-center gap-2 cursor-pointer">
<input class="text-primary focus:ring-primary/20 cursor-pointer" name="rating" type="radio"/>
<div class="flex text-yellow-400">
<span class="material-symbols-outlined text-lg filled font-variation-settings-filled">star</span>
<span class="material-symbols-outlined text-lg filled font-variation-settings-filled">star</span>
<span class="material-symbols-outlined text-lg filled font-variation-settings-filled">star</span>
<span class="material-symbols-outlined text-lg filled font-variation-settings-filled">star</span>
<span class="material-symbols-outlined text-lg text-gray-300">star</span>
</div>
<span class="text-xs text-dark-text">&amp; Up</span>
</label>
<label class="flex items-center gap-2 cursor-pointer">
<input class="text-primary focus:ring-primary/20 cursor-pointer" name="rating" type="radio"/>
<div class="flex text-yellow-400">
<span class="material-symbols-outlined text-lg filled font-variation-settings-filled">star</span>
<span class="material-symbols-outlined text-lg filled font-variation-settings-filled">star</span>
<span class="material-symbols-outlined text-lg filled font-variation-settings-filled">star</span>
<span class="material-symbols-outlined text-lg text-gray-300">star</span>
<span class="material-symbols-outlined text-lg text-gray-300">star</span>
</div>
<span class="text-xs text-dark-text">&amp; Up</span>
</label>
</div>
</div>
</aside>
<!-- Product Grid -->
<div class="flex-1">
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
<!-- Product Card 1 -->
<div class="group flex flex-col rounded-xl bg-white border border-light-border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
<div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
<img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" data-alt="Tumpukan apel merah segar dengan pencahayaan alami" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAaro25PvG0nBEcf6ZwbETHiYPWbJGaDpKqHWkjuA1qduC6d-p1EvX7EztAmsR5AP5GlIKSQwkTL7wUsSVVXg8FwtLRRRM_Wp6fSUSfozeF6-mXLyIFKhxEA2o0sHlNLff97HotjERIkQzoyKUu7MsNtnfBw3bX5hRNnQ3d3A0ecXeiudLlqppiK2xJ1asUoGNwX6UbkrH8pEAWIfP0KuDR16wLNi4NpHjLScGLIN8EARHGAE63c6rv44DX0VzXsZ_IAJ8fRaGQAMo"/>
<span class="absolute top-3 left-3 bg-[#e9f3e7]/90 backdrop-blur-sm text-primary-hover text-[10px] font-bold px-2.5 py-1 rounded-full border border-primary/20 uppercase tracking-wide">Organik</span>
<button class="absolute top-3 right-3 bg-white/80 p-1.5 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition-colors opacity-0 group-hover:opacity-100">
<span class="material-symbols-outlined text-[20px]">favorite</span>
</button>
</div>
<div class="p-4 flex flex-col gap-2 flex-1">
<div class="flex flex-col">
<h3 class="font-bold text-dark-text text-lg line-clamp-1 group-hover:text-primary transition-colors cursor-pointer">Apel Fuji Premium</h3>
<p class="text-xs text-secondary-text">Jawa Timur • Toko Tani Makmur</p>
</div>
<div class="flex items-center gap-1 my-1">
<span class="material-symbols-outlined text-yellow-400 text-sm filled font-variation-settings-filled">star</span>
<span class="text-xs font-bold text-dark-text">4.9</span>
<span class="text-xs text-gray-400">(240 terjual)</span>
</div>
<div class="mt-auto pt-3 border-t border-light-border flex items-center justify-between">
<div class="flex flex-col">
<span class="text-xs text-gray-400 line-through">Rp 45.000</span>
<span class="text-lg font-bold text-primary">Rp 35.000</span>
</div>
<button class="bg-primary text-white size-9 rounded-lg flex items-center justify-center hover:bg-primary-hover shadow-md hover:shadow-primary/30 transition-all active:scale-95">
<span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
</button>
</div>
</div>
</div>
<!-- Product Card 2 -->
<div class="group flex flex-col rounded-xl bg-white border border-light-border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
<div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
<img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" data-alt="Sayuran hijau segar kangkung dan bayam" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCvSFdZpdUhdyBBfLPQCT4RJpTf86JRgvqmoSWXxWDX7671yXflJ5qNW7LtBU86W2y8BjYBA8hKpDqXBhsWywonKeN5NMG5cBAQDEpm7acRZEwLvKXBuSsI9Q7jcBbabtf4dYknX81Y_9_IR_qBSBdsU4lIZsV2zjaiUinxsF_puXjbhmj_nGlqOVnpN2qi3Cf1QG7zYlZM1z5s8HJ57gF9sdh7cEdTiZbIO0ao-449yoy8qg8heR9MFsz2UdUPoRE35snPlYhA3fM"/>
<span class="absolute top-3 left-3 bg-[#e9f3e7]/90 backdrop-blur-sm text-primary-hover text-[10px] font-bold px-2.5 py-1 rounded-full border border-primary/20 uppercase tracking-wide">Segar</span>
<button class="absolute top-3 right-3 bg-white/80 p-1.5 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition-colors opacity-0 group-hover:opacity-100">
<span class="material-symbols-outlined text-[20px]">favorite</span>
</button>
</div>
<div class="p-4 flex flex-col gap-2 flex-1">
<div class="flex flex-col">
<h3 class="font-bold text-dark-text text-lg line-clamp-1 group-hover:text-primary transition-colors cursor-pointer">Paket Sayur Hijau</h3>
<p class="text-xs text-secondary-text">Bandung • Kebun Pak Budi</p>
</div>
<div class="flex items-center gap-1 my-1">
<span class="material-symbols-outlined text-yellow-400 text-sm filled font-variation-settings-filled">star</span>
<span class="text-xs font-bold text-dark-text">4.7</span>
<span class="text-xs text-gray-400">(85 terjual)</span>
</div>
<div class="mt-auto pt-3 border-t border-light-border flex items-center justify-between">
<div class="flex flex-col">
<span class="text-lg font-bold text-primary">Rp 15.000</span>
</div>
<button class="bg-primary text-white size-9 rounded-lg flex items-center justify-center hover:bg-primary-hover shadow-md hover:shadow-primary/30 transition-all active:scale-95">
<span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
</button>
</div>
</div>
</div>
<!-- Product Card 3 -->
<div class="group flex flex-col rounded-xl bg-white border border-light-border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
<div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
<img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" data-alt="Bibit tanaman kecil dalam pot hitam" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBobbu2gfqqvBemO53O1QjVLhVa9IXFpXWhLlXsNC6NbGvg6g9jMM3n_bKPV5HIyN6h2RQUYz2L5wDZ0zmnDGSc_HD2UGVyrxN35t3TYFlYfJywN1TRhnc9B1Fx7Mb17A9S6xQRD6uL2iJVPfLAFa-1JxpqlJFPFrPwwVBE8JdOwt7scmIq8a6xQQg5ZMYlDcwzKDvHm6BQalRR6GSKCnv7w0xdo0MGBuUDiLj0M603TwxHr_wo9jWsiXR-0FNBuW00OjpcTPe7gfs"/>
<button class="absolute top-3 right-3 bg-white/80 p-1.5 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition-colors opacity-0 group-hover:opacity-100">
<span class="material-symbols-outlined text-[20px]">favorite</span>
</button>
</div>
<div class="p-4 flex flex-col gap-2 flex-1">
<div class="flex flex-col">
<h3 class="font-bold text-dark-text text-lg line-clamp-1 group-hover:text-primary transition-colors cursor-pointer">Bibit Cabai Rawit</h3>
<p class="text-xs text-secondary-text">Bogor • Green Nursery</p>
</div>
<div class="flex items-center gap-1 my-1">
<span class="material-symbols-outlined text-yellow-400 text-sm filled font-variation-settings-filled">star</span>
<span class="text-xs font-bold text-dark-text">5.0</span>
<span class="text-xs text-gray-400">(12 terjual)</span>
</div>
<div class="mt-auto pt-3 border-t border-light-border flex items-center justify-between">
<div class="flex flex-col">
<span class="text-lg font-bold text-primary">Rp 5.000</span>
</div>
<button class="bg-primary text-white size-9 rounded-lg flex items-center justify-center hover:bg-primary-hover shadow-md hover:shadow-primary/30 transition-all active:scale-95">
<span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
</button>
</div>
</div>
</div>
<!-- Product Card 4 -->
<div class="group flex flex-col rounded-xl bg-white border border-light-border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
<div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
<img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" data-alt="Karung pupuk organik di ladang" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAX8IKw3VUt2Zjq_yeQzjrPe3MyypyIlLKYjzlC-aOxqCSuH7floidqP8Dt_koq1YtZVPWqUEqa8pU2rnkQ_9e0-tr9fXzxv4oQN7ab_dp3l73_7-mGuVuIgA-fDH1VeFHiWQ2r4icZUVbnBKD9_NVyjwOh0fRFHWfhlBOM2D2QQ_SaE29sR8nAl7cHJuDrp1znMthY87wrZZ5UBW8x3K_g14vrMaeJO3R_POkj_RFYpN5_ZYeXgUWBEyPPAzchFYEpTbaCQmtD3uU"/>
<span class="absolute top-3 left-3 bg-[#e9f3e7]/90 backdrop-blur-sm text-primary-hover text-[10px] font-bold px-2.5 py-1 rounded-full border border-primary/20 uppercase tracking-wide">Grosir</span>
<button class="absolute top-3 right-3 bg-white/80 p-1.5 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition-colors opacity-0 group-hover:opacity-100">
<span class="material-symbols-outlined text-[20px]">favorite</span>
</button>
</div>
<div class="p-4 flex flex-col gap-2 flex-1">
<div class="flex flex-col">
<h3 class="font-bold text-dark-text text-lg line-clamp-1 group-hover:text-primary transition-colors cursor-pointer">Pupuk Kandang Organik</h3>
<p class="text-xs text-secondary-text">Malang • Berkah Tani</p>
</div>
<div class="flex items-center gap-1 my-1">
<span class="material-symbols-outlined text-yellow-400 text-sm filled font-variation-settings-filled">star</span>
<span class="text-xs font-bold text-dark-text">4.6</span>
<span class="text-xs text-gray-400">(450 terjual)</span>
</div>
<div class="mt-auto pt-3 border-t border-light-border flex items-center justify-between">
<div class="flex flex-col">
<span class="text-xs text-gray-400 line-through">Rp 25.000</span>
<span class="text-lg font-bold text-primary">Rp 22.000</span>
</div>
<button class="bg-primary text-white size-9 rounded-lg flex items-center justify-center hover:bg-primary-hover shadow-md hover:shadow-primary/30 transition-all active:scale-95">
<span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
</button>
</div>
</div>
</div>
<!-- Product Card 5 -->
<div class="group flex flex-col rounded-xl bg-white border border-light-border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
<div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
<img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" data-alt="Cangkul dan alat tani di tanah" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCcP7od64rRiLEVnMCGAhSetAW38p17LsfK3cj3rTFVOLQtQ1HJf7vLGQ9O3FNmtnbTCnLZk51pX3jfgeLMBoYczm0RTXUNv2X2gpOJO5QM8XsBpKyB7ER-gdp4WHNbC13gTvDA7P_VhP7C-PfDlAQ7uSDu6Zk1cPOQZ4Kpo5yfRWqxKiufXrvXKNB2-Tly54qdzNt4YxvO41ETv1Sf_n1KIkiFoNmo4NVuIMyoWinfkXlhtjL7RG4BUWtrIvsCUgmrYrl5Xa1QsSA"/>
<button class="absolute top-3 right-3 bg-white/80 p-1.5 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition-colors opacity-0 group-hover:opacity-100">
<span class="material-symbols-outlined text-[20px]">favorite</span>
</button>
</div>
<div class="p-4 flex flex-col gap-2 flex-1">
<div class="flex flex-col">
<h3 class="font-bold text-dark-text text-lg line-clamp-1 group-hover:text-primary transition-colors cursor-pointer">Cangkul Baja Asli</h3>
<p class="text-xs text-secondary-text">Solo • Perkakas Nusantara</p>
</div>
<div class="flex items-center gap-1 my-1">
<span class="material-symbols-outlined text-yellow-400 text-sm filled font-variation-settings-filled">star</span>
<span class="text-xs font-bold text-dark-text">4.9</span>
<span class="text-xs text-gray-400">(50 terjual)</span>
</div>
<div class="mt-auto pt-3 border-t border-light-border flex items-center justify-between">
<div class="flex flex-col">
<span class="text-lg font-bold text-primary">Rp 85.000</span>
</div>
<button class="bg-primary text-white size-9 rounded-lg flex items-center justify-center hover:bg-primary-hover shadow-md hover:shadow-primary/30 transition-all active:scale-95">
<span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
</button>
</div>
</div>
</div>
<!-- Product Card 6 -->
<div class="group flex flex-col rounded-xl bg-white border border-light-border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
<div class="relative aspect-[4/3] bg-gray-100 overflow-hidden">
<img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" data-alt="Buah jeruk segar di pohon" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-RJ-9AzPK2OoPTXCcAyDGMtZU-E9ch5j6Wpjg9G3Fq7lkmlnOBgXhB0p4vSie7Rx1pn9T7BI1qo95ylpdUxNSBslkcykkFyMrfzqJ79WlY9fC7xD5_AKKuv_a-GfzkhxYW-03ek2f1YO3Nomm1GDgrUUhyw6DiIxlaHiNvZNbO6-rgMa5H0Cm_GBQudKUqLq35mmXOMWg9BlIOth9T6nAX2lnI4ArCw9ALd_G_EItdlO-h_jwLQs63zI6NM6LEYU-iPDOpfwuKBo"/>
<span class="absolute top-3 left-3 bg-[#e9f3e7]/90 backdrop-blur-sm text-primary-hover text-[10px] font-bold px-2.5 py-1 rounded-full border border-primary/20 uppercase tracking-wide">Promo</span>
<button class="absolute top-3 right-3 bg-white/80 p-1.5 rounded-full text-gray-400 hover:text-red-500 hover:bg-white transition-colors opacity-0 group-hover:opacity-100">
<span class="material-symbols-outlined text-[20px]">favorite</span>
</button>
</div>
<div class="p-4 flex flex-col gap-2 flex-1">
<div class="flex flex-col">
<h3 class="font-bold text-dark-text text-lg line-clamp-1 group-hover:text-primary transition-colors cursor-pointer">Jeruk Medan Manis</h3>
<p class="text-xs text-secondary-text">Medan • Buah Segar Abadi</p>
</div>
<div class="flex items-center gap-1 my-1">
<span class="material-symbols-outlined text-yellow-400 text-sm filled font-variation-settings-filled">star</span>
<span class="text-xs font-bold text-dark-text">4.8</span>
<span class="text-xs text-gray-400">(300+ terjual)</span>
</div>
<div class="mt-auto pt-3 border-t border-light-border flex items-center justify-between">
<div class="flex flex-col">
<span class="text-xs text-gray-400 line-through">Rp 20.000</span>
<span class="text-lg font-bold text-primary">Rp 18.000</span>
</div>
<button class="bg-primary text-white size-9 rounded-lg flex items-center justify-center hover:bg-primary-hover shadow-md hover:shadow-primary/30 transition-all active:scale-95">
<span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
</button>
</div>
</div>
</div>
</div>
<!-- Pagination -->
<div class="mt-10 flex justify-center">
<nav class="flex items-center gap-2">
<button class="flex items-center justify-center size-10 rounded-lg border border-light-border bg-white text-dark-text hover:bg-[#e9f3e7] disabled:opacity-50">
<span class="material-symbols-outlined">chevron_left</span>
</button>
<button class="flex items-center justify-center size-10 rounded-lg bg-primary text-white font-bold shadow-md shadow-primary/30">1</button>
<button class="flex items-center justify-center size-10 rounded-lg border border-light-border bg-white text-dark-text hover:bg-[#e9f3e7] font-medium transition-colors">2</button>
<button class="flex items-center justify-center size-10 rounded-lg border border-light-border bg-white text-dark-text hover:bg-[#e9f3e7] font-medium transition-colors">3</button>
<span class="flex items-center justify-center size-10 text-gray-400">...</span>
<button class="flex items-center justify-center size-10 rounded-lg border border-light-border bg-white text-dark-text hover:bg-[#e9f3e7] font-medium transition-colors">8</button>
<button class="flex items-center justify-center size-10 rounded-lg border border-light-border bg-white text-dark-text hover:bg-[#e9f3e7]">
<span class="material-symbols-outlined">chevron_right</span>
</button>
</nav>
</div>
</div>
</div>
</main>
<!-- Simple Footer for Context -->
<footer class="bg-white border-t border-light-border mt-auto py-8">
<div class="max-w-7xl mx-auto px-4 md:px-10 flex flex-col md:flex-row justify-between items-center gap-4">
<div class="flex items-center gap-2 text-dark-text">
<span class="material-symbols-outlined text-primary">agriculture</span>
<span class="font-bold">AgriStore © 2023</span>
</div>
<div class="flex gap-6 text-sm text-secondary-text">
<a class="hover:text-primary" href="#">Kebijakan Privasi</a>
<a class="hover:text-primary" href="#">Syarat &amp; Ketentuan</a>
<a class="hover:text-primary" href="#">Bantuan</a>
</div>
</div>
</footer>
</body></html>