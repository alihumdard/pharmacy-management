@extends('layouts.main')
@section('title', 'POS - Point of Sale')

@section('content')
<main class="overflow-y-auto p-4 md:p-8">
    <div class="max-w-[1400px] mx-auto">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 hidden md:block">New Sale Transaction</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-[2fr_1.5fr] xl:grid-cols-[3fr_2fr] gap-6">

            <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 p-4 md:p-6 h-[85vh] flex flex-col">
                <div class="flex items-center justify-between mb-4 border-b pb-4">
                    <h3 class="text-xl font-bold text-gray-800">Available Products</h3>
                    <button id="scanButton" class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full shadow-lg">
                        <i class="fa-solid fa-barcode text-lg"></i>
                    </button>
                </div>

                <div class="relative w-full mb-5">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input id="productSearch" onkeyup="searchProducts(this.value)"
                        class="w-full pl-10 pr-3 py-2 bg-gray-100 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-300 outline-none transition"
                        placeholder="Search by name or SKU...">
                </div>

                <div id="productGrid" class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 flex-grow overflow-y-auto pr-2 py-2 content-start">
                    @foreach($products as $product)
                        <div class="product-card group relative p-4 border border-gray-200 rounded-2xl bg-white shadow-sm hover:shadow-xl hover:border-blue-400 transition-all duration-300 cursor-pointer flex flex-col justify-between h-[180px]"
                            onclick="addToCart({{ $product->id }}, '{{ $product->medicine->name }}', {{ $product->sale_price ?? 0 }}, '{{ $product->sku }}', {{ $product->stock_level }})">
                            
                            <div class="flex justify-between items-start mb-2">
                                <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $product->stock_level < 10 ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                    {{ $product->stock_level }} In Stock
                                </span>
                                <i class="fa-solid fa-capsules text-gray-200 group-hover:text-blue-100 transition-colors"></i>
                            </div>

                            <div class="flex-grow">
                                <h4 class="font-bold text-sm text-gray-900 leading-tight mb-1 line-clamp-2">{{ $product->medicine->name }}</h4>
                                <p class="text-[10px] font-mono text-gray-400">SKU: {{ $product->sku }}</p>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-gray-400 block uppercase">Price</span>
                                    <span class="text-base font-black text-gray-900">
                                        <span class="text-xs font-normal text-gray-500">PKR</span> {{ number_format($product->sale_price, 0) }}
                                    </span>
                                </div>
                                <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-600 text-gray-400 group-hover:text-white flex items-center justify-center transition-all">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 p-4 md:p-6 h-[85vh] flex flex-col">
                <div class="border-b pb-4 mb-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-xl font-bold text-gray-800">Current Sale</h3>
                        <p class="text-sm text-gray-500">{{ date('d M Y') }}</p>
                    </div>
                    <div class="mt-4 flex items-center gap-2">
                        <i class="fa-solid fa-user text-blue-500"></i>
                        <select id="customerSelect" class="flex-1 px-4 py-2 border rounded-lg bg-gray-50 text-sm">
                            <option value="walkin">Walk-in Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->customer_name }} (Due: {{ number_format($customer->credit_balance, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="cartList" class="flex-grow space-y-3 max-h-[40vh] overflow-y-auto pr-2 mb-4"></div>

                <div class="mt-auto space-y-3 text-sm pt-4 border-t border-gray-300">
                    <div class="flex justify-between text-gray-700"><span>Subtotal</span> <span id="subtotal">PKR 0.00</span></div>
                    <div class="flex justify-between text-gray-700"><span>Tax (17%)</span> <span id="tax">PKR 0.00</span></div>
                    <div class="flex justify-between text-3xl font-extrabold border-t border-gray-300 pt-3 text-green-700">
                        <span>TOTAL</span> <span id="grandTotal">PKR 0.00</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-6">
                    <button onclick="processCheckout('cash')" class="bg-green-600 text-white py-3 rounded-xl shadow-lg hover:bg-green-700 font-bold flex items-center justify-center gap-2 transition">
                        <i class="fa-solid fa-cash-register"></i> Cash
                    </button>
                    <button onclick="processCheckout('credit')" class="bg-purple-600 text-white py-3 rounded-xl shadow-lg hover:bg-purple-700 font-bold flex items-center justify-center gap-2 transition">
                        <i class="fa-solid fa-file-invoice"></i> Credit
                    </button>
                </div>
                <button onclick="clearCart()" class="mt-3 w-full bg-red-100 text-red-700 py-2 rounded-xl text-sm font-semibold transition hover:bg-red-200">
                    <i class="fa-solid fa-trash-can mr-1"></i> Clear Cart
                </button>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    let cart = [];
    const TAX_RATE = 0.17;

    // --- Search Products: Fixed Row Height and Design ---
    async function searchProducts(query) {
        if (query.length === 0) { location.reload(); return; }
        if (query.length < 2) return;

        try {
            const response = await fetch(`{{ route('pos.search') }}?search=${encodeURIComponent(query)}`);
            const products = await response.json();
            const grid = document.getElementById('productGrid');
            grid.innerHTML = '';

            products.forEach(p => {
                const stockClass = p.stock_level < 10 ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600';
                // Fixed height 'h-[180px]' ensures cards stay same size even if only one exists
                grid.innerHTML += `
                    <div class="product-card group relative p-4 border border-gray-200 rounded-2xl bg-white shadow-sm hover:shadow-xl hover:border-blue-400 transition-all duration-300 cursor-pointer flex flex-col justify-between h-[180px]"
                        onclick="addToCart(${p.id}, '${p.medicine.name}', ${p.sale_price || 0}, '${p.sku}', ${p.stock_level})">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase ${stockClass}">${p.stock_level} In Stock</span>
                            <i class="fa-solid fa-capsules text-gray-200"></i>
                        </div>
                        <div class="flex-grow">
                            <h4 class="font-bold text-sm text-gray-900 leading-tight mb-1 line-clamp-2">${p.medicine.name}</h4>
                            <p class="text-[10px] font-mono text-gray-400">SKU: ${p.sku}</p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-50 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-gray-400 block uppercase">Price</span>
                                <span class="text-base font-black text-gray-900"><span class="text-xs font-normal">PKR</span> ${Number(p.sale_price).toLocaleString()}</span>
                            </div>
                            <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-600 text-gray-400 group-hover:text-white flex items-center justify-center transition-all">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </div>
                        </div>
                    </div>`;
            });
        } catch (error) { console.error("Search failed:", error); }
    }

    // --- Add to Cart ---
    window.addToCart = function (id, name, price, sku, stock) {
        const item = cart.find(i => i.id === id);
        if (item) {
            if (item.quantity < stock) {
                item.quantity++;
                item.total = item.quantity * item.unitPrice;
            } else { alert("Out of stock!"); }
        } else {
            cart.push({ id, name, unitPrice: price, quantity: 1, total: price, sku, stock });
        }
        renderCart();
    };

    // --- Render Cart Items ---
    function renderCart() {
        const list = document.getElementById('cartList');
        list.innerHTML = '';
        cart.forEach(item => {
            list.innerHTML += `
                <div class="cart-item flex justify-between items-center bg-gray-50 p-3 rounded-xl border border-gray-200">
                    <div class="text-sm">
                        <p class="font-semibold text-gray-800">${item.name}</p>
                        <p class="text-xs text-blue-500">${item.sku} @ ${item.unitPrice}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center bg-white border rounded-lg">
                            <button onclick="updateQty(${item.id}, -1)" class="px-2 py-1"><i class="fa-solid fa-minus text-xs"></i></button>
                            <span class="px-2 font-bold">${item.quantity}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="px-2 py-1"><i class="fa-solid fa-plus text-xs"></i></button>
                        </div>
                        <p class="font-bold text-sm w-16 text-right">${item.total.toFixed(2)}</p>
                        <button onclick="removeItem(${item.id})" class="text-red-500"><i class="fa-solid fa-trash-can"></i></button>
                    </div>
                </div>`;
        });
        calculateTotals();
    }

    // --- Update Quantity ---
    window.updateQty = (id, change) => {
        const item = cart.find(i => i.id === id);
        if (item && !(change > 0 && item.quantity >= item.stock)) {
            item.quantity += change;
            if (item.quantity <= 0) return removeItem(id);
            item.total = item.quantity * item.unitPrice;
            renderCart();
        } else if (change > 0) { alert("Stock limit reached"); }
    };

    // --- Remove and Clear ---
    window.removeItem = (id) => { cart = cart.filter(i => i.id !== id); renderCart(); };
    window.clearCart = () => { cart = []; renderCart(); };

    // --- Calculate Totals ---
    function calculateTotals() {
        let subtotal = cart.reduce((sum, i) => sum + i.total, 0);
        let tax = subtotal * TAX_RATE;
        document.getElementById('subtotal').innerText = `PKR ${subtotal.toFixed(2)}`;
        document.getElementById('tax').innerText = `PKR ${tax.toFixed(2)}`;
        document.getElementById('grandTotal').innerText = `PKR ${(subtotal + tax).toFixed(2)}`;
    }

    // --- Checkout Logic ---
    async function processCheckout(method) {
        if (cart.length === 0) return alert("Cart is empty");
        const data = {
            customer_id: document.getElementById('customerSelect').value,
            payment_method: method,
            items: cart.map(i => ({ variant_id: i.id, quantity: i.quantity })),
            total_amount: cart.reduce((sum, i) => sum + i.total, 0) * (1 + TAX_RATE)
        };
        const response = await fetch("{{ route('pos.checkout') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify(data)
        });
        const res = await response.json();
        if (res.success) { alert(res.message); location.reload(); }
        else { alert("Error: " + res.message); }
    }
</script>
@endpush