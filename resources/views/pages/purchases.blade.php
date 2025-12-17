@extends('layouts.main')
@section('title', 'Purchase Orders')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">

    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Purchase Order History</h1>

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 sm:p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                <div class="relative w-full md:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        type="text"
                        placeholder="Search by ID, Supplier, or Status..."
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border border-gray-300 rounded-xl outline-none text-sm text-gray-700 focus:ring-2 focus:ring-blue-400 transition">
                </div>

                <div class="flex flex-wrap items-center gap-3">

                    <div class="flex items-center bg-white px-4 py-2.5 border border-gray-300 rounded-xl shadow-sm cursor-pointer hover:bg-gray-50 transition w-full sm:w-auto">
                        <i class="fa-solid fa-calendar-alt text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Filter By Date Range</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 ml-2"></i>
                    </div>

                    <button class="w-full sm:w-auto px-6 py-2.5 bg-green-600 hover:bg-green-700 
                        text-white rounded-xl shadow-lg font-semibold flex items-center justify-center gap-2 transition">
                        <i class="fa-solid fa-cart-plus"></i> Create New PO
                    </button>

                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">

                <table class="w-full border-collapse text-sm min-w-[900px]">

                    <thead>
                        <tr class="bg-blue-600 text-white shadow-md">
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Purchase ID</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Supplier Name</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Order Date</th>
                            <th class="py-3 px-5 text-right font-bold uppercase tracking-wider">Total Amount</th>
                            <th class="py-3 px-5 text-center font-bold uppercase tracking-wider">Status</th>
                            <th class="py-3 px-5 text-center font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Row 1: Received --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-4 px-5 font-semibold text-blue-700">#2000009</td>
                            <td class="py-4 px-5 text-gray-800 font-medium">MediCorp Distributors</td>
                            <td class="py-4 px-5 text-gray-600">24/02/2023</td>
                            <td class="py-4 px-5 text-right font-bold text-green-700">PKR 150,000.00</td>
                            <td class="py-4 px-5 text-center">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-check-circle mr-1"></i> Received
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                                    <i class="fa-solid fa-eye cursor-pointer hover:text-blue-600" title="View Details"></i>
                                    <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Order"></i>
                                    <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Order"></i>
                                </div>
                            </td>
                        </tr>
                        
                         {{-- Row 2: Pending --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-4 px-5 font-semibold text-blue-700">#2000010</td>
                            <td class="py-4 px-5 text-gray-800 font-medium">PharmaSupply Inc.</td>
                            <td class="py-4 px-5 text-gray-600">10/12/2025</td>
                            <td class="py-4 px-5 text-right font-bold text-gray-700">PKR 85,500.00</td>
                            <td class="py-4 px-5 text-center">
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-hourglass-half mr-1"></i> Pending
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                                    <i class="fa-solid fa-eye cursor-pointer hover:text-blue-600" title="View Details"></i>
                                    <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Order"></i>
                                    <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Order"></i>
                                </div>
                            </td>
                        </tr>

                        {{-- Row 3: Draft --}}
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-4 px-5 font-semibold text-blue-700">#2000011</td>
                            <td class="py-4 px-5 text-gray-800 font-medium">Local Chemist Supply</td>
                            <td class="py-4 px-5 text-gray-600">12/12/2025</td>
                            <td class="py-4 px-5 text-right font-bold text-gray-700">PKR 45,000.00</td>
                            <td class="py-4 px-5 text-center">
                                <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-file-alt mr-1"></i> Draft
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                                    <i class="fa-solid fa-eye cursor-pointer hover:text-blue-600" title="View Details"></i>
                                    <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Order"></i>
                                    <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Order"></i>
                                </div>
                            </td>
                        </tr>
                        
                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>
@endsection