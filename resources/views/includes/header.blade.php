<header id="mainHeader" class="bg-white hidden sm:flex border-b border-gray-200 px-6 py-4 justify-between items-center z-40 w-full transition-all duration-300 shadow-sm">

    {{-- Left Side: Dashboard Title --}}
    <div class="flex items-center">
        <h2 class="text-xl md:text-2xl font-extrabold text-gray-900 tracking-tight flex items-center">
            <i class="fa-solid fa-tachometer-alt text-blue-600 mr-3"></i> 
            <span>Dashboard</span>
        </h2>
    </div>

    {{-- Right Side: Action Icons --}}
    <div class="flex items-center gap-4 md:gap-8 text-gray-500">
        
        {{-- Notifications --}}
        <div class="relative cursor-pointer hover:text-blue-600 transition-colors duration-200 p-1" title="Notifications">
            <i class="fa-regular fa-bell text-xl"></i>
            {{-- Animated notification badge --}}
            <span class="absolute top-1 right-1 h-2.5 w-2.5 bg-red-600 rounded-full animate-pulse border-2 border-white"></span>
        </div>

        {{-- Help Icon --}}
        <div class="cursor-pointer hover:text-blue-600 transition-colors duration-200 p-1" title="Help & Support">
            <i class="fa-regular fa-circle-question text-xl"></i>
        </div>
        
        {{-- Logout Button --}}
        <button class="flex items-center justify-center p-1 group transition-all duration-200" title="Logout">
            <i class="fa-solid fa-right-from-bracket text-red-500 group-hover:text-red-600 text-xl"></i>
        </button>
        
    </div>

</header>