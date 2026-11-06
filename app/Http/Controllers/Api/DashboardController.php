<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_products' => Product::count(),
            'low_stock' => Product::whereColumn('quantity', '<=', 'reorder_level')->count(),
            'out_of_stock' => Product::where('quantity', '<=', 0)->count(),
            'total_value' => Product::sum(DB::raw('quantity * price')),
            'recent_transactions' => InventoryTransaction::with('product')->recent()->take(5)->get()
        ]);
    }

    // Added for Part 7, Step 1
    public function lowStock()
    {
        return response()->json(Product::whereColumn('quantity', '<=', 'reorder_level')->get());
    }

    // Added for Part 7, Step 1
    public function recentTransactions()
    {
        return response()->json(InventoryTransaction::with('product')->recent()->take(10)->get());
    }
}   