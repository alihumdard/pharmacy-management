@extends('layouts.main')
@section('title', 'Customer Management')

@section('content')
<main class="overflow-y-auto p-4 md:p-8 min-h-[calc(100vh-70px)]">

    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b border-gray-200 pb-3">Customer Accounts Directory</h1>

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 md:p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                {{-- Search Input --}}
                <div class="relative w-full md:w-1/3">
                    <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Search by name or phone number..."
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-100 border border-gray-300 rounded-xl outline-none text-sm text-gray-700 focus:ring-2 focus:ring-blue-400 transition"
                        oninput="debounceFetchData()">
                </div>

                {{-- Filters and Add Button --}}
                <div class="flex items-center gap-3 flex-wrap">

                    {{-- Credit Filter --}}
                    <div class="relative">
                        <select id="creditFilter" onchange="fetchData()"
                            class="appearance-none px-5 py-2.5 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 flex items-center gap-2 shadow-md transition text-sm font-medium text-gray-700 pr-10">
                            <option value="">Credit Filter (All)</option>
                            <option value="due">Credit Due > 0</option>
                            <option value="paid">Credit Due = 0</option>
                        </select>
                        <i class="fa-solid fa-filter text-gray-600 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    {{-- Add New Customer Button (Calls openModalForAdd) --}}
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

                    <tbody id="customersTableBody" class="divide-y divide-gray-200">
                        @if (isset($customers))
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-5 font-semibold text-gray-800">{{ $customer->customer_name }}</td>
                                    <td class="py-4 px-5 text-gray-600 font-medium">{{ $customer->phone_number }}</td>
                                    <td class="py-4 px-5 text-right text-gray-700">{{ number_format($customer->total_purchases) }} Orders</td>
                                    <td class="py-4 px-5 text-right font-extrabold 
                                        @if ($customer->credit_balance > 0) 
                                            text-red-600
                                        @else
                                            text-green-600
                                        @endif">
                                        PKR {{ number_format($customer->credit_balance, 2) }}
                                    </td>
                                    <td class="py-4 px-5 text-center">
                                        <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                                            <i class="fa-solid fa-file-invoice cursor-pointer hover:text-blue-600" title="View History"></i>
                                            <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Customer" onclick="editCustomer({{ $customer->id }})"></i>
                                            <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Customer" onclick="deleteCustomer({{ $customer->id }}, '{{ addslashes($customer->customer_name) }}')"></i>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500 font-medium">No customers found.</td>
                                </tr>
                            @endforelse
                        @else
                            {{-- Fallback if the variable is not set by the layout/route --}}
                            <tr>
                                <td colspan="5" class="py-8 text-center text-red-500 font-medium">Error: Customer data failed to load.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination - Initial Load (Placeholder for completeness) --}}
            <div id="customersPagination" class="mt-6 flex justify-between items-center text-sm text-gray-600">
                @if (isset($customers) && $customers->hasPages())
                    <span>Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} results</span>
                    <div class="flex gap-2">
                        @if ($customers->onFirstPage())
                            <span class="px-3 py-1 border rounded-lg text-gray-400">&larr; Previous</span>
                        @else
                            <a href="{{ $customers->previousPageUrl() }}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">&larr; Previous</a>
                        @endif

                        @if ($customers->hasMorePages())
                            <a href="{{ $customers->nextPageUrl() }}" class="px-3 py-1 border rounded-lg hover:bg-gray-100">Next &rarr;</a>
                        @else
                            <span class="px-3 py-1 border rounded-lg text-gray-400">Next &rarr;</span>
                        @endif
                    </div>
                @elseif (isset($customers))
                    <span>Showing {{ $customers->count() }} results</span>
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


<div id="customerModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50 p-4 transition">

    <div id="customerModalBox"
        class="bg-white w-full max-w-2xl max-h-[90vh] mx-auto overflow-y-auto rounded-2xl shadow-2xl p-6 transform transition-all duration-300">

        <form id="customerForm" action="{{ route('customers.store') }}" method="POST">
            @csrf

            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-3 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-blue-600"></i> Add/Edit Customer Record
            </h2>
            
            <div id="formAlerts" class="mb-4"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="text-sm font-medium text-gray-700">Customer Name <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" required
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone_number" required
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-700">Email <span class="text-gray-500">(Optional)</span></label>
                    <input type="email" name="email"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-700">Address <span class="text-gray-500">(Optional)</span></label>
                    <textarea name="address"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition resize-none"
                        rows="2"></textarea>
                </div>

                <div class="md:col-span-2 border-t pt-4">
                    <label class="text-sm font-medium text-gray-700">Opening/Current Credit Balance (PKR)</label>
                    <input type="number" step="0.01" name="credit_balance" value="0.00"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 outline-none focus:ring focus:ring-blue-300 focus:border-blue-500 transition font-bold text-lg">
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-8 border-t pt-4">
                <button type="button" onclick="closeCustomerModal()"
                    class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-xl font-semibold transition">Cancel</button>

                <button type="submit" id="saveCustomerBtn"
                    class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-xl shadow-md font-semibold transition">
                    Save Customer
                </button>
            </div>
        </form>

    </div>

