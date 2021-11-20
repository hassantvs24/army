<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\SellInvoice;
use Illuminate\Http\Request;

class SalesListController extends Controller
{
    public function index(){
        $table = SellInvoice::with('warehouse', 'vetTex', 'customer', 'shipment', 'discount')->where('status','Final')->orderByDesc('id')->paginate(500);
        return view('sales.sales_list')->with(['table' => $table]);
    }

    public function quotation(){
        $table = SellInvoice::with('warehouse', 'vetTex', 'customer', 'shipment', 'discount')->where('status','Quotation')->orderByDesc('id')->get();
        return view('sales.quotation')->with(['table' => $table]);
    }

    public function draft(){
        $table = SellInvoice::with('warehouse', 'vetTex', 'customer', 'shipment', 'discount')->where('status','Draft')->orderByDesc('id')->get();
        return view('sales.draft')->with(['table' => $table]);
    }
}
