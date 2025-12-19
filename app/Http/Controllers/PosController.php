<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MedicineVariant;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('customer_name')->get();

        // CHANGED: Use 'stock_level' instead of 'quantity'
        $products = MedicineVariant::with('medicine')
            ->where('stock_level', '>', 0) 
            ->get();

        return view('pages.pos', compact('customers', 'products'));
    }

    public function searchProducts(Request $request)
    {
        $search = $request->get('search');
        
        $products = MedicineVariant::with('medicine')
            ->where('stock_level', '>', 0) // CHANGED: Use 'stock_level'
            ->where(function($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhereHas('medicine', function($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%");
                  });
            })
            ->get();

        return response()->json($products);
    }

   public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'payment_method' => 'required|string',
            'items' => 'required|array|min:1',
            'total_amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create the Sale record
            $sale = Sale::create([
                'invoice_number' => 'INV-' . strtoupper(uniqid()),
                'customer_id' => $request->customer_id === 'walkin' ? null : $request->customer_id,
                'total_amount' => $request->total_amount,
                'payment_method' => $request->payment_method,
                'sale_date' => now(),
            ]);

            // 2. Update Customer Record
            if ($request->customer_id !== 'walkin') {
                $customer = Customer::findOrFail($request->customer_id);
                
                // Increase total purchase count/value
                $customer->increment('total_purchases', $request->total_amount);

                // If it's a credit sale, add to their balance
                if ($request->payment_method === 'credit') {
                    $customer->increment('credit_balance', $request->total_amount);
                }
            }

            // 3. Deduct Stock and Save Items
            foreach ($request->items as $item) {
                $variant = MedicineVariant::findOrFail($item['variant_id']);

                if ($variant->stock_level < $item['quantity']) {
                    throw new \Exception("Insufficient stock for SKU: {$variant->sku}");
                }

                $variant->decrement('stock_level', $item['quantity']);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'medicine_variant_id' => $variant->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $variant->sale_price,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaction saved to customer record!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}