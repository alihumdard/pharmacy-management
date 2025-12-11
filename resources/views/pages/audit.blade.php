@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')

<!-- MAIN CONTENT AREA -->
<div class="flex-1 md:pl-64">

    <!-- NAVBAR (ALWAYS FIXED TOP) -->
    <header class="fixed top-0 left-0 right-0 md:left-64 bg-white shadow p-4
                       flex justify-between items-center z-40">

        <!-- Mobile Button -->
        <button class="md:hidden text-2xl" onclick="toggleSidebar()">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Title -->
        <h2 class="text-xl font-bold text-black">Audit Log</h2>

        <!-- Right Icons -->
        <div class="flex items-center gap-6 text-black text-xl">
            <div class="relative cursor-pointer">
                <i class="fa-regular fa-bell"></i>
                <span class="absolute -top-1 -right-1 h-2 w-2 bg-red-600 rounded-full"></span>
            </div>
            <i class="fa-regular fa-circle-question cursor-pointer"></i>
            <i class="fa-solid fa-right-from-bracket cursor-pointer"></i>
        </div>

    </header>

    <!-- CONTENT ALWAYS STARTS JUST BELOW NAVBAR -->
    <main class="pt-20 p-4">

        <div class="bg-white shadow rounded-lg p-5 h-[533px]">

            <!-- Filters -->
            <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-4">
                <div
                    class="flex items-center bg-gray-100 px-4 py-2 rounded-lg border border-gray-300 w-full md:w-1/3">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Search" class="bg-transparent ml-2 w-full outline-none">
                </div>

                <div class="flex items-center gap-3">

                    <input type="date" class="px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full border rounded">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Timestamp</th>
                            <th class="px-4 py-2 text-left">User</th>
                            <th class="px-4 py-2 text-left">Action</th>
                            <th class="px-4 py-2 text-left">Module</th>
                            <th class="px-4 py-2 text-left">Details</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-t">
                            <td class="px-4 py-2">2023-05-20 10:30 AM</td>
                            <td class="px-4 py-2">Admin</td>
                            <td class="px-4 py-2">Updated Stock</td>
                            <td class="px-4 py-2">Inventory</td>
                            <td class="px-4 py-2">Updated stock for Panadol Extra from 10 to 50</td>
                        </tr>
                    </tbody>

                </table>
            </div>

        </div>

    </main>
</div>
@endsection

@push('scripts')


@endpush