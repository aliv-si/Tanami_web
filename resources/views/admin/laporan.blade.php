@extends('layouts.admin')

@section('title', 'Laporan Bisnis')
@section('header_title', 'Laporan Bisnis')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="max-w-[1400px] mx-auto w-full space-y-6">

    {{-- Filter Toolbar --}}
    <form method="GET" class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
        <div class="flex flex-wrap items-center gap-3">
            <select name="tipe" onchange="this.form.submit()" class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm font-semibold focus:ring-primary focus:border-primary">
                <option value="penjualan" @selected($tipe=='penjualan')>📊 Penjualan</option>
                <option value="produk" @selected($tipe=='produk')>📦 Produk</option>
                <option value="petani" @selected($tipe=='petani')>🌾 Petani</option>
                <option value="pembeli" @selected($tipe=='pembeli')>👥 Pembeli</option>
            </select>
            <div class="flex items-center gap-2">
                <input type="date" name="dari" value="{{ $dari }}" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary" />
                <span class="text-gray-400">—</span>
                <input type="date" name="sampai" value="{{ $sampai }}" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary" />
            </div>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined text-sm align-middle mr-1">filter_alt</span>Filter
            </button>
        </div>
    </form>

    @if($tipe == 'penjualan')
    {{-- PENJUALAN Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">GMV (Gross)</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">Rp {{ number_format($data['summary']['gmv'], 0, ',', '.') }}</h3>
            <span class="text-xs {{ $data['summary']['gmv_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $data['summary']['gmv_growth'] >= 0 ? '↑' : '↓' }} {{ abs($data['summary']['gmv_growth']) }}%
            </span>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Pesanan Selesai</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ number_format($data['summary']['pesanan_selesai']) }}</h3>
            <span class="text-xs {{ $data['summary']['pesanan_growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $data['summary']['pesanan_growth'] >= 0 ? '↑' : '↓' }} {{ abs($data['summary']['pesanan_growth']) }}%
            </span>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Conversion Rate</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ $data['summary']['conversion_rate'] }}%</h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Avg Order Value</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">Rp {{ number_format($data['summary']['aov'], 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-heading font-bold text-[#1e3f1b] mb-4">Trend Penjualan Harian</h3>
        <canvas id="salesChart" height="100"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100"><h3 class="font-heading font-bold text-[#1e3f1b]">Detail Harian</h3></div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr><th class="px-6 py-3 text-left">Tanggal</th><th class="px-6 py-3 text-right">Pesanan</th><th class="px-6 py-3 text-right">Selesai</th><th class="px-6 py-3 text-right">Batal</th><th class="px-6 py-3 text-right">Penjualan</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($data['daily'] as $day)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium">{{ \Carbon\Carbon::parse($day->tanggal)->format('d M Y') }}</td>
                        <td class="px-6 py-3 text-right">{{ $day->jumlah_pesanan }}</td>
                        <td class="px-6 py-3 text-right text-green-600">{{ $day->pesanan_selesai }}</td>
                        <td class="px-6 py-3 text-right text-red-600">{{ $day->pesanan_batal }}</td>
                        <td class="px-6 py-3 text-right font-semibold">Rp {{ number_format($day->total_penjualan, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @elseif($tipe == 'produk')
    {{-- PRODUK Summary --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Total Produk Terjual</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ number_format($data['summary']['total_produk_terjual']) }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Total Pendapatan</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">Rp {{ number_format($data['summary']['total_pendapatan'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Produk Unik</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ $data['summary']['unique_produk'] }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-heading font-bold text-[#1e3f1b] mb-4">Penjualan per Kategori</h3>
        <canvas id="categoryChart" height="80"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100"><h3 class="font-heading font-bold text-[#1e3f1b]">Top 20 Produk Terlaris</h3></div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr><th class="px-6 py-3 text-left">#</th><th class="px-6 py-3 text-left">Produk</th><th class="px-6 py-3 text-left">Kategori</th><th class="px-6 py-3 text-right">Terjual</th><th class="px-6 py-3 text-right">Pendapatan</th><th class="px-6 py-3 text-right">Rating</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($data['topProducts'] as $i => $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-6 py-3 font-medium">{{ $product->nama_produk }}</td>
                        <td class="px-6 py-3"><span class="px-2 py-1 bg-gray-100 rounded text-xs">{{ $product->nama_kategori }}</span></td>
                        <td class="px-6 py-3 text-right">{{ number_format($product->total_terjual) }}</td>
                        <td class="px-6 py-3 text-right font-semibold">Rp {{ number_format($product->total_pendapatan, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-right">@if($product->avg_rating)<span class="text-yellow-500">★</span> {{ $product->avg_rating }}@else<span class="text-gray-300">-</span>@endif</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @elseif($tipe == 'petani')
    {{-- PETANI Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Total Petani Verified</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ $data['summary']['total_petani'] }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Petani Aktif</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ $data['summary']['petani_aktif'] }}</h3>
            <span class="text-xs text-gray-400">{{ $data['summary']['persentase_aktif'] }}%</span>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Escrow Dikirim</p>
            <h3 class="text-xl font-bold text-green-600 font-heading">Rp {{ number_format($data['escrowSummary']['total_dikirim'], 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Escrow Ditahan</p>
            <h3 class="text-xl font-bold text-yellow-600 font-heading">Rp {{ number_format($data['escrowSummary']['escrow_ditahan'], 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-heading font-bold text-[#1e3f1b] mb-4">Top 10 Petani</h3>
        <canvas id="petaniChart" height="100"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100"><h3 class="font-heading font-bold text-[#1e3f1b]">Top 20 Petani</h3></div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr><th class="px-6 py-3 text-left">#</th><th class="px-6 py-3 text-left">Nama</th><th class="px-6 py-3 text-right">Pesanan</th><th class="px-6 py-3 text-right">Produk</th><th class="px-6 py-3 text-right">Total</th><th class="px-6 py-3 text-right">Rating</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($data['topPetani'] as $i => $petani)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-6 py-3"><p class="font-medium">{{ $petani->nama_lengkap }}</p><p class="text-xs text-gray-400">{{ $petani->email }}</p></td>
                        <td class="px-6 py-3 text-right">{{ $petani->jumlah_pesanan }}</td>
                        <td class="px-6 py-3 text-right">{{ $petani->jumlah_produk_terjual }}</td>
                        <td class="px-6 py-3 text-right font-semibold">Rp {{ number_format($petani->total_penjualan, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-right">@if($petani->avg_rating)<span class="text-yellow-500">★</span> {{ $petani->avg_rating }}@else<span class="text-gray-300">-</span>@endif</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @elseif($tipe == 'pembeli')
    {{-- PEMBELI Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">User Baru</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ $data['newUsers']['total'] }}</h3>
            <span class="text-xs text-gray-400">{{ $data['newUsers']['pembeli'] }} pembeli, {{ $data['newUsers']['petani'] }} petani</span>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Unique Buyers</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ $data['retention']['unique_buyers'] }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">Repeat Rate</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ $data['retention']['repeat_rate'] }}%</h3>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 font-medium mb-1">First Time Buyers</p>
            <h3 class="text-xl font-bold text-[#1e3f1b] font-heading">{{ $data['retention']['first_time_buyers'] }}</h3>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-heading font-bold text-[#1e3f1b] mb-4">User Baru</h3>
        <div class="max-w-xs mx-auto"><canvas id="userChart" height="200"></canvas></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100"><h3 class="font-heading font-bold text-[#1e3f1b]">Top 20 Pembeli</h3></div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr><th class="px-6 py-3 text-left">#</th><th class="px-6 py-3 text-left">Nama</th><th class="px-6 py-3 text-right">Pesanan</th><th class="px-6 py-3 text-right">Total</th><th class="px-6 py-3 text-right">AOV</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($data['topBuyers'] as $i => $buyer)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-6 py-3"><p class="font-medium">{{ $buyer->pembeli->nama_lengkap ?? '-' }}</p><p class="text-xs text-gray-400">{{ $buyer->pembeli->email ?? '-' }}</p></td>
                        <td class="px-6 py-3 text-right">{{ $buyer->jumlah_pesanan }}</td>
                        <td class="px-6 py-3 text-right font-semibold">Rp {{ number_format($buyer->total_belanja, 0, ',', '.') }}</td>
                        <td class="px-6 py-3 text-right text-gray-500">Rp {{ number_format($buyer->avg_order_value, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@php
$chartLabels = [];
$chartValues = [];
$chartExtra = [];
if ($tipe == 'penjualan' && isset($data['daily'])) {
    $chartLabels = $data['daily']->pluck('tanggal')->toArray();
    $chartValues = $data['daily']->pluck('total_penjualan')->toArray();
} elseif ($tipe == 'produk' && isset($data['categoryBreakdown'])) {
    $chartLabels = $data['categoryBreakdown']->pluck('nama_kategori')->toArray();
    $chartValues = $data['categoryBreakdown']->pluck('total_pendapatan')->toArray();
} elseif ($tipe == 'petani' && isset($data['topPetani'])) {
    $chartLabels = $data['topPetani']->take(10)->pluck('nama_lengkap')->toArray();
    $chartValues = $data['topPetani']->take(10)->pluck('total_penjualan')->toArray();
} elseif ($tipe == 'pembeli' && isset($data['newUsers'])) {
    $chartExtra = ['pembeli' => $data['newUsers']['pembeli'] ?? 0, 'petani' => $data['newUsers']['petani'] ?? 0];
}
@endphp

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var primaryColor = '#53be20';
    var primaryLight = 'rgba(83, 190, 32, 0.1)';
    var chartLabels = @json($chartLabels);
    var chartValues = @json($chartValues);
    var chartExtra = @json($chartExtra);
    var tipe = '{{ $tipe }}';

    if (tipe === 'penjualan' && document.getElementById('salesChart')) {
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: chartLabels.map(function(d) { return new Date(d).toLocaleDateString('id-ID', {day:'numeric',month:'short'}); }),
                datasets: [{label:'Penjualan',data:chartValues,borderColor:primaryColor,backgroundColor:primaryLight,fill:true,tension:0.3}]
            },
            options: {responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{callback:function(v){return 'Rp '+v.toLocaleString('id-ID');}}}}}
        });
    }
    if (tipe === 'produk' && document.getElementById('categoryChart')) {
        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {labels:chartLabels,datasets:[{label:'Pendapatan',data:chartValues,backgroundColor:primaryColor}]},
            options: {indexAxis:'y',responsive:true,plugins:{legend:{display:false}},scales:{x:{ticks:{callback:function(v){return 'Rp '+(v/1000000).toFixed(1)+'jt';}}}}}
        });
    }
    if (tipe === 'petani' && document.getElementById('petaniChart')) {
        new Chart(document.getElementById('petaniChart'), {
            type: 'bar',
            data: {labels:chartLabels,datasets:[{label:'Penjualan',data:chartValues,backgroundColor:primaryColor}]},
            options: {indexAxis:'y',responsive:true,plugins:{legend:{display:false}},scales:{x:{ticks:{callback:function(v){return 'Rp '+(v/1000000).toFixed(1)+'jt';}}}}}
        });
    }
    if (tipe === 'pembeli' && document.getElementById('userChart')) {
        new Chart(document.getElementById('userChart'), {
            type: 'doughnut',
            data: {labels:['Pembeli','Petani'],datasets:[{data:[chartExtra.pembeli||0,chartExtra.petani||0],backgroundColor:[primaryColor,'#4299e1']}]},
            options: {responsive:true,plugins:{legend:{position:'bottom'}}}
        });
    }
});
</script>
@endpush    