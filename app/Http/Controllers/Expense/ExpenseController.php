<?php

namespace App\Http\Controllers\Expense;

use App\Expense;
use App\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{

    public function index()
    {
        $table = Expense::orderBy('id', 'DESC')->get();
        $category = ExpenseCategory::orderBy('name', 'ASC')->get();
        $warehouse = Warehouse::orderBy('name')->get();
        return view('expenses.expenses')->with(['table' => $table, 'category' => $category, 'warehouse' => $warehouse]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:4|max:191|unique:expenses,code',
            'created_at' => 'required|date_format:d/m/Y',
            'expense_categories_id' => 'numeric|required',
            'warehouses_id' => 'numeric|required',
            'amount' => 'numeric|required|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Expense();
            $table->code = $request->code ?? mt_rand();
            $table->expense_categories_id = $request->expense_categories_id;
            $table->amount = $request->amount;
            $table->description = $request->description;
            $table->warehouses_id = $request->warehouses_id;
            $table->created_at = $request->created_at;
            $table->save();

        }catch (\Exception $ex) {
            dd($ex);
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:4|max:191|unique:expenses,code,'.$id.',id',
            'created_at' => 'required|date_format:d/m/Y',
            'expense_categories_id' => 'numeric|required',
            'warehouses_id' => 'numeric|required',
            'amount' => 'numeric|required|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

                $table = Expense::find($id);
                $table->code = $request->code ?? mt_rand();
                $table->expense_categories_id = $request->expense_categories_id;
                $table->amount = $request->amount;
                $table->description = $request->description;
                $table->warehouses_id = $request->warehouses_id;
                $table->created_at = $request->created_at;
                $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function destroy($id)
    {
        try{

            Expense::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
