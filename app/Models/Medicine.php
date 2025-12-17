<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    protected $fillable = ['name', 'generic_name', 'category', 'manufacturer', 'description'];

    public function variants(): HasMany
    {
        return $this->hasMany(MedicineVariant::class);
    }
}