@extends('layouts.main')
@section('title', 'System Configuration')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">

    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-12 pt-3">System Configuration & Master Setup</h1>

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
                
                <div data-content="general" class="tab-content active-content">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Pharmacy Contact and Branding</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Input Fields --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pharmacy Name <span class="text-red-500">*</span></label>
                            <input type="text" placeholder="Your Pharmacy Name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" placeholder="+92 XXX XXXXXXX"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" placeholder="info@pharmacy.com"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                        </div>
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tax/Registration ID</label>
                            <input type="text" placeholder="E.g., NTN 1234567-8"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Physical Address</label>
                            <textarea rows="3" placeholder="Shop Address, City, Postal Code"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition resize-none"></textarea>
                        </div>
                        
                    </div>
                    
                    <div class="pt-8 border-t border-gray-200 mt-8 flex justify-end">
                        <button class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg font-semibold transition">
                            <i class="fa-solid fa-save mr-2"></i> Save General Settings
                        </button>
                    </div>
                </div>

                <div data-content="currency_tax" class="tab-content hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Currency and Tax Configuration</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Currency Symbol <span class="text-red-500">*</span></label>
                            <input type="text" value="PKR"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Default Sales Tax Rate (GST)</label>
                            <div class="relative">
                                <input type="number" value="17"
                                    class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-600 font-semibold">%</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price Decimal Places</label>
                            <select
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-300 transition">
                                <option>2 (e.g., 100.00)</option>
                                <option>0 (e.g., 100)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="pt-8 border-t border-gray-200 mt-8 flex justify-end">
                        <button class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg font-semibold transition">
                            <i class="fa-solid fa-save mr-2"></i> Save Tax & Currency
                        </button>
                    </div>
                </div>
                
                <div data-content="user_roles" class="tab-content hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">User Roles & Permissions Setup</h3>
                    
                    <div class="flex flex-col lg:flex-row gap-8">

                        <div class="w-full lg:w-56 border-b lg:border-b-0 lg:border-r border-gray-300 pb-4 lg:pb-0 lg:pr-6 space-y-3">
                            
                            <h4 class="font-bold text-gray-700 mb-3 uppercase tracking-wider text-xs">Roles Directory</h4>

                            <button data-role="admin" class="role-selector w-full text-left px-4 py-2 rounded-xl hover:bg-gray-100 transition duration-200 text-gray-700 font-semibold shadow-sm">
                                Admin
                            </button>

                            <button data-role="manager" class="role-selector active-role w-full text-left px-4 py-2 rounded-xl bg-blue-100 
                                text-blue-700 border border-blue-300 transition duration-200 font-bold shadow-md">
                                Manager
                            </button>

                            <button data-role="cashier" class="role-selector w-full text-left px-4 py-2 rounded-xl hover:bg-gray-100 transition duration-200 text-gray-700 font-semibold shadow-sm">
                                Cashier
                            </button>
                            
                            <button class="w-full text-left px-4 py-2 rounded-xl bg-green-100 hover:bg-green-200 transition duration-200 text-green-700 font-bold shadow-sm flex items-center gap-2 justify-center mt-4">
                                <i class="fa-solid fa-plus text-sm"></i> Add New Role
                            </button>

                        </div>

                        <div class="flex-1 space-y-6">
                            
                            <h4 class="text-lg font-extrabold text-blue-600 mb-4">Permissions for: <span id="activeRoleName" class="font-black">Manager</span></h4>

                            <div class="border border-gray-200 rounded-xl p-4 shadow-sm">
                                <h3 class="font-extrabold text-gray-800 mb-3 flex items-center gap-2 border-b pb-2"><i class="fa-solid fa-boxes-stacked text-teal-600"></i> Inventory Management</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-sm">
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded"> View Stock</label>
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded" checked> Add Product</label>
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded" checked> Edit Product</label>
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded"> Delete Product</label>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-xl p-4 shadow-sm">
                                <h3 class="font-extrabold text-gray-800 mb-3 flex items-center gap-2 border-b pb-2"><i class="fa-solid fa-cash-register text-teal-600"></i> Point of Sale (POS)</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-sm">
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded" checked> Process Sale</label>
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded" checked> Apply Discount</label>
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded" checked> Hold/Recall Sale</label>
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded"> Edit Final Price</label>
                                </div>
                            </div>
                            
                             <div class="border border-gray-200 rounded-xl p-4 shadow-sm">
                                <h3 class="font-extrabold text-gray-800 mb-3 flex items-center gap-2 border-b pb-2"><i class="fa-solid fa-chart-line text-teal-600"></i> Reporting</h3>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 text-sm">
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded" checked> View Sales Reports</label>
                                    <label class="flex items-center gap-2 font-medium text-gray-700"><input type="checkbox" class="form-checkbox text-blue-600 rounded"> View Profit Reports</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="flex justify-end lg:col-span-2 pt-6 border-t border-gray-200 w-full mt-8">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl shadow-lg font-semibold transition">
                            <i class="fa-solid fa-save mr-2"></i> Update Manager Permissions
                        </button>
                    </div>
                    
                </div>

                <div data-content="backup" class="tab-content hidden">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Data Backup & Restore</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 shadow-inner">
                            <p class="text-sm font-medium text-gray-700 mb-1">Last Backup Taken:</p>
                            <p class="text-lg font-bold text-gray-900">12 Dec 2025 at 09:00 AM</p>
                            <p class="text-xs text-green-600 mt-1"><i class="fa-solid fa-check-circle mr-1"></i> Backup successful and stored safely.</p>
                        </div>

                        <div class="flex items-center md:justify-end">
                            <button class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-xl shadow-lg font-extrabold transition text-base flex items-center gap-2">
                                <i class="fa-solid fa-arrow-down-to-disk"></i> Initiate Manual Backup
                            </button>
                        </div>
                        
                        <div class="md:col-span-2 border-t pt-4 mt-4">
                            <h4 class="font-bold text-gray-700 mb-2">Restore Database</h4>
                            <p class="text-sm text-gray-600 mb-3">Upload a backup file to restore data (Use with caution).</p>
                            <input type="file" class="w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-red-50 file:text-red-700
                                hover:file:bg-red-100 transition duration-300">
                        </div>

                    </div>
                    
                    <div class="pt-8 border-t border-gray-200 mt-8 flex justify-end">
                        <button class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg font-semibold transition">
                            <i class="fa-solid fa-save mr-2"></i> Save Backup Settings
                        </button>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</main>
