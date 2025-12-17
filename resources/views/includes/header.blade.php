<header id="mainHeader" class="bg-white border-b border-gray-200 p-4 
                        flex justify-between items-center z-40 w-full transition-all duration-300 shadow-xl">

    <div class="flex items-center gap-4">
        
        <button class="md:hidden text-2xl text-gray-700 hover:text-blue-600 transition" 
                onclick="toggleSidebar()" title="Toggle Menu">
            <i class="fa-solid fa-bars"></i>
        </button>

        <h2 class="text-xl md:text-2xl font-extrabold text-gray-900 tracking-tight">
            {{-- This should ideally be dynamic based on the page --}}
            <i class="fa-solid fa-tachometer-alt text-blue-600 mr-2 hidden sm:inline"></i> Dashboard
        </h2>
    </div>

    <div class="flex items-center gap-4 md:gap-6 text-gray-600 text-lg md:text-xl">
        

        <div class="relative cursor-pointer hover:text-red-500 transition" title="Notifications">
            <i class="fa-regular fa-bell"></i>
            {{-- Animated notification badge --}}
            <span class="absolute -top-1 -right-1 h-2.5 w-2.5 bg-red-600 rounded-full animate-pulse border border-white"></span>
        </div>

        <i class="fa-regular fa-circle-question cursor-pointer hover:text-blue-600 transition" title="Help & Support"></i>
        
        <button class="flex items-center gap-2 cursor-pointer hover:opacity-80 transition" title="User Profile / Logout">
            <i class="fa-solid fa-right-from-bracket text-red-500 hover:text-red-600 transition"></i>
        </button>
    </div>

</header>