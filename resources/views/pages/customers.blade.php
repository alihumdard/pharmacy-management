@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')


<!-- CONTENT ALWAYS STARTS JUST BELOW NAVBAR -->
<main class="overflow-y-auto p-2 bg-gray-100 mt-16">
    <div class="p-6">

        <div class="bg-white rounded-xl shadow-md p-6 max-w-6xl mx-auto h-[500px]">

            <!-- Top Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">

                <!-- Search -->
                <div class="flex items-center bg-gray-100 px-4 py-[10px] border border-gray-300 rounded-lg w-full md:w-1/3 shadow-sm">
                    <i class="fa-solid fa-search text-gray-500"></i>
                    <input type="text" placeholder="Search"
                        class="bg-transparent outline-none text-sm w-full pl-2">
                </div>

                <div class="flex items-center gap-3 flex-wrap">

                    <!-- Filter Button -->
                    <button
                        class="px-4 py-2 bg-white border rounded-lg hover:bg-gray-50 flex items-center gap-2 shadow-sm transition">
                        <i class="fa-solid fa-filter text-gray-600"></i>
                        Filter
                    </button>

                    <!-- Add Customer Button -->
                    <button onclick="openCustomerModal()"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition">
                        Add New Customer
                    </button>

                </div>

            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="py-3 px-4 text-left font-semibold">Customer Name</th>
                            <th class="py-3 px-4 text-left font-semibold">Phone Number</th>
                            <th class="py-3 px-4 text-left font-semibold">Total Purchases</th>
                            <th class="py-3 px-4 text-left font-semibold">Credit Balance</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Ali Khan</td>
                            <td class="py-3 px-4">+1 007-2346789</td>
                            <td class="py-3 px-4">10</td>
                            <td class="py-3 px-4 text-red-600 font-semibold">PKR 5,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</main>
<!-- CUSTOMER MODAL -->
<div id="customerModal"
    class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center z-50 p-4 transition">

    <!-- MODAL BOX -->
    <div id="customerModalBox"
        class="bg-white w-full max-w-[850px] max-h-[80vh] mx-auto mt-12 overflow-y-auto rounded-xl shadow-2xl p-6 transform scale-95 opacity-0 transition-all duration-300">

        <h2 class="text-2xl font-semibold mb-6">Add New Customer</h2>

        <!-- FORM -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="text-sm font-medium">Customer Name</label>
                <input
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200 transition"
                    value="Ali Khan">
            </div>

            <div>
                <label class="text-sm font-medium">Phone Number</label>
                <input
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200 transition"
                    value="+1 002-2346789">
            </div>

            <div>
                <label class="text-sm font-medium">Email <span class="text-gray-500">(Optional)</span></label>
                <input
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200 transition"
                    value="ali.khan@example.com">
            </div>

            <div>
                <label class="text-sm font-medium">Address <span class="text-gray-500">(Optional)</span></label>
                <textarea
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200 transition resize-none"
                    rows="2">House 12, Street 5, Lahore</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="text-sm font-medium">Opening Credit Balance</label>
                <input
                    class="w-full mt-1 px-3 py-2 border rounded-md bg-gray-50 outline-none focus:ring focus:ring-blue-200 transition"
                    value="0">
            </div>

        </div>

        <!-- BUTTONS -->
        <div class="flex justify-end gap-3 mt-8">
            <button onclick="closeCustomerModal()"
                class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">Cancel</button>

            <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md transition">
                Update Customer
            </button>
        </div>

    </div>

</div>


@endsection

@push('scripts')

<script>
    function openCustomerModal() {
        const modal = document.getElementById("customerModal");
        const box = document.getElementById("customerModalBox");

        modal.classList.remove("hidden");

        setTimeout(() => {
            box.classList.remove("scale-95", "opacity-0");
            box.classList.add("scale-100", "opacity-100");
        }, 10);
    }

    function closeCustomerModal() {
        const modal = document.getElementById("customerModal");
        const box = document.getElementById("customerModalBox");

        box.classList.add("scale-95", "opacity-0");

        setTimeout(() => {
            modal.classList.add("hidden");
        }, 200);
    }
</script>
@endpush