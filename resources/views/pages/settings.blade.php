@extends('layouts.main')
@section('title', 'System Configuration')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)] pt-24 bg-gray-50">

    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-12 pt-3 uppercase italic tracking-tighter">System Configuration & Master Setup</h1>

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">

            <div class="border-b border-gray-300 flex flex-wrap items-center gap-6 text-gray-600 text-base font-semibold mb-6">
                {{-- Tab Buttons --}}
                <button data-tab="general" class="tab-button active-tab pb-3 border-b-2 border-blue-600 text-blue-600 transition duration-200">
                    <i class="fa-solid fa-cogs mr-1"></i> General Details
                </button>
                <button data-tab="currency_tax" class="tab-button pb-3 hover:text-blue-600 border-b-2 border-transparent transition duration-200">
                    <i class="fa-solid fa-calculator mr-1"></i> Currency & Tax
                </button>
                <button data-tab="user_roles" class="tab-button pb-3 hover:text-blue-600 border-b-2 border-transparent transition duration-200">
                    <i class="fa-solid fa-users-cog mr-1"></i> User Roles
                </button>
                <button data-tab="backup" class="tab-button pb-3 hover:text-blue-600 border-b-2 border-transparent transition duration-200">
                    <i class="fa-solid fa-hdd mr-1"></i> Backup & Restore
                </button>
            </div>

            <div id="settingsContent" class="py-4">
                
                {{-- TAB 1: GENERAL SETTINGS FORM --}}
                <form action="{{ route('settings.update.general') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div data-content="general" class="tab-content active-content">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Pharmacy Contact and Branding</h3>
                        
                        <div class="flex flex-col lg:flex-row gap-10">
                            {{-- Logo Upload with Preview --}}
                            <div class="w-full lg:w-1/3 flex flex-col items-center text-center">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Pharmacy Logo / Profile Image</label>
                                <div class="relative group">
                                    <img id="logoPreview" 
                                         src="{{ ($settings && $settings->logo) ? asset('storage/'.$settings->logo) : '/assets/images/images (3).jpg' }}" 
                                         class="w-48 h-48 rounded-3xl object-cover border-4 border-blue-50 shadow-2xl transition group-hover:opacity-75">
                                    <input type="file" name="logo" onchange="previewImage(this)" class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                                <p class="text-[9px] text-gray-400 mt-4 italic">Click image to upload new logo</p>
                            </div>

                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pharmacy Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="pharmacy_name" value="{{ $settings->pharmacy_name ?? '' }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">User Name (for Sidebar) <span class="text-red-500">*</span></label>
                                    <input type="text" name="user_name" value="{{ $settings->user_name ?? '' }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ $settings->phone_number ?? '' }}" placeholder="+92 XXX XXXXXXX"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" value="{{ $settings->email ?? '' }}" placeholder="info@pharmacy.com"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                                </div>
                                 <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tax/Registration ID</label>
                                    <input type="text" name="tax_id" value="{{ $settings->tax_id ?? '' }}" placeholder="E.g., NTN 1234567-8"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Physical Address</label>
                                    <textarea name="address" rows="3" placeholder="Shop Address, City, Postal Code"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition resize-none">{{ $settings->address ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="pt-8 border-t border-gray-200 mt-8 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg font-semibold transition">
                                <i class="fa-solid fa-save mr-2"></i> Save General Settings
                            </button>
                        </div>
                    </div>
                </form>

                {{-- TAB 2: CURRENCY & TAX (Static UI preserved) --}}
                <div data-content="currency_tax" class="tab-content hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Currency and Tax Configuration</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Currency Symbol <span class="text-red-500">*</span></label>
                            <input type="text" value="{{ $settings->currency ?? 'PKR' }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Default Sales Tax Rate (GST)</label>
                            <div class="relative">
                                <input type="number" value="{{ $settings->tax_rate ?? '17' }}" class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none transition">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-600 font-semibold">%</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price Decimal Places</label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none transition">
                                <option>2 (e.g., 100.00)</option>
                                <option>0 (e.g., 100)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                {{-- TAB 3: USER ROLES (Static UI preserved) --}}
                <div data-content="user_roles" class="tab-content hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">User Roles & Permissions Setup</h3>
                    <div class="flex flex-col lg:flex-row gap-8">
                        {{-- Static Roles Sidebar --}}
                        <div class="w-full lg:w-56 border-b lg:border-b-0 lg:border-r border-gray-300 pb-4 lg:pb-0 lg:pr-6 space-y-3">
                            <h4 class="font-bold text-gray-700 mb-3 uppercase tracking-wider text-xs">Roles Directory</h4>
                            <button data-role="admin" class="role-selector w-full text-left px-4 py-2 rounded-xl hover:bg-gray-100 transition duration-200 text-gray-700 font-semibold shadow-sm">Admin</button>
                            <button data-role="manager" class="role-selector active-role w-full text-left px-4 py-2 rounded-xl bg-blue-100 text-blue-700 border border-blue-300 transition duration-200 font-bold shadow-md">Manager</button>
                            <button data-role="cashier" class="role-selector w-full text-left px-4 py-2 rounded-xl hover:bg-gray-100 transition duration-200 text-gray-700 font-semibold shadow-sm">Cashier</button>
                        </div>
                        {{-- Static Permissions --}}
                        <div class="flex-1 space-y-6">
                            <h4 class="text-lg font-extrabold text-blue-600 mb-4">Permissions for: <span id="activeRoleName" class="font-black">Manager</span></h4>
                            <div class="border border-gray-200 rounded-xl p-4 shadow-sm">
                                <h3 class="font-extrabold text-gray-800 mb-3 flex items-center gap-2 border-b pb-2"><i class="fa-solid fa-boxes-stacked text-teal-600"></i> Inventory Management</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-sm">
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded" checked> View Stock</label>
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded" checked> Add Product</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB 4: BACKUP (Static UI preserved) --}}
                <div data-content="backup" class="tab-content hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Backup & Restore</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 shadow-inner">
                            <p class="text-sm font-medium text-gray-700 mb-1">Last Backup Taken:</p>
                            <p class="text-lg font-bold text-gray-900">12 Dec 2025 at 09:00 AM</p>
                        </div>
                        <div class="flex items-center md:justify-end">
                            <button class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl shadow-lg font-extrabold transition text-base flex items-center gap-2">
                                <i class="fa-solid fa-arrow-down-to-disk"></i> Initiate Manual Backup
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Image Preview Logic 
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        const roleSelectors = document.querySelectorAll('.role-selector');
        const activeRoleName = document.getElementById('activeRoleName');

        function switchTab(tabName) {
            tabButtons.forEach(btn => {
                const isActive = btn.dataset.tab === tabName;
                btn.classList.toggle('text-blue-600', isActive);
                btn.classList.toggle('border-blue-600', isActive);
                btn.classList.toggle('border-transparent', !isActive);
            });

            tabContents.forEach(content => {
                content.classList.toggle('hidden', content.dataset.content !== tabName);
            });
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => switchTab(button.dataset.tab));
        });

        function switchRole(roleName) {
            roleSelectors.forEach(btn => {
                const isActive = btn.dataset.role === roleName;
                btn.classList.toggle('bg-blue-100', isActive);
                btn.classList.toggle('text-blue-700', isActive);
                btn.classList.toggle('border-blue-300', isActive);
            });
            if (activeRoleName) activeRoleName.textContent = roleName.charAt(0).toUpperCase() + roleName.slice(1);
        }

        roleSelectors.forEach(button => {
            button.addEventListener('click', () => switchRole(button.dataset.role));
        });
    });
</script>
@endpush