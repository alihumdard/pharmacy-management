@extends('layouts.main')
@section('title', 'Branch Management')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">

    <div class="max-w-7xl mx-auto">
        
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-12 pt-3">Multi-Branch Control Center</h1>

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                <div class="relative w-full md:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search by branch name or location..."
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border border-gray-300 rounded-xl outline-none text-sm text-gray-700 focus:ring-2 focus:ring-blue-400 transition">
                </div>

                <div class="flex items-center gap-3 flex-wrap">

                    <button class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 
                            flex items-center gap-2 shadow-md transition text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-filter text-gray-600"></i>
                         Filter Status
                        <select class="bg-transparent outline-none text-sm ml-1 hidden sm:inline-block">
                            <option>All</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </button>

                    <button onclick="openBranchModal()" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 font-semibold flex items-center gap-2 transition text-sm">
                        <i class="fa-solid fa-code-branch"></i> Add New Branch
                    </button>

                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
                <table class="w-full border-collapse text-sm min-w-[1000px]">

                    <thead>
                        <tr class="bg-blue-600 text-white shadow-md">
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Branch Name</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Location</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Phone</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Manager</th>
                            <th class="py-3 px-5 text-center font-bold uppercase tracking-wider">Status</th>
                            <th class="py-3 px-5 text-center font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-5 font-semibold text-blue-700">Lahore Main Branch</td>
                            <td class="py-4 px-5 text-gray-600 font-medium">Gulberg III, Lahore</td>
                            <td class="py-4 px-5 text-gray-600">+92 42 35751234</td>
                            <td class="py-4 px-5 text-gray-800">Ahmed Ali</td>
                            <td class="py-4 px-5 text-center">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Active
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                                    <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Branch"></i>
                                    <i class="fa-solid fa-eye cursor-pointer hover:text-blue-600" title="View Details"></i>
                                    <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Branch"></i>
                                </div>
                            </td>
                        </tr>
                        
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-5 font-semibold text-gray-800">Karachi Sub Center</td>
                            <td class="py-4 px-5 text-gray-600 font-medium">Clifton, Karachi</td>
                            <td class="py-4 px-5 text-gray-600">+92 21 35678901</td>
                            <td class="py-4 px-5 text-gray-800">Naila Javed</td>
                            <td class="py-4 px-5 text-center">
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> Inactive
                                </span>
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                                    <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Branch"></i>
                                    <i class="fa-solid fa-eye cursor-pointer hover:text-blue-600" title="View Details"></i>
                                    <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Branch"></i>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- Optional: Pagination (Placeholder for completeness) --}}
            <div class="mt-6 flex justify-between items-center text-sm text-gray-600">
                <span>Showing 1 to 10 of 52 results</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">&larr; Previous</button>
                    <button class="px-3 py-1 border rounded-lg hover:bg-gray-100">Next &rarr;</button>
                </div>
            </div>

        </div>

    </div>
</main>


<div id="branchModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 p-4 transition">

    <div
        class="bg-white w-full max-w-2xl max-h-[90vh] mx-auto overflow-y-auto rounded-2xl shadow-2xl p-6 transform transition-all duration-300 scale-95 opacity-0"
        id="branchModalBox">

        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3 flex items-center gap-2">
            <i class="fa-solid fa-sitemap text-blue-600"></i> Add New Branch Location
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="text-sm font-medium text-gray-700">Branch Name <span class="text-red-500">*</span></label>
                <input type="text" placeholder="e.g., Clifton Branch"
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring focus:ring-blue-300 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" placeholder="+92 XXX XXXXXXX"
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring focus:ring-blue-300 focus:border-blue-500 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-700">Location / Address <span class="text-red-500">*</span></label>
                <textarea rows="2" placeholder="Full address including city and area"
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 resize-none focus:ring focus:ring-blue-300 focus:border-blue-500 outline-none transition"></textarea>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Branch Manager</label>
                <select
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring focus:ring-blue-300 focus:border-blue-500 outline-none transition">
                    <option>Select a manager from existing users</option>
                    <option>Ahmed Ali</option>
                    <option>Naila Javed</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700">Status</label>
                <select
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring focus:ring-blue-300 focus:border-blue-500 outline-none transition">
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-8 border-t pt-4">
            <button onclick="closeBranchModal()"
                class="px-5 py-2 bg-gray-200 rounded-xl font-semibold hover:bg-gray-300 transition">
                Cancel
            </button>

            <button
                class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-md font-semibold transition">
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
        modal.classList.add("flex"); // Ensure flex is used for centering

        setTimeout(() => {
            box.classList.remove("scale-95", "opacity-0");
            box.classList.add("scale-100", "opacity-100");
             document.body.style.overflow = 'hidden'; // Lock scrolling
        }, 10);
    }

    function closeBranchModal() {
        const modal = document.getElementById("branchModal");
        const box = document.getElementById("branchModalBox");

        box.classList.remove("scale-100", "opacity-100");
        box.classList.add("scale-95", "opacity-0");

        setTimeout(() => {
            modal.classList.add("hidden");
             modal.classList.remove("flex");
             document.body.style.overflow = ''; // Unlock scrolling
        }, 300);
    }
    
    // Add event listener to handle backdrop clicks
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById("branchModal");
        if (modal) {
            modal.addEventListener('click', (e) => {
                // Only close if the click target is the modal backdrop itself
                if (e.target === modal) {
                    closeBranchModal();
                }
            });
        }
    });
</script>


@endpush