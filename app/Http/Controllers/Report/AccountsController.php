<?php

namespace App\Http\Controllers\Report;

use App\AccountBook;
use App\Custom\DbDate;
use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
{
    public function index(){
        $table = AccountBook::orderBy('name')->get();
        return view('reports.accounts')->with(['table' => $table]);
    }

    public function reports(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->orderBy('created_at');
        }

        $dt = new DbDate($request->date_range);

        $tablex = Transaction::whereBetween('created_at', $dt->ftr())->where('status', 'Active')->orderBy('created_at');

        if(!empty($request->account_books_id)){
            $tablex->where('account_books_id', $request->account_books_id);
        }

        if(!empty($request->payment_method)){
            $tablex->where('payment_method', $request->payment_method);
        }
        $table = $tablex->get();

        return view('reports.print.account_book')->with(['table' => $table, 'request' => $request->all()]);

    }
}
