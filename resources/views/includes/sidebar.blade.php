<!-- SIDEBAR (MOBILE SLIDE + DESKTOP FIXED) -->
<aside id="sidebar" class="w-64 h-screen bg-white shadow-lg p-5 overflow-y-auto
        transform -translate-x-full md:translate-x-0 transition-all duration-300
        fixed top-0 left-0 z-50 md:z-40">

  <div class="flex items-center gap-2 mb-6">
    <i class="fa-solid fa-hospital text-blue-600 text-2xl"></i>
    <h1 class="text-3xl font-bold">Hospital</h1>
  </div>
  <div class="mb-4 flex">
    <img src="/assets/images/images (3).jpg" class="w-12 h-12 rounded-full mr-3" alt="">
    <div>
      <p class="font-semibold text-[var(--text-dark)]">User Name</p>
      <p class="text-sm text-[var(--text-light)]">@Pharmacy Name</p>
    </div>
  </div>
  <hr class="mb-3">
<nav class="space-y-2 text-black">

    {{-- Dashboard --}}
    @if(view_permission('index'))
    <a href="{{ route('dashboard') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i> Dashboard
    </a>
    @endif

    {{-- POS --}}
    <a href="{{ route('pos') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('pos') ? 'active' : '' }}">
      <i class="fa-solid fa-cart-shopping"></i> POS
    </a>

    {{-- Sales --}}
    <a href="{{ route('sales') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-[var(--sidebar-hover)] {{ request()->routeIs('sales') ? 'active' : '' }}">
      <i class="fa-brands fa-salesforce"></i> Sales
    </a>

    {{-- Purchases --}}
    <a href="{{ route('purchases') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-[var(--sidebar-hover)] {{ request()->routeIs('purchases') ? 'active' : '' }}">
      <i class="fa-solid fa-file-invoice"></i> Purchases
    </a>

    {{-- Inventory --}}
    <a href="{{ route('inventory') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('inventory') ? 'active' : '' }}">
      <i class="fa-solid fa-boxes-stacked"></i> Inventory
    </a>

    {{-- Medicine Database --}}
    <a href="{{ route('medicine.database') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-[var(--sidebar-hover)] {{ request()->routeIs('medicine.database') ? 'active' : '' }}">
      <i class="fa-solid fa-capsules"></i> M.Database
    </a>

    {{-- Customers --}}
    <a href="{{ route('customers') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-[var(--sidebar-hover)] {{ request()->routeIs('customers') ? 'active' : '' }}">
      <i class="fa-solid fa-users"></i> Customers
    </a>

    {{-- Suppliers --}}
    <a href="{{ route('suppliers') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-[var(--sidebar-hover)] {{ request()->routeIs('suppliers') ? 'active' : '' }}">
      <i class="fa-brands fa-supple"></i> Suppliers
    </a>

    {{-- Reports --}}
    <a href="{{ route('reports') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('reports') ? 'active' : '' }}">
      <i class="fa-solid fa-chart-line"></i> Reports
    </a>

    {{-- Settings --}}
    <a href="{{ route('settings') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-[var(--sidebar-hover)] {{ request()->routeIs('settings') ? 'active' : '' }}">
      <i class="fa-solid fa-gear"></i> Settings
    </a>

    {{-- Branch Management --}}
    <a href="{{ route('branch.management') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-[var(--sidebar-hover)] {{ request()->routeIs('branch.management') ? 'active' : '' }}">
      <i class="fa-solid fa-code-branch"></i> B.Management
    </a>

    {{-- Rules & Permission --}}
    <a href="{{ route('roles.permissions') }}"
      class="flex items-center gap-2 px-4 py-2 rounded hover:bg-[var(--sidebar-hover)] {{ request()->routeIs('roles.permissions') ? 'active' : '' }}">
      <i class="fa-solid fa-scale-balanced"></i> Rules & Permission
    </a>

    <p class="mt-4 font-bold text-[var(--text-dark)] text-md">System</p>

    {{-- Audit Log --}}
    <a href="{{ route('audit.logs') }}"
      class="flex items-center gap-2 px-4 py-2 rounded bg-[var(--primary-light)] text-[var(--primary)] {{ request()->routeIs('audit.logs') ? 'active' : '' }}">
      <i class="fa-solid fa-list-check"></i> Audit Log
    </a>

</nav>


</aside>