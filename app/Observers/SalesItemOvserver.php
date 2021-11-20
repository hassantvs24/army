<?php

namespace App\Observers;

use App\InvoiceItem;
use App\StockTransaction;
use Illuminate\Support\Facades\Auth;

class SalesItemOvserver
{
    /**
     * Handle the invoice item "created" event.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return void
     */
    public function created(InvoiceItem $invoiceItem)
    {
        if($invoiceItem->quantity > 0){
            $stockTransaction = new StockTransaction();
            $stockTransaction->transaction_point = 'Sells';
            $stockTransaction->transaction_type = 'OUT';
            $stockTransaction->sku = $invoiceItem->sku;
            $stockTransaction->name = $invoiceItem->name;
            $stockTransaction->unit = $invoiceItem->unit;
            $stockTransaction->quantity =  $invoiceItem->quantity;
            $stockTransaction->amount = $invoiceItem->amount;
            $stockTransaction->status = $invoiceItem->status;
            $stockTransaction->products_id = $invoiceItem->products_id;
            $stockTransaction->invoice_items_id = $invoiceItem->id;
            $stockTransaction->warehouses_id = $invoiceItem->warehouses_id ??  Auth::user()->warehouses_id;
            $stockTransaction->created_at = $invoiceItem->created_at;
            $stockTransaction->save();
        }
    }

    /**
     * Handle the invoice item "updated" event.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return void
     */
    public function updated(InvoiceItem $invoiceItem)
    {
        if($invoiceItem->quantity > 0) {
            StockTransaction::where('invoice_items_id', $invoiceItem->id)->where('transaction_point', 'Sells')->update([
                'sku' => $invoiceItem->sku,
                'name' => $invoiceItem->name,
                'unit' => $invoiceItem->unit,
                'products_id' => $invoiceItem->products_id,
                'quantity' => $invoiceItem->quantity,
                'amount' => $invoiceItem->amount,
                'status' => $invoiceItem->status,
                'warehouses_id' => $invoiceItem->warehouses_id ??  Auth::user()->warehouses_id,
                'created_at' => $invoiceItem->created_at
            ]);
        }else{
            StockTransaction::where('invoice_items_id', $invoiceItem->id)->where('transaction_point', 'Sells')->forceDelete();
        }
    }

    /**
     * Handle the invoice item "deleted" event.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return void
     */
    public function deleted(InvoiceItem $invoiceItem)
    {
        StockTransaction::where('invoice_items_id', $invoiceItem->id)->where('transaction_point', 'Sells')->delete();
    }

    /**
     * Handle the invoice item "restored" event.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return void
     */
    public function restored(InvoiceItem $invoiceItem)
    {
        StockTransaction::onlyTrashed()->where('invoice_items_id', $invoiceItem->id)->where('transaction_point', 'Sells')->restore();
    }

    /**
     * Handle the invoice item "force deleted" event.
     *
     * @param  \App\InvoiceItem  $invoiceItem
     * @return void
     */
    public function forceDeleted(InvoiceItem $invoiceItem)
    {
        StockTransaction::where('invoice_items_id', $invoiceItem->id)->where('transaction_point', 'Sells')->forceDelete();
    }
}
