@extends('layouts.petani')

@section('title', 'Dashboard')

@section('content')
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-8 py-4">
        <h1 class="text-2xl font-bold font-heading text-text-dark">Dashboard Petani</h1>
        <div class="flex items-center gap-6">
            <div class="relative hidden lg:block">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input class="pl-10 pr-4 py-2 bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary w-64" placeholder="Cari pesanan, produk..." type="text" />
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-full">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <button class="p-2 text-gray-500 hover:bg-gray-100 rounded-full">
                    <span class="material-symbols-outlined">settings</span>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="p-8 max-w-[1400px] mx-auto">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-primary/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary">potted_plant</span>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">{{ $stats['productGrowth'] }}</span>
            </div>
            <p class="text-gray-500 text-sm font-sans">Total Produk</p>
            <h3 class="text-2xl font-bold font-heading mt-1">{{ $stats['totalProducts'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600">conveyor_belt</span>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">Aktif</span>
            </div>
            <p class="text-gray-500 text-sm font-sans">Pesanan Aktif</p>
            <h3 class="text-2xl font-bold font-heading mt-1">{{ $stats['activeOrders'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <span class="material-symbols-outlined text-orange-600">trending_up</span>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded">{{ $stats['salesGrowth'] }}</span>
            </div>
            <p class="text-gray-500 text-sm font-sans">Total Penjualan</p>
            <h3 class="text-2xl font-bold font-heading mt-1">Rp {{ number_format($stats['totalSales'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <span class="material-symbols-outlined text-purple-600">account_balance_wallet</span>
                </div>
            </div>
            <p class="text-gray-500 text-sm font-sans">Saldo Tersedia</p>
            <h3 class="text-2xl font-bold font-heading mt-1">Rp {{ number_format($stats['availableBalance'], 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-lg font-bold font-heading">Pesanan Terbaru</h2>
                <a href="{{ url('/pesanan') }}" class="text-primary text-sm font-semibold font-heading hover:underline">Lihat Semua</a>
            </div>
            @if(count($recentOrders) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th class="px-6 py-4 font-heading font-semibold text-sm text-gray-600">ID Pesanan</th>
                            <th class="px-6 py-4 font-heading font-semibold text-sm text-gray-600">Produk</th>
                            <th class="px-6 py-4 font-heading font-semibold text-sm text-gray-600">Total</th>
                            <th class="px-6 py-4 font-heading font-semibold text-sm text-gray-600">Status</th>
                            <th class="px-6 py-4 font-heading font-semibold text-sm text-gray-600">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-sans text-sm font-medium">#{{ $order['id'] }}</td>
                            <td class="px-6 py-4 font-sans text-sm">{{ $order['product'] }}</td>
                            <td class="px-6 py-4 font-sans text-sm">Rp {{ number_format($order['amount'], 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $order['status'] }}</span>
                            </td>
                            <td class="px-6 py-4 font-sans text-sm text-gray-500">{{ $order['date'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-gray-400 text-3xl">shopping_cart</span>
                </div>
                <h3 class="font-heading font-bold text-gray-600 mb-2">Belum ada pesanan</h3>
                <p class="text-sm text-gray-400">Pesanan baru akan muncul di sini</p>
            </div>
            @endif
        </div>

        <!-- Merchant Rating -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-heading font-bold text-gray-800 mb-4">Rating Toko</h3>
                <div class="flex flex-col items-center py-2">
                    <div class="text-4xl font-bold font-heading text-text-dark">{{ $rating['score'] }}</div>
                    <div class="flex gap-1 mt-2 mb-2">
                        @for($i = 0; $i < 5; $i++)
                            <span class="material-symbols-outlined text-yellow-400 fill-1">star</span>
                            @endfor
                    </div>
                    <p class="text-sm text-gray-500 font-sans">Berdasarkan {{ $rating['totalReviews'] }} ulasan</p>
                </div>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium">Kualitas Produk</span>
                        <div class="w-32 bg-gray-100 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-primary h-full" style="width: {{ $rating['productQuality'] }}%"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium">Kecepatan Pengiriman</span>
                        <div class="w-32 bg-gray-100 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-primary h-full" style="width: {{ $rating['deliverySpeed'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="font-heading font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ url('/produk/tambah') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-all">
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">add_circle</span>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-text-dark">Tambah Produk</p>
                            <p class="text-xs text-gray-400">Tambahkan produk baru ke toko</p>
                        </div>
                    </a>
                    <a href="{{ url('/pesanan') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-all">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600">shopping_cart</span>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-text-dark">Kelola Pesanan</p>
                            <p class="text-xs text-gray-400">Lihat dan proses pesanan</p>
                        </div>
                    </a>
                    <a href="{{ url('/rekening') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-all">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-purple-600">account_balance</span>
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-text-dark">Rekening Bank</p>
                            <p class="text-xs text-gray-400">Kelola rekening pencairan</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection