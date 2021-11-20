<?php

namespace App\Http\Controllers\Report;

use App\Custom\DbDate;
use App\Expense;
use App\Http\Controllers\Controller;
use App\PurchaseInvoice;
use App\SellInvoice;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportsController extends Controller
{
    public function index(){

        return view('reports.profit_loss');
    }

    public function profit_lose(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->orderBy('created_at');
        }

        $dt = new DbDate($request->date_range);

        $dates = $dt->gen_list();

        $table = array();
        foreach($dates as $d){
            $rowData['date'] = $d;

            $invoice = SellInvoice::whereDate('created_at', $d)->where('status', 'Final')->get();
            $rowData['sales'] = $invoice->sum('SubTotal');

            $pInvoice = PurchaseInvoice::whereDate('created_at', $d)->whereIn('status', ['Received', 'Ordered'])->get();
            $rowData['purchase'] = $pInvoice->sum('SubTotal');

            $rowData['expense'] = Expense::whereDate('created_at', $d)->sum('amount');

            $rowData['recover'] = Transaction::whereDate('created_at', $d)
                ->where('transaction_point', 'Stock Adjustment')
                ->where('transaction_hub', 'Recover')
                ->where('transaction_type', 'IN')
                ->where('status', 'Active')
                ->sum('amount');

            $rowData['withdraw'] = Transaction::whereDate('created_at', $d)
                ->where('transaction_point', 'Account Book')
                ->where('transaction_hub', 'Withdraw')
                ->where('transaction_type', 'OUT')
                ->where('status', 'Active')
                ->sum('amount');

            $rowData['deposit'] = Transaction::whereDate('created_at', $d)
                ->where('transaction_point', 'Account Book')
                ->where('transaction_hub', 'Add')
                ->where('transaction_type', 'IN')
                ->where('status', 'Active')
                ->sum('amount');


            array_push($table, $rowData);
        }


        return view('reports.print.profit_lose')->with(['table' => $table, 'request' => $request->all()]);

    }

    public function sales_profit(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->orderBy('created_at');
        }

        $dt = new DbDate($request->date_range);
        $dates = $dt->gen_list();

        $table = array();
        foreach($dates as $d) {
            $rowData['date'] = $d;

            $invoice = SellInvoice::whereDate('created_at', $d)->where('status', 'Final')->get();
            $rowData['invoice'] = $invoice->count();
            $rowData['discount_amount'] = $invoice->sum('discount_amount');
            $rowData['vet_texes_amount'] = $invoice->sum('vet_texes_amount');
            $rowData['additional_charges'] = $invoice->sum('additional_charges');
            $rowData['sub_total'] = $invoice->sum('SubTotal');
            $rowData['invoice_total'] = $invoice->sum('invoice_total');
            $rowData['purchase_total'] = $invoice->sum('purchase_total');

            array_push($table, $rowData);
        }
        return view('reports.print.sales_profit')->with(['table' => $table, 'request' => $request->all()]);
    }
}
