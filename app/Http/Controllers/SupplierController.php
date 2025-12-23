<?php
namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Schema;

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
    public function getHistory(Supplier $supplier)
    {
        try {
            // 1. Fetch Purchases
            $purchases = PurchaseOrder::where('supplier_name', $supplier->supplier_name)
                ->select('po_number as reference', 'total_amount as amount', DB::raw("'credit' as type"), 'order_date as date')
                ->get()
                ->map(function ($item) {
                    $item->category = 'Purchase';
                    return $item;
                });

            // 2. Fetch Manual Payments (Using optional check for table existence)
            $payments = collect();
            if (Schema::hasTable('supplier_manual_logs')) {
                $payments = DB::table('supplier_manual_logs')
                    ->where('supplier_id', $supplier->id)
                    ->select('reference_no as reference', 'amount', 'type', 'created_at as date')
                    ->get()
                    ->map(function ($item) {
                        $item->category = 'Manual';
                        return $item;
                    });
            }

            return response()->json([
                'success'  => true,
                'supplier' => [
                    'supplier_name' => $supplier->supplier_name,
                    'phone_number'  => $supplier->phone_number,
                    'balance_due'   => $supplier->balance_due,
                ],
                'history'  => $purchases->concat($payments)->sortByDesc('date')->values(),
            ]);
        } catch (\Exception $e) {
            \Log::error("Supplier Ledger Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Record a manual Debit (Payment Sent) or Credit (Debt Added).
     */
    public function recordPayment(Request $request, Supplier $supplier)
    {
        $request->validate([
            'type'   => 'required|in:debit,credit', // debit = payment sent to supplier, credit = new debt
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            if ($request->type === 'debit') {
                // Payment sent: Reduce balance due
                $supplier->decrement('balance_due', $request->amount);
            } else {
                // New debt: Increase balance due
                $supplier->increment('balance_due', $request->amount);
            }

            // Log entry (Ensure 'supplier_manual_logs' table exists)
            DB::table('supplier_manual_logs')->insert([
                'supplier_id'  => $supplier->id,
                'reference_no' => 'SPAY-' . strtoupper(uniqid()),
                'amount'       => $request->amount,
                'type'         => $request->type,
                'created_at'   => now(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Ledger updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update ledger.'], 500);
        }
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
            'data'  => $suppliers->items(),
            'links' => [
                'current_page'  => $suppliers->currentPage(),
                'last_page'     => $suppliers->lastPage(),
                'total'         => $suppliers->total(),
                'from'          => $suppliers->firstItem(),
                'to'            => $suppliers->lastItem(),
                'prev_page_url' => $suppliers->previousPageUrl(),
                'next_page_url' => $suppliers->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
  /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Supplier Name unique hona chahiye
            'supplier_name' => 'required|string|max:255|unique:suppliers,supplier_name',
            'contact_person' => 'nullable|string|max:255',
            // Phone Number unique hona chahiye
            'phone_number' => 'required|string|max:20|unique:suppliers,phone_number',
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
     * Update the specified resource.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            // Unique check magar current ID ko ignore karte hue (Edit ke liye zaroori hai)
            'supplier_name' => 'required|string|max:255|unique:suppliers,supplier_name,' . $supplier->id,
            'contact_person' => 'nullable|string|max:255',
            'phone_number' => 'required|string|max:20|unique:suppliers,phone_number,' . $supplier->id,
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
     * Show the specified resource for editing (used for AJAX data fetching).
     */
    public function edit(Supplier $supplier)
    {
        return response()->json($supplier);
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
            'message' => "Supplier '{$supplierName}' deleted successfully.",
        ], 200);
    }
}
