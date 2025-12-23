<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'pharmacy_name', 'user_name', 'phone_number', 
        'email', 'tax_id', 'address', 'logo', 'currency', 'tax_rate'
    ];
}