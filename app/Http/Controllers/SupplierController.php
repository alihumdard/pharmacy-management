<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource (Initial view load).
     */
    public function index()
    {
        $suppliers = null; // Initialize to null

        try {
            // Attempt to fetch data
            $suppliers = Supplier::orderBy('supplier_name')->paginate(10);
        } catch (QueryException $e) {
            // Log the error for debugging.
            // When $suppliers remains null, the Blade file displays: "Error: Supplier data failed to load."
            \Log::error('Database error loading suppliers on index page: ' . $e->getMessage());
        }
        
        return view('pages.supplier', compact('suppliers')); 
    }

    /**
     * Dynamic fetching of suppliers for AJAX/filtering/search.
     */
    public function getSuppliers(Request $request)
    {
        // ... (query logic remains the same)
        $query = Supplier::orderBy('supplier_name');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('supplier_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }
        
        if ($balance_filter = $request->get('balance_filter')) {
            if ($balance_filter === 'due') {
                $query->where('balance_due', '>', 0);
            } elseif ($balance_filter === 'paid') {
                $query->where('balance_due', '=', 0);
            }
        }

        $suppliers = $query->paginate(10);
        
        // Returns JSON data for JS to render
        return response()->json([
            'data' => $suppliers->items(),
            'links' => [
                'current_page' => $suppliers->currentPage(),
                'last_page' => $suppliers->lastPage(),
                'total' => $suppliers->total(),
                'from' => $suppliers->firstItem(),
                'to' => $suppliers->lastItem(),
                'prev_page_url' => $suppliers->previousPageUrl(),
                'next_page_url' => $suppliers->nextPageUrl(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_name' => 'required|string|max:255|unique:suppliers,supplier_name',
            'contact_person' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'balance_due' => 'nullable|numeric|min:0',
        ]);

        $supplier = Supplier::create($validatedData);

        return response()->json([
            'success' => true, 
            'message' => 'Supplier added successfully!',
            'supplier' => $supplier
        ], 201);
    }

    /**
     * Show the specified resource for editing (used for AJAX data fetching).
     */
    public function edit(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            // Enforce unique name while ignoring the current supplier's ID
            'supplier_name' => 'required|string|max:255|unique:suppliers,supplier_name,' . $supplier->id,
            'contact_person' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'balance_due' => 'nullable|numeric|min:0',
        ]);

        $supplier->update($validatedData);

        return response()->json([
            'success' => true, 
            'message' => 'Supplier updated successfully!',
            'supplier' => $supplier
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplierName = $supplier->supplier_name;
        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => "Supplier '{$supplierName}' deleted successfully."
        ], 200);
    }
}