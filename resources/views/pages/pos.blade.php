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
                    <button id="scanButton"
                        class="w-10 h-10 flex items-center justify-center bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition duration-200"
                        title="Scan Barcode/QR">
                        <i class="fa-solid fa-barcode text-lg"></i>
                    </button>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 mb-5">
                    <div class="relative w-full">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input id="productSearch"
                            class="w-full pl-10 pr-3 py-2 bg-gray-100 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-300 outline-none transition placeholder-gray-500"
                            placeholder="Search by name, code, or batch number">
                    </div>

                    <select id="categorySelect"
                        class="px-3 py-2 rounded-xl border border-gray-300 bg-white text-sm w-full sm:w-auto text-gray-700 shadow-sm focus:border-blue-500">
                        <option value="">All Categories</option>
                        <option>Pain Relief</option>
                        <option>Antibiotics</option>
                        <option>Vitamins</option>
                    </select>
                </div>

                <div id="productGrid" class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-3 flex-grow overflow-y-auto pr-2">

                    {{-- Dynamic Product Cards Placeholder (5 times for design display) --}}
                    @for ($i = 1; $i <= 5; $i++)
                        <div class="product-card group p-2 border border-gray-200 rounded-xl bg-white shadow-md hover:shadow-xl hover:border-blue-500 transition duration-200 cursor-pointer flex flex-col items-center text-center" 
                            data-product-id="{{ $i }}" data-price="330.00" onclick="addToCart({{ $i }}, 'Panadol Extra {{ $i }}', 330.00)">
                            
                            {{-- Product Image (Smaller) --}}
                            <div class="relative w-full mb-2">
                                <img src="/assets/images/Panadol Extra 600x600.jpg"
                                    class="w-12 h-12 object-cover rounded-md shadow-sm mx-auto" alt="Product Image" />
                                <span class="absolute top-0 right-0 text-[10px] font-bold text-white bg-green-500 px-1 rounded-bl-lg">
                                    {{ 50 - $i }} Left
                                </span>
                            </div>

                            <div class="flex-grow w-full">
                                <p class="font-bold text-xs text-gray-900 truncate" title="Panadol Extra">Panadol Extra</p>
                                <p class="text-xs font-extrabold text-blue-600 mt-0.5">PKR 330.00</p>
                            </div>
                            
                            {{-- Add Button (Always visible and prominent) --}}
                            <button
                                class="mt-2 w-full py-1 bg-blue-500 text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition duration-300 shadow-md flex items-center justify-center gap-1"
                                title="Add to Cart">
                                <i class="fa-solid fa-plus text-xs"></i> Add
                            </button>
                        </div>
                    @endfor
                    
                    {{-- Add 5 more cards using another image to fill the grid --}}
                    @for ($i = 6; $i <= 10; $i++)
                        <div class="product-card group p-2 border border-gray-200 rounded-xl bg-white shadow-md hover:shadow-xl hover:border-blue-500 transition duration-200 cursor-pointer flex flex-col items-center text-center" 
                            data-product-id="{{ $i }}" data-price="550.00" onclick="addToCart({{ $i }}, 'Augmentin 625MG', 550.00)">
                            
                            {{-- Product Image (Smaller) --}}
                            <div class="relative w-full mb-2">
                                <img src="/assets/images/AugmentinTablets625Mg.webp"
                                    class="w-12 h-12 object-cover rounded-md shadow-sm mx-auto" alt="Product Image" />
                                <span class="absolute top-0 right-0 text-[10px] font-bold text-white bg-green-500 px-1 rounded-bl-lg">
                                    {{ 12 - ($i - 5) }} Left
                                </span>
                            </div>

                            <div class="flex-grow w-full">
                                <p class="font-bold text-xs text-gray-900 truncate" title="Augmentin 625MG">Augmentin 625MG</p>
                                <p class="text-xs font-extrabold text-blue-600 mt-0.5">PKR 550.00</p>
                            </div>
                            
                            {{-- Add Button (Always visible and prominent) --}}
                            <button
                                class="mt-2 w-full py-1 bg-blue-500 text-white rounded-lg text-sm font-semibold hover:bg-blue-600 transition duration-300 shadow-md flex items-center justify-center gap-1"
                                title="Add to Cart">
                                <i class="fa-solid fa-plus text-xs"></i> Add
                            </button>
                        </div>
                    @endfor

                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 p-4 md:p-6 h-[85vh] flex flex-col">

                <div class="border-b pb-4 mb-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-xl font-bold text-gray-800">Current Sale</h3>
                        <div class="text-sm text-gray-500 text-right">
                            <p>Order #: <span class="font-bold text-gray-700">10018373</span></p>
                            <p>Date: <span class="text-gray-700">12 Dec 2025</span></p>
                        </div>
                    </div>
                    
                    {{-- Customer Select --}}
                    <div class="mt-4 flex items-center gap-2">
                        <i class="fa-solid fa-user text-blue-500"></i>
                        <select id="customerSelect" class="flex-1 px-4 py-2 border rounded-lg bg-gray-50 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="walkin">Walk-in Customer</option>
                            <option>John Doe (Credit PKR 1500)</option>
                        </select>
                        <button class="w-8 h-8 flex items-center justify-center bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition" title="Add New Customer">
                            <i class="fa-solid fa-user-plus text-xs"></i>
                        </button>
                    </div>
                </div>


                <div id="cartList" class="flex-grow space-y-3 max-h-[40vh] overflow-y-auto pr-2 mb-4">

                    <div id="cart-item-1" class="cart-item flex justify-between items-center bg-gray-50 p-3 rounded-xl shadow-inner border border-gray-200">
                        <div class="flex items-center gap-3">
                            <img src="/assets/images/Panadol Extra 600x600.jpg"
                                class="w-10 h-10 rounded-lg shadow object-cover" />
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Panadol Extra</p>
                                <p class="text-xs text-blue-500">Batch: B45 | @ 330.00</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">

                            <div class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm">
                                <button onclick="updateQuantity(1, -1)" class="px-2 py-1 text-gray-600 hover:bg-gray-100 rounded-l-lg"><i class="fa-solid fa-minus text-[10px]"></i></button>
                                <span id="qty-1" class="px-2 font-bold text-sm w-8 text-center">2</span>
                                <button onclick="updateQuantity(1, 1)" class="px-2 py-1 text-gray-600 hover:bg-gray-100 rounded-r-lg"><i class="fa-solid fa-plus text-[10px]"></i></button>
                            </div>

                            <p id="total-1" class="font-extrabold text-sm w-16 text-right text-gray-900">660.00</p>

                            <button onclick="removeItem(1)" class="text-red-500 w-6 h-6 hover:bg-red-50 rounded-full transition" title="Remove Item">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div id="cart-item-2" class="cart-item flex justify-between items-center bg-gray-50 p-3 rounded-xl shadow-inner border border-gray-200">
                        <div class="flex items-center gap-3">
                            <img src="/assets/images/AugmentinTablets625Mg.webp"
                                class="w-10 h-10 rounded-lg shadow object-cover" />
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Augmentin 625MG</p>
                                <p class="text-xs text-blue-500">Batch: A12 | @ 550.00</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">

                            <div class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm">
                                <button onclick="updateQuantity(2, -1)" class="px-2 py-1 text-gray-600 hover:bg-gray-100 rounded-l-lg"><i class="fa-solid fa-minus text-[10px]"></i></button>
                                <span id="qty-2" class="px-2 font-bold text-sm w-8 text-center">1</span>
                                <button onclick="updateQuantity(2, 1)" class="px-2 py-1 text-gray-600 hover:bg-gray-100 rounded-r-lg"><i class="fa-solid fa-plus text-[10px]"></i></button>
                            </div>

                            <p id="total-2" class="font-extrabold text-sm w-16 text-right text-gray-900">550.00</p>

                            <button onclick="removeItem(2)" class="text-red-500 w-6 h-6 hover:bg-red-50 rounded-full transition" title="Remove Item">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Cart items will be dynamically added here --}}

                </div>

                <div class="mt-auto space-y-3 text-sm pt-4 border-t border-gray-300">
                    <div class="flex justify-between text-gray-700">
                        <span>Subtotal</span> <span id="subtotal" class="font-semibold">PKR 1,210.00</span>
                    </div>

                    <div class="flex justify-between text-gray-700">
                        <span>Tax (GST 17%)</span> <span id="tax" class="font-semibold">PKR 205.70</span>
                    </div>

                    <div class="flex justify-between text-gray-700">
                        <span>Discount (<span id="discountPercent">0</span>%)</span> <span id="discount" class="font-semibold text-red-600">PKR 0.00</span>
                    </div>

                    <div class="flex justify-between text-3xl font-extrabold border-t border-gray-300 pt-3 text-green-700">
                        <span>TOTAL</span> <span id="grandTotal">PKR 1,415.70</span>
                    </div>
                </div>

                 <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6">

                    <button
                        class="bg-green-600 text-white py-3 rounded-xl shadow-lg hover:bg-green-700 font-bold transition flex items-center justify-center gap-2 text-base">
                        <i class="fa-solid fa-cash-register"></i> Cash
                    </button>

                    <button
                        class="bg-blue-600 text-white py-3 rounded-xl shadow-lg hover:bg-blue-700 font-bold transition flex items-center justify-center gap-2 text-base">
                        <i class="fa-solid fa-credit-card"></i> Card
                    </button>

                    <button
                        class="bg-purple-600 text-white py-3 rounded-xl shadow-lg hover:bg-purple-700 transition flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-file-invoice"></i> Credit Sale
                    </button>

                    <button
                        class="bg-gray-500 text-white py-3 rounded-xl shadow-lg hover:bg-gray-600 transition flex items-center justify-center gap-2 text-sm">
                        <i class="fa-solid fa-clock-rotate-left"></i> Hold
                    </button>

                </div>
                
                {{-- Clear/Discount/Other Options --}}
                <div class="flex justify-between gap-3 mt-3">
                     <button class="flex-1 bg-yellow-100 text-red-700 py-2 rounded-xl hover:bg-yellow-200 transition text-sm font-semibold">
                       <i class="fa-solid fa-trash-can mr-1"></i> Clear Cart
                    </button>
                     <button class="flex-1 bg-yellow-100 text-yellow-700 py-2 rounded-xl hover:bg-yellow-200 transition text-sm font-semibold">
                        <i class="fa-solid fa-percent mr-1"></i> Discount
                    </button>
                </div>

            </div>
        </div>

    </div>

