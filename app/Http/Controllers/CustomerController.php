<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Log;
// Use Log facade for error logging

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource (Initial view load).
     */
    public function index()
    {
        $customers = null;
        try {
            // Fetch initial paged data for Blade rendering
            $customers = Customer::orderBy('customer_name')->paginate(10);
        } catch (QueryException $e) {
            Log::error('Database error loading customers on index page: ' . $e->getMessage());
            // $customers remains null, triggering the error message in Blade.
        }

        // Ensure your view file is named 'pages.customer' or adjust the return
        return view('pages.customers', compact('customers'));
    }
public function getHistory(Customer $customer)
{
    try {
        // 1. POS Sales fetch karein
        $sales = Sale::where('customer_id', $customer->id)
            ->select('invoice_number as reference', 'total_amount as amount', 'payment_method as type', 'sale_date as date')
            ->get()
            ->map(function($item) {
                $item->category = 'Sale'; 
                return $item;
            });

        // 2. Manual Payments/Logs fetch karein
        $payments = DB::table('customer_manual_logs') 
            ->where('customer_id', $customer->id)
            ->select('reference_no as reference', 'amount', 'type', 'created_at as date')
            ->get()
            ->map(function($item) {
                $item->category = 'Manual'; 
                return $item;
            });

        // 3. Dono ko merge aur date ke mutabiq sort karein
        $combinedHistory = $sales->concat($payments)->sortByDesc('date')->values();
        
        return response()->json([
            'success' => true,
            'customer' => $customer,
            'history' => $combinedHistory
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Ledger failed to load.'], 500);
    }
}
    /**
     * Record manual ledger entry (from the 'Update Ledger' button)
     */
    public function recordPayment(Request $request, Customer $customer)
    {
        $request->validate([
            'type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update customer balance
            if ($request->type === 'debit') {
                $customer->decrement('credit_balance', $request->amount);
            } else {
                $customer->increment('credit_balance', $request->amount);
            }

            // 2. Log entry for history (ensure table 'customer_manual_logs' exists)
            DB::table('customer_manual_logs')->insert([
                'customer_id' => $customer->id,
                'reference_no' => 'PAY-' . strtoupper(uniqid()),
                'amount' => $request->amount,
                'type' => $request->type,
                'created_at' => now(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Ledger updated.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Database Error.'], 500);
        }
    }
    /**
     * Dynamic fetching of customers for AJAX/filtering/search.
     */
    public function getCustomers(Request $request)
    {
        $query = Customer::orderBy('customer_name');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        if ($credit_filter = $request->get('credit_filter')) {
            if ($credit_filter === 'due') {
                // Assuming positive balance means customer owes money (Credit Balance > 0)
                $query->where('credit_balance', '>', 0);
            } elseif ($credit_filter === 'paid') {
                // Assuming zero balance means cleared debt
                $query->where('credit_balance', '=', 0);
            }
        }

        $customers = $query->paginate(10);

        // Returns JSON data for JS to render
        return response()->json([
            'data'  => $customers->items(),
            'links' => [
                'current_page'  => $customers->currentPage(),
                'last_page'     => $customers->lastPage(),
                'total'         => $customers->total(),
                'from'          => $customers->firstItem(),
                'to'            => $customers->lastItem(),
                'prev_page_url' => $customers->previousPageUrl(),
                'next_page_url' => $customers->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'phone_number'   => 'required|string|max:20|unique:customers,phone_number',
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string',
            'credit_balance' => 'nullable|numeric',
        ]);

        $customer = Customer::create(array_merge($validatedData, [
            'total_purchases' => 0, // Initialize total purchases
        ]));

        return response()->json([
            'success'  => true,
            'message'  => 'Customer added successfully!',
            'customer' => $customer,
        ], 201);
    }

    /**
     * Show the specified resource for editing (AJAX endpoint).
     */
    public function edit(Customer $customer)
    {
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'customer_name'  => 'required|string|max:255',
            // Unique check excluding the current customer's ID
            'phone_number'   => 'required|string|max:20|unique:customers,phone_number,' . $customer->id,
            'email'          => 'nullable|email|max:255',
            'address'        => 'nullable|string',
            'credit_balance' => 'nullable|numeric',
        ]);

        $customer->update($validatedData);

        return response()->json([
            'success'  => true,
            'message'  => 'Customer updated successfully!',
            'customer' => $customer,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customerName = $customer->customer_name;
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => "Customer '{$customerName}' deleted successfully.",
        ]);
    }
}
