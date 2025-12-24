@extends('layouts.main')
@section('title', 'Welcome Dashboard')

@section('content')
<main class="overflow-y-auto p-4 md:p-10 mt-14 sm:mt-0">

    <div class="flex items-center justify-center">

        <div class="w-full max-w-6xl">

            <div class=" mb-10 md:mb-16">
                <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tighter leading-tight">
                    PHARMACY MANAGEMENT
                </h1>
                <p class="text-xl text-gray-600 mt-4 font-light">
                    Your central hub for efficient daily operations.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">

                {{-- Updated modules array to match web.php route names --}}
                @php
                    $modules = [
                        [
                            'name' => 'Medicine Database', 
                            'icon' => 'fa-pills', 
                            'color' => 'emerald', 
                            'route' => 'medicines.index', // Matches Route::get('/medicines')
                            'desc' => 'Manage inventory, suppliers, batches, and stock levels.'
                        ],
                        [
                            'name' => 'Point of Sale (POS)', 
                            'icon' => 'fa-cash-register', 
                            'color' => 'indigo', 
                            'route' => 'pos', // Matches Route::get('/pos')
                            'desc' => 'Process rapid transactions and view real-time sales records.'
                        ],
                        [
                            'name' => 'Customer Management', 
                            'icon' => 'fa-users', 
                            'color' => 'cyan', 
                            'route' => 'customers.index', // Matches Route::resource('customers')
                            'desc' => 'Maintain patient records and manage outstanding credit accounts.'
                        ],
                        [
                            'name' => 'Purchases & Receiving', 
                            'icon' => 'fa-truck-ramp-box', 
                            'color' => 'orange', 
                            'route' => 'po.index', // Matches Route::get('/purchase-orders')
                            'desc' => 'Handle ordering, stock receiving, and supplier management.'
                        ],
                        [
                            'name' => 'Analytics & Reports', 
                            'icon' => 'fa-chart-line', 
                            'color' => 'fuchsia', 
                            'route' => 'reports', // Matches Route::view('/reports')
                            'desc' => 'Access performance metrics, sales trends, and profitability analysis.'
                        ],
                        [
                            'name' => 'System Settings', 
                            'icon' => 'fa-gear', 
                            'color' => 'gray', 
                            'route' => 'settings', // Matches Route::view('/settings')
                            'desc' => 'Configure users, permissions, branches, and system parameters.'
                        ],
                    ];
                @endphp
                
                @foreach ($modules as $module)
                    @php
                        $colorClass = $module['color'];
                        $iconColor = "text-{$colorClass}-600";
                        $bgColorHover = "bg-{$colorClass}-50";
                        $titleColorHover = "text-{$colorClass}-900";
                    @endphp

                    <a href="{{ Route::has($module['route']) ? route($module['route']) : '#' }}"
                        class="group block p-7 bg-white rounded-xl shadow-2xl border border-gray-100 
                               hover:shadow-3xl hover:border-transparent transition-all duration-300 relative overflow-hidden 
                               transform hover:-translate-y-2 hover:z-10" 
                               style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">

                        {{-- Background Accent on Hover --}}
                        <div class="absolute inset-0 {{ $bgColorHover }} opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div class="relative z-10 flex flex-col items-start gap-4">
                            
                            {{-- Icon --}}
                            <div class="p-3 rounded-xl {{ $iconColor }} bg-gray-50 group-hover:bg-white shadow-inner transition-colors duration-300">
                                <i class="fa-solid {{ $module['icon'] }} text-3xl md:text-4xl"></i>
                            </div>

                            {{-- Title --}}
                            <span class="text-xl md:text-2xl font-extrabold text-gray-900 {{ $titleColorHover }} transition duration-300">
                                {{ $module['name'] }}
                            </span>

                            {{-- Description --}}
                            <p class="text-sm text-gray-500 group-hover:text-gray-600 transition">
                                {{ $module['desc'] }}
                            </p>
                     8       
                            {{-- Arrow Indicator --}}
                             <i class="fa-solid fa-arrow-right text-base mt-2 {{ $iconColor }} opacity-70 group-hover:opacity-100 transform group-hover:translate-x-1 transition duration-300"></i>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
    </div>
</main>
@endsection