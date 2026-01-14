@extends('layouts.admin')

@section('title', 'Tanami - User Management')
@section('header_title', 'User Management')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-8">

        {{-- Header Navigation --}}
        <nav class="flex items-center text-sm font-medium text-gray-500">
            <span class="text-primary font-semibold">User Management</span>
            <span class="material-symbols-outlined text-sm mx-2">chevron_right</span>
        </nav>

        {{-- Search & Filter Section (Menggunakan Form GET) --}}
        <div class="bg-white border-b border-gray-100 px-6 py-3 flex-shrink-0 z-10 rounded-2xl shadow-sm">
            <form method="GET" action="{{ route('admin.pengguna') }}" class="flex flex-col md:flex-row items-center gap-4">
                
                {{-- Search Bar --}}
                <div class="relative flex-1 w-full md:max-w-md group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    {{-- Input Name='q' sesuai controller --}}
                    <input name="q" value="{{ $currentSearch }}"
                        class="w-full pl-11 pr-4 py-2.5 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 text-sm font-sans placeholder-gray-400 text-gray-700 transition-all"
                        placeholder="Cari nama atau email..." type="text" onchange="this.form.submit()" />
                </div>

                {{-- Filter Role --}}
                <div class="flex items-center gap-4 w-full md:w-auto md:ml-auto justify-end">
                    <div class="relative w-full md:w-auto min-w-[160px]">
                        {{-- Select Name='role' sesuai controller --}}
                        <select name="role" onchange="this.form.submit()"
                            class="w-full appearance-none pl-4 pr-10 py-2.5 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:border-primary/20 focus:ring-4 focus:ring-primary/5 text-sm font-sans font-medium text-gray-700 transition-all cursor-pointer">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petani" {{ $currentRole == 'petani' ? 'selected' : '' }}>Petani</option>
                            <option value="pembeli" {{ $currentRole == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <span class="material-symbols-outlined text-sm">expand_more</span>
                        </div>
                    </div>

                    {{-- Link ke Halaman Verifikasi Petani --}}
                    <a href="{{ route('admin.pengguna.petani') }}"
                        class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border-2 border-primary/20 text-primary font-bold text-sm hover:bg-primary/5 transition-all whitespace-nowrap">
                        <span>Verifikasi Petani</span>
                        @if($counts['petani_pending'] > 0)
                            <span class="absolute -top-2 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] text-white ring-2 ring-white">
                                {{ $counts['petani_pending'] }}
                            </span>
                        @endif
                    </a>
                </div>
            </form>
        </div>

        {{-- Statistik Cards (Data dari $counts di Controller) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Card Total --}}
            <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center bg-gray-50 text-tanami-dark rounded-xl">
                        <span class="material-symbols-outlined text-2xl">groups</span>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Total Users</p>
                        <h3 class="text-2xl font-heading font-extrabold text-tanami-dark leading-none mt-1">{{ number_format($counts['total']) }}</h3>
                    </div>
                </div>
            </div>
            {{-- Card Pembeli --}}
            <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center bg-orange-50 text-orange-600 rounded-xl">
                        <span class="material-symbols-outlined text-2xl">shopping_cart</span>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Pembeli</p>
                        <h3 class="text-2xl font-heading font-extrabold text-tanami-dark leading-none mt-1">{{ number_format($counts['pembeli']) }}</h3>
                    </div>
                </div>
            </div>
            {{-- Card Petani --}}
            <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center bg-green-50 text-primary rounded-xl">
                        <span class="material-symbols-outlined text-2xl">agriculture</span>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Petani</p>
                        <h3 class="text-2xl font-heading font-extrabold text-tanami-dark leading-none mt-1">{{ number_format($counts['petani']) }}</h3>
                    </div>
                </div>
            </div>
            {{-- Card Admin --}}
            <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl">
                        <span class="material-symbols-outlined text-2xl">admin_panel_settings</span>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Admin</p>
                        <h3 class="text-2xl font-heading font-extrabold text-tanami-dark leading-none mt-1">{{ number_format($counts['admin']) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

        {{-- Tabel Utama --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider border-b border-gray-100">
                            <th class="px-6 py-4 w-16">No</th>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Tgl Daftar</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        @forelse ($penggunaList as $index => $user)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-6 py-4 text-gray-400 font-medium">
                                {{ $penggunaList->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img alt="User" class="size-9 rounded-full border border-gray-100 object-cover"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->nama_lengkap) }}&background=random" />
                                    {{-- Menggunakan nama_lengkap sesuai DB --}}
                                    <span class="font-bold text-tanami-dark">{{ $user->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                {{-- Menggunakan role_pengguna sesuai DB --}}
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide
                                    {{ $user->role_pengguna == 'admin' ? 'bg-blue-50 text-blue-600 border-blue-100' : 
                                       ($user->role_pengguna == 'petani' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-orange-50 text-orange-600 border-orange-100') }}">
                                    {{ $user->role_pengguna }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{-- Menggunakan is_verified sesuai DB --}}
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                                    {{ $user->is_verified ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $user->is_verified ? 'Verified' : 'Pending' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{-- Parsing tgl_daftar dengan Carbon --}}
                                {{ \Carbon\Carbon::parse($user->tgl_daftar)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Action: View --}}
                                    <a href="{{ route('admin.pengguna.show', $user->id_pengguna) }}"
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    
                                    {{-- Action: Delete --}}
                                    <form action="{{ route('admin.pengguna.destroy', $user->id_pengguna) }}" method="POST" 
                                          onsubmit="return confirm('Hapus pengguna {{ $user->nama_lengkap }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                Tidak ada data pengguna ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-6 border-t border-gray-50">
                {{ $penggunaList->links() }}
            </div>
        </div>
    </div>
@endsection

