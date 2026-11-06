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
        public function isLowStock(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->quantity <= 0) return 'Out of Stock';
        if ($this->quantity <= $this->reorder_level) return 'Low Stock';
        return 'In Stock';
    }
}