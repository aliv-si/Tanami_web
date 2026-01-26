@extends('layouts.app')

@section('title', 'Pesanan | Tanami')

@section('content')
<main class="flex-1 py-10">
    <div class="container mx-auto px-4 md:px-10 max-w-[1000px]">
        <div class="mb-10">
            <h1 class="text-3xl md:text-[48px] font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight mb-2">
                My Orders</h1>
            <p class="text-gray-500 dark:text-gray-400 font-sans text-lg">Track and manage your purchases</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-8 border-b border-gray-200 dark:border-gray-700 mb-8 overflow-x-auto scrollbar-hide">
            <a href="{{ route('pesanan') }}"
                class="pb-4 border-b-2 {{ !request('status') ? 'border-[#53be20] text-[#53be20]' : 'border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white' }} font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                All Orders
            </a>
            <a href="{{ route('pesanan', ['status' => 'pending']) }}"
                class="pb-4 border-b-2 {{ request('status') === 'pending' ? 'border-[#53be20] text-[#53be20]' : 'border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white' }} font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                Pending
            </a>
            <a href="{{ route('pesanan', ['status' => 'diproses']) }}"
                class="pb-4 border-b-2 {{ request('status') === 'diproses' ? 'border-[#53be20] text-[#53be20]' : 'border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white' }} font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                Processing
            </a>
            <a href="{{ route('pesanan', ['status' => 'dikirim']) }}"
                class="pb-4 border-b-2 {{ in_array(request('status'), ['dikirim', 'terkirim']) ? 'border-[#53be20] text-[#53be20]' : 'border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white' }} font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                Shipped
            </a>
            <a href="{{ route('pesanan', ['status' => 'selesai']) }}"
                class="pb-4 border-b-2 {{ request('status') === 'selesai' ? 'border-[#53be20] text-[#53be20]' : 'border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white' }} font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                Completed
            </a>
            <a href="{{ route('pesanan', ['status' => 'direfund']) }}"
                class="pb-4 border-b-2 {{ in_array(request('status'), ['direfund', 'minta_refund']) ? 'border-[#53be20] text-[#53be20]' : 'border-transparent hover:border-gray-300 dark:hover:border-gray-600 text-gray-500 dark:text-gray-400 hover:text-[#1e3f1b] dark:hover:text-white' }} font-heading font-semibold text-[14px] whitespace-nowrap transition-colors">
                Refunded
            </a>
        </div>

        <!-- Orders List -->
        <div class="space-y-6">
            @forelse($pesanan as $order)
            <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5 transition-all hover:shadow-md">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div class="flex items-center gap-4">
                        <span class="font-heading font-bold text-[#1e3f1b] dark:text-white">#TNM-{{ str_pad($order->id_pesanan, 5, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 font-sans">{{ $order->tgl_dibuat->format('d M Y') }}</span>
                    </div>
                    @php
                    $statusColors = [
                    'pending' => 'bg-yellow-500',
                    'menunggu_verifikasi' => 'bg-orange-500',
                    'dibayar' => 'bg-blue-500',
                    'diproses' => 'bg-cyan-500',
                    'dikirim' => 'bg-purple-500',
                    'terkirim' => 'bg-[#53be20]',
                    'selesai' => 'bg-[#1e3f1b]',
                    'dibatalkan' => 'bg-red-500',
                    'minta_refund' => 'bg-orange-600',
                    'direfund' => 'bg-gray-500',
                    ];
                    $statusLabels = [
                    'pending' => 'Pending',
                    'menunggu_verifikasi' => 'Waiting Verification',
                    'dibayar' => 'Paid',
                    'diproses' => 'Processing',
                    'dikirim' => 'Shipped',
                    'terkirim' => 'Delivered',
                    'selesai' => 'Completed',
                    'dibatalkan' => 'Cancelled',
                    'minta_refund' => 'Refund Requested',
                    'direfund' => 'Refunded',
                    ];
                    @endphp
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $statusColors[$order->status_pesanan] ?? 'bg-gray-500' }} text-white">
                        {{ $statusLabels[$order->status_pesanan] ?? $order->status_pesanan }}
                    </span>
                </div>

                <!-- Order Items -->
                @foreach($order->items->take(2) as $item)
                <div class="flex gap-4 md:gap-6 items-start {{ !$loop->last ? 'border-b border-gray-100 dark:border-white/10 pb-4 mb-4' : 'border-b border-gray-100 dark:border-white/10 pb-6 mb-6' }}">
                    <div class="size-20 md:size-24 bg-[#f7f7f7] dark:bg-white/5 rounded-lg flex items-center justify-center shrink-0 border border-gray-50 dark:border-white/5 overflow-hidden">
                        @if($item->produk->foto)
                        <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover">
                        @else
                        <span class="material-symbols-outlined text-3xl text-primary">inventory_2</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-1">{{ $item->produk->nama_produk }}</h3>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-sm text-gray-500 dark:text-gray-400 font-sans mb-1">
                            <span>Qty: {{ $item->jumlah }}</span>
                            <span class="hidden sm:inline">•</span>
                            <span class="text-[#1e3f1b] dark:text-gray-300">Farmer: <span class="font-medium">{{ $item->produk->petani->nama_lengkap ?? 'N/A' }}</span></span>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Rp {{ number_format((float)$item->harga_snapshot, 0, ',', '.') }} x {{ $item->jumlah }}
                        </div>
                    </div>
                </div>
                @endforeach

                @if($order->items->count() > 2)
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 -mt-2">+ {{ $order->items->count() - 2 }} more item(s)</p>
                @endif

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <!-- View Details Button -->
                        <a href="{{ route('pesanan.detail', $order->id_pesanan) }}"
                            class="w-full sm:w-auto px-6 py-2.5 rounded-lg border border-[#1e3f1b] dark:border-white text-[#1e3f1b] dark:text-white font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors text-center">
                            View Details
                        </a>

                        <!-- Action Buttons Based on Status -->
                        @if($order->status_pesanan === 'pending')
                        <!-- Upload Bukti Bayar -->
                        <button type="button" onclick="document.getElementById('upload-bukti-{{ $order->id_pesanan }}').classList.remove('hidden')"
                            class="w-full sm:w-auto px-6 py-2.5 rounded-lg bg-[#53be20] text-white font-heading font-semibold text-sm hover:bg-[#45a01b] transition-colors shadow-lg shadow-[#53be20]/20">
                            Upload Payment
                        </button>
                        @elseif($order->status_pesanan === 'terkirim')
                        <!-- Confirm Receipt -->
                        <form action="{{ route('pesanan.konfirmasi', $order->id_pesanan) }}" method="POST" class="w-full sm:w-auto">
                            @csrf
                            <button type="submit"
                                class="w-full px-6 py-2.5 rounded-lg bg-[#53be20] text-white font-heading font-semibold text-sm hover:bg-[#45a01b] transition-colors shadow-lg shadow-[#53be20]/20">
                                Confirm Receipt
                            </button>
                        </form>
                        @elseif($order->status_pesanan === 'selesai' && !$order->ulasan)
                        <!-- Buy Again / Review -->
                        <a href="{{ route('katalog') }}"
                            class="flex-1 sm:flex-none px-6 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors text-center">
                            Buy Again
                        </a>
                        @endif

                        <!-- Cancel Button (for pending/waiting verification) -->
                        @if(in_array($order->status_pesanan, ['pending', 'menunggu_verifikasi']))
                        <button type="button" onclick="document.getElementById('batal-{{ $order->id_pesanan }}').classList.remove('hidden')"
                            class="w-full sm:w-auto px-6 py-2.5 rounded-lg border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 font-heading font-semibold text-sm hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            Cancel
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Modal -->
            @if($order->status_pesanan === 'pending')
            <div id="upload-bukti-{{ $order->id_pesanan }}" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="this.closest('[role=dialog]').classList.add('hidden')"></div>
                    <div class="inline-block align-bottom bg-white dark:bg-[#1f2b1b] rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                        <form action="{{ route('pesanan.upload-bukti', $order->id_pesanan) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5">
                                <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white">Upload Payment Proof</h3>
                            </div>
                            <div class="p-6">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Order: #TNM-{{ str_pad($order->id_pesanan, 5, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-lg font-bold text-[#1e3f1b] dark:text-white mb-4">Total: Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</p>
                                <input type="file" name="bukti_bayar" accept="image/jpeg,image/png" required
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1f2b1b] text-sm">
                                <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Max: 2MB</p>
                            </div>
                            <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5 flex justify-end gap-3">
                                <button type="button" onclick="this.closest('[role=dialog]').classList.add('hidden')"
                                    class="px-5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg text-[#1e3f1b] dark:text-white font-semibold text-sm">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-[#53be20] text-white rounded-lg font-semibold text-sm hover:bg-[#45a01b]">
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Cancel Modal -->
            @if(in_array($order->status_pesanan, ['pending', 'menunggu_verifikasi']))
            <div id="batal-{{ $order->id_pesanan }}" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="this.closest('[role=dialog]').classList.add('hidden')"></div>
                    <div class="inline-block align-bottom bg-white dark:bg-[#1f2b1b] rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                        <form action="{{ route('pesanan.batal', $order->id_pesanan) }}" method="POST">
                            @csrf
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5">
                                <h3 class="font-heading font-bold text-lg text-red-600">Cancel Order</h3>
                            </div>
                            <div class="p-6">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Are you sure you want to cancel order #TNM-{{ str_pad($order->id_pesanan, 5, '0', STR_PAD_LEFT) }}?</p>
                                <textarea name="alasan_batal" rows="3" required placeholder="Reason for cancellation..."
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1f2b1b] text-sm resize-none"></textarea>
                            </div>
                            <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5 flex justify-end gap-3">
                                <button type="button" onclick="this.closest('[role=dialog]').classList.add('hidden')"
                                    class="px-5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg text-[#1e3f1b] dark:text-white font-semibold text-sm">
                                    Keep Order
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-red-600 text-white rounded-lg font-semibold text-sm hover:bg-red-700">
                                    Cancel Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @empty
            <!-- Empty State -->
            <div class="text-center py-16">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">shopping_bag</span>
                <h3 class="font-heading font-bold text-xl text-[#1e3f1b] dark:text-white mb-2">No orders yet</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Start shopping to see your orders here</p>
                <a href="{{ route('katalog') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#53be20] text-white rounded-lg font-heading font-semibold hover:bg-[#45a01b] transition-colors">
                    <span class="material-symbols-outlined">storefront</span>
                    Browse Products
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($pesanan->hasPages())
        <div class="mt-8">
            {{ $pesanan->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</main>


@endsection