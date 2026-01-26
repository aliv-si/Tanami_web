@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('header_title', 'Contact Messages')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6">

    @if(session('success'))
    <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm font-medium flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Sender</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pesan as $p)
                <tr class="hover:bg-gray-50/50 transition-colors {{ !$p->is_read ? 'bg-blue-50/30' : '' }}">
                    <td class="px-6 py-4">
                        @if(!$p->is_read)
                        <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider w-fit">
                            <span class="size-1.5 rounded-full bg-blue-600 animate-pulse"></span>
                            New
                        </span>
                        @else
                        <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-500 text-[10px] font-bold uppercase tracking-wider w-fit">
                            Read
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-gray-900 font-heading">{{ $p->nama }}</span>
                            <span class="text-xs text-gray-500">{{ $p->email }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-700">{{ $p->subjek }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs text-gray-500">{{ $p->created_at->format('d M Y, H:i') }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('admin.pesan-kontak.show', $p->id_pesan) }}"
                                class="size-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-primary hover:text-white transition-all duration-200">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                            <form action="{{ route('admin.pesan-kontak.destroy', $p->id_pesan) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="size-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all duration-200">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <span class="material-symbols-outlined text-5xl text-gray-200">mail</span>
                            <p class="text-gray-400 font-medium">No messages yet</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection