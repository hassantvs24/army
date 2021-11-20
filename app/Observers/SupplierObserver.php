<?php

namespace App\Observers;

use App\Supplier;
use App\Transaction;
use Illuminate\Support\Facades\Auth;

class SupplierObserver
{
    /**
     * Handle the supplier "created" event.
     *
     * @param  \App\Supplier  $supplier
     * @return void
     */

    public function created(Supplier $supplier)
    {
        if($supplier->balance != 0){
            $transactions = new Transaction();
            $transactions->suppliers_id = $supplier->id;
            $transactions->transaction_point = 'Supplier Account';
            $transactions->transaction_hub = 'Opening';
            $transactions->transaction_type = ($supplier->balance > 0 ? 'OUT' : 'IN');
            $transactions->amount = $supplier->balance;
            $transactions->warehouses_id = $supplier->warehouses_id ??  Auth::user()->warehouses_id;
            $transactions->account_books_id = Auth::user()->account_books_id;
            $transactions->save();
        }
    }

    /**
     * Handle the supplier "updated" event.
     *
     * @param  \App\Supplier  $supplier
     * @return void
     */

    public function updated(Supplier $supplier)
    {
        if($supplier->balance != 0) {

            Transaction::updateOrCreate([
                'suppliers_id' => $supplier->id, 'transaction_point' => 'Supplier Account', 'transaction_hub' => 'Opening'
            ], [
                'transaction_type' => ($supplier->balance > 0 ? 'OUT' : 'IN'),
                'amount' => $supplier->balance,
                'warehouses_id' => $supplier->warehouses_id,
                'account_books_id' => Auth::user()->account_books_id
            ]);
        }else{
            Transaction::where('suppliers_id',  $supplier->id)->where('transaction_point', 'Supplier Account')->where('transaction_hub', 'Opening')->forceDelete();
        }
    }

    /**
     * Handle the supplier "deleted" event.
     *
     * @param  \App\Supplier  $supplier
     * @return void
     */

    public function deleted(Supplier $supplier)
    {
        Transaction::where('suppliers_id',  $supplier->id)->where('transaction_point', 'Supplier Account')->where('transaction_hub', 'Opening')->delete();
    }

    /**
     * Handle the supplier "restored" event.
     *
     * @param  \App\Supplier  $supplier
     * @return void
     */

    public function restored(Supplier $supplier)
    {
        Transaction::onlyTrashed()->where('suppliers_id',  $supplier->id)->where('transaction_point', 'Supplier Account')->where('transaction_hub', 'Opening')->restore();
    }

    /**
     * Handle the supplier "force deleted" event.
     *
     * @param  \App\Supplier  $supplier
     * @return void
     */

    public function forceDeleted(Supplier $supplier)
    {
        Transaction::where('suppliers_id',  $supplier->id)->where('transaction_point', 'Supplier Account')->where('transaction_hub', 'Opening')->forceDelete();
    }
}
