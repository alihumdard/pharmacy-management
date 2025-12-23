<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Medicine;
use App\Models\MedicineVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        // Medicine ke saath variants load karein taake datalist mein data mil sakay
        $medicines = Medicine::with('variants')->select('id', 'name', 'manufacturer', 'category')->get();
        $orders = PurchaseOrder::with(['items.variants'])->latest()->get();

        return view('pages.purchases', compact('orders', 'suppliers', 'medicines'));
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

            $po = PurchaseOrder::create([
                'po_number'     => 'PO-' . strtoupper(uniqid()),
                'supplier_name' => $request->supplier,
                'order_date'    => $request->date,
                'status'        => $request->status ?? 'Draft',
                'total_amount'  => $request->total_amount,
            ]);

            foreach ($request->products as $productData) {
                $medicine = Medicine::updateOrCreate(
                    ['name' => $productData['name']],
                    [
                        'manufacturer' => $productData['manufacturer'] ?? 'Unknown',
                        'category'     => $productData['category'] ?? 'General',
                    ]
                );

                $item = $po->items()->create([
                    'product_name' => $medicine->name,
                    'manufacturer' => $medicine->manufacturer,
                ]);

                foreach ($productData['variants'] as $v) {
                    // SKU unique check and creation
                    MedicineVariant::firstOrCreate(
                        ['sku' => $v['sku']],
                        ['medicine_id' => $medicine->id, 'purchase_price' => $v['tp'] ?? 0]
                    );

                    // Link batch/qty to this PO with Correct Date Format
                    $item->variants()->create([
                        'sku'            => $v['sku'],
                        'batch_no'       => $v['batch'] ?? null,
                        'expiry_date'    => !empty($v['expiry']) ? Carbon::parse($v['expiry'])->format('Y-m-d') : null,
                        'purchase_price' => $v['tp'] ?? 0,
                        'quantity'       => $v['stock'] ?? 0,
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Purchase Order Saved Successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

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
        
        // 1. Update PO basic info
        $po->update([
            'supplier_name' => $request->supplier,
            'order_date'    => $request->date,
            'status'        => $request->status,
            'total_amount'  => $request->total_amount,
        ]);

        // 2. Purane items aur unke variants delete karne se pehle 
        // Optional: Yahan stock reversal ka logic lag sakta hai agar status 'Completed' tha.
        $po->items()->delete(); 

        foreach ($request->products as $productData) {
            // Medicine create ya update karein
            $medicine = Medicine::updateOrCreate(
                ['name' => $productData['name']],
                [
                    'manufacturer' => $productData['manufacturer'] ?? 'Unknown',
                    'category'     => $productData['category'] ?? 'General'
                ]
            );

            // PO Item create karein
            $item = $po->items()->create([
                'product_name' => $medicine->name,
                'manufacturer' => $medicine->manufacturer,
            ]);

            foreach ($productData['variants'] as $v) {
                // IMPORTANT: Main Inventory (medicine_variants) table mein update/create karein
                // Isse naya variant Database mein show hone lagega.
                $mainVariant = MedicineVariant::updateOrCreate(
                    ['sku' => $v['sku']],
                    [
                        'medicine_id' => $medicine->id,
                        'batch_no' => $v['batch'] ?? null,
                        'purchase_price' => $v['tp'] ?? 0,
                        'expiry_date' => !empty($v['expiry']) ? \Carbon\Carbon::parse($v['expiry'])->format('Y-m-d') : null,
                    ]
                );

                // Agar status 'Completed' hai to stock barha dein
                if ($request->status === 'Completed') {
                    $mainVariant->increment('stock_level', $v['stock']);
                }

                // PO Item Variant (History) create karein
                $item->variants()->create([
                    'sku'            => $v['sku'],
                    'batch_no'       => $v['batch'] ?? null,
                    'expiry_date'    => !empty($v['expiry']) ? \Carbon\Carbon::parse($v['expiry'])->format('Y-m-d') : null,
                    'purchase_price' => $v['tp'] ?? 0,
                    'quantity'       => $v['stock'] ?? 0,
                ]);
            }
        }

        DB::commit();
        return response()->json(['success' => true, 'message' => 'PO and Inventory updated successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    public function edit($id)
    {
        $order = PurchaseOrder::with(['items.variants'])->findOrFail($id);
        return response()->json($order);
    }

    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->delete();
        return response()->json(['success' => true]);
    }
}