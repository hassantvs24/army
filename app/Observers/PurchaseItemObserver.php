<?php

namespace App\Observers;

use App\PurchaseItem;
use App\StockTransaction;
use Illuminate\Support\Facades\Auth;

class PurchaseItemObserver
{
    /**
     * Handle the purchase item "created" event.
     *
     * @param  \App\PurchaseItem  $purchaseItem
     * @return void
     */
    public function created(PurchaseItem $purchaseItem)
    {
        if($purchaseItem->quantity > 0){
            $stockTransaction = new StockTransaction();
            $stockTransaction->transaction_point = 'Purchase';
            $stockTransaction->transaction_type = 'IN';
            $stockTransaction->sku = $purchaseItem->sku;
            $stockTransaction->name = $purchaseItem->name;
            $stockTransaction->unit = $purchaseItem->unit;
            $stockTransaction->status = $purchaseItem->status;
            $stockTransaction->quantity =  $purchaseItem->quantity;
            $stockTransaction->amount = $purchaseItem->amount;
            $stockTransaction->products_id = $purchaseItem->products_id;
            $stockTransaction->purchase_items_id = $purchaseItem->id;
            $stockTransaction->warehouses_id = $purchaseItem->warehouses_id ??  Auth::user()->warehouses_id;
            $stockTransaction->created_at = $purchaseItem->created_at;
            $stockTransaction->save();
        }

    }

    /**
     * Handle the purchase item "updated" event.
     *
     * @param  \App\PurchaseItem  $purchaseItem
     * @return void
     */
    public function updated(PurchaseItem $purchaseItem)
    {
        if($purchaseItem->quantity > 0) {
            StockTransaction::where('purchase_items_id', $purchaseItem->id)->where('transaction_point', 'Purchase')->update([
                'sku' => $purchaseItem->sku,
                'name' => $purchaseItem->name,
                'unit' => $purchaseItem->unit,
                'products_id' => $purchaseItem->products_id,
                'quantity' => $purchaseItem->quantity,
                'amount' => $purchaseItem->amount,
                'status' => $purchaseItem->status,
                'warehouses_id' => $purchaseItem->warehouses_id ??  Auth::user()->warehouses_id,
                'created_at' => $purchaseItem->created_at
            ]);
        }else{
            StockTransaction::where('purchase_items_id', $purchaseItem->id)->where('transaction_point', 'Purchase')->forceDelete();
        }
    }

    /**
     * Handle the purchase item "deleted" event.
     *
     * @param  \App\PurchaseItem  $purchaseItem
     * @return void
     */
    public function deleted(PurchaseItem $purchaseItem)
    {
        StockTransaction::where('purchase_items_id', $purchaseItem->id)->where('transaction_point', 'Purchase')->delete();
    }

    /**
     * Handle the purchase item "restored" event.
     *
     * @param  \App\PurchaseItem  $purchaseItem
     * @return void
     */
    public function restored(PurchaseItem $purchaseItem)
    {
        StockTransaction::onlyTrashed()->where('purchase_items_id', $purchaseItem->id)->where('transaction_point', 'Purchase')->restore();
    }

    /**
     * Handle the purchase item "force deleted" event.
     *
     * @param  \App\PurchaseItem  $purchaseItem
     * @return void
     */
    public function forceDeleted(PurchaseItem $purchaseItem)
    {
        StockTransaction::where('purchase_items_id', $purchaseItem->id)->where('transaction_point', 'Purchase')->forceDelete();
    }
}
