<?php
namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'supplier' => 'required',
            'date'     => 'required|date',
            'products' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            // 1. Create the Purchase Order
            $po = PurchaseOrder::create([
                'po_number'     => 'PO-' . strtoupper(uniqid()),
                'supplier_name' => $request->supplier,
                'order_date'    => $request->date,
                'status'        => $request->status ?? 'Draft',
                'total_amount'  => $request->total_amount,
            ]);

            foreach ($request->products as $productData) {
                // 2. Add New Medicine to the main Database if it doesn't exist
                $medicine = \App\Models\Medicine::firstOrCreate(
                    ['name' => $productData['name']],
                    [
                        'manufacturer' => $productData['manufacturer'] ?? 'Unknown',
                        'category'     => $productData['category'] ?? 'General',
                    ]
                );

                // 3. Link product to this specific Purchase Order
                $item = $po->items()->create([
                    'product_name' => $medicine->name,
                    'manufacturer' => $medicine->manufacturer,
                ]);

                foreach ($productData['variants'] as $v) {
                    // 4. Add New Variant (SKU) to the main Database if it doesn't exist
                    \App\Models\MedicineVariant::firstOrCreate(
                        ['sku' => $v['sku']],
                        ['medicine_id' => $medicine->id, 'purchase_price' => $v['tp'] ?? 0]
                    );

                    // 5. Save the Variant details for this specific PO
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
            return response()->json(['success' => true, 'message' => 'PO and New Medicines saved!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Edit: Order ka data JSON format mein bhejne ke liye
public function edit($id)
{
    $order = PurchaseOrder::with(['items.variants'])->findOrFail($id);
    return response()->json($order);
}

// Update: Modified data ko save karne ke liye
public function update(Request $request, $id)
{
    $request->validate([
        'supplier' => 'required',
        'date' => 'required|date',
        'products' => 'required|array|min:1'
    ]);

    try {
        DB::beginTransaction();

        $po = PurchaseOrder::findOrFail($id);
        $po->update([
            'supplier_name' => $request->supplier,
            'order_date'    => $request->date,
            'status'        => $request->status,
            'total_amount'  => $request->total_amount,
        ]);

        // Purane items delete karke naye add karna sabse safe approach hai
        $po->items()->delete(); 

        foreach ($request->products as $productData) {
            $medicine = \App\Models\Medicine::firstOrCreate(
                ['name' => $productData['name']],
                ['manufacturer' => $productData['manufacturer'] ?? 'Unknown', 'category' => $productData['category'] ?? 'General']
            );

            $item = $po->items()->create([
                'product_name' => $medicine->name,
                'manufacturer' => $medicine->manufacturer,
            ]);

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
        return response()->json(['success' => true, 'message' => 'PO Updated Successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->delete();
        return response()->json(['success' => true]);
    }
}
