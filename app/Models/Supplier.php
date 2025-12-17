<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supplier_name',
        'contact_person',
        'phone_number',
        'email',
        'balance_due',
        'address',
    ];

    /**
     * Casting for the balance_due field
     *
     * @var array<string, string>
     */
    protected $casts = [
        'balance_due' => 'decimal:2',
    ];
}