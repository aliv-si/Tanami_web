@extends('layouts.app')

@section('title', 'Product Detail | Tanami')

@section('content')
    <main class="flex-1 w-full max-w-[1280px] mx-auto px-4 md:px-10 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <div class="flex flex-col gap-4">
                <div class="aspect-square bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
                    <div class="w-full h-full bg-cover bg-center"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCxE7eDcmYVVRGHOds0-yQE0wN8X4BG-1WAhWX5edH3o-hvl90YBhbCj9xJyoYvOOZqRmGeFsSLT-849teLlLI3XLXA8jDQ_gmM9uKcjO89rd1mnpKePJMDZJPdyYdJ0hGsJjDZabupvl75x6YtT7hR_3L_nMpLMIDX_WzyF_YaJfmKg1zO5Bf6wR3es-4PlVFynehLRmEK2msfjyBRTacH_TVeUvdhWJwNdUDeKyP253ri4eggaQJGa29HHREL71yDQIkZLcIYqJhX");'>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-4">
                    <div
                        class="aspect-square bg-white rounded-lg border-2 border-primary overflow-hidden cursor-pointer shadow-sm">
                        <div class="w-full h-full bg-cover bg-center"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCxE7eDcmYVVRGHOds0-yQE0wN8X4BG-1WAhWX5edH3o-hvl90YBhbCj9xJyoYvOOZqRmGeFsSLT-849teLlLI3XLXA8jDQ_gmM9uKcjO89rd1mnpKePJMDZJPdyYdJ0hGsJjDZabupvl75x6YtT7hR_3L_nMpLMIDX_WzyF_YaJfmKg1zO5Bf6wR3es-4PlVFynehLRmEK2msfjyBRTacH_TVeUvdhWJwNdUDeKyP253ri4eggaQJGa29HHREL71yDQIkZLcIYqJhX");'>
                        </div>
                    </div>
                    <div
                        class="aspect-square bg-white rounded-lg border border-gray-100 overflow-hidden cursor-pointer hover:border-primary/50 shadow-sm transition-colors">
                        <div class="w-full h-full bg-cover bg-center opacity-80"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAzb0JT1LObIMcoqQyyxEOilNQgBtHve9FeMiE-hZUkxa8jtBQsRotdSddt6mYag-jlm1gomXcEPMClEq-m6f5IbiasG-rEzGPjF78HWcqBtKyvEz-nK8ELdfPzm7g7dSMhms3hP_ea5p5FyFr6UdKNWaNP6JKWDAH3J3xB62UiHEKiGQCd-bPDUeL8N_ij3k78cNWjntmNrZAE3yXLyhgrksXyEJdlR9WgRY9PN6Klc7MEDiO1AazO2o324MyRqkdVBgjqTSKIcbiz");'>
                        </div>
                    </div>
                    <div
                        class="aspect-square bg-white rounded-lg border border-gray-100 overflow-hidden cursor-pointer hover:border-primary/50 shadow-sm transition-colors">
                        <div class="w-full h-full bg-cover bg-center opacity-80"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCaLCCN1sb3pO-D-22LaE4c-H_DkorMbIeBoGCFQ8jRkMz2mnOPkhw3_Kl4aMJ0tVj5mCogMct_x1Ma0D2nC1VY-yRB8ERrxEiTXc7SFI9vn2qGn1iudpc4Wzu33yN4TRhtxJxwf1L79lqzemLTMNY8b4LQM-ThDhhn-SnW6P4iA6_Bd09WWZYLQcfULMmWVkhmWK5L63vam0dbAArX64sfXkoNCu3KYPZ8rL78Mr2FCAbA-OVcTZvgYxV65omcZeSjZtVlZ864Qo42");'>
                        </div>
                    </div>
                    <div
                        class="aspect-square bg-white rounded-lg border border-gray-100 overflow-hidden cursor-pointer hover:border-primary/50 shadow-sm transition-colors">
                        <div class="w-full h-full bg-cover bg-center opacity-80"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBdqyAY8cOXgiqLGVnXKz7Ty9ZXwMqO9eD9mTQ044jZM4jj0_zYGu0kT-0d-EY6tSOBYVtsY3n7FwsfdfQHNRpwm7dHtkglJv9CTtpKcNkmHUKjIUs2gAC197gDvTXGtDSYTWiJARnolNz5DfCUwnQT3Bzs2nEZaMwiyUYoIVioTJDRezoE0D0gTcyfyWhT2FwghIrX1w1TYigKHD9DKXB6U-q2r2btlpVETmHk34YX7FQ6OJwWHrPNI8rOOXoxosI9fLzhyoqKgxPx");'>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="text-[12px] font-heading font-bold uppercase tracking-widest text-primary mb-2">TECH</div>
                <h1 class="text-[36px] font-heading font-bold leading-tight mb-2">Smart Soil Sensor Pro</h1>
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center text-yellow-400">
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                        <span class="material-symbols-outlined fill-1">star</span>
                    </div>
                    <span class="text-sm text-gray-500 font-sans">(48 reviews)</span>
                </div>
                <div class="text-[32px] font-heading font-bold text-content-dark mb-6">$129.00</div>
                <p class="text-gray-600 mb-8 max-w-lg">
                    Monitor your crop health in real-time with industrial-grade precision. This sensor tracks soil moisture,
                    temperature, and pH levels, delivering data directly to your mobile device for optimized irrigation and
                    fertilization.
                </p>
                <div class="flex flex-col gap-4 mb-8">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center border border-gray-200 rounded-lg bg-white h-12">
                            <button class="px-4 text-gray-500 hover:text-primary"><span
                                    class="material-symbols-outlined text-lg">remove</span></button>
                            <span class="px-2 font-heading font-bold w-8 text-center">1</span>
                            <button class="px-4 text-gray-500 hover:text-primary"><span
                                    class="material-symbols-outlined text-lg">add</span></button>
                        </div>
                        <button
                            class="flex-1 bg-primary text-white h-12 rounded-lg btn-text hover:bg-opacity-90 shadow-lg shadow-primary/20 transition-all">
                            Add to Cart
                        </button>
                    </div>
                    <button
                        class="w-full border-2 border-content-dark text-content-dark h-12 rounded-lg btn-text hover:bg-content-dark hover:text-white transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-xl">favorite</span>
                        Add to Wishlist
                    </button>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <div class="size-12 rounded-full overflow-hidden bg-gray-100">
                        <img alt="Farmer Agus" class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuA9SVueF3UMWNfWLzenfaGJDjZ5FjdH1dkWBpxUdXWxjDnk9QZdGQVoySw8yNjVcFCUotHZpkb0sFo2IdAitrd_kCyyIHWug0_slETCUJbp5YGYrUVR_p-Gkmj21NlreBkTV7glmL9KVBVIE-d_5K5TKeeVl-BxQXf3bgseYOChCbWsHCf1D8w3ngIwXAV63PNsBQ_mmK4vNBl04encGshKcdr8qiM-RE7EDn2nWgki-h6WA6XHxPo2DGb1QQaeW3VjXV8-eh9B7xGW" />
                    </div>
                    <div>
                        <div class="flex items-center gap-1">
                            <span class="font-heading font-bold text-content-dark">Agus Setiawan</span>
                            <span class="material-symbols-outlined text-primary text-base">verified</span>
                        </div>
                        <div class="text-xs text-gray-500 font-sans">Lembang, West Java • Verified Farmer</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-16">
            <div class="border-b border-gray-200 mb-8">
                <div class="flex gap-10">
                    <button
                        class="pb-4 border-b-2 border-primary text-primary font-heading font-semibold text-[16px]">Description</button>
                    <button
                        class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-content-dark font-heading font-semibold text-[16px] transition-colors">Specifications</button>
                    <button
                        class="pb-4 border-b-2 border-transparent text-gray-500 hover:text-content-dark font-heading font-semibold text-[16px] transition-colors">Benefits</button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="md:col-span-2 space-y-4">
                    <h3 class="text-xl font-heading font-bold">Industrial Grade Monitoring</h3>
                    <p class="text-gray-600">
                        The Smart Soil Sensor Pro represents the pinnacle of modern agritech. Engineered to withstand harsh
                        outdoor environments while maintaining laboratory-level accuracy, it provides continuous monitoring
                        of the essential pillars of soil health.
                    </p>
                    <p class="text-gray-600">
                        With integrated LoRaWAN and WiFi connectivity, data is transmitted every 15 minutes to the Tanami
                        Cloud, allowing you to visualize trends and receive instant alerts if moisture or pH levels fall
                        outside of your custom-defined parameters.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm h-fit">
                    <h4 class="font-heading font-bold mb-4">What's in the box?</h4>
                    <ul class="space-y-3 text-sm font-sans text-gray-600">
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-primary text-base">check_circle</span> 1x Smart Soil
                            Sensor Pro</li>
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-primary text-base">check_circle</span> Calibration Kit
                        </li>
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-primary text-base">check_circle</span> Solar Charging
                            Panel</li>
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-primary text-base">check_circle</span> Quick Start
                            Guide</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mb-16">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-[36px] font-heading font-semibold">Related Products</h2>
                    <p class="text-gray-500 font-sans">Complement your smart farm setup.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBdqyAY8cOXgiqLGVnXKz7Ty9ZXwMqO9eD9mTQ044jZM4jj0_zYGu0kT-0d-EY6tSOBYVtsY3n7FwsfdfQHNRpwm7dHtkglJv9CTtpKcNkmHUKjIUs2gAC197gDvTXGtDSYTWiJARnolNz5DfCUwnQT3Bzs2nEZaMwiyUYoIVioTJDRezoE0D0gTcyfyWhT2FwghIrX1w1TYigKHD9DKXB6U-q2r2btlpVETmHk34YX7FQ6OJwWHrPNI8rOOXoxosI9fLzhyoqKgxPx");'>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">Nutrients
                        </div>
                        <h3 class="text-lg font-heading font-bold text-content-dark truncate">Organic Nitrogen Boost</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xl font-heading font-bold">$24.99</span>
                            <button
                                class="bg-primary hover:bg-opacity-90 text-white p-2 rounded-lg transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCaLCCN1sb3pO-D-22LaE4c-H_DkorMbIeBoGCFQ8jRkMz2mnOPkhw3_Kl4aMJ0tVj5mCogMct_x1Ma0D2nC1VY-yRB8ERrxEiTXc7SFI9vn2qGn1iudpc4Wzu33yN4TRhtxJxwf1L79lqzemLTMNY8b4LQM-ThDhhn-SnW6P4iA6_Bd09WWZYLQcfULMmWVkhmWK5L63vam0dbAArX64sfXkoNCu3KYPZ8rL78Mr2FCAbA-OVcTZvgYxV65omcZeSjZtVlZ864Qo42");'>
                        </div>
                        <div
                            class="absolute top-3 left-3 bg-primary text-white text-xs font-bold px-2 py-1 rounded font-heading">
                            Popular</div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">Irrigation
                        </div>
                        <h3 class="text-lg font-heading font-bold text-content-dark truncate">Auto-Drip Kit (50ft)</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xl font-heading font-bold">$45.50</span>
                            <button
                                class="bg-primary hover:bg-opacity-90 text-white p-2 rounded-lg transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCgTyX_gVdzneCxbC9fIWFWD50Fz2PNZcUiCmyJDicozr7VfjOQVT9tM0bnXe9ghgn2UzrjK60xGEph67kjI3-9xRtOsqH1R3NgYuEu5NAvbwBpMSfdU31gerbOTevgkBA13JAnq5IP85bFKxBEc4ruzFBezmOja3gl6FzS_YmWZTpyRQe4uvZS3ayWoaAv5FvgbEzi7hoX8qhGVzIXQviVfX1Gs38QzXnHI_8vvbtj0QN99mQtdBZzYigkOFDex9qCXLWTWIfpYIB6");'>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">Seeds</div>
                        <h3 class="text-lg font-heading font-bold text-content-dark truncate">Heirloom Tomato Seeds</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xl font-heading font-bold">$5.99</span>
                            <button
                                class="bg-primary hover:bg-opacity-90 text-white p-2 rounded-lg transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group">
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAzb0JT1LObIMcoqQyyxEOilNQgBtHve9FeMiE-hZUkxa8jtBQsRotdSddt6mYag-jlm1gomXcEPMClEq-m6f5IbiasG-rEzGPjF78HWcqBtKyvEz-nK8ELdfPzm7g7dSMhms3hP_ea5p5FyFr6UdKNWaNP6JKWDAH3J3xB62UiHEKiGQCd-bPDUeL8N_ij3k78cNWjntmNrZAE3yXLyhgrksXyEJdlR9WgRY9PN6Klc7MEDiO1AazO2o324MyRqkdVBgjqTSKIcbiz");'>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">Tools</div>
                        <h3 class="text-lg font-heading font-bold text-content-dark truncate">Precision Soil pH Meter</h3>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xl font-heading font-bold">$89.00</span>
                            <button
                                class="bg-primary hover:bg-opacity-90 text-white p-2 rounded-lg transition-colors flex items-center justify-center">
                                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
