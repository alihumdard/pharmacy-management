@extends('layouts.main')
@section('title', 'Sales Analytical Report')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 pt-24 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-4xl font-black text-gray-900 uppercase italic tracking-tighter">Sales Analytics</h1>
                <p class="text-sm text-blue-600 font-bold uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-circle text-[8px] animate-pulse"></i> Live Financial Insights
                </p>
            </div>
            
            {{-- Modern Filter Form --}}
            <form action="{{ route('reports.sales') }}" method="GET" class="flex flex-wrap items-end gap-3 bg-white p-5 rounded-3xl shadow-xl border border-gray-100">
                <div class="group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1 group-hover:text-blue-500 transition">From Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="px-4 py-2.5 bg-gray-50 border-none rounded-2xl text-sm outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-400 transition-all">
                </div>
                <div class="group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1 group-hover:text-blue-500 transition">To Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="px-4 py-2.5 bg-gray-50 border-none rounded-2xl text-sm outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-400 transition-all">
                </div>
                <div class="group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1 group-hover:text-blue-500 transition">Status</label>
                    <select name="status" class="px-4 py-2.5 bg-gray-50 border-none rounded-2xl text-sm outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-blue-400 transition-all min-w-[140px]">
                        <option value="">All Transactions</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Partial" {{ request('status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-2xl font-black text-sm hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-200 transition-all active:scale-95">
                    <i class="fa-solid fa-arrows-rotate mr-2"></i> Sync
                </button>
            </form>
        </div>

        {{-- Summary Cards with Trend Indicators --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            @php
                $cards = [
                    ['Total Revenue', 'PKR '.number_format($totalRevenue, 0), 'fa-chart-line', 'blue'],
                    ['Cash In Hand', 'PKR '.number_format($cashReceived, 0), 'fa-wallet', 'emerald'],
                    ['Debt/Credit', 'PKR '.number_format($remainingDebt, 0), 'fa-hand-holding-dollar', 'red'],
                    ['Total Orders', $totalSalesCount, 'fa-file-invoice', 'indigo'],
                ];
            @endphp

            @foreach($cards as $card)
            <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-gray-50 relative overflow-hidden group hover:scale-105 transition-transform duration-300">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-{{ $card[3] }}-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest relative z-10">{{ $card[0] }}</p>
                <h2 class="text-2xl font-black text-gray-900 mt-2 relative z-10">{{ $card[1] }}</h2>
                <div class="mt-4 flex items-center justify-between relative z-10">
                    <span class="text-[10px] font-bold text-{{ $card[3] }}-600 bg-{{ $card[3] }}-50 px-2 py-1 rounded-lg">Performance Stable</span>
                    <i class="fa-solid {{ $card[2] }} text-{{ $card[3] }}-200 text-2xl"></i>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Charts Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            {{-- Line Chart --}}
            <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-50">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-black text-gray-800 uppercase italic tracking-tighter">Revenue Trajectory</h3>
                    <span class="text-[10px] font-black text-blue-500 bg-blue-50 px-3 py-1 rounded-full uppercase">Daily Trend</span>
                </div>
                <div class="h-[300px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- Pie Chart --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-50">
                <h3 class="font-black text-gray-800 uppercase italic tracking-tighter mb-6">Payment Status</h3>
                <div class="h-[300px] flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Sales Table --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden mb-10">
            <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-white">
                <div>
                    <h3 class="font-black text-gray-900 uppercase italic text-xl tracking-tighter">Transaction Audit Log</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase mt-1">Verified Sales Records</p>
                </div>
                <button onclick="window.print()" class="bg-gray-900 text-white px-5 py-2.5 rounded-2xl font-bold text-xs hover:bg-black transition-all shadow-lg shadow-gray-200">
                    <i class="fa-solid fa-print mr-2"></i> Export PDF
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-400 font-black uppercase text-[10px] tracking-widest">
                            <th class="p-6">Timeline</th>
                            <th class="p-6">Invoice Reference</th>
                            <th class="p-6">Beneficiary</th>
                            <th class="p-6 text-right">Settlement Amount</th>
                            <th class="p-6 text-center">Verification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($sales as $sale)
                        <tr class="hover:bg-blue-50/30 transition duration-300 group">
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M, Y') }}</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase">{{ \Carbon\Carbon::parse($sale->sale_date)->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td class="p-6">
                                <span class="bg-blue-50 text-blue-700 px-4 py-2 rounded-xl text-xs font-black ring-1 ring-blue-100">
                                    #{{ $sale->invoice_number }}
                                </span>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-black text-gray-500 uppercase italic">
                                        {{ substr($sale->customer->customer_name ?? 'W', 0, 1) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-700">{{ $sale->customer->customer_name ?? 'Walk-in' }}</span>
                                </div>
                            </td>
                            <td class="p-6 text-right">
                                <span class="text-base font-black text-gray-900 italic">PKR {{ number_format($sale->total_amount, 2) }}</span>
                            </td>
                            <td class="p-6 text-center">
                                @if($sale->status == 'Completed')
                                    <span class="text-[10px] font-black uppercase text-emerald-600 bg-emerald-50 px-4 py-1.5 rounded-full border border-emerald-100 italic">Settled</span>
                                @else
                                    <span class="text-[10px] font-black uppercase text-orange-600 bg-orange-50 px-4 py-1.5 rounded-full border border-orange-100 italic">Due</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <i class="fa-solid fa-folder-open text-4xl text-gray-200 mb-4 block"></i>
                                <span class="text-gray-400 italic font-bold uppercase tracking-widest text-xs">Zero records found for selected period</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Revenue Trajectory (Line Chart)
    const ctxLine = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->keys()) !!},
            datasets: [{
                label: 'Daily Revenue',
                data: {!! json_encode($chartData->values()) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 4,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
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
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { weight: 'black', size: 10 } } }
            }
        }
    });
</script>
@endpush