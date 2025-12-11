@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<!-- PAGE CONTENT -->
<main class="overflow-y-auto p-2 bg-gray-100 mt-14">
    <div class="p-6 bg-gray-100">
        <div class="bg-white rounded-xl shadow-md p-6 max-w-5xl mx-auto">

            <!-- Tabs -->
            <div class="border-b flex flex-wrap items-center gap-6 text-gray-600 text-sm font-medium">
                <button class="pb-3 border-b-2 border-blue-600 text-blue-600">
                    General
                </button>
                <button class="pb-3 hover:text-blue-600">Currency & Tax</button>
                <button class="pb-3 hover:text-blue-600">User Roles</button>
                <button class="pb-3 hover:text-blue-600">Backup</button>
            </div>

            <!-- FORM -->
            <div class="mt-6 space-y-4">

                <!-- Pharmacy Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pharmacy Name</label>
                    <input type="text" placeholder="Pharmacy Name"
                        class="w-full md:w-1/2 px-4 py-2 border rounded-lg bg-gray-50 outline-none focus:border-blue-500">
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea rows="3"
                        class="w-full md:w-1/2 px-4 py-2 border rounded-lg bg-gray-50 outline-none focus:border-blue-500"></textarea>
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" placeholder="+1 002-2346789"
                        class="w-full md:w-1/2 px-4 py-2 border rounded-lg bg-gray-50 outline-none focus:border-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email"
                        class="w-full md:w-1/2 px-4 py-2 border rounded-lg bg-gray-50 outline-none focus:border-blue-500">
                </div>

                <!-- Save Button -->
                <div class="pt-3">
                    <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                        Save Changes
                    </button>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')


@endpush