<!-- NAVBAR (ALWAYS FIXED TOP) -->
<header class="fixed top-0 left-0 right-0 md:left-64 bg-white shadow p-4
                       flex justify-between items-center z-40">

    <!-- Mobile Button -->
    <button class="md:hidden text-2xl" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Title -->
    <h2 class="text-xl font-bold text-black">Dashboard</h2>

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