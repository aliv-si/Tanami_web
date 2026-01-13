@extends('layouts.app')

@section('title', 'Katalog | Tanami')

@section('content')
<main class="flex-1 w-full max-w-[1440px] mx-auto px-6 lg:px-10 py-8">
    {{-- Breadcrumb --}}
    <div class="flex flex-wrap gap-2 mb-6 font-display">
        <a class="text-text-secondary text-sm font-medium hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
        <span class="text-text-secondary text-sm font-medium">/</span>
        <span class="text-text-main dark:text-white text-sm font-medium">Katalog</span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-text-main dark:text-white text-3xl md:text-4xl font-bold font-heading tracking-tight mb-2">
                Produk Pertanian</h1>
            <p class="text-text-secondary dark:text-gray-400 font-display">Temukan sayuran, buah, bibit, dan tanaman hias terbaik dari petani lokal.</p>
        </div>
        <div class="flex items-center gap-3">
            <label class="hidden md:block text-sm font-medium text-text-secondary dark:text-gray-400 font-display">Urutkan:</label>
            <div class="relative">
                <select id="sort-select" onchange="this.form.submit()" form="filter-form" name="sort"
                    class="appearance-none h-10 pl-4 pr-10 rounded-lg border border-[#dfe5dc] dark:border-[#2a3825] bg-white dark:bg-[#1e2a1a] text-sm text-text-main dark:text-white focus:ring-1 focus:ring-primary focus:border-primary cursor-pointer font-display">
                    <option value="terbaru" {{ $currentSort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ $currentSort == 'termurah' ? 'selected' : '' }}>Termurah</option>
                    <option value="termahal" {{ $currentSort == 'termahal' ? 'selected' : '' }}>Termahal</option>
                    <option value="terlaris" {{ $currentSort == 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                </select>
                <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none text-lg">expand_more</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar Filters --}}
        <aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
            <form id="filter-form" method="GET" action="{{ route('katalog') }}">
                {{-- Mobile Search --}}
                <div class="block lg:hidden relative mb-4">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary material-symbols-outlined">search</span>
                    <input name="q" value="{{ $currentSearch }}" class="w-full rounded-lg bg-white border border-[#dfe5dc] py-2 pl-10 pr-4 text-sm font-display" placeholder="Cari produk..." type="text" />
                </div>

                <div class="bg-white dark:bg-[#1e2a1a] rounded-xl border border-[#dfe5dc] dark:border-[#2a3825] overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-[#dfe5dc] dark:border-[#2a3825] flex justify-between items-center">
                        <h3 class="font-bold text-text-main dark:text-white font-heading">Filter</h3>
                        <a href="{{ route('katalog') }}" class="text-xs font-medium text-primary hover:underline font-heading">Reset</a>
                    </div>

                    {{-- Search (Desktop) --}}
                    <div class="hidden lg:block p-4 border-b border-[#dfe5dc] dark:border-[#2a3825]">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary material-symbols-outlined text-lg">search</span>
                            <input name="q" value="{{ $currentSearch }}" class="w-full rounded-lg bg-gray-50 dark:bg-[#253220] border-0 py-2 pl-10 pr-4 text-sm font-display focus:ring-1 focus:ring-primary" placeholder="Cari produk..." type="text" />
                        </div>
                    </div>

                    {{-- Categories --}}
                    <details class="group border-b border-[#dfe5dc] dark:border-[#2a3825]" open>
                        <summary class="flex cursor-pointer items-center justify-between px-4 py-3 hover:bg-gray-50 dark:hover:bg-[#253220]">
                            <span class="text-sm font-bold text-text-main dark:text-white font-heading">Kategori</span>
                            <span class="material-symbols-outlined text-text-secondary transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="px-4 pb-4 pt-1 space-y-2">
                            @foreach ($kategoriList as $kat)
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input type="radio" name="kategori" value="{{ $kat->slug_kategori }}"
                                    {{ $currentKategori == $kat->slug_kategori ? 'checked' : '' }}
                                    class="rounded-full border-gray-300 text-primary focus:ring-primary w-4 h-4" />
                                <span class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">
                                    {{ $kat->nama_kategori }} ({{ $kat->produk_count }})
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </details>

                    {{-- Price Range --}}
                    <details class="group border-b border-[#dfe5dc] dark:border-[#2a3825]" open>
                        <summary class="flex cursor-pointer items-center justify-between px-4 py-3 hover:bg-gray-50 dark:hover:bg-[#253220]">
                            <span class="text-sm font-bold text-text-main dark:text-white font-heading">Rentang Harga</span>
                            <span class="material-symbols-outlined text-text-secondary transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="px-4 pb-4 pt-1">
                            <div class="flex items-center justify-between mb-4 font-display">
                                <span class="text-xs text-text-secondary dark:text-gray-400">Rp {{ number_format($hargaRange->min ?? 0, 0, ',', '.') }}</span>
                                <span class="text-xs text-text-secondary dark:text-gray-400">Rp {{ number_format($hargaRange->max ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <div class="relative w-full">
                                    <span class="absolute left-2 top-1/2 -translate-y-1/2 text-xs text-text-secondary font-display">Rp</span>
                                    <input name="min_harga" value="{{ $currentMinHarga }}"
                                        class="w-full pl-7 pr-2 py-1.5 text-sm border border-gray-200 rounded text-center focus:ring-primary focus:border-primary font-display"
                                        type="number" placeholder="Min" />
                                </div>
                                <span class="text-gray-400 self-center">-</span>
                                <div class="relative w-full">
                                    <span class="absolute left-2 top-1/2 -translate-y-1/2 text-xs text-text-secondary font-display">Rp</span>
                                    <input name="max_harga" value="{{ $currentMaxHarga }}"
                                        class="w-full pl-7 pr-2 py-1.5 text-sm border border-gray-200 rounded text-center focus:ring-primary focus:border-primary font-display"
                                        type="number" placeholder="Max" />
                                </div>
                            </div>
                        </div>
                    </details>

                    {{-- Apply Button --}}
                    <div class="p-4">
                        <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-2 px-4 rounded-lg transition-colors font-heading text-sm">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1">
            @if($produk->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">inventory_2</span>
                <h3 class="text-xl font-bold text-text-main dark:text-white font-heading mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-text-secondary dark:text-gray-400 font-display mb-4">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <a href="{{ route('katalog') }}" class="text-primary font-semibold hover:underline font-heading">Reset Filter</a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5">
                @foreach ($produk as $item)
                <a href="{{ route('produk.detail', $item->slug_produk) }}"
                    class="group relative flex flex-col bg-white dark:bg-[#1e2a1a] border border-[#dfe5dc] dark:border-[#2a3825] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden">
                        {{-- Badge for new products (created within 7 days) --}}
                        @if($item->tgl_dibuat->diffInDays(now()) <= 7)
                            <span class="absolute top-3 left-3 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-md z-10 font-heading">Baru</span>
                            @endif

                            {{-- Favorite button placeholder --}}
                            <button type="button" onclick="event.preventDefault();"
                                class="absolute top-3 right-3 p-1.5 bg-white/80 dark:bg-black/50 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 transition-colors z-10">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>

                            @if($item->foto)
                            <img alt="{{ $item->nama_produk }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="{{ Storage::url($item->foto) }}" />
                            @else
                            <div class="h-full w-full flex items-center justify-center bg-gray-200 dark:bg-[#253220]">
                                <span class="material-symbols-outlined text-5xl text-gray-400">image</span>
                            </div>
                            @endif
                    </div>
                    <div class="p-3.5 flex flex-col flex-1">
                        {{-- Rating --}}

                        {{-- Product Name --}}
                        <h3 class="text-base font-bold text-[#1e3f1b] dark:text-white mb-1 line-clamp-2 font-heading leading-tight">
                            {{ $item->nama_produk }}
                        </h3>

                        {{-- Description --}}
                        <p class="text-xs text-text-secondary dark:text-gray-400 mb-3 line-clamp-2 font-display">
                            {{ Str::limit($item->deskripsi, 80) }}
                        </p>

                        {{-- Star Rating --}}
                        <div class="flex items-center gap-1 mb-1.5">
                            @php
                            $avgRating = $item->rata_rating;
                            $fullStars = floor($avgRating);
                            $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp

                            <div class="flex items-center">
                                {{-- Full Stars --}}
                                @for ($i = 0; $i < $fullStars; $i++)
                                    <span class="fa-solid fa-star text-amber-400 text-[15px]" style="font-variation-settings: 'FILL' 1;"></span>
                                    @endfor

                                    {{-- Half Star --}}
                                    @if ($hasHalfStar)
                                    <span class="fa-solid fa-star-half-stroke text-amber-400 text-[15px]" style="font-variation-settings: 'FILL' 1;"></span>
                                    @endif

                                    {{-- Empty Stars --}}
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <span class="fa-regular fa-star text-gray-300 dark:text-gray-600 text-[15px]"></span>
                                        @endfor
                            </div>

                            {{-- Rating Number & Count --}}
                            @if($avgRating > 0)
                            <span class="text-xs font-semibold text-amber-500 ml-0.5">{{ number_format($avgRating, 1) }}</span>
                            @endif
                            <span class="text-[10px] text-text-secondary dark:text-gray-500 font-display">({{ $item->ulasan->count() }})</span>
                        </div>

                        {{-- Price & Add to Cart --}}
                        <div class="mt-auto flex items-center justify-between gap-2">
                            <div class="flex items-baseline gap-1">
                                <span class="text-lg font-bold text-[#53be20] font-display">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span class="text-xs text-text-secondary font-display">/{{ $item->satuan }}</span>
                            </div>
                            <form action="{{ route('keranjang.store') }}" method="POST" onclick="event.stopPropagation();">
                                @csrf
                                <input type="hidden" name="id_produk" value="{{ $item->id_produk }}">
                                <input type="hidden" name="jumlah" value="1">
                                <button type="submit"
                                    class="flex items-center gap-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white px-3 py-1.5 rounded-lg font-bold text-[11px] transition-all duration-300 font-heading">
                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                    Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($produk->hasPages())
            <div class="flex items-center justify-center mt-12">
                {{ $produk->links() }}
            </div>
            @endif
            @endif
        </div>
    </div>
</main>
@endsection