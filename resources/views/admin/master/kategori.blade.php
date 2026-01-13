@extends('layouts.admin')

@section('title', 'Tanami - Master Kategori')

{{-- MAGIC: Mengganti Search Bar di Header Layout menjadi Judul --}}
@section('header_title', 'Master Kategori')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-green-500">check_circle</span>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
        <span class="material-symbols-outlined text-red-500">error</span>
        {{ session('error') }}
    </div>
    @endif

    {{-- Navigasi & Tombol Aksi (Dipindah ke Body) --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <nav class="flex text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary cursor-pointer">Dashboard</a>
            <span class="mx-2 text-gray-300">/</span>
            <span class="hover:text-primary cursor-pointer">Master Data</span>
            <span class="mx-2 text-gray-300">/</span>
            <span class="text-gray-600">Kategori</span>
        </nav>

        {{-- Tombol Tambah --}}
        <button onclick="document.getElementById('modalTambah').showModal()" class="bg-primary hover:bg-opacity-90 text-white px-5 py-2.5 rounded-xl font-heading font-bold text-sm flex items-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-95">
            <span class="material-symbols-outlined text-sm">add</span>
            Tambah Kategori
        </button>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-widest border-b border-gray-50">
                        <th class="px-6 py-5 w-16">No</th>
                        <th class="px-6 py-5">Nama Kategori</th>
                        <th class="px-6 py-5">Slug</th>
                        <th class="px-6 py-5">Jumlah Produk</th>
                        <th class="px-6 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50">
                    @forelse($kategoriList ?? [] as $index => $kategori)
                    <tr class="hover:bg-gray-50/40 transition-colors group">
                        <td class="px-6 py-6 text-gray-400 font-medium">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-green-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform shadow-md">
                                    <span class="material-symbols-outlined text-xl">eco</span>
                                </div>
                                <span class="font-bold text-tanami-dark">{{ $kategori->nama_kategori }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <code class="px-2 py-1 bg-gray-50 text-gray-500 rounded text-xs font-medium">{{ $kategori->slug_kategori }}</code>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-tanami-dark">{{ $kategori->produk_count ?? 0 }}</span>
                                <span class="text-gray-400 text-xs">({{ $kategori->produk_aktif_count ?? 0 }} aktif)</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openEditModal({{ $kategori->id_kategori }}, '{{ $kategori->nama_kategori }}', '{{ $kategori->deskripsi ?? '' }}')" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </button>
                                <form action="{{ route('admin.kategori.destroy', $kategori->id_kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-50 flex items-center justify-between">
            <p class="text-xs text-gray-500 font-medium">Total <span class="text-tanami-dark font-bold">{{ count($kategoriList ?? []) }}</span> kategori</p>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<dialog id="modalTambah" class="rounded-2xl p-0 backdrop:bg-black/50 w-full max-w-md">
    <form action="{{ route('admin.kategori.store') }}" method="POST" class="p-6">
        @csrf
        <h3 class="text-lg font-heading font-bold text-tanami-dark mb-4">Tambah Kategori</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20"></textarea>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="document.getElementById('modalTambah').close()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-xl font-medium">Batal</button>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-bold hover:bg-opacity-90">Simpan</button>
        </div>
    </form>
</dialog>

{{-- Modal Edit --}}
<dialog id="modalEdit" class="rounded-2xl p-0 backdrop:bg-black/50 w-full max-w-md">
    <form id="formEdit" method="POST" class="p-6">
        @csrf
        @method('PUT')
        <h3 class="text-lg font-heading font-bold text-tanami-dark mb-4">Edit Kategori</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="editNama" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" id="editDeskripsi" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20"></textarea>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="document.getElementById('modalEdit').close()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-xl font-medium">Batal</button>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-bold hover:bg-opacity-90">Update</button>
        </div>
    </form>
</dialog>

<script>
    function openEditModal(id, nama, deskripsi) {
        document.getElementById('formEdit').action = '{{ url("admin/kategori") }}/' + id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editDeskripsi').value = deskripsi;
        document.getElementById('modalEdit').showModal();
    }
</script>
@endsection