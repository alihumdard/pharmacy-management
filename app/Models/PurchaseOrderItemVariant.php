<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_item_id',
        'sku',
        'batch_no',
        'expiry_date',
        'purchase_price',
        'quantity'
    ];

    /**
     * Get the product item that owns the variant.
     */
    public function productItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'purchase_order_item_id');
    }
}