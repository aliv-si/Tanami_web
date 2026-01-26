@extends('layouts.admin')

@section('title', 'Message Detail')
@section('header_title', 'Message Detail')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pesan-kontak') }}" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-50 text-gray-600 text-sm font-medium hover:bg-gray-100 transition-colors">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back
        </a>
        <form action="{{ route('admin.pesan-kontak.destroy', $pesan->id_pesan) }}" method="POST" onsubmit="return confirm('Delete this message?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-600 hover:text-white transition-all duration-200">
                <span class="material-symbols-outlined text-lg">delete</span>
                Delete Message
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <!-- Sender Info -->
        <div class="p-8 border-b border-gray-50 bg-gray-50/30">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex flex-col gap-1">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sender</span>
                    <span class="text-lg font-bold text-gray-900 font-heading">{{ $pesan->nama }}</span>
                    <span class="text-sm text-primary font-medium">{{ $pesan->email }}</span>
                </div>
                <div class="flex flex-col gap-1 md:text-right">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sent At</span>
                    <span class="text-sm font-semibold text-gray-700">{{ $pesan->created_at->format('d F Y, H:i') }}</span>
                    <span class="text-xs text-gray-500">{{ $pesan->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="p-8">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-2">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Subject</span>
                    <h2 class="text-xl font-bold text-gray-900 font-heading">{{ $pesan->subjek }}</h2>
                </div>

                <div class="flex flex-col gap-2">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Message</span>
                    <div class="p-6 rounded-xl bg-gray-50 text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $pesan->pesan }}
                    </div>
                </div>

                <div class="mt-4 pt-8 border-t border-gray-100 flex flex-col gap-4">
                    <h3 class="text-sm font-bold text-gray-900 font-heading">Follow Up</h3>
                    <div class="flex items-center gap-4">
                        <a href="mailto:{{ $pesan->email }}?subject=Re: {{ $pesan->subjek }}"
                            class="flex-1 flex items-center justify-center gap-2 h-14 bg-primary text-white rounded-xl font-bold hover:bg-green-600 transition-all shadow-md hover:shadow-lg">
                            <span class="material-symbols-outlined">reply</span>
                            Reply via Email ({{ $pesan->email }})
                        </a>
                    </div>
                    <p class="text-xs text-gray-400 text-center italic">
                        *Clicking the button above will open your email app (Outlook, Gmail, etc.).
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection