<?php

namespace App\Observers;

use App\StockAdjustmentItem;
use App\StockTransaction;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentItemObserver
{
    /**
     * Handle the stock adjustment item "created" event.
     *
     * @param  \App\StockAdjustmentItem  $stockAdjustmentItem
     * @return void
     */
    public function created(StockAdjustmentItem $stockAdjustmentItem)
    {
        if($stockAdjustmentItem->quantity > 0){
            $stockTransaction = new StockTransaction();
            $stockTransaction->transaction_point = 'Adjustment';
            $stockTransaction->transaction_type = $stockAdjustmentItem->adjustment_action;
            $stockTransaction->sku = $stockAdjustmentItem->sku;
            $stockTransaction->name = $stockAdjustmentItem->name;
            $stockTransaction->unit = $stockAdjustmentItem->unit;
            $stockTransaction->quantity =  $stockAdjustmentItem->quantity;
            $stockTransaction->amount = $stockAdjustmentItem->amount;
            $stockTransaction->products_id = $stockAdjustmentItem->products_id;
            $stockTransaction->stock_adjustment_items_id = $stockAdjustmentItem->id;
            $stockTransaction->warehouses_id = $stockAdjustmentItem->warehouses_id ?? Auth::user()->warehouses_id;
            $stockTransaction->created_at = $stockAdjustmentItem->created_at;
            $stockTransaction->save();
        }

    }

    /**
     * Handle the stock adjustment item "updated" event.
     *
     * @param  \App\StockAdjustmentItem  $stockAdjustmentItem
     * @return void
     */
    public function updated(StockAdjustmentItem $stockAdjustmentItem)
    {
        if($stockAdjustmentItem->quantity > 0) {
            StockTransaction::where('stock_adjustment_items_id', $stockAdjustmentItem->id)
                ->where('products_id', $stockAdjustmentItem->products_id)
                ->where('transaction_point', 'Adjustment')
                ->update([
                    'transaction_type' => $stockAdjustmentItem->adjustment_action,
                    'sku' => $stockAdjustmentItem->sku,
                    'name' => $stockAdjustmentItem->name,
                    'unit' => $stockAdjustmentItem->unit,
                    'quantity' => $stockAdjustmentItem->quantity,
                    'amount' => $stockAdjustmentItem->amount,
                    'warehouses_id' => $stockAdjustmentItem->warehouses_id ??  Auth::user()->warehouses_id,
                    'created_at' => $stockAdjustmentItem->created_at
                ]);
        }else{
            StockTransaction::where('stock_adjustment_items_id', $stockAdjustmentItem->id)->where('transaction_point', 'Adjustment')->forceDelete();
        }
    }

    /**
     * Handle the stock adjustment item "deleted" event.
     *
     * @param  \App\StockAdjustmentItem  $stockAdjustmentItem
     * @return void
     */
    public function deleted(StockAdjustmentItem $stockAdjustmentItem)
    {
        StockTransaction::where('stock_adjustment_items_id', $stockAdjustmentItem->id)->where('transaction_point', 'Adjustment')->delete();
    }

    /**
     * Handle the stock adjustment item "restored" event.
     *
     * @param  \App\StockAdjustmentItem  $stockAdjustmentItem
     * @return void
     */
    public function restored(StockAdjustmentItem $stockAdjustmentItem)
    {
        StockTransaction::onlyTrashed()->where('stock_adjustment_items_id', $stockAdjustmentItem->id)->where('transaction_point', 'Adjustment')->restore();
    }

    /**
     * Handle the stock adjustment item "force deleted" event.
     *
     * @param  \App\StockAdjustmentItem  $stockAdjustmentItem
     * @return void
     */
    public function forceDeleted(StockAdjustmentItem $stockAdjustmentItem)
    {
        StockTransaction::where('stock_adjustment_items_id', $stockAdjustmentItem->id)->where('transaction_point', 'Adjustment')->forceDelete();
    }
}