@endsection

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        const roleSelectors = document.querySelectorAll('.role-selector');
        const activeRoleName = document.getElementById('activeRoleName');

        // --- 1. Tab Switching Logic ---
        function switchTab(tabName) {
            // Update Tab Buttons UI
            tabButtons.forEach(btn => {
                const isActive = btn.dataset.tab === tabName;
                btn.classList.toggle('text-blue-600', isActive);
                btn.classList.toggle('border-blue-600', isActive);
                btn.classList.toggle('border-transparent', !isActive);
                btn.classList.toggle('active-tab', isActive);
            });

            // Switch Content
            tabContents.forEach(content => {
                content.classList.toggle('hidden', content.dataset.content !== tabName);
                content.classList.toggle('active-content', content.dataset.content === tabName);
            });
            
            // If the User Roles tab is activated, ensure a role is selected
            if (tabName === 'user_roles') {
                 // Check if 'Manager' is the active role, otherwise default to the first
                const currentlyActiveRole = document.querySelector('.role-selector.active-role');
                if (!currentlyActiveRole) {
                    switchRole('manager');
                }
            }
        }

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                switchTab(button.dataset.tab);
            });
        });

        // --- 2. Role Switching Logic (User Roles Tab) ---
        function switchRole(roleName) {
            // Update Active Role UI
            roleSelectors.forEach(btn => {
                const isActive = btn.dataset.role === roleName;
                
                // Clear all custom classes for clean switch
                btn.classList.remove('bg-blue-100', 'text-blue-700', 'border', 'border-blue-300', 'font-bold', 'shadow-md', 'active-role');
                btn.classList.add('hover:bg-gray-100', 'text-gray-700', 'font-semibold', 'shadow-sm');
                
                // Apply active styles
                if (isActive) {
                    btn.classList.add('bg-blue-100', 'text-blue-700', 'border', 'border-blue-300', 'font-bold', 'shadow-md', 'active-role');
                    btn.classList.remove('hover:bg-gray-100', 'text-gray-700', 'font-semibold', 'shadow-sm');
                }
            });

            // Update Active Role Text and Save Button Text
            const roleText = roleName.charAt(0).toUpperCase() + roleName.slice(1);
            if (activeRoleName) {
                activeRoleName.textContent = roleText;
            }
            
            const saveButton = document.querySelector('[data-content="user_roles"] button.bg-green-600');
            if (saveButton) {
                 saveButton.innerHTML = `<i class="fa-solid fa-save mr-2"></i> Update ${roleText} Permissions`;
            }

             // NOTE: In a real app, logic would load permissions here based on roleName
             // Example: Load different checkboxes/checked states here
        }

        roleSelectors.forEach(button => {
            button.addEventListener('click', () => {
                switchRole(button.dataset.role);
            });
        });

        // Initialize: Start on the General tab.
        switchTab('general');
        // Initialize Manager role visually for the static HTML content
        switchRole('manager'); 
    });
</script>
@endpush