@extends('layouts.admin')

@php $active = 'refund'; @endphp

@section('title', 'Tanami - Refund Management')
@section('header_title', 'Refund Management')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-8">
        
        {{-- Breadcrumb & Header --}}
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Refund Management</span>
            </div>
            <h2 class="text-2xl font-heading font-extrabold text-tanami-dark">Refund Management</h2>
            <p class="text-sm text-gray-500">Manage refund requests from buyers</p>
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

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Pending Requests --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-orange-50 text-orange-600 rounded-lg">
                        <span class="material-symbols-outlined">hourglass_top</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">{{ number_format($stats['pending_count'] ?? 0) }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Pending Requests</p>
                </div>
            </div>
            {{-- Pending Amount --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-amber-50 text-amber-600 rounded-lg">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">Rp {{ number_format($stats['pending_amount'] ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Pending Amount</p>
                </div>
            </div>
            {{-- Completed Refunds --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-green-50 text-green-600 rounded-lg">
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">{{ number_format($stats['completed_count'] ?? 0) }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Completed Refunds</p>
                </div>
            </div>
            {{-- Refunded Amount --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <div class="size-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg">
                        <span class="material-symbols-outlined">currency_exchange</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-heading font-extrabold text-tanami-dark">Rp {{ number_format($stats['completed_amount'] ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-gray-400 text-[11px] font-bold uppercase tracking-wider mt-1">Total Refunded</p>
                </div>
            </div>
        </div>

        {{-- Pending Refund Requests Table --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-heading font-bold text-tanami-dark">Pending Refund Requests</h3>
                    <p class="text-xs text-gray-400 mt-1">Orders awaiting refund approval</p>
                </div>
                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                    {{ $refundRequests->total() }} Requests
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] text-gray-500 font-bold uppercase border-b border-gray-100 font-heading tracking-wider">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Items</th>
                            <th class="px-6 py-4">Reason</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Requested Date</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50 font-sans">
                        @forelse($refundRequests as $request)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <a href="{{ route('admin.pesanan.detail', $request->id_pesanan) }}" class="font-mono font-bold text-primary hover:underline">
                                    #{{ $request->id_pesanan }}
                                </a>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($request->pembeli->nama_lengkap ?? 'U') }}&background=random&size=64" 
                                         alt="{{ $request->pembeli->nama_lengkap ?? '' }}" 
                                         class="size-8 rounded-full object-cover">
                                    <div>
                                        <span class="font-semibold text-tanami-dark">{{ $request->pembeli->nama_lengkap ?? '-' }}</span>
                                        <p class="text-xs text-gray-400">{{ $request->pembeli->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-gray-600">
                                <div class="max-w-[150px]">
                                    @foreach($request->items->take(2) as $item)
                                        <p class="text-xs truncate">{{ $item->produk->nama_produk ?? 'Product' }}</p>
                                    @endforeach
                                    @if($request->items->count() > 2)
                                        <p class="text-xs text-gray-400">+{{ $request->items->count() - 2 }} more</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 text-gray-600 max-w-[200px]">
                                <p class="truncate" title="{{ $request->alasan_batal ?? '-' }}">{{ $request->alasan_batal ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-5 font-bold text-tanami-dark">
                                Rp {{ number_format($request->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 text-gray-500 text-xs">
                                {{ \Carbon\Carbon::parse($request->tgl_update)->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Approve Button --}}
                                    <form action="{{ route('admin.refund.approve', $request->id_pesanan) }}" method="POST"
                                          onsubmit="return confirm('Approve this refund request? The funds will be returned to the buyer.');">
                                        @csrf
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Approve Refund">
                                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                        </button>
                                    </form>
                                    
                                    {{-- Reject Button --}}
                                    <button type="button" onclick="openRejectModal({{ $request->id_pesanan }})" 
                                            class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Reject Refund">
                                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                                    </button>
                                    
                                    {{-- View Detail --}}
                                    <a href="{{ route('admin.pesanan.detail', $request->id_pesanan) }}" 
                                       class="p-2 text-gray-400 hover:bg-gray-100 rounded-lg transition-colors" title="View Details">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="size-16 rounded-full bg-green-50 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-3xl text-green-400">check_circle</span>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 font-semibold">No Pending Requests</p>
                                        <p class="text-gray-500 text-sm mt-1">All refund requests have been processed.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if($refundRequests->hasPages())
            <div class="p-6 border-t border-gray-50">
                {{ $refundRequests->links() }}
            </div>
            @endif
        </div>

        {{-- Refund History --}}
        @if($refundHistory->count() > 0)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-heading font-bold text-tanami-dark">Recent Refund History</h3>
                    <p class="text-xs text-gray-400 mt-1">Last 20 completed refunds</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-[11px] text-gray-500 font-bold uppercase border-b border-gray-100 font-heading tracking-wider">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Refunded To</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-50 font-sans">
                        @foreach($refundHistory as $history)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pesanan.detail', $history->id_pesanan) }}" class="font-mono font-bold text-primary hover:underline">
                                    #{{ $history->id_pesanan }}
                                </a>
                            </td>
                            <td class="px-6 py-4 font-medium text-tanami-dark">
                                {{ $history->pembeli->nama_lengkap ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-bold text-tanami-dark">
                                Rp {{ number_format($history->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $history->escrow->penerima->nama_lengkap ?? $history->pembeli->nama_lengkap ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ $history->tgl_dibatalkan ? \Carbon\Carbon::parse($history->tgl_dibatalkan)->format('M d, Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 uppercase tracking-wide border border-green-100">
                                    Refunded
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    {{-- Reject Modal --}}
    <div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-heading font-bold text-tanami-dark">Reject Refund Request</h3>
                <p class="text-sm text-gray-500 mt-1">Please provide a reason for rejecting this refund request.</p>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="p-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason <span class="text-red-500">*</span></label>
                    <textarea name="alasan" rows="4" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary/30"
                        placeholder="Enter reason for rejecting this refund request..."></textarea>
                    @error('alasan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="p-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()" 
                        class="px-4 py-2.5 text-gray-600 border border-gray-200 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-colors">
                        Reject Refund
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(orderId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/refund/${orderId}/reject`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal on background click
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
@endsection