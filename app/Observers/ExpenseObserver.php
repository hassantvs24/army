<?php

namespace App\Observers;

use App\Expense;
use App\Transaction;
use Illuminate\Support\Facades\Auth;

class ExpenseObserver
{
    /**
     * Handle the expense "created" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function created(Expense $expense)
    {
        if($expense->amount > 0){
            $all_transaction = new Transaction();
            $all_transaction->expenses_id = $expense->id;
            $all_transaction->transaction_point = 'Expense';
            $all_transaction->transaction_type = 'OUT';
            $all_transaction->transaction_hub = 'General';
            $all_transaction->amount = $expense->amount;
            $all_transaction->warehouses_id = $expense->warehouses_id ?? Auth::user()->warehouses_id;
            $all_transaction->account_books_id = Auth::user()->account_books_id;
            $all_transaction->created_at = $expense->created_at;
            $all_transaction->save();
        }
    }

    /**
     * Handle the expense "updated" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function updated(Expense $expense)
    {
        if($expense->amount > 0){
            Transaction::updateOrCreate([
                'expenses_id' => $expense->id, 'transaction_point' => 'Expense'
            ], [
                'amount' => $expense->amount,
                'transaction_type' => 'OUT',
                'transaction_hub' => 'General',
                'warehouses_id' => $expense->warehouses_id ?? Auth::user()->warehouses_id,
                'account_books_id' => Auth::user()->account_books_id,
                'created_at' => $expense->created_at
            ]);
        }else{
            Transaction::where('expenses_id',  $expense->id)->forceDelete();
        }
    }

    /**
     * Handle the expense "deleted" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function deleted(Expense $expense)
    {
        Transaction::where('expenses_id',  $expense->id)->delete();
    }

    /**
     * Handle the expense "restored" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function restored(Expense $expense)
    {
        Transaction::onlyTrashed()->where('expenses_id',  $expense->id)->restore();
    }

    /**
     * Handle the expense "force deleted" event.
     *
     * @param  \App\Expense  $expense
     * @return void
     */
    public function forceDeleted(Expense $expense)
    {
        Transaction::where('expenses_id',  $expense->id)->forceDelete();
    }
}
