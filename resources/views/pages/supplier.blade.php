@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')

<!-- PAGE CONTENT -->
<main class="overflow-y-auto p-2 bg-gray-100 mt-16">
    <div class="p-6 bg-gray-100">
        <div class="bg-white rounded-xl shadow-md p-5 max-w-6xl mx-auto h-[500px]">
            <!-- Top Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                <!-- Search -->
                <div class="flex items-center bg-gray-100 px-4 py-2 rounded-lg w-full md:w-1/3">
                    <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
                    <input type="text" placeholder="Search"
                        class="bg-transparent outline-none text-sm w-full pl-2">
                </div>

                <!-- Buttons -->
                <div class="flex flex-wrap items-center gap-3">
                    <button
                        class="px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 flex items-center gap-2">
                        <i class="fa-solid fa-filter text-gray-600"></i>
                        Filter
                    </button>
                    <button onclick="openModal()"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm">
                        Add New Supplier
                    </button>
                </div>

            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm min-w-[600px]">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="py-3 px-4 text-left font-semibold">Supplier Name</th>
                            <th class="py-3 px-4 text-left font-semibold">Contact Person</th>
                            <th class="py-3 px-4 text-left font-semibold">Phone Number</th>
                            <th class="py-3 px-4 text-left font-semibold">Email</th>
                            <th class="py-3 px-4 text-left font-semibold">Balance Due</th>
                            <th class="py-3 px-4 text-left font-semibold"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">MediCorp Distributors</td>
                            <td class="py-3 px-4">Atam Smith</td>
                            <td class="py-3 px-4">+1 002-2346789</td>
                            <td class="py-3 px-4">medicorp@sample.com</td>
                            <td class="py-3 px-4 font-semibold text-red-600">PKR 150,000</td>
                            <td class="py-3 px-4 text-xl text-gray-500 cursor-pointer">...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</main>

<div id="supplierModal"
    class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50 p-3">

    <!-- MODAL BOX (scrollable on mobile if content is large) -->
    <div class="bg-white w-full max-w-[700px] max-h-[85vh] mx-auto mt-12 overflow-y-auto rounded-xl shadow-lg p-5">
        <h2 class="text-xl font-semibold mb-5">Edit Supplier</h2>
        <!-- Form Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <label class="text-sm font-medium">Supplier Name</label>
                <input value="MediCorp Distributors" class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50">
            </div>

            <div>
                <label class="text-sm font-medium">Contact Person</label>
                <input value="Aram Smith" class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50">
            </div>

            <div>
                <label class="text-sm font-medium">Phone Number</label>
                <input value="+1 002-2346789" class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50">
            </div>

            <div>
                <label class="text-sm font-medium">Email</label>
                <input value="medicorp@sample.com" class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50">
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium">Address</label>
                <textarea rows="2"
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50">Industrial Area, Karachi</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium">Opening Balance Due</label>
                <input value="0" class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50">
            </div>

        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 mt-6">
            <button onclick="closeModal()"
                class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Cancel
            </button>

            <button onclick="openSecondModal()"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Update Supplier
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal() {
        document.getElementById("supplierModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("supplierModal").classList.add("hidden");
    }
</script>

@endpush