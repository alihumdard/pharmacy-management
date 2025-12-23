@extends('layouts.main')
@section('title', 'Customer Ledger & Accounts')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Customer Directory & Ledger</h1>

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                {{-- Search Input --}}
                <div class="relative w-full md:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search by name or phone..."
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border border-gray-300 rounded-xl outline-none text-sm text-gray-700 focus:ring-2 focus:ring-blue-400 transition"
                        oninput="debounceFetchData()">
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <select id="creditFilter" onchange="fetchData()"
                        class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl shadow-md transition text-sm font-medium text-gray-700">
                        <option value="">Credit Filter (All)</option>
                        <option value="due">Credit Due > 0</option>
                        <option value="paid">Credit Due = 0</option>
                    </select>

                    <button onclick="openModalForAdd()" 
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 font-semibold flex items-center gap-2 transition text-sm">
                        <i class="fa-solid fa-user-plus"></i> Add New Customer
                    </button>
                </div>
            </div>

            {{-- Customers Table --}}
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
                <table class="w-full border-collapse text-sm min-w-[700px]">
                    <thead>
                        <tr class="bg-blue-600 text-white shadow-md">
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Customer Name</th>
                            <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Phone Number</th>
                            <th class="py-3 px-5 text-right font-bold uppercase tracking-wider">Total Purchases</th>
                            <th class="py-3 px-5 text-right font-bold uppercase tracking-wider">Credit Balance</th>
                            <th class="py-3 px-5 text-center font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="customersTableBody" class="divide-y divide-gray-200"></tbody>
                </table>
            </div>
            <div id="customersPagination" class="mt-6 flex justify-between items-center text-sm text-gray-600"></div>
        </div>
    </div>
</main>

{{-- MODAL: Add / Edit Customer --}}
<div id="customerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 p-4 transition">
    <div id="customerModalBox" class="bg-white w-full max-w-2xl max-h-[90vh] mx-auto overflow-y-auto rounded-2xl shadow-2xl p-6 transform transition-all duration-300 opacity-0 scale-95">
        <form id="customerForm" onsubmit="handleFormSubmit(event)">
            @csrf
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3 flex items-center gap-2">Add New Customer</h2>
            <div id="formAlerts" class="mb-4"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-700">Customer Name *</label>
                    <input type="text" name="customer_name" required class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-50 outline-none">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Phone Number *</label>
                    <input type="text" name="phone_number" required class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-50 outline-none">
                </div>
                <div class="md:col-span-2 border-t pt-4">
                    <label class="text-sm font-medium text-gray-700">Opening Balance (PKR)</label>
                    <input type="number" step="0.01" name="credit_balance" value="0.00" class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-50 font-black text-lg outline-none">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8 border-t pt-4">
                <button type="button" onclick="closeCustomerModal()" class="px-5 py-2 bg-gray-200 rounded-xl font-semibold transition">Cancel</button>
                <button type="submit" id="saveCustomerBtn" class="px-5 py-2 bg-green-600 text-white rounded-xl font-semibold shadow-md transition hover:bg-green-700">Save Customer</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: Statement Ledger (Cash vs Credit clearly shown) --}}
