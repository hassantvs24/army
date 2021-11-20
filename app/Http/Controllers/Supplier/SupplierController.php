<?php

namespace App\Http\Controllers\Supplier;

use App\AccountBook;
use App\Http\Controllers\Controller;
use App\Supplier;
use App\SupplierCategory;
use App\Transaction;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{

    public function index()
    {
        $table = Supplier::with('supplierCategory', 'warehouse')->orderBy('id', 'DESC')->get();
        $category = SupplierCategory::orderBy('name', 'ASC')->get();
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        $ac_book = AccountBook::orderBy('name', 'ASC')->get();
        return view('supplier.supplier')->with(['table' => $table, 'category' => $category, 'warehouse' => $warehouse, 'ac_book' => $ac_book]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'string|required|max:191',
            'name' => 'string|required|max:191',
            'contact' => 'string|required|min:11|max:11',
            'supplier_categories_id' => 'numeric|required',
            'warehouses_id' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Supplier();
            $table->code = $request->code ?? mt_rand();
            $table->name = $request->name;
            $table->address = $request->address;
            $table->email = $request->email;
            $table->contact = $request->contact;
            $table->phone = $request->phone;
            $table->alternate_contact = $request->alternate_contact;
            $table->description = $request->description;
            $table->supplier_categories_id = $request->supplier_categories_id;
            $table->warehouses_id = $request->warehouses_id;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'string|required|max:191',
            'name' => 'string|required|max:191',
            'contact' => 'string|required|min:11|max:11',
            'supplier_categories_id' => 'numeric|required',
            'warehouses_id' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = Supplier::find($id);
            $table->code = $request->code ?? mt_rand();
            $table->name = $request->name;
            $table->address = $request->address;
            $table->email = $request->email;
            $table->contact = $request->contact;
            $table->phone = $request->phone;
            $table->alternate_contact = $request->alternate_contact;
            $table->description = $request->description;
            $table->supplier_categories_id = $request->supplier_categories_id;
            $table->warehouses_id = $request->warehouses_id;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            Supplier::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }

    public function due_payment(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'payment_method' => 'string|required|max:20',
            'created_at' => 'required|date_format:d/m/Y',
            'account_books_id' => 'numeric|required',
            'amount' => 'numeric|required|min:1',
            'warehouses_id' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Transaction();
            $table->suppliers_id = $id;
            $table->transaction_point = 'Supplier Account';
            $table->transaction_hub = 'Due Payment';
            $table->transaction_type = 'OUT';
            $table->payment_method = $request->payment_method;
            $table->amount = $request->amount;
            $table->cheque_number = null_filter($request->cheque_number);
            $table->bank_account_no = null_filter($request->bank_account_no);
            $table->transaction_no = null_filter($request->transaction_no);
            $table->description = null_filter($request->description);
            $table->account_books_id = $request->account_books_id;
            $table->warehouses_id = $request->warehouses_id;
            $table->created_at = $request->created_at;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    public function show($id){
        $supplier = Supplier::find($id);
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        $ac_book = AccountBook::orderBy('name', 'ASC')->get();
        $table = $supplier->transactions()->with('accountBook', 'supplier', 'warehouse')->where('status', 'Active')->orderBy('id', 'DESC')->get();
        return view('supplier.transaction')->with(['table' => $table, 'supplier' => $supplier, 'ac_book' => $ac_book, 'warehouse' => $warehouse]);
    }

}
