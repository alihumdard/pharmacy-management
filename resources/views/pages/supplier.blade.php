@extends('layouts.main')
@section('title', 'Supplier Management')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">

    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Supplier Accounts Directory</h1>

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                {{-- Search Input --}}
                <div class="relative w-full md:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search by name or contact person..."
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border border-gray-300 rounded-xl outline-none text-sm text-gray-700 focus:ring-2 focus:ring-blue-400 transition"
                        oninput="debounceFetchData()">
                </div>

                {{-- Filters and Add Button --}}
                <div class="flex items-center gap-3 flex-wrap">

                    {{-- Balance Filter --}}
                    <div class="relative">
                        <select id="balanceFilter" onchange="fetchData()"
                            class="appearance-none px-5 py-2.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 flex items-center gap-2 shadow-md transition text-sm font-medium text-gray-700 pr-10">
                            <option value="">Balance Filter (All)</option>
                            <option value="due">Balance Due > 0</option>
                            <option value="paid">Balance Due = 0</option>
                        </select>
                        <i class="fa-solid fa-filter text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    {{-- Add New Supplier Button (Calls openModalForAdd) --}}
                    <button onclick="openModalForAdd()" 
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 font-semibold flex items-center gap-2 transition text-sm">
                        <i class="fa-solid fa-plus"></i> Add New Supplier
                    </button>

                </div>
            </div>

            {{-- Suppliers Table --}}
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

                    {{-- Table Body - Initial Load (Protected by isset check) --}}
                    <tbody id="suppliersTableBody" class="divide-y divide-gray-200">
                        @if (isset($suppliers))
                            @forelse ($suppliers as $supplier)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-5 font-semibold text-gray-800">{{ $supplier->supplier_name }}</td>
                                    <td class="py-4 px-5 text-gray-600 font-medium">{{ $supplier->contact_person ?? 'N/A' }}</td>
                                    <td class="py-4 px-5 text-gray-600">{{ $supplier->phone_number ?? 'N/A' }}</td>
                                    <td class="py-4 px-5 text-gray-600">{{ $supplier->email ?? 'N/A' }}</td>
                                    <td class="py-4 px-5 text-right font-extrabold 
                                        @if ($supplier->balance_due > 0) 
                                            text-red-600
                                        @else
                                            text-green-600
                                        @endif">
                                        PKR {{ number_format($supplier->balance_due, 2) }}
                                    </td>
                                    <td class="py-4 px-5 text-center">
                                        <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                                            <i class="fa-solid fa-file-invoice cursor-pointer hover:text-blue-600" title="View Purchase History"></i>
                                            {{-- ADDED: Edit handler --}}
                                            <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Supplier" onclick="editSupplier({{ $supplier->id }})"></i>
                                            {{-- ADDED: Delete handler --}}
                                            <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Supplier" onclick="deleteSupplier({{ $supplier->id }}, '{{ addslashes($supplier->supplier_name) }}')"></i>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500 font-medium">No suppliers found.</td>
                                </tr>
                            @endforelse
                        @else
                            {{-- Fallback if the variable is not set by the layout/route --}}
                            <tr>
                                <td colspan="6" class="py-8 text-center text-red-500 font-medium">Error: Supplier data failed to load.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Pagination - Initial Load (Protected by isset check) --}}
            <div id="suppliersPagination" class="mt-6 flex justify-between items-center text-sm text-gray-600">
                @if (isset($suppliers) && $suppliers->hasPages())
                    <span>Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} results</span>
                    <div class="flex gap-2">
                        @if ($suppliers->onFirstPage())
                            <span class="px-3 py-1 border rounded-lg text-gray-400">&larr; Previous</span>
                        @else
                            <a href="{{ $suppliers->previousPageUrl() }}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">&larr; Previous</a>
                        @endif

                        @if ($suppliers->hasMorePages())
                            <a href="{{ $suppliers->nextPageUrl() }}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">Next &rarr;</a>
                        @else
                            <span class="px-3 py-1 border rounded-lg text-gray-400">Next &rarr;</span>
                        @endif
                    </div>
                @elseif (isset($suppliers))
                    <span>Showing {{ $suppliers->count() }} results</span>
                    <div></div>
                @else
                    {{-- Placeholder to prevent layout shift during the error state --}}
                    <span>Loading...</span>
                    <div></div>
                @endif
            </div>

        </div>
    </div>
</main>


