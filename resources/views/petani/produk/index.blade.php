@extends('layouts.petani')

@section('title', 'Produk Saya')

@section('content')
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="flex flex-col md:flex-row md:items-center justify-between px-8 py-4 gap-4">
        <div>
            <h1 class="text-2xl font-bold font-heading text-text-dark">Produk Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Total {{ $stats['total'] }} produk ({{ $stats['aktif'] }} aktif, {{ $stats['stok_habis'] }} stok habis)</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <form action="{{ route('petani.produk') }}" method="GET" class="flex items-center gap-3">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                    <input name="q" value="{{ $currentSearch }}" class="pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary w-64" placeholder="Cari produk..." type="text"/>
                </div>
                <div class="relative">
                    <select name="kategori" class="pl-4 pr-10 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary appearance-none cursor-pointer min-w-[140px]" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kategori)
                            <option value="{{ $kategori->id_kategori }}" {{ $currentKategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                </div>
                <div class="relative">
                    <select name="sort" class="pl-4 pr-10 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary appearance-none cursor-pointer min-w-[140px]" onchange="this.form.submit()">
                        <option value="terbaru" {{ $currentSort == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="nama" {{ $currentSort == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="harga" {{ $currentSort == 'harga' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="stok_rendah" {{ $currentSort == 'stok_rendah' ? 'selected' : '' }}>Stok Terendah</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                </div>
            </form>
            <a href="{{ route('petani.produk.tambah') }}" class="bg-primary hover:bg-primary/90 text-white px-5 py-2 rounded-lg font-bold font-heading flex items-center gap-2 transition-all shadow-sm">
                <span class="material-symbols-outlined">add</span>
                Tambah Produk
            </a>
        </div>
    </div>
</header>

<div class="p-8 max-w-[1400px] mx-auto">
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined">error</span>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($produk->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($produk as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($item->foto)
                                    <img alt="{{ $item->nama_produk }}" class="w-12 h-12 rounded-lg object-cover border border-gray-100" src="{{ asset('storage/produk/' . $item->foto) }}"/>
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-gray-400">image</span>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-heading font-semibold text-text-dark block">{{ $item->nama_produk }}</span>
                                    <span class="text-xs text-gray-400">{{ $item->satuan }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td class="px-6 py-4 font-semibold text-text-dark">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $stokTersedia = $item->stok - $item->stok_direserve;
                            @endphp
                            <span class="text-sm {{ $stokTersedia <= 0 ? 'text-red-600' : ($stokTersedia <= 10 ? 'text-yellow-600' : 'text-gray-600') }}">
                                {{ $stokTersedia }} {{ $item->satuan }}
                            </span>
                            @if($item->stok_direserve > 0)
                                <span class="text-xs text-gray-400 block">({{ $item->stok_direserve }} direserve)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($stokTersedia <= 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Stok Habis</span>
                            @elseif($item->is_aktif)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-[#53be20]/10 text-[#53be20]">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('petani.produk.edit', $item->id_produk) }}" class="p-2 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-all" title="Edit">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <form action="{{ route('petani.produk.destroy', $item->id_produk) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $produk->links() }}
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-gray-400 text-3xl">inventory_2</span>
            </div>
            <h3 class="font-heading font-bold text-gray-600 mb-2">Belum ada produk</h3>
            <p class="text-sm text-gray-400 mb-4">Mulai tambahkan produk pertama Anda</p>
            <a href="{{ route('petani.produk.tambah') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-bold font-heading transition-all">
                <span class="material-symbols-outlined">add</span>
                Tambah Produk
            </a>
        </div>
        @endif
    </div>
</div>
@endsection