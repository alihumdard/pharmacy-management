<?php

namespace App\Http\Controllers;

use App\Models\MedicineVariant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MedicineReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get Filter Inputs
        $stockStatus = $request->input('stock_status'); // 'low', 'out', 'expired'

        // 2. Build Query
        $query = MedicineVariant::with('medicine');

        if ($stockStatus == 'low') {
            $query->whereColumn('stock_level', '<=', 'reorder_level')->where('stock_level', '>', 0);
        } elseif ($stockStatus == 'out') {
            $query->where('stock_level', '<=', 0);
        } elseif ($stockStatus == 'expired') {
            $query->where('expiry_date', '<', Carbon::now());
        }

        $variants = $query->latest()->get();

        // 3. Calculate Summary Cards
        $totalStockValue = $variants->sum(function($v) {
            return $v->stock_level * $v->purchase_price;
        });
        
        $potentialRevenue = $variants->sum(function($v) {
            return $v->stock_level * $v->sale_price;
        });

        $lowStockCount = MedicineVariant::whereColumn('stock_level', '<=', 'reorder_level')->count();
        $expiredCount = MedicineVariant::where('expiry_date', '<', Carbon::now())->count();

        return view('pages.reports.medicine', compact(
            'variants',
            'totalStockValue',
            'potentialRevenue',
            'lowStockCount',
            'expiredCount'
        ));
    }
}