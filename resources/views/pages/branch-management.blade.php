@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<!-- CONTENT ALWAYS STARTS JUST BELOW NAVBAR -->
<main class="p-2 bg-gray-100 mt-[60px]">
    <div class="p-4">

        <div class="bg-white rounded-xl shadow-md p-6 max-w-6xl mx-auto">

            <!-- Top Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">

                <!-- Search Bar -->
                <div class="flex items-center bg-gray-100 px-3 py-[10px] border border-gray-300 rounded-lg w-full md:w-1/3">
                    <i class="fa-solid fa-search text-gray-500"></i>
                    <input type="text" placeholder="Search"
                        class="bg-transparent outline-none text-sm w-full pl-2">
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 flex-wrap">

                    <button
                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg flex items-center gap-2 hover:bg-gray-100 transition">
                        <i class="fa-solid fa-filter text-gray-600"></i>
                        <select class="bg-transparent outline-none text-sm">
                            <option>Filter</option>
                            <option>Hello</option>
                            <option>Hello</option>
                            <option>Hello</option>
                        </select>
                    </button>

                    <button onclick="openBranchModal()"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        Add New Branch
                    </button>

                </div>
            </div>

            <!-- Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left text-gray-700">
                            <th class="py-3 px-4 font-semibold">Branch Name</th>
                            <th class="py-3 px-4 font-semibold">Location</th>
                            <th class="py-3 px-4 font-semibold">Phone</th>
                            <th class="py-3 px-4 font-semibold">Manager</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                            <th class="py-3 px-4 font-semibold">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 px-4">Lahore Main Branch</td>
                            <td class="py-2 px-4">Gulberg III, Lahore</td>
                            <td class="py-2 px-4">+92 42 35751234</td>
                            <td class="py-2 px-4">Ahmed Ali</td>
                            <td class="py-2 px-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Active
                                </span>
                            </td>
                            <td class="py-2 px-4 flex gap-2">
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">✏️</button>
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">👁️</button>
                                <button class="p-2 px-4 bg-gray-100 hover:bg-gray-200 rounded">⋮</button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 px-4">Lahore Main Branch</td>
                            <td class="py-2 px-4">Gulberg III, Lahore</td>
                            <td class="py-2 px-4">+92 42 35751234</td>
                            <td class="py-2 px-4">Ahmed Ali</td>
                            <td class="py-2 px-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Active
                                </span>
                            </td>
                            <td class="py-2 px-4 flex gap-2">
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">✏️</button>
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">👁️</button>
                                <button class="p-2 px-4 bg-gray-100 hover:bg-gray-200 rounded">⋮</button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 px-4">Lahore Main Branch</td>
                            <td class="py-2 px-4">Gulberg III, Lahore</td>
                            <td class="py-2 px-4">+92 42 35751234</td>
                            <td class="py-2 px-4">Ahmed Ali</td>
                            <td class="py-2 px-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Active
                                </span>
                            </td>
                            <td class="py-2 px-4 flex gap-2">
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">✏️</button>
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">👁️</button>
                                <button class="p-2 px-4 bg-gray-100 hover:bg-gray-200 rounded">⋮</button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 px-4">Lahore Main Branch</td>
                            <td class="py-2 px-4">Gulberg III, Lahore</td>
                            <td class="py-2 px-4">+92 42 35751234</td>
                            <td class="py-2 px-4">Ahmed Ali</td>
                            <td class="py-2 px-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Active
                                </span>
                            </td>
                            <td class="py-2 px-4 flex gap-2">
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">✏️</button>
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">👁️</button>
                                <button class="p-2 px-4 bg-gray-100 hover:bg-gray-200 rounded">⋮</button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 px-4">Lahore Main Branch</td>
                            <td class="py-2 px-4">Gulberg III, Lahore</td>
                            <td class="py-2 px-4">+92 42 35751234</td>
                            <td class="py-2 px-4">Ahmed Ali</td>
                            <td class="py-2 px-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Active
                                </span>
                            </td>
                            <td class="py-2 px-4 flex gap-2">
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">✏️</button>
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">👁️</button>
                                <button class="p-2 px-4 bg-gray-100 hover:bg-gray-200 rounded">⋮</button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 px-4">Lahore Main Branch</td>
                            <td class="py-2 px-4">Gulberg III, Lahore</td>
                            <td class="py-2 px-4">+92 42 35751234</td>
                            <td class="py-2 px-4">Ahmed Ali</td>
                            <td class="py-2 px-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Active
                                </span>
                            </td>
                            <td class="py-2 px-4 flex gap-2">
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">✏️</button>
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">👁️</button>
                                <button class="p-2 px-4 bg-gray-100 hover:bg-gray-200 rounded">⋮</button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 px-4">Lahore Main Branch</td>
                            <td class="py-2 px-4">Gulberg III, Lahore</td>
                            <td class="py-2 px-4">+92 42 35751234</td>
                            <td class="py-2 px-4">Ahmed Ali</td>
                            <td class="py-2 px-4">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Active
                                </span>
                            </td>
                            <td class="py-2 px-4 flex gap-2">
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">✏️</button>
                                <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded">👁️</button>
                                <button class="p-2 px-4 bg-gray-100 hover:bg-gray-200 rounded">⋮</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</main>
<div id="branchModal"
    class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50 p-4 transition">

    <!-- Modal Box -->
    <div
        class="bg-white w-full max-w-[850px] max-h-[80vh] mx-auto mt-12 overflow-y-auto rounded-xl shadow-xl p-6 transform transition-all duration-300 scale-95 opacity-0"
        id="branchModalBox">

        <h2 class="text-2xl font-semibold mb-6">Add New Branch</h2>

        <!-- Form Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="text-sm font-medium">Branch Name</label>
                <input type="text" placeholder="Branch Name"
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200 outline-none">
            </div>

            <div>
                <label class="text-sm font-medium">Location / Address</label>
                <textarea rows="2" placeholder="Location / Address"
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 resize-none focus:ring focus:ring-blue-200 outline-none"></textarea>
            </div>

            <div>
                <label class="text-sm font-medium">Phone Number</label>
                <input type="text" placeholder="Phone Number"
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200 outline-none">
            </div>

            <div>
                <label class="text-sm font-medium">Manager</label>
                <select
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200 outline-none">
                    <option>Inactive</option>
                    <option>Active</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-medium">Branch Manager</label>
                <select
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200 outline-none">
                    <option>Select a manager from existing users</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-medium">Status</label>
                <select
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200 outline-none">
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 mt-8">
            <button onclick="closeBranchModal()"
                class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Cancel
            </button>

            <button
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Save Branch
            </button>
        </div>

    </div>
</div>


@endsection

@push('scripts')

<script>
    function openBranchModal() {
        const modal = document.getElementById("branchModal");
        const box = document.getElementById("branchModalBox");

        modal.classList.remove("hidden");

        setTimeout(() => {
            box.classList.remove("scale-95", "opacity-0");
            box.classList.add("scale-100", "opacity-100");
        }, 10);
    }

    function closeBranchModal() {
        const modal = document.getElementById("branchModal");
        const box = document.getElementById("branchModalBox");

        box.classList.add("scale-95", "opacity-0");

        setTimeout(() => {
            modal.classList.add("hidden");
        }, 200);
    }
</script>


@endpush