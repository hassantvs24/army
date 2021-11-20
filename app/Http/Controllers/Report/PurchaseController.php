<?php

namespace App\Http\Controllers\Report;

use App\Custom\DbDate;
use App\Http\Controllers\Controller;
use App\Product;
use App\PurchaseInvoice;
use App\PurchaseItem;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index(){
        $products = Product::orderBy('name', 'ASC')->get();
        $supplier = Supplier::orderBy('name')->get();
        return view('reports.purchase')->with(['products' => $products, 'supplier' => $supplier]);
    }


    public function invoice(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dt = new DbDate($request->date_range);

        $tablex = PurchaseInvoice::whereBetween('created_at', $dt->ftr())->whereIn('status', ['Received', 'Ordered'])->orderBy('created_at');

        if(!empty($request->suppliers_id)){
            $tablex->where('suppliers_id', $request->suppliers_id);
        }

        $table = $tablex->get();

        return view('reports.print.purchase')->with(['table' => $table, 'request' => $request->all()]);
    }

    public function items(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dt = new DbDate($request->date_range);

        $tablex = PurchaseItem::whereBetween('created_at', $dt->ftr())->where('status', 'Active')->orderBy('created_at');
        if(!empty($request->products_id)){
            $tablex->where('products_id', $request->products_id);
        }
        $table = $tablex->get();
        return view('reports.print.purchase_item')->with(['table' => $table, 'request' => $request->all()]);
    }

}
