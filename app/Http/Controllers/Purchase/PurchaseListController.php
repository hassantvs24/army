<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\PurchaseInvoice;
use Illuminate\Http\Request;

class PurchaseListController extends Controller
{
    public function index(){
        $table = PurchaseInvoice::with('warehouse', 'vetTex', 'supplier', 'shipment', 'discount')->where('status','Received')->orderByDesc('id')->get();
        return view('purchase.purchase_list')->with(['table' => $table]);
    }

    public function pending(){
        $table = PurchaseInvoice::with('warehouse', 'vetTex', 'supplier', 'shipment', 'discount')->where('status','Pending')->orderByDesc('id')->get();
        return view('purchase.pending')->with(['table' => $table]);
    }

    public function ordered(){
        $table = PurchaseInvoice::with('warehouse', 'vetTex', 'supplier', 'shipment', 'discount')->where('status','Ordered')->orderByDesc('id')->get();
        return view('purchase.ordered')->with(['table' => $table]);
    }
}
