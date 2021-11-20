<?php

namespace App\Http\Controllers\Report;

use App\Agent;
use App\Custom\DbDate;
use App\Customer;
use App\Http\Controllers\Controller;
use App\InvoiceItem;
use App\Product;
use App\SellInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index(){
        $agent = Agent::orderBy('name', 'ASC')->get();
        $products = Product::orderBy('name', 'ASC')->get();
        $customer = Customer::orderBy('name')->get();
        return view('reports.sales')->with(['agent' => $agent, 'products' => $products, 'customer' => $customer]);
    }


    public function invoice(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dt = new DbDate($request->date_range);

        $tablex = SellInvoice::whereBetween('created_at', $dt->ftr())->where('status','Final')->orderBy('created_at');

        if(!empty($request->customers_id)){
                $tablex->where('customers_id', $request->customers_id);
            }

        if(!empty($request->agents_id)){
            $tablex->where('agents_id', $request->agents_id);
        }

        $table = $tablex->get();

        return view('reports.print.sales')->with(['table' => $table, 'request' => $request->all()]);
    }


    public function items(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dt = new DbDate($request->date_range);

        $tablex = InvoiceItem::whereBetween('created_at', $dt->ftr())->where('status', 'Active')->orderBy('created_at');
        if(!empty($request->products_id)){
            $tablex->where('products_id', $request->products_id);
        }
        $table = $tablex->get();
        return view('reports.print.sales_item')->with(['table' => $table, 'request' => $request->all()]);
    }


    public function due(Request $request){
        $validator = Validator::make($request->all(), [
            'due' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tablex = SellInvoice::where('status','Final')->orderBy('created_at');

        if($request->due == 'Over'){
            $tablex->where('due_date', '<', date('Y-m-d'));
        }

        if(!empty($request->customers_id)){
            $tablex->where('customers_id', $request->customers_id);
        }

        $table = $tablex->get();
        return view('reports.print.due_sales_invoice')->with(['table' => $table, 'request' => $request->all()]);

    }
}
