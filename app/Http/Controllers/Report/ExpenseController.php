<?php

namespace App\Http\Controllers\Report;

use App\Custom\DbDate;
use App\Expense;
use App\ExpenseCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index(){
        $table = ExpenseCategory::orderBy('name')->get();
        return view('reports.expense')->with(['table' => $table]);
    }

    public function reports(Request $request){

            $validator = Validator::make($request->all(), [
                'date_range' => 'required|string|min:23|max:23',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->orderBy('created_at');
            }

            $dt = new DbDate($request->date_range);

            $tablex = Expense::whereBetween('created_at', $dt->ftr());
                if(!empty($request->expense_categories_id)){
                    $tablex->where('expense_categories_id', $request->expense_categories_id);
                }
            $table = $tablex->get();

            return view('reports.print.expense')->with(['table' => $table, 'request' => $request->all()]);
    }
}