</div>


@endsection

@push('scripts')

<script>
    const modal = document.getElementById("customerModal");
    const modalBox = document.getElementById("customerModalBox");
    const form = document.getElementById("customerForm");
    const saveButton = document.getElementById("saveCustomerBtn");
    const tableBody = document.getElementById("customersTableBody");
    const paginationContainer = document.getElementById("customersPagination");
    const searchInput = document.getElementById("searchInput");
    const creditFilter = document.getElementById("creditFilter");

    let currentPage = 1;
    let debounceTimer;

    // --- Modal Functions ---

    // **NEW**: Handles resetting the form state (Cleanup without visual closing)
    function resetModalState() {
        form.reset();
        document.querySelector('#customerModal h2').textContent = 'Add/Edit Customer Record';
        form.action = '{{ route('customers.store') }}';
        
        const methodField = form.querySelector('input[name="_method"]');
        if (methodField) {
            methodField.remove(); // Remove the hidden PUT/DELETE field
        }
    }

    // 1. Basic function to open the modal (used by both Add and Edit handlers)
    function openCustomerModal() {
        document.getElementById("formAlerts").innerHTML = '';
        
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        
        // Start transition
        modalBox.classList.remove("scale-95", "opacity-0");
        modalBox.classList.add("scale-100", "opacity-100");
        document.body.style.overflow = 'hidden'; 
    }

    // 2. Function to handle opening the modal for Add operation (called by the button)
    function openModalForAdd() {
        resetModalState(); // 1. Run immediate reset/cleanup
        
        // 2. Set title and action for ADD mode
        document.querySelector('#customerModal h2').textContent = 'Add New Customer Record';
        form.action = '{{ route('customers.store') }}';
        
        openCustomerModal(); // 3. Open the modal visually
        form.querySelector('input[name="customer_name"]').focus(); // 4. Focus
    }

    // 3. Basic function to close the modal
    function closeCustomerModal() {
        // Start transition animation
        modalBox.classList.remove("scale-100", "opacity-100");
        modalBox.classList.add("scale-95", "opacity-0");

        setTimeout(() => {
            // Hide modal and unlock scroll AFTER animation finishes (300ms)
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            document.body.style.overflow = ''; // Unlock scrolling

            // Reset the state AFTER the modal is visually gone
            resetModalState(); 
        }, 300);
    }

    // Add event listener to handle backdrop clicks
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeCustomerModal();
        }
    });

    // --- Data Rendering Functions ---

    // Function to generate a single table row HTML from a customer object
    function generateTableRow(customer) {
        // Ensure credit_balance is treated as a float
        const balance = parseFloat(customer.credit_balance);
        const balanceColor = balance > 0 ? 'text-red-600' : 'text-green-600';
        const formattedBalance = `PKR ${balance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        const escapedName = customer.customer_name.replace(/'/g, "\\'");
        const totalPurchases = `${customer.total_purchases ?? 0} Orders`;

        return `
            <tr class="hover:bg-gray-50 transition" data-customer-id="${customer.id}">
                <td class="py-4 px-5 font-semibold text-gray-800">${customer.customer_name}</td>
                <td class="py-4 px-5 text-gray-600 font-medium">${customer.phone_number}</td>
                <td class="py-4 px-5 text-right text-gray-700">${totalPurchases}</td>
                <td class="py-4 px-5 text-right font-extrabold ${balanceColor}">
                    ${formattedBalance}
                </td>
                <td class="py-4 px-5 text-center">
                    <div class="flex items-center justify-center gap-4 text-gray-500 text-lg">
                        <i class="fa-solid fa-file-invoice cursor-pointer hover:text-blue-600" title="View History"></i>
                        <i class="fa-solid fa-pen-to-square cursor-pointer hover:text-orange-600" title="Edit Customer" onclick="editCustomer(${customer.id})"></i>
                        <i class="fa-solid fa-trash cursor-pointer hover:text-red-600" title="Delete Customer" onclick="deleteCustomer(${customer.id}, '${escapedName}')"></i>
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
            html += `<a href="${links.prev_page_url}" class="px-3 py-1 border rounded-lg hover:bg-gray-100" data-page-url="${links.prev_page_url}">&larr; Previous</a>`;
        } else {
            html += `<span class="px-3 py-1 border rounded-lg text-gray-400">&larr; Previous</span>`;
        }

        // Next Button
        if (links.next_page_url) {
            html += `<a href="${links.next_page_url}" class="px-3 py-1 border rounded-lg hover:bg-gray-100" data-page-url="${links.next_page_url}">Next &rarr;</a>`;
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
        
        currentPage = page;
        const search = searchInput.value;
        const credit_filter = creditFilter.value;
        
        // Show loading state
        tableBody.innerHTML = '<tr><td colspan="5" class="py-8 text-center text-gray-500 font-medium"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading data...</td></tr>';
        paginationContainer.innerHTML = '<span>Loading...</span><div></div>';
        
        const url = `{{ route('customers.fetch') }}?page=${page}&search=${search}&credit_filter=${credit_filter}`;

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            let tableRows = '';
            
            if (data.data && data.data.length > 0) {
                data.data.forEach(customer => {
                    tableRows += generateTableRow(customer);
                });
            } else {
                tableRows = '<tr><td colspan="5" class="py-8 text-center text-gray-500 font-medium">No customers found matching your criteria.</td></tr>';
            }
            
            tableBody.innerHTML = tableRows; 
            paginationContainer.innerHTML = generatePagination(data.links);
            
            attachPaginationListeners(); 
        })
        .catch(error => {
            console.error('Error fetching customers:', error);
            tableBody.innerHTML = '<tr><td colspan="5" class="py-8 text-center text-red-500 font-medium">Failed to load data. Please check your network or server connection.</td></tr>';
            paginationContainer.innerHTML = '<span>Error loading data.</span><div></div>';
        });
    }

    // Attach listeners to dynamically loaded pagination links
    function attachPaginationListeners() {
        document.querySelectorAll('#customersPagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                // Extract page number from the full URL string
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                fetchData(page);
            });
        });
    }

    // Initial load check: If the table body is empty (or has the PHP static examples), trigger an AJAX load on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', () => {
        // If PHP failed to render customers (due to DB error/missing variable), 
        // the table body will contain the specific red error message.
        if (tableBody.querySelector('td.text-red-500')) {
             fetchData(1);
        } else if (tableBody.children.length > 0) {
             // If initial data loaded successfully via PHP, just attach listeners
             attachPaginationListeners(); 
        } else {
             // For safety, assume initial load failed or no data exists and try AJAX load
             fetchData(1);
        }
    });


    // --- Edit/Update Functions ---

    function editCustomer(customerId) {
        // 1. Reset the modal state first to ensure clean form fields
        resetModalState(); 
        
        // 2. Fetch customer data
        fetch(`/customers/${customerId}/edit`, { 
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch customer data.');
            }
            return response.json();
        })
        .then(customer => {
            // 3. Populate Modal Title, Action, and Hidden Method
            document.querySelector('#customerModal h2').textContent = `Edit Customer: ${customer.customer_name}`;
            form.action = `/customers/${customer.id}`;
            
            // Add hidden method field
            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'PUT';
            form.appendChild(methodField);
            
            // 4. Populate form fields (Use querySelector with input name)
            document.querySelector('input[name="customer_name"]').value = customer.customer_name ?? '';
            document.querySelector('input[name="phone_number"]').value = customer.phone_number ?? '';
            document.querySelector('input[name="email"]').value = customer.email ?? '';
            document.querySelector('textarea[name="address"]').value = customer.address ?? '';
            document.querySelector('input[name="credit_balance"]').value = parseFloat(customer.credit_balance).toFixed(2);
            
            // 5. Open Modal
            openCustomerModal();
            document.querySelector('input[name="customer_name"]').focus();
        })
        .catch(error => {
            console.error('Error fetching customer for edit:', error);
            alert('Could not load customer data for editing. Check console for details.');
        });
    }


    // --- Delete Function ---

    function deleteCustomer(customerId, customerName) {
        if (confirm(`Are you sure you want to delete the customer "${customerName}"? This action cannot be undone.`)) {
            
            fetch(`/customers/${customerId}`, { 
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
                    alert(`Customer "${customerName}" deleted successfully.`);
                    fetchData(currentPage); // Refresh the current page of the table
                } else {
                    throw new Error('Failed to delete customer');
                }
            })
            .catch(error => {
                console.error('Deletion error:', error);
                alert('An error occurred while trying to delete the customer.');
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
            saveButton.innerHTML = 'Save Customer';
            return response.json().then(data => ({
                status: response.status,
                body: data
            }));
        })
        .then(({ status, body }) => {
            if (status === 201) { // Successfully Created (Add)
                alertsContainer.innerHTML = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-3 rounded-lg" role="alert">Customer added successfully!</div>';
                
                setTimeout(() => {
                    closeCustomerModal();
                    fetchData(1); // Refresh table and reset to page 1
                }, 1000); 

            } else if (status === 200 && isEditing) { // Successfully Updated (Edit)
                alertsContainer.innerHTML = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-3 rounded-lg" role="alert">Customer updated successfully!</div>';
                
                setTimeout(() => {
                    closeCustomerModal();
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
            saveButton.innerHTML = 'Save Customer';
            alertsContainer.innerHTML = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-3 rounded-lg" role="alert">Network error. Check your connection.</div>';
        });
    });

</script>
@endpush