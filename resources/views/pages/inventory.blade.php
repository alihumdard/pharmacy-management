@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<!-- CONTENT ALWAYS STARTS JUST BELOW NAVBAR -->
<main class="overflow-y-auto p-4 bg-gray-100 mt-[70px]">

    <div class="max-w-7xl mx-auto">

        <div id="supplierModal" class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">

            <!-- Top Controls -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

                <!-- Search Bar -->
                <div class="flex items-center bg-gray-100 px-4 py-2 rounded-lg w-full md:w-1/3 
                            border border-gray-200 shadow-sm">
                    <i class="fa-solid fa-search text-gray-500"></i>
                    <input type="text" placeholder="Search"
                        class="bg-transparent outline-none text-sm w-full pl-2">
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 flex-wrap">

                    <!-- Filter Button -->
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 
                               flex items-center gap-2 shadow-sm transition">
                        <i class="fa-solid fa-filter text-gray-600"></i> Filter
                    </button>

                    <!-- Add Medicine Button -->
                    <button onclick="openProductModal()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg 
                               shadow-md transition">
                        Add New Medicine
                    </button>

                </div>

            </div>

            <!-- Table Wrapper -->
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">

                <table class="w-full border-collapse text-sm">

                    <!-- Table Header -->
                    <thead class="bg-gray-100 text-gray-700 text-left">
                        <tr>
                            <th class="py-3 px-4 font-semibold">Medicine Name</th>
                            <th class="py-3 px-4 font-semibold">Batch No.</th>
                            <th class="py-3 px-4 font-semibold">Expiry Date</th>
                            <th class="py-3 px-4 font-semibold">Stock Level</th>
                            <th class="py-3 px-4 font-semibold">Purchase Price</th>
                            <th class="py-3 px-4 font-semibold">Sale Price</th>
                            <th class="py-3 px-4 text-right font-semibold"></th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200">

                        <!-- Row 1 -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Medicine Dnoestile</td>
                            <td class="py-3 px-4">2B0031</td>
                            <td class="py-3 px-4">13/06/2022</td>
                            <td class="py-3 px-4">3 Boxes</td>
                            <td class="py-3 px-4">$100</td>
                            <td class="py-3 px-4">$200</td>
                            <td class="py-3 px-4 text-right">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-600 cursor-pointer"></i>
                            </td>
                        </tr>

                        <!-- Low Stock -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Panadol Extra</td>
                            <td class="py-3 px-4">2B0063</td>
                            <td class="py-3 px-4">13/06/2022</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-xs">
                                    Low Stock
                                </span>
                            </td>
                            <td class="py-3 px-4">$150</td>
                            <td class="py-3 px-4">$300</td>
                            <td class="py-3 px-4 text-right">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-600 cursor-pointer"></i>
                            </td>
                        </tr>

                        <!-- Additional Rows -->
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Panadol Data</td>
                            <td class="py-3 px-4">2B0045</td>
                            <td class="py-3 px-4">08/06/2022</td>
                            <td class="py-3 px-4">3 Boxes</td>
                            <td class="py-3 px-4">$100</td>
                            <td class="py-3 px-4">$250</td>
                            <td class="py-3 px-4 text-right">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-600 cursor-pointer"></i>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Panadol Data</td>
                            <td class="py-3 px-4">2B0045</td>
                            <td class="py-3 px-4">08/06/2022</td>
                            <td class="py-3 px-4">3 Boxes</td>
                            <td class="py-3 px-4">$100</td>
                            <td class="py-3 px-4">$250</td>
                            <td class="py-3 px-4 text-right">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-600 cursor-pointer"></i>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Panadol Data</td>
                            <td class="py-3 px-4">2B0045</td>
                            <td class="py-3 px-4">08/06/2022</td>
                            <td class="py-3 px-4">3 Boxes</td>
                            <td class="py-3 px-4">$100</td>
                            <td class="py-3 px-4">$250</td>
                            <td class="py-3 px-4 text-right">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-600 cursor-pointer"></i>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Panadol Data</td>
                            <td class="py-3 px-4">2B0045</td>
                            <td class="py-3 px-4">08/06/2022</td>
                            <td class="py-3 px-4">3 Boxes</td>
                            <td class="py-3 px-4">$100</td>
                            <td class="py-3 px-4">$250</td>
                            <td class="py-3 px-4 text-right">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-600 cursor-pointer"></i>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Panadol Data</td>
                            <td class="py-3 px-4">2B0045</td>
                            <td class="py-3 px-4">08/06/2022</td>
                            <td class="py-3 px-4">3 Boxes</td>
                            <td class="py-3 px-4">$100</td>
                            <td class="py-3 px-4">$250</td>
                            <td class="py-3 px-4 text-right">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-600 cursor-pointer"></i>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4">Panadol Data</td>
                            <td class="py-3 px-4">2B0045</td>
                            <td class="py-3 px-4">08/06/2022</td>
                            <td class="py-3 px-4">3 Boxes</td>
                            <td class="py-3 px-4">$100</td>
                            <td class="py-3 px-4">$250</td>
                            <td class="py-3 px-4 text-right">
                                <i class="fa-solid fa-ellipsis-vertical text-gray-600 cursor-pointer"></i>
                            </td>
                        </tr>


                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>

