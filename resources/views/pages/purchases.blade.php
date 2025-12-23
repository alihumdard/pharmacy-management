@extends('layouts.main')
@section('title', 'Purchase Orders')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)] bg-gray-50" 
          x-data="{ showModal: false, isEditMode: false }"
          @open-po-modal.window="showModal = true; isEditMode = $event.detail.editMode">

        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Purchase Order History</h1>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-4 sm:p-6">
                {{-- Search & Create --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                    <div class="relative w-full md:w-1/3">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search POs..." class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-300 rounded-xl outline-none text-sm focus:ring-2 focus:ring-blue-400 transition">
                    </div>
                    <button @click="resetForm(); $dispatch('open-po-modal', { editMode: false })"
                        class="w-full sm:w-auto px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg font-semibold flex items-center justify-center gap-2 transition transform active:scale-95">
                        <i class="fa-solid fa-cart-plus"></i> Create New PO
                    </button>
                </div>

                {{-- Main Table --}}
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-md">
                    <table class="w-full border-collapse text-sm min-w-[1000px]">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="py-4 px-5 text-left font-bold uppercase tracking-wider">Purchase ID</th>
                                <th class="py-4 px-5 text-left font-bold uppercase tracking-wider">Supplier & Items Detail</th>
                                <th class="py-4 px-5 text-right font-bold uppercase tracking-wider">Total Amount</th>
                                <th class="py-4 px-5 text-center font-bold uppercase tracking-wider">Status</th>
                                <th class="py-4 px-5 text-center font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="mainPOTableBody" class="divide-y divide-gray-100 text-gray-800">
                            @forelse($orders as $order)
                                <tr class="hover:bg-blue-50/30 transition border-b">
                                    <td class="py-4 px-5 align-top">
                                        <div class="font-bold text-blue-700">{{ $order->po_number }}</div>
                                        <div class="text-[10px] text-gray-400 mt-1">{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</div>
                                    </td>
                                    <td class="py-4 px-5 align-top">
                                        <div class="font-bold text-gray-900 uppercase mb-2">{{ $order->supplier_name }}</div>
                                        <div class="space-y-3">
                                            @foreach($order->items as $item)
                                                <div class="border-l-2 border-blue-200 pl-3 py-1 bg-blue-50/20 rounded-r-lg">
                                                    <span class="text-xs font-black text-blue-700 block">{{ $item->product_name }}</span>
                                                    <div class="flex flex-wrap gap-1.5 mt-1.5">
                                                        @foreach($item->variants as $v)
                                                            <div class="flex items-center gap-1.5 bg-white border border-gray-200 px-2 py-1 rounded shadow-sm">
                                                                <span class="text-[9px] font-black text-gray-800 uppercase tracking-tight">{{ $v->sku }}</span>
                                                                <span class="text-[9px] text-gray-400">| B: {{ $v->batch_no ?? 'N/A' }}</span>
                                                                <span class="text-[9px] font-bold text-green-600">Qty: {{ $v->quantity }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-4 px-5 text-right font-bold text-gray-900 align-top">PKR {{ number_format($order->total_amount, 2) }}</td>
                                    <td class="py-4 px-5 text-center align-top">
                                        <span class="bg-gray-50 border border-gray-200 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">{{ $order->status }}</span>
                                    </td>
                                    <td class="py-4 px-5 text-center align-top">
                                        <div class="flex items-center justify-center gap-3 text-gray-400 text-lg">
                                            <i class="fa-solid fa-pen-to-square hover:text-green-600 cursor-pointer transition" onclick="editPO({{ $order->id }})"></i>
                                            <i class="fa-solid fa-trash hover:text-red-600 cursor-pointer transition" onclick="deletePO({{ $order->id }})"></i>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-10 text-center">No purchase orders found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MAIN PO MODAL --}}
        <div x-show="showModal" class="fixed inset-0 z-40 overflow-y-auto" style="display: none;" x-transition>
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden">
                    <div class="bg-blue-600 px-6 py-4 flex justify-between items-center text-white font-bold uppercase italic">
                        <h3 x-text="isEditMode ? 'Edit Purchase Order' : 'Create New Purchase Order'"></h3>
                        <button @click="showModal = false" class="text-3xl">&times;</button>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Supplier Name</label>
                                <select id="po_supplier" class="w-full p-2.5 border rounded-lg mt-1 bg-white outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_name }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Order Date</label>
                                <input id="po_date" type="date" value="{{ date('Y-m-d') }}" class="w-full p-2.5 border rounded-lg mt-1 outline-none focus:ring-2 focus:ring-blue-400">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">PO Status</label>
                                <select id="po_status" class="w-full p-2.5 border rounded-lg mt-1 bg-white outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="Draft">Draft</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="border rounded-xl p-4 bg-gray-50 border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-bold text-blue-800 uppercase text-sm italic tracking-widest border-l-4 border-blue-600 pl-2">Selected Products</h4>
                                <button type="button" onclick="openProductModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-lg hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-plus-circle mr-1"></i> Add Product
                                </button>
                            </div>
                            <div class="bg-white border rounded-lg overflow-hidden shadow-sm">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-100 text-gray-600 border-b">
                                        <tr class="text-left font-bold">
                                            <th class="p-3">Product Name & Variants</th>
                                            <th class="p-3">Details</th>
                                            <th class="p-3 text-right">Subtotal</th>
                                            <th class="p-3 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="poProductsTbody" class="divide-y divide-gray-200"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-t bg-gray-50 flex justify-end gap-3 text-sm font-bold">
                        <button @click="showModal = false" class="px-6 py-2 bg-gray-200 rounded-xl text-gray-600 hover:bg-gray-300">Discard</button>
                        <button onclick="submitFinalPO()" class="px-8 py-2 bg-green-600 text-white rounded-xl shadow-xl hover:bg-green-700 transition">Submit Order</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- PRODUCT SELECTION MODAL --}}
        <div id="productModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-[50] p-4">
            <div id="productModalBox" class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl flex flex-col overflow-hidden opacity-0 scale-95 transition-all duration-200">
                <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                    <h2 id="productModalTitle" class="text-xl font-bold italic uppercase tracking-tighter text-blue-600">Product Selection</h2>
                    <button onclick="closeProductModal()" class="text-3xl">&times;</button>
                </div>
                <div class="p-5 overflow-y-auto" style="max-height: 80vh;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="col-span-2 relative" x-data="{ open: false, search: '' }">
                            <label class="text-[10px] font-bold uppercase text-gray-500 tracking-widest ml-1 mb-1 block">Product Name *</label>
                            <input type="text" id="p_name" x-model="search" @click="open = true" @click.away="open = false" @input="open = true; checkExistingProduct(search)"
                                   placeholder="Search medicine database..." class="w-full p-3 border rounded-xl outline-none focus:ring-2 focus:ring-blue-400 text-sm shadow-sm" autocomplete="off" />
                            
                            <div x-show="open && search.length > 0" class="absolute z-[100] w-full mt-1 bg-white border rounded-xl shadow-xl overflow-hidden" style="display: none;">
                                <div class="max-h-48 overflow-y-auto custom-scrollbar">
                                    <template x-for="med in Array.from(document.querySelectorAll('#existing_medicines option'))">
                                        <div x-show="med.value.toLowerCase().includes(search.toLowerCase())"
                                             @click="search = med.value; open = false; checkExistingProduct(med.value)"
                                             class="px-4 py-2 hover:bg-blue-50 cursor-pointer border-b text-sm transition-colors">
                                            <span class="font-bold text-gray-800" x-text="med.value"></span>
                                            <span class="text-[10px] text-gray-400 ml-2" x-text="med.dataset.manufacturer"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <input id="p_manufacturer" placeholder="Manufacturer" class="w-full p-3 border rounded-xl mt-1 outline-none text-sm bg-white" />
                        <select id="p_category" class="w-full p-3 border rounded-xl mt-1 outline-none text-sm bg-white">
                            <option value="General">General</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Syrup">Syrup</option>
                            <option value="Injection">Injection</option>
                        </select>
                    </div>

                    <div class="border p-4 rounded-xl bg-blue-50/20 border-blue-100">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-bold text-gray-700 text-sm italic uppercase tracking-widest">Variants, Batches & Expiry</h4>
                            <button type="button" onclick="addNewEmptyVariant()" class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-lg shadow hover:bg-green-600 transition">
                                <i class="fa-solid fa-plus mr-1"></i> Add SKU
                            </button>
                        </div>
                        <div class="bg-white rounded-lg border overflow-hidden shadow-sm">
                            <table class="w-full text-xs">
                                <thead class="bg-gray-50 text-gray-500 font-bold border-b uppercase">
                                    <tr>
                                        <th class="p-2 text-left">SKU / Label</th>
                                        <th class="p-2 text-left">Batch #</th>
                                        <th class="p-2 text-left">Expiry Date</th> {{-- Added --}}
                                        <th class="p-2 text-right w-24">TP (Price)</th>
                                        <th class="p-2 text-center w-20">Qty</th>
                                        <th class="p-2 text-center w-12"></th>
                                    </tr>
                                </thead>
                                <tbody id="variantsTbody" class="divide-y divide-gray-100"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t bg-gray-50 flex justify-end gap-3">
                    <button onclick="closeProductModal()" class="px-5 py-2 bg-gray-200 rounded-lg font-bold text-sm">Cancel</button>
                    <button onclick="addProductToPO()" class="px-5 py-2 bg-blue-600 text-white rounded-lg font-bold shadow-lg text-sm uppercase tracking-wider">Save Selection</button>
                </div>
            </div>
        </div>

        <datalist id="existing_medicines" class="hidden">
            @foreach($medicines as $med)
                <option value="{{ $med->name }}" 
                        data-manufacturer="{{ $med->manufacturer }}" 
                        data-category="{{ $med->category }}"
                        data-variants="{{ json_encode($med->variants) }}">
            @endforeach
        </datalist>

    </main>

    <script>
        let currentTempVariants = [];
        let poItemsList = [];
        let isEditMode = false;
        let editPoId = null;
        let editingProductIndex = null;

        function animateOpen(container, box) {
            container.classList.remove('hidden'); container.classList.add('flex');
            setTimeout(() => { box.classList.remove('scale-95', 'opacity-0'); box.classList.add('scale-100', 'opacity-100'); }, 10);
        }
        function animateClose(container, box) {
            box.classList.remove('scale-100', 'opacity-100'); box.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { container.classList.add('hidden'); container.classList.remove('flex'); }, 200);
        }

        function checkExistingProduct(val) {
            const list = document.getElementById('existing_medicines');
            const option = Array.from(list.options).find(opt => opt.value === val);
            if (option) {
                document.getElementById('p_manufacturer').value = option.getAttribute('data-manufacturer');
                document.getElementById('p_category').value = option.getAttribute('data-category');
                document.getElementById('p_manufacturer').readOnly = true;
                if (editingProductIndex === null) {
                    const variantsData = JSON.parse(option.getAttribute('data-variants') || '[]');
                    currentTempVariants = variantsData.map(v => ({
                        sku: v.sku, batch: '', expiry: v.expiry_date || '', 
                        tp: v.purchase_price || 0, stock: 0, subtotal: 0
                    }));
                    updateVariantTable();
                }
            } else {
                document.getElementById('p_manufacturer').readOnly = false;
            }
        }

        function updateVariantTable() {
            const tbody = document.getElementById('variantsTbody');
            if (currentTempVariants.length === 0) { 
                tbody.innerHTML = '<tr><td colspan="6" class="p-4 text-center text-gray-400 italic font-bold uppercase tracking-widest text-[10px]">No variants available. Search or Add SKU.</td></tr>'; 
                return; 
            }
            tbody.innerHTML = currentTempVariants.map((v, i) => `
                <tr class="bg-white hover:bg-gray-50 transition border-b">
                    <td class="p-2"><input type="text" value="${v.sku}" onchange="updateVariantData(${i}, 'sku', this.value)" class="w-full p-1 border rounded text-[11px] font-bold text-blue-600 uppercase focus:ring-1 outline-none"></td>
                    <td class="p-2"><input type="text" value="${v.batch}" onchange="updateVariantData(${i}, 'batch', this.value)" placeholder="Batch #" class="w-full p-1 border rounded text-[11px] outline-none"></td>
                    <td class="p-2"><input type="date" value="${v.expiry}" onchange="updateVariantData(${i}, 'expiry', this.value)" class="w-full p-1 border rounded text-[11px] font-bold text-red-500 outline-none"></td>
                    <td class="p-2 text-right"><input type="number" value="${v.tp}" onchange="updateVariantData(${i}, 'tp', this.value)" class="w-full p-1 border rounded text-[11px] text-right font-semibold outline-none"></td>
                    <td class="p-2 text-center"><input type="number" value="${v.stock}" onchange="updateVariantData(${i}, 'stock', this.value)" class="w-full p-1 border rounded text-[11px] text-center font-bold outline-none"></td>
                    <td class="p-2 text-center"><button onclick="currentTempVariants.splice(${i},1);updateVariantTable();" class="text-red-300 hover:text-red-500 transition"><i class="fa-solid fa-circle-minus text-base"></i></button></td>
                </tr>`).join('');
        }

        window.updateVariantData = (index, field, value) => {
            currentTempVariants[index][field] = value;
            if (field === 'tp' || field === 'stock') {
                currentTempVariants[index].subtotal = (parseFloat(currentTempVariants[index].tp) || 0) * (parseInt(currentTempVariants[index].stock) || 0);
            }
        };

        window.addNewEmptyVariant = () => {
            currentTempVariants.push({ sku: '', batch: '', expiry: '', tp: 0, stock: 1, subtotal: 0 });
            updateVariantTable();
        };

        window.openProductModal = () => { 
            editingProductIndex = null;
            document.getElementById('productModalTitle').innerText = "Add Product Selection";
            currentTempVariants = []; updateVariantTable(); 
            document.getElementById('p_name').value = '';
            document.getElementById('p_manufacturer').value = '';
            document.getElementById('p_manufacturer').readOnly = false;
            animateOpen(document.getElementById('productModal'), document.getElementById('productModalBox')); 
        };

        window.closeProductModal = () => animateClose(document.getElementById('productModal'), document.getElementById('productModalBox'));

        window.addProductToPO = () => {
            const pName = document.getElementById('p_name').value;
            const pManufacturer = document.getElementById('p_manufacturer').value;
            if (!pName || currentTempVariants.length === 0) return alert('Product name and variants are required');
            const productTotal = currentTempVariants.reduce((sum, v) => sum + (v.subtotal || 0), 0);
            const productData = { name: pName, manufacturer: pManufacturer, category: document.getElementById('p_category').value, variants: [...currentTempVariants], total: productTotal };
            if (editingProductIndex !== null) poItemsList[editingProductIndex] = productData;
            else poItemsList.push(productData);
            updatePOTable(); closeProductModal();
        };

        function updatePOTable() {
            const tbody = document.getElementById('poProductsTbody');
            if (poItemsList.length === 0) { tbody.innerHTML = '<tr><td colspan="4" class="p-6 text-center italic text-gray-400">No items selected yet.</td></tr>'; return; }
            tbody.innerHTML = poItemsList.map((p, i) => `
                <tr class="border-b bg-white hover:bg-gray-50 transition">
                    <td class="p-3"><div class="font-bold text-gray-800 uppercase tracking-tight text-xs">${p.name}</div><div class="text-[9px] text-gray-400 italic mt-0.5 leading-tight">${p.variants.map(v => v.sku).join(', ')}</div></td>
                    <td class="p-3 text-xs tracking-tighter"><span class="text-gray-500 block">${p.manufacturer}</span><span class="font-black text-blue-600 uppercase text-[9px]">${p.variants.length} VARIANT(S)</span></td>
                    <td class="p-3 text-right font-black text-green-700 italic text-sm">PKR ${p.total.toLocaleString()}</td>
                    <td class="p-3 text-center"><div class="flex justify-center gap-3"><i class="fa-solid fa-pencil text-blue-400 hover:text-blue-600 cursor-pointer" onclick="editProductInPO(${i})"></i><i class="fa-solid fa-trash-can text-red-300 hover:text-red-500 cursor-pointer" onclick="poItemsList.splice(${i},1);updatePOTable();"></i></div></td>
                </tr>`).join('');
        }

        window.editProductInPO = (index) => {
            editingProductIndex = index;
            const product = poItemsList[index];
            document.getElementById('productModalTitle').innerText = "Update Selected Product";
            document.getElementById('p_name').value = product.name;
            document.getElementById('p_manufacturer').value = product.manufacturer;
            document.getElementById('p_category').value = product.category;
            currentTempVariants = [...product.variants];
            updateVariantTable();
            animateOpen(document.getElementById('productModal'), document.getElementById('productModalBox'));
        };

        window.submitFinalPO = async () => {
            const payload = {
                _token: "{{ csrf_token() }}",
                supplier: document.getElementById('po_supplier').value,
                date: document.getElementById('po_date').value,
                status: document.getElementById('po_status').value,
                total_amount: poItemsList.reduce((sum, p) => sum + p.total, 0),
                products: poItemsList.map(p => ({
                    ...p,
                    variants: p.variants.map(v => ({
                        ...v,
                        expiry: v.expiry ? v.expiry : null // Ensuring clean expiry format
                    }))
                }))
            };
            const url = isEditMode ? `/purchase-orders/${editPoId}` : "{{ route('po.store') }}";
            try {
                const response = await fetch(url, { method: isEditMode ? "PUT" : "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(payload) });
                if (response.ok) window.location.reload();
                else { const res = await response.json(); alert(res.message); }
            } catch (e) { alert('Network Error'); }
        };

        window.editPO = async (id) => {
            const response = await fetch(`/purchase-orders/${id}/edit`);
            const po = await response.json();
            isEditMode = true; editPoId = id;
            document.getElementById('po_supplier').value = po.supplier_name;
            document.getElementById('po_date').value = po.order_date;
            document.getElementById('po_status').value = po.status;
            poItemsList = po.items.map(item => ({
                name: item.product_name, manufacturer: item.manufacturer, category: 'General',
                variants: item.variants.map(v => ({ sku: v.sku, batch: v.batch_no, expiry: v.expiry_date || '', tp: v.purchase_price, stock: v.quantity, subtotal: v.purchase_price * v.quantity })),
                total: item.variants.reduce((sum, v) => sum + (v.purchase_price * v.quantity), 0)
            }));
            updatePOTable();
            window.dispatchEvent(new CustomEvent('open-po-modal', { detail: { editMode: true } }));
        };

        window.deletePO = async (id) => {
            if (confirm('Permanently delete this PO record?')) {
                await fetch(`/purchase-orders/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" } });
                window.location.reload();
            }
        };

        window.resetForm = () => { poItemsList = []; isEditMode = false; updatePOTable(); };
    </script>
@endsection