{{-- Supplier Modal (Add/Edit Form) --}}
<div id="supplierModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 p-4">

    <div class="bg-white w-full max-w-2xl max-h-[90vh] mx-auto overflow-y-auto rounded-2xl shadow-2xl p-6 transition-all duration-300">
        <form id="supplierForm" action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3 flex items-center gap-2">
                <i class="fa-solid fa-truck-field text-blue-600"></i> Add New Supplier
            </h2>
            
            <div id="formAlerts" class="mb-4"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="text-sm font-medium text-gray-700">Supplier Name <span class="text-red-500">*</span></label>
                    <input type="text" name="supplier_name" id="supplier_name" required
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Contact Person</label>
                    <input type="text" name="contact_person"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone_number"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-700">Address</label>
                    <textarea rows="2" name="address"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition resize-none"></textarea>
                </div>

                <div class="md:col-span-2 border-t pt-4">
                    <label class="text-sm font-medium text-gray-700">Opening/Current Balance Due (PKR)</label>
                    <input type="number" step="0.01" name="balance_due" value="0.00"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition font-bold text-lg">
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-8 border-t pt-4">
                <button type="button" onclick="closeModal()"
                    class="px-5 py-2 bg-gray-200 rounded-xl font-semibold hover:bg-gray-300 transition">
                    Cancel
                </button>

                <button type="submit" id="saveSupplierBtn"
                    class="px-5 py-2 bg-green-600 text-white rounded-xl shadow-md font-semibold hover:bg-green-700 transition">
                    Save Supplier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById("supplierModal");
    const form = document.getElementById("supplierForm");
    const saveButton = document.getElementById("saveSupplierBtn");
    const tableBody = document.getElementById("suppliersTableBody");
    const paginationContainer = document.getElementById("suppliersPagination");
    const searchInput = document.getElementById("searchInput");
    const balanceFilter = document.getElementById("balanceFilter");

    let currentPage = 1;
    let debounceTimer;

    // --- Modal Functions ---

    // **BASIC OPEN FUNCTION** (Used by Add/Edit handlers)
    function openModal() {
        document.getElementById("formAlerts").innerHTML = '';
        
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        document.body.style.overflow = 'hidden'; 
    }

    // Function to handle opening the modal for Add operation (called by the button)
    function openModalForAdd() {
        closeModal(); // 1. Ensure a clean slate (resets to 'Add' mode)
        document.querySelector('#supplierModal h2').textContent = 'Add New Supplier';
        form.action = '{{ route('suppliers.store') }}';
        
        openModal(); // 2. Open the modal
        form.querySelector('input[name="supplier_name"]').focus(); // 3. Focus
    }

    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        document.body.style.overflow = '';

        // CRITICAL: Complete Reset for consistency
        form.reset();
        document.querySelector('#supplierModal h2').textContent = 'Add New Supplier';
        form.action = '{{ route('suppliers.store') }}';
        
        const methodField = form.querySelector('input[name="_method"]');
        if (methodField) {
            methodField.remove(); // Remove the hidden PUT/DELETE field
        }
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // --- Data Rendering Functions ---

    // Function to generate a single table row HTML from a supplier object
    function generateTableRow(supplier) {
        // Ensure balance_due is treated as a float for comparison and formatting
        const balance = parseFloat(supplier.balance_due);
        const balanceColor = balance > 0 ? 'text-red-600' : 'text-green-600';
        const formattedBalance = `PKR ${balance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;

        // Escaping supplier name for use in JS function
        const escapedName = supplier.supplier_name.replace(/'/g, "\\'");

        return `
            <tr class="hover:bg-gray-50 transition" data-supplier-id="${supplier.id}">
                <td class="py-4 px-5 font-semibold text-gray-800">${supplier.supplier_name}</td>
                <td class="py-4 px-5 text-gray-600 font-medium">${supplier.contact_person ?? 'N/A'}</td>
                <td class="py-4 px-5 text-gray-600">${supplier.phone_number ?? 'N/A'}</td>
                <td class="py-4 px-5 text-gray-600">${supplier.email ?? 'N/A'}</td>
                <td class="py-4 px-5 text-right font-extrabold ${balanceColor}">
                    ${formattedBalance}
                </td>
                <td class="py-4 px-5 text-center">
                    <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                        <i class="fa-solid fa-file-invoice cursor-pointer hover:text-blue-600" title="View Purchase History"></i>
                        {{-- Added onclick for EDIT --}}
                        <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Supplier" onclick="editSupplier(${supplier.id})"></i>
                        {{-- Added onclick for DELETE --}}
                        <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Supplier" onclick="deleteSupplier(${supplier.id}, '${escapedName}')"></i>
                    </div>
                </td>
            </tr>
        `;
    }

    // Function to dynamically build the entire pagination HTML from link data
    function generatePagination(links) {
        if (links.total === 0) {
            return '<span>No results found</span><div></div>';
        }

        let html = `<span>Showing ${links.from ?? 0} to ${links.to ?? 0} of ${links.total} results</span>`;
        html += '<div class="flex gap-2">';
        
        // Previous Button
        if (links.prev_page_url) {
            html += `<a href="${links.prev_page_url}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">&larr; Previous</a>`;
        } else {
            html += `<span class="px-3 py-1 border rounded-lg text-gray-400">&larr; Previous</span>`;
        }

        // Next Button
        if (links.next_page_url) {
            html += `<a href="${links.next_page_url}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">Next &rarr;</a>`;
        } else {
            html += `<span class="px-3 py-1 border rounded-lg text-gray-400">Next &rarr;</span>`;
        }

        html += '</div>';
        return html;
    }
    
    // --- AJAX Data Fetching (Search, Filter, Pagination) ---

    function debounceFetchData() {
        clearTimeout(debounceTimer);
        currentPage = 1; // Reset to first page on new search
        debounceTimer = setTimeout(() => {
            fetchData();
        }, 300);
    }

    // Main function to fetch and update table data
    function fetchData(page = 1) {
        // IMPORTANT: If table body currently contains the PHP error fallback, 
        // we assume we need to run an initial fetch to load data.
        const isErrorState = tableBody.querySelector('td.text-red-500') !== null;
        
        // If we are on the initial load and the error is showing, use AJAX to load the data.
        if (isErrorState && page === 1 && searchInput.value === '' && balanceFilter.value === '') {
            // Clear the initial PHP error message before fetching
            tableBody.innerHTML = '<tr><td colspan="6" class="py-8 text-center text-gray-500 font-medium"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading data...</td></tr>';
            paginationContainer.innerHTML = '<span>Loading...</span><div></div>';
        }
        
        currentPage = page;
        const search = searchInput.value;
        const balance = balanceFilter.value;
        
        const url = `{{ route('suppliers.fetch') }}?page=${page}&search=${search}&balance_filter=${balance}`;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            let tableRows = '';
            
            if (data.data && data.data.length > 0) {
                // RENDER TABLE ROWS from the JSON data array
                data.data.forEach(supplier => {
                    tableRows += generateTableRow(supplier);
                });
            } else {
                tableRows = '<tr><td colspan="6" class="py-8 text-center text-gray-500 font-medium">No suppliers found matching your criteria.</td></tr>';
            }
            
            tableBody.innerHTML = tableRows; 
            
            // RENDER PAGINATION using the received link metadata
            paginationContainer.innerHTML = generatePagination(data.links);
            
            attachPaginationListeners(); 
        })
        .catch(error => {
            console.error('Error fetching suppliers:', error);
            // Revert to error state if AJAX failed after initial attempt
            tableBody.innerHTML = '<tr><td colspan="6" class="py-8 text-center text-red-500 font-medium">Failed to load data. Please check your network or server connection.</td></tr>';
            paginationContainer.innerHTML = '<span>Error loading data.</span><div></div>';
        });
    }

    // Attach listeners to dynamically loaded pagination links
    function attachPaginationListeners() {
        document.querySelectorAll('#suppliersPagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                // Extract page number from the full URL string
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                fetchData(page);
            });
        });
    }

    // Initial setup: If the PHP rendered an error, immediately try to load data via AJAX
    document.addEventListener('DOMContentLoaded', () => {
        // If PHP failed to render suppliers (due to DB error/missing variable), 
        // the table body will contain the specific red error message.
        if (tableBody.querySelector('td.text-red-500')) {
            // Run fetchData to attempt to load data via AJAX immediately
            fetchData(1);
        } else {
            // Otherwise, attach listeners to the initial Blade-rendered pagination
            attachPaginationListeners(); 
        }
    });


    // --- Edit/Update Functions ---

    function editSupplier(supplierId) {
        // 1. Reset the modal state first to ensure clean form fields
        closeModal(); 
        
        // 2. Fetch supplier data
        fetch(`/suppliers/${supplierId}/edit`, { 
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) {
                // Handle 404/500 errors during fetch
                throw new Error('Failed to fetch supplier data.');
            }
            return response.json();
        })
        .then(supplier => {
            // 3. Populate Modal Title, Action, and Hidden Method
            document.querySelector('#supplierModal h2').textContent = `Edit Supplier: ${supplier.supplier_name}`;
            form.action = `/suppliers/${supplier.id}`;
            
            // Add hidden method field
            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PUT';
            form.appendChild(methodField);
            
            // 4. Populate form fields (Use querySelector with input name)
            document.querySelector('input[name="supplier_name"]').value = supplier.supplier_name ?? '';
            document.querySelector('input[name="contact_person"]').value = supplier.contact_person ?? '';
            document.querySelector('input[name="phone_number"]').value = supplier.phone_number ?? '';
            document.querySelector('input[name="email"]').value = supplier.email ?? '';
            document.querySelector('textarea[name="address"]').value = supplier.address ?? '';
            document.querySelector('input[name="balance_due"]').value = parseFloat(supplier.balance_due).toFixed(2);
            
            // 5. Open Modal
            openModal();
            document.querySelector('input[name="supplier_name"]').focus();
        })
        .catch(error => {
            console.error('Error fetching supplier for edit:', error);
            alert('Could not load supplier data for editing. Check console for details.');
        });
    }


    // --- Delete Function ---

    function deleteSupplier(supplierId, supplierName) {
        if (confirm(`Are you sure you want to delete the supplier "${supplierName}"? This action cannot be undone.`)) {
            
            fetch(`/suppliers/${supplierId}`, { 
                method: 'POST', // Method spoofing requires POST request
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'DELETE' // Method spoofing for Laravel routes
                })
            })
            .then(response => {
                if (response.ok) {
                    alert(`Supplier "${supplierName}" deleted successfully.`);
                    fetchData(currentPage); // Refresh the current page of the table
                } else {
                    throw new Error('Failed to delete supplier');
                }
            })
            .catch(error => {
                console.error('Deletion error:', error);
                alert('An error occurred while trying to delete the supplier.');
            });
        }
    }


    // --- Form Submission (Add/Edit Logic) ---

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        saveButton.disabled = true;
        const isEditing = form.querySelector('input[name="_method"]')?.value === 'PUT';
        saveButton.innerHTML = `<i class="fa-solid fa-spinner fa-spin mr-2"></i> ${isEditing ? 'Updating...' : 'Saving...'}`;

        const formData = new FormData(form);
        const alertsContainer = document.getElementById("formAlerts");
        alertsContainer.innerHTML = ''; 

        fetch(form.action, {
            method: 'POST', // Always POST for Laravel forms/method spoofing
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            saveButton.disabled = false;
            saveButton.innerHTML = 'Save Supplier';
            return response.json().then(data => ({
                status: response.status,
                body: data
            }));
        })
        .then(({ status, body }) => {
            if (status === 201) { // Successfully Created (Add)
                alertsContainer.innerHTML = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-3 rounded-lg" role="alert">Supplier added successfully!</div>';
                
                setTimeout(() => {
                    closeModal();
                    fetchData(1); // Refresh table and reset to page 1
                }, 1000); 

            } else if (status === 200 && isEditing) { // Successfully Updated (Edit)
                alertsContainer.innerHTML = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-3 rounded-lg" role="alert">Supplier updated successfully!</div>';
                
                setTimeout(() => {
                    closeModal();
                    fetchData(currentPage); // Refresh current page
                }, 1000); 

            } else if (status === 422) { // Validation Errors
                let errorsHtml = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-3 rounded-lg"><ul class="list-disc ml-5 space-y-1">';
                for (const key in body.errors) {
                    body.errors[key].forEach(error => {
                        errorsHtml += `<li>${error}</li>`;
                    });
                }
                errorsHtml += '</ul></div>';
                alertsContainer.innerHTML = errorsHtml;

            } else { // Other Errors
                alertsContainer.innerHTML = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-3 rounded-lg" role="alert">An unexpected error occurred. Please try again.</div>';
            }
        })
        .catch(error => {
            console.error('Submission error:', error);
            saveButton.disabled = false;
            saveButton.innerHTML = 'Save Supplier';
            alertsContainer.innerHTML = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-3 rounded-lg" role="alert">Network error. Check your connection.</div>';
        });
    });

</script>
@endpush