<?php

namespace App\Observers;

use App\Customer;
use App\Transaction;
use Illuminate\Support\Facades\Auth;

class CustomerObserver
{
    /**
     * Handle the customer "created" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        if($customer->balance != 0){
            $transactions = new Transaction();
            $transactions->customers_id = $customer->id;
            $transactions->transaction_point = 'Customer Account';
            $transactions->transaction_hub = 'Opening';
            $transactions->transaction_type = ($customer->balance > 0 ? 'IN' : 'OUT');
            $transactions->amount = $customer->balance;
            $transactions->warehouses_id = $customer->warehouses_id ??  Auth::user()->warehouses_id;
            $transactions->account_books_id = Auth::user()->account_books_id;
            $transactions->save();
        }
    }

    /**
     * Handle the customer "updated" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function updated(Customer $customer)
    {
        if($customer->balance != 0) {
            Transaction::updateOrCreate([
                'customers_id' => $customer->id, 'transaction_point' => 'Customer Account', 'transaction_hub' => 'Opening'
            ], [
                'transaction_type' => ($customer->balance > 0 ? 'IN' : 'OUT'),
                'amount' => $customer->balance,
                'warehouses_id' => $customer->warehouses_id,
                'account_books_id' => Auth::user()->account_books_id
            ]);
        }else{
            Transaction::where('customers_id',  $customer->id)->where('transaction_point', 'Customer Account')->where('transaction_hub', 'Opening')->forceDelete();
        }
    }

    /**
     * Handle the customer "deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function deleted(Customer $customer)
    {
        Transaction::where('customers_id',  $customer->id)->where('transaction_point', 'Customer Account')->where('transaction_hub', 'Opening')->delete();
    }

    /**
     * Handle the customer "restored" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function restored(Customer $customer)
    {
        Transaction::onlyTrashed()->where('customers_id',  $customer->id)->where('transaction_point', 'Customer Account')->where('transaction_hub', 'Opening')->restore();
    }

    /**
     * Handle the customer "force deleted" event.
     *
     * @param  \App\Customer  $customer
     * @return void
     */
    public function forceDeleted(Customer $customer)
    {
        Transaction::where('customers_id',  $customer->id)->where('transaction_point', 'Customer Account')->where('transaction_hub', 'Opening')->forceDelete();
    }
}
