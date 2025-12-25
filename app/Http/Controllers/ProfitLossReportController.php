<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitLossReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get Filter Inputs (Defaults: Start of month to Today)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());

        // 2. Fetch sales with items - FIX: Use whereDate to include current date records fully
        $sales = Sale::with(['items.medicineVariant'])
            ->whereDate('sale_date', '>=', $startDate)
            ->whereDate('sale_date', '<=', $endDate)
            ->get();

        $totalRevenue = 0;
        $totalCost = 0;
        $totalServiceCharges = 0;

        foreach ($sales as $sale) {
            $totalRevenue += $sale->total_amount;
            $totalServiceCharges += $sale->service_charges ?? 0;
            
            foreach ($sale->items as $item) {
                // Cost = Quantity Sold * Purchase Price
                $totalCost += ($item->quantity * ($item->medicineVariant->purchase_price ?? 0));
            }
        }

        $grossProfit = $totalRevenue - $totalCost;
        $profitMargin = $totalRevenue > 0 ? ($grossProfit / $totalRevenue) * 100 : 0;

        // 3. Grouping data for the Profit Trend Chart
        $chartData = $sales->groupBy(function($date) {
            return Carbon::parse($date->sale_date)->format('d M');
        })->map(function ($day) {
            $revenue = $day->sum('total_amount');
            $cost = $day->sum(function($s) {
                return $s->items->sum(fn($i) => $i->quantity * ($i->medicineVariant->purchase_price ?? 0));
            });
            return $revenue - $cost;
        });

        // FIX: Ensure chart shows data in chronological order (purani date se nayi date)
        $chartData = $chartData->reverse(); 

        return view('pages.reports.profit_loss', compact(
            'totalRevenue',
            'totalCost',
            'grossProfit',
            'profitMargin',
            'totalServiceCharges',
            'startDate',
            'endDate',
            'chartData'
        ));
    }
}