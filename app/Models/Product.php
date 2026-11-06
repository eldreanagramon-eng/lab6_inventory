<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'reorder_level',
        'price',
    ];

    // A product has many transactions
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}