<div id="historyModal" class="fixed inset-0 bg-black bg-opacity-60 hidden justify-center items-center z-[60] p-4 backdrop-blur-sm transition">
    <div id="historyModalBox" class="bg-white w-full max-w-6xl max-h-[90vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-gray-100 transform transition-all duration-300">
        
        <div class="p-6 border-b flex justify-between items-center bg-gray-50">
            <div>
                <h2 id="historyCustomerName" class="text-2xl font-black text-gray-900">Statement</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span id="historyCustomerPhone" class="text-sm text-gray-500 font-medium"></span>
                    <button onclick="sendWhatsAppReminder()" class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold flex items-center gap-1 hover:bg-green-200 transition">
                        <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Reminder
                    </button>
                </div>
            </div>
            <button onclick="closeHistoryModal()" class="text-gray-400 hover:text-gray-700 text-3xl font-light">&times;</button>
        </div>

        <div class="flex flex-col lg:flex-row flex-grow overflow-hidden">
            <div class="lg:w-2/3 flex-grow overflow-y-auto p-6 border-r border-gray-50">
                <h3 class="text-xs font-bold uppercase text-gray-400 mb-4 tracking-widest border-b pb-2">Full Transaction Statement</h3>
                <div id="historyContent"></div>
            </div>

            <div class="lg:w-1/3 bg-blue-50/30 p-6 flex flex-col">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 mb-6 text-center">
                    <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Total Outstanding Due</p>
                    <h4 id="ledgerTotalCredit" class="text-3xl font-black text-blue-700 tracking-tighter">PKR 0.00</h4>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 border-b pb-2">Record Payment</h3>
                    <div class="space-y-4">
                        <select id="manualType" class="w-full px-3 py-2 border rounded-xl bg-gray-50 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-400 transition">
                            <option value="debit">Payment Received (Debit)</option>
                            <option value="credit">Manual Debt (Credit)</option>
                        </select>
                        <input type="number" id="manualAmount" class="w-full px-3 py-2 border rounded-xl bg-gray-50 text-sm font-black outline-none" placeholder="0.00">
                        <button onclick="submitManualTransaction()" id="manualSubmitBtn" class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg hover:bg-blue-700 transition active:scale-95">Update Ledger</button>
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

    const modal = document.getElementById("customerModal");
    const modalBox = document.getElementById("customerModalBox");
    const form = document.getElementById("customerForm");
    const saveButton = document.getElementById("saveCustomerBtn");
    const tableBody = document.getElementById("customersTableBody");
    const paginationContainer = document.getElementById("customersPagination");

    // --- Modal Logic ---
    function openCustomerModal() {
        modal.classList.replace("hidden", "flex");
        setTimeout(() => modalBox.classList.replace("scale-95", "scale-100"), 10);
        modalBox.classList.replace("opacity-0", "opacity-100");
        document.body.style.overflow = 'hidden'; 
    }

    function openModalForAdd() {
        form.reset();
        activeCustomerId = null;
        document.querySelector('#customerModal h2').innerText = 'Add New Customer Record';
        if (form.querySelector('input[name="_method"]')) form.querySelector('input[name="_method"]').remove();
        openCustomerModal();
    }

    function closeCustomerModal() {
        modalBox.classList.replace("scale-100", "scale-95");
        modalBox.classList.replace("opacity-100", "opacity-0");
        setTimeout(() => { modal.classList.replace("flex", "hidden"); document.body.style.overflow = ''; }, 300);
    }

    function closeHistoryModal() { document.getElementById('historyModal').classList.replace("flex", "hidden"); }

    // --- Search & Fetch ---
    function debounceFetchData() { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => fetchData(1), 300); }

    function fetchData(page = 1) {
        currentPage = page;
        const search = document.getElementById("searchInput").value;
        const filter = document.getElementById("creditFilter").value;
        tableBody.innerHTML = '<tr><td colspan="5" class="py-12 text-center text-gray-400 font-medium italic">Refreshing data...</td></tr>';
        
        fetch(`{{ route('customers.fetch') }}?page=${page}&search=${search}&credit_filter=${filter}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            let html = '';
            if (data.data.length > 0) {
                data.data.forEach(c => {
                    const bal = parseFloat(c.credit_balance);
                    html += `<tr class="hover:bg-gray-50 transition border-b">
                        <td class="py-4 px-5 font-bold text-gray-800">${c.customer_name}</td>
                        <td class="py-4 px-5 text-gray-600">${c.phone_number}</td>
                        <td class="py-4 px-5 text-right font-semibold text-gray-700">PKR ${Number(c.total_purchases).toLocaleString()}</td>
                        <td class="py-4 px-5 text-right font-black ${bal > 0 ? 'text-red-600' : 'text-green-600'}">PKR ${bal.toLocaleString(undefined, {minimumFractionDigits: 2})}</td>
                        <td class="py-4 px-5 text-center">
                            <div class="flex justify-center gap-4 text-gray-400 text-lg">
                                <i class="fa-solid fa-file-invoice cursor-pointer hover:text-blue-600" onclick="viewCustomerHistory(${c.id})"></i>
                                <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" onclick="editCustomer(${c.id})"></i>
                                <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" onclick="deleteCustomer(${c.id}, '${c.customer_name.replace(/'/g, "\\'")}')"></i>
                            </div>
                        </td>
                    </tr>`;
                });
            } else { html = '<tr><td colspan="5" class="py-12 text-center text-gray-400">No records found.</td></tr>'; }
            tableBody.innerHTML = html;
            paginationContainer.innerHTML = generatePagination(data.links);
            attachPaginationListeners();
        });
    }

    function generatePagination(l) {
        if (l.total === 0) return '';
        let h = `<div class="flex gap-2">`;
        h += l.prev_page_url ? `<a href="${l.prev_page_url}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">&larr; Previous</a>` : `<span class="px-3 py-1 border rounded-lg text-gray-300">&larr; Previous</span>`;
        h += l.next_page_url ? `<a href="${l.next_page_url}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">Next &rarr;</a>` : `<span class="px-3 py-1 border rounded-lg text-gray-300">Next &rarr;</span>`;
        return h + '</div>';
    }

    function attachPaginationListeners() {
        document.querySelectorAll('#customersPagination a').forEach(a => { a.onclick = (e) => { e.preventDefault(); fetchData(new URL(a.href).searchParams.get('page')); }; });
    }

    // --- Ledger Logic (Detailed Statement) ---
    function viewCustomerHistory(id) {
        activeCustomerId = id;
        const content = document.getElementById('historyContent');
        content.innerHTML = '<div class="text-center py-20"><i class="fa-solid fa-spinner fa-spin text-4xl text-blue-600"></i><p class="mt-4 text-gray-400 font-bold tracking-widest">Generating Statement...</p></div>';
        document.getElementById('historyModal').classList.replace("hidden", "flex");

        fetch(`/customers/${id}/history`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.customer) throw new Error("Invalid structure");
            activeCustomerName = data.customer.customer_name;
            activeCustomerPhone = data.customer.phone_number;
            currentBalance = parseFloat(data.customer.credit_balance);

            document.getElementById('historyCustomerName').innerText = activeCustomerName;
            document.getElementById('historyCustomerPhone').innerText = `Phone: ${activeCustomerPhone}`;
            document.getElementById('ledgerTotalCredit').innerText = `PKR ${currentBalance.toLocaleString(undefined, {minimumFractionDigits: 2})}`;

            if (!data.history || data.history.length === 0) {
                content.innerHTML = '<div class="text-center py-20 text-gray-300 italic">No transaction history found for this account.</div>';
                return;
            }

            let html = `
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left border-b text-gray-400 text-[10px] uppercase font-black">
                            <th class="pb-3">Date</th>
                            <th class="pb-3">Reference/Ref</th>
                            <th class="pb-3 text-center">Type</th>
                            <th class="pb-3 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">`;

            data.history.forEach(entry => {
                const isManual = entry.category === 'Manual';
                const isCreditSale = entry.type === 'credit';
                const isDebit = entry.type === 'debit';
                
                // Set Badge Colors and Labels
                let badgeClass = '';
                let label = '';

                if (isManual) {
                    badgeClass = isDebit ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200';
                    label = isDebit ? 'Payment Recv' : 'Loan Added';
                } else {
                    badgeClass = isCreditSale ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-blue-50 text-blue-700 border-blue-200';
                    label = isCreditSale ? 'Credit Sale' : 'Cash Sale';
                }

                const date = new Date(entry.date);
                const displayDate = date.toLocaleDateString('en-GB') + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                html += `<tr class="hover:bg-blue-50/30 transition">
                    <td class="py-4 text-gray-500 text-[11px] font-medium">${displayDate}</td>
                    <td class="py-4 font-bold text-gray-700">${entry.reference}</td>
                    <td class="py-4 text-center">
                        <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase border ${badgeClass}">
                            ${label}
                        </span>
                    </td>
                    <td class="py-4 text-right font-black text-gray-900">PKR ${parseFloat(entry.amount).toLocaleString()}</td>
                </tr>`;
            });
            content.innerHTML = html + '</tbody></table>';
        });
    }

    // --- Form Submissions (AJAX) ---
    async function handleFormSubmit(event) {
        event.preventDefault();
        saveButton.disabled = true;
        saveButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Saving...';
        
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const url = activeCustomerId ? `/customers/${activeCustomerId}` : '{{ route("customers.store") }}';
        if (activeCustomerId) data._method = 'PUT';

        const res = await fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await res.json();
        if (res.ok) {
            document.getElementById("formAlerts").innerHTML = `<div class="p-3 bg-green-100 text-green-700 rounded-lg font-bold">${result.message}</div>`;
            setTimeout(() => { closeCustomerModal(); fetchData(activeCustomerId ? currentPage : 1); }, 800);
        } else {
            document.getElementById("formAlerts").innerHTML = `<div class="p-3 bg-red-100 text-red-700 rounded-lg">${result.message || 'Error saving data'}</div>`;
            saveButton.disabled = false; saveButton.innerText = 'Save Customer';
        }
    }

    async function submitManualTransaction() {
        const type = document.getElementById('manualType').value;
        const amount = document.getElementById('manualAmount').value;
        if (!amount || amount <= 0) return alert("Enter amount");
        const btn = document.getElementById('manualSubmitBtn');
        btn.disabled = true;

        const res = await fetch(`/customers/${activeCustomerId}/payment`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ type, amount })
        });

        if (res.ok) {
            document.getElementById('manualAmount').value = '';
            viewCustomerHistory(activeCustomerId); fetchData(currentPage);
        } else { alert("Failed"); }
        btn.disabled = false;
    }

    function sendWhatsAppReminder() {
        if (currentBalance <= 0) return alert("Clear balance");
        const msg = `Dear ${activeCustomerName}, your pending balance is PKR ${currentBalance.toLocaleString()}. Thank you!`;
        window.open(`https://wa.me/${activeCustomerPhone}?text=${encodeURIComponent(msg)}`, '_blank');
    }

    function editCustomer(id) {
        activeCustomerId = id;
        fetch(`/customers/${id}/edit`).then(res => res.json()).then(c => {
            openCustomerModal();
            document.querySelector('#customerModal h2').innerText = 'Edit Profile';
            form.elements['customer_name'].value = c.customer_name;
            form.elements['phone_number'].value = c.phone_number;
            form.elements['credit_balance'].value = c.credit_balance;
        });
    }

    function deleteCustomer(id, name) {
        if (confirm(`Delete ${name}?`)) {
            fetch(`/customers/${id}`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ _method: 'DELETE' }) })
            .then(() => fetchData(currentPage));
        }
    }

    document.addEventListener('DOMContentLoaded', () => fetchData(1));
</script>
@endpush