<?php

namespace App\Http\Controllers\Dashboard;

use App\AccountBook;
use App\Customer;
use App\Expense;
use App\Http\Controllers\Controller;
use App\Product;
use App\PurchaseInvoice;
use App\SellInvoice;
use App\Supplier;
use App\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $sales = SellInvoice::orderBy('id', 'DESC')->where('status', 'Final')->take(10)->get();
        $purchase = PurchaseInvoice::orderBy('id', 'DESC')->where('status', '<>', 'Pending')->take(10)->get();
        $transaction = Transaction::orderBy('id', 'DESC')->where('status', 'Active')->take(10)->get();
        $colors = ['bg-primary-400', 'bg-danger-400', 'bg-indigo-400', 'bg-success-400', 'bg-info-400', 'bg-pink-400', 'bg-purple-400', 'bg-brown-400', 'bg-teal-400', 'bg-slate-400'];

        return view('dashboard.dashboard')->with([
            'sales' => $sales,
            'purchase' => $purchase,
            'transaction' => $transaction,
            'colors' => $colors
        ]);
    }

    public function fixed_data(){

        $table = Product::all()->sortByDesc('CurrentStock')->take(10);
        $customer = Customer::all()->sortByDesc('Sales')->take(10);

        $product_data = array();
        foreach ($table as $row){
            $rowDataS['name']=$row->name;
            $rowDataS['value']=$row->CurrentStock;
            array_push($product_data, $rowDataS);
        }

        $customer_data = array();
        foreach ($customer as $row){
            $rowDataC['name']=$row->name;
            $rowDataC['value']=$row->Sales;
            array_push($customer_data, $rowDataC);
        }

        $st_date = db_se_date(date('Y-m-d', strtotime('tomorrow - 30 days')))[0];
        $end_date = db_se_date(date('Y-m-d', strtotime('tomorrow - 0 days')))[1];
        $sales_invoice = SellInvoice::whereBetween('created_at', [$st_date, $end_date])->where('status', 'Final')->get();
        $purchase_invoice = PurchaseInvoice::whereBetween('created_at', [$st_date, $end_date])->where('status', '<>', 'Pending')->get();
        $sl_ps_data = array();
        for($i = 0; $i <= 30; $i++){ //30 day sales purchase
            $cr_date = date('d/m/Y', strtotime('tomorrow - '.$i.' days'));
            $db_date = db_se_date($cr_date);

            $rowDataI['date'] = $cr_date;
            $rowDataI['sales'] = $sales_invoice->where('created_at','>=',$db_date[0])->where('created_at','<=',$db_date[1])->sum('SubTotal');
            $rowDataI['purchase'] = $purchase_invoice->where('created_at','>=',$db_date[0])->where('created_at','<=',$db_date[1])->sum('SubTotal');

            array_push($sl_ps_data, $rowDataI);
        }

        $year_data = array();
        for ($m = 0; $m < 12; $m++){
            $mo = date('m', strtotime("-$m month"));
            $ye = date('Y', strtotime("-$m month"));

            $sl_invoice = SellInvoice::whereYear('created_at',  $ye)->whereMonth('created_at',  $mo)->where('status', 'Final')->get();
            $rowDataY['sales'] = $sl_invoice->sum('SubTotal');

            $ps_invoice = PurchaseInvoice::whereYear('created_at',  $ye)->whereMonth('created_at',  $mo)->where('status', '<>', 'Pending')->get();
            $rowDataY['purchase'] = $ps_invoice->sum('SubTotal');

            $rowDataY['month'] = date('M-y', strtotime("-$m month"));
            array_push($year_data, $rowDataY);
        }

        return response()->json(array('stock' => $product_data, 'customer' => $customer_data, 'invoice' => $sl_ps_data, 'yearly' => $year_data));
    }


    public function info_data(){
        $product= Product::all();
        $stock_value = $product->sum('StockValue');
        $stock_lower = $product->sum('StockLower');
        $customer = Customer::all();
        $customer_due = $customer->sum('SalesDue');
        $total_customer = $customer->count();
        $supplier_due = Supplier::all()->sum('PurchaseDue');

        $ac_balance = AccountBook::all()->sum('TotalBalance');

        $today = date('Y-m-d');

        $today_sales = SellInvoice::whereDate('created_at', $today)->where('status', 'Final')->get();
        $today_sale = $today_sales->sum('SubTotal');

        $today_purchases = PurchaseInvoice::whereDate('created_at', $today)->where('status', '<>', 'Pending')->get();
        $today_purchase = $today_purchases->sum('SubTotal');

        $today_expance = Expense::whereDate('created_at', $today)->sum('amount');

        $monthly_expance = Expense::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('amount');

        $in_balance = Transaction::whereDate('created_at', $today)->where('transaction_type', 'IN')->sum('amount');
        $out_balance = Transaction::whereDate('created_at', $today)->where('transaction_type', 'OUT')->sum('amount');
        $today_balance = $in_balance - $out_balance;

        $customer_today = Customer::whereDate('created_at', $today)->get();
        $new_customer = $customer_today->count();

        return response()->json([
            'today_sale' => $today_sale,
            'today_purchase' => $today_purchase,
            'today_expance' => $today_expance,
            'stock_value' => $stock_value,
            'total_customer' => $total_customer,
            'ac_balance' => $ac_balance,
            'customer_due' => $customer_due,
            'supplier_due' => $supplier_due,
            'monthly_expance' => $monthly_expance,
            'stock_lower' => $stock_lower,
            'today_balance' => $today_balance,
            'new_customer' => $new_customer
        ]);
    }




}
