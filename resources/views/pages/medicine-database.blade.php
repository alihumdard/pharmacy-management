@extends('layouts.main')
@section('title', 'Medicine Database')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">

    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Central Medicine Database</h1>

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                <div class="relative w-full md:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search by brand, generic name, or manufacturer..."
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border border-gray-300 rounded-xl outline-none text-sm text-gray-700 focus:ring-2 focus:ring-blue-400 transition">
                </div>

                <div class="flex items-center gap-3 flex-wrap">

                    <button class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 
                            flex items-center gap-2 shadow-md transition text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-filter text-gray-600"></i> Apply Filters
                    </button>

                    <button class="px-5 py-2.5 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 font-semibold flex items-center gap-2 transition text-sm">
                        <i class="fa-solid fa-plus"></i> Add New Product
                    </button>

                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">

                <table class="w-full border-collapse text-sm min-w-[1000px]">

                    <thead class="bg-blue-600 text-white shadow-md">
                        <tr>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Generic Name</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Brand Name</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Manufacturer</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Category</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Dosage Form</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Strength</th>
                            <th class="py-3 px-5 text-center font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @for ($i = 1; $i <= 8; $i++)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-5 font-medium text-gray-800">Paracetamol</td>
                            <td class="py-3 px-5 font-semibold text-blue-700">Panadol Extra</td>
                            <td class="py-3 px-5 text-gray-600">GSK</td>
                            <td class="py-3 px-5 text-gray-600">Analgesic</td>
                            <td class="py-3 px-5 text-gray-600">Tablet</td>
                            <td class="py-3 px-5 text-gray-600">500mg</td>
                             <td class="py-3 px-5 text-center">
                                <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                                    <i class="fa-solid fa-eye cursor-pointer hover:text-blue-600" title="View Details"></i>
                                    <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Product"></i>
                                </div>
                            </td>
                        </tr>
                        @endfor
                        

                    </tbody>

                </table>
            </div>

            {{-- Optional: Pagination (Placeholder for completeness) --}}
            <div class="mt-6 flex justify-between items-center text-sm text-gray-600">
                <span>Showing 1 to 10 of 52 results</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">&larr; Previous</button>
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">Next &rarr;</button>
                </div>
            </div>

        </div>

    </div>

</main>

@endsection

@push('scripts')
@endpush