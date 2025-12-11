@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<!-- PAGE CONTENT -->
<main class="overflow-y-auto p-2 bg-gray-100 mt-16">
  <div class="p-4 sm:p-6 bg-gray-100 min-h-screen">

    <!-- SALES SUMMARY CARD -->
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 max-w-6xl mx-auto mb-6">

      <!-- Header -->
      <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
        <h2 class="text-lg sm:text-xl font-bold text-gray-800">Sales Summary</h2>

        <button class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 
                       text-gray-700 flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
          Last 6 Months
          <i class="fa-solid fa-chevron-down text-xs"></i>
        </button>
      </div>

      <!-- Chart (Scrollable on Mobile)-->
      <div class="w-full overflow-x-auto">
        <canvas id="salesChart" class="min-w-[500px] sm:min-w-full"></canvas>
      </div>

    </div>

    <!-- TOP SELLING MEDICINES -->
    <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 max-w-6xl mx-auto">

      <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 text-center sm:text-left">
        Top Selling Medicines
      </h2>

      <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
          <thead>
            <tr class="bg-gray-100 text-gray-700">
              <th class="py-3 px-4 text-left font-semibold">Medicine Name</th>
              <th class="py-3 px-4 text-left font-semibold">Quantity Sold</th>
              <th class="py-3 px-4 text-left font-semibold">Total Revenue</th>
            </tr>
          </thead>

          <tbody>

            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-3 px-4">Medicine Dnoestile</td>
              <td class="py-3 px-4">205</td>
              <td class="py-3 px-4">PKR 330.00</td>
            </tr>

            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-3 px-4">Panadol Data</td>
              <td class="py-3 px-4">250</td>
              <td class="py-3 px-4">PKR 250.00</td>
            </tr>

            <!-- (Duplicate rows preserved as in your code) -->
            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-3 px-4">Panadol Data</td>
              <td class="py-3 px-4">250</td>
              <td class="py-3 px-4">PKR 250.00</td>
            </tr>

            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-3 px-4">Panadol Data</td>
              <td class="py-3 px-4">250</td>
              <td class="py-3 px-4">PKR 250.00</td>
            </tr>

            <tr class="border-b hover:bg-gray-50 transition">
              <td class="py-3 px-4">Panadol Data</td>
              <td class="py-3 px-4">250</td>
              <td class="py-3 px-4">PKR 250.00</td>
            </tr>

          </tbody>
        </table>
      </div>

    </div>

  </div>
</main>
@endsection

@push('scripts')


<script>
  const ctx = document.getElementById('salesChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan 21', 'Feb 21', 'Mar 21', 'Apr 22', 'May 22', 'Jun 22'],
      datasets: [{
        label: 'Sales',
        data: [750, 900, 1100, 800, 1200, 950],
        backgroundColor: '#3B82F6',
        borderRadius: 6,
        barThickness: 80
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 250
          }
        }
      }
    }
  });
</script>
@endpush