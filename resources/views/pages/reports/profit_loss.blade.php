@extends('layouts.main')
@section('title', 'Profit & Loss Statement')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 pt-24 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter">P&L Statement</h1>
                <p class="text-sm text-emerald-600 font-bold uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-circle text-[8px] animate-pulse"></i> Net Income Analysis
                </p>
            </div>
            
            <form action="{{ route('reports.profit_loss') }}" method="GET" class="flex flex-wrap items-end gap-3 bg-white p-5 rounded-3xl shadow-xl border border-gray-100">
                <div class="group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">From Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="px-4 py-2.5 bg-gray-50 border-none rounded-2xl text-sm outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-emerald-400 transition-all">
                </div>
                <div class="group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 ml-1">To Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="px-4 py-2.5 bg-gray-50 border-none rounded-2xl text-sm outline-none ring-1 ring-gray-200 focus:ring-2 focus:ring-emerald-400 transition-all">
                </div>
                <button type="submit" class="bg-emerald-600 text-white px-6 py-2.5 rounded-2xl font-black text-sm hover:bg-emerald-700 transition-all">
                    <i class="fa-solid fa-calculator mr-2"></i> Calculate
                </button>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <x-report-card title="Total Revenue" value="PKR {{ number_format($totalRevenue) }}" icon="fa-money-bill-trend-up" color="blue" />
            <x-report-card title="Cost of Goods" value="PKR {{ number_format($totalCost) }}" icon="fa-tags" color="orange" />
            <x-report-card title="Gross Profit" value="PKR {{ number_format($grossProfit) }}" icon="fa-sack-dollar" color="emerald" />
            <x-report-card title="Net Margin" value="{{ number_format($profitMargin, 1) }}%" icon="fa-chart-pie" color="indigo" />
        </div>

        {{-- Profit Trend Chart --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-50 mb-10">
            <h3 class="font-black text-gray-800 uppercase italic tracking-tighter mb-6">Daily Profit Growth</h3>
            <div class="h-[350px]">
                <canvas id="profitTrendChart"></canvas>
            </div>
        </div>

        {{-- Simplified Ledger --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-100">
                <h3 class="font-black text-gray-900 uppercase italic text-xl tracking-tighter">Financial Summary</h3>
            </div>
            <div class="p-8 space-y-4">
                <div class="flex justify-between items-center text-lg font-bold text-gray-600">
                    <span>Total Sales (Tax/Charges Included)</span>
                    <span class="text-gray-900">PKR {{ number_format($totalRevenue, 2) }}</span>
                </div>
                <div class="flex justify-between items-center text-lg font-bold text-red-500">
                    <span>Total Cost of Inventory Sold</span>
                    <span>- PKR {{ number_format($totalCost, 2) }}</span>
                </div>
                <div class="border-t-2 border-dashed pt-4 flex justify-between items-center text-2xl font-black text-emerald-600">
                    <span class="italic uppercase tracking-tighter">Gross Income</span>
                    <span>PKR {{ number_format($grossProfit, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('profitTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->keys()) !!},
            datasets: [{
                label: 'Net Profit',
                data: {!! json_encode($chartData->values()) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                pointRadius: 6,
                pointBackgroundColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { borderDash: [5, 5] } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush