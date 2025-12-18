@extends('layouts.main')
@section('title', 'Purchase Orders')

@section('content')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)] bg-gray-50" x-data="{ showModal: false }">

        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Purchase Order History</h1>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-4 sm:p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                    <div class="relative w-full md:w-1/3">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" placeholder="Search POs..."
                            class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-300 rounded-xl outline-none text-sm focus:ring-2 focus:ring-blue-400 transition">
                    </div>
                    <button @click="showModal = true; resetForm();"
                        class="w-full sm:w-auto px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-lg font-semibold flex items-center justify-center gap-2 transition transform active:scale-95">
                        <i class="fa-solid fa-cart-plus"></i> Create New PO
                    </button>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-md">
                    <table class="w-full border-collapse text-sm min-w-[1000px]">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="py-4 px-5 text-left font-bold uppercase tracking-wider">Purchase ID</th>
                                <th class="py-4 px-5 text-left font-bold uppercase tracking-wider">Supplier & Products</th>
                                <th class="py-4 px-5 text-right font-bold uppercase tracking-wider">Total Amount</th>
                                <th class="py-4 px-5 text-center font-bold uppercase tracking-wider">Status</th>
                                <th class="py-4 px-5 text-center font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="mainPOTableBody" class="divide-y divide-gray-100 italic text-gray-400">
                            @forelse($orders as $order)
                                <tr class="hover:bg-blue-50/30 transition text-gray-800 not-italic border-b">
                                    <td class="py-4 px-5 align-top">
                                        <div class="font-bold text-blue-700">{{ $order->po_number }}</div>
                                        <div class="text-[10px] text-gray-400 mt-1">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-5 align-top">
                                        <div class="font-bold text-gray-900 uppercase tracking-tight">
                                            {{ $order->supplier_name }}
                                        </div>
                                        <div class="mt-2 flex flex-wrap gap-1">
                                            @foreach($order->items as $item)
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span
                                                        class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded border border-blue-100 font-medium">{{ $item->product_name }}</span>
                                                    <span class="text-[10px] text-gray-500">({{ $item->variants->count() }}
                                                        vars)</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-4 px-5 text-right font-bold text-gray-900 align-top">
                                        PKR {{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="py-4 px-5 text-center align-top">
                                        @php
                                            $statusClasses = [
                                                'Completed' => 'bg-green-50 text-green-700 border-green-200',
                                                'Pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                                'Draft' => 'bg-gray-50 text-gray-700 border-gray-200'
                                            ];
                                        @endphp
                                        <span
                                            class="{{ $statusClasses[$order->status] ?? $statusClasses['Draft'] }} border px-3 py-1 rounded-full text-[10px] font-extrabold uppercase">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-5 text-center align-top">
                                        <div class="flex items-center justify-center gap-3 text-gray-400 text-lg">
                                            <i class="fa-solid fa-eye hover:text-blue-600 cursor-pointer transition"></i>
                                            <i class="fa-solid fa-trash hover:text-red-600 cursor-pointer transition"
                                                onclick="deletePO({{ $order->id }})"></i>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-400 italic">No purchase orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="showModal" class="fixed inset-0 z-40 overflow-y-auto" style="display: none;" x-transition>
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showModal = false"></div>
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="relative bg-white w-full max-w-5xl rounded-2xl shadow-2xl overflow-hidden">
                    <div
                        class="bg-blue-600 px-6 py-4 flex justify-between items-center text-white font-bold uppercase italic">
                        <h3>Create New Purchase Order</h3>
                        <button @click="showModal = false" class="text-3xl">&times;</button>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700">Supplier Name</label>
                                    <select id="po_supplier"
                                        class="w-full p-2.5 border rounded-lg mt-1 bg-white outline-none focus:ring-2 focus:ring-blue-400">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            {{--
                                            Agar aapka column 'name' hai to niche wala code chalega.
                                            Agar column 'supplier_name' hai to $supplier->supplier_name likhein.
                                            --}}
                                            <option value="{{ $supplier->name ?? $supplier->supplier_name }}">
                                                {{ $supplier->name ?? $supplier->supplier_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Order Date</label>
                                <input id="po_date" type="date" value="{{ date('Y-m-d') }}"
                                    class="w-full p-2.5 border rounded-lg mt-1 outline-none focus:ring-2 focus:ring-blue-400">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">PO Status</label>
                                <select id="po_status"
                                    class="w-full p-2.5 border rounded-lg mt-1 bg-white outline-none focus:ring-2 focus:ring-blue-400">
                                    <option value="Draft">Draft</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </div>

                        <div class="border rounded-xl p-4 bg-gray-50 border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h4
                                    class="font-bold text-blue-800 uppercase text-sm italic tracking-widest border-l-4 border-blue-600 pl-2">
                                    Selected Products</h4>
                                <button type="button" onclick="openProductModal()"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-lg hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-plus-circle mr-1"></i> Add Product
                                </button>
                            </div>
                            <div class="bg-white border rounded-lg overflow-hidden shadow-sm">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-100 text-gray-600 border-b">
                                        <tr class="text-left font-bold">
                                            <th class="p-3">Product Name</th>
                                            <th class="p-3">Variants</th>
                                            <th class="p-3 text-right">Subtotal</th>
                                            <th class="p-3 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="poProductsTbody" class="divide-y divide-gray-200">
                                        <tr>
                                            <td colspan="4" class="p-6 text-center text-gray-400 italic">No products added
                                                yet.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-t bg-gray-50 flex justify-end gap-3">
                        <button @click="showModal = false"
                            class="px-6 py-2 bg-gray-200 rounded-lg font-bold text-gray-600">Discard</button>
                        <button onclick="submitFinalPO()"
                            class="px-8 py-2 bg-green-600 text-white rounded-lg font-bold shadow-xl transition hover:bg-green-700 active:scale-95">Submit
                            Order</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="productModal" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-[50] p-4">
            <div id="productModalBox"
                class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl flex flex-col overflow-hidden opacity-0 scale-95 transition-all duration-200">
                <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                    <h2 class="text-xl font-bold italic uppercase tracking-tighter">Add Product to PO</h2>
                    <button onclick="closeProductModal()" class="text-3xl">&times;</button>
                </div>
                <div class="p-5 overflow-y-auto" style="max-height: 70vh;">
                    <div class="mb-4">
                        <label class="text-xs font-bold uppercase text-gray-500 tracking-widest">Product Name *</label>
                        <input id="p_name" placeholder="Enter product name..."
                            class="w-full p-3 border rounded-xl mt-1 outline-none focus:ring-2 focus:ring-blue-400" />
                    </div>
                    <div class="border p-4 rounded-xl bg-blue-50/20 border-blue-100">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-bold text-gray-700 text-sm">Variants & Batches</h4>
                            <button type="button" onclick="openVariantModal()"
                                class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-lg shadow hover:bg-green-600 transition">
                                <i class="fa-solid fa-plus mr-1"></i> Variant
                            </button>
                        </div>
                        <table class="w-full text-xs bg-white border border-gray-100 rounded-lg overflow-hidden shadow-sm">
                            <thead class="bg-gray-50 text-gray-500 uppercase font-bold">
                                <tr>
                                    <th class="p-2 text-left">SKU</th>
                                    <th class="p-2 text-left">Batch</th>
                                    <th class="p-2 text-right">Price</th>
                                    <th class="p-2 text-center">Qty</th>
                                    <th class="p-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="variantsTbody" class="divide-y divide-gray-50"></tbody>
                        </table>
                    </div>
                </div>
                <div class="p-4 border-t bg-gray-50 flex justify-end gap-3">
                    <button onclick="closeProductModal()" class="px-5 py-2 bg-gray-200 rounded-lg font-bold">Cancel</button>
                    <button onclick="addProductToPO()"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg font-bold shadow-lg">Save Product</button>
                </div>
            </div>
        </div>

        <div id="variantModal" class="fixed inset-0 bg-black/70 hidden justify-center items-center z-[60] p-4">
            <div id="variantModalBox"
                class="bg-white w-full max-w-md rounded-2xl shadow-2xl opacity-0 scale-95 transition-all duration-200">
                <div class="p-4 border-b bg-gray-50 font-bold uppercase text-sm tracking-widest italic text-blue-600">Batch
                    & SKU Details</div>
                <div class="p-5 grid grid-cols-2 gap-4">
                    <div class="col-span-2"><label class="text-xs font-bold uppercase text-gray-500">SKU / Label
                            *</label><input id="v_sku"
                            class="w-full border p-2.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-400"></div>
                    <div><label class="text-xs font-bold uppercase text-gray-500">Batch No</label><input id="v_batch"
                            class="w-full border p-2.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-400"></div>
                    <div><label class="text-xs font-bold uppercase text-gray-500">Expiry Date</label><input id="v_expiry"
                            type="date"
                            class="w-full border p-2.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-400"></div>
                    <div><label class="text-xs font-bold uppercase text-gray-500">Purchase (TP)</label><input id="v_tp"
                            type="number"
                            class="w-full border p-2.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-400" value="0">
                    </div>
                    <div><label class="text-xs font-bold uppercase text-gray-500">Stock Qty</label><input id="v_stock"
                            type="number"
                            class="w-full border p-2.5 rounded-xl outline-none focus:ring-2 focus:ring-blue-400" value="1">
                    </div>
                </div>
                <div class="p-4 border-t flex justify-end gap-2 bg-gray-50 rounded-b-2xl">
                    <button onclick="closeVariantModal()" class="px-4 py-2 bg-gray-200 rounded-lg font-bold">Cancel</button>
                    <button id="saveVariantBtn" class="px-6 py-2 bg-green-600 text-white rounded-lg font-bold shadow-md">Add
                        to List</button>
                </div>
            </div>
        </div>

    </main>

    <script>
        // [Saari JavaScript logic jo pehle controllers mein thi, yahan shamil hogi]
        // Bus submitFinalPO mein payload route ka sahi hona zaroori hai
        let currentTempVariants = [];
        let poItemsList = [];

        function animateOpen(container, box) {
            container.classList.remove('hidden'); container.classList.add('flex');
            setTimeout(() => { box.classList.remove('scale-95', 'opacity-0'); box.classList.add('scale-100', 'opacity-100'); }, 10);
        }
        function animateClose(container, box) {
            box.classList.remove('scale-100', 'opacity-100'); box.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { container.classList.add('hidden'); container.classList.remove('flex'); }, 200);
        }

        window.openProductModal = () => { currentTempVariants = []; updateVariantTable(); animateOpen(document.getElementById('productModal'), document.getElementById('productModalBox')); };
        window.closeProductModal = () => animateClose(document.getElementById('productModal'), document.getElementById('productModalBox'));
        window.openVariantModal = () => animateOpen(document.getElementById('variantModal'), document.getElementById('variantModalBox'));
        window.closeVariantModal = () => animateClose(document.getElementById('variantModal'), document.getElementById('variantModalBox'));

        document.getElementById('saveVariantBtn').addEventListener('click', () => {
            const sku = document.getElementById('v_sku').value;
            const tp = parseFloat(document.getElementById('v_tp').value) || 0;
            const stock = parseInt(document.getElementById('v_stock').value) || 0;
            if (!sku) return alert('SKU is required');
            currentTempVariants.push({ sku, batch: document.getElementById('v_batch').value, expiry: document.getElementById('v_expiry').value, tp, stock, subtotal: tp * stock });
            updateVariantTable();
            closeVariantModal();
            ['v_sku', 'v_batch', 'v_expiry', 'v_tp', 'v_stock'].forEach(id => document.getElementById(id).value = (id === 'v_tp' ? '0' : (id === 'v_stock' ? '1' : '')));
        });

        function updateVariantTable() {
            const tbody = document.getElementById('variantsTbody');
            if (currentTempVariants.length === 0) { tbody.innerHTML = '<tr><td colspan="5" class="p-4 text-center">No variants added</td></tr>'; return; }
            tbody.innerHTML = currentTempVariants.map((v, i) => `<tr class="bg-white"><td class="p-2">${v.sku}</td><td class="p-2">${v.batch || '-'}</td><td class="p-2 text-right">${v.tp}</td><td class="p-2 text-center">${v.stock}</td><td class="p-2 text-center text-red-500 cursor-pointer" onclick="currentTempVariants.splice(${i},1);updateVariantTable();"><i class="fa-solid fa-trash"></i></td></tr>`).join('');
        }

        window.addProductToPO = () => {
            const pName = document.getElementById('p_name').value;
            if (!pName || currentTempVariants.length === 0) return alert('Add product name and at least one variant');
            const productTotal = currentTempVariants.reduce((sum, v) => sum + v.subtotal, 0);
            poItemsList.push({ name: pName, variants: [...currentTempVariants], total: productTotal });
            updatePOTable();
            closeProductModal();
            document.getElementById('p_name').value = '';
        };

        function updatePOTable() {
            const tbody = document.getElementById('poProductsTbody');
            if (poItemsList.length === 0) { tbody.innerHTML = '<tr><td colspan="4" class="p-6 text-center italic text-gray-400">No products added yet.</td></tr>'; return; }
            tbody.innerHTML = poItemsList.map((p, i) => `<tr class="border-b"><td class="p-3 font-bold text-gray-700">${p.name}</td><td class="p-3"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-xs font-bold">${p.variants.length} Variants</span></td><td class="p-3 text-right font-bold text-green-700">PKR ${p.total.toLocaleString()}</td><td class="p-3 text-center"><button onclick="poItemsList.splice(${i},1);updatePOTable();" class="text-red-500"><i class="fa-solid fa-trash-can"></i></button></td></tr>`).join('');
        }

        window.submitFinalPO = async () => {
            const payload = {
                _token: "{{ csrf_token() }}",
                supplier: document.getElementById('po_supplier').value,
                date: document.getElementById('po_date').value,
                status: document.getElementById('po_status').value,
                total_amount: poItemsList.reduce((sum, p) => sum + p.total, 0),
                products: poItemsList
            };

            if (!payload.supplier || poItemsList.length === 0) return alert('Supplier and Products are mandatory');

            try {
                const response = await fetch("{{ route('po.store') }}", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "Accept": "application/json" },
                    body: JSON.stringify(payload)
                });
                const result = await response.json();
                if (result.success) window.location.reload();
                else alert(result.message);
            } catch (e) {
                alert('Something went wrong. Please check console.');
                console.error(e);
            }
        };

        window.deletePO = async (id) => {
            if (!confirm('Delete this PO?')) return;
            const res = await fetch(`/purchase-orders/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" }
            });
            if ((await res.json()).success) window.location.reload();
        };

        window.resetForm = () => { poItemsList = []; updatePOTable(); };
    </script>
@endsection