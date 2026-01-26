@extends('layouts.admin')

@php $active = 'pengguna'; @endphp

@section('title', 'Tanami - Verifikasi Petani')
@section('header_title', 'Verifikasi Petani')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-8">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <a href="{{ route('admin.pengguna') }}" class="hover:text-primary transition-colors">User Management</a>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <span class="text-primary">Verify Farmer</span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-heading font-bold text-[#1e3f1b]">Verify Farmer</h1>
            <p class="text-gray-500 text-sm mt-1">List of farmers waiting for account verification</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            {{-- Back to User Management --}}
            <a href="{{ route('admin.pengguna') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-700 font-medium text-sm hover:bg-gray-200 transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <span class="material-symbols-outlined text-green-600">check_circle</span>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <span class="material-symbols-outlined text-red-600">error</span>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs text-gray-500 font-bold uppercase border-b border-gray-200 font-heading tracking-wider">
                        <th class="py-4 pl-6 pr-4 w-12">No</th>
                        <th class="py-4 px-4">Farmer</th>
                        <th class="py-4 px-4">Email</th>
                        <th class="py-4 px-4">Phone Number</th>
                        <th class="py-4 px-4">Address</th>
                        <th class="py-4 px-4">Register Date</th>
                        <th class="py-4 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-sans divide-y divide-gray-100">
                    @forelse ($petaniList as $index => $petani)
                    <tr class="group hover:bg-gray-50 transition-colors">
                        <td class="py-4 pl-6 pr-4 text-gray-400 font-medium">
                            {{ $petaniList->firstItem() + $index }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <img alt="Farmer"
                                    class="size-10 rounded-full object-cover ring-2 ring-gray-100"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($petani->nama_lengkap) }}&background=random" />
                                <div>
                                    <div class="font-bold text-[#1e3f1b]">{{ $petani->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-400">ID: #{{ $petani->id_pengguna }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-gray-600">{{ $petani->email }}</td>
                        <td class="py-4 px-4 text-gray-600">{{ $petani->no_hp ?? '-' }}</td>
                        <td class="py-4 px-4 text-gray-600 max-w-[200px] truncate">{{ $petani->alamat ?? '-' }}</td>
                        <td class="py-4 px-4 text-gray-600">
                            {{ \Carbon\Carbon::parse($petani->tgl_daftar)->format('d M Y') }}
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center justify-center gap-2">
                                {{-- View Details --}}
                                <a href="{{ route('admin.pengguna.show', $petani->id_pengguna) }}"
                                    class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                    title="Lihat Detail">
                                    <span class="material-symbols-outlined text-[20px]">visibility</span>
                                </a>

                                {{-- Verify Button --}}
                                <form action="{{ route('admin.pengguna.verify', $petani->id_pengguna) }}" method="POST"
                                    onsubmit="return confirm('Verifikasi akun petani {{ $petani->nama_lengkap }}?');">
                                    @csrf
                                    <button type="submit"
                                        class="p-1.5 text-gray-400 hover:text-primary hover:bg-green-50 rounded transition-colors"
                                        title="Verifikasi">
                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                    </button>
                                </form>

                                <div class="w-[1px] h-4 bg-gray-200 mx-1"></div>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.pengguna.destroy', $petani->id_pengguna) }}" method="POST"
                                    onsubmit="return confirm('Hapus akun petani {{ $petani->nama_lengkap }}? Aksi ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                        title="Hapus">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="size-16 rounded-full bg-green-50 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-3xl text-primary">verified</span>
                                </div>
                                <div>
                                    <p class="text-gray-700 font-semibold">All farmers have been verified!</p>
                                    <p class="text-gray-500 text-sm mt-1">There are no farmer accounts waiting for verification.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($petaniList->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $petaniList->links() }}
        </div>
        @endif
    </div>
</div>
@endsection