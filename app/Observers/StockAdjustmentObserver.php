<?php

namespace App\Observers;

use App\StockAdjustment;
use App\Transaction;
use Illuminate\Support\Facades\Auth;

class StockAdjustmentObserver
{

    public function created(StockAdjustment $stockAdjustment)
    {
        if($stockAdjustment->recover_amount > 0){
            $all_transaction = new Transaction();
            $all_transaction->stock_adjustments_id = $stockAdjustment->id;
            $all_transaction->transaction_point = 'Stock Adjustment';
            $all_transaction->transaction_hub = 'Recover';
            $all_transaction->transaction_type = 'IN';
            $all_transaction->amount = $stockAdjustment->recover_amount;
            $all_transaction->warehouses_id = $stockAdjustment->warehouses_id ??  Auth::user()->warehouses_id;
            $all_transaction->account_books_id = Auth::user()->account_books_id;
            $all_transaction->created_at = $stockAdjustment->created_at;
            $all_transaction->save();
        }
    }

    public function updated(StockAdjustment $stockAdjustment)
    {
        if($stockAdjustment->recover_amount > 0){
            Transaction::updateOrCreate([
                'stock_adjustments_id' => $stockAdjustment->id, 'transaction_point' => 'Stock Adjustment', 'transaction_hub' => 'Recover'
            ], [
                'amount' => $stockAdjustment->recover_amount,
                'warehouses_id' => $stockAdjustment->warehouses_id ??  Auth::user()->warehouses_id,
                'account_books_id' => Auth::user()->account_books_id,
                'created_at' => $stockAdjustment->created_at
            ]);
        }else{
            Transaction::where('stock_adjustments_id', $stockAdjustment->id)->where('transaction_point', 'Stock Adjustment')->where('transaction_hub', 'Recover')->forceDelete();
        }
    }

    public function deleted(StockAdjustment $stockAdjustment)
    {
        Transaction::where('stock_adjustments_id', $stockAdjustment->id)->where('transaction_point', 'Stock Adjustment')->where('transaction_hub', 'Recover')->delete();
    }

    public function restored(StockAdjustment $stockAdjustment)
    {
        Transaction::onlyTrashed()->where('stock_adjustments_id', $stockAdjustment->id)->where('transaction_point', 'Stock Adjustment')->where('transaction_hub', 'Recover')->restore();
    }

    public function forceDeleted(StockAdjustment $stockAdjustment)
    {
        Transaction::where('stock_adjustments_id', $stockAdjustment->id)->where('transaction_point', 'Stock Adjustment')->where('transaction_hub', 'Recover')->forceDelete();
    }
}
