@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')

        <!-- PAGE CONTENT -->
        <main class="overflow-y-auto bg-gray-100 mt-16 p-4 min-h-[calc(100vh-70px)]">

            <div class="max-w-[1200px] mx-auto">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- LEFT PANEL -->
                    <div class="bg-white rounded-xl shadow p-6">

                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Product Selection Grid</h3>
                            <button
                                class="w-9 h-9 flex items-center justify-center bg-gray-100 rounded-full shadow hover:bg-gray-200">
                                <i class="fa-solid fa-qrcode text-gray-600"></i>
                            </button>
                        </div>

                        <!-- Search + Category -->
                        <div class="flex flex-col sm:flex-row items-center gap-3 mb-5">
                            <div class="relative w-full">
                                <i
                                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input class="w-full pl-10 pr-3 py-2 bg-gray-100 rounded-xl outline-none"
                                    placeholder="Search">
                            </div>

                            <select
                                class="px-3 py-2 rounded-lg border border-gray-300 bg-white text-sm w-full sm:w-auto">
                                <option>Categories</option>
                            </select>
                        </div>

                        <!-- PRODUCT GRID (scrollable) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-[70vh] overflow-y-auto pr-2">

                            <!-- PRODUCT CARD -->
                            <div class="p-3 border rounded-xl bg-white shadow-sm">
                                <span class="text-xs text-gray-600 bg-gray-200 px-2 py-1 rounded-full">Quick Add</span>

                                <div class="flex items-center gap-3 mt-2">
                                    <img src="/assets/images/Panadol Extra 600x600.jpg"
                                        class="w-16 h-16 rounded-lg object-cover shadow" />

                                    <div class="flex-1">
                                        <p class="font-semibold text-sm text-gray-800">Panadol Extra</p>
                                        <p class="text-xs text-gray-500">50 Boxes</p>

                                        <div class="flex items-center mt-2">
                                            <p class="font-semibold text-sm">PKR 330.00</p>

                                            <button
                                                class="ml-3 w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
                                                <i class="fa-solid fa-plus text-[11px] text-gray-700"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border rounded-xl bg-white shadow-sm">
                                <span class="text-xs text-gray-600 bg-gray-200 px-2 py-1 rounded-full">Quick Add</span>

                                <div class="flex items-center gap-3 mt-2">
                                    <img src="/assets/images/AugmentinTablets625Mg.webp"
                                        class="w-16 h-16 rounded-lg object-cover shadow" />

                                    <div class="flex-1">
                                        <p class="font-semibold text-sm text-gray-800">Panadol Extra</p>
                                        <p class="text-xs text-gray-500">50 Boxes</p>

                                        <div class="flex items-center mt-2">
                                            <p class="font-semibold text-sm">PKR 330.00</p>

                                            <button
                                                class="ml-3 w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
                                                <i class="fa-solid fa-plus text-[11px] text-gray-700"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border rounded-xl bg-white shadow-sm">
                                <span class="text-xs text-gray-600 bg-gray-200 px-2 py-1 rounded-full">Quick Add</span>

                                <div class="flex items-center gap-3 mt-2">
                                    <img src="/assets/images/images (4).jpg"
                                        class="w-16 h-16 rounded-lg object-cover shadow" />

                                    <div class="flex-1">
                                        <p class="font-semibold text-sm text-gray-800">Panadol Extra</p>
                                        <p class="text-xs text-gray-500">50 Boxes</p>

                                        <div class="flex items-center mt-2">
                                            <p class="font-semibold text-sm">PKR 330.00</p>

                                            <button
                                                class="ml-3 w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
                                                <i class="fa-solid fa-plus text-[11px] text-gray-700"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border rounded-xl bg-white shadow-sm">
                                <span class="text-xs text-gray-600 bg-gray-200 px-2 py-1 rounded-full">Quick Add</span>

                                <div class="flex items-center gap-3 mt-2">
                                    <img src="/assets/images/Panadol Extra 600x600.jpg"
                                        class="w-16 h-16 rounded-lg object-cover shadow" />

                                    <div class="flex-1">
                                        <p class="font-semibold text-sm text-gray-800">Panadol Extra</p>
                                        <p class="text-xs text-gray-500">50 Boxes</p>

                                        <div class="flex items-center mt-2">
                                            <p class="font-semibold text-sm">PKR 330.00</p>

                                            <button
                                                class="ml-3 w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
                                                <i class="fa-solid fa-plus text-[11px] text-gray-700"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border rounded-xl bg-white shadow-sm">
                                <span class="text-xs text-gray-600 bg-gray-200 px-2 py-1 rounded-full">Quick Add</span>

                                <div class="flex items-center gap-3 mt-2">
                                    <img src="/assets/images/images (4).jpg"
                                        class="w-16 h-16 rounded-lg object-cover shadow" />

                                    <div class="flex-1">
                                        <p class="font-semibold text-sm text-gray-800">Panadol Extra</p>
                                        <p class="text-xs text-gray-500">50 Boxes</p>

                                        <div class="flex items-center mt-2">
                                            <p class="font-semibold text-sm">PKR 330.00</p>

                                            <button
                                                class="ml-3 w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
                                                <i class="fa-solid fa-plus text-[11px] text-gray-700"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 border rounded-xl bg-white shadow-sm">
                                <span class="text-xs text-gray-600 bg-gray-200 px-2 py-1 rounded-full">Quick Add</span>

                                <div class="flex items-center gap-3 mt-2">
                                    <img src="/assets/images/AugmentinTablets625Mg.webp"
                                        class="w-16 h-16 rounded-lg object-cover shadow" />

                                    <div class="flex-1">
                                        <p class="font-semibold text-sm text-gray-800">Panadol Extra</p>
                                        <p class="text-xs text-gray-500">50 Boxes</p>

                                        <div class="flex items-center mt-2">
                                            <p class="font-semibold text-sm">PKR 330.00</p>

                                            <button
                                                class="ml-3 w-6 h-6 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">
                                                <i class="fa-solid fa-plus text-[11px] text-gray-700"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>

                    <!-- RIGHT PANEL -->
                    <div class="bg-white rounded-xl shadow p-6">

                        <!-- Header -->
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-semibold">Current Sale Receipt</h3>

                            <div class="text-sm text-gray-500 text-right">
                                <p>Order #: <span class="font-semibold">10018373</span></p>
                                <p>Date: <span>16 Apr 2022</span></p>
                            </div>
                        </div>

                        <!-- RECEIPT LIST -->
                        <div class="border-b pb-4 mt-4 space-y-3 max-h-[45vh] overflow-y-auto">

                            <!-- ITEM -->
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl shadow-sm">
                                <div class="flex items-center gap-3">
                                    <img src="/assets/images/Panadol Extra 600x600.jpg"
                                        class="w-12 h-12 rounded-lg shadow" />

                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Panadol Extra</p>
                                        <p class="text-xs text-gray-500">Discount</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">

                                    <!-- Quantity -->
                                    <div class="flex items-center bg-white border px-2 py-1 rounded-lg">
                                        <button class="px-2 text-gray-600"><i class="fa-solid fa-minus"></i></button>
                                        <span class="px-2 font-semibold">1</span>
                                        <button class="px-2 text-gray-600"><i class="fa-solid fa-plus"></i></button>
                                    </div>

                                    <p class="font-semibold text-sm">PKR 330.00</p>

                                    <button class="text-red-500"><i class="fa-solid fa-trash"></i></button>
                                </div>

                            </div>


                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl shadow-sm">
                                <div class="flex items-center gap-3">
                                    <img src="/assets/images/images (4).jpg"
                                        class="w-12 h-12 rounded-lg shadow" />

                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">Panadol Extra</p>
                                        <p class="text-xs text-gray-500">Discount</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">

                                    <!-- Quantity -->
                                    <div class="flex items-center bg-white border px-2 py-1 rounded-lg">
                                        <button class="px-2 text-gray-600"><i class="fa-solid fa-minus"></i></button>
                                        <span class="px-2 font-semibold">1</span>
                                        <button class="px-2 text-gray-600"><i class="fa-solid fa-plus"></i></button>
                                    </div>

                                    <p class="font-semibold text-sm">PKR 330.00</p>

                                    <button class="text-red-500"><i class="fa-solid fa-trash"></i></button>
                                </div>

                            </div>

                        </div>

                        <!-- TOTALS -->
                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span> <span class="font-semibold">PKR 580.00</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Tax (GST 17%)</span> <span class="font-semibold">PKR 70.00</span>
                            </div>

                            <div class="flex justify-between text-gray-600">
                                <span>Total Discount</span> <span class="font-semibold">PKR 0.00</span>
                            </div>

                            <div class="flex justify-between text-lg font-bold border-t pt-3">
                                <span>Grand Total</span> <span>PKR 580.00</span>
                            </div>
                        </div>

                        <!-- PAYMENT BUTTONS -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6">

                            <button
                                class="bg-green-600 text-white py-2 rounded-lg flex items-center justify-center gap-2">
                                <i class="fa-solid fa-money-bill-wave"></i> Cash
                            </button>

                            <button
                                class="bg-blue-600 text-white py-2 rounded-lg flex items-center justify-center gap-2">
                                <i class="fa-solid fa-credit-card"></i> Card
                            </button>

                            <button
                                class="bg-purple-600 text-white py-2 rounded-lg text-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-file-invoice"></i> Credit Sale
                            </button>

                            <button
                                class="bg-gray-500 text-white py-2 rounded-lg text-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left"></i> Hold/Recall
                            </button>

                        </div>

                        <!-- CUSTOMER SELECT -->
                        <div class="mt-4">
                            <select class="w-full px-4 py-2 border rounded-lg bg-gray-50">
                                <option>Customer @Pharmacy</option>
                            </select>
                        </div>

                    </div>
                </div>

            </div>

        </main>

@endsection

@push('scripts')


@endpush
