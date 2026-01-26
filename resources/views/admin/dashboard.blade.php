@extends('layouts.admin')

@php $active = 'dashboard'; @endphp

@section('title', 'Tanami - Admin Dashboard Overview')
@section('header_title', 'Admin Dashboard')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-10 p-0">
    <div class="flex flex-col gap-1">
        <h2 class="text-2xl font-heading font-extrabold text-tanami-dark">Dashboard Overview</h2>
        <p class="text-sm text-gray-500 font-medium">Monitoring Tanami agritech performance and marketplace
            activity.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
            class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="size-11 flex items-center justify-center bg-green-50 text-primary rounded-xl">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <span
                    class="inline-flex items-center text-[11px] font-bold text-primary bg-green-50 px-2 py-1 rounded-md">
                    <span class="material-symbols-outlined text-sm mr-1">trending_up</span> GMV
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-heading font-extrabold text-tanami-dark">Rp{{ number_format($financialStats['gmv_total'] ?? 0, 0, ',', '.') }}</h3>
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">TOTAL GMV</p>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div
                    class="size-11 flex items-center justify-center bg-orange-50 text-orange-600 rounded-xl">
                    <span class="material-symbols-outlined">receipt_long</span>
                </div>
                <span
                    class="inline-flex items-center text-[11px] font-bold text-primary bg-green-50 px-2 py-1 rounded-md">
                    <span class="material-symbols-outlined text-sm mr-1">trending_up</span> Total
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-heading font-extrabold text-tanami-dark">{{ number_format($transactionStats['total_pesanan'] ?? 0) }}</h3>
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">TOTAL TRANSACTION</p>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="size-11 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <span
                    class="inline-flex items-center text-[11px] font-bold text-primary bg-green-50 px-2 py-1 rounded-md">
                    <span class="material-symbols-outlined text-sm mr-1">trending_up</span> Users
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-heading font-extrabold text-tanami-dark">{{ number_format(($userStats['total_pembeli'] ?? 0) + ($userStats['total_petani'] ?? 0)) }}</h3>
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">TOTAL USERS</p>
            </div>
        </div>
        <div
            class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="size-11 flex items-center justify-center bg-amber-50 text-amber-600 rounded-xl">
                    <span class="material-symbols-outlined">inventory_2</span>
                </div>
                <span
                    class="inline-flex items-center text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-md">
                    <span class="material-symbols-outlined text-sm mr-1">info</span> Pending
                </span>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-heading font-extrabold text-tanami-dark">{{ number_format($userStats['petani_pending'] ?? 0) }}</h3>
                <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">PENDING FARMER</p>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div
            class="lg:col-span-1 bg-white rounded-2xl border border-gray-50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-heading font-bold text-tanami-dark">Sales Trend</h3>
                    <p class="text-xs text-gray-400 font-medium">Daily revenue insights</p>
                </div>
                <div
                    class="size-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 cursor-pointer hover:bg-gray-100">
                    <span class="material-symbols-outlined text-sm">more_vert</span>
                </div>
            </div>
            <div class="h-48 flex items-end justify-between gap-3 px-2">
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                        <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                            style="height: 45%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">M</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                        <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                            style="height: 65%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">T</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                        <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                            style="height: 35%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">W</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                        <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                            style="height: 85%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">T</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                        <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                            style="height: 55%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">F</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                        <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                            style="height: 70%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">S</span>
                </div>
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                        <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                            style="height: 50%"></div>
                    </div>
                    <span class="text-[10px] text-gray-400 font-bold uppercase">S</span>
                </div>
            </div>
        </div>
        <div
            class="lg:col-span-2 bg-white rounded-2xl border border-gray-50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-heading font-bold text-tanami-dark">Recent Orders</h3>
                    <p class="text-xs text-gray-400 font-medium">Tracking latest marketplace activities</p>
                </div>
                <a href="{{ route('admin.pesanan') }}"
                    class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-xl text-xs font-bold transition-colors">
                    View All
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Buyer</th>
                            <th class="px-6 py-4">City</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50">
                        @forelse($recentOrders ?? [] as $index => $pesanan)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="px-6 py-4 text-gray-400 font-medium">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 font-mono text-gray-500 font-medium text-xs">#ORD-{{ $pesanan->id_pesanan }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-[10px]">
                                        {{ strtoupper(substr($pesanan->pembeli->nama_lengkap ?? 'U', 0, 2)) }}
                                    </div>
                                    <span class="font-semibold text-tanami-dark">{{ $pesanan->pembeli->nama_lengkap ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 font-medium">{{ $pesanan->kota->nama_kota ?? '-' }}</td>
                            <td class="px-6 py-4 font-bold text-tanami-dark">Rp{{ number_format($pesanan->total_bayar, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                $statusColors = [
                                'pending' => 'bg-yellow-50 text-yellow-700',
                                'menunggu_verifikasi' => 'bg-blue-50 text-blue-700',
                                'dibayar' => 'bg-green-50 text-green-700',
                                'diproses' => 'bg-indigo-50 text-indigo-700',
                                'dikirim' => 'bg-purple-50 text-purple-700',
                                'terkirim' => 'bg-teal-50 text-teal-700',
                                'selesai' => 'bg-green-50 text-green-700',
                                'dibatalkan' => 'bg-red-50 text-red-700',
                                'minta_refund' => 'bg-orange-50 text-orange-700',
                                'direfund' => 'bg-gray-50 text-gray-700',
                                ];
                                $statusColor = $statusColors[$pesanan->status_pesanan] ?? 'bg-gray-50 text-gray-700';
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $statusColor }} uppercase tracking-wide">
                                    {{ str_replace('_', ' ', $pesanan->status_pesanan) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $pesanan->tgl_dibuat->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">No Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection