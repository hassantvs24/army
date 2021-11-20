<?php

namespace App\Http\Controllers\Report;

use App\Custom\DbDate;
use App\Customer;
use App\Http\Controllers\Controller;
use App\UpaZilla;
use App\Zilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(){
        $customer = Customer::orderBy('name')->get();
        $zilla = Zilla::orderBy('name')->get();
        $upazilla = UpaZilla::orderBy('name')->get();

        return view('reports.customer')->with(['zilla' => $zilla, 'upazilla' => $upazilla, 'customer' => $customer]);
    }

    public function single_customer(Request $request){
        $validator = Validator::make($request->all(), [
            'customers_id' => 'required|numeric',
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->orderBy('created_at');
        }

        $dt = new DbDate($request->date_range);
        $date_list = $dt->gen_list();

        $table = Customer::with('transactions', 'sellInvoices')->where('id', $request->customers_id)->first();

        $all_data = array();
        foreach ($date_list as $date){
            $day = $table->daily($date);
            if($day['in'] != 0 || $day['out'] != 0){
                $rowData['date'] = $date;
                $rowData['in'] = $day['in'];
                $rowData['out'] = $day['out'];
                array_push($all_data, $rowData);
            }
        }

        return view('reports.print.single_customer_ledger')->with(['table' => $table, 'data' => $all_data, 'request' => $request->all()]);
    }

    public function all_customer(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->orderBy('created_at');
        }

        $dt = new DbDate($request->date_range);

        $tablex = Customer::with('transactions', 'sellInvoices')->orderBy('name');
        if(!empty($request->zillas_id) && empty($request->upa_zillas_id)){
            $tablex->where('zillas_id', $request->zillas_id);
        }
        if(!empty($request->upa_zillas_id)){
            $tablex->where('upa_zillas_id', $request->upa_zillas_id);
        }
        $table = $tablex->get();


        return view('reports.print.all_customer_ledger')->with(['table' => $table, 'st' => $dt->form(), 'end' => $dt->to(),  'range' => $dt->ftr(), 'request' => $request->all()]);
    }
}
