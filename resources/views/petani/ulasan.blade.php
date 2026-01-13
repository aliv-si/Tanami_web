@extends('layouts.petani')

@section('title', 'Ulasan Pelanggan')

@section('content')
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-8 py-5">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold font-heading text-text-dark">Ulasan Pelanggan</h1>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <select class="text-sm font-semibold text-gray-600 bg-gray-50 border-none rounded-lg focus:ring-primary">
                    <option>Semua Rating</option>
                    <option>5 Bintang</option>
                    <option>4 Bintang</option>
                    <option>3 Bintang</option>
                    <option>2 Bintang</option>
                    <option>1 Bintang</option>
                </select>
                <select class="text-sm font-semibold text-gray-600 bg-gray-50 border-none rounded-lg focus:ring-primary">
                    <option>Urutkan: Terbaru</option>
                    <option>Urutkan: Terlama</option>
                    <option>Urutkan: Rating Tertinggi</option>
                </select>
            </div>
        </div>
    </div>
</header>

<div class="p-8 max-w-[1200px] mx-auto">
    <!-- Rating Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col items-center justify-center py-4">
                <div class="text-5xl font-bold font-heading text-text-dark">{{ number_format($ratingStats['average'], 1) }}</div>
                <div class="flex items-center gap-1 mt-3">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < floor($ratingStats['average']))
                        <span class="material-symbols-outlined text-yellow-400 fill-1 text-2xl">star</span>
                        @else
                        <span class="material-symbols-outlined text-gray-300 text-2xl">star</span>
                        @endif
                        @endfor
                </div>
                <p class="text-sm text-gray-500 mt-2">Berdasarkan {{ $ratingStats['totalReviews'] }} ulasan</p>
            </div>
            <div class="space-y-3">
                @for($star = 5; $star >= 1; $star--)
                @php
                $count = $ratingStats['distribution'][$star] ?? 0;
                $percentage = $ratingStats['totalReviews'] > 0 ? ($count / $ratingStats['totalReviews']) * 100 : 0;
                @endphp
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-600 w-12">{{ $star }} ⭐</span>
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <span class="text-sm text-gray-500 w-8 text-right">{{ $count }}</span>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Reviews List -->
    @if(count($reviews) > 0)
    <div class="space-y-4">
        @foreach($reviews as $review)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="font-heading font-bold text-primary">{{ $review['customerInitials'] }}</span>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <h4 class="font-heading font-bold text-text-dark">{{ $review['customerName'] }}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="flex">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < $review['rating'])
                                        <span class="material-symbols-outlined text-yellow-400 fill-1 text-sm">star</span>
                                        @else
                                        <span class="material-symbols-outlined text-gray-300 text-sm">star</span>
                                        @endif
                                        @endfor
                                </div>
                                <span class="text-xs text-gray-400">{{ $review['date'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mb-3 text-xs text-gray-500">
                        <span class="material-symbols-outlined text-gray-400 text-sm">{{ $review['product']['icon'] }}</span>
                        {{ $review['product']['name'] }}
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $review['comment'] }}</p>

                    @if($review['reply'])
                    <div class="mt-4 pl-4 border-l-2 border-primary/30 bg-gray-50 p-3 rounded-r-lg">
                        <p class="text-xs font-semibold text-primary mb-1">Balasan Anda:</p>
                        <p class="text-sm text-gray-600">{{ $review['reply'] }}</p>
                    </div>
                    @else
                    <button class="mt-3 text-sm text-primary font-semibold hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-lg">reply</span>
                        Balas Ulasan
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-gray-400 text-3xl">reviews</span>
        </div>
        <h3 class="font-heading font-bold text-gray-600 mb-2">Belum ada ulasan</h3>
        <p class="text-sm text-gray-400">Ulasan dari pelanggan akan muncul di sini</p>
    </div>
    @endif
</div>
@endsection