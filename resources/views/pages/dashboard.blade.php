@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<!-- CONTENT ALWAYS STARTS JUST BELOW NAVBAR -->
<main class="overflow-y-auto p-5 bg-gray-100 mt-16 min-h-screen">

    <!-- TOP CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- CARD 1 -->
        <div class="p-6 rounded-xl shadow-lg text-white bg-gradient-to-br from-blue-400 to-blue-700">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-cart-shopping text-3xl"></i>
                <div>
                    <p class="text-sm opacity-90">Today's Sales</p>
                    <h2 class="text-3xl font-bold">PKR 50,000</h2>
                </div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="p-6 rounded-xl shadow-lg text-white bg-gradient-to-br from-red-400 to-red-600">
            <div class="flex items-center gap-3 pt-4">
                <i class="fa-solid fa-triangle-exclamation text-3xl"></i>
                <div>
                    <p class="text-sm opacity-90">Low Stock Alerts</p>
                    <h2 class="text-3xl font-bold">15 Items</h2>
                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="p-6 rounded-xl shadow-lg text-white bg-gradient-to-br from-yellow-400 to-yellow-600">
            <div class="flex items-center gap-3 pt-4">
                <i class="fa-solid fa-hourglass-start text-3xl"></i>
                <div>
                    <p class="text-sm opacity-90">Expiring Soon</p>
                    <h2 class="text-3xl font-bold">5 Batches</h2>
                </div>
            </div>
        </div>

        <!-- CARD 4 -->
        <div class="p-6 rounded-xl shadow-lg text-white bg-gradient-to-br from-emerald-400 to-emerald-600">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-sack-dollar text-3xl"></i>
                <div>
                    <p class="text-sm opacity-90">Pending Credit</p>
                    <h2 class="text-3xl font-bold">PKR 20,000</h2>
                </div>
            </div>
        </div>

    </div>

    <!-- GRAPH CARD -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">

        <!-- Header -->
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-xl font-semibold text-gray-700">Weekly Sales Trend</h2>

            <select
                class="px-3 py-2 rounded-lg border bg-gray-50 text-gray-700 hover:bg-gray-100 cursor-pointer">
                <option>Next Month</option>
            </select>
        </div>

        <!-- Chart -->
        <div class="h-80">
            <canvas id="salesChart"></canvas>
        </div>

    </div>

</main>

<!-- CUSTOMER MODAL -->
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('salesChart');
    new Chart(ctx, {
        type: 'line',

        data: {
            labels: [
                "Jan 21",
                "Tue 22",
                "Wed 21",
                "Thu 21",
                "Fri 21",
                "May 21",
                "Jan 22",
                "Mar 22"
            ],

            datasets: [{
                data: [50, 370, 220, 620, 580, 910, 760, 740],
                borderColor: "#4f8dfd",
                backgroundColor: "rgba(79,141,253,0.18)",
                borderWidth: 3,
                pointRadius: 0,
                tension: 0.45,     // Smooth curve
                fill: true
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        color: "rgba(0,0,0,0.05)",
                        lineWidth: 1
                    },
                    ticks: {
                        color: "#444"
                    }
                },

                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: "#444"
                    }
                }
            },

            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
