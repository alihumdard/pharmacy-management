<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    /* Active Tab Design */
    .active-dark-mode {
        background-color: #ffffff !important;
        color: #1d4ed8 !important;
        font-weight: 700;
        border-top-left-radius: 9999px;
        border-bottom-left-radius: 9999px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transform: scale(1.02);
    }

    .active-dark-mode i { color: #1d4ed8 !important; }

    .nav-link-base {
        transition: all 0.2s ease-in-out;
        padding-left: 1rem;
    }

    .submenu-link {
        transition: all 0.2s;
        padding-left: 3.5rem;
    }

    .active-submenu-text {
        color: #fbbf24 !important;
        font-weight: 800;
    }

    [x-cloak] { display: none !important; }

    /* Sidebar height fix for mobile */
    @media (max-width: 767px) {
        #sidebar {
            height: 100vh !important;
            height: 100dvh !important; /* Dynamic viewport height for mobile browsers */
        }
    }
</style>

<div x-data="{ sidebarOpen: false }" class="relative flex min-h-screen bg-gray-50">

    <div class="fixed top-4 left-4 z-40 md:hidden">
        <button @click="sidebarOpen = true" 
                class="p-2 bg-[#1d4ed8] text-white rounded-lg shadow-lg active:scale-95 transition-transform">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
    </div>

    <div x-show="sidebarOpen" 
         x-cloak
         @click="sidebarOpen = false" 
         x-transition:enter="transition opacity-0 ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition opacity-100 ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 z-40 md:hidden backdrop-blur-sm">
    </div>

    <aside id="sidebar" 
        x-data="{ openReports: {{ request()->routeIs('reports*') ? 'true' : 'false' }} }"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
        class="fixed inset-y-0 left-0 w-64 bg-[#1d4ed8] py-6 pl-4 overflow-y-auto transition-transform duration-300 ease-in-out z-50 text-white font-sans md:sticky md:top-0 shadow-2xl md:shadow-none">

        <div class="md:hidden absolute top-4 right-4 z-[60]">
            <button @click="sidebarOpen = false" 
                    class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 border border-white/20 transition-all">
                <i class="fa-solid fa-xmark text-lg text-white"></i>
            </button>
        </div>

        {{-- Branding Section --}}
        <div class="mb-8 flex items-center p-3 mx-2 pr-12 md:pr-3">
            @if(isset($siteSettings) && $siteSettings->logo)
                <img src="{{ asset('storage/' . $siteSettings->logo) }}"
                    class="w-11 h-11 rounded-full mr-3 border-2 border-white shadow-md object-cover">
            @else
                <img src="{{ asset('assets/images/images (3).jpg') }}"
                    class="w-11 h-11 rounded-full mr-3 border-2 border-white shadow-md object-cover">
            @endif
            <div class="overflow-hidden">
                <p class="font-bold text-white text-md leading-tight truncate">{{ $siteSettings->user_name ?? 'User Name' }}</p>
                <p class="text-[10px] text-blue-200 font-bold uppercase tracking-wider mt-1 italic truncate">
                    {{ $siteSettings->pharmacy_name ?? 'Pharmacy Name' }}
                </p>
            </div>
        </div>

        <hr class="mb-4 border-white/10 mr-4">

        <nav class="space-y-1.5">
            @php
                $baseClass = 'nav-link-base flex items-center gap-3 px-4 py-2 text-sm text-white';
                $activeClass = 'active-dark-mode';
                $isReportsActive = request()->routeIs('reports*');
            @endphp

            <a href="{{ route('dashboard') }}" class="{{ $baseClass }} {{ request()->routeIs('dashboard') ? $activeClass : '' }}">
                <i class="fa-solid fa-house w-4 text-center"></i>
                <span class="tracking-wide uppercase text-[11px] font-bold">Dashboard</span>
            </a>

            <a href="{{ route('sales') }}" class="{{ $baseClass }} {{ request()->routeIs('sales') ? $activeClass : '' }}">
                <i class="fa-brands fa-salesforce w-4 text-center"></i>
                <span class="tracking-wide uppercase text-[11px] font-bold">Sales</span>
            </a>

            <a href="{{ route('pos') }}" class="{{ $baseClass }} {{ request()->routeIs('pos') ? $activeClass : '' }}">
                <i class="fa-solid fa-cart-shopping w-4 text-center"></i>
                <span class="tracking-wide uppercase text-[11px] font-bold">POS</span>
            </a>

            <a href="{{ route('po.index') }}" class="{{ $baseClass }} {{ request()->routeIs('po.index') ? $activeClass : '' }}">
                <i class="fa-solid fa-file-invoice w-4 text-center"></i>
                <span class="tracking-wide uppercase text-[11px] font-bold">Purchases</span>
            </a>

            <a href="{{ route('suppliers.index') }}" class="{{ $baseClass }} {{ request()->routeIs('suppliers*') ? $activeClass : '' }}">
                <i class="fa-solid fa-truck-field w-4 text-center"></i>
                <span class="tracking-wide uppercase text-[11px] font-bold">Suppliers</span>
            </a>

            <a href="{{ route('medicines.index') }}" class="{{ $baseClass }} {{ request()->routeIs('medicines.index') ? $activeClass : '' }}">
                <i class="fa-solid fa-boxes-stacked w-4 text-center"></i>
                <span class="tracking-wide uppercase text-[11px] font-bold">Inventory</span>
            </a>

            <a href="{{ route('customers.index') }}" class="{{ $baseClass }} {{ request()->routeIs('customers.index') ? $activeClass : '' }}">
                <i class="fa-solid fa-users w-4 text-center"></i>
                <span class="tracking-wide uppercase text-[11px] font-bold">Customers</span>
            </a>

            <div class="relative">
                <button @click="openReports = !openReports"
                    class="w-full {{ $baseClass }} {{ $isReportsActive ? $activeClass : 'hover:bg-white/10' }}">
                    <i class="fa-solid fa-chart-line w-4 text-center"></i>
                    <span class="tracking-wide uppercase text-[11px] font-bold flex-1 text-left">Reports Center</span>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 mr-4"
                        :class="openReports ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="openReports" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2" class="mt-1 space-y-1">
                    <a href="{{ route('reports.sales', ['tab' => 'sales']) }}"
                        class="submenu-link py-2 flex items-center text-[10px] uppercase font-black tracking-widest hover:text-white {{ request('tab') == 'sales' ? 'active-submenu-text' : 'text-blue-100' }}">
                        <i class="fa-solid fa-circle text-[6px] mr-2"></i> Sales Report
                    </a>
                    <a href="{{ route('reports.medicine') }}"
                        class="submenu-link py-2 flex items-center text-[10px] uppercase font-black tracking-widest hover:text-white {{ request()->routeIs('reports.medicine') ? 'active-submenu-text text-white' : 'text-blue-100' }}">
                        <i class="fa-solid fa-circle text-[6px] mr-2 {{ request()->routeIs('reports.medicine') ? 'text-white' : '' }}"></i>
                        Inventory Report
                    </a>
                    <a href="{{ route('reports.profit_loss') }}"
                        class="submenu-link py-2 flex items-center text-[10px] uppercase font-black tracking-widest hover:text-white {{ request()->routeIs('reports.profit_loss') ? 'active-submenu-text text-white' : 'text-blue-100' }}">
                        <i class="fa-solid fa-circle text-[6px] mr-2 {{ request()->routeIs('reports.profit_loss') ? 'text-white' : '' }}"></i>
                        Profit & Loss Report
                    </a>
                </div>
            </div>

            <a href="{{ route('settings') }}" class="{{ $baseClass }} {{ request()->routeIs('settings') ? $activeClass : '' }}">
                <i class="fa-solid fa-gear w-4 text-center"></i>
                <span class="tracking-wide uppercase text-[11px] font-bold">Settings</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1">
        </main>
</div>