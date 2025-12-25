<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get Filter Inputs (Defaults: Start of month to Today)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $status = $request->input('status');

        // 2. Build Query
        $query = Sale::with(['customer', 'items.medicineVariant.medicine']);

        // FIX: Use whereDate to ignore time or adjust the end_date to end of day
        if ($startDate && $endDate) {
            $query->whereDate('sale_date', '>=', $startDate)
                  ->whereDate('sale_date', '<=', $endDate);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // 3. Get Results
        $sales = $query->latest('sale_date')->get();

        // 4. Calculate Summary Cards
        $totalRevenue = $sales->sum('total_amount');
        $totalSalesCount = $sales->count();
        $cashReceived = $sales->sum('cash_received');
        $remainingDebt = $totalRevenue - $cashReceived;

        // 5. Grouped Data for Charts (Daily Revenue)
        $chartData = $sales->groupBy(function($date) {
            return Carbon::parse($date->sale_date)->format('d M');
        })->map(function ($day) {
            return $day->sum('total_amount');
        })->reverse(); // Timeline ko seedha karne ke liye (Old to New)

        return view('pages.reports.sales', compact(
            'sales', 
            'totalRevenue', 
            'totalSalesCount', 
            'cashReceived', 
            'remainingDebt',
            'startDate',
            'endDate',
            'chartData'
        ));
    }
}