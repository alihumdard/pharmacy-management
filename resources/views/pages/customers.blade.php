@extends('layouts.main')
@section('title', 'Customer Ledger & Accounts')

@section('content')
<main class="h-screen overflow-y-auto p-2 sm:p-4 md:p-8 pt-24 bg-gray-50 flex flex-col">
    <div class="max-w-[1600px] mx-auto w-full">
        
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-gray-900 tracking-tighter italic uppercase pb-1 inline-block leading-none">
                    Customer Accounts
                </h1>
                <p class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mt-2">Accounts & Receivable Ledger</p>
            </div>
            
            <button onclick="openModalForAdd()"
                class="w-full md:w-auto px-6 py-4 bg-blue-600 text-white rounded-2xl shadow-lg hover:bg-blue-700 font-black uppercase text-xs tracking-widest transition active:scale-95 flex items-center justify-center gap-2 ring-4 ring-blue-50">
                <i class="fa-solid fa-user-plus"></i> Add New Customer
            </button>
        </div>

        <div class="bg-white rounded-[30px] shadow-xl border border-gray-100 p-4 sm:p-8">
            {{-- Filters & Search --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
                <div class="relative w-full lg:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search name or phone..."
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl outline-none text-sm font-bold focus:ring-4 focus:ring-blue-50 transition shadow-inner"
                        oninput="debounceFetchData()">
                </div>

                <div class="w-full lg:w-auto">
                    <select id="creditFilter" onchange="fetchData()"
                        class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-[10px] font-black uppercase tracking-widest outline-none focus:ring-4 focus:ring-blue-50">
                        <option value="">Credit Filter (All)</option>
                        <option value="due">Credit Due > 0</option>
                        <option value="paid">Credit Due = 0</option>
                    </select>
                </div>
            </div>

            {{-- DESKTOP VIEW --}}
            <div class="hidden lg:block overflow-hidden rounded-2xl border border-gray-100 shadow-sm">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr class="bg-blue-600 text-white border-b border-gray-100 uppercase font-black text-[10px] tracking-widest">
                            <th class="py-5 px-6 text-left">Customer Nomenclature</th>
                            <th class="py-5 px-6 text-left">Phone Metadata</th>
                            <th class="py-5 px-6 text-right">Total Purchases</th>
                            <th class="py-5 px-6 text-right">Credit Balance</th>
                            <th class="py-5 px-6 text-center">Protocol Actions</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody" class="divide-y divide-gray-50 text-gray-800">
                        {{-- AJAX Data --}}
                    </tbody>
                </table>
            </div>

            {{-- MOBILE VIEW --}}
            <div id="customersCardContainer" class="lg:hidden grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- AJAX Data --}}
            </div>
            
            <div id="customersPagination" class="mt-8 flex justify-center gap-2"></div>
        </div>
    </div>
</main>

{{-- MODAL: Add / Edit Customer --}}
<div id="customerModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all">
    <div id="customerModalBox" class="bg-white w-full max-w-2xl rounded-[40px] shadow-2xl overflow-hidden flex flex-col opacity-0 scale-95 transition-all duration-300">
        <div class="bg-blue-600 px-8 py-6 flex justify-between items-center text-white shrink-0">
            <div>
                <h3 class="text-2xl font-black uppercase italic tracking-tighter leading-none" id="modalTitle">Customer Profile</h3>
                <p class="text-[10px] font-bold uppercase tracking-widest mt-1 text-blue-200">Registration Terminal</p>
            </div>
            <button onclick="closeCustomerModal()" class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center hover:bg-white/20 transition text-2xl font-light">&times;</button>
        </div>

        <form id="customerForm" onsubmit="handleFormSubmit(event)" class="p-8 overflow-y-auto">
            @csrf
            <div id="formAlerts" class="mb-6"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Customer Name *</label>
                    <input type="text" name="customer_name" id="f_name" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-50">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Phone Number *</label>
                    <input type="text" name="phone_number" id="f_phone" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-50">
                </div>
                <div class="md:col-span-2 p-6 bg-blue-50 rounded-3xl border border-blue-100">
                    <label class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2 block uppercase">Opening Balance (PKR)</label>
                    <input type="number" step="0.01" name="credit_balance" id="f_balance" value="0.00" class="w-full px-5 py-4 border-2 border-blue-200 rounded-2xl bg-white font-black text-2xl text-blue-700 italic outline-none focus:ring-8 focus:ring-blue-50">
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 border-t pt-6">
                <button type="button" onclick="closeCustomerModal()" class="px-8 py-3 bg-white border border-gray-200 rounded-2xl text-gray-500 font-black uppercase text-[10px] tracking-widest">Discard</button>
                <button type="submit" id="saveCustomerBtn" class="px-10 py-3 bg-emerald-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-emerald-700 transition active:scale-95 ring-8 ring-emerald-50">Save Profile</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: Ledger --}}
