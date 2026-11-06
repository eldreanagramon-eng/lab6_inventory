<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Added for the DB::raw in the reports method

class InventoryTransactionController extends Controller
{
    public function index()
    {
        // Paginate 20 items per page, load product and user to prevent N+1 queries
        $transactions = InventoryTransaction::with(['product', 'user'])->recent()->paginate(20);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:stock_in,stock_out,adjustment',
            'quantity' => 'required|integer|min:1',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            // Create the transaction. The Observer will handle the product quantity update.
            InventoryTransaction::create([
                'product_id' => $request->product_id,
                'user_id' => Auth::id(), // The currently logged-in user
                'type' => $request->type,
                'quantity' => $request->quantity,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
            ]);

            return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');

        } catch (\Exception $e) {
            // If the observer throws an error (e.g., not enough stock), catch it here
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(InventoryTransaction $transaction)
    {
        $transaction->load(['product', 'user']);
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(InventoryTransaction $transaction)
    {
        // Note: Deleting a transaction does not automatically reverse the stock in this basic setup.
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted.');
    }

    public function adjustmentForm()
    {
        $products = Product::all();
        return view('transactions.adjustment', compact('products'));
    }

    public function processAdjustment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'physical_count' => 'required|integer|min:0',
            'notes' => 'required|string', // Reason for adjustment
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Calculate the difference (Physical - System)
        $difference = $request->physical_count - $product->quantity;

        // If there is no difference, just redirect back
        if ($difference == 0) {
            return redirect()->route('transactions.index')->with('success', 'No adjustment needed. Counts match.');
        }

        // Create the transaction (Observer will update the product quantity)
        InventoryTransaction::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'type' => 'adjustment',
            'quantity' => $difference, 
            'notes' => $request->notes,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Stock adjusted successfully.');
    }

    // --- ADDED THE REPORTS METHOD HERE ---
    public function reports()
    {
        $lowStockProducts = Product::whereColumn('quantity', '<=', 'reorder_level')->get();
        $totalValue = Product::sum(DB::raw('quantity * price'));
        $recentMovements = InventoryTransaction::with('product')->recent()->take(20)->get();

        return view('transactions.reports', compact('lowStockProducts', 'totalValue', 'recentMovements'));
    }
}