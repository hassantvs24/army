<?php

namespace App\Http\Controllers\Accounts;

use App\AccountBook;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{

    public function index()
    {
        $table = AccountBook::orderBy('id', 'DESC')->get();
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        return view('accounts.account')->with(['table' => $table, 'warehouse' => $warehouse]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new AccountBook();
            $table->name = $request->name;
            $table->account_number = $request->account_number;
            $table->description = $request->description;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = AccountBook::find($id);
            $table->name = $request->name;
            $table->account_number = $request->account_number;
            $table->description = $request->description;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            AccountBook::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }

    public function show($id)
    {
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        $table = AccountBook::find($id);
        $transactions = $table->transactions()->with('warehouse')->orderBy('id', 'DESC')->where('status', 'Active')->get();
        return view('accounts.transaction')->with(['table' => $table, 'transactions' => $transactions, 'warehouse' => $warehouse]);
    }

    public function payment(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'payment_method' => 'string|required|max:20',
            'transaction_type' => 'string|required|min:2|max:3',
            'created_at' => 'required|date_format:d/m/Y',
            'amount' => 'numeric|required|min:1',
            'warehouses_id' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $table = new Transaction();
            $table->account_books_id = $id;
            $table->transaction_point = 'Account Book';
            $table->transaction_hub = ($request->transaction_type == 'IN' ? 'Add':'Withdraw');
            $table->transaction_type = $request->transaction_type;
            $table->payment_method = $request->payment_method;
            $table->amount = $request->amount;
            $table->cheque_number = null_filter($request->cheque_number);
            $table->bank_account_no = null_filter($request->bank_account_no);
            $table->transaction_no = null_filter($request->transaction_no);
            $table->description = null_filter($request->description);
            $table->warehouses_id = $request->warehouses_id ?? Auth::user()->warehouses_id;
            $table->created_at = $request->created_at;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }


}