<div id="historyModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/80 backdrop-blur-md transition-all">
    <div id="historyModalBox" class="bg-white w-full max-w-6xl rounded-[40px] shadow-2xl overflow-hidden flex flex-col max-h-[90vh] opacity-0 scale-95 transition-all duration-300">
        <div class="bg-gray-900 px-8 py-6 flex justify-between items-center text-white shrink-0">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-file-invoice text-xl"></i>
                </div>
                <div>
                    <h2 id="historyCustomerName" class="text-2xl font-black italic tracking-tighter leading-none uppercase">Statement</h2>
                    <div class="flex items-center gap-3 mt-1">
                        <span id="historyCustomerPhone" class="text-[10px] font-bold text-blue-400 uppercase tracking-widest"></span>
                        <button onclick="sendWhatsAppReminder()" class="bg-emerald-500/20 text-emerald-400 px-3 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest hover:bg-emerald-500 transition">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </button>
                    </div>
                </div>
            </div>
            <button onclick="closeHistoryModal()" class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center hover:bg-white/20 transition text-3xl font-light">&times;</button>
        </div>

        <div class="flex flex-col lg:flex-row flex-grow overflow-hidden">
            <div class="lg:w-2/3 flex-grow overflow-y-auto p-6 sm:p-8 border-r border-gray-100 custom-scrollbar">
                <h3 class="text-[10px] font-black uppercase text-gray-400 mb-6 tracking-widest italic border-l-4 border-blue-600 pl-3">Transaction Manifest</h3>
                <div class="overflow-x-auto rounded-3xl border border-gray-100 shadow-inner">
                    <div id="historyContent" class="min-w-[600px]"></div>
                </div>
            </div>

            <div class="lg:w-1/3 bg-gray-50 p-6 sm:p-8 flex flex-col shrink-0 overflow-y-auto">
                <div class="bg-white p-6 rounded-[30px] shadow-sm border border-blue-100 mb-8 text-center ring-8 ring-blue-50/50">
                    <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-1">Outstanding Balance</p>
                    <h4 id="ledgerTotalCredit" class="text-3xl font-black text-blue-700 tracking-tighter italic">PKR 0.00</h4>
                </div>

                <div class="bg-white p-6 rounded-[30px] border border-gray-200 shadow-inner">
                    <h3 class="text-xs font-black text-gray-800 mb-6 uppercase tracking-widest italic border-b pb-3">Update Ledger</h3>
                    <div class="space-y-4">
                        <select id="manualType" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none">
                            <option value="debit">Payment Received (-)</option>
                            <option value="credit">Manual Debt (+)</option>
                        </select>
                        <input type="number" id="manualAmount" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-black text-lg outline-none" placeholder="Amount (PKR)">
                        <button onclick="submitManualTransaction()" id="manualSubmitBtn" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl hover:bg-blue-700 active:scale-95 transition ring-4 ring-blue-50">Sync Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeCustomerId = null;
    let activeCustomerName = "";
    let activeCustomerPhone = "";
    let currentBalance = 0;
    let currentPage = 1;
    let debounceTimer;

    // --- Modal Logic ---
    function openAnimate(m, b) {
        m.classList.remove("hidden");
        m.classList.add("flex");
        setTimeout(() => { b.classList.remove("opacity-0", "scale-95"); b.classList.add("scale-100", "opacity-100"); }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeAnimate(m, b) {
        b.classList.remove("scale-100", "opacity-100");
        b.classList.add("opacity-0", "scale-95");
        setTimeout(() => { m.classList.add("hidden"); m.classList.remove("flex"); document.body.style.overflow = ''; }, 300);
    }

    window.openCustomerModal = () => openAnimate(document.getElementById("customerModal"), document.getElementById("customerModalBox"));
    window.closeCustomerModal = () => closeAnimate(document.getElementById("customerModal"), document.getElementById("customerModalBox"));
    window.openHistoryModal = () => openAnimate(document.getElementById("historyModal"), document.getElementById("historyModalBox"));
    window.closeHistoryModal = () => closeAnimate(document.getElementById("historyModal"), document.getElementById("historyModalBox"));

    window.openModalForAdd = () => {
        activeCustomerId = null;
        document.getElementById("customerForm").reset();
        document.getElementById("formAlerts").innerHTML = '';
        document.getElementById("modalTitle").innerText = 'Add Customer Profile';
        openCustomerModal();
    }

    window.debounceFetchData = () => { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => fetchData(1), 300); }

    window.fetchData = (page = 1) => {
        currentPage = page;
        const search = document.getElementById("searchInput").value;
        const filter = document.getElementById("creditFilter").value;
        const tBody = document.getElementById("customersTableBody");
        const cContainer = document.getElementById("customersCardContainer");

        tBody.innerHTML = '<tr><td colspan="5" class="py-20 text-center"><i class="fa-solid fa-circle-notch fa-spin text-3xl text-blue-500"></i></td></tr>';
        cContainer.innerHTML = '<div class="col-span-full py-10 text-center"><i class="fa-solid fa-circle-notch fa-spin text-3xl text-blue-500"></i></div>';

        fetch(`{{ route('customers.fetch') }}?page=${page}&search=${search}&credit_filter=${filter}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(data => {
                let tHtml = '';
                let cHtml = '';
                const customers = data.data || [];

                if (customers.length > 0) {
                    customers.forEach(c => {
                        const bal = parseFloat(c.credit_balance || 0);
                        const balColor = bal > 0 ? 'text-red-600' : 'text-emerald-600';
                        const balBg = bal > 0 ? 'bg-red-50' : 'bg-emerald-50';
                        const safeName = c.customer_name ? c.customer_name.replace(/'/g, "\\'") : "User";

                        tHtml += `<tr>
                            <td class="py-5 px-6 font-black text-gray-900 uppercase italic tracking-tighter text-sm">${c.customer_name}</td>
                            <td class="py-5 px-6 font-bold text-gray-500 italic text-xs">${c.phone_number || '---'}</td>
                            <td class="py-5 px-6 text-right font-bold text-gray-600">PKR ${Number(c.total_purchases || 0).toLocaleString()}</td>
                            <td class="py-5 px-6 text-right font-black italic tracking-tighter ${balColor}">PKR ${bal.toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                            <td class="py-5 px-6 text-center">
                                <div class="flex justify-center gap-2">
                                    <button onclick="viewCustomerHistory(${c.id})" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm hover:bg-blue-600 hover:text-white transition"><i class="fa-solid fa-file-invoice"></i></button>
                                    <button onclick="editCustomer(${c.id})" class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center shadow-sm hover:bg-gray-800 hover:text-white transition"><i class="fa-solid fa-pen"></i></button>
                                    <button onclick="deleteCustomer(${c.id}, '${safeName}')" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center shadow-sm hover:bg-red-600 hover:text-white transition"><i class="fa-solid fa-trash-can"></i></button>
                                </div>
                            </td>
                        </tr>`;

                        cHtml += `<div class="bg-white p-5 rounded-[30px] border border-gray-100 shadow-sm flex flex-col gap-3">
                            <div class="flex justify-between items-start">
                                <div><h3 class="font-black text-gray-900 uppercase italic tracking-tighter leading-tight">${c.customer_name}</h3><p class="text-[9px] font-bold text-gray-400 mt-1 italic">${c.phone_number || '---'}</p></div>
                                <div class="px-3 py-1 rounded-full ${balBg} border ${balColor} text-[10px] font-black italic shadow-sm">PKR ${bal.toLocaleString()}</div>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-50 mt-1">
                                <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest italic uppercase leading-none">Total Transactions</span>
                                <span class="text-xs font-black text-gray-700 italic">PKR ${Number(c.total_purchases || 0).toLocaleString()}</span>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest italic uppercase">Action Center</span>
                                <div class="flex gap-2">
                                    <button onclick="viewCustomerHistory(${c.id})" class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg"><i class="fa-solid fa-file-invoice text-xs"></i></button>
                                    <button onclick="editCustomer(${c.id})" class="w-12 h-12 rounded-2xl bg-white border border-gray-200 text-gray-600 flex items-center justify-center"><i class="fa-solid fa-pen text-xs"></i></button>
                                    <button onclick="deleteCustomer(${c.id}, '${safeName}')" class="w-12 h-12 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center border border-red-100"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                </div>
                            </div>
                        </div>`;
                    });
                } else {
                    const empty = '<div class="py-20 text-center text-gray-300 italic font-black uppercase tracking-widest uppercase">Vault is empty</div>';
                    tHtml = '<tr><td colspan="5">' + empty + '</td></tr>';
                    cHtml = empty;
                }
                tBody.innerHTML = tHtml;
                cContainer.innerHTML = cHtml;
                
                const links = data.links || (data.meta ? data.meta.links : null);
                document.getElementById("customersPagination").innerHTML = generatePagination(links);
            });
    }

    window.generatePagination = (links) => {
        if (!links || !Array.isArray(links) || links.length <= 3) return '';
        let h = '<div class="flex gap-2 flex-wrap justify-center">';
        links.forEach(l => {
            let label = l.label.replace('&laquo; Previous', '←').replace('Next &raquo;', '→');
            const activeClass = l.active ? 'bg-blue-600 text-white ring-4 ring-blue-100 shadow-lg' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50';
            if(l.url) {
                const page = new URL(l.url).searchParams.get('page');
                h += `<button onclick="fetchData(${page})" class="w-10 h-10 rounded-xl font-black text-xs transition ${activeClass}">${label}</button>`;
            } else {
                h += `<span class="w-10 h-10 rounded-xl flex items-center justify-center border border-gray-100 text-gray-300 text-xs font-bold">${label}</span>`;
            }
        });
        return h + '</div>';
    }

    window.editCustomer = (id) => {
        activeCustomerId = id;
        fetch(`/customers/${id}/edit`)
            .then(res => res.json())
            .then(c => {
                document.getElementById("modalTitle").innerText = 'Update Profile';
                document.getElementById("f_name").value = c.customer_name;
                document.getElementById("f_phone").value = c.phone_number;
                document.getElementById("f_balance").value = c.credit_balance;
                openCustomerModal();
            });
    }

    window.deleteCustomer = (id, name) => {
        if (confirm(`Permanently remove ${name}?`)) {
            fetch(`/customers/${id}`, { 
                method: 'POST', 
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }, 
                body: JSON.stringify({ _method: 'DELETE' }) 
            }).then(() => fetchData(currentPage));
        }
    }

    window.viewCustomerHistory = (id) => {
        activeCustomerId = id;
        const hContent = document.getElementById('historyContent');
        hContent.innerHTML = '<div class="text-center py-20"><i class="fa-solid fa-circle-notch fa-spin text-4xl text-blue-500"></i></div>';
        openHistoryModal();

        fetch(`/customers/${id}/history`)
            .then(res => res.json())
            .then(data => {
                activeCustomerName = data.customer.customer_name;
                activeCustomerPhone = data.customer.phone_number;
                currentBalance = parseFloat(data.customer.credit_balance);
                document.getElementById('historyCustomerName').innerText = activeCustomerName;
                document.getElementById('historyCustomerPhone').innerText = `METADATA: ${activeCustomerPhone}`;
                document.getElementById('ledgerTotalCredit').innerText = `PKR ${currentBalance.toLocaleString(undefined, {minimumFractionDigits: 2})}`;

                if (!data.history || data.history.length === 0) {
                    hContent.innerHTML = '<div class="text-center py-20 text-gray-300 italic font-black uppercase tracking-widest text-[10px]">No ledger data found</div>';
                    return;
                }

                let html = `<table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b bg-gray-50 text-gray-400 text-[10px] uppercase font-black tracking-widest"><th class="p-4">Timestamp</th><th class="p-4">Reference</th><th class="p-4 text-center">Protocol</th><th class="p-4 text-right">Valuation</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">`;

                data.history.forEach(entry => {
                    const isManual = entry.category === 'Manual';
                    const isDebit = entry.type === 'debit';
                    let label = isManual ? (isDebit ? 'Payment Recv' : 'Debt Added') : (entry.type === 'credit' ? 'Credit Sale' : 'Cash Sale');
                    let color = isDebit ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-red-600 bg-red-50 border-red-100';
                    const dateString = new Date(entry.date).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'});

                    html += `<tr class="hover:bg-blue-50/30 transition">
                        <td class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-tighter whitespace-nowrap">${dateString}</td>
                        <td class="p-4 font-black text-gray-700 italic uppercase text-xs tracking-tight">${entry.reference}</td>
                        <td class="p-4 text-center"><span class="px-3 py-1 rounded-full text-[8px] font-black uppercase border ${color}">${label}</span></td>
                        <td class="p-4 text-right font-black text-gray-900 italic tracking-tighter leading-none">PKR ${parseFloat(entry.amount).toLocaleString()}</td>
                    </tr>`;
                });
                hContent.innerHTML = html + '</tbody></table>';
            });
    }

    window.submitManualTransaction = async () => {
        const amountInput = document.getElementById('manualAmount');
        const amount = amountInput.value;
        if (!amount || amount <= 0) return alert("Enter valid amount");
        const btn = document.getElementById('manualSubmitBtn');
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';
        try {
            const res = await fetch(`/customers/${activeCustomerId}/payment`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ type: document.getElementById('manualType').value, amount })
            });
            if (res.ok) { amountInput.value = ''; viewCustomerHistory(activeCustomerId); fetchData(currentPage); }
        } finally { btn.disabled = false; btn.innerHTML = 'Sync Account'; }
    }

    window.handleFormSubmit = async (event) => {
        event.preventDefault();
        const btn = document.getElementById("saveCustomerBtn");
        btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';
        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        const url = activeCustomerId ? `/customers/${activeCustomerId}` : '{{ route("customers.store") }}';
        if (activeCustomerId) data._method = 'PUT';
        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            if (res.ok) { closeCustomerModal(); fetchData(currentPage); }
            else { const result = await res.json(); document.getElementById("formAlerts").innerHTML = `<div class="p-4 bg-red-50 text-red-600 rounded-2xl border border-red-100 text-[10px] font-black uppercase">${result.message}</div>`; }
        } finally { btn.disabled = false; btn.innerHTML = 'Confirm'; }
    }

    window.sendWhatsAppReminder = () => {
        if (currentBalance <= 0) return alert("Account is clear!");
        const msg = `Dear ${activeCustomerName}, your pending balance is PKR ${currentBalance.toLocaleString()}. Please clear it at your earliest convenience. Thank you!`;
        window.open(`https://wa.me/${activeCustomerPhone}?text=${encodeURIComponent(msg)}`, '_blank');
    }

    document.addEventListener('DOMContentLoaded', () => fetchData(1));
</script>
@endpush