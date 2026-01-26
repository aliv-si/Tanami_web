@extends('layouts.admin')

@section('title', 'Tanami - Master Kota & Ongkir')
@section('header_title', 'Master Kota & Ongkir')

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

    {{-- Toolbar: Navigasi, Search Lokal, Tombol Aksi --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="space-y-1">
            <nav class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary cursor-pointer">Dashboard</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span>Master Data</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-gray-600">City</span>
            </nav>
        </div>

        <button onclick="document.getElementById('modalTambah').showModal()" class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-xl font-heading font-bold text-sm transition-all shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            Add City
        </button>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider">
                        <th class="px-8 py-5 border-b border-gray-100 w-20">No</th>
                        <th class="px-6 py-5 border-b border-gray-100">City Name</th>
                        <th class="px-6 py-5 border-b border-gray-100">Province</th>
                        <th class="px-6 py-5 border-b border-gray-100">Shipping Cost</th>
                        <th class="px-6 py-5 border-b border-gray-100">Status</th>
                        <th class="px-8 py-5 border-b border-gray-100 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50">
                    @forelse($kotaList ?? [] as $index => $kota)
                    <tr class="hover:bg-gray-50/30 transition-colors">
                        <td class="px-8 py-5 text-gray-400 font-medium">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-5"><span class="font-bold text-tanami-dark block">{{ $kota->nama_kota }}</span></td>
                        <td class="px-6 py-5 text-gray-600 font-medium">{{ $kota->provinsi ?? '-' }}</td>
                        <td class="px-6 py-5 text-gray-700 font-semibold font-mono">Rp {{ number_format($kota->ongkir, 0, ',', '.') }}</td>
                        <td class="px-6 py-5">
                            @if($kota->is_aktif)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-green-50 text-green-700 uppercase tracking-wide">Aktif</span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-500 uppercase tracking-wide">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button onclick="openEditModal({{ $kota->id_kota }}, '{{ $kota->nama_kota }}', '{{ $kota->provinsi ?? '' }}', {{ $kota->ongkir }}, {{ $kota->is_aktif ? 'true' : 'false' }})" class="size-8 flex items-center justify-center rounded-lg text-amber-500 hover:bg-amber-50 transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">edit_square</span>
                                </button>
                                <form action="{{ route('admin.kota.destroy', $kota->id_kota) }}" method="POST" onsubmit="return confirm('Hapus kota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="size-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">No city found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-8 py-5 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total {{ count($kotaList ?? []) }} City</p>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<dialog id="modalTambah" class="rounded-2xl p-0 backdrop:bg-black/50 w-full max-w-md">
    <form action="{{ route('admin.kota.store') }}" method="POST" class="p-6">
        @csrf
        <h3 class="text-lg font-heading font-bold text-tanami-dark mb-4">Add City</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City Name</label>
                <input type="text" name="nama_kota" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Province</label>
                <input type="text" name="provinsi" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Cost (Rp)</label>
                <input type="number" name="ongkir" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_aktif" value="1" checked id="is_aktif_tambah" class="rounded border-gray-300 text-primary focus:ring-primary">
                <label for="is_aktif_tambah" class="text-sm text-gray-700">Active</label>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="document.getElementById('modalTambah').close()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-xl font-medium">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-bold hover:bg-opacity-90">Save</button>
        </div>
    </form>
</dialog>

{{-- Modal Edit --}}
<dialog id="modalEdit" class="rounded-2xl p-0 backdrop:bg-black/50 w-full max-w-md">
    <form id="formEdit" method="POST" class="p-6">
        @csrf
        @method('PUT')
        <h3 class="text-lg font-heading font-bold text-tanami-dark mb-4">Edit City</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City Name</label>
                <input type="text" name="nama_kota" id="editNama" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Province</label>
                <input type="text" name="provinsi" id="editProvinsi" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Cost (Rp)</label>
                <input type="number" name="ongkir" id="editOngkir" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_aktif" value="1" id="editAktif" class="rounded border-gray-300 text-primary focus:ring-primary">
                <label for="editAktif" class="text-sm text-gray-700">Active</label>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="document.getElementById('modalEdit').close()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-xl font-medium">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-bold hover:bg-opacity-90">Update</button>
        </div>
    </form>
</dialog>

<script>
    function openEditModal(id, nama, provinsi, ongkir, aktif) {
        document.getElementById('formEdit').action = '{{ url("admin/kota") }}/' + id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editProvinsi').value = provinsi;
        document.getElementById('editOngkir').value = ongkir;
        document.getElementById('editAktif').checked = aktif;
        document.getElementById('modalEdit').showModal();
    }
</script>
@endsection