@extends('layouts.main')
@section('title', 'Supplier Management')

@section('content')
    <main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Supplier Accounts Directory
            </h1>

            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                    <div class="relative w-full md:w-1/3">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchInput" placeholder="Search by name..."
                            class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border rounded-xl outline-none text-sm"
                            oninput="debounceFetchData()">
                    </div>

                    <div class="flex items-center gap-3 flex-wrap">
                        <select id="balanceFilter" onchange="fetchData()"
                            class="px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-sm">
                            <option value="">Balance Filter (All)</option>
                            <option value="due">Balance Due > 0</option>
                            <option value="paid">Balance Due = 0</option>
                        </select>
                        <button onclick="openModalForAdd()"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 font-semibold transition text-sm">
                            <i class="fa-solid fa-plus"></i> Add New Supplier
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
                    <table class="w-full border-collapse text-sm min-w-[900px]">
                        <thead>
                            <tr class="bg-blue-600 text-white shadow-md">
                                <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Supplier Name</th>
                                <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Contact Person</th>
                                <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Phone Number</th>
                                <th class="py-3 px-5 text-left font-bold uppercase tracking-wider">Email</th>
                                <th class="py-3 px-5 text-right font-bold uppercase tracking-wider">Balance Due</th>
                                <th class="py-3 px-5 text-center font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="suppliersTableBody" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
                <div id="suppliersPagination" class="mt-6 flex justify-between items-center text-sm text-gray-600"></div>
            </div>
        </div>
    </main>

    {{-- MODAL: Supplier Ledger --}}
    <div id="historyModal"
        class="fixed inset-0 bg-black bg-opacity-60 hidden justify-center items-center z-[60] p-4 backdrop-blur-sm transition">
        <div id="historyModalBox"
            class="bg-white w-full max-w-6xl max-h-[90vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-gray-100 transform transition-all duration-300">
            <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                <div>
                    <h2 id="historySupplierName" class="text-2xl font-black text-gray-900 tracking-tight">Supplier Statement
                    </h2>
                    <span id="historySupplierPhone" class="text-sm text-gray-500 font-medium"></span>
                </div>
                <button onclick="closeHistoryModal()" class="text-gray-400 hover:text-gray-700 text-3xl">&times;</button>
            </div>

            <div class="flex flex-col lg:flex-row flex-grow overflow-hidden">
                <div class="lg:w-2/3 flex-grow overflow-y-auto p-6 border-r border-gray-50">
                    <h3 class="text-xs font-bold uppercase text-gray-400 mb-4 tracking-widest">Transaction Statement</h3>
                    <div id="historyContent"></div>
                </div>

                <div class="lg:w-1/3 bg-blue-50/30 p-6 flex flex-col">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-blue-100 mb-6 text-center">
                        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Total Balance Payable
                        </p>
                        <h4 id="ledgerTotalDue" class="text-3xl font-black text-blue-700 tracking-tighter">PKR 0.00</h4>
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200">
                        <h3 class="text-sm font-bold text-gray-800 mb-4 border-b pb-2">Record Payment</h3>
                        <div class="space-y-4">
                            <select id="manualType"
                                class="w-full px-3 py-2 border rounded-xl bg-gray-50 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-400 transition">
                                <option value="debit">Payment Sent (Reduce Balance)</option>
                                <option value="credit">Purchase/Credit (Increase Balance)</option>
                            </select>
                            <input type="number" id="manualAmount"
                                class="w-full px-3 py-2 border rounded-xl bg-gray-50 text-sm font-black outline-none"
                                placeholder="Amount (PKR)">
                            <button onclick="submitManualTransaction()" id="manualSubmitBtn"
                                class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg hover:bg-blue-700 transition active:scale-95">Update
                                Balance</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL: Add/Edit Supplier --}}
    <div id="supplierModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 p-4 transition">
        <div id="supplierModalBox"
            class="bg-white w-full max-w-2xl max-h-[90vh] mx-auto overflow-y-auto rounded-2xl shadow-2xl p-6 transform transition-all duration-300 opacity-0 scale-95">
            <form id="supplierForm" onsubmit="handleFormSubmit(event)">
                @csrf
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3">Add New Supplier</h2>
                <div id="formAlerts" class="mb-4"></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div><label class="text-sm font-medium">Supplier Name *</label><input type="text" name="supplier_name"
                            required class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-50 outline-none"></div>
                    <div><label class="text-sm font-medium">Contact Person</label><input type="text" name="contact_person"
                            class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-50 outline-none"></div>
                    <div><label class="text-sm font-medium">Phone Number</label><input type="text" name="phone_number"
                            class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-50 outline-none"></div>
                    <div><label class="text-sm font-medium">Email</label><input type="email" name="email"
                            class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-50 outline-none"></div>
                    <div class="md:col-span-2 border-t pt-4"><label class="text-sm font-medium">Opening Balance Due
                            (PKR)</label><input type="number" step="0.01" name="balance_due" value="0.00"
                            class="w-full mt-1 px-3 py-2 border rounded-lg bg-gray-50 font-bold text-lg outline-none"></div>
                </div>
                <div class="flex justify-end gap-3 mt-8 border-t pt-4">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2 bg-gray-200 rounded-xl font-semibold transition">Cancel</button>
                    <button type="submit" id="saveSupplierBtn"
                        class="px-5 py-2 bg-green-600 text-white rounded-xl shadow-md font-semibold transition hover:bg-green-700">Save
                        Supplier</button>
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
        const paginationContainer = document.getElementById("suppliersPagination");

        // --- Modal Logic ---
        function openModal() {
            modal.classList.replace("hidden", "flex");
            setTimeout(() => modalBox.classList.replace("scale-95", "scale-100"), 10);
            modalBox.classList.replace("opacity-0", "opacity-100");
            document.body.style.overflow = 'hidden';
        }

        function openModalForAdd() {
            form.reset(); activeSupplierId = null;
            document.querySelector('#supplierModal h2').innerText = 'Add New Supplier';
            if (form.querySelector('input[name="_method"]')) form.querySelector('input[name="_method"]').remove();
            openModal();
        }

        function closeModal() {
            modalBox.classList.replace("scale-100", "scale-95");
            modalBox.classList.replace("opacity-100", "opacity-0");
            setTimeout(() => { modal.classList.replace("flex", "hidden"); document.body.style.overflow = ''; }, 300);
        }

        function closeHistoryModal() { document.getElementById('historyModal').classList.replace("flex", "hidden"); }

        // --- Data Fetching ---
        function debounceFetchData() { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => fetchData(1), 300); }

        function fetchData(page = 1) {
            currentPage = page;
            const search = document.getElementById("searchInput").value;
            const balance = document.getElementById("balanceFilter").value;
            tableBody.innerHTML = '<tr><td colspan="6" class="py-12 text-center text-gray-400 italic">Refreshing data...</td></tr>';

            fetch(`{{ route('suppliers.fetch') }}?page=${page}&search=${search}&balance_filter=${balance}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (data.data.length > 0) {
                        data.data.forEach(s => {
                            const bal = parseFloat(s.balance_due);
                            html += `<tr class="hover:bg-gray-50 transition border-b">
                            <td class="py-4 px-5 font-bold text-gray-800">${s.supplier_name}</td>
                            <td class="py-4 px-5 text-gray-600">${s.contact_person || 'N/A'}</td>

                            <td class="py-4 px-5 text-gray-600">${s.phone_number || 'N/A'}</td>
                            <td class="py-4 px-5 text-gray-600">${s.email || 'N/A'}</td>

                            <td class="py-4 px-5 text-right font-black ${bal > 0 ? 'text-red-600' : 'text-green-600'}">PKR ${bal.toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
                            <td class="py-4 px-5 text-center">
                                <div class="flex justify-center gap-4 text-gray-400 text-lg">
                                    <i class="fa-solid fa-file-invoice cursor-pointer hover:text-blue-600" onclick="viewSupplierHistory(${s.id})"></i>
                                    <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" onclick="editSupplier(${s.id})"></i>
                                    <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" onclick="deleteSupplier(${s.id}, '${s.supplier_name.replace(/'/g, "\\'")}')"></i>
                                </div>
                            </td>
                        </tr>`;
                        });
                    } else {
                        html = '<tr><td colspan="6" class="py-12 text-center text-gray-400">No records found.</td></tr>';
                    }
                    tableBody.innerHTML = html;
                    paginationContainer.innerHTML = generatePagination(data.links);
                    attachPaginationListeners();
                });
        }
        function generatePagination(l) {
            if (!l.total) return '';
            let h = `<div class="flex gap-2">`;
            h += l.prev_page_url ? `<a href="${l.prev_page_url}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">&larr; Previous</a>` : `<span class="px-3 py-1 border rounded-lg text-gray-300">&larr; Previous</span>`;
            h += l.next_page_url ? `<a href="${l.next_page_url}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">Next &rarr;</a>` : `<span class="px-3 py-1 border rounded-lg text-gray-300">Next &rarr;</span>`;
            return h + '</div>';
        }

        function attachPaginationListeners() {
            document.querySelectorAll('#suppliersPagination a').forEach(a => { a.onclick = (e) => { e.preventDefault(); fetchData(new URL(a.href).searchParams.get('page')); }; });
        }

        // --- Ledger Logic ---
        function viewSupplierHistory(id) {
            activeSupplierId = id;
            const content = document.getElementById('historyContent');
            content.innerHTML = '<div class="text-center py-20"><i class="fa-solid fa-spinner fa-spin text-4xl text-blue-600"></i></div>';
            document.getElementById('historyModal').classList.replace("hidden", "flex");

            fetch(`/suppliers/${id}/history`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('historySupplierName').innerText = data.supplier.supplier_name;
                    document.getElementById('historySupplierPhone').innerText = `Phone: ${data.supplier.phone_number || 'N/A'}`;
                    document.getElementById('ledgerTotalDue').innerText = `PKR ${parseFloat(data.supplier.balance_due).toLocaleString(undefined, { minimumFractionDigits: 2 })}`;

                    if (!data.history || data.history.length === 0) {
                        content.innerHTML = '<div class="text-center py-10 text-gray-400">No transactions found.</div>';
                        return;
                    }

                    let html = `<table class="w-full text-sm"><thead><tr class="text-left border-b text-gray-400 text-[10px] uppercase font-black">
                    <th class="pb-3">Date</th><th class="pb-3">Ref #</th><th class="pb-3 text-center">Type</th><th class="pb-3 text-right">Amount</th></tr></thead><tbody class="divide-y divide-gray-100">`;

                    data.history.forEach(entry => {
                        const isManual = entry.category === 'Manual';
                        const label = isManual ? (entry.type === 'debit' ? 'Payment Sent' : 'Debt Added') : 'PO Purchase';
                        const color = isManual ? (entry.type === 'debit' ? 'text-green-600' : 'text-red-600') : 'text-blue-600';
                        const date = new Date(entry.date).toLocaleDateString('en-GB');

                        html += `<tr class="hover:bg-blue-50/30 transition"><td class="py-4 text-xs font-medium text-gray-500">${date}</td>
                        <td class="py-4 font-bold text-gray-700">${entry.reference}</td>
                        <td class="py-4 text-center"><span class="px-2 py-1 rounded text-[9px] font-black uppercase border border-gray-200 ${color}">${label}</span></td>
                        <td class="py-4 text-right font-black text-gray-900 tracking-tighter">PKR ${parseFloat(entry.amount).toLocaleString()}</td></tr>`;
                    });
                    content.innerHTML = html + '</tbody></table>';
                }).catch(err => { console.error(err); });
        }

        async function submitManualTransaction() {
            const type = document.getElementById('manualType').value;
            const amount = document.getElementById('manualAmount').value;
            if (!amount || amount <= 0) return alert("Enter amount");
            const btn = document.getElementById('manualSubmitBtn'); btn.disabled = true;

            const res = await fetch(`/suppliers/${activeSupplierId}/payment`, {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ type, amount })
            });

            if (res.ok) { document.getElementById('manualAmount').value = ''; viewSupplierHistory(activeSupplierId); fetchData(currentPage); }
            btn.disabled = false;
        }

        // --- CRUD Actions ---
       async function handleFormSubmit(event) {
        event.preventDefault();
        saveButton.disabled = true;
        saveButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

        const alertsContainer = document.getElementById("formAlerts");
        alertsContainer.innerHTML = ''; // Purane errors clear karein

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const url = activeSupplierId ? `/suppliers/${activeSupplierId}` : '{{ route("suppliers.store") }}';
        if (activeSupplierId) data._method = 'PUT';

        try {
            const res = await fetch(url, {
                method: 'POST', // Method spoofing logic
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();

            if (res.status === 201 || res.status === 200) {
                // Success case
                alertsContainer.innerHTML = `<div class="p-3 bg-green-100 text-green-700 rounded-lg font-bold border-l-4 border-green-500">${result.message}</div>`;
                setTimeout(() => {
                    closeModal();
                    fetchData(activeSupplierId ? currentPage : 1);
                }, 1000);
            } else if (res.status === 422) {
                // Validation error (Unique constraint failed)
                let errorsHtml = '<div class="p-3 bg-red-100 text-red-700 rounded-lg border-l-4 border-red-500"><ul class="list-disc ml-5">';
                for (const key in result.errors) {
                    result.errors[key].forEach(error => {
                        errorsHtml += `<li>${error}</li>`;
                    });
                }
                errorsHtml += '</ul></div>';
                alertsContainer.innerHTML = errorsHtml;
                saveButton.disabled = false;
                saveButton.innerHTML = 'Save Supplier';
            } else {
                throw new Error("Unexpected error occurred");
            }
        } catch (error) {
            alertsContainer.innerHTML = `<div class="p-3 bg-red-100 text-red-700 rounded-lg border-l-4 border-red-500">Duplicate name or phone number detected! Please use unique values.</div>`;
            saveButton.disabled = false;
            saveButton.innerHTML = 'Save Supplier';
        }
    }

      function editSupplier(id) {
        activeSupplierId = id;
        fetch(`/suppliers/${id}/edit`).then(res => res.json()).then(s => {
            openModal(); 
            document.querySelector('#supplierModal h2').innerText = 'Edit Supplier Record';
            
            // Sab fields ko populate karein
            form.elements['supplier_name'].value = s.supplier_name; 
            form.elements['contact_person'].value = s.contact_person || '';
            form.elements['phone_number'].value = s.phone_number || ''; // Add this
            form.elements['email'].value = s.email || '';               // Add this
            form.elements['balance_due'].value = s.balance_due;
        });
    }

        function deleteSupplier(id, name) {
            if (confirm(`Delete supplier ${name}?`)) {
                fetch(`/suppliers/${id}`, { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ _method: 'DELETE' }) })
                    .then(() => fetchData(currentPage));
            }
        }

        document.addEventListener('DOMContentLoaded', () => fetchData(1));
    </script>
@endpush