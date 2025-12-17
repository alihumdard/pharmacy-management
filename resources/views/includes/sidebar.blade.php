<style>
    /* ** Custom styles for the DARK MODE Active Link ** */
    .active-dark-mode {
        background-color: #ffffff; /* White background */
        color: #1f2937; /* pos-text-main (Dark Gray) */
        font-weight: 700;
        /* Use a standard, clean rounded shape for the active tab */
        border-top-left-radius: 9999px;
        border-bottom-left-radius: 9999px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Stronger shadow on the white tab */        
        transform: scale(1.02); 
    }
    .active-dark-mode i {
        color: #1f2937; /* Dark icon color */
    }
    
    /* Global transition for smoothness */
    .nav-link-base {
        transition: all 0.2s ease-in-out;
        /* Increase left padding slightly for better look on dark background */
        padding-left: 1rem; 
    }
    
    /* Hover state for inactive (white text) links */
   

    /* Mobile Transition adjustment */
    @media (max-width: 767px) {
        #sidebar.transform.translate-x-0 {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    }
</style>

<aside
    id="sidebar"
    {{-- Main Sidebar Background is Royal Blue (#1d4ed8) --}}
    class="w-64 bg-[#1d4ed8] py-6 pl-4 overflow-y-auto min-h-screen 
           transform -translate-x-full absolute md:relative md:translate-x-0
           transition-all duration-300 top-0 left-0 z-50 md:z-40 text-white font-sans">

    <div class="mb-6 flex items-center p-3 mx-2">
        <img src="/assets/images/images (3).jpg" class="w-11 h-11 rounded-full mr-3 border-2 border-white shadow-md object-cover" alt="User Avatar">
        <div>
            <p class="font-bold text-white text-md">User Name</p>
            <p class="text-sm text-pos-primary font-medium">@Pharmacy Name</p>
        </div>
    </div>

    <hr class="mb-4 border-white/10">

    <nav class="space-y-1.5"> 

        @php
            // Define refined base class for navigation links
            // Text color is white by default
            $baseClass = 'nav-link-base flex items-center gap-3 px-4 py-2 text-sm text-white'; 
            // Define the custom active class for dark mode
            $activeClass = 'active-dark-mode';
        @endphp

        {{-- Dashboard --}}
        @if(view_permission('index'))
            <a href="{{ route('dashboard') }}"
               class=" {{ $baseClass }} {{ request()->routeIs('dashboard') ? $activeClass : '' }}">
                <i class="fa-solid fa-house w-4 h-4 text-lg mb-3 mr-2"></i>
                Dashboard
            </a>
        @endif

        {{-- POS --}}
        <a href="{{ route('pos') }}"
           class="{{ $baseClass }} {{ request()->routeIs('pos') ? $activeClass : '' }}">
            <i class="fa-solid fa-cart-shopping w-4 h-4 text-lg mb-3 mr-2"></i>
            POS
        </a>

        {{-- Sales --}}
        <a href="{{ route('sales') }}"
           class="{{ $baseClass }} {{ request()->routeIs('sales') ? $activeClass : '' }}">
            <i class="fa-brands fa-salesforce w-4 h-4 text-lg mb-3 mr-2"></i>
            Sales
        </a>

        {{-- Purchases --}}
        <a href="{{ route('purchases') }}"
           class="{{ $baseClass }} {{ request()->routeIs('purchases') ? $activeClass : '' }}">
            <i class="fa-solid fa-file-invoice w-4 h-4 text-lg mb-3 mr-2"></i>
            Purchases
        </a>

        {{-- Inventory --}}
        <a href="{{ route('medicines.index') }}"
           class="{{ $baseClass }} {{ request()->routeIs('medicines.index') ? $activeClass : '' }}">
            <i class="fa-solid fa-boxes-stacked w-4 h-4 text-lg mb-3 mr-2"></i>
            Inventory
        </a>

        {{-- Medicine Database --}}
        <a href="{{ route('medicine.database') }}"
           class="{{ $baseClass }} {{ request()->routeIs('medicine.database') ? $activeClass : '' }}">
            <i class="fa-solid fa-capsules w-4 h-4 text-lg mb-3 mr-2"></i>
            M.Database
        </a>

        {{-- Customers --}}
        <a href="{{ route('customers.index') }}"
           class="{{ $baseClass }} {{ request()->routeIs('customers.index') ? $activeClass : '' }}">
            <i class="fa-solid fa-users w-4 h-4 text-lg mb-3 mr-2"></i>
            Customers
        </a>

        {{-- Suppliers --}}
        <a href="{{ route('suppliers.index') }}"
           class="{{ $baseClass }} {{ request()->routeIs('suppliers.index') ? $activeClass : '' }}">
            <i class="fa-brands fa-supple w-4 h-4 text-lg mb-3 mr-2"></i>
            Suppliers
        </a>

        {{-- Reports --}}
        <a href="{{ route('reports') }}"
           class="{{ $baseClass }} {{ request()->routeIs('reports') ? $activeClass : '' }}">
            <i class="fa-solid fa-chart-line w-4 h-4 text-lg mb-3 mr-2"></i>
            Reports
        </a>

        {{-- Settings --}}
        <a href="{{ route('settings') }}"
           class="{{ $baseClass }} {{ request()->routeIs('settings') ? $activeClass : '' }}">
            <i class="fa-solid fa-gear w-4 h-4 text-lg mb-3 mr-2"></i>
            Settings
        </a>

        {{-- Branch Management --}}
        <a href="{{ route('branch.management') }}"
           class="{{ $baseClass }} {{ request()->routeIs('branch.management') ? $activeClass : '' }}">
            <i class="fa-solid fa-code-branch w-4 h-4 text-lg mb-3 mr-2"></i>
            B.Management
        </a>

        {{-- <p class="mt-6 mb-2 ml-2 font-bold text-pos-primary uppercase text-xs tracking-wider border-t pt-4 border-white/10">System Tools</p> --}}

        {{-- Audit Log --}}
        <a href="{{ route('audit.logs') }}"
           class="{{ $baseClass }} {{ request()->routeIs('audit.logs') ? $activeClass : '' }}">
            <i class="fa-solid fa-list-check w-4 h-4 text-lg mb-3 mr-2"></i>
            Audit Log
        </a>

    </nav>

</aside>