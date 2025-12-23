<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    /* Active Tab Design (Main Menu) */
    .active-dark-mode {
        background-color: #ffffff !important;
        color: #1d4ed8 !important; /* Blue text when button is white */
        font-weight: 700;
        border-top-left-radius: 9999px;
        border-bottom-left-radius: 9999px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transform: scale(1.02);
    }

    /* Icon color fix when button is active (white) */
    .active-dark-mode i {
        color: #1d4ed8 !important;
    }

    .nav-link-base {
        transition: all 0.2s ease-in-out;
        padding-left: 1rem;
    }

    /* Submenu Specific Styles */
    .submenu-link {
        transition: all 0.2s;
        padding-left: 3.5rem; /* Text alignment with main icons */
    }
    
    /* Sub-tab text color when active (Yellow/Gold) */
    .active-submenu-text {
        color: #fbbf24 !important; 
        font-weight: 800;
    }

    [x-cloak] { display: none !important; }

    @media (max-width: 767px) {
        #sidebar.transform.translate-x-0 {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    }
</style>

<aside id="sidebar" 
    x-data="{ openReports: {{ request()->routeIs('reports*') ? 'true' : 'false' }} }"
    class="w-64 bg-[#1d4ed8] py-6 pl-4 overflow-y-auto min-h-screen transform -translate-x-full absolute md:relative md:translate-x-0 transition-all duration-300 top-0 left-0 z-50 md:z-40 text-white font-sans">
    
    {{-- Branding Section --}}
    <div class="mb-6 flex items-center p-3 mx-2">
        @if(isset($siteSettings) && $siteSettings->logo)
            <img src="{{ asset('storage/' . $siteSettings->logo) }}" class="w-11 h-11 rounded-full mr-3 border-2 border-white shadow-md object-cover">
        @else
            <img src="{{ asset('assets/images/images (3).jpg') }}" class="w-11 h-11 rounded-full mr-3 border-2 border-white shadow-md object-cover">
        @endif
        <div>
            <p class="font-bold text-white text-md leading-tight">{{ $siteSettings->user_name ?? 'User Name' }}</p>
            <p class="text-[10px] text-blue-200 font-bold uppercase tracking-wider mt-1 italic">{{ $siteSettings->pharmacy_name ?? 'Pharmacy Name' }}</p>
        </div>
    </div>

    <hr class="mb-4 border-white/10">

    <nav class="space-y-1.5">
        @php
            $baseClass = 'nav-link-base flex items-center gap-3 px-4 py-2 text-sm text-white';
            $activeClass = 'active-dark-mode';
            $isReportsActive = request()->routeIs('reports*');
        @endphp

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="{{ $baseClass }} {{ request()->routeIs('dashboard') ? $activeClass : '' }}">
            <i class="fa-solid fa-house w-4 text-center"></i> 
            <span class="tracking-wide uppercase text-[11px] font-bold">Dashboard</span>
        </a>

        {{-- Sales --}}
        <a href="{{ route('sales') }}" 
            class="{{ $baseClass }} {{ request()->routeIs('sales') ? $activeClass : '' }}">
            <i class="fa-brands fa-salesforce w-4 text-center"></i> 
            <span class="tracking-wide uppercase text-[11px] font-bold">Sales</span>
        </a>

        {{-- POS --}}
        <a href="{{ route('pos') }}" 
            class="{{ $baseClass }} {{ request()->routeIs('pos') ? $activeClass : '' }}">
            <i class="fa-solid fa-cart-shopping w-4 text-center"></i> 
            <span class="tracking-wide uppercase text-[11px] font-bold">POS</span>
        </a>

        {{-- Purchases --}}
        <a href="{{ route('po.index') }}"
            class="{{ $baseClass }} {{ request()->routeIs('po.index') ? $activeClass : '' }}">
            <i class="fa-solid fa-file-invoice w-4 text-center"></i> 
            <span class="tracking-wide uppercase text-[11px] font-bold">Purchases</span>
        </a>

        {{-- Suppliers (Naya Tab) --}}
        <a href="{{ route('suppliers.index') }}"
            class="{{ $baseClass }} {{ request()->routeIs('suppliers*') ? $activeClass : '' }}">
            <i class="fa-solid fa-truck-field w-4 text-center"></i> 
            <span class="tracking-wide uppercase text-[11px] font-bold">Suppliers</span>
        </a>

        {{-- Inventory --}}
        <a href="{{ route('medicines.index') }}"
            class="{{ $baseClass }} {{ request()->routeIs('medicines.index') ? $activeClass : '' }}">
            <i class="fa-solid fa-boxes-stacked w-4 text-center"></i> 
            <span class="tracking-wide uppercase text-[11px] font-bold">Inventory</span>
        </a>

        {{-- Customers --}}
        <a href="{{ route('customers.index') }}"
            class="{{ $baseClass }} {{ request()->routeIs('customers.index') ? $activeClass : '' }}">
            <i class="fa-solid fa-users w-4 text-center"></i> 
            <span class="tracking-wide uppercase text-[11px] font-bold">Customers</span>
        </a>

        {{-- Reports Center Dropdown --}}
        <div class="relative">
            <button @click="openReports = !openReports" 
                class="w-full {{ $baseClass }} {{ $isReportsActive ? $activeClass : 'hover:bg-white/10' }}">
                <i class="fa-solid fa-chart-line w-4 text-center"></i> 
                <span class="tracking-wide uppercase text-[11px] font-bold flex-1 text-left">Reports Center</span>
                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 mr-4" :class="openReports ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="openReports" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" class="mt-1 space-y-1">
                <a href="{{ route('reports.sales', ['tab' => 'sales']) }}" 
                   class="submenu-link py-2 flex items-center text-[10px] uppercase font-black tracking-widest hover:text-white {{ request('tab') == 'sales' ? 'active-submenu-text' : 'text-blue-100' }}">
                    <i class="fa-solid fa-circle text-[6px] mr-2"></i> Sales Report
                </a>
                <a href="" 
                   class="submenu-link py-2 flex items-center text-[10px] uppercase font-black tracking-widest hover:text-white {{ request('tab') == 'inventory' ? 'active-submenu-text' : 'text-blue-100' }}">
                    <i class="fa-solid fa-circle text-[6px] mr-2"></i> Inventory Report
                </a>
                <a href="" 
                   class="submenu-link py-2 flex items-center text-[10px] uppercase font-black tracking-widest hover:text-white {{ request('tab') == 'activity' ? 'active-submenu-text' : 'text-blue-100' }}">
                    <i class="fa-solid fa-circle text-[6px] mr-2"></i> Profit & Loss Report
                </a>
            </div>
        </div>

        {{-- Settings --}}
        <a href="{{ route('settings') }}" class="{{ $baseClass }} {{ request()->routeIs('settings') ? $activeClass : '' }}">
            <i class="fa-solid fa-gear w-4 text-center"></i> 
            <span class="tracking-wide uppercase text-[11px] font-bold">Settings</span>
        </a>
    </nav>
</aside>