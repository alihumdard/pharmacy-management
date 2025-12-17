@extends('layouts.main')
@section('title', 'Executive Dashboard')

@section('content')
<main class="overflow-y-auto p-6 md:p-8 pt-16 bg-gray-50 min-h-screen">

    <h1 class="text-3xl font-bold text-gray-800 mb-2">Pharmacy Overview</h1>
    <p class="text-gray-500 mb-8">Quick insights into today's performance and inventory health.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        {{-- Custom CSS: Use Tailwind's `group` and `transition` for better hover effects --}}

        <div class="p-6 overflow-hidden rounded-xl border border-blue-50 bg-white shadow-xl group hover:shadow-2xl transition duration-500 relative">
            
            {{-- Aesthetic Icon Background (Half Circle) --}}
            <div class="absolute -left-12 -top-12 w-28 h-28 rounded-full bg-blue-100 opacity-30 transition duration-500 group-hover:opacity-40"></div>

            <div class="flex items-center justify-between z-10 relative">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 shadow-md">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Today's Sales</p>
                    <h2 class="text-2xl font-extrabold text-gray-900">PKR 50,000</h2>
                </div>
            </div>
            
            {{-- Footer Stat with Gradient Separator --}}
            <p class="text-xs font-semibold text-green-600 mt-5 pt-3 border-t border-gray-100 flex items-center">
                <i class="fa-solid fa-arrow-up text-green-600 mr-1"></i> 
                12% increase 
                <span class="text-gray-400 ml-auto font-normal">vs yesterday</span>
            </p>
        </div>

        <div class="p-6 overflow-hidden rounded-xl border border-red-50 bg-white shadow-xl group hover:shadow-2xl transition duration-500 relative">
            <div class="absolute -left-12 -top-12 w-28 h-28 rounded-full bg-red-100 opacity-30 transition duration-500 group-hover:opacity-40"></div>

            <div class="flex items-center justify-between z-10 relative">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-red-50 text-red-600 shadow-md">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Low Stock Items</p>
                    <h2 class="text-4xl font-extrabold text-gray-900">15</h2>
                </div>
            </div>
            <p class="text-xs font-semibold text-red-600 mt-5 pt-3 border-t border-gray-100 flex items-center">
                <i class="fa-solid fa-bell text-red-600 mr-1"></i> 
                Action Required
                <span class="text-gray-400 ml-auto font-normal">Check Inventory</span>
            </p>
        </div>

        <div class="p-6 overflow-hidden rounded-xl border border-amber-50 bg-white shadow-xl group hover:shadow-2xl transition duration-500 relative">
             <div class="absolute -left-12 -top-12 w-28 h-28 rounded-full bg-amber-100 opacity-30 transition duration-500 group-hover:opacity-40"></div>

            <div class="flex items-center justify-between z-10 relative">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-amber-50 text-amber-600 shadow-md">
                    <i class="fa-solid fa-hourglass-start text-2xl"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Expiring Batches</p>
                    <h2 class="text-4xl font-extrabold text-gray-900">5</h2>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-600 mt-5 pt-3 border-t border-gray-100 flex items-center">
                <i class="fa-solid fa-calendar-alt text-gray-500 mr-1"></i> 
                Next 30 days
                <span class="text-gray-400 ml-auto font-normal">Review list</span>
            </p>
        </div>

        <div class="p-6 overflow-hidden rounded-xl border border-emerald-50 bg-white shadow-xl group hover:shadow-2xl transition duration-500 relative">
            <div class="absolute -left-12 -top-12 w-28 h-28 rounded-full bg-emerald-100 opacity-30 transition duration-500 group-hover:opacity-40"></div>

            <div class="flex items-center justify-between z-10 relative">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-emerald-50 text-emerald-600 shadow-md">
                    <i class="fa-solid fa-sack-dollar text-2xl"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-0.5">Credit Due</p>
                    <h2 class="text-2xl font-extrabold text-gray-900">PKR 20,000</h2>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-600 mt-5 pt-3 border-t border-gray-100 flex items-center">
                <i class="fa-solid fa-clock text-gray-500 mr-1"></i>
                Avg. Overdue 7 days
                <span class="text-gray-400 ml-auto font-normal">Collect now</span>
            </p>
        </div>

    </div>
    {{-- Rest of the code (Charts, Activity, Tables) will follow here... --}}
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white rounded-xl shadow-xl border border-gray-100 p-6 md:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 border-b pb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-3 md:mb-0">Revenue Trend (Last 30 Days)</h2>
                <div class="flex items-center gap-4">
                    <select
                        class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-150">
                        <option>Monthly</option>
                        <option>Quarterly</option>
                    </select>
                </div>
            </div>
            <div class="h-96 w-full"> 
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-1 bg-white rounded-xl shadow-xl border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Recent System Activity</h2>
            <ul class="space-y-4">
                <li class="flex items-start space-x-3 border-l-2 pl-3 border-green-400">
                    <i class="fa-solid fa-check-circle text-lg text-green-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Sale #459 completed</p>
                        <p class="text-xs text-gray-500">by User A, 2 mins ago</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3 border-l-2 pl-3 border-yellow-400">
                    <i class="fa-solid fa-arrow-up text-lg text-yellow-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Inventory updated (Supplier Z)</p>
                        <p class="text-xs text-gray-500">by Admin, 1 hour ago</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3 border-l-2 pl-3 border-red-400">
                    <i class="fa-solid fa-xmark-circle text-lg text-red-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Critical Stock: Panadol (Qty 5)</p>
                        <p class="text-xs text-gray-500">System Alert, 3 hours ago</p>
                    </div>
                </li>
                <li class="flex items-start space-x-3 border-l-2 pl-3 border-blue-400">
                    <i class="fa-solid fa-user-plus text-lg text-blue-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-medium text-gray-800">New Customer Added</p>
                        <p class="text-xs text-gray-500">by User B, 5 hours ago</p>
                    </div>
                </li>
            </ul>
        </div>

    </div>
    
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Inventory Value Breakdown</h2>
            <div class="h-80 w-full">
                <canvas id="inventoryChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Top 5 Selling Items (Units)</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Units Sold</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Paracetamol 500mg</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">850</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">17,000</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Amoxil 250mg</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">620</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">31,000</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Vitamin D Tablets</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">510</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">10,200</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Blood Pressure Pills</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">480</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">48,000</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Cough Syrup</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">390</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">5,850</td></tr>
                </tbody>
            </table>
        </div>

    </div>

