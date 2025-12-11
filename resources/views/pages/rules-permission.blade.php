@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
        <!-- PAGE CONTENT -->

        <main class="overflow-y-auto p-2 bg-gray-100 mt-16">
            <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl p-6 mt-6">

                <!-- Tabs -->
                <div class="flex flex-wrap gap-6 border-b pb-3 text-sm font-medium text-gray-600">
                    <button class="hover:text-blue-600">General</button>
                    <button class="hover:text-blue-600">Currency & Tax</button>
                    <button class="text-blue-600 border-b-2 border-blue-600">User Roles</button>
                    <button class="hover:text-blue-600">Backup</button>
                </div>

                <!-- CONTENT -->
                <div class="mt-6 flex flex-col lg:flex-row gap-8">

                    <!-- ROLES LIST -->
                    <div class="w-full lg:w-40 border-r lg:border-r pr-0 lg:pr-4 space-y-2">

                        <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-100">
                            Admin
                        </button>

                        <button class="w-full text-left px-3 py-2 rounded-lg bg-blue-50 
                       text-blue-700 border border-blue-200">
                            Manager
                        </button>

                        <button class="w-full text-left px-3 py-2 rounded-lg hover:bg-gray-100">
                            Cashier
                        </button>

                    </div>

                    <!-- PERMISSIONS -->
                    <div class="flex-1 space-y-6">

                        <!-- Inventory -->
                        <div>
                            <h3 class="font-semibold mb-2">Inventory</h3>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <label class="flex items-center gap-2"><input type="checkbox"> View</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> Add</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> Edit</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> Delete</label>
                            </div>
                        </div>

                        <!-- POS -->
                        <div>
                            <h3 class="font-semibold mb-2">POS</h3>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <label class="flex items-center gap-2"><input type="checkbox"> Process Sale</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> Give Discount</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> View Change</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> View puetis</label>
                            </div>
                        </div>

                        <!-- Customers -->
                        <div>
                            <h3 class="font-semibold mb-2">Customers</h3>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <label class="flex items-center gap-2"><input type="checkbox"> View, Add, Edit
                                    Item</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> Delete</label>
                            </div>
                        </div>

                        <!-- Cashier Permissions -->
                        <div>
                            <h3 class="font-semibold mb-2">Cashier Permissions</h3>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <label class="flex items-center gap-2"><input type="checkbox"> View where</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> Edit Item</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> Edit</label>
                                <label class="flex items-center gap-2"><input type="checkbox"> Delete</label>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SAVE BUTTON -->
                <div class="flex justify-end mt-10">
                    <button onclick="openUserModal()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                        Save Permissions
                    </button>
                </div>

            </div>
        </main>
        <div id="userModal" class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50 p-4">

            <div class="bg-white w-full max-w-3xl mx-auto mt-12 rounded-xl shadow-lg 
                p-6 max-h-[90vh] overflow-y-auto">

                <h2 class="text-xl font-semibold mb-6">Add New User</h2>

                <!-- FORM GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="text-sm font-medium">Full Name</label>
                        <input type="text" placeholder="Full Name"
                            class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" placeholder="medicorp@sample.com"
                            class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" placeholder="Password"
                            class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Confirm Password</label>
                        <input type="password" placeholder="Password"
                            class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200">
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Assign Role</label>
                        <select
                            class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200">
                            <option>Admin</option>
                            <option>Manager</option>
                            <option>Cashier</option>
                        </select>
                    </div>

                </div>

                <!-- BUTTONS -->
                <div class="flex justify-end gap-3 mt-8">
                    <button onclick="closeUserModal()" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg">
                        Cancel
                    </button>

                    <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Save User
                    </button>
                </div>

            </div>
        </div>
@endsection

@push('scripts')
    <script>
        function openUserModal() {
            document.getElementById("userModal").classList.remove("hidden");
        }
        function closeUserModal() {
            document.getElementById("userModal").classList.add("hidden");
        }
    </script>

@endpush
