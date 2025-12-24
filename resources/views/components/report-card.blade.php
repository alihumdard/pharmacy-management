@props(['title', 'value', 'icon', 'color'])

<div class="bg-white p-6 rounded-[2rem] shadow-xl border border-gray-50 relative overflow-hidden group hover:scale-105 transition-transform duration-300">
    <div class="absolute -right-4 -top-4 w-24 h-24 bg-{{ $color }}-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest relative z-10">{{ $title }}</p>
    <h2 class="text-2xl font-black text-gray-900 mt-2 relative z-10">{{ $value }}</h2>
    <div class="mt-4 flex items-center justify-between relative z-10">
        <span class="text-[10px] font-bold text-{{ $color }}-600 bg-{{ $color }}-50 px-2 py-1 rounded-lg">Performance Stable</span>
        <i class="fa-solid {{ $icon }} text-{{ $color }}-200 text-2xl"></i>
    </div>
</div>