<!-- PRODUCT MODAL (parent) -->
<div id="productModal"
    class="fixed inset-0 bg-black bg-opacity-40 hidden flex justify-center items-center z-50 p-4">
    <div id="productModalBox"
        class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl flex flex-col overflow-hidden transform transition-all duration-200 scale-95 opacity-0"
        style="max-height:85vh;">
        <!-- header -->
        <div class="p-5 border-b sticky top-0 bg-white z-10">
            <h2 class="text-xl font-bold">Add New Product</h2>
        </div>

        <!-- body -->
        <div class="flex-1 overflow-y-auto px-5 pb-6 pt-4 space-y-8">
            <section>
                <h4 class="font-semibold mb-3">Basic Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm font-medium">Product Name</label>
                        <input id="p_name"
                            class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Generic Name</label>
                        <input id="p_generic"
                            class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Category</label>
                        <select id="p_cat"
                            class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200">
                            <option>Select Category</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Manufacturer</label>
                        <select id="p_man"
                            class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200">
                            <option>Select Manufacturer</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-medium">Description</label>
                        <textarea id="p_desc" rows="2"
                            class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 resize-none focus:ring focus:ring-blue-200"></textarea>
                    </div>
                </div>
            </section>

            <section>
                <div class="flex items-center justify-between">
                    <h4 class="font-semibold">Product Variants</h4>
                    <button id="openVariantBtn"
                        class="px-3 py-2 bg-white border rounded-lg shadow-sm flex items-center gap-2 hover:bg-gray-50">
                        <i class="fa-solid fa-plus text-blue-600"></i> Add Variant
                    </button>
                </div>
                <p class="text-sm text-gray-600 mb-3">Add variants for different strengths, pack sizes, etc.</p>

                <div class="border rounded-xl overflow-hidden bg-white shadow-sm">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 text-left">Variant</th>
                                <th class="py-3 px-4 text-left">Strength</th>
                                <th class="py-3 px-4 text-left">Pack</th>
                                <th class="py-3 px-4 text-left">Price</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4"></th>
                            </tr>
                        </thead>
                        <tbody id="variantsTbody" class="divide-y">
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3 px-4">Panadol-500mg-10s</td>
                                <td class="py-3 px-4">500mg</td>
                                <td class="py-3 px-4">10 tablets</td>
                                <td class="py-3 px-4">PKR 120</td>
                                <td class="py-3 px-4 text-green-600 font-semibold">Active</td>
                                <td class="py-3 px-4 flex gap-3 text-blue-600 text-lg">
                                    <i class="fa-solid fa-pen cursor-pointer"></i>
                                    <i class="fa-solid fa-trash text-red-600 cursor-pointer"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section>
                <h4 class="font-semibold mb-3">Default Pricing & Stock</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm font-medium">Default Purchase Price (TP)</label>
                        <input id="p_tp" type="number"
                            class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Default Sales Price (MRP)</label>
                        <input id="p_mrp" type="number"
                            class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200" />
                    </div>
                    <div>
                        <label class="text-sm font-medium">Default Reorder Level</label>
                        <input id="p_reorder" type="number" value="1"
                            class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 focus:ring focus:ring-blue-200" />
                    </div>
                </div>
            </section>
        </div>

        <!-- footer -->
        <div class="p-5 border-t bg-white flex justify-end gap-3 sticky bottom-0">
            <button onclick="closeProductModal()"
                class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cancel</button>
            <button id="saveProductBtn" onclick="openVariantModal()"
                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Product</button>
        </div>
    </div>
</div>

<!-- VARIANT MODAL (child) -->
<!-- VARIANT MODAL -->
<!-- VARIANT MODAL -->
<div id="variantModal" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-[60] p-3">

    <div id="variantModalBox" class="bg-white w-full max-w-lg mx-auto rounded-2xl shadow-2xl 
              transform transition-all duration-200 scale-95 opacity-0
              max-h-[85vh] overflow-y-auto">

        <!-- INNER WRAPPER FOR PADDING -->
        <div class="p-6">

            <!-- TITLE -->
            <h3 class="text-2xl font-bold mb-6 text-gray-900 text-center sm:text-left">
                Add Product Variant
            </h3>

            <!-- FORM GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm font-medium text-gray-700">Variant SKU / Name</label>
                    <input id="v_name" type="text" placeholder="Panadol-500mg-10s" class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 
                        focus:ring-2 focus:ring-blue-300 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Strength</label>
                    <input id="v_strength" type="text" placeholder="500mg" class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 
                        focus:ring-2 focus:ring-blue-300 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Pack Size</label>
                    <input id="v_pack" type="text" placeholder="10 tablets" class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 
                        focus:ring-2 focus:ring-blue-300 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Barcode</label>
                    <input id="v_barcode" type="text" class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 
                        focus:ring-2 focus:ring-blue-300 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Purchase Price (TP)</label>
                    <input id="v_tp" type="number" value="1" class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 
                        focus:ring-2 focus:ring-blue-300 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Sales Price (MRP)</label>
                    <input id="v_mrp" type="number" value="1" class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 
                        focus:ring-2 focus:ring-blue-300 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Opening Stock</label>
                    <input id="v_stock" type="number" value="1" class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 
                        focus:ring-2 focus:ring-blue-300 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Reorder Level</label>
                    <input id="v_reorder" type="number" value="1" class="mt-1 w-full px-3 py-2 border rounded-md bg-gray-50 
                        focus:ring-2 focus:ring-blue-300 outline-none">
                </div>

            </div>

            <!-- BUTTONS -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8">

                <button onclick="closeVariantModal()"
                    class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>

                <button id="saveVariantBtn"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition">
                    Save Variant
                </button>

            </div>

        </div> <!-- padding wrapper -->
    </div>
</div>
@endsection

@push('scripts')

<script>
    /* ------------------------------
           Modal helpers + behavior
        -------------------------------*/
    function setBodyScrollLock(lock) {
        document.body.style.overflow = lock ? 'hidden' : '';
    }

    function animateOpen(container, box) {
        container.classList.remove('hidden');
        setBodyScrollLock(true);
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        requestAnimationFrame(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100', 'animate-scaleFade');
            setTimeout(() => box.classList.remove('animate-scaleFade'), 300);
        });
    }

    function animateClose(container, box) {
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            container.classList.add('hidden');
            // unlock if no modal visible
            if (!document.querySelector('.fixed.inset-0:not(.hidden)')) {
                setBodyScrollLock(false);
            }
        }, 220);
    }

    // elements
    const productModal = document.getElementById('productModal');
    const productModalBox = document.getElementById('productModalBox');
    const variantModal = document.getElementById('variantModal');
    const variantModalBox = document.getElementById('variantModalBox');
    const openVariantBtn = document.getElementById('openVariantBtn');
    const openVariantFromSaveBtn = document.getElementById('saveProductBtn'); // "Save Product" opens child variant in this demo

    // open/close
    function openProductModal() {
        animateOpen(productModal, productModalBox);
    }

    function closeProductModal() {
        animateClose(productModal, productModalBox);
    }

    function openVariantModal() {
        // make parent inert visually & non-interactive
        productModalBox.classList.add('pointer-events-none', 'opacity-60');
        animateOpen(variantModal, variantModalBox);
    }

    function closeVariantModal() {
        animateClose(variantModal, variantModalBox);
        setTimeout(() => productModalBox.classList.remove('pointer-events-none', 'opacity-60'), 260);
    }

    // open child from parent button
    if (openVariantBtn) openVariantBtn.addEventListener('click', (e) => {
        e.preventDefault();
        openVariantModal();
    });

    // backdrop click
    productModal.addEventListener('click', (e) => {
        if (e.target === productModal) closeProductModal();
    });
    variantModal.addEventListener('click', (e) => {
        if (e.target === variantModal) closeVariantModal();
    });

    // ESC key closes topmost modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (!variantModal.classList.contains('hidden')) closeVariantModal();
            else if (!productModal.classList.contains('hidden')) closeProductModal();
        }
    });

    /* ------------------------------
       Small demo: add variant functionality
       Adds a new row into the variants table when Save Variant is clicked
    -------------------------------*/
    document.getElementById('saveVariantBtn').addEventListener('click', () => {
        const vName = document.getElementById('v_name').value || 'Variant';
        const vStrength = document.getElementById('v_strength').value || '-';
        const vPack = document.getElementById('v_pack').value || '-';
        const vMrp = document.getElementById('v_mrp').value || '0';
        const tbody = document.getElementById('variantsTbody');

        const tr = document.createElement('tr');
        tr.className = 'hover:bg-gray-50 transition';
        tr.innerHTML = `
        <td class="py-3 px-4">${escapeHtml(vName)}</td>
        <td class="py-3 px-4">${escapeHtml(vStrength)}</td>
        <td class="py-3 px-4">${escapeHtml(vPack)}</td>
        <td class="py-3 px-4">PKR ${escapeHtml(vMrp)}</td>
        <td class="py-3 px-4 text-green-600 font-semibold">Active</td>
        <td class="py-3 px-4 flex gap-3 text-blue-600 text-lg">
          <i class="fa-solid fa-pen cursor-pointer"></i>
          <i class="fa-solid fa-trash text-red-600 cursor-pointer"></i>
        </td>
      `;
        tbody.appendChild(tr);

        // close variant modal and restore parent
        closeVariantModal();
    });

    // small helper to avoid HTML injection (very small)
    function escapeHtml(text) {
        return text.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;');
    }
</script>


@endpush