</main>

@endsection

@push('scripts')
<script>
// Mock Cart Data Structure (Kept for functionality)
let cart = [
    { id: 1, name: 'Panadol Extra', unitPrice: 330.00, quantity: 2, total: 660.00 },
    { id: 2, name: 'Augmentin 625MG', unitPrice: 550.00, quantity: 1, total: 550.00 }
];
let discountRate = 0; // 0% discount
const TAX_RATE = 0.17; // 17% GST

// --- Helper Function ---
function formatPKR(value) {
    return `PKR ${value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
}

// --- Main Logic ---

// Function to calculate and update all totals
function calculateTotals() {
    let subtotal = cart.reduce((sum, item) => sum + item.total, 0);
    
    let discountAmount = subtotal * discountRate;
    let discountedSubtotal = subtotal - discountAmount;

    let tax = discountedSubtotal * TAX_RATE;
    let grandTotal = discountedSubtotal + tax;

    // Update DOM elements
    document.getElementById('subtotal').textContent = formatPKR(subtotal);
    document.getElementById('tax').textContent = formatPKR(tax);
    document.getElementById('discount').textContent = formatPKR(discountAmount);
    document.getElementById('grandTotal').textContent = formatPKR(grandTotal);
    document.getElementById('discountPercent').textContent = (discountRate * 100).toFixed(0);
    
    // Hide/Show Clear Cart button based on cart size (optional)
    const clearButton = document.querySelector('.flex-1.bg-red-100');
    if (clearButton) {
        clearButton.style.display = cart.length > 0 ? 'flex' : 'none';
    }
}

// Function to update quantity of an item
window.updateQuantity = function(id, change) {
    const item = cart.find(i => i.id === id);
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            removeItem(id);
            return;
        }
        item.total = item.quantity * item.unitPrice;
        document.getElementById(`qty-${id}`).textContent = item.quantity;
        document.getElementById(`total-${id}`).textContent = item.total.toFixed(2);
        calculateTotals();
    }
}

// Function to remove an item from the cart
window.removeItem = function(id) {
    cart = cart.filter(item => item.id !== id);
    const itemElement = document.getElementById(`cart-item-${id}`);
    if (itemElement) {
        itemElement.remove();
    }
    calculateTotals();
}

// Function to add item to cart (mock function for buttons)
window.addToCart = function(id, name, price) {
    const existingItem = cart.find(i => i.id === id);
    if (existingItem) {
        updateQuantity(id, 1);
    } else {
        // NOTE: In a real system, you would dynamically create and append a new cart item element here.
        alert(`Product: ${name} (PKR ${price.toFixed(2)}) added to cart! (ID: ${id})`);
        // Mock add to cart array for totals calculation
        cart.push({ id: id, name: name, unitPrice: price, quantity: 1, total: price });
        calculateTotals();
    }
}

// Initialize totals when the page loads
document.addEventListener('DOMContentLoaded', calculateTotals);
</script>
@endpush