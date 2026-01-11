@extends('layouts.petani')

@section('title', $isEdit ? 'Edit Produk' : 'Tambah Produk')

@push('styles')
<style type="text/tailwindcss">
    label { @apply font-heading font-semibold text-sm text-text-dark mb-1.5 block; }
</style>
@endpush

@section('content')
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-8 py-4">
        <div class="flex items-center gap-4">
            <a href="{{ url('/produk') }}" class="p-2 hover:bg-gray-100 rounded-full transition-all text-gray-500">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold font-heading text-text-dark">{{ $isEdit ? 'Edit Produk' : 'Tambah Produk Baru' }}</h1>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ url('/produk') }}" class="px-6 py-2.5 border border-gray-200 rounded-lg font-bold font-heading text-gray-600 hover:bg-gray-50 transition-all">
                Batal
            </a>
            <button type="submit" form="product-form" class="bg-primary hover:bg-primary/90 text-white px-8 py-2.5 rounded-lg font-bold font-heading transition-all shadow-md">
                Simpan Produk
            </button>
        </div>
    </div>
</header>

<div class="p-8 max-w-4xl mx-auto">
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <div class="flex items-center gap-2 mb-2">
                <span class="material-symbols-outlined">error</span>
                <span class="font-bold">Terjadi kesalahan:</span>
            </div>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="product-form" action="{{ $isEdit ? url('/produk/' . $produk->id_produk) : url('/produk') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <section class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="text-lg font-bold text-text-dark">Informasi Produk</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label for="nama_produk">Nama Produk <span class="text-red-500">*</span></label>
                        <input class="form-input @error('nama_produk') border-red-500 @enderror" id="nama_produk" name="nama_produk" placeholder="Contoh: Tomat Organik Segar" type="text" value="{{ old('nama_produk', $produk->nama_produk ?? '') }}" required/>
                    </div>
                    <div>
                        <label for="id_kategori">Kategori <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select class="form-input appearance-none @error('id_kategori') border-red-500 @enderror" id="id_kategori" name="id_kategori" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoriList as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $produk->id_kategori ?? '') == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                        </div>
                    </div>
                    <div>
                        <label for="satuan">Satuan <span class="text-red-500">*</span></label>
                        <input class="form-input @error('satuan') border-red-500 @enderror" id="satuan" name="satuan" placeholder="Contoh: kg, pcs, ikat" type="text" value="{{ old('satuan', $produk->satuan ?? '') }}" required/>
                    </div>
                    <div>
                        <label for="harga">Harga (Rp) <span class="text-red-500">*</span></label>
                        <input class="form-input @error('harga') border-red-500 @enderror" id="harga" name="harga" placeholder="0" step="100" type="number" value="{{ old('harga', $produk->harga ?? '') }}" required/>
                    </div>
                    <div>
                        <label for="stok">Stok <span class="text-red-500">*</span></label>
                        <input class="form-input @error('stok') border-red-500 @enderror" id="stok" name="stok" placeholder="0" type="number" value="{{ old('stok', $produk->stok ?? '') }}" required/>
                        @if($isEdit && $produk->stok_direserve > 0)
                            <p class="text-xs text-yellow-600 mt-1">{{ $produk->stok_direserve }} stok sedang direserve untuk pesanan aktif</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="text-lg font-bold text-text-dark">Foto Produk</h2>
            </div>
            <div class="p-6">
                @if($isEdit && $produk->foto)
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-2">Foto saat ini:</p>
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/produk/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200"/>
                            <label class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 cursor-pointer hover:bg-red-600">
                                <input type="checkbox" name="hapus_foto" value="1" class="hidden" onchange="this.parentElement.classList.toggle('bg-green-500'); this.parentElement.classList.toggle('bg-red-500')"/>
                                <span class="material-symbols-outlined text-sm">close</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Klik × untuk menghapus foto</p>
                    </div>
                @endif
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 flex flex-col items-center justify-center text-center hover:border-primary transition-all cursor-pointer bg-gray-50/50">
                    <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">upload_file</span>
                    </div>
                    <p class="text-sm font-bold font-heading text-text-dark">Seret dan lepas gambar di sini</p>
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, atau JPEG maksimal 5MB</p>
                    <label class="mt-4 text-primary font-bold text-sm hover:underline cursor-pointer">
                        Atau pilih file
                        <input type="file" name="foto" class="hidden" accept="image/jpeg,image/png,image/jpg"/>
                    </label>
                </div>
            </div>
        </section>

        <section class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="text-lg font-bold text-text-dark">Deskripsi</h2>
            </div>
            <div class="p-6">
                <label for="deskripsi">Deskripsi Produk</label>
                <textarea class="form-input resize-none" id="deskripsi" name="deskripsi" placeholder="Jelaskan detail produk Anda, seperti kualitas, asal usul, cara penyimpanan, dll..." rows="6">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
            </div>
        </section>

        <section class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <h2 class="text-lg font-bold text-text-dark">Pengaturan</h2>
            </div>
            <div class="p-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', $produk->is_aktif ?? true) ? 'checked' : '' }} class="w-5 h-5 rounded text-primary focus:ring-primary"/>
                    <span class="font-heading font-semibold">Aktifkan produk</span>
                </label>
                <p class="text-xs text-gray-400 mt-1 ml-8">Produk yang aktif akan ditampilkan di halaman marketplace</p>
            </div>
        </section>

        <div class="flex flex-col gap-3 md:hidden">
            <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white py-3 rounded-lg font-bold font-heading transition-all shadow-md">
                Simpan Produk
            </button>
            <a href="{{ url('/produk') }}" class="w-full text-center px-6 py-3 border border-gray-200 rounded-lg font-bold font-heading text-gray-600 hover:bg-gray-50 transition-all">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection