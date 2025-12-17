@extends('layouts.main')
@section('title', 'Medicine Database')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Product & Inventory Catalogue</h1>

        <div id="supplierModal" class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <form action="{{ route('medicines.index') }}" method="GET" class="relative w-full md:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, batch, or SKU..."
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border border-gray-300 rounded-xl outline-none text-sm text-gray-700 focus:ring-2 focus:ring-blue-400 transition">
                </form>

                <div class="flex items-center gap-3 flex-wrap">
                    <button onclick="window.location.href='{{ route('medicines.index') }}'" class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 flex items-center gap-2 shadow-md transition text-sm font-medium text-gray-700">
                        <i class="fa-solid fa-rotate-right text-gray-600"></i> Reset
                    </button>

                    <button onclick="openProductModal()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg font-semibold flex items-center gap-2 transition text-sm">
                        <i class="fa-solid fa-plus"></i> Add New Medicine
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
                <table class="w-full border-collapse text-sm min-w-[1000px]">
                    <thead class="bg-blue-600 text-white text-left shadow-md">
                        <tr>
                            <th class="py-3 px-4 font-bold uppercase tracking-wider">Medicine Name / SKU</th>
                            <th class="py-3 px-4 font-bold uppercase tracking-wider">Batch No.</th>
                            <th class="py-3 px-4 font-bold uppercase tracking-wider">Expiry Date</th>
                            <th class="py-3 px-4 font-bold uppercase tracking-wider">Stock Level</th>
                            <th class="py-3 px-4 font-bold uppercase tracking-wider text-right">Purchase (TP)</th>
                            <th class="py-3 px-4 font-bold uppercase tracking-wider text-right">Sale (MRP)</th>
                            <th class="py-3 px-4 font-bold uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($variants as $variant)
                        <tr class="hover:bg-gray-50 transition {{ $variant->stock_level <= $variant->reorder_level ? 'bg-red-50' : '' }}">
                            <td class="py-3 px-4">
                                <div class="font-medium text-gray-800">{{ $variant->medicine->name }}</div>
                                <div class="text-xs text-blue-500 font-mono">{{ $variant->sku }}</div>
                            </td>
                            <td class="py-3 px-4 text-gray-600 font-medium">{{ $variant->batch_no ?? '---' }}</td>
                            <td class="py-3 px-4 text-gray-600">
                                @if($variant->expiry_date)
                                    <span class="{{ \Carbon\Carbon::parse($variant->expiry_date)->isPast() ? 'text-red-600 font-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($variant->expiry_date)->format('d/m/Y') }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($variant->stock_level <= $variant->reorder_level)
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold shadow-sm">
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Low Stock ({{ $variant->stock_level }})
                                    </span>
                                @else
                                    <span class="font-semibold text-green-700">{{ $variant->stock_level }} Units</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right text-gray-700">{{ number_format($variant->purchase_price, 2) }}</td>
                            <td class="py-3 px-4 text-right text-gray-900 font-bold">{{ number_format($variant->sale_price, 2) }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center gap-3">
                                    <button onclick="openEditModal({{ json_encode($variant) }}, {{ json_encode($variant->medicine) }})" 
                                            class="text-blue-600 hover:text-blue-800 transition text-lg" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button onclick="deleteProduct({{ $variant->id }})" 
                                            class="text-red-600 hover:text-red-800 transition text-lg" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-gray-500 italic">No products found in the database.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $variants->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</main>

<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50 p-4">
    <div id="productModalBox" class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl flex flex-col overflow-hidden transform transition-all duration-200 scale-95 opacity-0" style="max-height:90vh;">
        <div class="p-5 border-b sticky top-0 bg-white z-10 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Create New Product</h2>
            <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-700 text-lg"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="flex-1 overflow-y-auto px-5 pb-6 pt-4 space-y-8">
            <section class="border border-gray-200 rounded-xl p-4 shadow-sm">
                <h4 class="font-bold text-lg text-blue-700 mb-4 flex items-center gap-2"><i class="fa-solid fa-info-circle"></i> Basic Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <label class="text-sm font-medium text-gray-700">Product Name <span class="text-red-500">*</span></label>
                        <input id="p_name" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg outline-none transition" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Generic Name</label>
                        <input id="p_generic" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg outline-none transition" />
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700">Manufacturer</label>
                        <input id="p_man" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg outline-none transition" />
                    </div>
                </div>
            </section>
            <section class="border border-gray-200 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-bold text-lg text-blue-700 flex items-center gap-2"><i class="fa-solid fa-boxes"></i> Product Variants</h4>
                    <button onclick="openVariantModal()" class="px-4 py-2 bg-green-500 text-white rounded-lg shadow-md flex items-center gap-2 hover:bg-green-600 transition text-sm font-semibold">
                        <i class="fa-solid fa-plus"></i> Add New Variant
                    </button>
                </div>
                <div class="border rounded-xl overflow-hidden bg-white shadow-md">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700"><tr class="text-left"><th class="py-3 px-4">SKU</th><th class="py-3 px-4">Batch</th><th class="py-3 px-4">MRP</th><th class="py-3 px-4 text-center">Actions</th></tr></thead>
                        <tbody id="variantsTbody" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </section>
        </div>
        <div class="p-5 border-t bg-white flex justify-end gap-3 sticky bottom-0 z-10">
            <button onclick="closeProductModal()" class="px-5 py-2 bg-gray-200 rounded-xl font-semibold hover:bg-gray-300 transition">Cancel</button>
            <button id="saveProductBtn" class="px-5 py-2 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 shadow-md transition">Save Product</button>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-[70] p-4">
    <div id="editModalBox" class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl flex flex-col overflow-hidden transform transition-all duration-200 scale-95 opacity-0">
        <div class="p-5 border-b flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Update Inventory Item</h2>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-700 text-lg"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="editForm" class="p-6 overflow-y-auto" style="max-height: 80vh;">
            <input type="hidden" id="edit_variant_id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="text-sm font-semibold text-gray-600">Medicine Name</label>
                    <input type="text" id="edit_name" class="w-full border rounded-lg p-2.5 mt-1 bg-gray-50" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">Variant SKU</label>
                    <input type="text" id="edit_sku" class="w-full border rounded-lg p-2.5 mt-1" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">Batch No</label>
                    <input type="text" id="edit_batch" class="w-full border rounded-lg p-2.5 mt-1">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">Purchase Price (TP)</label>
                    <input type="number" step="0.01" id="edit_tp" class="w-full border rounded-lg p-2.5 mt-1">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">Sale Price (MRP)</label>
                    <input type="number" step="0.01" id="edit_mrp" class="w-full border rounded-lg p-2.5 mt-1">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">Stock Quantity</label>
                    <input type="number" id="edit_stock" class="w-full border rounded-lg p-2.5 mt-1">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-600">Expiry Date</label>
                    <input type="date" id="edit_expiry" class="w-full border rounded-lg p-2.5 mt-1">
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-6 py-2 bg-gray-200 rounded-xl font-semibold">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 shadow-lg">Update Item</button>
            </div>
        </form>
    </div>
</div>

<div id="variantModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-[60] p-3">
    <div id="variantModalBox" class="bg-white w-full max-w-lg mx-auto rounded-2xl shadow-2xl transform transition-all duration-200 scale-95 opacity-0">
        <div class="p-6">
            <h3 class="text-2xl font-bold mb-6 text-gray-900 border-b pb-3">Add Variant Details</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2"><label class="text-sm font-medium">SKU *</label><input id="v_name" type="text" class="w-full border rounded-lg p-2"></div>
                <div><label class="text-sm font-medium">Batch No</label><input id="v_batch" type="text" class="w-full border rounded-lg p-2"></div>
                <div><label class="text-sm font-medium">Expiry</label><input id="v_expiry" type="date" class="w-full border rounded-lg p-2"></div>
                <div><label class="text-sm font-medium">TP</label><input id="v_tp" type="number" class="w-full border rounded-lg p-2" value="0"></div>
                <div><label class="text-sm font-medium">MRP</label><input id="v_mrp" type="number" class="w-full border rounded-lg p-2" value="0"></div>
                <div><label class="text-sm font-medium">Stock</label><input id="v_stock" type="number" class="w-full border rounded-lg p-2" value="0"></div>
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-4 border-t">
                <button onclick="closeVariantModal()" class="px-5 py-2 bg-gray-200 rounded-lg">Cancel</button>
                <button id="saveVariantBtn" class="px-5 py-2 bg-blue-600 text-white rounded-lg">Add to List</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let currentVariants = [];

    /* --- MODAL UTILS --- */
    function animateOpen(container, box) {
        container.classList.remove('hidden'); container.classList.add('flex');
        document.body.style.overflow = 'hidden';
        setTimeout(() => { box.classList.remove('scale-95', 'opacity-0'); box.classList.add('scale-100', 'opacity-100'); }, 10);
    }
    function animateClose(container, box) {
        box.classList.remove('scale-100', 'opacity-100'); box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { container.classList.add('hidden'); container.classList.remove('flex'); if(!document.querySelector('.fixed.inset-0:not(.hidden)')) document.body.style.overflow = ''; }, 200);
    }

    /* --- ADD PRODUCT MODAL --- */
    window.openProductModal = () => animateOpen(document.getElementById('productModal'), document.getElementById('productModalBox'));
    window.closeProductModal = () => animateClose(document.getElementById('productModal'), document.getElementById('productModalBox'));

    /* --- VARIANT SUB-MODAL --- */
    window.openVariantModal = () => animateOpen(document.getElementById('variantModal'), document.getElementById('variantModalBox'));
    window.closeVariantModal = () => animateClose(document.getElementById('variantModal'), document.getElementById('variantModalBox'));

    document.getElementById('saveVariantBtn').addEventListener('click', () => {
        const v = {
            sku: document.getElementById('v_name').value,
            batch_no: document.getElementById('v_batch').value,
            expiry_date: document.getElementById('v_expiry').value,
            purchase_price: document.getElementById('v_tp').value,
            sale_price: document.getElementById('v_mrp').value,
            stock_level: document.getElementById('v_stock').value,
            reorder_level: 5
        };
        if(!v.sku) return alert('SKU is mandatory');
        currentVariants.push(v);
        updateVariantTable();
        closeVariantModal();
    });

    function updateVariantTable() {
        document.getElementById('variantsTbody').innerHTML = currentVariants.map((v, i) => `
            <tr><td class="p-4">${v.sku}</td><td class="p-4">${v.batch_no || '-'}</td><td class="p-4">$${v.sale_price}</td>
            <td class="p-4 text-center"><button onclick="currentVariants.splice(${i},1);updateVariantTable()" class="text-red-500"><i class="fa-solid fa-trash"></i></button></td></tr>
        `).join('');
    }

    /* --- SAVE (CREATE) AJAX --- */
    document.getElementById('saveProductBtn').addEventListener('click', async () => {
        const payload = {
            _token: "{{ csrf_token() }}",
            name: document.getElementById('p_name').value,
            generic_name: document.getElementById('p_generic').value,
            manufacturer: document.getElementById('p_man').value,
            variants: currentVariants
        };
        const res = await fetch("{{ route('medicines.store') }}", {
            method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload)
        });
        const result = await res.json();
        if(result.success) window.location.reload();
        else alert(result.message);
    });

    /* --- EDIT MODAL LOGIC --- */
    window.openEditModal = (variant, medicine) => {
        document.getElementById('edit_variant_id').value = variant.id;
        document.getElementById('edit_name').value = medicine.name;
        document.getElementById('edit_sku').value = variant.sku;
        document.getElementById('edit_batch').value = variant.batch_no || '';
        document.getElementById('edit_tp').value = variant.purchase_price;
        document.getElementById('edit_mrp').value = variant.sale_price;
        document.getElementById('edit_stock').value = variant.stock_level;
        document.getElementById('edit_expiry').value = variant.expiry_date ? variant.expiry_date.split(' ')[0] : '';
        animateOpen(document.getElementById('editModal'), document.getElementById('editModalBox'));
    };
    window.closeEditModal = () => animateClose(document.getElementById('editModal'), document.getElementById('editModalBox'));

    /* --- UPDATE AJAX --- */
    document.getElementById('editForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('edit_variant_id').value;
        const payload = {
            _token: "{{ csrf_token() }}",
            name: document.getElementById('edit_name').value,
            sku: document.getElementById('edit_sku').value,
            batch_no: document.getElementById('edit_batch').value,
            purchase_price: document.getElementById('edit_tp').value,
            sale_price: document.getElementById('edit_mrp').value,
            stock_level: document.getElementById('edit_stock').value,
            expiry_date: document.getElementById('edit_expiry').value,
        };
        const res = await fetch(`/medicines/${id}`, {
            method: 'PUT', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload)
        });
        const result = await res.json();
        if(result.success) window.location.reload();
        else alert(result.message);
    });

    /* --- DELETE AJAX --- */
    window.deleteProduct = async (id) => {
        if(!confirm('Permanent delete this item?')) return;
        const res = await fetch(`/medicines/${id}`, {
            method: 'DELETE', headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
        });
        const result = await res.json();
        if(result.success) window.location.reload();
    };
</script>
@endpush