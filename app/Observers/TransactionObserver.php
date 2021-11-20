<?php

namespace App\Observers;

use App\Customer;
use App\Expense;
use App\Transaction;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        /*if($transaction->transaction_point == 'Customer Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->customers_id);
            $table->balance = ($transaction->transaction_type == 'IN' ? $transaction->amount : -$transaction->amount);
            $table->save();
        }elseif ($transaction->transaction_point == 'Supplier Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->suppliers_id);
            $table->balance = ($transaction->transaction_type == 'IN' ? -$transaction->amount : $transaction->amount);
            $table->save();
        }elseif ($transaction->transaction_point == 'Expense' && $transaction->transaction_hub == 'General'){
            $table = Expense::find($transaction->expenses_id);
            $table->amount = $transaction->amount;
            $table->save();
        }
        }*/
    }

    /**
     * Handle the transaction "updated" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        if($transaction->transaction_point == 'Customer Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->customers_id);
            $table->balance = ($transaction->transaction_type == 'IN' ? $transaction->amount : -$transaction->amount);
            $table->save();
        }elseif ($transaction->transaction_point == 'Supplier Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->suppliers_id);
            $table->balance = ($transaction->transaction_type == 'IN' ? -$transaction->amount : $transaction->amount);
            $table->save();
        }elseif ($transaction->transaction_point == 'Expense' && $transaction->transaction_hub == 'General'){
            $table = Expense::find($transaction->expenses_id);
            $table->amount = $transaction->amount;
            $table->save();
        }
    }

    /**
     * Handle the transaction "deleted" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        if($transaction->transaction_point == 'Customer Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->customers_id);
            $table->balance = 0;
            $table->save();
        }elseif ($transaction->transaction_point == 'Supplier Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->suppliers_id);
            $table->balance = 0;
            $table->save();
        }elseif ($transaction->transaction_point == 'Expense' && $transaction->transaction_hub == 'General'){
            $table = Expense::find($transaction->expenses_id);
            $table->amount = 0;
            $table->save();
        }
    }

    /**
     * Handle the transaction "restored" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        if($transaction->transaction_point == 'Customer Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->customers_id);
            $table->balance = $transaction->amount;
            $table->save();
        }elseif ($transaction->transaction_point == 'Supplier Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->suppliers_id);
            $table->balance = $transaction->amount;
            $table->save();
        }elseif ($transaction->transaction_point == 'Expense' && $transaction->transaction_hub == 'General'){
            $table = Expense::find($transaction->expenses_id);
            $table->amount = $transaction->amount;
            $table->save();
        }
    }

    /**
     * Handle the transaction "force deleted" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        if($transaction->transaction_point == 'Customer Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->customers_id);
            $table->balance = 0;
            $table->save();
        }elseif ($transaction->transaction_point == 'Supplier Account' && $transaction->transaction_hub == 'Opening'){
            $table = Customer::find($transaction->suppliers_id);
            $table->balance = 0;
            $table->save();
        }elseif ($transaction->transaction_point == 'Expense' && $transaction->transaction_hub == 'General'){
            $table = Expense::find($transaction->expenses_id);
            $table->amount = 0;
            $table->save();
        }
    }
}
