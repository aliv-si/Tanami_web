<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Apel Fuji Super Manis - AgriFresh</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
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
                        "secondary-green": "#e9f3e7",
                        "accent-green": "#599a4c",
                        "background-light": "#f9fcf8",
                        "background-dark": "#132210",
                        "text-main": "#101b0d",
                        "text-light": "#ffffff",
                    },
                    fontFamily: {
                        "display": ["Inter", "Noto Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        /* Custom scrollbar for horizontal scrolling areas */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 antialiased min-h-screen flex flex-col">
    <!-- Top Navigation -->
    <header
        class="sticky top-0 z-50 w-full border-b border-[#e9f3e7] bg-[#f9fcf8]/95 backdrop-blur-sm dark:bg-background-dark/95 dark:border-white/10">
        <div class="flex items-center justify-between px-4 py-3 lg:px-10 max-w-[1440px] mx-auto w-full">
            <div class="flex items-center gap-8">
                <a class="flex items-center gap-2 text-text-main dark:text-white group" href="#">
                    <div class="size-8 text-primary">
                        <svg class="w-full h-full" fill="none" viewbox="0 0 48 48"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 6H42L36 24L42 42H6L12 24L6 6Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <h2
                        class="text-xl font-bold leading-tight tracking-tight group-hover:text-primary transition-colors">
                        AgriFresh</h2>
                </a>
                <!-- Desktop Search -->
                <div class="hidden lg:flex w-full max-w-md">
                    <div class="relative flex w-full items-center rounded-lg bg-secondary-green/50 dark:bg-white/10">
                        <div class="absolute left-3 text-accent-green dark:text-gray-400">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                        </div>
                        <input
                            class="w-full bg-transparent border-none py-2.5 pl-10 pr-4 text-sm text-text-main dark:text-white placeholder:text-accent-green dark:placeholder:text-gray-400 focus:ring-2 focus:ring-primary rounded-lg"
                            placeholder="Cari buah, sayur, atau pupuk..." type="text" />
                    </div>
                </div>
            </div>
            <!-- Navigation & Actions -->
            <div class="flex items-center gap-6">
                <nav class="hidden md:flex items-center gap-8">
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Belanja</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Kategori</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Promo</a>
                </nav>
                <div class="flex items-center gap-3">
                    <button
                        class="relative p-2 rounded-lg hover:bg-secondary-green dark:hover:bg-white/10 transition-colors">
                        <span class="material-symbols-outlined text-[24px]">shopping_cart</span>
                        <span
                            class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-primary text-[10px] font-bold text-text-main">3</span>
                    </button>
                    <button
                        class="hidden sm:flex h-10 px-5 items-center justify-center rounded-lg bg-secondary-green dark:bg-white/10 text-text-main dark:text-white text-sm font-bold hover:bg-green-100 dark:hover:bg-white/20 transition-colors">
                        Masuk
                    </button>
                    <button
                        class="h-10 px-5 items-center justify-center rounded-lg bg-primary text-text-main text-sm font-bold shadow-lg shadow-primary/20 hover:bg-green-400 transition-all transform hover:-translate-y-0.5">
                        Daftar
                    </button>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content -->
    <main class="flex-grow w-full max-w-[1280px] mx-auto px-4 lg:px-10 py-6">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm mb-6 overflow-x-auto whitespace-nowrap hide-scrollbar pb-2">
            <a class="text-accent-green hover:underline" href="#">Beranda</a>
            <span class="text-gray-400 text-xs material-symbols-outlined">chevron_right</span>
            <a class="text-accent-green hover:underline" href="#">Buah Segar</a>
            <span class="text-gray-400 text-xs material-symbols-outlined">chevron_right</span>
            <span class="text-text-main font-medium dark:text-white">Apel Fuji Super Manis</span>
        </nav>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            <!-- Left Column: Product Images -->
            <div class="lg:col-span-7 flex flex-col gap-4">
                <div
                    class="group relative w-full aspect-[4/3] overflow-hidden rounded-2xl bg-gray-100 dark:bg-white/5 border border-gray-100 dark:border-white/10 shadow-sm">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
                        data-alt="Close up of fresh red fuji apples with water droplets"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDBv_S5l5h8O45-BD5QNjnQbt_zOUqfnvr0EVSXlTynnXX6zOErA8Om0tDd0f6JyDaQlxxqEwiDjtcN1CZXEXMjaQCqtnxnwkJwfYLLFru6FSbgV8tgnbSMeMc3HrLjDmdQrm14DAffAXN9bBj3HAfb_9g9vTGiJUw3aLG1WFlrT-C4x2ZXl5koGDGJPukgQPo7zkBql93hh0JbVwiJxfi0nyuQNnmoVH7S85v2UT5SYoWdPvaK_QPtk6-ECHkBBu5tXdH2CHstVPs');">
                    </div>
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        <span
                            class="px-3 py-1 bg-primary text-text-main text-xs font-bold rounded-full shadow-sm">Terlaris</span>
                        <span
                            class="px-3 py-1 bg-white/90 backdrop-blur text-accent-green text-xs font-bold rounded-full shadow-sm">Panen
                            Hari Ini</span>
                    </div>
                </div>
                <!-- Thumbnails -->
                <div class="flex gap-4 overflow-x-auto pb-2 hide-scrollbar">
                    <button class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-primary p-0.5">
                        <div class="w-full h-full rounded-md bg-cover bg-center" data-alt="Red fuji apple single"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBewc_JU94wsmxCI-JzG8POmw6Td2jJA2PRUNzxZg96QSef8YTqJEl8Lub1_aj72IG8_v4jdV32g9-ogoDcjyT_dyw_2arKszS3R_7HtToq6scwO-aa3r96kC0EdjQUW28u6yV4DVZFH-lWTUq_6y_8pjfYB5uoFf8dWcjTZiHlTis7pWOPDd8ZzUft6yAWAVcvnL2J1Dsi1grzgamLAO2Yksw5ZvSRZ8NoPFmY3bsdkKGmRz-t5hXl_Z-63mRNC9cg3_uYSv0MQP8');">
                        </div>
                    </button>
                    <button
                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border border-transparent hover:border-primary/50 transition-all">
                        <div class="w-full h-full rounded-md bg-cover bg-center"
                            data-alt="Sliced fuji apples on wooden board"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCqnQLL6_BZhW4DA3kYYAdmSbOPsmnwMDBxUfJUtLc7TQoWynH92eCZKoYzN-13FzayZEk0oQEFoDEXeFqK3S7ILqZPsqrLpOY86N-g3OnuIk0opLQfX3KDrQvMRQKeq_ZM2QMya9ap5n1ALYp1XK3t9QuPeYJvoFOT2E0dlGW6ye-vn2cX98BdAdDXC1RVfmvGTkb0cm46wCUkzXkt-38qGLEKlyMxdOfo2ifs8Ce6nXVl4Qky4uHyLXmF0atQ0FysSxREwVz6vCQ');">
                        </div>
                    </button>
                    <button
                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border border-transparent hover:border-primary/50 transition-all">
                        <div class="w-full h-full rounded-md bg-cover bg-center" data-alt="Orchard with apple trees"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBmesARIeCdHJDEPWNfdeo0f7vFyqsrOpio95doiY6n8qWyoZ1mPekiOUDNlT2uizWQOQ3Niz1kZS70mdvdrfDtzL1igL9e7O5755H8EOhFrYVoIJsEsAuz2MIR6SNIl4RwMXMiy1aRvRLxB76kG2ObT3VT7hWSpi0tBFMAMB_yHMQ7zq_WW1TeNaUjzKp1v2Inf8dhdKpFLe14-UmssPcgnBW2iaPhAXFcm8SOMcdcP1DhtILjdpLME3k9xq649tSq6G8jBBVZQy8');">
                        </div>
                    </button>
                    <button
                        class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border border-transparent hover:border-primary/50 transition-all relative">
                        <div
                            class="absolute inset-0 bg-black/30 flex items-center justify-center text-white font-bold text-sm">
                            +2</div>
                        <div class="w-full h-full rounded-md bg-cover bg-center" data-alt="Basket full of apples"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA_D4KInOGIlZqgdzZVuzZZE9RGVPkUmTPTOACzdDRMedxkNszh--GngwjtvnELpKX0uV5AErzbA70tdNNZUGMisdT5pf41QAYBxzGpEZuKUpqWmGYiQin13WsoluQLa3KrNTqmJqRhP9UNfEU_tSvGx-kIPQkPKaCLA89LfVEO0bu_Kd8Gs5SnQBXaCQPYAFH9YQWdtAtX2YKEaPlxheu8Itx-_VDPX05Dy4kWW3Irhg9UA2x0mTiVhWyzx7nnK46n2w979ht8GX0');">
                        </div>
                    </button>
                </div>
            </div>
            <!-- Right Column: Product Details -->
            <div class="lg:col-span-5 flex flex-col h-full">
                <div class="flex flex-col gap-6 sticky top-24">
                    <!-- Header -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-2 text-sm text-accent-green font-medium">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            Petani Lokal Malang
                        </div>
                        <h1 class="text-3xl font-bold text-text-main dark:text-white leading-tight">Apel Fuji Super
                            Manis - Kualitas Premium (1kg)</h1>
                        <div class="flex items-center gap-4">
                            <div class="flex text-yellow-400">
                                <span class="material-symbols-outlined text-[20px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[20px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[20px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[20px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[20px] fill-current">star_half</span>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">4.8 (128 Ulasan)</span>
                            <span class="text-gray-300">|</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Terjual 1.2rb+</span>
                        </div>
                    </div>
                    <!-- Price -->
                    <div
                        class="bg-secondary-green/30 dark:bg-white/5 p-4 rounded-xl border border-secondary-green dark:border-white/5">
                        <div class="flex items-end gap-3 mb-1">
                            <span class="text-3xl font-bold text-text-main dark:text-white">Rp 35.000</span>
                            <span class="text-lg text-gray-400 line-through mb-1">Rp 45.000</span>
                            <span
                                class="px-2 py-0.5 bg-red-100 text-red-600 text-xs font-bold rounded mb-1.5">-22%</span>
                        </div>
                        <p class="text-sm text-accent-green dark:text-primary/80 font-medium">Promo Berakhir dalam 14
                            jam 22 menit</p>
                    </div>
                    <!-- Description Snippet -->
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        Apel Fuji pilihan dengan rasa manis yang khas dan tekstur renyah. Dipetik langsung dari kebun
                        petani di Malang, dijamin segar sampai ke tangan Anda. Kaya akan vitamin C dan serat.
                    </p>
                    <!-- Variants & Quantity -->
                    <div class="space-y-4">
                        <!-- Variant -->
                        <div>
                            <span class="block text-sm font-semibold mb-2 dark:text-gray-200">Pilih Berat:</span>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="px-4 py-2 rounded-lg border-2 border-primary bg-primary/10 text-text-main font-semibold text-sm">1
                                    kg</button>
                                <button
                                    class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-white/5 hover:border-primary/50 text-gray-600 dark:text-gray-300 text-sm transition-all">2
                                    kg (Hemat 5rb)</button>
                                <button
                                    class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-white/5 hover:border-primary/50 text-gray-600 dark:text-gray-300 text-sm transition-all">5
                                    kg (Grosir)</button>
                            </div>
                        </div>
                        <!-- Quantity -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold dark:text-gray-200">Jumlah:</span>
                            <div
                                class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-white/5">
                                <button
                                    class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-primary hover:bg-gray-50 dark:hover:bg-white/10 rounded-l-lg transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">remove</span>
                                </button>
                                <input
                                    class="w-12 h-10 text-center border-none bg-transparent text-text-main dark:text-white font-medium focus:ring-0 p-0"
                                    type="number" value="1" />
                                <button
                                    class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-primary hover:bg-gray-50 dark:hover:bg-white/10 rounded-r-lg transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">add</span>
                                </button>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="material-symbols-outlined text-[16px] text-accent-green">inventory_2</span>
                            Stok tersedia: <span class="font-bold text-text-main dark:text-white">48 kg</span>
                        </div>
                    </div>
                    <!-- Actions -->
                    <div class="flex flex-col gap-3 pt-2">
                        <div class="flex gap-3 h-12">
                            <button
                                class="flex-1 rounded-xl bg-primary text-text-main font-bold text-base shadow-lg shadow-primary/25 hover:bg-green-400 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">shopping_cart</span>
                                Tambah ke Keranjang
                            </button>
                            <button
                                class="aspect-square rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-gray-50 dark:hover:bg-white/10 text-gray-400 hover:text-red-500 transition-colors">
                                <span class="material-symbols-outlined">favorite</span>
                            </button>
                        </div>
                        <button
                            class="w-full h-11 rounded-xl border-2 border-primary text-text-main dark:text-primary font-bold text-sm hover:bg-primary/10 active:scale-[0.98] transition-all">
                            Beli Langsung
                        </button>
                    </div>
                    <!-- Trust Badges -->
                    <div
                        class="grid grid-cols-3 gap-2 py-4 border-t border-dashed border-gray-200 dark:border-gray-700 mt-2">
                        <div class="flex flex-col items-center text-center gap-1">
                            <span class="material-symbols-outlined text-accent-green text-2xl">local_shipping</span>
                            <span class="text-[10px] text-gray-500 leading-tight">Pengiriman<br />Cepat</span>
                        </div>
                        <div class="flex flex-col items-center text-center gap-1">
                            <span class="material-symbols-outlined text-accent-green text-2xl">workspace_premium</span>
                            <span class="text-[10px] text-gray-500 leading-tight">Garansi<br />Segar</span>
                        </div>
                        <div class="flex flex-col items-center text-center gap-1">
                            <span class="material-symbols-outlined text-accent-green text-2xl">support_agent</span>
                            <span class="text-[10px] text-gray-500 leading-tight">Layanan<br />24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Details Tabs Section -->
        <div class="mt-16 lg:mt-24">
            <div class="border-b border-gray-200 dark:border-gray-700 mb-8">
                <div class="flex gap-8 overflow-x-auto hide-scrollbar">
                    <button
                        class="pb-4 border-b-2 border-primary text-primary font-bold text-sm whitespace-nowrap">Deskripsi
                        Produk</button>
                    <button
                        class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-text-main dark:text-gray-400 dark:hover:text-white font-medium text-sm transition-colors whitespace-nowrap">Spesifikasi
                        &amp; Nutrisi</button>
                    <button
                        class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-text-main dark:text-gray-400 dark:hover:text-white font-medium text-sm transition-colors whitespace-nowrap">Info
                        Pengiriman</button>
                    <button
                        class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-text-main dark:text-gray-400 dark:hover:text-white font-medium text-sm transition-colors whitespace-nowrap">Ulasan
                        (128)</button>
                </div>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-12 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-lg font-bold text-text-main dark:text-white mb-3">Tentang Apel Fuji Malang</h3>
                        <p class="mb-4">
                            Apel Fuji kami dibudidayakan di dataran tinggi Malang yang sejuk, menghasilkan buah dengan
                            tekstur yang sangat renyah dan rasa manis yang seimbang dengan sedikit sentuhan asam segar.
                            Kulitnya berwarna merah muda kemerahan dengan garis-garis kuning halus.
                        </p>
                        <p>
                            Sangat cocok untuk dikonsumsi langsung sebagai camilan sehat, dijadikan jus, salad buah,
                            atau bahan pembuatan kue pie apel. Produk ini dipanen setiap pagi untuk memastikan kesegaran
                            maksimal saat sampai di tangan Anda.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-text-main dark:text-white mb-3">Manfaat Kesehatan</h3>
                        <ul class="list-disc pl-5 space-y-1 marker:text-primary">
                            <li>Kaya akan antioksidan, terutama flavonoid.</li>
                            <li>Sumber serat pangan yang baik untuk pencernaan.</li>
                            <li>Membantu menjaga kesehatan jantung.</li>
                            <li>Rendah kalori, cocok untuk diet.</li>
                        </ul>
                    </div>
                </div>
                <!-- Specs Card -->
                <div
                    class="bg-gray-50 dark:bg-white/5 p-6 rounded-2xl border border-gray-100 dark:border-white/5 h-fit">
                    <h3 class="text-base font-bold text-text-main dark:text-white mb-4">Spesifikasi Produk</h3>
                    <div class="space-y-3">
                        <div
                            class="flex justify-between pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                            <span class="text-gray-500">Berat Bersih</span>
                            <span class="font-medium text-text-main dark:text-white">950g - 1050g</span>
                        </div>
                        <div
                            class="flex justify-between pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                            <span class="text-gray-500">Asal</span>
                            <span class="font-medium text-text-main dark:text-white">Batu, Malang</span>
                        </div>
                        <div
                            class="flex justify-between pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                            <span class="text-gray-500">Kualitas</span>
                            <span class="font-medium text-text-main dark:text-white">Grade A (Premium)</span>
                        </div>
                        <div
                            class="flex justify-between pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                            <span class="text-gray-500">Masa Simpan</span>
                            <span class="font-medium text-text-main dark:text-white">2-3 Minggu (Kulkas)</span>
                        </div>
                        <div
                            class="flex justify-between pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                            <span class="text-gray-500">Petani</span>
                            <span class="font-medium text-primary underline cursor-pointer">Pak Budi Santoso</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Reviews Section -->
        <div class="mt-16 pt-10 border-t border-gray-100 dark:border-white/10">
            <h3 class="text-2xl font-bold text-text-main dark:text-white mb-8">Ulasan Pembeli</h3>
            <div class="flex flex-col md:flex-row gap-8 mb-10">
                <!-- Rating Summary -->
                <div
                    class="flex-shrink-0 w-full md:w-64 bg-secondary-green/30 dark:bg-white/5 rounded-2xl p-6 flex flex-col items-center justify-center text-center">
                    <div class="text-5xl font-bold text-text-main dark:text-white mb-2">4.8</div>
                    <div class="flex text-yellow-400 mb-2">
                        <span class="material-symbols-outlined fill-current">star</span>
                        <span class="material-symbols-outlined fill-current">star</span>
                        <span class="material-symbols-outlined fill-current">star</span>
                        <span class="material-symbols-outlined fill-current">star</span>
                        <span class="material-symbols-outlined fill-current">star_half</span>
                    </div>
                    <p class="text-sm text-gray-500">Berdasarkan 128 ulasan</p>
                </div>
                <!-- Review List -->
                <div class="flex-grow space-y-6">
                    <!-- Review Item 1 -->
                    <div class="pb-6 border-b border-gray-100 dark:border-white/10 last:border-0">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 bg-cover bg-center"
                                    data-alt="User profile picture placeholder"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDst4SZGALd-vBfSBcGAFn-6XB1BosTgkcPqhcTGHSz7sOr1PyFPoO3XyiXaZ1KKgRUQsxB-ybkmowdW9s_wDL0n798vveHNF1GP1QcGIxYxCs1w8qN3aOuQFF4HsfA3NJgSiG2EPgmTZhxHSJk54hGcb-dnP3Mj3Va--FaXzEGjy5Qcrnb9i0ByDWKcQc8g_sRj_BEo-3R78Q2v5DSe2debvDFj3J0hsCCzQ27fIKUR4RdXIgApUcjV7lGcyO5TJrDUPLUORVuREo');">
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-text-main dark:text-white">Siti Aminah</h4>
                                    <p class="text-xs text-gray-400">2 Hari yang lalu • Varian 2 kg</p>
                                </div>
                            </div>
                            <div class="flex text-yellow-400 text-sm">
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-3">
                            Apelnya beneran manis dan seger banget! Pengiriman juga cepet, pesen pagi sore udah sampe.
                            Packing aman pake bubble wrap tebel. Recommended seller!
                        </p>
                        <div class="flex gap-2">
                            <div class="w-16 h-16 rounded-lg bg-gray-100 dark:bg-white/5 bg-cover bg-center cursor-pointer hover:opacity-80 transition-opacity"
                                data-alt="Review photo 1"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDdQ317Ots0Bu1IrfvpJ_qQowZFpEA4vA-2NCWKABDnLtskbtvMBWdtJccEXy-oH3I5Qs7IYAgGqhrSmtIR9NpjuUkn_V7j3xL0zSFsYCwoGhFLDm1pNOsh-lw8bMZIHi5suo93rwjjzWL2x5MeEuejSatT2qVO053AK9838PnWsXzXgzraH_oXxVM-7u7T1wAyuljxiJE7xV49ok4x2027HIFxXOlJS_Z9nrRHYV2w0LjVp7k4EJU41EShb5edw65JJ2EmFwv7IfQ');">
                            </div>
                            <div class="w-16 h-16 rounded-lg bg-gray-100 dark:bg-white/5 bg-cover bg-center cursor-pointer hover:opacity-80 transition-opacity"
                                data-alt="Review photo 2"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDLzaqq8cv-_OINAI0u0Fpgf-ADClGDi_Shtl_z2dAuNLvXgO7l_tLsxBmWx5qujTduiDB_EhxxbTqUQlSk79XvoILfXFI5hu9gxm3zMyQO26shZKVSM2mUOI-exkdbiA-NWUVkyWKenBxb8NthxqmaqO6SjAZKoAjhSvj3WczjTLr-xA0CsAb9-9rdhHdBh2JDVAnzCXlYkRAjabosnZahoY6LcjuJx9Ko94eyq32R2n4YzZi_Da2koDS5ZG4lmsPU63z7SjFhyQA');">
                            </div>
                        </div>
                    </div>
                    <!-- Review Item 2 -->
                    <div class="pb-6 border-b border-gray-100 dark:border-white/10 last:border-0">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-sm">
                                    DI
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm text-text-main dark:text-white">Dian Irawan</h4>
                                    <p class="text-xs text-gray-400">5 Hari yang lalu • Varian 1 kg</p>
                                </div>
                            </div>
                            <div class="flex text-yellow-400 text-sm">
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[16px] fill-current">star</span>
                                <span class="material-symbols-outlined text-[16px] text-gray-300">star</span>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">
                            Kualitas bagus, tapi sayang pengiriman agak telat karena hujan. Overall buahnya masih fresh
                            kok.
                        </p>
                    </div>
                </div>
            </div>
            <button
                class="w-full md:w-auto mx-auto px-6 py-3 rounded-lg border border-gray-300 dark:border-gray-600 text-text-main dark:text-white font-medium text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors block text-center">
                Lihat Semua Ulasan
            </button>
        </div>
        <!-- Related Products -->
        <div class="mt-20 mb-10">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-text-main dark:text-white">Sering Dibeli Bersama</h3>
                <a class="text-accent-green font-medium text-sm hover:underline" href="#">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
                <!-- Product Card 1 -->
                <div
                    class="group flex flex-col bg-white dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative w-full aspect-square bg-gray-100 dark:bg-black/20 overflow-hidden">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform group-hover:scale-105"
                            data-alt="Green pears on a table"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCyJJ0dR2vjLlFxGMOJeGCi0pZVX28_2JxVM7WIRVcF-lKbcgWLYQSNDcyUHGK8rfBNl3ULBDXC303dv7uTKMEwBWoK6dCas5HDgUV8Nme4rg-lZka9t0cMd0maNEEhaCNuDHsMjQ8YT32VJBUelf0fkdLRzAe0-xcoRw3yg5xVCDfT_a3Ea9RCnBQrn6aDwZd527b-nFjAu7fxQbdghOH20UxBV5KJz9-TlKvQQljN0eC-uAcMlEwUJv1JK1BjfLc-KlFKV-t88IU');">
                        </div>
                        <div class="absolute top-2 right-2">
                            <button
                                class="p-1.5 rounded-full bg-white/80 hover:bg-white text-gray-500 hover:text-red-500 transition-colors backdrop-blur-sm">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="text-xs text-accent-green font-bold mb-1">Buah Segar</div>
                        <h4 class="text-sm font-bold text-text-main dark:text-white line-clamp-2 mb-2">Pir Hijau
                            Packham Manis (1kg)</h4>
                        <div class="mt-auto flex items-end justify-between">
                            <div>
                                <span class="block text-xs text-gray-400 line-through">Rp 28.000</span>
                                <span class="block text-base font-bold text-text-main dark:text-primary">Rp
                                    24.500</span>
                            </div>
                            <button
                                class="p-2 rounded-lg bg-primary text-text-main hover:bg-green-400 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Product Card 2 -->
                <div
                    class="group flex flex-col bg-white dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative w-full aspect-square bg-gray-100 dark:bg-black/20 overflow-hidden">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform group-hover:scale-105"
                            data-alt="Fresh oranges sliced"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBymI5x_ABmrDFIMfnChAPkp0m175zs7GfO6w3xO7T0uqR9vJZhFcXOelnV-M-2Bd4SOalNi77jipsxnU70YexAAbsAxeNKvqTQXWO0eJ_FkMRV8M8Uq_rBI7Ua-TmsK5UxLXI45ELhKm_Vh18Cn_Ecn8D04dRTTuzOpka7dpHwHBm6ZbEBrnXCeTEvQgdfzi4x-MlvQuoBqIxyEzvpMZAie0Ji3Ew3uRK16IqsOiBTv6JJNk7xcpldyBF9BTz_YBP1uQDrKj_L0fw');">
                        </div>
                        <div
                            class="absolute top-2 left-2 px-2 py-0.5 bg-red-500 text-white text-[10px] font-bold rounded">
                            HOT</div>
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="text-xs text-accent-green font-bold mb-1">Buah Segar</div>
                        <h4 class="text-sm font-bold text-text-main dark:text-white line-clamp-2 mb-2">Jeruk Mandarin
                            Ponkam (1kg)</h4>
                        <div class="mt-auto flex items-end justify-between">
                            <div>
                                <span class="block text-base font-bold text-text-main dark:text-primary">Rp
                                    32.000</span>
                            </div>
                            <button
                                class="p-2 rounded-lg bg-secondary-green dark:bg-white/10 text-text-main dark:text-white hover:bg-primary hover:border-transparent transition-colors">
                                <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Product Card 3 -->
                <div
                    class="group flex flex-col bg-white dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative w-full aspect-square bg-gray-100 dark:bg-black/20 overflow-hidden">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform group-hover:scale-105"
                            data-alt="Bunch of red grapes"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC_khGyDKM4guXTStKOOCprHkY-XmuynLBAUDp3DFPDqp4CGThY1AwZXtIzHKEffxbeVk2hq-8sWqGK1EO_FwFFXD4d3L54d9zOPgCsdJBeWz2qlnEAzIooXhvObVyB8EeSHn1uxScdHhgk6kqroOr2cs8X3ma3IFXf3W1ciaYXDNQ_knqiHJbrhHWcQ4Sj2dNMeNHeyAzNpju_pv-f-D9HjqBimB7n4pvShssJsDdmkDPximLaKXYxZIz4TAi9QuX6vPwBYBIwM_s');">
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="text-xs text-accent-green font-bold mb-1">Buah Segar</div>
                        <h4 class="text-sm font-bold text-text-main dark:text-white line-clamp-2 mb-2">Anggur Red Globe
                            Super (500g)</h4>
                        <div class="mt-auto flex items-end justify-between">
                            <div>
                                <span class="block text-base font-bold text-text-main dark:text-primary">Rp
                                    45.000</span>
                            </div>
                            <button
                                class="p-2 rounded-lg bg-secondary-green dark:bg-white/10 text-text-main dark:text-white hover:bg-primary hover:border-transparent transition-colors">
                                <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Product Card 4 -->
                <div
                    class="group flex flex-col bg-white dark:bg-white/5 border border-gray-100 dark:border-white/10 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative w-full aspect-square bg-gray-100 dark:bg-black/20 overflow-hidden">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform group-hover:scale-105"
                            data-alt="Fresh salad vegetables"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDGAvQ9cNjieUuUvl-tY1gzP9Yk5dyANQus33d8pFcTm9UGwz3wW9FhXrgv0pJ-GNMKvlUERGKseGSO-Lh8iZ5YAoZqu1hnimXpITP-WkyQXoy2hhofvqnqIUgYpkYiMYuvvki8y4Dh7epBXAOkJRYYEtp6PSmClUyPP62IDrJZVBm5F8-hPWtHrwM2lUYPTX9rrFOAw6hqL0ig7ZHIQ5mdub9IZU8fNvIDc8V9z-BR4yX8eu3rnNzqbnmB4yLYI-Lq-EnEwYvQKUc');">
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="text-xs text-accent-green font-bold mb-1">Paket Hemat</div>
                        <h4 class="text-sm font-bold text-text-main dark:text-white line-clamp-2 mb-2">Paket Salad
                            Sayur Organik</h4>
                        <div class="mt-auto flex items-end justify-between">
                            <div>
                                <span class="block text-xs text-gray-400 line-through">Rp 50.000</span>
                                <span class="block text-base font-bold text-text-main dark:text-primary">Rp
                                    42.000</span>
                            </div>
                            <button
                                class="p-2 rounded-lg bg-secondary-green dark:bg-white/10 text-text-main dark:text-white hover:bg-primary hover:border-transparent transition-colors">
                                <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Simple Footer -->
    <footer class="bg-white dark:bg-background-dark border-t border-gray-100 dark:border-white/10 py-8">
        <div class="max-w-[1280px] mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">© 2024 AgriFresh Indonesia. Tumbuh bersama Alam.</p>
        </div>
    </footer>
</body>

</html>
