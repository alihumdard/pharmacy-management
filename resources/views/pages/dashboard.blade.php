@extends('layouts.main')
@section('title', 'Executive Dashboard')

@section('content')
<main class="overflow-y-auto p-6 md:p-8 pt-16 bg-gray-50 min-h-screen">
    <div class="max-w-[1600px] mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pharmacy Overview</h1>
        <p class="text-gray-500 mb-8">Real-time performance metrics as of {{ now()->format('d M, Y h:i A') }}</p>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="p-6 overflow-hidden rounded-xl border border-blue-50 bg-white shadow-xl relative group">
                <div class="absolute -left-12 -top-12 w-28 h-28 rounded-full bg-blue-100 opacity-30 transition duration-500 group-hover:opacity-40"></div>
                <div class="flex items-center justify-between z-10 relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 shadow-md">
                        <i class="fa-solid fa-cart-shopping text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Today's Sales</p>
                        <h2 class="text-2xl font-extrabold text-gray-900">PKR {{ number_format($todaySales, 0) }}</h2>
                    </div>
                </div>
                <p class="text-xs font-semibold {{ $percentageIncrease >= 0 ? 'text-green-600' : 'text-red-600' }} mt-5 pt-3 border-t border-gray-100 flex items-center">
                    <i class="fa-solid fa-arrow-{{ $percentageIncrease >= 0 ? 'up' : 'down' }} mr-1"></i> 
                    {{ number_format(abs($percentageIncrease), 1) }}% 
                    <span class="text-gray-400 ml-auto font-normal">vs yesterday</span>
                </p>
            </div>

            <div class="p-6 overflow-hidden rounded-xl border border-red-50 bg-white shadow-xl relative group">
                <div class="absolute -left-12 -top-12 w-28 h-28 rounded-full bg-red-100 opacity-30 transition duration-500 group-hover:opacity-40"></div>
                <div class="flex items-center justify-between z-10 relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-red-50 text-red-600 shadow-md">
                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Low Stock Items</p>
                        <h2 class="text-4xl font-extrabold text-gray-900">{{ $lowStockCount }}</h2>
                    </div>
                </div>
                <a href="{{ route('medicines.index') }}" class="text-xs font-semibold text-red-600 mt-5 pt-3 border-t border-gray-100 flex items-center hover:underline">
                    <i class="fa-solid fa-bell mr-1"></i> Action Required
                    <span class="text-gray-400 ml-auto font-normal">Check Inventory</span>
                </a>
            </div>

            <div class="p-6 overflow-hidden rounded-xl border border-amber-50 bg-white shadow-xl relative group">
                 <div class="absolute -left-12 -top-12 w-28 h-28 rounded-full bg-amber-100 opacity-30 transition duration-500 group-hover:opacity-40"></div>
                <div class="flex items-center justify-between z-10 relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-amber-50 text-amber-600 shadow-md">
                        <i class="fa-solid fa-hourglass-start text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Expiring Batches</p>
                        <h2 class="text-4xl font-extrabold text-gray-900">{{ $expiringCount }}</h2>
                    </div>
                </div>
                <p class="text-xs font-semibold text-gray-600 mt-5 pt-3 border-t border-gray-100 flex items-center">
                    <i class="fa-solid fa-calendar-alt text-gray-500 mr-1"></i> Next 30 days
                    <span class="text-gray-400 ml-auto font-normal">Review list</span>
                </p>
            </div>

            <div class="p-6 overflow-hidden rounded-xl border border-emerald-50 bg-white shadow-xl relative group">
                <div class="absolute -left-12 -top-12 w-28 h-28 rounded-full bg-emerald-100 opacity-30 transition duration-500 group-hover:opacity-40"></div>
                <div class="flex items-center justify-between z-10 relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full bg-emerald-50 text-emerald-600 shadow-md">
                        <i class="fa-solid fa-sack-dollar text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Total Credit</p>
                        <h2 class="text-2xl font-extrabold text-gray-900">PKR {{ number_format($totalCreditDue, 0) }}</h2>
                    </div>
                </div>
                <a href="{{ route('customers.index') }}" class="text-xs font-semibold text-gray-600 mt-5 pt-3 border-t border-gray-100 flex items-center hover:underline">
                    <i class="fa-solid fa-clock text-gray-500 mr-1"></i> Collect Now
                    <span class="text-gray-400 ml-auto font-normal">View Accounts</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            {{-- Revenue Trend Chart --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl border border-gray-100 p-6 flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-blue-500"></i> Revenue Trend
                    </h2>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest tracking-widest">Last 30 Days</span>
                </div>
                <div class="flex-grow min-h-[400px] w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-xl border border-gray-100 p-6 h-full flex flex-col">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-ranking-star text-amber-500"></i> Top Products
                </h2>
                <div class="flex-grow overflow-y-auto">
                    <table class="min-w-full">
                        <tbody class="divide-y divide-gray-100">
                            @foreach($topSelling as $item)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-4 font-semibold text-gray-800 text-sm">
                                    {{ $item->name }}
                                </td>
                                <td class="py-4 text-right">
                                    <div class="text-sm font-black text-blue-600">PKR {{ number_format($item->revenue, 0) }}</div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase">{{ $item->units }} sold</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
            {{-- Inventory Breakdown --}}
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-xl border border-gray-100 p-6 flex flex-col">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-emerald-500"></i> Category Value
                </h2>
                <div class="flex-grow min-h-[350px] relative flex items-center justify-center">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>

            {{-- System Activity --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Recent System Activity</h2>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3 border-l-4 pl-4 border-green-400">
                        <i class="fa-solid fa-circle-check text-green-500 mt-1"></i>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Dynamic Dashboard Completed</p>
                            <p class="text-xs text-gray-500">System generated, Just now</p>
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
    // 1. Line Chart with Gradient Fill
    const salesTrendData = {!! json_encode($salesTrend) !!};
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: salesTrendData.map(d => d.date),
            datasets: [{
                label: 'Revenue',
                data: salesTrendData.map(d => d.total),
                borderColor: "#3b82f6",
                borderWidth: 4,
                backgroundColor: (context) => {
                    const ctx = context.chart.ctx;
                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
                    gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
                    return gradient;
                },
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointBackgroundColor: "#ffffff",
                pointBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: "#9ca3af", font: { weight: 'bold' } } },
                y: { 
                    border: { display: false },
                    grid: { color: "#f3f4f6" },
                    ticks: { color: "#9ca3af", font: { weight: 'bold' }, callback: v => 'PKR ' + v.toLocaleString() }
                }
            }
        }
    });

    // 2. Elegant Doughnut Chart
    const categoryData = {!! json_encode($categoryBreakdown) !!};
    new Chart(document.getElementById('inventoryChart'), {
        type: 'doughnut',
        data: {
            labels: categoryData.map(d => d.category),
            datasets: [{
                data: categoryData.map(d => d.value),
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899'],
                borderWidth: 8,
                borderColor: '#ffffff',
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '78%',
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25, font: { weight: 'bold', size: 11 } } }
            }
        }
    });
</script>
@endpush