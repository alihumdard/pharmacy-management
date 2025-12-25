<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicineVariant::with('medicine');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('sku', 'like', "%$s%")
                ->orWhere('batch_no', 'like', "%$s%")
                ->orWhereHas('medicine', function ($q) use ($s) {
                    $q->where('name', 'like', "%$s%")
                        ->orWhere('manufacturer', 'like', "%$s%");
                });
        }

        $variants = $query->latest()->paginate(10);

        // Dropdown ke liye saari medicines aur unke variants fetch karein
        $allMedicines = Medicine::with('variants')->get();

        return view('pages.inventory', compact('variants', 'allMedicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'variants'       => 'required|array|min:1',
            'variants.*.sku' => 'required|unique:medicine_variants,sku',
        ]);

        try {
            DB::beginTransaction();

            $medicine = Medicine::create($request->only([
                'name', 'generic_name', 'category', 'manufacturer',
            ]));

            foreach ($request->variants as $variantData) {
                $medicine->variants()->create($variantData);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Product added successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * UPDATE FUNCTIONALITY
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'sku'        => 'required|unique:medicine_variants,sku,' . $id,
            'sale_price' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $variant = MedicineVariant::findOrFail($id);

            // Medicine name update karein
            $variant->medicine->update([
                'name'         => $request->name,
                'manufacturer' => $request->manufacturer,
            ]);

            // Variant details update karein
            $variant->update([
                'sku'            => $request->sku,
                'batch_no'       => $request->batch_no,
                // Yahan default value 0 set ki hai agar request khali ho
                'purchase_price' => $request->purchase_price ?? 0,
                'sale_price'     => $request->sale_price,
                'stock_level'    => $request->stock_level ?? 0,
                'expiry_date'    => $request->expiry_date,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Inventory item updated successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * DELETE FUNCTIONALITY
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $variant  = MedicineVariant::findOrFail($id);
            $medicine = $variant->medicine;

            // Delete the variant
            $variant->delete();

            // Optional: If this was the last variant, delete the medicine record too
            if ($medicine->variants()->count() === 0) {
                $medicine->delete();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Item deleted successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to delete item.'], 500);
        }
    }
}
