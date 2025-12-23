@extends('layouts.main')
@section('title', 'Medicine Database')

@section('content')
<main class="h-screen overflow-y-auto p-4 md:p-8 pt-24 bg-gray-50 flex flex-col">

    <div class="max-w-7xl mx-auto w-full">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-8 pb-4 border-b border-gray-200 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 italic uppercase tracking-tighter">Inventory Catalogue</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Manage your pharmacy products and stock variants efficiently.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button onclick="window.location.href='{{ route('medicines.index') }}'" class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 flex items-center gap-2 shadow-sm transition text-sm font-bold text-gray-600">
                    <i class="fa-solid fa-rotate-right"></i> Reset
                </button>
                <button onclick="openProductModal()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg font-black flex items-center gap-2 transition text-sm uppercase tracking-wider">
                    <i class="fa-solid fa-plus"></i> Add Product
                </button>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-4 md:p-6 mb-10">
            {{-- Search Bar Section --}}
            <div class="mb-8">
                <form action="{{ route('medicines.index') }}" method="GET" class="relative max-w-md">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, batch, or SKU..."
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl outline-none text-sm text-gray-700 focus:ring-4 focus:ring-blue-50 focus:border-blue-400 transition shadow-inner">
                </form>
            </div>

            {{-- Main Listing Table --}}
            <div class="overflow-x-auto rounded-2xl border border-gray-100 shadow-sm">
                <table class="w-full border-collapse text-sm min-w-[1000px]">
                    <thead class="bg-blue-600 text-white text-left">
                        <tr>
                            <th class="py-4 px-6 font-bold uppercase tracking-widest text-[10px]">Medicine / SKU</th>
                            <th class="py-4 px-4 font-bold uppercase tracking-widest text-[10px]">Batch #</th>
                            <th class="py-4 px-4 font-bold uppercase tracking-widest text-[10px]">Expiry</th>
                            <th class="py-4 px-4 font-bold uppercase tracking-widest text-[10px]">Stock Level</th>
                            <th class="py-4 px-4 font-bold uppercase tracking-widest text-[10px] text-right">TP (Price)</th>
                            <th class="py-4 px-4 font-bold uppercase tracking-widest text-[10px] text-right">MRP (Sale)</th>
                            <th class="py-4 px-6 font-bold uppercase tracking-widest text-[10px] text-center w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($variants as $variant)
                        <tr class="hover:bg-blue-50/30 transition group {{ $variant->stock_level <= $variant->reorder_level ? 'bg-red-50/50' : '' }}">
                            <td class="py-4 px-6 font-black text-gray-800">{{ $variant->medicine->name }} <br> <span class="text-[9px] text-blue-500 uppercase">{{ $variant->sku }}</span></td>
                            <td class="py-4 px-4 text-gray-600 font-bold">{{ $variant->batch_no ?? '---' }}</td>
                            <td class="py-4 px-4">
                                @if($variant->expiry_date)
                                    <span class="font-medium {{ \Carbon\Carbon::parse($variant->expiry_date)->isPast() ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                        {{ \Carbon\Carbon::parse($variant->expiry_date)->format('d M, Y') }}
                                    </span>
                                @else <span class="text-gray-300 italic">N/A</span> @endif
                            </td>
                            <td class="py-4 px-4"><span class="font-bold {{ $variant->stock_level <= $variant->reorder_level ? 'text-red-600' : 'text-emerald-600' }}">{{ $variant->stock_level }}</span></td>
                            <td class="py-4 px-4 text-right">PKR {{ number_format($variant->purchase_price, 2) }}</td>
                            <td class="py-4 px-4 text-right font-black">PKR {{ number_format($variant->sale_price, 2) }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center gap-3">
                                    <button onclick='openEditModal({!! json_encode($variant) !!}, {!! json_encode($variant->medicine) !!})' class="text-blue-500 hover:text-blue-700 transition"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button onclick="deleteProduct({{ $variant->id }})" class="text-red-400 hover:text-red-600 transition"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="py-20 text-center text-gray-400 italic">No inventory matches found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-8 flex justify-center">{{ $variants->appends(request()->input())->links() }}</div>
        </div>
    </div>
</main>

{{-- MODAL: Product Management (Entry) --}}
<div id="productModal" class="fixed inset-0 bg-black/60 hidden flex justify-center items-center z-[100] p-4 backdrop-blur-md">
    <div id="productModalBox" class="bg-white w-full max-w-5xl rounded-[2rem] shadow-2xl flex flex-col overflow-hidden transform transition-all duration-300 scale-95 opacity-0" style="max-height:92vh;">
        <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
            <h2 class="text-2xl font-black text-gray-900 italic uppercase tracking-tighter">Inventory Hub</h2>
            <button onclick="closeProductModal()" class="text-gray-400 hover:text-red-600 text-3xl font-light">&times;</button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Medicine Name *</label>
                    <input id="p_name" list="existing_medicines" onchange="handleProductSelect(this.value)" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-2xl outline-none focus:ring-4 focus:ring-blue-50 font-bold" placeholder="Search..." />
                    <datalist id="existing_medicines">
                        @foreach($allMedicines as $med)
                            <option value="{{ $med->name }}" data-generic="{{ $med->generic_name }}" data-manufacturer="{{ $med->manufacturer }}" data-variants="{{ json_encode($med->variants) }}">
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Generic</label>
                    <input id="p_generic" class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-gray-50/50 outline-none" />
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Manufacturer</label>
                    <input id="p_man" class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-gray-50/50 outline-none" />
                </div>
            </div>

            <div class="bg-blue-50/30 rounded-3xl p-6 border border-blue-100">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="font-black text-blue-800 uppercase text-xs tracking-widest border-l-4 border-blue-600 pl-3">Stock Variants</h4>
                    <button onclick="addNewEmptyVariant()" class="px-5 py-2 bg-green-500 text-white rounded-xl shadow-lg hover:bg-green-600 transition text-[10px] font-black uppercase ring-4 ring-green-50">Add SKU</button>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <table class="w-full text-xs">
                        <thead class="bg-gray-50 text-gray-400 font-black uppercase tracking-widest">
                            <tr class="text-left">
                                <th class="py-4 px-4">SKU Name</th>
                                <th class="py-4 px-4">Batch #</th>
                                <th class="py-4 px-4">Expiry Date</th> {{-- New Column --}}
                                <th class="py-4 px-4 text-center">Stock</th>
                                <th class="py-4 px-4 text-right">MRP</th>
                                <th class="py-4 px-4 w-16"></th>
                            </tr>
                        </thead>
                        <tbody id="variantsTbody" class="divide-y divide-gray-50"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="p-6 border-t bg-gray-50 flex justify-end gap-4 shadow-2xl">
            <button onclick="closeProductModal()" class="px-8 py-3 bg-white border border-gray-200 rounded-2xl font-bold text-gray-500 uppercase tracking-widest text-xs">Discard</button>
            <button id="saveProductBtn" class="px-10 py-3 bg-blue-600 text-white rounded-2xl font-black shadow-xl uppercase tracking-widest text-xs">Commit Changes</button>
        </div>
    </div>
</div>

{{-- MODAL: Edit Inventory Item (Single Variant) --}}
<div id="editModal" class="fixed inset-0 bg-black/60 hidden flex justify-center items-center z-[100] p-4 backdrop-blur-md">
    <div id="editModalBox" class="bg-white w-full max-w-xl rounded-[2rem] shadow-2xl flex flex-col overflow-hidden transform transition-all duration-200 scale-95 opacity-0">
        <div class="p-6 border-b bg-gray-50 font-black uppercase italic text-gray-900 text-xl tracking-tighter">Update Variant Details</div>
        <form id="editForm" class="p-8 space-y-6">
            <input type="hidden" id="edit_variant_id">
            <input type="hidden" id="hidden_tp">
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-1 block">Medicine Name</label>
                    <input type="text" id="edit_name" class="w-full border border-gray-200 rounded-2xl p-3.5 bg-gray-50 font-bold outline-none cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-1 block">SKU / Package</label>
                    <input type="text" id="edit_sku" class="w-full border border-gray-200 rounded-2xl p-3.5 outline-none font-bold text-blue-600" required>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-1 block">Batch No</label>
                    <input type="text" id="edit_batch" class="w-full border border-gray-200 rounded-2xl p-3.5 outline-none font-bold text-gray-700">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-1 block">Expiry Date</label> {{-- Added --}}
                    <input type="date" id="edit_expiry" class="w-full border border-gray-200 rounded-2xl p-3.5 outline-none font-bold text-red-500">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-1 block">MRP (Sale Price)</label>
                    <input type="number" step="0.01" id="edit_mrp" class="w-full border border-gray-200 rounded-2xl p-3.5 outline-none font-black text-emerald-600">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-1 block">Current Stock</label>
                    <input type="number" id="edit_stock" class="w-full border border-gray-200 rounded-2xl p-3.5 outline-none font-black text-gray-800">
                </div>
            </div>
            <div class="mt-10 flex justify-end gap-4">
                <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-gray-100 rounded-xl font-bold text-gray-500 uppercase text-[10px] tracking-widest">Cancel</button>
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-black shadow-lg hover:bg-blue-700 uppercase text-[10px] tracking-widest ring-4 ring-blue-50">Apply Changes</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let currentVariants = [];

    // Alignment and Sync Logic
    function updateVariantTable() {
        const tbody = document.getElementById('variantsTbody');
        if (currentVariants.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="p-16 text-center text-gray-300 italic font-bold">Search product or click Add SKU.</td></tr>';
            return;
        }
        tbody.innerHTML = currentVariants.map((v, i) => `
            <tr class="hover:bg-blue-50/50 transition border-b border-gray-50">
                <td class="p-3"><input type="text" value="${v.sku}" onchange="syncVariantData(${i}, 'sku', this.value)" class="w-full px-3 py-2.5 border border-gray-100 rounded-xl text-[11px] font-black text-blue-600 uppercase focus:ring-4 focus:ring-blue-50 outline-none"></td>
                <td class="p-3"><input type="text" value="${v.batch_no}" onchange="syncVariantData(${i}, 'batch_no', this.value)" placeholder="---" class="w-full px-3 py-2.5 border border-gray-100 rounded-xl text-[11px] font-bold text-gray-600 outline-none"></td>
                <td class="p-3"><input type="date" value="${v.expiry_date}" onchange="syncVariantData(${i}, 'expiry_date', this.value)" class="w-full px-3 py-2.5 border border-gray-100 rounded-xl text-[11px] font-bold text-red-500 outline-none"></td>
                <td class="p-3 w-28 text-center"><input type="number" value="${v.stock_level}" onchange="syncVariantData(${i}, 'stock_level', this.value)" class="w-full px-3 py-2.5 border border-gray-100 rounded-xl text-[11px] text-center font-black text-emerald-600 outline-none"></td>
                <td class="p-3 w-32 text-right"><input type="number" value="${v.sale_price}" onchange="syncVariantData(${i}, 'sale_price', this.value)" class="w-full px-3 py-2.5 border border-gray-100 rounded-xl text-[11px] text-right font-black text-gray-900 outline-none italic"></td>
                <td class="p-3 text-center w-12"><button onclick="currentVariants.splice(${i},1);updateVariantTable()" class="text-red-300 hover:text-red-500 p-2"><i class="fa-solid fa-circle-minus text-xl"></i></button></td>
            </tr>
        `).join('');
    }

    function syncVariantData(index, field, value) { currentVariants[index][field] = value; }
    function addNewEmptyVariant() { currentVariants.push({ sku: '', batch_no: '', expiry_date: '', stock_level: 1, sale_price: 0, purchase_price: 0 }); updateVariantTable(); }

    function handleProductSelect(val) {
        const list = document.getElementById('existing_medicines');
        const option = Array.from(list.options).find(opt => opt.value === val);
        if (option) {
            document.getElementById('p_generic').value = option.dataset.generic || '';
            document.getElementById('p_man').value = option.dataset.manufacturer || '';
            currentVariants = JSON.parse(option.dataset.variants || '[]').map(v => ({ 
                sku: v.sku, 
                batch_no: v.batch_no || '', 
                expiry_date: v.expiry_date || '', // Fixed Expiry Loading
                stock_level: v.stock_level || 0, 
                sale_price: v.sale_price || 0, 
                purchase_price: v.purchase_price || 0, 
                id: v.id 
            }));
            updateVariantTable();
        }
    }

    window.openEditModal = (variant, medicine) => {
        document.getElementById('edit_variant_id').value = variant.id;
        document.getElementById('edit_name').value = medicine.name;
        document.getElementById('edit_sku').value = variant.sku;
        document.getElementById('edit_batch').value = variant.batch_no || '';
        document.getElementById('edit_expiry').value = variant.expiry_date ? variant.expiry_date.split(' ')[0] : ''; // Date format fix
        document.getElementById('edit_mrp').value = variant.sale_price;
        document.getElementById('edit_stock').value = variant.stock_level;
        document.getElementById('hidden_tp').value = variant.purchase_price;
        animateOpen(document.getElementById('editModal'), document.getElementById('editModalBox'));
    };

    document.getElementById('editForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const payload = {
            _token: "{{ csrf_token() }}",
            name: document.getElementById('edit_name').value,
            sku: document.getElementById('edit_sku').value,
            batch_no: document.getElementById('edit_batch').value,
            expiry_date: document.getElementById('edit_expiry').value, // Included in Update
            sale_price: document.getElementById('edit_mrp').value,
            stock_level: document.getElementById('edit_stock').value,
            purchase_price: document.getElementById('hidden_tp').value || 0
        };
        const res = await fetch(`/medicines/${document.getElementById('edit_variant_id').value}`, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' }, body: JSON.stringify(payload) });
        if((await res.json()).success) window.location.reload();
    });

    window.deleteProduct = async (id) => {
        if(confirm('Delete SKU permanently?')) {
            const res = await fetch(`/medicines/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Accept': 'application/json' } });
            if((await res.json()).success) window.location.reload();
        }
    };

    function animateOpen(m, b) { m.classList.remove('hidden'); m.classList.add('flex'); setTimeout(() => { b.classList.remove('scale-95', 'opacity-0'); b.classList.add('scale-100', 'opacity-100'); }, 10); }
    function closeEditModal() { const b = document.getElementById('editModalBox'); b.classList.add('scale-95', 'opacity-0'); setTimeout(() => { document.getElementById('editModal').classList.add('hidden'); }, 200); }
    function closeProductModal() { const b = document.getElementById('productModalBox'); b.classList.add('scale-95', 'opacity-0'); setTimeout(() => { document.getElementById('productModal').classList.add('hidden'); }, 200); }
    function openProductModal() { currentVariants = []; updateVariantTable(); ['p_name', 'p_generic', 'p_man'].forEach(i => document.getElementById(i).value = ''); animateOpen(document.getElementById('productModal'), document.getElementById('productModalBox')); }

    document.getElementById('saveProductBtn').addEventListener('click', async () => {
        const payload = { _token: "{{ csrf_token() }}", name: document.getElementById('p_name').value, generic_name: document.getElementById('p_generic').value, manufacturer: document.getElementById('p_man').value, variants: currentVariants };
        const res = await fetch("{{ route('medicines.store') }}", { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
        if((await res.json()).success) window.location.reload();
    });
</script>
@endpush
@endsection