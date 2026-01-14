@extends('layouts.admin')

@section('title', 'Tanami - Admin Escrow Management')
@section('header_title', 'Escrow Management')

@section('content')
    <div class="max-w-[1600px] mx-auto space-y-6">
        
        {{-- Breadcrumb & Subtitle --}}
        <div class="flex flex-col gap-1">
            <div class="flex items-center text-xs text-gray-500 font-sans">
                <a class="hover:text-primary transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span class="mx-2 text-gray-300">/</span>
                <span class="text-gray-900 font-medium">Escrow Management</span>
            </div>
            <h1 class="text-2xl font-heading font-bold text-[#1e3f1b]">Escrow Overview</h1>
        </div>

        {{-- Cards Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Held in Escrow --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center bg-yellow-50 text-yellow-700 rounded-lg">
                        <span class="material-symbols-outlined text-2xl">account_balance</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Held in Escrow</p>
                        <h3 class="text-2xl font-heading font-bold text-[#1e3f1b]">Rp {{ number_format($stats['total_ditahan'], 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $stats['count_ditahan'] }} transactions</p>
                    </div>
                </div>
            </div>
            {{-- Released to Farmers --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center bg-green-50 text-green-700 rounded-lg">
                        <span class="material-symbols-outlined text-2xl">payments</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Released to Farmers</p>
                        <h3 class="text-2xl font-heading font-bold text-green-600">Rp {{ number_format($stats['total_dikirim'], 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $stats['count_dikirim'] }} transactions</p>
                    </div>
                </div>
            </div>
            {{-- Refunded to Buyers --}}
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="size-12 flex items-center justify-center bg-red-50 text-red-700 rounded-lg">
                        <span class="material-symbols-outlined text-2xl">money_off</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Refunded to Buyers</p>
                        <h3 class="text-2xl font-heading font-bold text-red-600">Rp {{ number_format($stats['total_direfund'], 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $stats['count_direfund'] }} transactions</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table Area --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <form method="GET" action="{{ route('admin.escrow') }}" class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    {{-- Filter Dropdown --}}
                    <select name="status" onchange="this.form.submit()" class="text-sm border-gray-200 rounded-lg text-gray-600 focus:ring-primary/20 py-2.5 pr-10">
                        <option value="">All Status</option>
                        <option value="ditahan" {{ $currentStatus === 'ditahan' ? 'selected' : '' }}>Held</option>
                        <option value="dikirim_ke_petani" {{ $currentStatus === 'dikirim_ke_petani' ? 'selected' : '' }}>Released</option>
                        <option value="direfund_ke_pembeli" {{ $currentStatus === 'direfund_ke_pembeli' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
            </form>
            
            {{-- Tabel Escrow --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-xs text-gray-500 font-bold uppercase border-b border-gray-100 font-heading tracking-wider">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Transaction Info</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-sans divide-y divide-gray-100">
                        @forelse($escrowList as $escrow)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5 font-bold text-[#1e3f1b]">#TNM-{{ str_pad($escrow->pesanan->id_pesanan ?? 0, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-5">
                                @php
                                    // Get farmer from first item's produk
                                    $petani = $escrow->pesanan?->items?->first()?->produk?->petani;
                                @endphp
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-blue-50 text-blue-600">BUYER</span>
                                        <span class="font-semibold text-gray-800">{{ $escrow->pesanan?->pembeli?->nama_lengkap ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-green-50 text-green-600">FARMER</span>
                                        <span class="text-gray-500">{{ $petani?->nama_lengkap ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 font-bold text-[#1e3f1b]">Rp {{ number_format($escrow->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 text-gray-500">{{ $escrow->tgl_ditahan?->format('M d, Y') ?? '-' }}</td>
                            <td class="px-6 py-5">
                                @php
                                    $statusColors = [
                                        'ditahan' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'dot' => 'bg-yellow-600', 'label' => 'Held in Escrow'],
                                        'dikirim_ke_petani' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'dot' => 'bg-green-600', 'label' => 'Released'],
                                        'direfund_ke_pembeli' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'dot' => 'bg-red-600', 'label' => 'Refunded'],
                                    ];
                                    $s = $statusColors[$escrow->status_escrow] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200', 'dot' => 'bg-gray-600', 'label' => $escrow->status_escrow];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $s['bg'] }} {{ $s['text'] }} border {{ $s['border'] }}">
                                    <span class="size-1.5 rounded-full {{ $s['dot'] }}"></span> {{ $s['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-2">
                                    @if($escrow->status_escrow === 'ditahan')
                                    {{-- Release to Petani --}}
                                    <form action="{{ route('admin.escrow.release', $escrow->id_escrow) }}" method="POST" onsubmit="return confirm('Release dana ke petani?')">
                                        @csrf
                                        <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Release to Farmer">
                                            <span class="material-symbols-outlined text-xl">payments</span>
                                        </button>
                                    </form>
                                    {{-- Refund to Pembeli --}}
                                    <button type="button" onclick="openRefundModal({{ $escrow->id_escrow }})" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Refund to Buyer">
                                        <span class="material-symbols-outlined text-xl">money_off</span>
                                    </button>
                                    @else
                                    <span class="text-gray-400 text-xs">Processed</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2">inbox</span>
                                <p>No escrow transactions found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($escrowList->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $escrowList->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Refund Modal --}}
    <div id="refund-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-bold text-[#1e3f1b]">Refund to Buyer</h3>
                <button type="button" onclick="closeRefundModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="refund-form" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for refund *</label>
                    <textarea name="alasan" rows="3" required class="w-full rounded-lg border-gray-200 focus:ring-primary/20" placeholder="Enter reason for refund..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeRefundModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Process Refund</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRefundModal(escrowId) {
            const modal = document.getElementById('refund-modal');
            const form = document.getElementById('refund-form');
            form.action = '{{ url("admin/escrow") }}/' + escrowId + '/refund';
            modal.classList.remove('hidden');
        }

        function closeRefundModal() {
            document.getElementById('refund-modal').classList.add('hidden');
        }
    </script>

    @if(session('success'))
    <script>
        setTimeout(() => alert('{{ session('success') }}'), 100);
    </script>
    @endif

    @if(session('error'))
    <script>
        setTimeout(() => alert('{{ session('error') }}'), 100);
    </script>
    @endif
@endsection