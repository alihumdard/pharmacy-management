@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')

      <!-- PAGE CONTENT -->
<main class="overflow-y-auto p-4 bg-gray-100 mt-[80px]">

    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-5">

        <!-- Top Bar -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">

            <!-- Search -->
            <div class="flex items-center bg-gray-100 px-4 py-2 rounded-lg w-full md:w-1/3 border border-gray-200">
                <i class="fa-solid fa-search text-gray-500"></i>
                <input type="text" placeholder="Search"
                    class="bg-transparent outline-none text-sm w-full pl-2">
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 flex-wrap">

                <!-- Filter -->
                <button class="px-4 py-2 bg-white border rounded-lg shadow hover:bg-gray-50 flex items-center gap-2">
                    <i class="fa-solid fa-filter text-gray-600"></i>
                    Filter
                </button>

                <!-- Add New -->
                <button class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                    Add New Medicine
                </button>

            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="w-full border-collapse text-sm">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-3 px-4 text-left font-semibold">Generic Name</th>
                        <th class="py-3 px-4 text-left font-semibold">Brand Name</th>
                        <th class="py-3 px-4 text-left font-semibold">Manufacturer</th>
                        <th class="py-3 px-4 text-left font-semibold">Category</th>
                        <th class="py-3 px-4 text-left font-semibold">Dosage Form</th>
                        <th class="py-3 px-4 text-left font-semibold">Strength</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    <!-- Row Example -->
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Paracetamol</td>
                        <td class="py-3 px-4">Panadol</td>
                        <td class="py-3 px-4">GSK</td>
                        <td class="py-3 px-4">Analgesic</td>
                        <td class="py-3 px-4">Tablet</td>
                        <td class="py-3 px-4">500mg</td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Paracetamol</td>
                        <td class="py-3 px-4">Panadol</td>
                        <td class="py-3 px-4">GSK</td>
                        <td class="py-3 px-4">Analgesic</td>
                        <td class="py-3 px-4">Tablet</td>
                        <td class="py-3 px-4">500mg</td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Paracetamol</td>
                        <td class="py-3 px-4">Panadol</td>
                        <td class="py-3 px-4">GSK</td>
                        <td class="py-3 px-4">Analgesic</td>
                        <td class="py-3 px-4">Tablet</td>
                        <td class="py-3 px-4">500mg</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Paracetamol</td>
                        <td class="py-3 px-4">Panadol</td>
                        <td class="py-3 px-4">GSK</td>
                        <td class="py-3 px-4">Analgesic</td>
                        <td class="py-3 px-4">Tablet</td>
                        <td class="py-3 px-4">500mg</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Paracetamol</td>
                        <td class="py-3 px-4">Panadol</td>
                        <td class="py-3 px-4">GSK</td>
                        <td class="py-3 px-4">Analgesic</td>
                        <td class="py-3 px-4">Tablet</td>
                        <td class="py-3 px-4">500mg</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Paracetamol</td>
                        <td class="py-3 px-4">Panadol</td>
                        <td class="py-3 px-4">GSK</td>
                        <td class="py-3 px-4">Analgesic</td>
                        <td class="py-3 px-4">Tablet</td>
                        <td class="py-3 px-4">500mg</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Paracetamol</td>
                        <td class="py-3 px-4">Panadol</td>
                        <td class="py-3 px-4">GSK</td>
                        <td class="py-3 px-4">Analgesic</td>
                        <td class="py-3 px-4">Tablet</td>
                        <td class="py-3 px-4">500mg</td>
                    </tr>
                     <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">Paracetamol</td>
                        <td class="py-3 px-4">Panadol</td>
                        <td class="py-3 px-4">GSK</td>
                        <td class="py-3 px-4">Analgesic</td>
                        <td class="py-3 px-4">Tablet</td>
                        <td class="py-3 px-4">500mg</td>
                    </tr>
                    

                    <!-- Repeat rows same way -->
                </tbody>

            </table>
        </div>

    </div>

</main>

@endsection

@push('scripts')


@endpush
