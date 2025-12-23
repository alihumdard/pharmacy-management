<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get Filter Inputs
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->toDateString());
        $status = $request->input('status');

        // 2. Build Query
        $query = Sale::with(['customer', 'items.medicineVariant.medicine'])
            ->whereBetween('sale_date', [$startDate, $endDate]);

        if ($status) {
            $query->where('status', $status);
        }

        $sales = $query->latest('sale_date')->get();

        // 3. Calculate Summary Cards
        $totalRevenue = $sales->sum('total_amount');
        $totalSalesCount = $sales->count();
        $cashReceived = $sales->sum('cash_received');
        $remainingDebt = $totalRevenue - $cashReceived;

        // 4. Grouped Data for Charts (Daily Revenue)
        $chartData = $sales->groupBy(function($date) {
            return Carbon::parse($date->sale_date)->format('d M');
        })->map(function ($day) {
            return $day->sum('total_amount');
        });

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