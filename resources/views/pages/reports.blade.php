@extends('layouts.main')
@section('title', 'Sales Report & Analytics')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">

    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-12 pt-3">Comprehensive Sales Analysis</h1>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 my-8">
            
            {{-- KPI Card 1: Total Revenue --}}
            <div class="p-6 bg-white rounded-xl shadow-xl border-l-4 border-blue-600">
                <p class="text-sm font-medium text-gray-500">Total Revenue (6 Months)</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">PKR 530,000</h3>
            </div>
            
            {{-- KPI Card 2: Average Basket Value --}}
            <div class="p-6 bg-white rounded-xl shadow-xl border-l-4 border-green-600">
                <p class="text-sm font-medium text-gray-500">Avg. Basket Value</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">PKR 1,560</h3>
            </div>
            
            {{-- KPI Card 3: Total Transactions --}}
            <div class="p-6 bg-white rounded-xl shadow-xl border-l-4 border-purple-600">
                <p class="text-sm font-medium text-gray-500">Total Transactions</p>
                <h3 class="text-3xl font-extrabold text-gray-900 mt-1">340</h3>
            </div>

        </div>


        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6 mb-8">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6 border-b pb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-bar text-blue-600"></i> Revenue Trend Analysis
                </h2>

                <button class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 
                               font-semibold flex items-center gap-2 text-sm shadow-md">
                    Last 6 Months
                    <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
                </button>
            </div>

            <div class="w-full overflow-x-auto" style="height: 400px;">
                <canvas id="salesChart" class="min-w-[800px] sm:min-w-full"></canvas>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">

            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4 flex items-center gap-2">
                <i class="fa-solid fa-medal text-blue-600"></i> Top 5 Performing Products
            </h2>

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
                <table class="w-full border-collapse text-sm min-w-[700px]">
                    
                    <thead>
                        <tr class="bg-blue-600 text-white shadow-md">
                            <th class="py-3 px-5 text-center font-bold uppercase tracking-wider w-[10%]">Rank</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider w-[50%]">Medicine Name</th>
                            <th class="py-3 px-5 text-right font-bold uppercase tracking-wider w-[20%]">Quantity Sold</th>
                            <th class="py-3 px-5 text-right font-bold uppercase tracking-wider w-[20%]">Total Revenue</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @php
                            $top_sales = [
                                ['name' => 'Amoxicillin 500mg', 'qty' => 250, 'rev' => 45000.00],
                                ['name' => 'Medicine Dnoestile', 'qty' => 205, 'rev' => 33000.00],
                                ['name' => 'Panadol Extra', 'qty' => 180, 'rev' => 25000.00],
                                ['name' => 'Vitamin D Tablets', 'qty' => 150, 'rev' => 12000.00],
                                ['name' => 'Cough Syrup (Adult)', 'qty' => 135, 'rev' => 9000.00],
                            ];
                        @endphp
                        
                        @foreach ($top_sales as $index => $item)
                            <tr class="hover:bg-blue-50 transition {{ $index == 0 ? 'bg-blue-50 font-semibold' : '' }}">
                                <td class="py-4 px-5 text-center font-extrabold {{ $index < 3 ? 'text-lg text-blue-700' : 'text-gray-500' }}">
                                    #{{ $index + 1 }}
                                </td>
                                <td class="py-4 px-5 text-gray-800">{{ $item['name'] }}</td>
                                <td class="py-4 px-5 text-right font-bold text-blue-600">{{ $item['qty'] }} Units</td>
                                <td class="py-4 px-5 text-right font-bold text-green-700">PKR {{ number_format($item['rev'], 2) }}</td>
                            </tr>
                        @endforeach
                        
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
const ctx = document.getElementById('salesChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // Simplified labels
        datasets: [{
            label: 'Total Revenue (PKR)',
            data: [75000, 90000, 110000, 80000, 120000, 95000], // Adjusted to be large values
            backgroundColor: '#3B82F6', // Tailwind blue-500
            hoverBackgroundColor: '#2563EB', // Tailwind blue-600
            borderRadius: 8, // Slightly larger radius for bars
            barPercentage: 0.7, 
            categoryPercentage: 0.6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false 
            },
            tooltip: {
                backgroundColor: 'rgba(30, 41, 59, 0.9)',
                titleFont: { weight: 'bold' },
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.parsed.y !== null) {
                            label += 'PKR ' + context.parsed.y.toLocaleString('en-US');
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: "rgba(0,0,0,0.08)"
                },
                ticks: {
                    stepSize: 50000, 
                    callback: function(value) {
                        return 'PKR ' + (value / 1000) + 'k'; // Format Y-axis ticks
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
@endpush