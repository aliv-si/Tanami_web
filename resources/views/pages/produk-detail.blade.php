@extends('layouts.app')

@section('title', $produk->nama_produk . ' | Tanami')

@section('content')
<main class="flex-1 w-full max-w-[1280px] mx-auto px-4 md:px-10 py-6">
    {{-- Breadcrumb --}}
    <div class="flex flex-wrap gap-2 mb-6 font-display">
        <a class="text-text-secondary text-sm font-medium hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
        <span class="text-text-secondary text-sm font-medium">/</span>
        <a class="text-text-secondary text-sm font-medium hover:text-primary transition-colors" href="{{ route('katalog') }}">Katalog</a>
        <span class="text-text-secondary text-sm font-medium">/</span>
        @if($produk->kategori)
        <a class="text-text-secondary text-sm font-medium hover:text-primary transition-colors" href="{{ route('katalog', ['kategori' => $produk->kategori->slug_kategori]) }}">{{ $produk->kategori->nama_kategori }}</a>
        <span class="text-text-secondary text-sm font-medium">/</span>
        @endif
        <span class="text-text-main dark:text-white text-sm font-medium">{{ $produk->nama_produk }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
        {{-- Product Images --}}
        <div class="flex flex-col gap-4">
            {{-- Main Image --}}
            <div class="aspect-square bg-white dark:bg-[#1e2a1a] rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-[#2a3825]">
                @if($produk->foto)
                <img id="main-product-image" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover" src="{{ Storage::url($produk->foto) }}" />
                @else
                <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-[#253220]">
                    <span class="material-symbols-outlined text-8xl text-gray-400">image</span>
                </div>
                @endif
            </div>

            {{-- Thumbnail Previews --}}
            @if($produk->foto)
            <div class="grid grid-cols-4 gap-4">
                <div class="aspect-square bg-white dark:bg-[#1e2a1a] rounded-lg border-2 border-primary overflow-hidden cursor-pointer shadow-sm">
                    <img alt="Preview 1" class="w-full h-full object-cover" src="{{ Storage::url($produk->foto) }}" />
                </div>
                <div class="aspect-square bg-white dark:bg-[#1e2a1a] rounded-lg border border-gray-100 dark:border-[#2a3825] overflow-hidden cursor-pointer hover:border-primary/50 shadow-sm transition-colors">
                    <img alt="Preview 2" class="w-full h-full object-cover object-top opacity-80" src="{{ Storage::url($produk->foto) }}" />
                </div>
                <div class="aspect-square bg-white dark:bg-[#1e2a1a] rounded-lg border border-gray-100 dark:border-[#2a3825] overflow-hidden cursor-pointer hover:border-primary/50 shadow-sm transition-colors">
                    <img alt="Preview 3" class="w-full h-full object-cover object-bottom opacity-80" src="{{ Storage::url($produk->foto) }}" />
                </div>
                <div class="aspect-square bg-white dark:bg-[#1e2a1a] rounded-lg border border-gray-100 dark:border-[#2a3825] overflow-hidden cursor-pointer hover:border-primary/50 shadow-sm transition-colors">
                    <img alt="Preview 4" class="w-full h-full object-cover scale-110 opacity-80" src="{{ Storage::url($produk->foto) }}" />
                </div>
            </div>
            @endif
        </div>

        {{-- Product Info --}}
        <div class="flex flex-col">
            {{-- Category Badge --}}
            @if($produk->kategori)
            <div class="text-[12px] font-heading font-bold uppercase tracking-widest text-primary mb-2">{{ $produk->kategori->nama_kategori }}</div>
            @endif

            {{-- Product Name --}}
            <h1 class="text-[36px] font-heading font-bold leading-tight mb-2 text-text-main dark:text-white">{{ $produk->nama_produk }}</h1>

            {{-- Rating --}}
            <div class="flex items-center gap-4 mb-6">
                <div class="flex items-center">
                    @php
                    $avgRating = $ratingStats['rata_rata'];
                    $fullStars = floor($avgRating);
                    $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                    @endphp

                    @for ($i = 0; $i < $fullStars; $i++)
                        <span class="fa-solid fa-star text-amber-400 text-lg"></span>
                        @endfor

                        @if ($hasHalfStar)
                        <span class="fa-solid fa-star-half-stroke text-amber-400 text-lg"></span>
                        @endif

                        @for ($i = 0; $i < $emptyStars; $i++)
                            <span class="fa-regular fa-star text-gray-300 dark:text-gray-600 text-lg"></span>
                            @endfor
                </div>
                @if($avgRating > 0)
                <span class="text-sm font-semibold text-amber-500">{{ number_format($avgRating, 1) }}</span>
                @endif
                <span class="text-sm text-gray-500 font-display">({{ $ratingStats['total'] }} ulasan)</span>
            </div>

            {{-- Price --}}
            <div class="text-[32px] font-heading font-bold text-[#53be20] mb-6">Rp {{ number_format($produk->harga, 0, ',', '.') }} <span class="text-sm text-text-secondary font-display font-normal">/ {{ $produk->satuan }}</span></div>

            {{-- Description --}}
            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-lg font-display leading-relaxed">
                {{ $produk->deskripsi }}
            </p>

            {{-- Add to Cart --}}
            <div class="flex flex-col gap-4 mb-8">
                @if($produk->stok > 0)
                <form action="{{ route('keranjang.store') }}" method="POST" class="flex items-center gap-4">
                    @csrf
                    <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                    <div class="flex items-center border border-gray-200 dark:border-[#2a3825] rounded-lg bg-white dark:bg-[#1e2a1a] h-12">
                        <button type="button" onclick="decreaseQty()" class="px-4 text-gray-500 hover:text-primary">
                            <span class="material-symbols-outlined text-lg">remove</span>
                        </button>
                        <input type="number" name="jumlah" id="qty-input" value="1" min="1" max="{{ $produk->stok }}"
                            class="w-16 text-center font-heading font-bold bg-transparent border-0 focus:ring-0 text-text-main dark:text-white" />
                        <button type="button" onclick="increaseQty()" data-max="{{ $produk->stok }}" class="px-4 text-gray-500 hover:text-primary" id="btn-increase">
                            <span class="material-symbols-outlined text-lg">add</span>
                        </button>
                    </div>
                    <button type="submit"
                        class="flex-1 bg-primary text-white h-12 rounded-lg font-heading font-semibold hover:bg-opacity-90 shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">add_shopping_cart</span>
                        Tambah ke Keranjang
                    </button>
                </form>
                @else
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-sm font-medium">
                        <span class="material-symbols-outlined text-base">cancel</span>
                        Stok habis
                    </span>
                    <button disabled class="flex-1 bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 h-12 rounded-lg font-heading font-semibold cursor-not-allowed">
                        Stok Habis
                    </button>
                </div>
                @endif

                {{-- Stock Info --}}
                @if($produk->stok > 0)
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm font-medium w-fit">
                    <span class="material-symbols-outlined text-base">check_circle</span>
                    Stok tersedia ({{ $produk->stok }} {{ $produk->satuan }})
                </span>
                @endif

                {{-- Wishlist Button --}}
                <button
                    class="w-full border-2 border-text-main dark:border-gray-600 text-text-main dark:text-white h-12 rounded-lg font-heading font-semibold hover:bg-text-main hover:text-white dark:hover:bg-gray-600 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-xl">favorite</span>
                    Tambah ke Wishlist
                </button>
            </div>

            {{-- Seller Info --}}
            @if($produk->petani)
            <div class="bg-white dark:bg-[#1e2a1a] p-4 rounded-xl border border-gray-100 dark:border-[#2a3825] shadow-sm flex items-center gap-4">
                <div class="size-12 rounded-full overflow-hidden bg-gray-100 dark:bg-[#253220] flex items-center justify-center">
                    @if($produk->petani->foto_profil)
                    <img alt="{{ $produk->petani->nama }}" class="w-full h-full object-cover" src="{{ Storage::url($produk->petani->foto_profil) }}" />
                    @else
                    <span class="material-symbols-outlined text-2xl text-gray-400">person</span>
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-1">
                        <span class="font-heading font-bold text-text-main dark:text-white">{{ $produk->petani->nama }}</span>
                        @if($produk->petani->terverifikasi)
                        <span class="material-symbols-outlined text-primary text-base">verified</span>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 font-display">
                        {{ $produk->petani->alamat ?? 'Petani Lokal' }}
                        @if($produk->petani->terverifikasi) • Petani Terverifikasi @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Product Description Section --}}
    <div class="mb-16">
        <div class="border-b border-gray-200 dark:border-[#2a3825] mb-8">
            <div class="flex gap-10">
                <button id="tab-desc" onclick="showTab('desc')"
                    class="tab-btn pb-4 border-b-2 border-primary text-primary font-heading font-semibold text-[16px]">Deskripsi</button>
                <button id="tab-ulasan" onclick="showTab('ulasan')"
                    class="tab-btn pb-4 border-b-2 border-transparent text-gray-500 hover:text-text-main dark:hover:text-white font-heading font-semibold text-[16px] transition-colors">
                    Ulasan ({{ $ratingStats['total'] }})
                </button>
            </div>
        </div>

        {{-- Description Tab Content --}}
        <div id="content-desc" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="md:col-span-2 space-y-4">
                    <h3 class="text-xl font-heading font-bold text-text-main dark:text-white">Detail Produk</h3>
                    <p class="text-gray-600 dark:text-gray-400 font-display leading-relaxed whitespace-pre-line">{{ $produk->deskripsi }}</p>
                </div>
                <div class="bg-white dark:bg-[#1e2a1a] p-6 rounded-xl border border-gray-100 dark:border-[#2a3825] shadow-sm h-fit">
                    <h4 class="font-heading font-bold mb-4 text-text-main dark:text-white">Informasi Produk</h4>
                    <ul class="space-y-3 text-sm font-display text-gray-600 dark:text-gray-400">
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-base">check_circle</span>
                            Kategori: {{ $produk->kategori->nama_kategori ?? 'Umum' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-base">check_circle</span>
                            Satuan: {{ $produk->satuan }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-base">check_circle</span>
                            Stok: {{ $produk->stok }} {{ $produk->satuan }}
                        </li>
                        @if($produk->petani)
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-base">check_circle</span>
                            Petani: {{ $produk->petani->nama }}
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- Reviews Tab Content --}}
        <div id="content-ulasan" class="tab-content hidden">
            {{-- Rating Summary --}}
            <div class="bg-white dark:bg-[#1e2a1a] rounded-xl border border-gray-100 dark:border-[#2a3825] p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex flex-col items-center justify-center md:w-48">
                        <div class="text-5xl font-bold text-text-main dark:text-white font-heading">{{ number_format($ratingStats['rata_rata'], 1) }}</div>
                        <div class="flex items-center mt-2">
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < floor($ratingStats['rata_rata']))
                                <span class="fa-solid fa-star text-amber-400"></span>
                                @elseif ($i == floor($ratingStats['rata_rata']) && ($ratingStats['rata_rata'] - floor($ratingStats['rata_rata'])) >= 0.5)
                                <span class="fa-solid fa-star-half-stroke text-amber-400"></span>
                                @else
                                <span class="fa-regular fa-star text-gray-300 dark:text-gray-600"></span>
                                @endif
                                @endfor
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1 font-display">{{ $ratingStats['total'] }} ulasan</div>
                    </div>
                    <div class="flex-1 space-y-2">
                        @for ($i = 5; $i >= 1; $i--)
                        @php
                        $count = $ratingStats['distribusi'][$i];
                        $percentage = $ratingStats['total'] > 0 ? ($count / $ratingStats['total']) * 100 : 0;
                        @endphp
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-600 dark:text-gray-400 font-display w-3">{{ $i }}</span>
                            <span class="fa-solid fa-star text-amber-400 text-sm"></span>
                            <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400 font-display w-8">{{ $count }}</span>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Reviews List --}}
            @if($produk->ulasan->count() > 0)
            <div class="space-y-4">
                @foreach($produk->ulasan as $ulasan)
                <div class="bg-white dark:bg-[#1e2a1a] rounded-xl border border-gray-100 dark:border-[#2a3825] p-5">
                    <div class="flex items-start gap-4">
                        <div class="size-10 rounded-full overflow-hidden bg-gray-100 dark:bg-[#253220] flex items-center justify-center shrink-0">
                            @if($ulasan->pengguna && $ulasan->pengguna->foto_profil)
                            <img alt="{{ $ulasan->pengguna->nama }}" class="w-full h-full object-cover" src="{{ Storage::url($ulasan->pengguna->foto_profil) }}" />
                            @else
                            <span class="material-symbols-outlined text-xl text-gray-400">person</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-heading font-semibold text-text-main dark:text-white">
                                    {{ $ulasan->pengguna ? $ulasan->pengguna->nama : 'Pengguna' }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 font-display">
                                    {{ $ulasan->tgl_dibuat->diffForHumans() }}
                                </span>
                            </div>
                            <div class="flex items-center mb-2">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $ulasan->rating)
                                    <span class="fa-solid fa-star text-amber-400 text-xs"></span>
                                    @else
                                    <span class="fa-regular fa-star text-gray-300 dark:text-gray-600 text-xs"></span>
                                    @endif
                                    @endfor
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-display">{{ $ulasan->komentar }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <span class="material-symbols-outlined text-5xl text-gray-300 dark:text-gray-600 mb-4">rate_review</span>
                <p class="text-gray-500 dark:text-gray-400 font-display">Belum ada ulasan untuk produk ini.</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Related Products --}}
    @if($produkTerkait->count() > 0)
    <div class="mb-16">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-heading font-bold text-text-main dark:text-white">Produk Terkait</h2>
                <p class="text-gray-500 dark:text-gray-400 font-display">Produk lain dari kategori yang sama.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($produkTerkait as $item)
            <div class="group bg-white dark:bg-[#1e2a1a] rounded-xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 dark:border-[#2a3825] transition-all duration-300 hover:-translate-y-1">
                <a href="{{ route('produk.detail', $item->slug_produk) }}" class="block relative aspect-square overflow-hidden bg-gray-100 dark:bg-[#253220]">
                    @if($item->foto)
                    <img alt="{{ $item->nama_produk }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ Storage::url($item->foto) }}" />
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-gray-400">image</span>
                    </div>
                    @endif
                </a>
                <div class="p-4">
                    @if($item->kategori)
                    <div class="text-xs text-primary font-bold uppercase tracking-wider mb-1 font-heading">{{ $item->kategori->nama_kategori }}</div>
                    @endif
                    <a href="{{ route('produk.detail', $item->slug_produk) }}">
                        <h3 class="text-lg font-heading font-bold text-text-main dark:text-white truncate transition-colors">{{ $item->nama_produk }}</h3>
                    </a>
                    <div class="flex items-baseline gap-1 mt-2">
                        <span class="text-lg font-heading font-bold text-[#53be20]">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        <span class="text-xs text-text-secondary font-display">/{{ $item->satuan }}</span>
                    </div>
                    <form action="{{ route('keranjang.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center border border-gray-200 dark:border-[#2a3825] rounded-lg bg-white dark:bg-[#253220] h-9">
                                <button type="button" onclick="adjustQty(this, -1, {{ $item->stok }})" class="px-2 text-gray-500 hover:text-primary">
                                    <span class="material-symbols-outlined text-sm">remove</span>
                                </button>
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}"
                                    class="w-10 text-center text-sm font-heading font-bold bg-transparent border-0 focus:ring-0 text-text-main dark:text-white p-0" />
                                <button type="button" onclick="adjustQty(this, 1, {{ $item->stok }})" class="px-2 text-gray-500 hover:text-primary">
                                    <span class="material-symbols-outlined text-sm">add</span>
                                </button>
                            </div>
                            <button type="submit" class="flex-1 bg-primary hover:bg-opacity-90 text-white h-9 rounded-lg transition-colors flex items-center justify-center gap-1 text-sm font-heading font-semibold">
                                <span class="material-symbols-outlined text-base">add_shopping_cart</span>
                                <span class="hidden sm:inline">Tambah</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Products from same seller --}}
    @if($produkPetani->count() > 0)
    <div class="mb-16">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-heading font-bold text-text-main dark:text-white">Produk Lain dari {{ $produk->petani->nama }}</h2>
                <p class="text-gray-500 dark:text-gray-400 font-display">Jelajahi produk lainnya dari petani yang sama.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($produkPetani as $item)
            <div class="group bg-white dark:bg-[#1e2a1a] rounded-xl overflow-hidden shadow-sm hover:shadow-lg border border-gray-100 dark:border-[#2a3825] transition-all duration-300 hover:-translate-y-1">
                <a href="{{ route('produk.detail', $item->slug_produk) }}" class="block relative aspect-square overflow-hidden bg-gray-100 dark:bg-[#253220]">
                    @if($item->foto)
                    <img alt="{{ $item->nama_produk }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ Storage::url($item->foto) }}" />
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-gray-400">image</span>
                    </div>
                    @endif
                </a>
                <div class="p-4">
                    <a href="{{ route('produk.detail', $item->slug_produk) }}">
                        <h3 class="text-lg font-heading font-bold text-text-main dark:text-white truncate transition-colors">{{ $item->nama_produk }}</h3>
                    </a>
                    <div class="flex items-baseline gap-1 mt-2">
                        <span class="text-lg font-heading font-bold text-[#53be20]">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        <span class="text-xs text-text-secondary font-display">/{{ $item->satuan }}</span>
                    </div>
                    <form action="{{ route('keranjang.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center border border-gray-200 dark:border-[#2a3825] rounded-lg bg-white dark:bg-[#253220] h-9">
                                <button type="button" onclick="adjustQty(this, -1, {{ $item->stok }})" class="px-2 text-gray-500 hover:text-primary">
                                    <span class="material-symbols-outlined text-sm">remove</span>
                                </button>
                                <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}"
                                    class="w-10 text-center text-sm font-heading font-bold bg-transparent border-0 focus:ring-0 text-text-main dark:text-white p-0" />
                                <button type="button" onclick="adjustQty(this, 1, {{ $item->stok }})" class="px-2 text-gray-500 hover:text-primary">
                                    <span class="material-symbols-outlined text-sm">add</span>
                                </button>
                            </div>
                            <button type="submit" class="flex-1 bg-primary hover:bg-opacity-90 text-white h-9 rounded-lg transition-colors flex items-center justify-center gap-1 text-sm font-heading font-semibold">
                                <span class="material-symbols-outlined text-base">add_shopping_cart</span>
                                <span class="hidden sm:inline">Tambah</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</main>

<script>
    function decreaseQty() {
        const input = document.getElementById('qty-input');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    function increaseQty() {
        const input = document.getElementById('qty-input');
        const max = parseInt(document.getElementById('btn-increase').dataset.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function showTab(tab) {
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        // Reset all tabs
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('border-primary', 'text-primary');
            el.classList.add('border-transparent', 'text-gray-500');
        });
        // Show selected content
        document.getElementById('content-' + tab).classList.remove('hidden');
        // Activate selected tab
        const activeTab = document.getElementById('tab-' + tab);
        activeTab.classList.remove('border-transparent', 'text-gray-500');
        activeTab.classList.add('border-primary', 'text-primary');
    }

    function adjustQty(btn, delta, max) {
        const container = btn.closest('.flex');
        const input = container.querySelector('input[name="jumlah"]');
        let value = parseInt(input.value) + delta;

        if (value < 1) value = 1;
        if (value > max) value = max;

        input.value = value;
    }
</script>
@endsection