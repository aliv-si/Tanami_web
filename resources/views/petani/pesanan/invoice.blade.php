<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pesanan->id_pesanan }} - Tanami</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white p-8">
    <!-- Print Button -->
    <div class="no-print mb-6 flex items-center justify-between">
        <a href="{{ route('petani.pesanan.detail', $pesanan->id_pesanan) }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>
        <button onclick="window.print()" class="flex items-center gap-2 px-6 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Invoice
        </button>
    </div>

    <!-- Invoice Container -->
    <div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-green-600 to-green-700 rounded-t-lg">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4 8v13h16V8l-8-6zm0 2.5L18 9v10H6V9l6-4.5z"/></svg>
                        TANAMI
                    </h1>
                    <p class="text-green-100 text-sm mt-1">Smart Gardening & E-commerce</p>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-bold text-white">INVOICE</h2>
                    <p class="text-green-100">#{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="px-8 py-6 grid grid-cols-2 gap-8 border-b border-gray-200">
            <!-- Pembeli -->
            <div>
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Billed To</h3>
                <p class="font-semibold text-gray-900">{{ $pesanan->pembeli->nama_lengkap ?? '-' }}</p>
                <p class="text-sm text-gray-600">{{ $pesanan->pembeli->email ?? '-' }}</p>
                <p class="text-sm text-gray-600">{{ $pesanan->pembeli->no_hp ?? '-' }}</p>
                @if($pesanan->alamat_pengiriman)
                    <p class="text-sm text-gray-600 mt-2">{{ $pesanan->alamat_pengiriman }}</p>
                @endif
                <p class="text-sm text-gray-600">{{ $pesanan->kota->nama_kota ?? '-' }}</p>
            </div>
            <!-- Detail Invoice -->
            <div class="text-right">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Invoice Details</h3>
                <div class="space-y-1 text-sm">
                    <p><span class="text-gray-500">Date:</span> <span class="font-medium">{{ $pesanan->tgl_dibuat->format('d M Y') }}</span></p>
                    <p><span class="text-gray-500">Status:</span> 
                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold
                            @if($pesanan->status_pesanan == 'selesai') bg-green-100 text-green-700
                            @elseif($pesanan->status_pesanan == 'dibatalkan') bg-red-100 text-red-700
                            @else bg-blue-100 text-blue-700
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $pesanan->status_pesanan)) }}
                        </span>
                    </p>
                    @if($pesanan->no_resi)
                        <p><span class="text-gray-500">Resi Number:</span> <span class="font-medium">{{ $pesanan->no_resi }}</span></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="px-8 py-6">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left text-xs font-bold text-gray-500 uppercase tracking-wider pb-3">Product</th>
                        <th class="text-center text-xs font-bold text-gray-500 uppercase tracking-wider pb-3">Qty</th>
                        <th class="text-right text-xs font-bold text-gray-500 uppercase tracking-wider pb-3">Price</th>
                        <th class="text-right text-xs font-bold text-gray-500 uppercase tracking-wider pb-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pesanan->items as $item)
                    <tr>
                        <td class="py-4">
                            <p class="font-medium text-gray-900">{{ $item->produk->nama_produk ?? 'Produk' }}</p>
                            <p class="text-sm text-gray-500">{{ $item->produk->satuan ?? '' }}</p>
                        </td>
                        <td class="py-4 text-center text-gray-600">{{ $item->jumlah }}</td>
                        <td class="py-4 text-right text-gray-600">Rp {{ number_format($item->harga_snapshot, 0, ',', '.') }}</td>
                        <td class="py-4 text-right font-medium text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="px-8 py-6 bg-gray-50 rounded-b-lg">
            <div class="max-w-xs ml-auto space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium">Rp {{ number_format($subtotalPetani, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Shipping</span>
                    <span class="font-medium">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                </div>
                @if($pesanan->diskon > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Discount</span>
                    <span class="font-medium text-red-600">-Rp {{ number_format($pesanan->diskon, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between pt-2 border-t border-gray-200">
                    <span class="font-bold text-gray-900">Total</span>
                    <span class="font-bold text-green-600 text-lg">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="max-w-3xl mx-auto mt-6 text-center text-sm text-gray-500">
        <p>Thank you for shopping at <strong class="text-green-600">Tanami</strong></p>
        <p class="mt-1">This invoice was printed on {{ now()->format('d M Y H:i') }}</p>
    </div>
</body>
</html>
