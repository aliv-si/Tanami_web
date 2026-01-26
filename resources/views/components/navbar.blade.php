<header
    class="sticky top-0 z-50 w-full bg-white/90 dark:bg-background-dark/90 backdrop-blur-md border-b border-[#e5e7eb] dark:border-[#2f3e2a]">
    <div class="px-4 md:px-10 py-3 mx-auto max-w-[1280px]">
        <div class="flex items-center justify-between whitespace-nowrap">
            <div class="flex items-center gap-3 text-content-dark dark:text-white">
                <img
                    src="{{ asset('images/logoinvert.png') }}"
                    alt="Tanami Logo"
                    class="h-6 w-auto object-contain" />
            </div>
            <div class="hidden md:flex flex-1 justify-center gap-8 font-heading">
                <a class="{{ request()->routeIs('home') ? 'text-content-dark font-semibold' : 'text-gray-400 dark:text-gray-500' }} hover:text-content-dark dark:hover:text-content-dark transition-colors text-[16px] font-medium leading-normal"
                    href="{{ route('home') }}">Home</a>
                <a class="{{ request()->routeIs('katalog') || request()->routeIs('produk.*') ? 'text-content-dark font-semibold' : 'text-gray-400 dark:text-gray-500' }} hover:text-content-dark dark:hover:text-content-dark transition-colors text-[16px] font-medium leading-normal"
                    href="{{ route('katalog') }}">Shop</a>
                <a class="{{ request()->routeIs('tentang') ? 'text-content-dark font-semibold' : 'text-gray-400 dark:text-gray-500' }} hover:text-content-dark dark:hover:text-content-dark transition-colors text-[16px] font-medium leading-normal"
                    href="{{ route('tentang') }}">About</a>
                <a class="{{ request()->routeIs('kontak') ? 'text-content-dark font-semibold' : 'text-gray-400 dark:text-gray-500' }} hover:text-content-dark dark:hover:text-content-dark transition-colors text-[16px] font-medium leading-normal"
                    href="{{ route('kontak') }}">Contact</a>
            </div>
            <div class="flex items-center justify-center gap-3">
                <button
                    class="flex items-center justify-center size-10 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-content-dark dark:text-white transition-colors">
                    <span class="material-symbols-outlined">search</span>
                </button>
                <div class="flex items-center justify-center gap-3">
                    @auth
                    {{-- Keranjang (hanya untuk pembeli) --}}
                    @if(auth()->user()->isPembeli())
                    <button
                        class="flex items-center justify-center size-10 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-content-dark dark:text-white transition-colors">
                        <a href="{{ route('keranjang') }}" class="nav-icon-btn relative">
                            <span class="material-symbols-outlined">shopping_bag</span>
                            <span class="absolute top-1 right-1 size-2 bg-primary rounded-full"></span>
                        </a>
                    </button>
                    @endif

                    {{-- Profile Dropdown --}}
                    <div class="relative group">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <div class="size-8 bg-primary/20 rounded-full flex items-center justify-center">
                                <span class="text-primary font-bold text-sm">{{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 1)) }}</span>
                            </div>
                            <span class="hidden lg:block text-sm font-semibold text-content-dark dark:text-white max-w-[100px] truncate">
                                {{ auth()->user()->nama_lengkap }}
                            </span>
                            <span class="material-symbols-outlined text-gray-400 text-sm">expand_more</span>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-[#1f2b1b] rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-gray-100 dark:border-gray-700">
                                <p class="font-semibold text-content-dark dark:text-white text-sm">{{ auth()->user()->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full 
                                    @if(auth()->user()->isAdmin()) bg-purple-100 text-purple-700
                                    @elseif(auth()->user()->isPetani()) bg-green-100 text-green-700
                                    @else bg-blue-100 text-blue-700 @endif">
                                    {{ ucfirst(auth()->user()->role_pengguna) }}
                                </span>
                            </div>
                            <div class="p-2">
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">admin_panel_settings</span>
                                    Dashboard Admin
                                </a>
                                @elseif(auth()->user()->isPetani())
                                <a href="{{ route('petani.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">dashboard</span>
                                    Dashboard Farmer
                                </a>
                                <a href="{{ route('petani.produk') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">inventory_2</span>
                                    Products
                                </a>
                                @else
                                <a href="{{ route('pesanan') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">receipt_long</span>
                                        Orders
                                </a>
                                @endif
                                <a href="{{ route('profil') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">person</span>
                                    Profile
                                </a>
                            </div>
                            <div class="p-2 border-t border-gray-100 dark:border-gray-700">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                        <span class="material-symbols-outlined text-lg">logout</span>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- Guest: Login/Register Buttons --}}
                    <a href="{{ route('login') }}" class="flex items-center px-4 py-2 bg-primary hover:bg-primary/90 text-white text-sm font-semibold rounded-lg shadow-md shadow-primary/25 transition-all font-heading">
                        Login
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>