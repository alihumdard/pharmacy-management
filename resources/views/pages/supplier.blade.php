@extends('layouts.main')
@section('title', 'Supplier Management')

@section('content')
    <main class="overflow-y-auto p-2 sm:p-4 md:p-8 min-h-[calc(100vh-70px)] bg-gray-50 mt-14 sm:mt-0">
        <div class="max-w-[1600px] mx-auto w-full">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-gray-900 tracking-tighter uppercase pb-2 inline-block leading-none">
                        Supplier Accounts
                    </h1>
                    <p class="text-[10px] text-blue-500 font-bold uppercase tracking-widest mt-2">Directory & Ledger Management</p>
                </div>
                
                <button onclick="openModalForAdd()"
                    class="w-full md:w-auto px-6 py-3 bg-blue-600 text-white rounded-2xl shadow-lg hover:bg-blue-700 font-black uppercase text-xs tracking-widest transition active:scale-95 flex items-center justify-center gap-2 ring-4 ring-blue-50">
                    <i class="fa-solid fa-plus"></i> Add New Supplier
                </button>
            </div>

            <div class="bg-white rounded-[30px] shadow-xl border border-gray-100 p-4 sm:p-8">
                {{-- Filters & Search --}}
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
                    <div class="relative w-full lg:w-1/3">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchInput" placeholder="Search by name..."
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl outline-none text-sm font-bold focus:ring-4 focus:ring-blue-50 transition shadow-inner"
                            oninput="debounceFetchData()">
                    </div>

                    <div class="w-full lg:w-auto">
                        <select id="balanceFilter" onchange="fetchData()"
                            class="w-full px-5 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-[10px] font-black uppercase tracking-widest outline-none focus:ring-4 focus:ring-blue-50">
                            <option value="">Balance Filter (All)</option>
                            <option value="due">Balance Due > 0</option>
                            <option value="paid">Balance Due = 0</option>
                        </select>
                    </div>
                </div>

                {{-- DESKTOP VIEW: Table (Hidden on Mobile) --}}
                <div class="hidden md:block overflow-hidden rounded-2xl border border-gray-100 shadow-sm">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="bg-blue-600 text-white border-b border-gray-100 uppercase font-black text-[10px] tracking-widest">
                                <th class="py-5 px-6 text-left">Supplier Nomenclature</th>
                                <th class="py-5 px-6 text-left">Liaison Person</th>
                                <th class="py-5 px-6 text-left">Contact Metadata</th>
                                <th class="py-5 px-6 text-right">Balance Valuation</th>
                                <th class="py-5 px-6 text-center">Protocol Actions</th>
                            </tr>
                        </thead>
                        <tbody id="suppliersTableBody" class="divide-y divide-gray-50 text-gray-800">
                            {{-- Content loaded via JS --}}
                        </tbody>
                    </table>
                </div>

                {{-- MOBILE VIEW: Card Layout (Visible only on Mobile) --}}
                <div id="suppliersCardContainer" class="md:hidden grid grid-cols-1 gap-4">
                    {{-- Cards content via JS --}}
                </div>
                
                <div id="suppliersPagination" class="mt-8 flex justify-center gap-2">
                    {{-- Pagination Content --}}
                </div>
            </div>
        </div>
    </main>

    {{-- MODAL: Supplier Ledger --}}
    <div id="historyModal" class="fixed inset-0 bg-black/60 hidden justify-center items-center z-[60] p-2 sm:p-4 backdrop-blur-md transition-all duration-300">
        <div id="historyModalBox" class="bg-white w-full max-w-6xl max-h-[90vh] rounded-[40px] shadow-2xl flex flex-col overflow-hidden border border-gray-100 transform scale-95 opacity-0 transition-all duration-300">
            <div class="p-6 border-b flex justify-between items-center bg-gray-900 shrink-0 text-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                    </div>
                    <div>
                        <h2 id="historySupplierName" class="text-lg sm:text-2xl font-black tracking-tighter leading-none italic uppercase">Statement</h2>
                        <span id="historySupplierPhone" class="text-[10px] font-bold text-blue-400 uppercase tracking-widest"></span>
                    </div>
                </div>
                <button onclick="closeHistoryModal()" class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center hover:bg-white/20 transition text-3xl font-light">&times;</button>
            </div>

            <div class="flex flex-col lg:flex-row flex-grow overflow-hidden">
                {{-- Left: Transaction History (Scrollable Table) --}}
                <div class="lg:w-2/3 flex-grow overflow-y-auto p-6 border-r border-gray-100 custom-scrollbar">
                    <h3 class="text-[10px] font-black uppercase text-gray-400 mb-6 tracking-widest italic border-l-4 border-blue-600 pl-3">Transaction Manifest</h3>
                    <div class="overflow-x-auto rounded-3xl border border-gray-100 shadow-inner">
                        <div id="historyContent" class="min-w-[600px]"></div>
                    </div>
                </div>

                {{-- Right: Record Payment --}}
                <div class="lg:w-1/3 bg-gray-50 p-6 flex flex-col shrink-0 overflow-y-auto">
                    <div class="bg-white p-6 rounded-[30px] shadow-sm border border-blue-100 mb-8 text-center ring-8 ring-blue-50/50">
                        <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-1">Total Payable Balance</p>
                        <h4 id="ledgerTotalDue" class="text-3xl font-black text-blue-700 tracking-tighter italic leading-none">PKR 0.00</h4>
                    </div>

                    <div class="bg-white p-6 rounded-[30px] border border-gray-200 shadow-inner">
                        <h3 class="text-xs font-black text-gray-800 mb-6 uppercase tracking-widest italic border-b pb-3 leading-none">Update Ledger</h3>
                        <div class="space-y-4">
                            <select id="manualType" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-bold text-sm outline-none">
                                <option value="debit">Payment Sent (Reduce Balance)</option>
                                <option value="credit">Purchase/Credit (Increase Balance)</option>
                            </select>
                            <input type="number" id="manualAmount" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-black text-lg outline-none" placeholder="0.00">
                            <button onclick="submitManualTransaction()" id="manualSubmitBtn"
                                class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl hover:bg-emerald-700 transition active:scale-95 ring-4 ring-emerald-50 mt-4">
                                Sync Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Add/Edit Supplier --}}
    <div id="supplierModal" class="fixed inset-0 bg-black/60 hidden justify-center items-center z-[60] p-2 sm:p-4 backdrop-blur-md transition-all">
        <div id="supplierModalBox" class="bg-white w-full max-w-2xl max-h-[95vh] overflow-y-auto rounded-[40px] shadow-2xl p-8 transform scale-95 opacity-0 transition-all duration-300 flex flex-col">
            <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-5">
                <div>
                    <h2 class="text-xl sm:text-3xl font-black text-gray-900 tracking-tighter italic uppercase leading-none">Supplier Profile</h2>
                    <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1">Directory Metadata</p>
                </div>
                <button onclick="closeModal()" class="w-10 h-10 rounded-2xl bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition text-3xl font-light">&times;</button>
            </div>

            <form id="supplierForm" onsubmit="handleFormSubmit(event)" class="space-y-6">
                @csrf
                <div id="formAlerts"></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Supplier Name *</label>
                        <input type="text" name="supplier_name" required class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-gray-50 text-sm font-bold outline-none focus:ring-4 focus:ring-blue-50 transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Contact Person</label>
                        <input type="text" name="contact_person" class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-gray-50 text-sm font-bold outline-none focus:ring-4 focus:ring-blue-50 transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Phone Number</label>
                        <input type="text" name="phone_number" class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-gray-50 text-sm font-bold outline-none focus:ring-4 focus:ring-blue-50 transition">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" name="email" class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-gray-50 text-sm font-bold outline-none focus:ring-4 focus:ring-blue-50 transition">
                    </div>
                    <div class="sm:col-span-2 p-6 bg-blue-50 rounded-[30px] border border-blue-100">
                        <label class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2 block uppercase">Opening Balance (PKR)</label>
                        <input type="number" step="0.01" name="balance_due" value="0.00" class="w-full px-5 py-4 border-2 border-blue-200 rounded-2xl bg-white font-black text-2xl text-blue-700 italic outline-none focus:ring-8 focus:ring-blue-50 shadow-sm">
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row justify-end gap-3 mt-10 shrink-0">
                    <button type="button" onclick="closeModal()" class="px-8 py-4 bg-white border border-gray-200 rounded-2xl text-gray-500 font-black uppercase text-[10px] tracking-widest">Discard</button>
                    <button type="submit" id="saveSupplierBtn" class="px-10 py-4 bg-emerald-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl hover:bg-emerald-700 transition active:scale-95 ring-8 ring-emerald-50">Confirm</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let activeSupplierId = null;
    let currentPage = 1;
    let debounceTimer;

    const modal = document.getElementById("supplierModal");
    const modalBox = document.getElementById("supplierModalBox");
    const form = document.getElementById("supplierForm");
    const saveButton = document.getElementById("saveSupplierBtn");
    const tableBody = document.getElementById("suppliersTableBody");
    const cardContainer = document.getElementById("suppliersCardContainer");

    // Modal Animations
    function openModal() {
        modal.classList.replace("hidden", "flex");
        setTimeout(() => { modalBox.classList.replace("opacity-0", "opacity-100"); modalBox.classList.replace("scale-95", "scale-100"); }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modalBox.classList.replace("opacity-100", "opacity-0");
        modalBox.classList.replace("scale-100", "scale-95");
        setTimeout(() => { modal.classList.replace("flex", "hidden"); document.body.style.overflow = ''; }, 300);
    }

    function openModalForAdd() {
        form.reset(); activeSupplierId = null;
        document.getElementById("formAlerts").innerHTML = '';
        document.querySelector('#supplierModal h2').innerText = 'Add Supplier';
        if (form.querySelector('input[name="_method"]')) form.querySelector('input[name="_method"]').remove();
        openModal();
    }

    function closeHistoryModal() {
        const hModal = document.getElementById('historyModal');
        const hBox = document.getElementById('historyModalBox');
        hBox.classList.replace("opacity-100", "opacity-0");
        hBox.classList.replace("scale-100", "scale-95");
        setTimeout(() => { hModal.classList.replace("flex", "hidden"); }, 300);
    }

    function debounceFetchData() { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => fetchData(1), 300); }

    function fetchData(page = 1) {
        currentPage = page;
        const search = document.getElementById("searchInput").value;
        const balance = document.getElementById("balanceFilter").value;
        
        const loader = '<tr><td colspan="5" class="py-20 text-center"><i class="fa-solid fa-circle-notch fa-spin text-3xl text-blue-500"></i></td></tr>';
        const cardLoader = '<div class="col-span-full py-10 text-center"><i class="fa-solid fa-circle-notch fa-spin text-3xl text-blue-500"></i></div>';
        
        tableBody.innerHTML = loader;
        cardContainer.innerHTML = cardLoader;

        fetch(`{{ route('suppliers.fetch') }}?page=${page}&search=${search}&balance_filter=${balance}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(data => {
                let tableHtml = '';
                let cardHtml = '';

                if (data.data.length > 0) {
                    data.data.forEach(s => {
                        const bal = parseFloat(s.balance_due);
                        const balColor = bal > 0 ? 'text-red-600' : 'text-emerald-600';
                        const balBg = bal > 0 ? 'bg-red-50 border-red-100' : 'bg-emerald-50 border-emerald-100';

                        // DESKTOP
                        tableHtml += `
                            <tr class="hover:bg-blue-50/40 transition group">
                                <td class="py-5 px-6 font-black text-gray-900 uppercase tracking-tighter italic text-sm">${s.supplier_name}</td>
                                <td class="py-5 px-6 font-bold text-gray-600 uppercase text-xs">${s.contact_person || '---'}</td>
                                <td class="py-5 px-6">
                                    <div class="text-xs font-black text-gray-800 italic">${s.phone_number || '---'}</div>
                                    <div class="text-[10px] text-gray-400 font-bold lowercase mt-1">${s.email || ''}</div>
                                </td>
                                <td class="py-5 px-6 text-right font-black italic tracking-tighter ${balColor}">
                                    <span class="text-[10px] font-bold text-gray-400 not-italic uppercase mr-1">PKR</span>${bal.toLocaleString(undefined, { minimumFractionDigits: 2 })}
                                </td>
                                <td class="py-5 px-6 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button onclick="viewSupplierHistory(${s.id})" class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition"><i class="fa-solid fa-file-invoice-dollar text-xs"></i></button>
                                        <button onclick="editSupplier(${s.id})" class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-gray-800 hover:text-white transition"><i class="fa-solid fa-pen-to-square text-xs"></i></button>
                                        <button onclick="deleteSupplier(${s.id}, '${s.supplier_name}')" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-600 hover:text-white transition"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                    </div>
                                </td>
                            </tr>`;

                        // MOBILE
                        cardHtml += `
                            <div class="bg-white p-5 rounded-[30px] border border-gray-100 shadow-sm flex flex-col gap-3">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-black text-gray-900 uppercase italic tracking-tighter leading-tight">${s.supplier_name}</h3>
                                        <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1">Liaison: ${s.contact_person || '---'}</p>
                                    </div>
                                    <div class="px-3 py-1 rounded-full ${balBg} border ${balColor} text-[10px] font-black italic">PKR ${bal.toLocaleString()}</div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 py-3 border-y border-gray-50">
                                    <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest uppercase">Phone: <span class="text-gray-700 block text-xs font-black italic mt-1">${s.phone_number || '---'}</span></div>
                                    <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest uppercase text-right">Email: <span class="text-gray-700 block text-[11px] font-black mt-1 lowercase truncate">${s.email || '---'}</span></div>
                                </div>
                                <div class="flex justify-between items-center pt-1">
                                    <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest italic uppercase">Action Center</span>
                                    <div class="flex gap-2">
                                        <button onclick="viewSupplierHistory(${s.id})" class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-lg"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                                        <button onclick="editSupplier(${s.id})" class="w-12 h-12 rounded-2xl bg-white border border-gray-200 text-gray-600 flex items-center justify-center"><i class="fa-solid fa-pen"></i></button>
                                        <button onclick="deleteSupplier(${s.id}, '${s.supplier_name}')" class="w-12 h-12 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center border border-red-100"><i class="fa-solid fa-trash-can"></i></button>
                                    </div>
                                </div>
                            </div>`;
                    });
                } else {
                    const empty = '<div class="py-20 text-center text-gray-300 italic font-black uppercase tracking-widest">No Manifest Records</div>';
                    tableHtml = '<tr><td colspan="5">' + empty + '</td></tr>';
                    cardHtml = empty;
                }
                tableBody.innerHTML = tableHtml;
                cardContainer.innerHTML = cardHtml;
                document.getElementById("suppliersPagination").innerHTML = generatePagination(data);
                attachPaginationListeners();
            });
    }

    function generatePagination(data) {
        if (data.last_page <= 1) return '';
        let h = '';
        for (let i = 1; i <= data.last_page; i++) {
            const active = i === data.current_page ? 'bg-blue-600 text-white shadow-lg ring-4 ring-blue-100' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50';
            h += `<button data-page="${i}" class="pagination-btn w-10 h-10 rounded-xl font-black text-xs transition ${active}">${i}</button>`;
        }
        return h;
    }

    function attachPaginationListeners() {
        document.querySelectorAll('.pagination-btn').forEach(btn => {
            btn.onclick = () => fetchData(btn.dataset.page);
        });
    }

    function viewSupplierHistory(id) {
        activeSupplierId = id;
        const hModal = document.getElementById('historyModal');
        const hBox = document.getElementById('historyModalBox');
        const hContent = document.getElementById('historyContent');
        
        hModal.classList.replace("hidden", "flex");
        hContent.innerHTML = '<div class="text-center py-20"><i class="fa-solid fa-circle-notch fa-spin text-4xl text-blue-500"></i></div>';
        
        setTimeout(() => { hBox.classList.replace("opacity-0", "opacity-100"); hBox.classList.replace("scale-95", "scale-100"); }, 10);

        fetch(`/suppliers/${id}/history`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('historySupplierName').innerText = data.supplier.supplier_name;
                document.getElementById('historySupplierPhone').innerText = `CONTACT: ${data.supplier.phone_number || 'N/A'}`;
                document.getElementById('ledgerTotalDue').innerText = `PKR ${parseFloat(data.supplier.balance_due).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

                if (!data.history || data.history.length === 0) {
                    hContent.innerHTML = '<div class="text-center py-20 text-gray-300 italic font-black uppercase tracking-widest text-[10px]">Vault is Empty</div>';
                    return;
                }

                let html = `<table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b bg-gray-50 text-gray-400 text-[10px] uppercase font-black tracking-widest">
                            <th class="p-4 uppercase">Timestamp</th><th class="p-4 uppercase">Reference</th><th class="p-4 text-center uppercase">Protocol</th><th class="p-4 text-right uppercase">Valuation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">`;

                data.history.forEach(entry => {
                    const color = entry.type === 'debit' ? 'text-emerald-600 bg-emerald-50 border-emerald-100' : 'text-red-600 bg-red-50 border-red-100';
                    const nature = entry.type === 'debit' ? 'Payment Out' : 'Debt Incurred';
                    const date = new Date(entry.date).toLocaleDateString('en-GB', {day:'2-digit', month:'short', year:'numeric'});
                    
                    html += `<tr class="hover:bg-blue-50/30 transition">
                        <td class="p-4 text-[10px] font-black text-gray-400 uppercase tracking-tighter whitespace-nowrap">${date}</td>
                        <td class="p-4 font-black text-gray-700 italic uppercase text-xs tracking-tight">${entry.reference}</td>
                        <td class="p-4 text-center"><span class="px-3 py-1 rounded-full text-[8px] font-black uppercase border ${color}">${nature}</span></td>
                        <td class="p-4 text-right font-black text-gray-900 italic tracking-tighter whitespace-nowrap">PKR ${parseFloat(entry.amount).toLocaleString()}</td>
                    </tr>`;
                });
                hContent.innerHTML = html + '</tbody></table>';
            });
    }

    async function submitManualTransaction() {
        const amount = document.getElementById('manualAmount').value;
        if (!amount || amount <= 0) return alert("Enter valid amount");
        const btn = document.getElementById('manualSubmitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i>';

        try {
            const res = await fetch(`/suppliers/${activeSupplierId}/payment`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ type: document.getElementById('manualType').value, amount })
            });
            if (res.ok) {
                document.getElementById('manualAmount').value = '';
                viewSupplierHistory(activeSupplierId); fetchData(currentPage);
            }
        } finally { btn.disabled = false; btn.innerHTML = 'Sync Account'; }
    }

    async function handleFormSubmit(event) {
        event.preventDefault();
        saveButton.disabled = true;
        saveButton.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Processing...';

        const formData = new FormData(event.target);
        const data = Object.fromEntries(formData.entries());
        const url = activeSupplierId ? `/suppliers/${activeSupplierId}` : '{{ route("suppliers.store") }}';
        if (activeSupplierId) data._method = 'PUT';

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            if (res.ok) { closeModal(); fetchData(activeSupplierId ? currentPage : 1); }
            else {
                const err = await res.json();
                document.getElementById("formAlerts").innerHTML = `<div class="p-4 bg-red-50 text-red-600 rounded-2xl border border-red-100 text-[10px] font-black uppercase">${err.message}</div>`;
            }
        } finally { saveButton.disabled = false; saveButton.innerHTML = 'Confirm'; }
    }

    function editSupplier(id) {
        activeSupplierId = id;
        fetch(`/suppliers/${id}/edit`).then(res => res.json()).then(s => {
            form.elements['supplier_name'].value = s.supplier_name;
            form.elements['contact_person'].value = s.contact_person || '';
            form.elements['phone_number'].value = s.phone_number || '';
            form.elements['email'].value = s.email || '';
            form.elements['balance_due'].value = s.balance_due;
            document.querySelector('#supplierModal h2').innerText = 'Update Profile';
            openModal();
        });
    }

    function deleteSupplier(id, name) {
        if (confirm(`Remove supplier "${name}"?`)) {
            fetch(`/suppliers/${id}`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ _method: 'DELETE' }) })
                .then(() => fetchData(currentPage));
        }
    }

    document.addEventListener('DOMContentLoaded', () => fetchData(1));
</script>
@endpush