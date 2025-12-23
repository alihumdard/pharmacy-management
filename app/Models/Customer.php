<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone_number',
        'email',
        'address',
        'credit_balance',
        'total_purchases', // Added for completeness, usually updated separately
    ];

    // Optional: Cast credit_balance to float
    protected $casts = [
        'credit_balance' => 'float',
    ];

    public function sales() {
    return $this->hasMany(Sale::class)->orderBy('sale_date', 'desc');
}
}