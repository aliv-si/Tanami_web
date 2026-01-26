@extends('layouts.admin')

@section('title', 'Tanami - Master Kupon')
@section('header_title', 'Master Kupon')

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

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="space-y-1">
            <nav class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary cursor-pointer">Dashboard</a>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span>Master Data</span>
                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                <span class="text-gray-600">Coupon</span>
            </nav>
        </div>

        <button onclick="document.getElementById('modalTambah').showModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-[#49a91b] text-white rounded-xl text-sm font-bold shadow-sm shadow-primary/20 transition-all active:scale-95">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Add Coupon
        </button>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider">
                        <th class="px-6 py-4 w-16">No</th>
                        <th class="px-6 py-4">Coupon Code</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Value</th>
                        <th class="px-6 py-4">Min. Purchase</th>
                        <th class="px-6 py-4">Expire Date</th>
                        <th class="px-6 py-4">Usage</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50">
                    @forelse($kuponList ?? [] as $index => $kupon)
                    <tr class="hover:bg-gray-50/30 transition-colors">
                        <td class="px-6 py-4 text-gray-400 font-medium">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4"><span class="font-mono font-bold text-tanami-dark uppercase tracking-wider">{{ $kupon->kode_kupon }}</span></td>
                        <td class="px-6 py-4">
                            @if($kupon->tipe_diskon === 'persen')
                            <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold bg-blue-50 text-blue-600 uppercase">Percentage</span>
                            @else
                            <span class="inline-flex px-2.5 py-1 rounded-md text-[10px] font-bold bg-purple-50 text-purple-600 uppercase">Nominal</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-700">
                            @if($kupon->tipe_diskon === 'persen')
                            {{ $kupon->persen_diskon }}%
                            @else
                            Rp {{ number_format($kupon->nominal_diskon, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">Rp {{ number_format($kupon->min_belanja, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-gray-500 text-xs">{{ \Carbon\Carbon::parse($kupon->tgl_selesai)->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="text-gray-600 font-medium">{{ $kupon->pemakaian_count ?? 0 }}x</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($kupon->is_aktif && \Carbon\Carbon::parse($kupon->tgl_selesai)->isFuture())
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 uppercase">
                                <span class="size-1.5 rounded-full bg-green-600"></span> Active
                            </span>
                            @elseif(\Carbon\Carbon::parse($kupon->tgl_selesai)->isPast())
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500 uppercase">
                                <span class="size-1.5 rounded-full bg-gray-400"></span> Expired
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 uppercase">
                                <span class="size-1.5 rounded-full bg-red-500"></span> Nonactive
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openEditModal({{ json_encode($kupon) }})" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"><span class="material-symbols-outlined text-[20px]">edit</span></button>
                                <form action="{{ route('admin.kupon.destroy', $kupon->id_kupon) }}" method="POST" onsubmit="return confirm('Hapus kupon ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"><span class="material-symbols-outlined text-[20px]">delete</span></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-gray-400">No coupon found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50/30 border-t border-gray-50 flex items-center justify-between">
            <p class="text-xs text-gray-500 font-medium">Total <span class="text-tanami-dark font-bold">{{ count($kuponList ?? []) }}</span> coupon</p>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<dialog id="modalTambah" class="rounded-2xl p-0 backdrop:bg-black/50 w-full max-w-lg">
    <form action="{{ route('admin.kupon.store') }}" method="POST" class="p-6">
        @csrf
        <h3 class="text-lg font-heading font-bold text-tanami-dark mb-4">Add Coupon</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                <input type="text" name="kode_kupon" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 uppercase" placeholder="MERDEKA45">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type Discount</label>
                <select name="tipe_diskon" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
                    <option value="persen">Percentage (%)</option>
                    <option value="nominal">Nominal (Rp)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                <input type="number" name="nilai_diskon" required min="0" step="0.01" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Min. Purchase (Rp)</label>
                <input type="number" name="min_belanja" min="0" value="0" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Limit Per User</label>
                <input type="number" name="limit_per_user" min="1" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Kosong = unlimited">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="tgl_mulai" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="tgl_selesai" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div class="col-span-2 flex items-center gap-2">
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
<dialog id="modalEdit" class="rounded-2xl p-0 backdrop:bg-black/50 w-full max-w-lg">
    <form id="formEdit" method="POST" class="p-6">
        @csrf
        @method('PUT')
        <h3 class="text-lg font-heading font-bold text-tanami-dark mb-4">Edit Coupon</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                <input type="text" name="kode_kupon" id="editKode" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 uppercase">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type Discount</label>
                <select name="tipe_diskon" id="editTipe" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
                    <option value="persen">Percentage (%)</option>
                    <option value="nominal">Nominal (Rp)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                <input type="number" name="nilai_diskon" id="editNilai" required min="0" step="0.01" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Min. Purchase (Rp)</label>
                <input type="number" name="min_belanja" id="editMinBelanja" min="0" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Limit Per User</label>
                <input type="number" name="limit_per_user" id="editLimitUser" min="1" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" name="tgl_mulai" id="editTglMulai" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" name="tgl_selesai" id="editTglSelesai" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20">
            </div>
            <div class="col-span-2 flex items-center gap-2">
                <input type="checkbox" name="is_aktif" value="1" id="editAktif" class="rounded border-gray-300 text-primary focus:ring-primary">
                <label for="editAktif" class="text-sm text-gray-700">Active</label>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" onclick="document.getElementById('modalEdit').close()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-xl font-medium">Batal</button>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-xl font-bold hover:bg-opacity-90">Update</button>
        </div>
    </form>
</dialog>

<script>
    function openEditModal(kupon) {
        document.getElementById('formEdit').action = '{{ url("admin/kupon") }}/' + kupon.id_kupon;
        document.getElementById('editKode').value = kupon.kode_kupon;
        document.getElementById('editTipe').value = kupon.tipe_diskon;
        document.getElementById('editNilai').value = kupon.tipe_diskon === 'persen' ? kupon.persen_diskon : kupon.nominal_diskon;
        document.getElementById('editMinBelanja').value = kupon.min_belanja;
        document.getElementById('editLimitUser').value = kupon.limit_per_user || '';
        document.getElementById('editTglMulai').value = kupon.tgl_mulai.split('T')[0];
        document.getElementById('editTglSelesai').value = kupon.tgl_selesai.split('T')[0];
        document.getElementById('editAktif').checked = kupon.is_aktif;
        document.getElementById('modalEdit').showModal();
    }
</script>
@endsection