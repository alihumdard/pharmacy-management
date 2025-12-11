@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<!-- PAGE CONTENT -->
<main class="overflow-y-auto p-2 bg-gray-100 mt-16">
    <div class="bg-gray-50 flex items-center justify-center p-4 sm:p-6">

        <div class="w-full max-w-5xl h-[500px]">

            <!-- Title -->
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-800 mb-6 sm:mb-10 text-center sm:text-left">
                Pharmacy Management System
            </h1>

            <!-- GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6">

                <!-- Card 1 -->
                <div class="flex items-center gap-4 p-6 bg-white rounded-xl shadow hover:shadow-lg transition cursor-pointer">
                    <i class="fa-solid fa-pills text-4xl text-green-800"></i>
                    <span class="text-lg font-semibold text-gray-700">Medicines</span>
                </div>

                <!-- Card 2 -->
                <div class="flex items-center gap-4 p-6 bg-white rounded-xl shadow hover:shadow-lg transition cursor-pointer">
                    <i class="fa-solid fa-store text-4xl text-green-800"></i>
                    <span class="text-lg font-semibold text-gray-700">Sales</span>
                </div>

                <!-- Card 3 -->
                <div class="flex items-center gap-4 p-6 bg-white rounded-xl shadow hover:shadow-lg transition cursor-pointer">
                    <i class="fa-solid fa-user text-4xl text-green-800"></i>
                    <span class="text-lg font-semibold text-gray-700">Customers</span>
                </div>

                <!-- Card 4 -->
                <div class="flex items-center gap-4 p-6 bg-white rounded-xl shadow hover:shadow-lg transition cursor-pointer">
                    <i class="fa-solid fa-chart-pie text-4xl text-green-800"></i>
                    <span class="text-lg font-semibold text-gray-700">Purchases</span>
                </div>

                <!-- Card 5 -->
                <div class="flex items-center gap-4 p-6 bg-white rounded-xl shadow hover:shadow-lg transition cursor-pointer">
                    <i class="fa-solid fa-chart-line text-4xl text-green-800"></i>
                    <span class="text-lg font-semibold text-gray-700">Reports</span>
                </div>

                <!-- Card 6 -->
                <div class="flex items-center gap-4 p-6 bg-white rounded-xl shadow hover:shadow-lg transition cursor-pointer">
                    <i class="fa-solid fa-gear text-4xl text-green-800"></i>
                    <span class="text-lg font-semibold text-gray-700">Settings</span>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')


@endpush