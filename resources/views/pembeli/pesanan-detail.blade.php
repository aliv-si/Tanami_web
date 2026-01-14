@extends('layouts.app')

@section('title', 'Detail Pesanan #TNM-' . str_pad($pesanan->id_pesanan, 5, '0', STR_PAD_LEFT) . ' | Tanami')

@section('content')
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
'pending' => 'Pending Payment',
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
$statusIcons = [
'pending' => 'schedule',
'menunggu_verifikasi' => 'hourglass_top',
'dibayar' => 'paid',
'diproses' => 'precision_manufacturing',
'dikirim' => 'local_shipping',
'terkirim' => 'inventory',
'selesai' => 'check_circle',
'dibatalkan' => 'cancel',
'minta_refund' => 'assignment_return',
'direfund' => 'money_off',
];
@endphp

    <main class="flex-1 py-10">
        <div class="container mx-auto px-4 md:px-10 max-w-[1200px]">
            <nav class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-6 font-sans">
                <a class="hover:text-primary transition-colors" href="{{ route('pesanan') }}">My Orders</a>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-[#1e3f1b] dark:text-white font-medium">Order Details</span>
            </nav>
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <h1 class="text-3xl md:text-4xl font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight">
                            Order Details</h1>
                        <span class="px-3 py-1 rounded-full text-sm font-bold {{ $statusColors[$pesanan->status_pesanan] ?? 'bg-gray-500' }} text-white flex items-center gap-1">
                            <span class="material-symbols-outlined text-lg">{{ $statusIcons[$pesanan->status_pesanan] ?? 'info' }}</span>
                            {{ $statusLabels[$pesanan->status_pesanan] ?? $pesanan->status_pesanan }}
                        </span>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 font-sans text-lg">Order ID: <span
                            class="font-bold text-[#1e3f1b] dark:text-white">#TNM-{{ str_pad($pesanan->id_pesanan, 5, '0', STR_PAD_LEFT) }}</span> • Placed on {{ $pesanan->tgl_dibuat->format('M d, Y') }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    @if($pesanan->status_pesanan === 'pending')
                    <!-- Upload Payment -->
                    <button type="button" onclick="document.getElementById('upload-modal').classList.remove('hidden')"
                        class="px-6 py-2.5 rounded-lg bg-[#53be20] text-white font-heading font-semibold text-sm hover:bg-[#45a01b] transition-colors shadow-lg shadow-[#53be20]/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">upload</span>
                        Upload Payment
                    </button>
                    @elseif(in_array($pesanan->status_pesanan, ['dikirim', 'terkirim']))
                    <!-- Track & Confirm -->
                    @if($pesanan->no_resi)
                    <button type="button" onclick="alert('Tracking: {{ $pesanan->no_resi }}')"
                        class="px-6 py-2.5 rounded-lg border border-[#1e3f1b] dark:border-white text-[#1e3f1b] dark:text-white font-heading font-semibold text-sm hover:bg-gray-50 dark:hover:bg-white/5 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">location_on</span>
                        Track Courier
                    </button>
                    @endif
                    @if(in_array($pesanan->status_pesanan, ['terkirim', 'dikirim']))
                    <form action="{{ route('pesanan.konfirmasi', $pesanan->id_pesanan) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-[#53be20] text-white font-heading font-semibold text-sm hover:bg-[#45a01b] transition-colors shadow-lg shadow-[#53be20]/20 flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">check_circle</span>
                            Confirm Receipt
                        </button>
                    </form>
                    @endif
                    @endif
                    
                    @if(in_array($pesanan->status_pesanan, ['pending', 'menunggu_verifikasi']))
                    <button type="button" onclick="document.getElementById('cancel-modal').classList.remove('hidden')"
                        class="px-6 py-2.5 rounded-lg border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 font-heading font-semibold text-sm hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">cancel</span>
                        Cancel Order
                    </button>
                    @endif

                    @if(in_array($pesanan->status_pesanan, ['terkirim', 'selesai']))
                    <button type="button" onclick="document.getElementById('refund-modal').classList.remove('hidden')"
                        class="px-6 py-2.5 rounded-lg border border-orange-300 dark:border-orange-700 text-orange-600 dark:text-orange-400 font-heading font-semibold text-sm hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">assignment_return</span>
                        Request Refund
                    </button>
                    @endif
                </div>

                <!-- Review Section (only for completed orders) -->
                @if($pesanan->status_pesanan === 'selesai')
                <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                    <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#53be20]">star</span>
                        Rate Your Products
                    </h3>
                    <div class="space-y-6">
                        @foreach($pesanan->items as $item)
                        @php
                        $existingReview = $item->ulasan;
                        @endphp
                        <div class="p-4 bg-gray-50 dark:bg-white/5 rounded-xl {{ !$loop->last ? 'border-b border-gray-100 dark:border-white/10' : '' }}">
                            <div class="flex gap-4 items-start mb-4">
                                <div class="size-16 bg-white dark:bg-white/10 rounded-lg flex items-center justify-center shrink-0 overflow-hidden">
                                    @if($item->produk->foto)
                                    <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover">
                                    @else
                                    <span class="material-symbols-outlined text-4xl text-primary">inventory_2</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <h4 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-1">
                                                {{ $item->produk->nama_produk }}</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 font-sans mb-1">{{ Str::limit($item->produk->deskripsi, 60) }}</p>
                                            <div class="text-sm text-[#1e3f1b] dark:text-gray-300 font-medium">Farmer: {{ $item->produk->petani->nama_lengkap ?? 'N/A' }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-lg font-bold font-heading text-[#1e3f1b] dark:text-white whitespace-nowrap">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $item->jumlah }} × Rp {{ number_format((float)$item->harga_snapshot, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex items-center text-sm font-sans text-gray-500 dark:text-gray-400">
                                        <span class="bg-gray-100 dark:bg-white/10 px-2 py-0.5 rounded">Unit Price: Rp {{ number_format((float)$item->harga_snapshot, 0, ',', '.') }}</span>
                                        <span class="mx-2">•</span>
                                        <span class="bg-gray-100 dark:bg-white/10 px-2 py-0.5 rounded">Qty: {{ $item->jumlah }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-6">Price Breakdown</h3>
                        <div class="space-y-3 font-sans text-gray-600 dark:text-gray-300">
                            <div class="flex justify-between items-center">
                                <span>Subtotal ({{ $pesanan->items->sum('jumlah') }} items)</span>
                                <span>Rp {{ number_format($pesanan->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Delivery Fee</span>
                                <span>Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                            </div>
                            @if($pesanan->pemakaianKupon)
                            <div class="flex justify-between items-center text-[#53be20]">
                                <span>Discount ({{ $pesanan->pemakaianKupon->kupon->kode_kupon }})</span>
                                <span>- Rp {{ number_format($pesanan->diskon, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="h-px bg-gray-100 dark:bg-white/10 my-2"></div>
                            <div class="flex justify-between items-center text-lg font-heading font-bold text-[#1e3f1b] dark:text-white">
                                <span>Total Price</span>
                                <span>Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <!-- Order Timeline -->
                    <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-6">Order Timeline</h3>
                        <div class="relative pl-2 font-sans">
                            @foreach($pesanan->historiStatus->sortByDesc('tgl_ubah') as $index => $histori)
                            <div class="flex gap-4 {{ !$loop->last ? 'mb-8' : '' }} relative z-10">
                                <div class="flex flex-col items-center">
                                    <div class="size-8 rounded-full {{ $loop->first ? 'bg-[#53be20] ring-4 ring-[#53be20]/20' : 'bg-[#1e3f1b]' }} text-white flex items-center justify-center shrink-0 z-10">
                                        <span class="material-symbols-outlined text-sm">{{ $loop->first ? ($statusIcons[$histori->status_baru] ?? 'info') : 'check' }}</span>
                                    </div>
                                    @if(!$loop->last)
                                    <div class="w-0.5 h-full bg-[#1e3f1b] absolute top-8 left-[15px] -z-0"></div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold {{ $loop->first ? 'text-[#53be20]' : 'text-[#1e3f1b] dark:text-white' }} text-sm">{{ $statusLabels[$histori->status_baru] ?? $histori->status_baru }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $histori->tgl_dibuat->format('d M, h:i A') }}</p>
                                    @if($histori->alasan)
                                    <p class="text-xs text-[#1e3f1b] dark:text-gray-300 mt-2 font-medium">{{ $histori->alasan }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach

                        @if($pesanan->historiStatus->isEmpty())
                        <div class="flex gap-4 relative z-10">
                            <div class="flex flex-col items-center">
                                <div class="size-8 rounded-full bg-[#53be20] ring-4 ring-[#53be20]/20 text-white flex items-center justify-center shrink-0 z-10">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-[#53be20] text-sm">Order Placed</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $pesanan->tgl_dibuat->format('d M, h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                    <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-4">Shipping Information</h3>
                    <div class="flex gap-4 items-start">
                        <div class="mt-1">
                            <span class="material-symbols-outlined text-gray-400">person_pin_circle</span>
                        </div>
                        <div>
                            <p class="font-heading font-semibold text-[#1e3f1b] dark:text-white">{{ $pesanan->pembeli->nama_lengkap }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                                {{ $pesanan->pembeli->alamat ?? '-' }}<br>
                                {{ $pesanan->kota->nama_kota ?? '' }}
                            </p>
                            @if($pesanan->pembeli->no_hp)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $pesanan->pembeli->no_hp }}</p>
                            @endif
                            @if($pesanan->no_resi)
                            <p class="text-sm text-[#53be20] mt-2 font-medium">Resi: {{ $pesanan->no_resi }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                    <!-- Payment Information -->
                    <div class="bg-white dark:bg-[#1f2b1b] rounded-xl p-6 shadow-sm border border-gray-100 dark:border-white/5">
                        <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white mb-4">Payment Information</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-lg bg-gray-50 dark:bg-white/5 flex items-center justify-center border border-gray-100 dark:border-white/10">
                                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-300">account_balance</span>
                                    </div>
                                    <div>
                                        <p class="font-heading font-semibold text-[#1e3f1b] dark:text-white text-sm">Bank Transfer</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $pesanan->metode_pembayaran ?? 'Manual Transfer' }}</p>
                                    </div>
                                </div>
                                @php
                                    $paymentStatus = in_array($pesanan->status_pesanan, ['pending']) ? 'Unpaid' : 'Paid';
                                    $paymentClass = $paymentStatus === 'Paid' ? 'bg-[#1e3f1b]/10 dark:bg-white/10 text-[#1e3f1b] dark:text-white' : 'bg-yellow-100 text-yellow-700';
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $paymentClass }}">
                                    {{ $paymentStatus }}
                                </span>
                            </div>

                            {{-- Farmer Bank Account Info --}}
                            @php
                                $petani = $pesanan->items->first()?->produk?->petani;
                                $rekening = $petani?->rekening?->first();
                            @endphp
                            @if($rekening && $pesanan->status_pesanan === 'pending')
                            <div class="pt-4 border-t border-gray-100 dark:border-white/10">
                                <p class="text-sm font-semibold text-[#1e3f1b] dark:text-white mb-3">Transfer to:</p>
                                <div class="bg-gray-50 dark:bg-white/5 rounded-lg p-4 space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Bank</span>
                                        <span class="text-sm font-bold text-[#1e3f1b] dark:text-white">{{ $rekening->nama_bank }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Account Number</span>
                                        <span class="text-sm font-bold text-[#1e3f1b] dark:text-white font-mono">{{ $rekening->no_rekening }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Account Name</span>
                                        <span class="text-sm font-bold text-[#1e3f1b] dark:text-white">{{ $rekening->atas_nama }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($pesanan->bukti_bayar)
                            <div class="pt-4 border-t border-gray-100 dark:border-white/10">
                                <p class="text-sm text-gray-500 mb-2">Payment Proof:</p>
                                <a href="{{ route('pesanan.bukti-bayar', $pesanan->id_pesanan) }}" target="_blank" class="text-[#53be20] text-sm hover:underline">View Image</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<!-- Upload Payment Modal -->
@if($pesanan->status_pesanan === 'pending')
<div id="upload-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="this.closest('[role=dialog]').classList.add('hidden')"></div>
        <div class="inline-block align-bottom bg-white dark:bg-[#1f2b1b] rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
            <form action="{{ route('pesanan.upload-bukti', $pesanan->id_pesanan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5">
                    <h3 class="font-heading font-bold text-lg text-[#1e3f1b] dark:text-white">Upload Payment Proof</h3>
                </div>
                <div class="p-6">
                    <p class="text-lg font-bold text-[#1e3f1b] dark:text-white mb-4">Total: Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                    <input type="file" name="bukti_bayar" accept="image/jpeg,image/png" required
                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1f2b1b] text-sm">
                    <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Max: 2MB</p>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5 flex justify-end gap-3">
                    <button type="button" onclick="this.closest('[role=dialog]').classList.add('hidden')"
                        class="px-5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg text-[#1e3f1b] dark:text-white font-semibold text-sm">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#53be20] text-white rounded-lg font-semibold text-sm hover:bg-[#45a01b]">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Cancel Modal -->
@if(in_array($pesanan->status_pesanan, ['pending', 'menunggu_verifikasi']))
<div id="cancel-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="this.closest('[role=dialog]').classList.add('hidden')"></div>
        <div class="inline-block align-bottom bg-white dark:bg-[#1f2b1b] rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
            <form action="{{ route('pesanan.batal', $pesanan->id_pesanan) }}" method="POST">
                @csrf
                <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5">
                    <h3 class="font-heading font-bold text-lg text-red-600">Cancel Order</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Are you sure you want to cancel this order?</p>
                    <textarea name="alasan_batal" rows="3" required placeholder="Reason for cancellation..."
                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1f2b1b] text-sm resize-none"></textarea>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5 flex justify-end gap-3">
                    <button type="button" onclick="this.closest('[role=dialog]').classList.add('hidden')"
                        class="px-5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg text-[#1e3f1b] dark:text-white font-semibold text-sm">Keep Order</button>
                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-lg font-semibold text-sm hover:bg-red-700">Cancel Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Refund Modal -->
@if(in_array($pesanan->status_pesanan, ['terkirim', 'selesai']))
<div id="refund-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="this.closest('[role=dialog]').classList.add('hidden')"></div>
        <div class="inline-block align-bottom bg-white dark:bg-[#1f2b1b] rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
            <form action="{{ route('pesanan.refund', $pesanan->id_pesanan) }}" method="POST">
                @csrf
                <div class="px-6 py-4 border-b border-gray-100 dark:border-white/5">
                    <h3 class="font-heading font-bold text-lg text-orange-600">Request Refund</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Please describe why you want a refund:</p>
                    <textarea name="alasan_refund" rows="3" required placeholder="Reason for refund request..."
                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-[#1f2b1b] text-sm resize-none"></textarea>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 dark:border-white/5 flex justify-end gap-3">
                    <button type="button" onclick="this.closest('[role=dialog]').classList.add('hidden')"
                        class="px-5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg text-[#1e3f1b] dark:text-white font-semibold text-sm">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 bg-orange-600 text-white rounded-lg font-semibold text-sm hover:bg-orange-700">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(session('success'))
<script>
    setTimeout(() => {
        alert('{{ session('
            success ') }}');
    }, 100);
</script>
@endif

@if(session('error'))
<script>
    setTimeout(() => {
        alert('{{ session('
            error ') }}');
    }, 100);
</script>
@endif

<!-- Star Rating JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.star-rating').forEach(function(container) {
            const stars = container.querySelectorAll('.star-icon');
            const inputs = container.querySelectorAll('input[type="radio"]');

            stars.forEach(function(star, index) {
                star.addEventListener('click', function() {
                    // Update visual
                    stars.forEach(function(s, i) {
                        if (i <= index) {
                            s.classList.remove('text-gray-300');
                            s.classList.add('text-yellow-400');
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });
                });

                star.addEventListener('mouseenter', function() {
                    stars.forEach(function(s, i) {
                        if (i <= index) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                        }
                    });
                });

                star.addEventListener('mouseleave', function() {
                    // Restore to selected state
                    const checkedInput = container.querySelector('input:checked');
                    const checkedValue = checkedInput ? parseInt(checkedInput.value) : 0;

                    stars.forEach(function(s, i) {
                        if (i < checkedValue) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });
                });
            });
        });
    });
</script>
@endsection