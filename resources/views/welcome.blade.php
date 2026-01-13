@extends('layouts.app')

@section('title', 'Home | Tanami')

@section('content')
<main class="flex flex-col flex-1">
    {{-- Flash Messages --}}
    @if (session('success'))
    <div class="fixed top-20 right-4 z-50 max-w-sm">
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            <p class="text-sm font-medium">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="fixed top-20 right-4 z-50 max-w-sm">
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
            <span class="material-symbols-outlined text-red-500">error</span>
            <p class="text-sm font-medium">{{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-500 hover:text-red-700">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
    </div>
    @endif

    <section class="relative w-full overflow-hidden bg-white dark:bg-background-dark py-12 md:py-24 lg:py-32">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1625246333195-58197bd47f26?q=80&amp;w=2560&amp;auto=format&amp;fit=crop')] bg-cover bg-center opacity-5 dark:opacity-10"
            data-alt="Subtle pattern of agricultural fields"></div>
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="grid gap-6 lg:grid-cols-2 lg:gap-12 items-center">
                <div class="flex flex-col justify-center space-y-4">
                    @auth
                    <div class="inline-flex items-center rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-sm font-medium text-primary w-fit font-heading">
                        <span class="material-symbols-outlined text-sm mr-1">waving_hand</span>
                        Selamat datang, {{ auth()->user()->nama_lengkap }}!
                    </div>
                    @else
                    <div class="inline-flex items-center rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-sm font-medium text-primary w-fit font-heading">
                        <span class="material-symbols-outlined text-sm mr-1">bolt</span> New Season Arrivals
                    </div>
                    @endauth
                    <h1 class="text-[48px] font-heading font-bold tracking-tight sm:text-[48px] xl:text-[56px] leading-tight text-[#1e3f1b] dark:text-white">
                        The Future of <span class="text-primary">Sustainable Farming</span> is Here.
                    </h1>
                    <p class="max-w-[600px] text-gray-600 dark:text-gray-300 text-[16px] font-normal leading-relaxed font-sans">
                        Tanami provides cutting-edge agritech solutions and premium organic supplies directly to your farm. Elevate your yield today.
                    </p>
                    <div class="flex flex-col gap-2 min-[400px]:flex-row pt-4 font-heading">
                        @auth
                        {{-- Logged in: Role-based CTA --}}
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-primary px-8 text-[16px] font-semibold text-white shadow-lg shadow-primary/25 transition-all hover:bg-primary/90">
                            <span class="material-symbols-outlined mr-2">admin_panel_settings</span>
                            Dashboard Admin
                        </a>
                        @elseif(auth()->user()->isPetani())
                        <a href="{{ route('petani.dashboard') }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-primary px-8 text-[16px] font-semibold text-white shadow-lg shadow-primary/25 transition-all hover:bg-primary/90">
                            <span class="material-symbols-outlined mr-2">dashboard</span>
                            Dashboard Petani
                        </a>
                        <a href="{{ route('petani.produk') }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-gray-200 bg-white dark:bg-white/5 px-8 text-[16px] font-semibold text-[#1e3f1b] dark:text-white shadow-sm transition-colors hover:bg-gray-50">
                            <span class="material-symbols-outlined mr-2">inventory_2</span>
                            Kelola Produk
                        </a>
                        @else
                        <a href="{{ route('katalog') }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-primary px-8 text-[16px] font-semibold text-white shadow-lg shadow-primary/25 transition-all hover:bg-primary/90">
                            <span class="material-symbols-outlined mr-2">storefront</span>
                            Belanja Sekarang
                        </a>
                        @endif
                        @else
                        {{-- Guest: Register/Login CTA --}}
                        <a href="{{ route('register') }}" class="inline-flex h-12 items-center justify-center rounded-lg bg-primary px-8 text-[16px] font-semibold text-white shadow-lg shadow-primary/25 transition-all hover:bg-primary/90 focus-visible:outline-none">
                            Register Now
                        </a>
                        <a href="{{ route('katalog') }}" class="inline-flex h-12 items-center justify-center rounded-lg border border-gray-200 bg-white dark:bg-white/5 dark:border-white/10 px-8 text-[16px] font-semibold text-[#1e3f1b] dark:text-white shadow-sm transition-colors hover:bg-gray-50 dark:hover:bg-white/10">
                            See Catalog
                        </a>
                        @endauth
                    </div>
                </div>
                <div
                    class="mx-auto aspect-video w-full overflow-hidden rounded-2xl object-cover object-center shadow-2xl lg:order-last">
                    <div class="w-full h-full bg-cover bg-center bg-no-repeat transition-transform hover:scale-105 duration-700"
                        data-alt="A lush green field with modern agricultural drone monitoring crops"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAzb0JT1LObIMcoqQyyxEOilNQgBtHve9FeMiE-hZUkxa8jtBQsRotdSddt6mYag-jlm1gomXcEPMClEq-m6f5IbiasG-rEzGPjF78HWcqBtKyvEz-nK8ELdfPzm7g7dSMhms3hP_ea5p5FyFr6UdKNWaNP6JKWDAH3J3xB62UiHEKiGQCd-bPDUeL8N_ij3k78cNWjntmNrZAE3yXLyhgrksXyEJdlR9WgRY9PN6Klc7MEDiO1AazO2o324MyRqkdVBgjqTSKIcbiz");'>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-12 md:py-24 bg-background-light dark:bg-background-dark/50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col items-center justify-center space-y-4 text-center mb-12">
                <div class="space-y-2">
                    <h2
                        class="text-[36px] font-heading font-semibold tracking-tight text-[#1e3f1b] dark:text-white">
                        Why Choose Tanami?</h2>
                    <p
                        class="mx-auto max-w-[700px] text-gray-500 dark:text-gray-400 text-[16px] font-normal font-sans">
                        We combine technology with nature to bring you the best farming solutions.
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="group relative overflow-hidden rounded-xl bg-white dark:bg-[#1f2b1b] p-8 shadow-sm transition-all hover:shadow-md hover:-translate-y-1">
                    <div
                        class="mb-4 inline-flex items-center justify-center rounded-lg bg-primary/10 p-3 text-primary">
                        <span class="material-symbols-outlined text-4xl">analytics</span>
                    </div>
                    <h3 class="mb-2 text-xl font-heading font-bold text-[#1e3f1b] dark:text-white">Data-Driven
                        Insights</h3>
                    <p class="text-gray-500 dark:text-gray-400 font-sans text-[16px] font-normal">Leverage smart
                        data for better yield. Our analytics help you make informed decisions.</p>
                </div>
                <div
                    class="group relative overflow-hidden rounded-xl bg-white dark:bg-[#1f2b1b] p-8 shadow-sm transition-all hover:shadow-md hover:-translate-y-1">
                    <div
                        class="mb-4 inline-flex items-center justify-center rounded-lg bg-primary/10 p-3 text-primary">
                        <span class="material-symbols-outlined text-4xl">eco</span>
                    </div>
                    <h3 class="mb-2 text-xl font-heading font-bold text-[#1e3f1b] dark:text-white">Eco-Friendly
                        Sourcing</h3>
                    <p class="text-gray-500 dark:text-gray-400 font-sans text-[16px] font-normal">Sustainable
                        products for a greener planet. Certified organic and responsibly sourced.</p>
                </div>
                <div
                    class="group relative overflow-hidden rounded-xl bg-white dark:bg-[#1f2b1b] p-8 shadow-sm transition-all hover:shadow-md hover:-translate-y-1">
                    <div
                        class="mb-4 inline-flex items-center justify-center rounded-lg bg-primary/10 p-3 text-primary">
                        <span class="material-symbols-outlined text-4xl">local_shipping</span>
                    </div>
                    <h3 class="mb-2 text-xl font-heading font-bold text-[#1e3f1b] dark:text-white">Farm-to-Door
                        Delivery</h3>
                    <p class="text-gray-500 dark:text-gray-400 font-sans text-[16px] font-normal">Direct
                        delivery logistics for freshness. From our warehouse straight to your barn.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-16 bg-white dark:bg-background-dark border-y border-gray-100 dark:border-white/5">
        <div class="container mx-auto px-4 md:px-6">
            <div class="mb-12">
                <h2
                    class="text-[#131712] dark:text-white text-[36px] font-heading font-semibold leading-tight tracking-[-0.015em] text-center">
                    How It Works</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <div
                    class="hidden md:block absolute top-12 left-[16%] right-[16%] h-0.5 bg-gray-200 dark:bg-gray-700 -z-0">
                </div>
                <div class="flex flex-col items-center text-center relative z-10 group">
                    <div
                        class="flex items-center justify-center w-24 h-24 rounded-full bg-white dark:bg-[#1f2b1b] border-4 border-gray-100 dark:border-gray-700 text-primary mb-6 shadow-sm group-hover:border-primary/30 transition-colors">
                        <span class="material-symbols-outlined text-4xl">manage_search</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-2">1. Browse
                        Catalog</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm max-w-[250px] font-sans">Explore our wide
                        range of seeds, tools, and tech solutions.</p>
                </div>
                <div class="flex flex-col items-center text-center relative z-10 group">
                    <div
                        class="flex items-center justify-center w-24 h-24 rounded-full bg-white dark:bg-[#1f2b1b] border-4 border-gray-100 dark:border-gray-700 text-primary mb-6 shadow-sm group-hover:border-primary/30 transition-colors">
                        <span class="material-symbols-outlined text-4xl">shopping_cart_checkout</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-2">2. Place
                        Order</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm max-w-[250px] font-sans">Securely
                        checkout with flexible payment and shipping options.</p>
                </div>
                <div class="flex flex-col items-center text-center relative z-10 group">
                    <div
                        class="flex items-center justify-center w-24 h-24 rounded-full bg-white dark:bg-[#1f2b1b] border-4 border-gray-100 dark:border-gray-700 text-primary mb-6 shadow-sm group-hover:border-primary/30 transition-colors">
                        <span class="material-symbols-outlined text-4xl">potted_plant</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-2">3. Grow
                        Better</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm max-w-[250px] font-sans">Receive your
                        supplies and start seeing results in your yield.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="w-full py-16 bg-background-light dark:bg-background-dark">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-[36px] font-heading font-semibold text-[#1e3f1b] dark:text-white">Featured
                        Products</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-2 font-sans text-[16px] font-normal">Top
                        picks for this season.</p>
                </div>
                <a class="hidden sm:flex items-center text-primary font-heading font-semibold hover:underline"
                    href="#">
                    View all
                    <span class="material-symbols-outlined ml-1 text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white dark:bg-[#1f2b1b] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            data-alt="Close up of a smart soil sensor device in dark soil"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCxE7eDcmYVVRGHOds0-yQE0wN8X4BG-1WAhWX5edH3o-hvl90YBhbCj9xJyoYvOOZqRmGeFsSLT-849teLlLI3XLXA8jDQ_gmM9uKcjO89rd1mnpKePJMDZJPdyYdJ0hGsJjDZabupvl75x6YtT7hR_3L_nMpLMIDX_WzyF_YaJfmKg1zO5Bf6wR3es-4PlVFynehLRmEK2msfjyBRTacH_TVeUvdhWJwNdUDeKyP253ri4eggaQJGa29HHREL71yDQIkZLcIYqJhX");'>
                        </div>
                        <div
                            class="absolute top-3 right-3 bg-white dark:bg-black/50 p-1.5 rounded-full text-gray-400 hover:text-red-500 cursor-pointer transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-xl">favorite</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">
                            Tech</div>
                        <h3 class="text-lg font-heading font-bold text-[#1e3f1b] dark:text-white truncate">
                            Smart Soil Sensor Pro</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span
                                class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-gray-200">$129.00</span>
                            <button
                                class="bg-primary hover:bg-primary/90 text-white p-2 rounded-lg transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-[#1f2b1b] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            data-alt="Bag of organic fertilizer pellets with green leaf icon"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBdqyAY8cOXgiqLGVnXKz7Ty9ZXwMqO9eD9mTQ044jZM4jj0_zYGu0kT-0d-EY6tSOBYVtsY3n7FwsfdfQHNRpwm7dHtkglJv9CTtpKcNkmHUKjIUs2gAC197gDvTXGtDSYTWiJARnolNz5DfCUwnQT3Bzs2nEZaMwiyUYoIVioTJDRezoE0D0gTcyfyWhT2FwghIrX1w1TYigKHD9DKXB6U-q2r2btlpVETmHk34YX7FQ6OJwWHrPNI8rOOXoxosI9fLzhyoqKgxPx");'>
                        </div>
                        <div
                            class="absolute top-3 left-3 bg-primary text-white text-xs font-bold px-2 py-1 rounded font-heading">
                            Best Seller</div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">
                            Nutrients</div>
                        <h3 class="text-lg font-heading font-bold text-[#1e3f1b] dark:text-white truncate">
                            Organic Nitrogen Boost</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span
                                class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-gray-200">$24.99</span>
                            <button
                                class="bg-primary hover:bg-primary/90 text-white p-2 rounded-lg transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-[#1f2b1b] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            data-alt="Drip irrigation system watering plants in a greenhouse"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCaLCCN1sb3pO-D-22LaE4c-H_DkorMbIeBoGCFQ8jRkMz2mnOPkhw3_Kl4aMJ0tVj5mCogMct_x1Ma0D2nC1VY-yRB8ERrxEiTXc7SFI9vn2qGn1iudpc4Wzu33yN4TRhtxJxwf1L79lqzemLTMNY8b4LQM-ThDhhn-SnW6P4iA6_Bd09WWZYLQcfULMmWVkhmWK5L63vam0dbAArX64sfXkoNCu3KYPZ8rL78Mr2FCAbA-OVcTZvgYxV65omcZeSjZtVlZ864Qo42");'>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">
                            Irrigation</div>
                        <h3 class="text-lg font-heading font-bold text-[#1e3f1b] dark:text-white truncate">
                            Auto-Drip Kit (50ft)</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span
                                class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-gray-200">$45.50</span>
                            <button
                                class="bg-primary hover:bg-primary/90 text-white p-2 rounded-lg transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white dark:bg-[#1f2b1b] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            data-alt="Packet of high quality heirloom tomato seeds"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCgTyX_gVdzneCxbC9fIWFWD50Fz2PNZcUiCmyJDicozr7VfjOQVT9tM0bnXe9ghgn2UzrjK60xGEph67kjI3-9xRtOsqH1R3NgYuEu5NAvbwBpMSfdU31gerbOTevgkBA13JAnq5IP85bFKxBEc4ruzFBezmOja3gl6FzS_YmWZTpyRQe4uvZS3ayWoaAv5FvgbEzi7hoX8qhGVzIXQviVfX1Gs38QzXnHI_8vvbtj0QN99mQtdBZzYigkOFDex9qCXLWTWIfpYIB6");'>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">
                            Seeds</div>
                        <h3 class="text-lg font-heading font-bold text-[#1e3f1b] dark:text-white truncate">
                            Heirloom Tomato Seeds</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span
                                class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-gray-200">$5.99</span>
                            <button
                                class="bg-primary hover:bg-primary/90 text-white p-2 rounded-lg transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex sm:hidden justify-center">
                <a class="flex items-center text-primary font-heading font-semibold hover:underline"
                    href="#">
                    View all products
                    <span class="material-symbols-outlined ml-1 text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
</main>
@endsection