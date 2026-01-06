<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Keranjang Belanja - AgriMart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#37ec13",
                        "primary-dark": "#2cc50e",
                        "background-light": "#f6f8f6",
                        "background-dark": "#132210",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a2e16",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Custom scrollbar for cleaner look */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-50 font-display transition-colors duration-200 min-h-screen flex flex-col">
    <!-- Top Navigation -->
    <header
        class="sticky top-0 z-50 bg-surface-light/95 dark:bg-surface-dark/95 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                <!-- Logo -->
                <div class="flex items-center gap-2 cursor-pointer shrink-0">
                    <div class="text-primary">
                        <span class="material-symbols-outlined text-3xl">agriculture</span>
                    </div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white hidden sm:block">AgriMart
                    </h1>
                </div>
                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-8">
                    <a class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-primary transition-colors"
                        href="#">Produk</a>
                    <a class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-primary transition-colors"
                        href="#">Tentang Kami</a>
                    <a class="text-sm font-medium text-slate-700 dark:text-slate-300 hover:text-primary transition-colors"
                        href="#">Bantuan</a>
                </nav>
                <!-- Search & Actions -->
                <div class="flex items-center gap-3 flex-1 justify-end max-w-lg">
                    <div
                        class="hidden sm:flex w-full max-w-xs items-center bg-gray-100 dark:bg-[#243a20] rounded-lg px-3 py-2 border border-transparent focus-within:border-primary focus-within:ring-1 focus-within:ring-primary transition-all">
                        <span class="material-symbols-outlined text-gray-400">search</span>
                        <input
                            class="w-full bg-transparent border-none focus:ring-0 text-sm placeholder-gray-400 text-slate-900 dark:text-white ml-2 p-0 h-auto"
                            placeholder="Cari bibit, pupuk..." type="text" />
                    </div>
                    <div class="flex items-center gap-1">
                        <button
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#243a20] relative group transition-colors">
                            <span
                                class="material-symbols-outlined text-slate-700 dark:text-slate-300">shopping_cart</span>
                            <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-primary"></span>
                            </span>
                        </button>
                        <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-[#243a20] transition-colors">
                            <span
                                class="material-symbols-outlined text-slate-700 dark:text-slate-300">account_circle</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs / Steps -->
        <div class="mb-8 hidden sm:block">
            <div class="flex items-center justify-center space-x-4 text-sm font-medium">
                <div class="flex items-center text-primary">
                    <span
                        class="flex items-center justify-center w-6 h-6 rounded-full bg-primary text-black text-xs mr-2">1</span>
                    Keranjang
                </div>
                <div class="w-12 h-px bg-gray-200 dark:bg-gray-700"></div>
                <div class="flex items-center text-gray-400 dark:text-gray-600">
                    <span
                        class="flex items-center justify-center w-6 h-6 rounded-full border border-gray-300 dark:border-gray-600 text-xs mr-2">2</span>
                    Pengiriman
                </div>
                <div class="w-12 h-px bg-gray-200 dark:bg-gray-700"></div>
                <div class="flex items-center text-gray-400 dark:text-gray-600">
                    <span
                        class="flex items-center justify-center w-6 h-6 rounded-full border border-gray-300 dark:border-gray-600 text-xs mr-2">3</span>
                    Pembayaran
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Column: Cart Items -->
            <div class="lg:col-span-8 flex flex-col gap-6">
                <!-- Page Heading -->
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Keranjang Belanja
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 mt-1">Anda memiliki 3 item dalam keranjang</p>
                    </div>
                    <button
                        class="text-sm font-medium text-red-500 hover:text-red-600 flex items-center gap-1 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                        Hapus Semua
                    </button>
                </div>
                <!-- Cart Table Container -->
                <div
                    class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden @container">
                    <!-- Table Header (Hidden on small screens via CSS grid usually, but using flex here) -->
                    <div
                        class="hidden sm:flex border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-[#20361c] px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <div class="flex-1">Produk</div>
                        <div class="w-32 text-center">Harga</div>
                        <div class="w-32 text-center">Kuantitas</div>
                        <div class="w-32 text-right">Total</div>
                        <div class="w-12"></div>
                    </div>
                    <!-- Item 1 -->
                    <div
                        class="flex flex-col sm:flex-row sm:items-center p-4 sm:px-6 sm:py-6 border-b border-gray-100 dark:border-gray-800 gap-4 group hover:bg-gray-50 dark:hover:bg-[#20361c]/50 transition-colors">
                        <!-- Product Info -->
                        <div class="flex items-center gap-4 flex-1">
                            <div
                                class="h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                <div class="h-full w-full bg-cover bg-center"
                                    data-alt="Packet of high quality red chili seeds"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCTLX8kV6yH_nvX1ZbFMQfDkkVdTD1UVVCKr-XM3_5urz_ZkVoerh1-TiTkRxFfV9udLk6KjumRw_b40utc9rxL8EN1ldQIBVrlub_pMp2bgc-7L9RkMj4lilJYew6bk15XF9vy-SCtQ8vs5Sq4GsgCSRzkeQrsEzX77891Seu4pTYPQ-eI2tMQHydBG8Oz3cAYoBQ2586-Udd5JA-i_pAp4zzJkAuqfi2avMVpBcgdpx--A7gDEiN3qAj-Ax4PRh6p52PrG-kRfpE');">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="font-semibold text-slate-900 dark:text-white">Bibit Cabai Rawit Unggul</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Pack 10 gram</p>
                                <span
                                    class="inline-flex mt-1 items-center rounded-md bg-green-50 dark:bg-green-900/30 px-2 py-1 text-xs font-medium text-green-700 dark:text-green-400 ring-1 ring-inset ring-green-600/20">Stok
                                    Tersedia</span>
                            </div>
                        </div>
                        <!-- Mobile layout wrapper for Price, Qty, Total -->
                        <div class="flex flex-row items-center justify-between sm:contents w-full">
                            <!-- Price -->
                            <div class="w-auto sm:w-32 text-left sm:text-center">
                                <div class="text-sm font-medium text-slate-900 dark:text-white">Rp 15.000</div>
                            </div>
                            <!-- Quantity -->
                            <div class="w-auto sm:w-32 flex justify-center">
                                <div
                                    class="flex items-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-transparent">
                                    <button
                                        class="flex h-8 w-8 items-center justify-center rounded-l-lg text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">remove</span>
                                    </button>
                                    <input
                                        class="h-8 w-10 border-0 bg-transparent p-0 text-center text-sm font-medium text-slate-900 dark:text-white focus:ring-0"
                                        readonly="" type="text" value="2" />
                                    <button
                                        class="flex h-8 w-8 items-center justify-center rounded-r-lg text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">add</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Total -->
                            <div class="w-auto sm:w-32 text-right">
                                <div class="text-sm font-bold text-primary dark:text-primary">Rp 30.000</div>
                            </div>
                        </div>
                        <!-- Delete Action -->
                        <div class="flex sm:w-12 justify-end">
                            <button
                                class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </div>
                    <!-- Item 2 -->
                    <div
                        class="flex flex-col sm:flex-row sm:items-center p-4 sm:px-6 sm:py-6 border-b border-gray-100 dark:border-gray-800 gap-4 group hover:bg-gray-50 dark:hover:bg-[#20361c]/50 transition-colors">
                        <div class="flex items-center gap-4 flex-1">
                            <div
                                class="h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                <div class="h-full w-full bg-cover bg-center"
                                    data-alt="Green plastic bottle of liquid organic fertilizer"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAmxuRpF3TYDlAvVCJmTzyeOZT4Ez_D47P6uapws2SFYZJWK2G5ScMPhVkjQkQoAOj1PLJDigHRIl1BIOahEguV4Mou6uj05YRaCJxH789C2KYnZ9PFxhFFZwMHDPOLjCyKjpbkvkAidjCo77rQzdEJhogIa85S1bnwn56otHEqqsBfNsPWGMqshNopxWTzoEmw-xPLUAs-H-L8LYMhaIsPjcnnPg-Oiom97s8IfWYdcDdKrzmaMA7F_Y1ovsQXmUH6_QX9Ede9zZc');">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="font-semibold text-slate-900 dark:text-white">Pupuk Organik Cair 1L</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Formula Sayuran Daun</p>
                            </div>
                        </div>
                        <div class="flex flex-row items-center justify-between sm:contents w-full">
                            <div class="w-auto sm:w-32 text-left sm:text-center">
                                <div class="text-sm font-medium text-slate-900 dark:text-white">Rp 45.000</div>
                            </div>
                            <div class="w-auto sm:w-32 flex justify-center">
                                <div
                                    class="flex items-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-transparent">
                                    <button
                                        class="flex h-8 w-8 items-center justify-center rounded-l-lg text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="material-symbols-outlined text-[16px]">remove</span>
                                    </button>
                                    <input
                                        class="h-8 w-10 border-0 bg-transparent p-0 text-center text-sm font-medium text-slate-900 dark:text-white focus:ring-0"
                                        readonly="" type="text" value="1" />
                                    <button
                                        class="flex h-8 w-8 items-center justify-center rounded-r-lg text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="material-symbols-outlined text-[16px]">add</span>
                                    </button>
                                </div>
                            </div>
                            <div class="w-auto sm:w-32 text-right">
                                <div class="text-sm font-bold text-primary dark:text-primary">Rp 45.000</div>
                            </div>
                        </div>
                        <div class="flex sm:w-12 justify-end">
                            <button
                                class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </div>
                    <!-- Item 3 -->
                    <div
                        class="flex flex-col sm:flex-row sm:items-center p-4 sm:px-6 sm:py-6 gap-4 group hover:bg-gray-50 dark:hover:bg-[#20361c]/50 transition-colors">
                        <div class="flex items-center gap-4 flex-1">
                            <div
                                class="h-20 w-20 shrink-0 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                                <div class="h-full w-full bg-cover bg-center"
                                    data-alt="Stainless steel garden trowel with wooden handle"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCJ7xD9XPXmnxQge1-0HTgWUnxTwlvpjX8zBBIxd2S4RnaISz-p7xUt29PFDELEWnuyfL-u_IOk6S9QCxXgggMSQevXWU6dQpivY1N1PrL5iKiG-8l5PmvnFCZTiD7sMAFE6lcKehA9yBjfK0PDPiXEpaLAf5fhkoxDGjsWNYaSniRnbagnDblZlsPnI5LG6zltUbUSLCHKOY_l97nPCmsDH0ozvodkWwEweUKP1xu-4VQ4zMtnZq0ziLsDAgxzR-XNf1X6cvC579U');">
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="font-semibold text-slate-900 dark:text-white">Sekop Taman Stainless</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Gagang Kayu Jati</p>
                                <span
                                    class="inline-flex mt-1 items-center rounded-md bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 text-xs font-medium text-yellow-800 dark:text-yellow-500 ring-1 ring-inset ring-yellow-600/20">Sisa
                                    3 stok</span>
                            </div>
                        </div>
                        <div class="flex flex-row items-center justify-between sm:contents w-full">
                            <div class="w-auto sm:w-32 text-left sm:text-center">
                                <div class="text-sm font-medium text-slate-900 dark:text-white">Rp 30.000</div>
                            </div>
                            <div class="w-auto sm:w-32 flex justify-center">
                                <div
                                    class="flex items-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-transparent">
                                    <button
                                        class="flex h-8 w-8 items-center justify-center rounded-l-lg text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="material-symbols-outlined text-[16px]">remove</span>
                                    </button>
                                    <input
                                        class="h-8 w-10 border-0 bg-transparent p-0 text-center text-sm font-medium text-slate-900 dark:text-white focus:ring-0"
                                        readonly="" type="text" value="1" />
                                    <button
                                        class="flex h-8 w-8 items-center justify-center rounded-r-lg text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="material-symbols-outlined text-[16px]">add</span>
                                    </button>
                                </div>
                            </div>
                            <div class="w-auto sm:w-32 text-right">
                                <div class="text-sm font-bold text-primary dark:text-primary">Rp 30.000</div>
                            </div>
                        </div>
                        <div class="flex sm:w-12 justify-end">
                            <button
                                class="text-gray-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Cross-sell / Related Products (Optional but requested context "Modern") -->
                <div class="mt-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Mungkin Anda juga butuh</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div
                            class="bg-surface-light dark:bg-surface-dark p-3 rounded-lg border border-gray-200 dark:border-gray-800 hover:shadow-md transition-shadow cursor-pointer">
                            <div class="bg-gray-100 dark:bg-gray-800 rounded h-24 mb-3 w-full bg-cover bg-center"
                                data-alt="Small pot plant"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAgNpPLk02AYf9vTo6LR2qlbzYZiwNFcAfqBFIO-kxPfSU5Kqm6Sgw9Nhbq-3ZxXKS8kQo1OemTTt3_rR34tQs8a56UtAAWfayNHNA_qAlF43h6n_GpwCoBzdTNwEiU86izRAwzxS32JEqlQcQ0_w1ZL_9pjpWDQAE4jxIYM-ynw9flb9f62bAl6qsi52CQKFmqGJRyx0B3rocj_-l3ZAxV-8Zo7Il6y8yFKveY6ty_mf7m_ecr7XKD6eW9WbhAA_HXY00SxI2ywTA');">
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Pot 15cm</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">Pot Tanaman Hitam
                            </p>
                            <p class="text-xs font-bold text-primary mt-1">Rp 5.000</p>
                        </div>
                        <div
                            class="bg-surface-light dark:bg-surface-dark p-3 rounded-lg border border-gray-200 dark:border-gray-800 hover:shadow-md transition-shadow cursor-pointer">
                            <div class="bg-gray-100 dark:bg-gray-800 rounded h-24 mb-3 w-full bg-cover bg-center"
                                data-alt="Gardening gloves"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDEivK4uxmSr4LYmW9xZrEynFo5aw4CCsx2J-SvnQb6R2KB4GD8KV0V6J5mLWptnLJbFNRubGHuWXwH7M9Ss_TqSjunukE_S5GC_SdloSdQPHVtxl2UXLDG-CtecV1Gs1UCnbU6jnsUyKPNIF0rSRTL0M-t5XiP5M3comFHLabfVRyfzEa9V6M-uNMY35t17ZJWAoL-Os6PR6ralqu5eM0L7zG8moGTrByNZw6WQaoXSb5kNClz13Y4FovBW5dVvg53fFg_ERzZ2Fs');">
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Sarung Tangan</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">Sarung Tangan
                                Karet</p>
                            <p class="text-xs font-bold text-primary mt-1">Rp 12.000</p>
                        </div>
                        <!-- Hidden on very small screens if needed -->
                    </div>
                </div>
            </div>
            <!-- Right Column: Order Summary (Sticky) -->
            <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
                <div
                    class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 flex flex-col gap-5">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Ringkasan Pesanan</h3>
                    <!-- Costs Breakdown -->
                    <div class="space-y-3 pb-5 border-b border-gray-100 dark:border-gray-800">
                        <div class="flex justify-between text-sm text-slate-600 dark:text-slate-400">
                            <span>Subtotal (3 item)</span>
                            <span class="font-medium text-slate-900 dark:text-white">Rp 105.000</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-600 dark:text-slate-400">
                            <span>Diskon</span>
                            <span class="font-medium text-green-600 dark:text-primary">-Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-600 dark:text-slate-400">
                            <span>Pajak (PPN 11%)</span>
                            <span class="font-medium text-slate-900 dark:text-white">Termasuk</span>
                        </div>
                    </div>
                    <!-- Promo Code Input -->
                    <div class="flex gap-2">
                        <input
                            class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-[#132210] text-sm text-slate-900 dark:text-white focus:border-primary focus:ring-primary shadow-sm placeholder:text-gray-400"
                            placeholder="Kode Promo" type="text" />
                        <button
                            class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-slate-900 dark:text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Pakai
                        </button>
                    </div>
                    <!-- Total -->
                    <div class="flex justify-between items-baseline pt-2">
                        <span class="text-base font-semibold text-slate-900 dark:text-white">Total Belanja</span>
                        <span class="text-2xl font-extrabold text-slate-900 dark:text-white">Rp 105.000</span>
                    </div>
                    <!-- Disclaimer -->
                    <p class="text-xs text-slate-500 dark:text-slate-400 text-right">
                        Belum termasuk ongkos kirim.
                    </p>
                    <!-- Primary CTA -->
                    <button
                        class="w-full bg-primary hover:bg-primary-dark text-slate-900 font-bold text-base py-3.5 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 group">
                        Lanjutkan ke Checkout
                        <span
                            class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                </div>
                <!-- Trust Badges -->
                <div
                    class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-gray-800 p-4">
                    <div class="flex flex-col gap-3">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary shrink-0">verified_user</span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">Pembayaran Aman</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-snug">Enkripsi SSL 256-bit
                                    menjamin keamanan transaksi Anda.</p>
                            </div>
                        </div>
                        <div class="h-px bg-gray-100 dark:bg-gray-800 w-full"></div>
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-primary shrink-0">eco</span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">Garansi Segar</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-snug">Uang kembali jika
                                    produk yang diterima layu atau rusak.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
