@extends('layouts.main')
@section('title', 'Inventory Analytics')

@section('content')
<main class="overflow-y-auto p-2 sm:p-4 md:p-8 pt-24 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto w-full">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 px-2">
            <div>
                <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Inventory Analytics</h1>
                <p class="text-[10px] md:text-sm text-indigo-600 font-bold uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-circle text-[6px] md:text-[8px] animate-pulse"></i> Stock & Valuation Insights
                </p>
            </div>
            
            {{-- Filter Form --}}
            <form action="{{ route('reports.medicine') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 bg-white p-4 md:p-5 rounded-[2rem] md:rounded-3xl shadow-xl border border-gray-100 w-full md:w-auto">
                <div class="group flex-grow">
                    <label class="block text-[9px] font-black text-gray-400 uppercase mb-1 ml-1 group-hover:text-indigo-500 transition">Filter by Status</label>
                    <select name="stock_status" class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl text-xs outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-indigo-400 transition-all">
                        <option value="">Full Inventory</option>
                        <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock Alerts</option>
                        <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                        <option value="expired" {{ request('stock_status') == 'expired' ? 'selected' : '' }}>Expired Items</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-black text-xs hover:bg-indigo-700 transition-all active:scale-95 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-arrows-rotate text-[10px]"></i> Sync
                </button>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10 px-2">
            @php
                $summary = [
                    ['Stock Valuation', 'PKR '.number_format($totalStockValue, 0), 'fa-boxes-stacked', 'blue'],
                    ['Potential Revenue', 'PKR '.number_format($potentialRevenue, 0), 'fa-hand-holding-dollar', 'emerald'],
                    ['Low Stock Items', $lowStockCount, 'fa-triangle-exclamation', 'orange'],
                    ['Expired Items', $expiredCount, 'fa-skull-crossbones', 'red'],
                ];
            @endphp
            @foreach($summary as $card)
            <div class="bg-white p-5 md:p-6 rounded-[2rem] shadow-lg border border-gray-50 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-{{ $card[3] }}-50 rounded-full opacity-40"></div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest relative z-10">{{ $card[0] }}</p>
                <h2 class="text-xl md:text-2xl font-black text-gray-900 mt-1 relative z-10 tracking-tighter italic">{{ $card[1] }}</h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[8px] font-black text-{{ $card[3] }}-600 bg-{{ $card[3] }}-50 px-2 py-1 rounded-lg uppercase">Live Count</span>
                    <i class="fa-solid {{ $card[2] }} text-{{ $card[3] }}-200 text-xl"></i>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10 px-2">
            <div class="lg:col-span-2 bg-white p-5 md:p-8 rounded-[2.5rem] shadow-xl border border-gray-50 h-[350px] md:h-[400px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-black text-gray-800 uppercase italic tracking-tighter text-sm md:text-base">Valuation Leaderboard</h3>
                    <span class="text-[9px] font-black text-indigo-500 bg-indigo-50 px-3 py-1 rounded-full uppercase">Top Assets</span>
                </div>
                <div class="h-full pb-10">
                    <canvas id="valuationChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-5 md:p-8 rounded-[2.5rem] shadow-xl border border-gray-50 h-[350px] md:h-[400px]">
                <h3 class="font-black text-gray-800 uppercase italic tracking-tighter mb-4 text-sm md:text-base">Inventory Health</h3>
                <div class="h-full flex items-center justify-center pb-10">
                    <canvas id="healthChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Table/Card Section --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden mb-10 mx-2">
            <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-white gap-4 text-center sm:text-left">
                <div>
                    <h3 class="font-black text-gray-900 uppercase italic text-lg md:text-xl tracking-tighter leading-none">Inventory Audit Log</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 tracking-widest">Real-time Stock Tracking</p>
                </div>
            </div>

            {{-- DESKTOP VIEW: TABLE --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 font-black uppercase text-[10px] tracking-widest border-b border-gray-100">
                            <th class="p-6">Medicine & SKU</th>
                            <th class="p-6">Batch/Expiry</th>
                            <th class="p-6 text-center">Stock</th>
                            <th class="p-6 text-right">Price</th>
                            <th class="p-6 text-right">Total Valuation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($variants as $variant)
                        <tr class="hover:bg-indigo-50/30 transition duration-300">
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-800">{{ $variant->medicine->name }}</span>
                                    <span class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest italic">{{ $variant->sku }}</span>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-gray-600 uppercase">Batch: {{ $variant->batch_no ?? 'N/A' }}</span>
                                    <span class="text-[10px] {{ optional($variant->expiry_date)->isPast() ? 'text-red-500' : 'text-gray-400' }} font-black uppercase">
                                        Exp: {{ optional($variant->expiry_date)->format('d M, Y') ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-4 py-1.5 rounded-xl text-xs font-black ring-1 {{ $variant->stock_level <= $variant->reorder_level ? 'bg-red-50 text-red-600 ring-red-100' : 'bg-emerald-50 text-emerald-600 ring-emerald-100' }} italic">
                                    {{ $variant->stock_level }}
                                </span>
                            </td>
                            <td class="p-6 text-right text-xs font-black text-gray-500 italic">PKR {{ number_format($variant->purchase_price, 2) }}</td>
                            <td class="p-6 text-right font-black text-gray-900 italic tracking-tighter">PKR {{ number_format($variant->stock_level * $variant->purchase_price, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-20 text-center text-gray-400 font-black uppercase text-xs">Zero Manifest Data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- MOBILE VIEW: CARDS --}}
            <div class="lg:hidden p-4 space-y-4">
                @forelse($variants as $variant)
                <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100 space-y-4 {{ $variant->stock_level <= $variant->reorder_level ? 'border-l-4 border-l-red-500' : 'border-l-4 border-l-indigo-500' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-sm font-black text-gray-900 uppercase italic tracking-tight">{{ $variant->medicine->name }}</h4>
                            <span class="text-[9px] font-bold text-indigo-500 uppercase tracking-widest">{{ $variant->sku }}</span>
                        </div>
                        <span class="text-[9px] font-black italic {{ optional($variant->expiry_date)->isPast() ? 'text-red-600' : 'text-gray-400' }}">
                            {{ optional($variant->expiry_date)->format('M y') ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center bg-white p-3 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex flex-col">
                            <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Inventory</span>
                            <span class="text-sm font-black {{ $variant->stock_level <= $variant->reorder_level ? 'text-red-600' : 'text-emerald-600' }} tracking-tighter">{{ $variant->stock_level }} Units</span>
                        </div>
                        <div class="flex flex-col text-right">
                            <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Valuation</span>
                            <span class="text-sm font-black text-gray-900 italic tracking-tighter">PKR {{ number_format($variant->stock_level * $variant->purchase_price, 0) }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-10 text-center text-gray-400 font-black uppercase text-xs">Zero Manifest Data</div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.font.weight = '700';

    // 1. Valuation Leaderboard
    const ctxBar = document.getElementById('valuationChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($variants->sortByDesc(fn($v) => $v->stock_level * $v->purchase_price)->take(10)->map(fn($v) => $v->medicine->name)->values()) !!},
            datasets: [{
                data: {!! json_encode($variants->sortByDesc(fn($v) => $v->stock_level * $v->purchase_price)->take(10)->map(fn($v) => $v->stock_level * $v->purchase_price)->values()) !!},
                backgroundColor: '#4f46e5',
                borderRadius: 10,
                borderSkipped: false,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f3f4f6' }, ticks: { font: { size: 9 } } },
                x: { grid: { display: false }, ticks: { font: { size: 9 } } }
            }
        }
    });

    // 2. Inventory Health
    const ctxDoughnut = document.getElementById('healthChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Healthy', 'Low Stock', 'Expired'],
            datasets: [{
                data: [
                    {{ $variants->where('stock_level', '>', 5)->where('expiry_date', '>', now())->count() }}, 
                    {{ $lowStockCount }}, 
                    {{ $expiredCount }}
                ],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { weight: '900', size: 10 } } }
            }
        }
    });
</script>
@endpush