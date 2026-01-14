@extends('layouts.admin')

@php $active = 'pesanan'; @endphp

@section('title', 'Tanami - Order Detail #' . $pesanan->id_pesanan)
@section('header_title', 'Order Detail')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-8">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                    <span class="material-symbols-outlined text-[10px]">arrow_forward_ios</span>
                    <a href="{{ route('admin.pesanan') }}" class="hover:text-primary transition-colors">Orders</a>
                    <span class="material-symbols-outlined text-[10px]">arrow_forward_ios</span>
                    <span class="text-primary">Detail</span>
                </div>
                <h2 class="text-3xl font-heading font-extrabold text-tanami-dark flex items-center gap-4">
                    Order #{{ $pesanan->id_pesanan }}
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'menunggu_verifikasi' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'dibayar' => 'bg-cyan-50 text-cyan-600 border-cyan-100',
                            'diproses' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                            'dikirim' => 'bg-purple-50 text-purple-600 border-purple-100',
                            'terkirim' => 'bg-violet-50 text-violet-600 border-violet-100',
                            'selesai' => 'bg-green-50 text-green-600 border-green-100',
                            'dibatalkan' => 'bg-red-50 text-red-600 border-red-100',
                            'minta_refund' => 'bg-orange-50 text-orange-600 border-orange-100',
                            'direfund' => 'bg-gray-100 text-gray-600 border-gray-200',
                        ];
                        $statusLabels = [
                            'pending' => 'Pending',
                            'menunggu_verifikasi' => 'Awaiting Verification',
                            'dibayar' => 'Paid',
                            'diproses' => 'Processing',
                            'dikirim' => 'Shipped',
                            'terkirim' => 'Delivered',
                            'selesai' => 'Completed',
                            'dibatalkan' => 'Cancelled',
                            'minta_refund' => 'Refund Requested',
                            'direfund' => 'Refunded',
                        ];
                        $color = $statusColors[$pesanan->status_pesanan] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                        $label = $statusLabels[$pesanan->status_pesanan] ?? ucfirst($pesanan->status_pesanan);
                    @endphp
                    <span class="px-3 py-1 rounded-full border text-xs font-bold uppercase tracking-wide {{ $color }}">{{ $label }}</span>
                </h2>
                <p class="text-sm text-gray-500 font-medium">
                    Created on {{ \Carbon\Carbon::parse($pesanan->tgl_dibuat)->format('M d, Y \a\t h:i A') }}
                </p>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('admin.pesanan') }}"
                    class="px-4 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-50 hover:text-tanami-dark hover:border-gray-300 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Item List --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-lg font-heading font-bold text-tanami-dark">Order Items</h3>
                        <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-md">
                            {{ $pesanan->items->count() }} {{ $pesanan->items->count() == 1 ? 'Item' : 'Items' }}
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50">
                                <tr class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">
                                    <th class="px-6 py-4">Product</th>
                                    <th class="px-6 py-4">Farmer</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4 text-center">Qty</th>
                                    <th class="px-6 py-4 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($pesanan->items as $item)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="size-14 rounded-lg bg-green-50 border border-green-100 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                                @if($item->produk && $item->produk->gambar_produk)
                                                    <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}" alt="{{ $item->produk->nama_produk ?? '' }}" class="size-full object-cover">
                                                @else
                                                    <span class="material-symbols-outlined text-2xl text-green-500">nutrition</span>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-heading font-bold text-tanami-dark text-sm">
                                                    {{ $item->produk->nama_produk ?? 'Product unavailable' }}
                                                </p>
                                                @if($item->produk && $item->produk->kategori)
                                                <p class="text-xs text-gray-500 mt-0.5">{{ $item->produk->kategori->nama_kategori }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->petani->nama_lengkap ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                        Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium text-gray-600">
                                        {{ $item->jumlah }} {{ $item->produk->satuan ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-tanami-dark">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">No items found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Payment Summary --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-6">
                    <h3 class="text-lg font-heading font-bold text-tanami-dark mb-6">Payment Summary</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Subtotal</span>
                            <span class="font-bold text-tanami-dark">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Shipping Cost</span>
                            <span class="font-bold text-tanami-dark">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                        </div>
                        @if($pesanan->pemakaianKupon && $pesanan->pemakaianKupon->count() > 0)
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">
                                Coupon Discount
                                <span class="text-xs text-primary">({{ $pesanan->pemakaianKupon->first()->kupon->kode_kupon ?? '' }})</span>
                            </span>
                            <span class="font-bold text-green-600">- Rp {{ number_format($pesanan->pemakaianKupon->first()->jumlah_diskon ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="h-px bg-gray-100 my-4"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-tanami-dark">Grand Total</span>
                            <span class="text-xl font-heading font-extrabold text-primary">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    {{-- Payment Proof --}}
                    @if($pesanan->bukti_bayar)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-xs text-gray-400 font-bold uppercase mb-3">Payment Proof</p>
                        <a href="{{ asset('storage/' . $pesanan->bukti_bayar) }}" target="_blank" class="inline-flex items-center gap-2 text-primary hover:underline text-sm font-medium">
                            <span class="material-symbols-outlined text-lg">receipt_long</span>
                            View Payment Proof
                        </a>
                    </div>
                    @endif
                </div>

                {{-- Escrow Info --}}
                @if($pesanan->escrow)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-6">
                    <h3 class="text-lg font-heading font-bold text-tanami-dark mb-6">Escrow Information</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Amount</p>
                            <p class="text-sm font-bold text-tanami-dark">Rp {{ number_format($pesanan->escrow->jumlah, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Status</p>
                            @php
                                $escrowStatusColors = [
                                    'ditahan' => 'bg-amber-50 text-amber-700',
                                    'dilepas' => 'bg-green-50 text-green-700',
                                    'dikembalikan' => 'bg-red-50 text-red-700',
                                ];
                                $escrowStatusLabels = [
                                    'ditahan' => 'Held',
                                    'dilepas' => 'Released',
                                    'dikembalikan' => 'Returned',
                                ];
                                $escrowColor = $escrowStatusColors[$pesanan->escrow->status_escrow] ?? 'bg-gray-100 text-gray-700';
                                $escrowLabel = $escrowStatusLabels[$pesanan->escrow->status_escrow] ?? ucfirst($pesanan->escrow->status_escrow);
                            @endphp
                            <span class="inline-flex px-2 py-0.5 rounded text-xs font-bold uppercase {{ $escrowColor }}">{{ $escrowLabel }}</span>
                        </div>
                        @if($pesanan->escrow->penerima)
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Recipient</p>
                            <p class="text-sm font-bold text-tanami-dark">{{ $pesanan->escrow->penerima->nama_lengkap }}</p>
                        </div>
                        @endif
                        @if($pesanan->escrow->tgl_diproses)
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Processed Date</p>
                            <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($pesanan->escrow->tgl_diproses)->format('M d, Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- Right Column --}}
            <div class="space-y-8">
                
                {{-- Customer Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <h3 class="text-sm font-heading font-bold text-tanami-dark uppercase tracking-wide">
                            Customer Information
                        </h3>
                    </div>
                    <div class="p-5 space-y-4">
                        @if($pesanan->pembeli)
                        <div class="flex items-start gap-4">
                            <img alt="{{ $pesanan->pembeli->nama_lengkap }}" class="size-10 rounded-full bg-gray-100 object-cover"
                                src="https://ui-avatars.com/api/?name={{ urlencode($pesanan->pembeli->nama_lengkap) }}&background=random" />
                            <div>
                                <p class="text-sm font-bold text-tanami-dark">{{ $pesanan->pembeli->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500 mb-2">{{ $pesanan->pembeli->email }}</p>
                                @if($pesanan->pembeli->no_hp)
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span class="material-symbols-outlined text-[14px]">call</span>
                                    {{ $pesanan->pembeli->no_hp }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @else
                        <p class="text-sm text-gray-500">Customer data not available.</p>
                        @endif
                    </div>
                </div>

                {{-- Shipping Info --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-sm font-heading font-bold text-tanami-dark uppercase tracking-wide">
                            Shipping Information
                        </h3>
                        <span class="material-symbols-outlined text-gray-400 text-lg">local_shipping</span>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Shipping Address</p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $pesanan->alamat_kirim ?? ($pesanan->pembeli->alamat ?? 'No address provided') }}
                            </p>
                        </div>
                        @if($pesanan->kota)
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">City</p>
                            <p class="text-sm font-bold text-tanami-dark">{{ $pesanan->kota->nama_kota }}</p>
                        </div>
                        @endif
                        @if($pesanan->no_resi)
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Tracking Number</p>
                            <p class="text-sm text-primary font-medium">{{ $pesanan->no_resi }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Order History --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <h3 class="text-sm font-heading font-bold text-tanami-dark uppercase tracking-wide">
                            Status History
                        </h3>
                    </div>
                    <div class="p-5">
                        @if($pesanan->historiStatus && $pesanan->historiStatus->count() > 0)
                        <div class="space-y-4">
                            @foreach($pesanan->historiStatus->sortByDesc('tgl_perubahan') as $histori)
                            <div class="flex items-start gap-3 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                                <div class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-sm">sync_alt</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        @php
                                            $historyLabels = [
                                                'pending' => 'Pending',
                                                'menunggu_verifikasi' => 'Verification',
                                                'dibayar' => 'Paid',
                                                'diproses' => 'Processing',
                                                'dikirim' => 'Shipped',
                                                'terkirim' => 'Delivered',
                                                'selesai' => 'Completed',
                                                'dibatalkan' => 'Cancelled',
                                                'minta_refund' => 'Refund Request',
                                                'direfund' => 'Refunded',
                                            ];
                                        @endphp
                                        <span class="text-xs font-bold text-gray-500 uppercase">{{ $historyLabels[$histori->status_lama] ?? $histori->status_lama ?? '-' }}</span>
                                        <span class="material-symbols-outlined text-[12px] text-gray-400">arrow_forward</span>
                                        <span class="text-xs font-bold text-primary uppercase">{{ $historyLabels[$histori->status_baru] ?? $histori->status_baru }}</span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ \Carbon\Carbon::parse($histori->tgl_perubahan)->format('M d, Y \a\t h:i A') }}
                                        @if($histori->pengubah)
                                        by {{ $histori->pengubah->nama_lengkap }}
                                        @endif
                                    </p>
                                    @if($histori->alasan)
                                    <p class="text-xs text-gray-500 mt-1 italic">"{{ $histori->alasan }}"</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-sm text-gray-500 text-center py-4">No status history available.</p>
                        @endif
                    </div>
                </div>

                {{-- Customer Notes --}}
                @if($pesanan->catatan)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <h3 class="text-sm font-heading font-bold text-tanami-dark uppercase tracking-wide">
                            Customer Notes
                        </h3>
                    </div>
                    <div class="p-5">
                        <p class="text-sm text-gray-600">{{ $pesanan->catatan }}</p>
                    </div>
                </div>
                @endif

                {{-- Cancellation Reason --}}
                @if($pesanan->status_pesanan == 'dibatalkan' && $pesanan->alasan_batal)
                <div class="bg-red-50 rounded-2xl border border-red-100 overflow-hidden">
                    <div class="p-5 border-b border-red-100">
                        <h3 class="text-sm font-heading font-bold text-red-700 uppercase tracking-wide">
                            Cancellation Reason
                        </h3>
                    </div>
                    <div class="p-5">
                        <p class="text-sm text-red-600">{{ $pesanan->alasan_batal }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection