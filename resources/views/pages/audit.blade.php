@extends('layouts.main')
@section('title', 'System Audit Log')

@section('content')
<main class="pt-20 p-4 md:p-8 ">

    <div class="max-w-full mx-auto">
        
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-12 pt-3">System Activity Audit</h1>

        <div class="bg-white shadow-2xl rounded-2xl border border-gray-100 p-4 md:p-6">

            <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">Activity Tracking & History</h3>

            <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-6">
                
                <div class="relative w-full md:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search by user, action, or details..." 
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border border-gray-300 rounded-xl outline-none text-sm text-gray-700 focus:ring-2 focus:ring-blue-400 transition">
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    
                     <select class="px-4 py-2.5 border border-gray-300 rounded-xl bg-gray-50 text-gray-700 text-sm shadow-sm focus:border-blue-500">
                        <option>Filter by Action Type</option>
                        <option>Update</option>
                        <option>Create</option>
                        <option>Delete</option>
                    </select>
                    
                    <input type="date" class="px-4 py-2.5 border border-gray-300 rounded-xl bg-white text-gray-700 text-sm shadow-sm focus:border-blue-500">
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
                <table class="w-full border-collapse text-sm">
                    
                    <thead class="bg-blue-600 text-white shadow-md">
                        <tr>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider w-[15%]">Timestamp</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider w-[10%]">User</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider w-[10%]">Action</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider w-[10%]">Module</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider w-[55%]">Details</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        
                        {{-- Row 1: Update (Example Data) --}}
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-800 whitespace-nowrap">2025-12-12 10:30 PM</td>
                            <td class="px-5 py-3 font-semibold text-blue-700">Admin</td>
                            <td class="px-5 py-3">
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Update
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">Inventory</td>
                            <td class="px-5 py-3 text-gray-800">Updated stock for **Panadol Extra** from 10 to 50 boxes.</td>
                        </tr>
                        
                        {{-- Row 2: Create (Example Data) --}}
                         <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-800 whitespace-nowrap">2025-12-12 09:15 PM</td>
                            <td class="px-5 py-3 font-semibold text-blue-700">Cashier Jane</td>
                            <td class="px-5 py-3">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Create
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">Sales/POS</td>
                            <td class="px-5 py-3 text-gray-800">Processed new sale **#S10018373** (PKR 1,415.70) via Cash.</td>
                        </tr>

                         {{-- Row 3: Delete (Example Data) --}}
                         <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-800 whitespace-nowrap">2025-12-11 04:00 PM</td>
                            <td class="px-5 py-3 font-semibold text-blue-700">Manager Sam</td>
                            <td class="px-5 py-3">
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Delete
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">Customers</td>
                            <td class="px-5 py-3 text-gray-800">Deleted customer record: **John Doe** (Phone: 0300XXXXXX).</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            {{-- Optional: Pagination (Placeholder for completeness) --}}
            <div class="mt-6 flex justify-between items-center text-sm text-gray-600">
                <span>Showing 1 to 10 of 200 results</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">&larr; Previous</button>
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">Next &rarr;</button>
                </div>
            </div>

        </div>

    </main>
@endsection

@push('scripts')
{{-- Note: No specific script changes needed --}}
@endpush