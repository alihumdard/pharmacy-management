<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseOrderController extends Controller
{
  public function index()
{
    // Agar column ka naam 'name' nahi hai to sirf latest() use karein
    // Ya phir check karein ke apki table mein column ka sahi naam kya hai
    $suppliers = \App\Models\Supplier::latest()->get(); 
    
    // Baki code wahi rahega
    $orders = PurchaseOrder::with(['items.variants'])->latest()->get();
    
    return view('pages.purchases', compact('orders', 'suppliers'));
}
    public function store(Request $request)
    {
        // Validation (Optional but recommended)
        $request->validate([
            'supplier' => 'required',
            'date' => 'required|date',
            'products' => 'required|array|min:1'
        ]);

        try {
            DB::beginTransaction();

            // 1. Create Main Purchase Order
            $po = PurchaseOrder::create([
                'po_number'     => 'PO-' . strtoupper(uniqid()),
                'supplier_name' => $request->supplier,
                'order_date'    => $request->date,
                'status'        => $request->status ?? 'Draft',
                'total_amount'  => $request->total_amount,
            ]);

            // 2. Loop through each Product
            foreach ($request->products as $productData) {
                $item = $po->items()->create([
                    'product_name' => $productData['name'],
                    'manufacturer' => $productData['manufacturer'] ?? null,
                ]);

                // 3. Loop through each Variant of the product
                foreach ($productData['variants'] as $v) {
                    $item->variants()->create([
                        'sku'            => $v['sku'],
                        'batch_no'       => $v['batch'] ?? null,
                        'expiry_date'    => $v['expiry'] ?? null,
                        'purchase_price' => $v['tp'] ?? 0,
                        'quantity'       => $v['stock'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'PO Created Successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
        }
    }

    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->delete();
        return response()->json(['success' => true]);
    }
}