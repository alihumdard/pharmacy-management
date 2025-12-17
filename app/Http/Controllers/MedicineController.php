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
        // Get variants with parent medicine info
        $query = MedicineVariant::with('medicine');

        // Simple Search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('sku', 'like', "%$s%")
                  ->orWhereHas('medicine', function($q) use ($s) {
                      $q->where('name', 'like', "%$s%")
                        ->orWhere('manufacturer', 'like', "%$s%");
                  });
        }

        $variants = $query->latest()->paginate(10);
        return view('pages.inventory', compact('variants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'variants' => 'required|array|min:1',
            'variants.*.sku' => 'required|unique:medicine_variants,sku',
        ]);

        try {
            DB::beginTransaction();

            $medicine = Medicine::create($request->only([
                'name', 'generic_name', 'category', 'manufacturer', 'description'
            ]));

            foreach ($request->variants as $variantData) {
                $medicine->variants()->create($variantData);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Product added!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}