<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Halaman Proses Checkout - AgriMart</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Theme Config -->
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#37ec13",
                        "background-light": "#f6f8f6",
                        "background-dark": "#132210",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a2e16",
                        "border-light": "#e9f3e7",
                        "border-dark": "#2a4225",
                        "text-main": "#101b0d",
                        "text-secondary": "#599a4c",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"],
                        "sans": ["Inter", "sans-serif"],
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
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display antialiased text-text-main dark:text-white transition-colors duration-300">
    <div class="relative flex min-h-screen flex-col overflow-x-hidden">
        <!-- Header -->
        <header
            class="sticky top-0 z-50 flex items-center justify-between border-b border-border-light dark:border-border-dark bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-6 lg:px-10 py-4">
            <div class="flex items-center gap-4">
                <a class="flex items-center gap-3 text-text-main dark:text-white group" href="#">
                    <div class="size-8 text-primary transition-transform group-hover:scale-110">
                        <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                d="M47.2426 24L24 47.2426L0.757355 24L24 0.757355L47.2426 24ZM12.2426 21H35.7574L24 9.24264L12.2426 21Z"
                                fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold tracking-tight">AgriMart</h2>
                </a>
            </div>
            <div class="flex items-center gap-4">
                <div
                    class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full bg-border-light/50 dark:bg-border-dark/50 text-xs font-semibold text-text-secondary dark:text-primary">
                    <span class="material-symbols-outlined text-[16px]">lock</span>
                    Checkout Aman
                </div>
                <div class="bg-center bg-no-repeat bg-cover rounded-full size-10 ring-2 ring-primary/20"
                    data-alt="User profile avatar placeholder"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB-R9jDJthS5TofPgR4sUGaNGRBBSm5sH-54pSyPqoUyNad-nIEPxlrLf-Dm9k6rlrr8GQQngJh3_WlSlXgu2_nZpi3QHlP9YyO-b-y3wvrcZ4xK-iTxiHDcTA2cCZ1KeqkQlHPAo8pWrMdu9HKhpqm9iRu1v9nn7GMVS2lFzYQjDEi8MMULH-Ae_UHuOFfUAk3UvB8NkyNJVtJNxOCT-2ycbidnUij7FR7SKyP--T7M0Jpy0wQaDyqrjX5gCcIgfYOWW_yz-EtBrU");'>
                </div>
            </div>
        </header>
        <!-- Main Content -->
        <main class="flex-grow layout-container flex flex-col items-center py-8 px-4 md:px-8 lg:px-40">
            <div class="w-full max-w-6xl flex flex-col gap-8">
                <!-- Progress Bar Section -->
                <div class="w-full">
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <p class="text-text-main dark:text-white text-sm font-semibold uppercase tracking-wider">
                                Langkah 1 dari 3</p>
                            <span class="text-xs text-text-secondary dark:text-gray-400">Selanjutnya: Pembayaran</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-border-light dark:bg-border-dark overflow-hidden">
                            <div class="h-full rounded-full bg-primary shadow-[0_0_10px_rgba(55,236,19,0.5)] transition-all duration-500 ease-out"
                                style="width: 33%;"></div>
                        </div>
                        <div
                            class="flex justify-between text-xs font-medium text-text-secondary dark:text-gray-400 mt-1">
                            <span class="text-primary">Pengiriman</span>
                            <span>Pembayaran</span>
                            <span>Konfirmasi</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                    <!-- Left Column: Forms -->
                    <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-8">
                        <!-- Page Heading -->
                        <div class="flex flex-col gap-2">
                            <h1 class="text-3xl md:text-4xl font-bold text-text-main dark:text-white tracking-tight">
                                Informasi Pengiriman</h1>
                            <p class="text-text-secondary dark:text-gray-400">Masukkan detail alamat kemana paket
                                pertanian anda akan dikirim.</p>
                        </div>
                        <!-- Form Card -->
                        <div
                            class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 md:p-8 shadow-sm border border-border-light dark:border-border-dark">
                            <form class="flex flex-col gap-6">
                                <!-- Name Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <label class="flex flex-col gap-2">
                                        <span class="text-sm font-semibold text-text-main dark:text-gray-200">Nama
                                            Depan</span>
                                        <input
                                            class="form-input w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 text-text-main dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary placeholder:text-text-secondary/50"
                                            placeholder="Budi" type="text" />
                                    </label>
                                    <label class="flex flex-col gap-2">
                                        <span class="text-sm font-semibold text-text-main dark:text-gray-200">Nama
                                            Belakang</span>
                                        <input
                                            class="form-input w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 text-text-main dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary placeholder:text-text-secondary/50"
                                            placeholder="Santoso" type="text" />
                                    </label>
                                </div>
                                <!-- Contact Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <label class="flex flex-col gap-2">
                                        <span
                                            class="text-sm font-semibold text-text-main dark:text-gray-200">Email</span>
                                        <div class="relative">
                                            <span
                                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary">mail</span>
                                            <input
                                                class="form-input w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 text-text-main dark:text-white h-12 pl-10 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary placeholder:text-text-secondary/50"
                                                placeholder="budi@petani.id" type="email" />
                                        </div>
                                    </label>
                                    <label class="flex flex-col gap-2">
                                        <span class="text-sm font-semibold text-text-main dark:text-gray-200">Nomor
                                            Telepon</span>
                                        <div class="relative">
                                            <span
                                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary">call</span>
                                            <input
                                                class="form-input w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 text-text-main dark:text-white h-12 pl-10 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary placeholder:text-text-secondary/50"
                                                placeholder="0812..." type="tel" />
                                        </div>
                                    </label>
                                </div>
                                <!-- Address Field -->
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Alamat
                                        Lengkap</span>
                                    <textarea
                                        class="form-input w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 text-text-main dark:text-white min-h-[100px] p-4 focus:ring-2 focus:ring-primary/50 focus:border-primary placeholder:text-text-secondary/50 resize-y"
                                        placeholder="Jl. Raya Pertanian No. 123, Desa Sukamaju"></textarea>
                                </label>
                                <!-- Location Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                    <label class="flex flex-col gap-2 md:col-span-1">
                                        <span class="text-sm font-semibold text-text-main dark:text-gray-200">Kode
                                            Pos</span>
                                        <input
                                            class="form-input w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 text-text-main dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary placeholder:text-text-secondary/50"
                                            placeholder="12345" type="text" />
                                    </label>
                                    <label class="flex flex-col gap-2 md:col-span-2">
                                        <span class="text-sm font-semibold text-text-main dark:text-gray-200">Kota /
                                            Kabupaten</span>
                                        <div class="relative">
                                            <select
                                                class="form-select w-full rounded-lg border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark/50 text-text-main dark:text-white h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary appearance-none">
                                                <option>Jakarta Selatan</option>
                                                <option>Bandung</option>
                                                <option>Bogor</option>
                                                <option>Surabaya</option>
                                            </select>
                                            <span
                                                class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none">expand_more</span>
                                        </div>
                                    </label>
                                </div>
                            </form>
                        </div>
                        <!-- Shipping Method Selection -->
                        <div class="flex flex-col gap-4">
                            <h3 class="text-lg font-bold text-text-main dark:text-white">Metode Pengiriman</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Option 1 -->
                                <label
                                    class="relative flex cursor-pointer rounded-xl border-2 border-primary bg-primary/5 dark:bg-primary/10 p-4 shadow-sm focus:outline-none">
                                    <input
                                        aria-describedby="shipping-method-0-description-0 shipping-method-0-description-1"
                                        aria-labelledby="shipping-method-0-label" checked="" class="sr-only"
                                        name="shipping-method" type="radio" value="regular" />
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-bold text-text-main dark:text-white"
                                                id="shipping-method-0-label">Reguler (JNE)</span>
                                            <span
                                                class="mt-1 flex items-center text-sm text-text-secondary dark:text-gray-400"
                                                id="shipping-method-0-description-0">Estimasi 2-3 Hari Kerja</span>
                                            <span class="mt-6 text-sm font-medium text-text-main dark:text-white"
                                                id="shipping-method-0-description-1">Rp 15.000</span>
                                        </span>
                                    </span>
                                    <span aria-hidden="true"
                                        class="material-symbols-outlined text-primary">check_circle</span>
                                </label>
                                <!-- Option 2 -->
                                <label
                                    class="relative flex cursor-pointer rounded-xl border border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark p-4 shadow-sm hover:border-primary/50 focus:outline-none transition-colors">
                                    <input
                                        aria-describedby="shipping-method-1-description-0 shipping-method-1-description-1"
                                        aria-labelledby="shipping-method-1-label" class="sr-only"
                                        name="shipping-method" type="radio" value="express" />
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-bold text-text-main dark:text-white"
                                                id="shipping-method-1-label">Instan (GoSend)</span>
                                            <span
                                                class="mt-1 flex items-center text-sm text-text-secondary dark:text-gray-400"
                                                id="shipping-method-1-description-0">Tiba hari ini</span>
                                            <span class="mt-6 text-sm font-medium text-text-main dark:text-white"
                                                id="shipping-method-1-description-1">Rp 35.000</span>
                                        </span>
                                    </span>
                                    <span aria-hidden="true"
                                        class="material-symbols-outlined text-border-light dark:text-border-dark">circle</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column: Order Summary (Sticky) -->
                    <div class="lg:col-span-5 xl:col-span-4 lg:sticky lg:top-24 h-fit">
                        <div
                            class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-lg border border-border-light dark:border-border-dark overflow-hidden">
                            <div
                                class="p-6 border-b border-border-light dark:border-border-dark bg-background-light/50 dark:bg-background-dark/30">
                                <h3 class="text-lg font-bold text-text-main dark:text-white">Ringkasan Pesanan</h3>
                            </div>
                            <!-- Items List -->
                            <div class="max-h-[320px] overflow-y-auto p-6 flex flex-col gap-6 custom-scrollbar">
                                <!-- Item 1 -->
                                <div class="flex gap-4">
                                    <div
                                        class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-border-light dark:border-border-dark bg-white">
                                        <img class="h-full w-full object-cover object-center"
                                            data-alt="Close up of organic green fertilizer bottle"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBvVS0IYbUsPGS8SWFA_0jlVNJF_CNwm1ntm37BPmsYuw7hU6tOoGAEQEw8WufqQATAt3ZAJLujZhr38-mFejuEXGdimsvLfgjdNnlRySB-VQjpd_5uzIpdrfkoNULkTsjJB5n8yIV39Os92jx7WTnam9razTt-Ya49iv2dL651asfBHJ_6Lxq9bQLMwZcgyeZMcmUD7vgumDYvNJmduuaoJH2_a4sxqNT2UwgyWVLCezCksw_ciro0UQOoQknkILnkkfpgkHPAE2s" />
                                    </div>
                                    <div class="flex flex-1 flex-col">
                                        <div
                                            class="flex justify-between text-base font-medium text-text-main dark:text-white">
                                            <h3>Pupuk Organik Cair</h3>
                                            <p class="ml-4">Rp 45.000</p>
                                        </div>
                                        <p class="mt-1 text-sm text-text-secondary">500ml</p>
                                        <div class="flex items-center justify-between text-sm mt-2">
                                            <p class="text-text-secondary">Qty: 2</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Item 2 -->
                                <div class="flex gap-4">
                                    <div
                                        class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-border-light dark:border-border-dark bg-white">
                                        <img class="h-full w-full object-cover object-center"
                                            data-alt="High quality corn seeds packet"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuB7_MokLRIzhKut5MfSNeGaoIsFB4H0wIi1_PQGun4-nLdmC1RfMhoAN29dxRZHKRvxFp-q0Bpet_bKAox-xyzE5DOAl4NFSHDm2vcj0WB4IPQXapWdbYkMYPiJRQyZIRNxn8CpwmPR6KtPSr7UPVVVJKuwuL-KkR-xB5m8SasibsncSqckKkdp964a_Scq6szcS2ZsljBcPks6tZUrK95BtS1WuxC7WEhrhNNi4LosUk6cNm9A9AM5vUTOiGHp8CQiXmThOuaOqqM" />
                                    </div>
                                    <div class="flex flex-1 flex-col">
                                        <div
                                            class="flex justify-between text-base font-medium text-text-main dark:text-white">
                                            <h3>Benih Jagung Manis</h3>
                                            <p class="ml-4">Rp 25.000</p>
                                        </div>
                                        <p class="mt-1 text-sm text-text-secondary">Pack 100gr</p>
                                        <div class="flex items-center justify-between text-sm mt-2">
                                            <p class="text-text-secondary">Qty: 1</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Promo Code -->
                            <div
                                class="px-6 py-4 bg-background-light dark:bg-background-dark/30 border-y border-border-light dark:border-border-dark">
                                <label class="flex gap-2">
                                    <input
                                        class="form-input flex-1 rounded-lg border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark text-text-main dark:text-white text-sm h-10 px-3 focus:ring-1 focus:ring-primary focus:border-primary placeholder:text-text-secondary/50"
                                        placeholder="Kode Promo" type="text" />
                                    <button
                                        class="rounded-lg bg-text-main dark:bg-surface-dark border border-text-main dark:border-gray-600 text-white dark:text-gray-200 px-4 text-sm font-medium hover:bg-opacity-90 transition-colors"
                                        type="button">Terapkan</button>
                                </label>
                            </div>
                            <!-- Cost Breakdown -->
                            <div class="p-6 space-y-4">
                                <div
                                    class="flex items-center justify-between text-sm text-text-secondary dark:text-gray-400">
                                    <p>Subtotal</p>
                                    <p class="font-medium text-text-main dark:text-white">Rp 115.000</p>
                                </div>
                                <div
                                    class="flex items-center justify-between text-sm text-text-secondary dark:text-gray-400">
                                    <p>Pengiriman</p>
                                    <p class="font-medium text-text-main dark:text-white">Rp 15.000</p>
                                </div>
                                <div
                                    class="flex items-center justify-between text-sm text-text-secondary dark:text-gray-400">
                                    <p>Pajak</p>
                                    <p class="font-medium text-text-main dark:text-white">Rp 1.150</p>
                                </div>
                                <div
                                    class="border-t border-border-light dark:border-border-dark pt-4 flex items-center justify-between">
                                    <p class="text-base font-bold text-text-main dark:text-white">Total</p>
                                    <p class="text-xl font-bold text-primary">Rp 131.150</p>
                                </div>
                            </div>
                            <!-- Action Button -->
                            <div class="p-6 pt-0 flex flex-col gap-4">
                                <button
                                    class="w-full flex items-center justify-center gap-2 rounded-lg bg-primary hover:bg-[#2ed60e] text-black h-12 text-base font-bold shadow-lg shadow-primary/20 transition-all hover:shadow-primary/40 active:scale-[0.98]">
                                    Lanjut ke Pembayaran
                                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                                </button>
                                <div
                                    class="flex justify-center items-center gap-2 text-xs text-text-secondary dark:text-gray-500">
                                    <span class="material-symbols-outlined text-[14px]">lock</span>
                                    <span>Pembayaran terenkripsi &amp; aman</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
