@extends('layouts.main')
@section('title', 'Executive Dashboard')

@section('content')
<main class="overflow-y-auto p-6 md:p-8 pt-16 bg-gray-50 min-h-screen antialiased">
    <div class="max-w-[1600px] mx-auto space-y-10">

        {{-- Header --}}
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                Pharmacy Overview
            </h1>
            <p class="text-gray-500 mt-1">
                Real-time performance metrics · {{ now()->format('d M, Y h:i A') }}
            </p>
        </div>

        {{-- ================= STATS ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Today Sales --}}
            <div class="relative bg-white rounded-3xl p-6 shadow-[0_10px_40px_-15px_rgba(0,0,0,0.2)]
                        hover:-translate-y-1 hover:shadow-[0_20px_50px_-15px_rgba(0,0,0,0.3)]
                        transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-t-3xl"></div>

                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-500 uppercase">Today’s Sales</p>
                        <h2 class="text-2xl font-extrabold text-gray-900">
                            PKR {{ number_format($todaySales ?? 0) }}
                        </h2>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between border-t pt-3">
                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold rounded-full
                        {{ ($percentageIncrease ?? 0) >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <i class="fa-solid fa-arrow-{{ ($percentageIncrease ?? 0) >= 0 ? 'up' : 'down' }} mr-1"></i>
                        {{ number_format(abs($percentageIncrease ?? 0),1) }}%
                    </span>
                    <span class="text-xs text-gray-400">vs yesterday</span>
                </div>
            </div>

            {{-- Low Stock --}}
            <div class="relative bg-white rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-600 to-red-400 rounded-t-3xl"></div>

                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-500 uppercase">Low Stock</p>
                        <h2 class="text-3xl font-extrabold text-gray-900">
                            {{ $lowStockCount ?? 0 }}
                        </h2>
                    </div>
                </div>

                <a href="{{ route('medicines.index') }}"
                   class="mt-4 text-xs font-semibold text-red-600 flex justify-between border-t pt-3 hover:underline">
                    Action Required
                    <span class="text-gray-400">View Inventory</span>
                </a>
            </div>

            {{-- Expiring --}}
            <div class="relative bg-white rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-amber-300 rounded-t-3xl"></div>

                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-hourglass-start text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-500 uppercase">Expiring Soon</p>
                        <h2 class="text-3xl font-extrabold text-gray-900">
                            {{ $expiringCount ?? 0 }}
                        </h2>
                    </div>
                </div>

                <p class="mt-4 text-xs text-gray-500 border-t pt-3 flex justify-between">
                    Next 30 days <span>Review</span>
                </p>
            </div>

            {{-- Credit --}}
            <div class="relative bg-white rounded-3xl p-6 shadow-xl hover:-translate-y-1 transition">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-600 to-emerald-400 rounded-t-3xl"></div>

                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-sack-dollar text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-500 uppercase">Total Credit</p>
                        <h2 class="text-2xl font-extrabold text-gray-900">
                            PKR {{ number_format($totalCreditDue ?? 0) }}
                        </h2>
                    </div>
                </div>

                <a href="{{ route('customers.index') }}"
                   class="mt-4 text-xs text-gray-600 border-t pt-3 flex justify-between hover:underline">
                    Collect Now <span>Accounts</span>
                </a>
            </div>

        </div>

        {{-- ================= CHARTS ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Revenue --}}
            <div class="lg:col-span-2 bg-gradient-to-br from-white to-blue-50/40 rounded-3xl p-6 shadow-xl">
                <div class="flex justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-blue-600"></i> Revenue Trend
                    </h2>
                    <span class="text-xs text-gray-400 font-bold uppercase">Last 30 Days</span>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <p class="text-xs text-gray-500">Avg Daily</p>
                        <p class="font-bold text-gray-900">PKR {{ number_format($avgDaily ?? 0) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Best Day</p>
                        <p class="font-bold text-green-600">PKR {{ number_format($bestDay ?? 0) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Lowest Day</p>
                        <p class="font-bold text-red-600">PKR {{ number_format($lowestDay ?? 0) }}</p>
                    </div>
                </div>

                <div class="min-h-[350px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fa-solid fa-ranking-star text-amber-500 mr-1"></i> Top Products
                </h2>

                <table class="w-full">
                    <tbody class="divide-y">
                        @foreach($topSelling ?? [] as $item)
                        <tr>
                            <td class="py-3 flex items-center gap-3">
                                <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 text-xs font-black flex items-center justify-center">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="font-semibold text-sm text-gray-800">
                                    {{ $item->name }}
                                </span>
                            </td>
                            <td class="py-3 text-right">
                                <p class="text-sm font-extrabold text-blue-600">
                                    PKR {{ number_format($item->revenue) }}
                                </p>
                                <p class="text-[10px] text-gray-400 uppercase font-bold">
                                    {{ $item->units }} sold
                                </p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ================= BOTTOM ================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Inventory --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl relative">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fa-solid fa-chart-pie text-emerald-500 mr-1"></i> Inventory Value
                </h2>

                <div class="relative min-h-[300px] flex items-center justify-center">
                    <canvas id="inventoryChart"></canvas>
                    <div class="absolute text-center">
                        {{-- <p class="text-xs text-gray-500">Total Inventory</p> --}}
                        <p class="text-2xl font-extrabold text-gray-900">
                            PKR {{ number_format($totalInventoryValue ?? 0) }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Activity --}}
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-xl">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Activity</h2>

                <ul class="space-y-4">
                    <li class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fa-solid fa-circle-check text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Dashboard Loaded Successfully</p>
                            <p class="text-xs text-gray-500">Just now</p>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const salesTrendData = {!! json_encode($salesTrend ?? []) !!};

new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: salesTrendData.map(d => d.date),
        datasets: [{
            data: salesTrendData.map(d => d.total),
            borderColor: '#2563eb',
            borderWidth: 4,
            fill: true,
            tension: .4,
            pointRadius: 0,
            backgroundColor: ctx => {
                const g = ctx.chart.ctx.createLinearGradient(0,0,0,300);
                g.addColorStop(0,'rgba(37,99,235,.4)');
                g.addColorStop(1,'rgba(37,99,235,0)');
                return g;
            }
        }]
    },
    options: { responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}} }
});

const categoryData = {!! json_encode($categoryBreakdown ?? []) !!};

new Chart(document.getElementById('inventoryChart'), {
    type:'doughnut',
    data:{
        labels:categoryData.map(d=>d.category),
        datasets:[{
            data:categoryData.map(d=>d.value),
            backgroundColor:['#2563eb','#10b981','#f59e0b','#8b5cf6','#ec4899'],
            borderWidth:8,
            borderColor:'#fff'
        }]
    },
    options:{cutout:'78%', plugins:{legend:{position:'bottom'}}}
});
</script>
@endpush