</main>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ------------------------------------------------------------------
    // 1. REVENUE TREND CHART (Main Line Chart)
    // ------------------------------------------------------------------
    const salesCtx = document.getElementById('salesChart');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: [
                "Day 1", "Day 5", "Day 10", "Day 15", "Day 20", "Day 25", "Day 30"
            ],
            datasets: [{
                label: 'Total Revenue (PKR)',
                data: [50000, 37000, 42000, 62000, 58000, 71000, 74000],
                borderColor: "#3b82f6", // Primary Blue
                backgroundColor: "rgba(59, 130, 246, 0.15)",
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'PKR Value', color: '#6b7280' },
                    grid: { color: "rgba(0,0,0,0.08)" },
                    ticks: { color: "#4b5563" }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: "#4b5563" }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: { backgroundColor: 'rgba(30, 41, 59, 0.9)' }
            }
        }
    });

    // ------------------------------------------------------------------
    // 2. INVENTORY BREAKDOWN CHART (New Doughnut Chart)
    // ------------------------------------------------------------------
    const inventoryCtx = document.getElementById('inventoryChart');
    new Chart(inventoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['General Medicines', 'Prescription Drugs', 'Supplies & Equipment', 'Other OTC'],
            datasets: [{
                data: [45, 30, 15, 10], // Percentage value breakdown
                backgroundColor: [
                    '#3b82f6', // Blue
                    '#10b981', // Emerald
                    '#f59e0b', // Amber
                    '#8b5cf6'  // Violet
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 20
                    }
                },
                title: {
                    display: true,
                    text: 'Inventory Value by Category (%)',
                    font: { size: 14 }
                }
            }
        }
    });
</script>
@endpush