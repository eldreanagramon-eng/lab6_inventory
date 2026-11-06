<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryTransactionObserver
{
    /**
     * Handle the InventoryTransaction "created" event.
     */
    public function created(InventoryTransaction $transaction): void
    {
        // We use a database transaction to ensure data integrity
        DB::transaction(function () use ($transaction) {
            
            $product = Product::findOrFail($transaction->product_id);
            $newQuantity = $product->quantity;

            if ($transaction->type === 'stock_in') {
                $newQuantity += $transaction->quantity;
            } elseif ($transaction->type === 'stock_out') {
                // Check for sufficient stock
                if ($product->quantity < $transaction->quantity) {
                    throw new Exception("Not enough stock available for this transaction.");
                }
                $newQuantity -= $transaction->quantity;
            } elseif ($transaction->type === 'adjustment') {
                // Adjustments can be positive or negative depending on how you save them
                // For this lab, we will assume adjustment quantity is the difference
                $newQuantity += $transaction->quantity;
            }

            // Update the product
            $product->update(['quantity' => $newQuantity]);
                        // Check if the product is now low on stock
            if ($product->quantity <= $product->reorder_level) {
                // Send to all users (for this lab, we send to everyone)
                $users = User::all();
                Notification::send($users, new LowStockNotification($product));
            }
        });
    }
}