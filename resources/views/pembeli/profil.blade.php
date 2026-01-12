@extends('layouts.app')

@section('title', 'User Profil | Tanami')

@section('content')
    <main class="flex-1 py-10">
        <div class="container mx-auto px-4 md:px-10 max-w-[1280px]">
            <div class="mb-8 hidden sm:block">
                <nav class="flex text-sm font-sans text-gray-500">
                    <a class="hover:text-primary" href="#">Home</a>
                    <span class="mx-2">/</span>
                    <span class="text-[#1e3f1b] font-medium">My Account</span>
                </nav>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <aside class="lg:col-span-3">
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden sticky top-24">
                        <div class="p-4 border-b border-gray-100 dark:border-white/5 lg:hidden">
                            <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">Account Menu</span>
                        </div>
                        <nav class="p-3 space-y-1">
                            <a class="flex items-center gap-3 px-4 py-3 bg-[#53be20]/10 text-[#53be20] rounded-lg font-heading font-medium text-[14px] transition-all"
                                href="#">
                                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                                Dashboard
                            </a>
                            <a class="flex items-center gap-3 px-4 py-3 text-[#1e3f1b] dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 rounded-lg font-heading font-medium text-[14px] transition-all group"
                                href="#">
                                <span
                                    class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-primary transition-colors">shopping_bag</span>
                                My Orders
                            </a>
                            <a class="flex items-center gap-3 px-4 py-3 text-[#1e3f1b] dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 rounded-lg font-heading font-medium text-[14px] transition-all group"
                                href="#">
                                <span
                                    class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-primary transition-colors">favorite</span>
                                Wishlist
                            </a>
                            <a class="flex items-center gap-3 px-4 py-3 text-[#1e3f1b] dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 rounded-lg font-heading font-medium text-[14px] transition-all group"
                                href="#">
                                <span
                                    class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-primary transition-colors">location_on</span>
                                Addresses
                            </a>
                            <a class="flex items-center gap-3 px-4 py-3 text-[#1e3f1b] dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 rounded-lg font-heading font-medium text-[14px] transition-all group"
                                href="#">
                                <span
                                    class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-primary transition-colors">settings</span>
                                Settings
                            </a>
                            <div class="h-px bg-gray-100 dark:bg-white/10 my-2"></div>
                            <a class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg font-heading font-medium text-[14px] transition-all"
                                href="#">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                                Log Out
                            </a>
                        </nav>
                    </div>
                </aside>
                <div class="lg:col-span-9 space-y-6">
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 flex flex-col md:flex-row items-center md:items-start gap-6 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-[#53be20]/5 rounded-bl-full -mr-8 -mt-8 pointer-events-none">
                        </div>
                        <div class="relative shrink-0">
                            <div
                                class="size-24 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden ring-4 ring-white dark:ring-[#1f2b1b] shadow-md">
                                <img alt="Budi Santoso" class="w-full h-full object-cover"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBCKWpGqKIaXyQHDVI0o4jfGEjIAOw8N_bfq_PUfGlgIQdZ4ODxzdYVYqaB6uNVwfyegEzxTLeXFHMvTgtBOizSRdlxycv2pDHomp1nsBM8UoXtT8uBhlue1qcSXXyktlmxuCWemySz4Ym1G0U31EoA_gY9R8xPk-WOrStPtBSdcCz_JAzmyzmbpTw9h_f3jjhRvUGRakQfITbmIo7_9Lsf0ZcIuCuVbTyu2u-3QB2N1bf-p_lxnLLSVUNgvwtdAL3gD0-Flfle-Yjb" />
                            </div>
                            <button
                                class="absolute bottom-0 right-0 bg-[#53be20] text-white p-1.5 rounded-full border-2 border-white dark:border-[#1f2b1b] shadow-sm hover:bg-[#45a01b] transition-colors"
                                title="Change Avatar">
                                <span class="material-symbols-outlined text-sm leading-none">photo_camera</span>
                            </button>
                        </div>
                        <div class="flex-1 text-center md:text-left z-10">
                            <div class="flex flex-col md:flex-row md:items-center gap-2 mb-2">
                                <h1 class="text-2xl font-heading font-bold text-[#1e3f1b] dark:text-white">Budi Santoso</h1>
                                <span
                                    class="inline-flex mx-auto md:mx-0 items-center px-2.5 py-0.5 rounded-full text-xs font-heading font-bold uppercase tracking-wide bg-[#53be20]/10 text-[#53be20] w-fit">
                                    Customer
                                </span>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-sans text-sm mb-4">Member since March 2024</p>
                            <div class="flex flex-wrap justify-center md:justify-start gap-3">
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 font-sans">
                                    <span class="material-symbols-outlined text-lg mr-1 text-gray-400">mail</span>
                                    budi.santoso@example.com
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 font-sans">
                                    <span class="material-symbols-outlined text-lg mr-1 text-gray-400">call</span>
                                    +62 812 3456 7890
                                </div>
                            </div>
                        </div>
                        <div class="shrink-0 z-10">
                            <button
                                class="flex items-center gap-2 px-5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg text-[#1e3f1b] dark:text-white font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-lg">edit</span>
                                Edit Profile
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div
                            class="bg-white dark:bg-[#1f2b1b] p-5 rounded-xl shadow-sm border border-gray-100 dark:border-white/5 flex items-center gap-4 group hover:border-[#53be20]/30 transition-colors">
                            <div
                                class="p-3 bg-[#53be20]/10 rounded-full text-[#53be20] group-hover:bg-[#53be20] group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                            </div>
                            <div>
                                <p
                                    class="text-gray-500 dark:text-gray-400 text-xs font-heading font-bold uppercase tracking-wider mb-1">
                                    Total Orders</p>
                                <p class="text-2xl font-heading font-bold text-[#1e3f1b] dark:text-white">24</p>
                            </div>
                        </div>
                        <div
                            class="bg-white dark:bg-[#1f2b1b] p-5 rounded-xl shadow-sm border border-gray-100 dark:border-white/5 flex items-center gap-4 group hover:border-[#53be20]/30 transition-colors">
                            <div
                                class="p-3 bg-[#53be20]/10 rounded-full text-[#53be20] group-hover:bg-[#53be20] group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-2xl">local_shipping</span>
                            </div>
                            <div>
                                <p
                                    class="text-gray-500 dark:text-gray-400 text-xs font-heading font-bold uppercase tracking-wider mb-1">
                                    Active</p>
                                <p class="text-2xl font-heading font-bold text-[#1e3f1b] dark:text-white">2</p>
                            </div>
                        </div>
                        <div
                            class="bg-white dark:bg-[#1f2b1b] p-5 rounded-xl shadow-sm border border-gray-100 dark:border-white/5 flex items-center gap-4 group hover:border-[#53be20]/30 transition-colors">
                            <div
                                class="p-3 bg-[#53be20]/10 rounded-full text-[#53be20] group-hover:bg-[#53be20] group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-2xl">check_circle</span>
                            </div>
                            <div>
                                <p
                                    class="text-gray-500 dark:text-gray-400 text-xs font-heading font-bold uppercase tracking-wider mb-1">
                                    Completed</p>
                                <p class="text-2xl font-heading font-bold text-[#1e3f1b] dark:text-white">22</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-white/5 flex justify-between items-center bg-gray-50/50 dark:bg-white/5">
                            <h3
                                class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#53be20]">badge</span>
                                Personal Information
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <label class="block text-sm font-sans text-gray-500 dark:text-gray-400 mb-1.5">Full
                                        Name</label>
                                    <div class="text-[#1e3f1b] dark:text-gray-200 font-sans font-medium text-[16px]">Budi
                                        Santoso</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-sans text-gray-500 dark:text-gray-400 mb-1.5">Phone
                                        Number</label>
                                    <div class="text-[#1e3f1b] dark:text-gray-200 font-sans font-medium text-[16px]">+62 812
                                        3456 7890</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-sans text-gray-500 dark:text-gray-400 mb-1.5">Email
                                        Address</label>
                                    <div class="text-[#1e3f1b] dark:text-gray-200 font-sans font-medium text-[16px]">
                                        budi.santoso@example.com</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-sans text-gray-500 dark:text-gray-400 mb-1.5">Default
                                        Shipping Location</label>
                                    <div class="text-[#1e3f1b] dark:text-gray-200 font-sans font-medium text-[16px]">Jakarta
                                        Pusat, Indonesia</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white dark:bg-[#1f2b1b] rounded-xl shadow-sm border border-gray-100 dark:border-white/5 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-100 dark:border-white/5 flex justify-between items-center bg-gray-50/50 dark:bg-white/5">
                            <h3
                                class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#53be20]">home_pin</span>
                                Address Book
                            </h3>
                            <button
                                class="flex items-center gap-1 text-[#53be20] text-sm font-heading font-bold hover:bg-[#53be20]/10 px-3 py-1.5 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-lg">add</span>
                                Add New Address
                            </button>
                        </div>
                        <div class="p-6 space-y-4">
                            <div
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-5 relative hover:border-[#53be20] dark:hover:border-[#53be20] transition-colors cursor-pointer group bg-white dark:bg-[#1f2b1b]">
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-2 mb-3">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="font-heading font-bold text-[#1e3f1b] dark:text-white text-lg">Home</span>
                                        <span
                                            class="bg-[#1e3f1b] dark:bg-white text-white dark:text-[#1e3f1b] text-[10px] px-2 py-1 rounded font-bold uppercase tracking-wider leading-none">Default</span>
                                    </div>
                                    <div class="flex gap-2 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                        <button
                                            class="p-1.5 text-gray-400 hover:text-[#53be20] hover:bg-[#53be20]/10 rounded transition-colors"><span
                                                class="material-symbols-outlined text-lg">edit</span></button>
                                        <button
                                            class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-colors"><span
                                                class="material-symbols-outlined text-lg">delete</span></button>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 font-sans text-sm leading-relaxed mb-2">
                                    Jl. Jendral Sudirman No. 123, Rt. 01/Rw. 02, Kec. Tanah Abang<br />
                                    Jakarta Pusat, DKI Jakarta 10220<br />
                                    Indonesia
                                </p>
                                <p
                                    class="text-gray-600 dark:text-gray-300 font-sans text-sm font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-gray-400 text-sm">call</span>
                                    +62 812 3456 7890
                                </p>
                            </div>
                            <div
                                class="border border-gray-200 dark:border-gray-700 rounded-lg p-5 relative hover:border-[#53be20] dark:hover:border-[#53be20] transition-colors cursor-pointer group bg-white dark:bg-[#1f2b1b]">
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-2 mb-3">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="font-heading font-bold text-[#1e3f1b] dark:text-white text-lg">Office</span>
                                    </div>
                                    <div class="flex gap-2 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                        <button
                                            class="p-1.5 text-gray-400 hover:text-[#53be20] hover:bg-[#53be20]/10 rounded transition-colors"><span
                                                class="material-symbols-outlined text-lg">edit</span></button>
                                        <button
                                            class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition-colors"><span
                                                class="material-symbols-outlined text-lg">delete</span></button>
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 font-sans text-sm leading-relaxed mb-2">
                                    Green Office Park, BSD City<br />
                                    Tangerang, Banten 15345<br />
                                    Indonesia
                                </p>
                                <p
                                    class="text-gray-600 dark:text-gray-300 font-sans text-sm font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-gray-400 text-sm">call</span>
                                    +62 812 3456 7890
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
