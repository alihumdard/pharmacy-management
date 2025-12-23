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

        // Stock check: Sirf wo products dikhayein jo stock mein hain
        $products = MedicineVariant::with('medicine')
            ->where('stock_level', '>', 0) 
            ->get();

        return view('pages.pos', compact('customers', 'products'));
    }

    public function searchProducts(Request $request)
{
    try {
        $search = $request->get('search');
        
        $products = MedicineVariant::with('medicine')
            ->where('stock_level', '>', 0)
            ->where(function($q) use ($search) {
                if (!empty($search)) {
                    $q->where('sku', 'like', "%{$search}%")
                      ->orWhereHas('medicine', function($mq) use ($search) {
                          $mq->where('name', 'like', "%{$search}%");
                      });
                }
            })
            ->latest()
            ->paginate(12); // AJAX pagination ke liye paginate zaroori hai

        return response()->json($products);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
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

            // 1. Calculations
            $subtotal = $request->subtotal;
            $discount = $request->discount ?? 0;
            $serviceCharges = $request->service_charges ?? 0;
            $totalAmount = $request->total_amount;
            $cashReceived = $request->cash_received ?? 0;

            // Debt (Udhaar) calculation
            $remainingDebt = $totalAmount - $cashReceived;
            if ($remainingDebt < 0) $remainingDebt = 0;

            // 2. Unique Invoice Number Generate Karein
            $invoiceNumber = 'INV-' . strtoupper(uniqid());

            // 3. Create the Sale record
            // Note: Make sure invoice_number, subtotal, discount, service_charges, cash_received are in Sale Model $fillable
            $sale = Sale::create([
                'invoice_number'  => $invoiceNumber,
                'customer_id'     => $request->customer_id === 'walkin' ? null : $request->customer_id,
                'subtotal'        => $subtotal,
                'discount'        => $discount,
                'service_charges' => $serviceCharges,
                'total_amount'    => $totalAmount,
                'cash_received'   => $cashReceived,
                'payment_method'  => $request->payment_method,
                'sale_date'       => now(),
                'status'          => ($remainingDebt > 0) ? 'Partial' : 'Completed',
            ]);

            // 4. Process Items & Deduct Stock
            foreach ($request->items as $item) {
                $variant = MedicineVariant::findOrFail($item['variant_id']);

                if ($variant->stock_level < $item['quantity']) {
                    throw new \Exception("Insufficient stock for SKU: {$variant->sku}");
                }

                // Stock decrement karein
                $variant->decrement('stock_level', $item['quantity']);

                // Sale Item record karein
                SaleItem::create([
                    'sale_id'             => $sale->id,
                    'medicine_variant_id' => $variant->id,
                    'quantity'            => $item['quantity'],
                    'unit_price'          => $variant->sale_price,
                    'total_price'         => $item['quantity'] * $variant->sale_price,
                ]);
            }

            // 5. Update Customer Ledger (Agar registered customer hai)
            if ($request->customer_id !== 'walkin') {
                $customer = Customer::findOrFail($request->customer_id);
                
                // Total purchases record barhao
                $customer->increment('total_purchases', $totalAmount);

                // Agar customer ne payment puri nahi ki to balance update karein
                if ($remainingDebt > 0) {
                    $customer->increment('credit_balance', $remainingDebt);

                    // Manual Log entry (Description column hata diya hai error ki wajah se)
                    DB::table('customer_manual_logs')->insert([
                        'customer_id'  => $customer->id,
                        'reference_no' => $invoiceNumber,
                        'amount'       => $remainingDebt,
                        'type'         => 'credit', // Udhaar record
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => "Sale Completed Successfully! Invoice: {$invoiceNumber}",
                'invoice' => $invoiceNumber
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => 'Processing Error: ' . $e->getMessage()
            ], 500);
        }
    }
}