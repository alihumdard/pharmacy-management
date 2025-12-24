@extends('layouts.main')
@section('title', 'Sales Analytical Report')

@section('content')
<main class="overflow-y-auto p-2 sm:p-4 md:p-8 pt-24 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 px-2">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-gray-900 uppercase tracking-tighter">Sales Analytics</h1>
                <p class="text-[10px] md:text-sm text-blue-600 font-bold uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-circle text-[6px] md:text-[8px] animate-pulse"></i> Live Financial Insights
                </p>
            </div>
            
            {{-- Modern Filter Form --}}
            <form action="{{ route('reports.sales') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3 bg-white p-4 md:p-5 rounded-[2rem] md:rounded-3xl shadow-xl border border-gray-100 w-full md:w-auto">
                <div class="grid grid-cols-2 sm:flex gap-3">
                    <div class="group">
                        <label class="block text-[9px] font-black text-gray-400 uppercase mb-1 ml-1">From</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3 py-2 bg-gray-50 border-none rounded-xl text-xs outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="group">
                        <label class="block text-[9px] font-black text-gray-400 uppercase mb-1 ml-1">To</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3 py-2 bg-gray-50 border-none rounded-xl text-xs outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
                <div class="flex gap-2">
                    <select name="status" class="flex-1 px-3 py-2 bg-gray-50 border-none rounded-xl text-xs outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-400">
                        <option value="">All Status</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Partial" {{ request('status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-xl font-black text-xs hover:bg-blue-700 transition-all active:scale-95 flex items-center gap-2">
                        <i class="fa-solid fa-arrows-rotate text-[10px]"></i> <span class="sm:hidden lg:inline">Sync</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10 px-2">
            @php
                $cards = [
                    ['Total Revenue', 'PKR '.number_format($totalRevenue, 0), 'fa-chart-line', 'blue'],
                    ['Cash In Hand', 'PKR '.number_format($cashReceived, 0), 'fa-wallet', 'emerald'],
                    ['Debt/Credit', 'PKR '.number_format($remainingDebt, 0), 'fa-hand-holding-dollar', 'red'],
                    ['Total Orders', $totalSalesCount, 'fa-file-invoice', 'indigo'],
                ];
            @endphp

            @foreach($cards as $card)
            <div class="bg-white p-5 md:p-6 rounded-[2rem] shadow-lg border border-gray-50 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-{{ $card[3] }}-50 rounded-full opacity-40"></div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest relative z-10">{{ $card[0] }}</p>
                <h2 class="text-xl md:text-2xl font-black text-gray-900 mt-1 relative z-10 tracking-tighter italic">{{ $card[1] }}</h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[8px] font-black text-{{ $card[3] }}-600 bg-{{ $card[3] }}-50 px-2 py-1 rounded-lg uppercase">System Verified</span>
                    <i class="fa-solid {{ $card[2] }} text-{{ $card[3] }}-200 text-xl"></i>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10 px-2">
            <div class="lg:col-span-2 bg-white p-5 md:p-8 rounded-[2.5rem] shadow-xl border border-gray-50 h-[350px] md:h-[400px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-black text-gray-800 uppercase italic tracking-tighter text-sm md:text-base">Revenue Trajectory</h3>
                    <span class="text-[9px] font-black text-blue-500 bg-blue-50 px-3 py-1 rounded-full uppercase">Timeline</span>
                </div>
                <div class="h-full pb-10">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-5 md:p-8 rounded-[2.5rem] shadow-xl border border-gray-50 h-[350px] md:h-[400px]">
                <h3 class="font-black text-gray-800 uppercase italic tracking-tighter mb-4 text-sm md:text-base">Settlement Status</h3>
                <div class="h-full flex items-center justify-center pb-10">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Transaction List --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden mb-10 mx-2">
            <div class="p-6 md:p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-white gap-4 text-center sm:text-left">
                <div>
                    <h3 class="font-black text-gray-900 uppercase italic text-lg md:text-xl tracking-tighter leading-none">Audit Journal</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1 tracking-widest">Verified Sales Records</p>
                </div>
            </div>

            {{-- DESKTOP VIEW: TABLE --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 font-black uppercase text-[10px] tracking-widest border-b border-gray-100">
                            <th class="p-6">Timeline</th>
                            <th class="p-6">Invoice #</th>
                            <th class="p-6">Beneficiary</th>
                            <th class="p-6 text-right">Settlement Amount</th>
                            <th class="p-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($sales as $sale)
                        <tr class="hover:bg-blue-50/30 transition duration-300">
                            <td class="p-6 font-black text-gray-800 text-sm italic">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y') }}</td>
                            <td class="p-6"><span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-[10px] font-black italic">#{{ $sale->invoice_number }}</span></td>
                            <td class="p-6 font-bold text-gray-700 text-sm">{{ $sale->customer->customer_name ?? 'Walk-in' }}</td>
                            <td class="p-6 text-right font-black text-gray-900 italic tracking-tight">PKR {{ number_format($sale->total_amount, 2) }}</td>
                            <td class="p-6 text-center">
                                <span class="text-[9px] font-black uppercase {{ $sale->status == 'Completed' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-orange-600 bg-orange-50 border-orange-100' }} px-4 py-1.5 rounded-full border italic">
                                    {{ $sale->status == 'Completed' ? 'Settled' : 'Due' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-20 text-center text-gray-400 font-bold uppercase italic tracking-widest text-xs">No Records Found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- MOBILE VIEW: CARDS --}}
            <div class="lg:hidden p-4 space-y-4">
                @forelse($sales as $sale)
                <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[9px] font-black text-gray-400 uppercase block leading-none mb-1">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y | h:i A') }}</span>
                            <h4 class="text-sm font-black text-gray-900 uppercase italic">#{{ $sale->invoice_number }}</h4>
                        </div>
                        <span class="text-[8px] font-black uppercase {{ $sale->status == 'Completed' ? 'text-emerald-600 bg-emerald-50' : 'text-orange-600 bg-orange-50' }} px-3 py-1 rounded-full border border-current italic">
                            {{ $sale->status == 'Completed' ? 'Settled' : 'Due' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-end border-t border-gray-100 pt-3">
                        <div class="text-[10px] font-bold text-gray-500 uppercase">{{ $sale->customer->customer_name ?? 'Walk-in' }}</div>
                        <div class="text-base font-black text-gray-900 italic tracking-tighter">PKR {{ number_format($sale->total_amount, 0) }}</div>
                    </div>
                </div>
                @empty
                <div class="py-10 text-center text-gray-400 font-bold uppercase italic tracking-widest text-xs">No Records Found</div>
                @endforelse
            </div>
        </div>
    </div>
</main>

{{-- DIAGRAM: Revenue vs Payment Status Logic --}}
{{--  --}}

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Config Chart Defaults
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.font.weight = '700';

    // 1. Revenue Trajectory (Line Chart)
    const ctxLine = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->keys()) !!},
            datasets: [{
                data: {!! json_encode($chartData->values()) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.05)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563eb',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { font: { size: 9 } } },
                x: { grid: { display: false }, ticks: { font: { size: 9 } } }
            }
        }
    });

    // 2. Status Distribution (Pie Chart)
    const ctxPie = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Settled', 'Due'],
            datasets: [{
                data: [
                    {{ $sales->where('status', 'Completed')->count() }}, 
                    {{ $sales->where('status', 'Partial')->count() }}
                ],
                backgroundColor: ['#10b981', '#f59e0b'],
                borderWidth: 0,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { 
                    position: 'bottom', 
                    labels: { 
                        usePointStyle: true, 
                        padding: 20, 
                        font: { size: 10, weight: '900' },
                        boxWidth: 6
                    } 
                }
            }
        }
    });
</script>
@endpush