<?php

namespace App\Observers;

use App\Product;
use App\StockTransaction;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        if($product->stock > 0){
            $stockTransaction = new StockTransaction();
            $stockTransaction->transaction_point = 'Opening Stock';
            $stockTransaction->transaction_type = 'IN';
            $stockTransaction->sku = $product->sku;
            $stockTransaction->name = $product->name;
            $stockTransaction->unit = $product->unit['name'];
            $stockTransaction->quantity = $product->stock;
            $stockTransaction->amount = $product->purchase_price;
            $stockTransaction->products_id = $product->id;
            if (auth()->check()) {
                $stockTransaction->warehouses_id = Auth::user()->warehouses_id;
            }
            $stockTransaction->save();
        }
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        if($product->stock > 0) {
            StockTransaction::updateOrCreate(
                ['products_id' => $product->id, 'transaction_point' => 'Opening Stock', 'transaction_type' => 'IN'],
                [
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'unit' => $product->unit['name'],
                    'quantity' => $product->stock,
                    'amount' => $product->purchase_price
                ]
            );
        }else{
            StockTransaction::where('products_id',  $product->id)->where('transaction_point', 'Opening Stock')->where('transaction_type', 'IN')->forceDelete();
        }
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        StockTransaction::where('products_id',  $product->id)->where('transaction_point', 'Opening Stock')->where('transaction_type', 'IN')->delete();
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        StockTransaction::onlyTrashed()->where('products_id',  $product->id)->where('transaction_point', 'Opening Stock')->where('transaction_type', 'IN')->restore();
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        StockTransaction::where('products_id',  $product->id)->where('transaction_point', 'Opening Stock')->where('transaction_type', 'IN')->forceDelete();
    }
}
