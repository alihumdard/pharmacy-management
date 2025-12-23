<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'medicine_variant_id',
        'quantity',
        'unit_price'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function variant()
    {
        return $this->belongsTo(MedicineVariant::class, 'medicine_variant_id');
    }

    public function medicineVariant()
    {
        // Check karein ke foreign key 'medicine_variant_id' hi hai
        return $this->belongsTo(MedicineVariant::class, 'medicine_variant_id');
    }
}