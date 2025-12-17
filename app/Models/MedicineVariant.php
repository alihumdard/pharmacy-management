<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicineVariant extends Model
{
    protected $fillable = [
        'medicine_id', 'sku', 'strength', 'pack_size', 'barcode', 
        'purchase_price', 'sale_price', 'stock_level', 'reorder_level', 
        'batch_no', 'expiry_date',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}