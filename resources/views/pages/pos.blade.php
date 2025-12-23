@extends('layouts.main')
@section('title', 'POS - Point of Sale')

@section('content')
<main class="h-screen overflow-y-auto p-4 md:p-8 pt-20 bg-gray-50 flex flex-col">
    <div class="max-w-[1600px] mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-[2.5fr_1.5fr] gap-6 items-stretch">

            {{-- LEFT SIDE: PRODUCT SECTION --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 h-[85vh] flex flex-col">
                <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 tracking-tighter italic uppercase leading-none">Inventory Items</h2>
                        <p class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mt-1">Direct Selection & Search</p>
                    </div>
                    {{-- Search Bar: No Page Reload --}}
                    <div class="relative w-full max-w-md">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="productSearch" oninput="fetchProducts(1)"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 rounded-2xl border border-gray-200 focus:ring-4 focus:ring-blue-50 focus:border-blue-400 outline-none transition shadow-inner font-bold text-sm"
                            placeholder="Search by name or SKU...">
                    </div>
                </div>

                {{-- Product Grid: 4 per Row Layout --}}
                <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 flex-grow overflow-y-auto pr-2 py-2 content-start min-h-0">
                    {{-- Data loaded via fetchProducts() --}}
                </div>

                {{-- Pagination Links --}}
                <div id="paginationLinks" class="mt-4 pt-4 border-t border-gray-100 flex justify-center gap-2"></div>
            </div>

            {{-- RIGHT SIDE: CART SECTION --}}
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 h-[85vh] flex flex-col overflow-hidden">
                <div class="border-b border-gray-100 pb-4 mb-4">
                    <h3 class="text-xl font-black text-gray-900 tracking-tighter uppercase italic leading-none">Current Invoice</h3>
                    <div class="mt-4 flex items-center gap-3">
                        <select id="customerSelect" class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl bg-gray-50 text-sm font-bold focus:ring-4 focus:ring-blue-50 outline-none">
                            <option value="walkin">Walk-in Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->customer_name }} (Due: {{ number_format($customer->credit_balance, 0) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Cart Items List --}}
                <div id="cartList" class="flex-grow space-y-3 overflow-y-auto pr-2 mb-4 scrollbar-hide"></div>

                {{-- CALCULATION BOX WITH INPUTS --}}
                <div class="mt-auto space-y-3 bg-gray-50 p-5 rounded-3xl border border-gray-200 shadow-inner">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Discount (PKR)</label>
                            <input type="number" id="discountInput" oninput="calculateTotals()" value="0" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm font-bold text-red-600 outline-none focus:ring-2 focus:ring-red-100">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-gray-400 uppercase ml-1">Srv. Charges</label>
                            <input type="number" id="serviceInput" oninput="calculateTotals()" value="0" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm font-bold text-blue-600 outline-none focus:ring-2 focus:ring-blue-100">
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-gray-200 text-xs font-bold text-gray-500 uppercase font-black">
                        <span>Subtotal</span>
                        <span id="subtotal" class="text-gray-800">0.00</span>
                    </div>

                    <div class="flex justify-between items-end text-green-700">
                        <span class="text-xs font-black uppercase tracking-tighter">Net Payable</span>
                        <span id="grandTotal" class="text-2xl font-black italic tracking-tighter leading-none">PKR 0.00</span>
                    </div>

                    {{-- Partial Payment Input --}}
                    <div class="pt-3 border-t border-gray-200">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-1 block mb-1">Cash Received</label>
                        <input type="number" id="cashReceived" oninput="calculateTotals()" placeholder="Enter amount..." 
                               class="w-full px-3 py-2 bg-white border-2 border-green-500 rounded-2xl text-xl font-black text-green-700 outline-none focus:ring-4 focus:ring-green-100 transition-all shadow-sm">
                    </div>

                    <div id="balanceBox" class="flex justify-between items-center px-2 mt-1">
                        <span id="balanceLabel" class="text-[10px] font-bold uppercase text-gray-400">Return Change</span>
                        <span id="balanceAmount" class="text-lg font-black text-gray-800">0.00</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-6">
                    <button onclick="processCheckout('cash')" class="bg-emerald-600 text-white py-4 rounded-2xl shadow-lg hover:bg-emerald-700 font-black uppercase text-xs tracking-widest transition active:scale-95 ring-4 ring-emerald-50">
                        <i class="fa-solid fa-money-bill-wave mr-2"></i> Pay Cash
                    </button>
                    <button onclick="processCheckout('credit')" class="bg-blue-600 text-white py-4 rounded-2xl shadow-lg hover:bg-blue-700 font-black uppercase text-xs tracking-widest transition active:scale-95 ring-4 ring-blue-50">
                        <i class="fa-solid fa-credit-card mr-2"></i> On Credit
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let cart = [];

    // --- 1. AJAX Product Fetching (No Reload) ---
    async function fetchProducts(page = 1) {
        const search = document.getElementById('productSearch').value;
        const grid = document.getElementById('productGrid');
        const pagination = document.getElementById('paginationLinks');

        grid.innerHTML = '<div class="col-span-full py-20 text-center"><i class="fa-solid fa-circle-notch fa-spin text-3xl text-blue-500"></i></div>';

        try {
            const response = await fetch(`{{ route('pos.search') }}?page=${page}&search=${encodeURIComponent(search)}`);
            const data = await response.json();

            renderGrid(data.data);
            renderPagination(data);
        } catch (error) {
            grid.innerHTML = '<div class="col-span-full py-20 text-center text-red-500 font-bold">Error loading inventory.</div>';
        }
    }

    function renderGrid(products) {
        const grid = document.getElementById('productGrid');
        grid.innerHTML = products.length === 0 ? '<div class="col-span-full py-20 text-center text-gray-400 italic font-bold">No results found</div>' : '';
        
        products.forEach(p => {
            const stockColor = p.stock_level < 10 ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600';
            grid.innerHTML += `
                <div class="product-card group relative p-4 border border-gray-100 rounded-2xl bg-white shadow-sm hover:shadow-xl hover:border-blue-400 transition-all duration-300 cursor-pointer flex flex-col justify-between h-[190px] transform hover:-translate-y-1"
                     onclick="addToCart(${p.id}, '${p.medicine.name}', ${p.sale_price || 0}, '${p.sku}', ${p.stock_level})">
                    <div class="flex justify-between items-start">
                        <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase ${stockColor}">Stock: ${p.stock_level}</span>
                        <i class="fa-solid fa-capsules text-gray-200 group-hover:text-blue-500"></i>
                    </div>
                    <div class="mt-2">
                        <h4 class="font-black text-sm text-gray-800 leading-tight line-clamp-2 uppercase">${p.medicine.name}</h4>
                        <p class="text-[9px] font-bold text-blue-400 mt-1 uppercase">SKU: ${p.sku}</p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                        <div><span class="text-base font-black text-gray-900 italic"><span class="text-[10px] font-bold text-gray-400 not-italic">PKR</span> ${Number(p.sale_price).toLocaleString()}</span></div>
                        <div class="w-8 h-8 rounded-xl bg-gray-50 group-hover:bg-blue-600 text-gray-300 group-hover:text-white flex items-center justify-center transition-all shadow-sm"><i class="fa-solid fa-plus text-xs"></i></div>
                    </div>
                </div>`;
        });
    }

    function renderPagination(data) {
        const container = document.getElementById('paginationLinks');
        container.innerHTML = '';
        if (data.last_page > 1) {
            for (let i = 1; i <= data.last_page; i++) {
                const active = i === data.current_page ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200';
                container.innerHTML += `<button onclick="fetchProducts(${i})" class="px-3 py-1 rounded-lg font-black text-[10px] transition ${active}">${i}</button>`;
            }
        }
    }

    // --- 2. Cart Logic ---
    window.addToCart = function (id, name, price, sku, stock) {
        const item = cart.find(i => i.id === id);
        if (item) {
            if (item.quantity < stock) {
                item.quantity++;
                item.total = item.quantity * item.unitPrice;
            } else { Swal.fire('Stock Limit', 'Limit reached!', 'warning'); }
        } else {
            if (stock > 0) cart.push({ id, name, unitPrice: price, quantity: 1, total: price, sku, stock });
            else Swal.fire('Out of Stock', 'Product unavailable', 'error');
        }
        renderCart();
    };

    function renderCart() {
        const list = document.getElementById('cartList');
        list.innerHTML = cart.length === 0 ? '<div class="text-center py-20 text-gray-300 italic font-bold">Terminal Ready</div>' : '';
        cart.forEach(item => {
            list.innerHTML += `
                <div class="cart-item flex justify-between items-center bg-white p-4 rounded-2xl border border-gray-100 shadow-sm transition">
                    <div class="flex flex-col">
                        <p class="font-black text-xs text-gray-800 uppercase tracking-tight">${item.name}</p>
                        <p class="text-[9px] font-bold text-blue-500 uppercase tracking-widest">${item.sku} @ ${item.unitPrice}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl">
                            <button onclick="updateQty(${item.id}, -1)" class="px-3 py-1 hover:bg-gray-100"><i class="fa-solid fa-minus text-[10px]"></i></button>
                            <span class="px-2 font-black text-xs">${item.quantity}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="px-3 py-1 hover:bg-gray-100"><i class="fa-solid fa-plus text-[10px]"></i></button>
                        </div>
                        <p class="font-black text-xs w-16 text-right text-gray-900 italic">${item.total.toLocaleString()}</p>
                        <button onclick="removeItem(${item.id})" class="text-red-300 hover:text-red-600 transition ml-1"><i class="fa-solid fa-circle-xmark"></i></button>
                    </div>
                </div>`;
        });
        calculateTotals();
    }

    // --- 3. Calculation Logic (Real-time Change & Debt) ---
    function calculateTotals() {
        let subtotal = cart.reduce((sum, i) => sum + i.total, 0);
        let discount = parseFloat(document.getElementById('discountInput').value) || 0;
        let serviceCharges = parseFloat(document.getElementById('serviceInput').value) || 0;
        let cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;

        let grandTotal = (subtotal + serviceCharges) - discount;
        if (grandTotal < 0) grandTotal = 0;
        let balance = cashReceived - grandTotal;

        document.getElementById('subtotal').innerText = subtotal.toLocaleString();
        document.getElementById('grandTotal').innerText = `PKR ${grandTotal.toLocaleString()}`;
        
        const balanceElem = document.getElementById('balanceAmount');
        const labelElem = document.getElementById('balanceLabel');
        
        if (balance >= 0) {
            labelElem.innerText = "Return Change";
            balanceElem.innerText = balance.toLocaleString();
            balanceElem.className = "text-lg font-black text-gray-800";
        } else {
            labelElem.innerText = "Remaining Debt";
            balanceElem.innerText = Math.abs(balance).toLocaleString();
            balanceElem.className = "text-lg font-black text-red-600";
        }
    }

    window.updateQty = (id, change) => {
        const item = cart.find(i => i.id === id);
        if (item) {
            if (change > 0 && item.quantity >= item.stock) return Swal.fire('Limit', 'Max stock reached', 'info');
            item.quantity += change;
            if (item.quantity <= 0) return removeItem(id);
            item.total = item.quantity * item.unitPrice;
            renderCart();
        }
    };

    window.removeItem = (id) => { cart = cart.filter(i => i.id !== id); renderCart(); };

    // --- 4. Final Checkout & Ledger Sync ---
    async function processCheckout(method) {
        if (cart.length === 0) return Swal.fire('Empty Cart', 'Please add items', 'info');

        let subtotal = cart.reduce((sum, i) => sum + i.total, 0);
        let discount = parseFloat(document.getElementById('discountInput').value) || 0;
        let serviceCharges = parseFloat(document.getElementById('serviceInput').value) || 0;
        let cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;
        let finalTotal = (subtotal + serviceCharges) - discount;

        const payload = {
            customer_id: document.getElementById('customerSelect').value,
            payment_method: method,
            items: cart.map(i => ({ variant_id: i.id, quantity: i.quantity })),
            subtotal: subtotal,
            discount: discount,
            service_charges: serviceCharges,
            cash_received: cashReceived,
            total_amount: finalTotal
        };

        if (payload.customer_id === 'walkin' && cashReceived < finalTotal && method === 'cash') {
            return Swal.fire('Payment Short', 'Walk-in customers cannot carry debt.', 'error');
        }

        try {
            const response = await fetch("{{ route('pos.checkout') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify(payload)
            });
            const res = await response.json();
            if (res.success) {
                Swal.fire('Success', 'Sale Recorded & Ledger Updated!', 'success').then(() => location.reload());
            } else { Swal.fire('Error', res.message, 'error'); }
        } catch (e) { Swal.fire('Error', 'Transaction failed', 'error'); }
    }

    document.addEventListener('DOMContentLoaded', () => { fetchProducts(1); renderCart(); });
</script>
@endpush