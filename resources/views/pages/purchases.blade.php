@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
    <!-- PAGE CONTENT -->
    <main class="overflow-y-auto p-2 bg-gray-100 mt-16">

      <div class="p-4 sm:p-6 bg-gray-100">

        <div class="bg-white rounded-xl shadow-md p-4 sm:p-5 max-w-6xl mx-auto h-[500px]">

          <!-- Top Controls -->
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <!-- Search -->
            <div class="flex items-center bg-gray-100 px-4 py-[10px] border border-gray-300 rounded-lg w-full md:w-1/3">
              <i class="fa-solid fa-search text-gray-500"></i>
              <input
                type="text"
                placeholder="Search"
                class="bg-transparent outline-none text-sm w-full pl-2">
            </div>

            <!-- Date Filter + Button -->
            <div class="flex flex-wrap items-center gap-3">

              <!-- Date Box -->
              <div class="flex items-center bg-gray-100 px-4 py-[10px] border border-gray-300 rounded-lg w-full sm:w-auto">
                <i class="fa-solid fa-calendar text-gray-600"></i>
                <span class="text-sm text-gray-600 ml-2">Date — 31/01/2024</span>
              </div>

              <!-- Button -->
              <button class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 
                 text-white rounded-lg shadow-sm">
                New Purchase Order
              </button>

            </div>


          </div>

          <!-- Table -->
          <div class="overflow-x-auto rounded-lg border border-gray-200">

            <table class="w-full border-collapse text-sm min-w-[700px]">

              <thead>
                <tr class="bg-gray-100 text-gray-700">
                  <th class="py-3 px-4 text-left font-semibold">Purchase ID</th>
                  <th class="py-3 px-4 text-left font-semibold">Supplier</th>
                  <th class="py-3 px-4 text-left font-semibold">Purchase Date</th>
                  <th class="py-3 px-4 text-left font-semibold">Total Amount</th>
                  <th class="py-3 px-4 text-left font-semibold">Status</th>
                  <th class="py-3 px-4 text-left font-semibold">Actions</th>
                </tr>
              </thead>

              <tbody>

                <tr class="border-b hover:bg-gray-50 transition">
                  <td class="py-3 px-4">2000009</td>
                  <td class="py-3 px-4">MediCorp Distributors</td>
                  <td class="py-3 px-4">24/02/2023</td>
                  <td class="py-3 px-4">PKR 150,000</td>

                  <td class="py-3 px-1">
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                      Received
                    </span>
                  </td>

                  <td class="py-3 px-3 flex items-center gap-4 text-gray-600 text-lg">
                    <i class="fa-solid fa-pen cursor-pointer hover:text-blue-600"></i>
                    <i class="fa-solid fa-trash cursor-pointer hover:text-red-600"></i>
                    <i class="fa-solid fa-ellipsis-vertical cursor-pointer"></i>
                  </td>
                </tr>

              </tbody>

            </table>

          </div>

        </div>

      </div>

    </main>




@endsection

@push('scripts')


@endpush
