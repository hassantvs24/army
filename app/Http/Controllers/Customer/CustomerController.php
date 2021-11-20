<?php

namespace App\Http\Controllers\Customer;

use App\Custom\BdPhone;
use App\AccountBook;
use App\Agent;
use App\Customer;
use App\CustomerCategory;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\UpaZilla;
use App\Warehouse;
use App\Zilla;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function index()
    {
        $table = Customer::with('zone', 'customerCategory', 'warehouse')->orderBy('id', 'DESC')->paginate(700);
        $category = CustomerCategory::orderBy('name', 'ASC')->get();
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        $ac_book = AccountBook::orderBy('name', 'ASC')->get();

        $agent = Agent::orderBy('name', 'ASC')->get();
        $upa_zilla = UpaZilla::orderBy('name', 'ASC')->get();
        $zilla  = Zilla::orderBy('name', 'ASC')->get();
        return view('customer.customer')->with(['table' => $table, 'category' => $category, 'warehouse' => $warehouse, 'agent' => $agent, 'zilla' => $zilla, 'upa_zilla' => $upa_zilla, 'ac_book' => $ac_book]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'string|required|max:191',
            'name' => 'string|required|max:191',
            'contact' => 'string|required|min:11|max:11',
            'balance' => 'numeric|required',
            'customer_categories_id' => 'numeric|required',
            'sells_target' => 'numeric|required',
            'credit_limit' => 'numeric|required',
            'zillas_id' => 'numeric|required',
            //'upa_zillas_id' => 'numeric|required',
            'agent_id' => 'numeric|required',
            'warehouses_id' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

           // $zilla = UpaZilla::find($request->upa_zillas_id);

            $table = new Customer();
            $table->code = $request->code ?? mt_rand();
            $table->name = $request->name;
            $table->contact_person = $request->contact_person;
            $table->address = $request->address;
            $table->email = $request->email;
            $table->contact = $request->contact;
            $table->phone = $request->phone;
            $table->alternate_contact = $request->alternate_contact;
            $table->description = $request->description;
            $table->credit_limit = $request->credit_limit ?? 0;
            $table->balance = $request->balance ?? 0;
            $table->sells_target = $request->sells_target ?? 0;
            //$table->upa_zillas_id = $request->upa_zillas_id;
            $table->zillas_id = $request->zillas_id;
            $table->agent_id = $request->agent_id;
            $table->customer_categories_id = $request->customer_categories_id;
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
            'balance' => 'numeric|required',
            'customer_categories_id' => 'numeric|required',
            'sells_target' => 'numeric|required',
            'credit_limit' => 'numeric|required',
            'zillas_id' => 'numeric|required',
            //'upa_zillas_id' => 'numeric|required',
            'agent_id' => 'numeric|required',
            'warehouses_id' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

           // $zilla = UpaZilla::find($request->upa_zillas_id);

            $table = Customer::find($id);
            $table->code = $request->code ?? mt_rand();
            $table->name = $request->name;
            $table->contact_person = $request->contact_person;
            $table->address = $request->address;
            $table->email = $request->email;
            $table->contact = $request->contact;
            $table->phone = $request->phone;
            $table->alternate_contact = $request->alternate_contact;
            $table->description = $request->description;
            $table->credit_limit = $request->credit_limit ?? 0;
            $table->balance = $request->balance ?? 0;
            $table->sells_target = $request->sells_target ?? 0;
            //$table->upa_zillas_id = $request->upa_zillas_id;
            $table->zillas_id = $request->zillas_id;
            $table->agent_id = $request->agent_id;
            $table->customer_categories_id = $request->customer_categories_id;
            $table->warehouses_id = $request->warehouses_id;
            $table->save();


        }catch (\Exception $ex) {
            dd($ex);
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            Customer::destroy($id);

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
            
            $customer = Customer::find($id);

            $table = new Transaction();
            $table->customers_id = $id;
            $table->transaction_point = 'Customer Account';
            $table->transaction_hub = 'Due Payment';
            $table->transaction_type = 'IN';
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
            
            
            
            //SMS
			$mobile_number = new BdPhone($customer->contact);
			if($mobile_number->check()){
				$user_name = 'nne';
				$password = 'Dhaka@8877';
				$from = 'N.N.E';
				$contact = "88".$customer->contact;
				$t_amount = $request->amount;
				$sms = urlencode("Dear ".$customer->name.". Your Payment of tk. ".$t_amount." is received. Thank you from Nabil & Nahin Enterprise. Mobile: 01775178283");

				file_get_contents("https://api.mobireach.com.bd/SendTextMessage?Username=nne&Password=Dhaka@8877&From=N.N.E&To=".$contact."&Message=".$sms);
			}
            //SMS

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    public function show($id){
        $customer = Customer::find($id);
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();
        $ac_book = AccountBook::orderBy('name', 'ASC')->get();
        $table = $customer->transactions()->with('accountBook', 'customer', 'warehouse')->where('status', 'Active')->orderBy('id', 'DESC')->get();
        return view('customer.transaction')->with(['table' => $table, 'warehouse' => $warehouse, 'customer' => $customer, 'ac_book' => $ac_book]);
    }

    public function customer_api(Request $request){
        $search = $request->search;

        $table = Customer::orderBy('name')
            ->orderBy('name')
            ->where('name', 'like', $search.'%')
            ->orWhere('contact', 'like', $search.'%')
            ->take(15)
            ->get();

        $data = array();

        foreach ($table as $row){
              $rowData['id'] = $row->id;
              $rowData['text'] = $row->name.' ♦ '.$row->contact;
              array_push($data, $rowData);
        }

        return response()->json(['results' => $data]);
    }

    public function customer_table_api(){
        $table = Customer::with('zone', 'customerCategory', 'warehouse')->orderBy('id', 'DESC')->get();
        return response()->json($table);
    }

    public function get_cr_bl(Request $request){
        $id = $request->id;
        $table = Customer::find($id);

        return response()->json(array($table->credit_limit, $table->dueBalance()));
    }

    public function customer_datatable(Request $request){

        $table = Customer::with('zone', 'customerCategory', 'warehouse')->orderBy('id', 'DESC')->get();

       // dd($table);
    }

}
