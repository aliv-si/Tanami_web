@extends('layouts.app')

@section('title', 'About Us | Tanami')

@section('content')
<main class="flex-1">
    {{-- Hero Section --}}
    <section class="relative py-24 md:py-32 overflow-hidden bg-gradient-to-br from-[#1e3f1b] via-[#2d5a28] to-[#1a3518]">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-[#53be20] rounded-full blur-[120px]"></div>
            <div class="absolute bottom-10 right-20 w-96 h-96 bg-[#6dd03a] rounded-full blur-[150px]"></div>
        </div>
        <div class="container mx-auto px-4 md:px-10 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white/90 text-sm font-semibold mb-6 backdrop-blur-sm">
                    <span class="material-symbols-outlined text-[#53be20] text-lg">eco</span>
                    Growing Together Since 2025
                </span>
                <h1 class="text-4xl md:text-6xl font-heading font-bold text-white leading-tight mb-6">
                    Empowering <span class="text-[#53be20]">Urban Agriculture</span> Through Technology
                </h1>
                <p class="text-lg md:text-xl text-white/80 font-sans leading-relaxed max-w-3xl mx-auto">
                    Tanami is more than a marketplace — we're a movement connecting passionate farmers with conscious consumers, creating a sustainable ecosystem for fresh, locally-grown produce.
                </p>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-white dark:from-[#101a0e] to-transparent"></div>
    </section>

    {{-- Mission & Vision --}}
    <section class="py-20 bg-white dark:bg-[#101a0e]">
        <div class="container mx-auto px-4 md:px-10">
            <div class="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <div class="bg-gradient-to-br from-[#f8fff5] to-white dark:from-[#1a2617] dark:to-[#151f13] rounded-3xl p-10 border border-[#53be20]/20 shadow-xl shadow-[#53be20]/5 hover:shadow-2xl hover:shadow-[#53be20]/10 transition-all duration-500">
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-[#53be20] to-[#3d9118] flex items-center justify-center mb-6 shadow-lg shadow-[#53be20]/30">
                        <span class="material-symbols-outlined text-white text-3xl" style="font-variation-settings: 'FILL' 1;">visibility</span>
                    </div>
                    <h2 class="text-2xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-4">Our Vision</h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        To become the leading digital platform that revolutionizes urban agriculture in Indonesia, making fresh and healthy produce accessible to everyone while empowering local farmers with modern technology.
                    </p>
                </div>
                <div class="bg-gradient-to-br from-[#fff8f5] to-white dark:from-[#1a1917] dark:to-[#151513] rounded-3xl p-10 border border-orange-200/50 dark:border-orange-900/30 shadow-xl shadow-orange-500/5 hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-500">
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center mb-6 shadow-lg shadow-orange-500/30">
                        <span class="material-symbols-outlined text-white text-3xl" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                    </div>
                    <h2 class="text-2xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-4">Our Mission</h2>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        To simplify home gardening, increase agricultural productivity, and build thriving communities through the seamless integration of technology, knowledge sharing, and trusted commerce.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- What We Do --}}
    <section class="py-20 bg-[#f9fdf7] dark:bg-[#0d130b]">
        <div class="container mx-auto px-4 md:px-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-[#53be20]/10 text-[#53be20] text-sm font-bold uppercase tracking-wider mb-4">What We Offer</span>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-4">
                    A Complete Ecosystem for Modern Farming
                </h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    From seed to sale, we provide everything you need to grow, sell, and thrive in the world of urban agriculture.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                {{-- Marketplace --}}
                <div class="group bg-white dark:bg-[#1a2617] rounded-2xl p-8 border border-gray-100 dark:border-white/5 hover:border-[#53be20]/30 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="size-14 rounded-xl bg-[#53be20]/10 group-hover:bg-[#53be20] flex items-center justify-center mb-6 transition-colors">
                        <span class="material-symbols-outlined text-[#53be20] group-hover:text-white text-2xl transition-colors">storefront</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-3">Secure Marketplace</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Buy and sell fresh produce, seeds, and gardening supplies with our secure escrow payment system that protects both buyers and sellers.
                    </p>
                </div>

                {{-- Smart Automation --}}
                <div class="group bg-white dark:bg-[#1a2617] rounded-2xl p-8 border border-gray-100 dark:border-white/5 hover:border-[#53be20]/30 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="size-14 rounded-xl bg-blue-500/10 group-hover:bg-blue-500 flex items-center justify-center mb-6 transition-colors">
                        <span class="material-symbols-outlined text-blue-500 group-hover:text-white text-2xl transition-colors">settings_suggest</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-3">Smart Automation</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        IoT-powered automatic watering and fertilizing based on real-time soil moisture and fertility sensor data.
                    </p>
                </div>

                {{-- Real-Time Monitoring --}}
                <div class="group bg-white dark:bg-[#1a2617] rounded-2xl p-8 border border-gray-100 dark:border-white/5 hover:border-[#53be20]/30 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="size-14 rounded-xl bg-purple-500/10 group-hover:bg-purple-500 flex items-center justify-center mb-6 transition-colors">
                        <span class="material-symbols-outlined text-purple-500 group-hover:text-white text-2xl transition-colors">monitoring</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-3">Live Monitoring</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Track soil conditions, weather forecasts, and plant health in real-time with data sourced from BMKG.
                    </p>
                </div>

                {{-- TanamCare --}}
                <div class="group bg-white dark:bg-[#1a2617] rounded-2xl p-8 border border-gray-100 dark:border-white/5 hover:border-[#53be20]/30 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="size-14 rounded-xl bg-red-500/10 group-hover:bg-red-500 flex items-center justify-center mb-6 transition-colors">
                        <span class="material-symbols-outlined text-red-500 group-hover:text-white text-2xl transition-colors">health_and_safety</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-3">TanamCare AI</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        AI-powered plant disease detection — snap a photo of your plant and get instant diagnosis with treatment recommendations.
                    </p>
                </div>

                {{-- TanamAssistant --}}
                <div class="group bg-white dark:bg-[#1a2617] rounded-2xl p-8 border border-gray-100 dark:border-white/5 hover:border-[#53be20]/30 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="size-14 rounded-xl bg-amber-500/10 group-hover:bg-amber-500 flex items-center justify-center mb-6 transition-colors">
                        <span class="material-symbols-outlined text-amber-500 group-hover:text-white text-2xl transition-colors">smart_toy</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-3">TanamAssistant</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Your personal plant advisor providing tailored care tips, fertilizing reminders, and harvest predictions.
                    </p>
                </div>

                {{-- Community --}}
                <div class="group bg-white dark:bg-[#1a2617] rounded-2xl p-8 border border-gray-100 dark:border-white/5 hover:border-[#53be20]/30 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="size-14 rounded-xl bg-cyan-500/10 group-hover:bg-cyan-500 flex items-center justify-center mb-6 transition-colors">
                        <span class="material-symbols-outlined text-cyan-500 group-hover:text-white text-2xl transition-colors">groups</span>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-3">Gardening Community</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        Connect with fellow gardeners, share experiences, exchange tips, and grow your knowledge together.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Trust & Security --}}
    <section class="py-20 bg-white dark:bg-[#101a0e]">
        <div class="container mx-auto px-4 md:px-10">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <span class="inline-block px-4 py-1.5 rounded-full bg-[#53be20]/10 text-[#53be20] text-sm font-bold uppercase tracking-wider mb-4">Trust & Security</span>
                        <h2 class="text-3xl md:text-4xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-6">
                            Your Transactions Are Protected
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                            We've implemented industry-leading security measures to ensure every transaction on Tanami is safe, transparent, and fair for both buyers and sellers.
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="size-12 rounded-xl bg-[#53be20]/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-[#53be20]">account_balance</span>
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold text-[#1e3f1b] dark:text-white mb-1">Escrow Payment System</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Funds are held securely until the buyer confirms receipt, protecting both parties.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="size-12 rounded-xl bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-blue-500">schedule</span>
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold text-[#1e3f1b] dark:text-white mb-1">Automated Timeouts</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Smart auto-cancel and auto-complete features prevent orders from being stuck indefinitely.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="size-12 rounded-xl bg-purple-500/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-purple-500">history</span>
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold text-[#1e3f1b] dark:text-white mb-1">Complete Audit Trail</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Every status change is logged automatically for full transparency and dispute resolution.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-[#53be20]/20 to-[#1e3f1b]/20 rounded-3xl blur-3xl"></div>
                        <div class="relative bg-gradient-to-br from-[#1e3f1b] to-[#2d5a28] rounded-3xl p-10 text-white">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="text-center p-6 bg-white/10 rounded-2xl backdrop-blur-sm">
                                    <div class="text-4xl font-heading font-bold text-[#53be20] mb-2">24h</div>
                                    <div class="text-sm text-white/70">Payment Deadline</div>
                                </div>
                                <div class="text-center p-6 bg-white/10 rounded-2xl backdrop-blur-sm">
                                    <div class="text-4xl font-heading font-bold text-[#53be20] mb-2">48h</div>
                                    <div class="text-sm text-white/70">Verification Window</div>
                                </div>
                                <div class="text-center p-6 bg-white/10 rounded-2xl backdrop-blur-sm">
                                    <div class="text-4xl font-heading font-bold text-[#53be20] mb-2">3d</div>
                                    <div class="text-sm text-white/70">Auto-Complete</div>
                                </div>
                                <div class="text-center p-6 bg-white/10 rounded-2xl backdrop-blur-sm">
                                    <div class="text-4xl font-heading font-bold text-[#53be20] mb-2">100%</div>
                                    <div class="text-sm text-white/70">Refund Protection</div>
                                </div>
                            </div>
                            <div class="mt-8 p-6 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/10">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="material-symbols-outlined text-[#53be20]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                    <span class="font-bold">Secure Escrow System</span>
                                </div>
                                <p class="text-sm text-white/70">Your payment is held by the platform until you confirm delivery. If there's an issue, you're eligible for a full refund.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="py-20 bg-gradient-to-br from-[#53be20] to-[#3d9118]">
        <div class="container mx-auto px-4 md:px-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-heading font-bold text-white mb-2">500+</div>
                    <div class="text-white/80 font-medium">Local Farmers</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-heading font-bold text-white mb-2">10K+</div>
                    <div class="text-white/80 font-medium">Happy Customers</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-heading font-bold text-white mb-2">50K+</div>
                    <div class="text-white/80 font-medium">Orders Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-heading font-bold text-white mb-2">100+</div>
                    <div class="text-white/80 font-medium">Cities Covered</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Team / University --}}
    <section class="py-20 bg-[#f9fdf7] dark:bg-[#0d130b]">
        <div class="container mx-auto px-4 md:px-10">
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-1.5 rounded-full bg-[#53be20]/10 text-[#53be20] text-sm font-bold uppercase tracking-wider mb-4">The Team</span>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-[#1e3f1b] dark:text-white mb-4">
                    Built with Passion by Students
                </h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Tanami is a capstone project developed by Information Systems students at Universitas Amikom Yogyakarta, combining academic excellence with real-world problem solving.
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-6 max-w-4xl mx-auto">
                @php
                $team = [
                ['name' => 'Yudistira Azfa Dani W.', 'nim' => '24.12.3274'],
                ['name' => 'Muhammad Adam S.', 'nim' => '24.12.3281'],
                ['name' => 'Wasima Juhaina', 'nim' => '24.12.3282'],
                ['name' => 'Alief Fathin A.K.', 'nim' => '24.12.3303'],
                ['name' => 'Luqman Adiwidya', 'nim' => '24.12.3280'],
                ];
                @endphp
                @foreach($team as $member)
                <div class="bg-white dark:bg-[#1a2617] rounded-2xl p-6 border border-gray-100 dark:border-white/5 shadow-sm hover:shadow-lg transition-shadow text-center min-w-[200px]">
                    <div class="size-16 rounded-full bg-gradient-to-br from-[#53be20] to-[#3d9118] flex items-center justify-center mx-auto mb-4 shadow-lg shadow-[#53be20]/20">
                        <span class="material-symbols-outlined text-white text-2xl" style="font-variation-settings: 'FILL' 1;">person</span>
                    </div>
                    <h4 class="font-heading font-bold text-[#1e3f1b] dark:text-white text-sm">{{ $member['name'] }}</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $member['nim'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <div class="inline-flex items-center gap-4 px-8 py-4 bg-white dark:bg-[#1a2617] rounded-2xl border border-gray-100 dark:border-white/5 shadow-sm">
                    <div class="size-12 rounded-xl bg-[#1e3f1b] flex items-center justify-center">
                        <span class="material-symbols-outlined text-white">school</span>
                    </div>
                    <div class="text-left">
                        <p class="font-heading font-bold text-[#1e3f1b] dark:text-white">Universitas Amikom Yogyakarta</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Faculty of Computer Science • Information Systems</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 bg-white dark:bg-[#101a0e]">
        <div class="container mx-auto px-4 md:px-10">
            <div class="max-w-4xl mx-auto text-center bg-gradient-to-br from-[#1e3f1b] via-[#2d5a28] to-[#1a3518] rounded-3xl p-12 md:p-16 relative overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute top-10 right-10 w-40 h-40 bg-[#53be20] rounded-full blur-[80px]"></div>
                    <div class="absolute bottom-10 left-10 w-60 h-60 bg-[#6dd03a] rounded-full blur-[100px]"></div>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">
                        Ready to Start Growing?
                    </h2>
                    <p class="text-white/80 mb-8 max-w-xl mx-auto">
                        Join thousands of farmers and gardening enthusiasts who are already part of the Tanami community.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('katalog') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-[#53be20] text-white rounded-xl font-heading font-bold hover:bg-[#45a01b] transition-colors shadow-lg shadow-[#53be20]/30">
                            <span class="material-symbols-outlined">storefront</span>
                            Explore Products
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 text-white border border-white/20 rounded-xl font-heading font-bold hover:bg-white/20 transition-colors backdrop-blur-sm">
                            <span class="material-symbols-outlined">person_add</span>
                            Create Account
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection