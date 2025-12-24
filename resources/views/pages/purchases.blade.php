@extends('layouts.main')
@section('title', 'Purchase Orders')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <main class="h-screen overflow-y-auto p-4 md:p-8 pt-20 bg-gray-50 flex flex-col" 
          x-data="{ showModal: false, isEditMode: false }"
          @open-po-modal.window="showModal = true; isEditMode = $event.detail.editMode">

        <div class="max-w-[1600px] mx-auto w-full">
            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tighter uppercase leading-none">Purchases</h1>
                    <p class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mt-1">Management & Procurement</p>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <div class="relative flex-grow sm:w-80">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search POs..." 
                            class="w-full pl-11 pr-4 py-3 bg-white rounded-2xl border border-gray-200 focus:ring-4 focus:ring-blue-50 outline-none transition shadow-sm font-bold text-sm">
                    </div>
                    <button @click="resetForm(); $dispatch('open-po-modal', { editMode: false })"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-2xl shadow-lg font-black uppercase text-xs tracking-widest transition transform active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i> Create New PO
                    </button>
                </div>
            </div>

            {{-- MAIN CONTENT GRID --}}
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-sm min-w-[1000px]">
                            <thead class="bg-blue-600 text-white border-b border-gray-100">
                                <tr>
                                    <th class="py-5 px-6 text-left font-black uppercase tracking-widest text-[10px]">Purchase ID</th>
                                    <th class="py-5 px-6 text-left font-black uppercase tracking-widest text-[10px]">Supplier & Items</th>
                                    <th class="py-5 px-6 text-right font-black uppercase tracking-widest text-[10px]">Total Amount</th>
                                    <th class="py-5 px-6 text-center font-black uppercase tracking-widest text-[10px]">Status</th>
                                    <th class="py-5 px-6 text-center font-black uppercase tracking-widest text-[10px]">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="mainPOTableBody" class="divide-y divide-gray-50">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-blue-50/30 transition group">
                                        <td class="py-5 px-6 align-top">
                                            <div class="font-black text-blue-600 tracking-tighter italic text-lg leading-none">#{{ $order->po_number }}</div>
                                            <div class="text-[10px] text-gray-400 font-bold uppercase mt-2 tracking-tighter">
                                                {{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}
                                            </div>
                                        </td>
                                        <td class="py-5 px-6 align-top">
                                            <div class="font-black text-gray-900 uppercase mb-3 tracking-tight">{{ $order->supplier_name }}</div>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                @foreach($order->items as $item)
                                                    <div class="bg-gray-50 rounded-xl p-3 border border-gray-100">
                                                        <span class="text-[10px] font-black text-blue-700 block uppercase mb-1">{{ $item->product_name }}</span>
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach($item->variants as $v)
                                                                <span class="text-[9px] font-bold bg-white border border-gray-200 px-2 py-0.5 rounded text-gray-600">
                                                                    {{ $v->sku }} | Qty: {{ $v->quantity }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="py-5 px-6 text-right align-top">
                                            <div class="text-lg font-black text-gray-900 italic tracking-tighter">
                                                <span class="text-[10px] font-bold text-gray-400 not-italic uppercase mr-1">PKR</span>{{ number_format($order->total_amount, 2) }}
                                            </div>
                                        </td>
                                        <td class="py-5 px-6 text-center align-top">
                                            <span class="inline-block px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-sm border
                                                {{ $order->status == 'Completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-orange-50 text-orange-600 border-orange-100' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-6 text-center align-top">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick="editPO({{ $order->id }})" class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-sm">
                                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                                </button>
                                                <button onclick="deletePO({{ $order->id }})" class="w-9 h-9 rounded-xl bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="py-20 text-center text-gray-300 italic font-black uppercase tracking-widest">No PO Records Found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- CREATE/EDIT MODAL (RESPONSIVE) --}}
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" x-cloak x-transition>
            <div class="bg-white w-full max-w-6xl rounded-[40px] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                {{-- Modal Header --}}
                <div class="bg-blue-600 px-8 py-6 flex justify-between items-center text-white shrink-0">
                    <div>
                        <h3 class="text-2xl font-black uppercase italic tracking-tighter leading-none" x-text="isEditMode ? 'Update Purchase Order' : 'New Purchase Order'"></h3>
                        <p class="text-[10px] font-bold uppercase tracking-widest mt-1 text-blue-200">Procurement Terminal</p>
                    </div>
                    <button @click="showModal = false" class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center hover:bg-white/20 transition text-2xl font-light">&times;</button>
                </div>

                <div class="p-8 overflow-y-auto custom-scrollbar flex-grow">
                    {{-- Form Fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Supplier Selection</label>
                            <select id="po_supplier" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-50">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->supplier_name }}">{{ $supplier->supplier_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Order Timestamp</label>
                            <input id="po_date" type="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-50">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Workflow Status</label>
                            <select id="po_status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-50">
                                <option value="Draft">Draft</option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    {{-- Products Table Area --}}
                    <div class="bg-gray-50 rounded-[30px] border border-gray-200 p-6 shadow-inner">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest italic border-l-4 border-blue-600 pl-3">Order Manifest</h4>
                            <button type="button" onclick="openProductModal()" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg hover:bg-blue-700 transition active:scale-95">
                                <i class="fa-solid fa-plus-circle mr-1"></i> Add Product
                            </button>
                        </div>
                        
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 text-gray-400 font-black uppercase text-[9px] border-b border-gray-100">
                                    <tr>
                                        <th class="p-4 text-left">Nomenclature & SKUs</th>
                                        <th class="p-4 text-left">Analytics</th>
                                        <th class="p-4 text-right">Valuation</th>
                                        <th class="p-4 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="poProductsTbody" class="divide-y divide-gray-50">
                                    {{-- JS Injected Content --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="p-8 border-t border-gray-100 bg-gray-50 flex justify-end gap-4 shrink-0">
                    <button @click="showModal = false" class="px-8 py-3 bg-white border border-gray-200 rounded-2xl text-gray-500 font-black uppercase text-[10px] tracking-widest hover:bg-gray-100 transition">Discard</button>
                    <button onclick="submitFinalPO()" class="px-10 py-3 bg-emerald-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-emerald-700 transition active:scale-95 ring-4 ring-emerald-50">Confirm Order</button>
                </div>
            </div>
        </div>

        {{-- PRODUCT SELECTION SUB-MODAL --}}
        <div id="productModal" class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-black/80 backdrop-blur-md" x-cloak>
            <div id="productModalBox" class="bg-white w-full max-w-4xl rounded-[40px] shadow-2xl overflow-hidden flex flex-col opacity-0 scale-95 transition-all duration-300 max-h-[85vh]">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center shrink-0">
                    <h2 id="productModalTitle" class="text-xl font-black italic uppercase tracking-tighter text-blue-600 leading-none">Catalog Selection</h2>
                    <button onclick="closeProductModal()" class="w-8 h-8 rounded-xl bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition">&times;</button>
                </div>
                
                <div class="p-8 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-2 relative" x-data="{ open: false, search: '' }">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2 block">Database Lookup</label>
                            <input type="text" id="p_name" x-model="search" @click="open = true" @click.away="open = false" @input="open = true; checkExistingProduct(search)"
                                   placeholder="Search by Medicine Name..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-50" autocomplete="off" />
                            
                            <div x-show="open && search.length > 0" class="absolute z-[100] w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden">
                                <div class="max-h-60 overflow-y-auto">
                                    <template x-for="med in Array.from(document.querySelectorAll('#existing_medicines option'))">
                                        <div x-show="med.value.toLowerCase().includes(search.toLowerCase())"
                                             @click="search = med.value; open = false; checkExistingProduct(med.value)"
                                             class="px-6 py-3 hover:bg-blue-50 cursor-pointer border-b border-gray-50 transition-colors flex justify-between items-center">
                                            <div>
                                                <div class="font-black text-gray-800 text-sm uppercase" x-text="med.value"></div>
                                                <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest" x-text="med.dataset.manufacturer"></div>
                                            </div>
                                            <i class="fa-solid fa-chevron-right text-[10px] text-blue-300"></i>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <input id="p_manufacturer" placeholder="Manufacturer" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none" />
                        <select id="p_category" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none">
                            <option value="General">General</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Syrup">Syrup</option>
                            <option value="Injection">Injection</option>
                        </select>
                    </div>

                    <div class="bg-gray-50 rounded-[30px] border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-[10px] font-black text-gray-900 uppercase tracking-widest italic border-l-4 border-green-500 pl-3">Variant Configuration</h4>
                            <button type="button" onclick="addNewEmptyVariant()" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-[9px] font-black uppercase tracking-widest shadow-md hover:bg-emerald-700 transition active:scale-95">
                                <i class="fa-solid fa-plus-circle mr-1"></i> New SKU
                            </button>
                        </div>
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm overflow-x-auto">
                            <table class="w-full text-xs min-w-[600px]">
                                <thead class="bg-gray-50 text-gray-400 font-black uppercase text-[9px] border-b border-gray-100">
                                    <tr>
                                        <th class="p-3 text-left">SKU Label</th>
                                        <th class="p-3 text-left">Batch No.</th>
                                        <th class="p-3 text-left">Expiry</th>
                                        <th class="p-3 text-right">Unit Price</th>
                                        <th class="p-3 text-center w-24">Quantity</th>
                                        <th class="p-3 text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="variantsTbody" class="divide-y divide-gray-50"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end gap-3 shrink-0">
                    <button onclick="closeProductModal()" class="px-6 py-2 bg-white border border-gray-200 rounded-xl font-black uppercase text-[9px] tracking-widest">Cancel</button>
                    <button onclick="addProductToPO()" class="px-8 py-2 bg-blue-600 text-white rounded-xl font-black uppercase text-[9px] tracking-widest shadow-lg active:scale-95 ring-4 ring-blue-50">Apply Selection</button>
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
    </main>


@endsection