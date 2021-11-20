<?php

namespace App\Http\Controllers\Sales;

use App\AccountBook;
use App\Agent;
use App\Customer;
use App\CustomerCategory;
use App\Discount;
use App\Http\Controllers\Controller;
use App\InvoiceItem;
use App\Product;
use App\SellInvoice;
use App\Shipment;
use App\Transaction;
use App\UpaZilla;
use App\VetTex;
use App\Warehouse;
use App\Zilla;
use App\Custom\BdPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index()
    {
        $warehouse = Warehouse::orderBy('name')->get();
        $discount = Discount::orderBy('name')->get();
        $shipment = Shipment::orderBy('name')->get();
        $vat_tax = VetTex::orderBy('name')->get();
        $ac_book = AccountBook::orderBy('name')->get();

        $upa_zilla = UpaZilla::orderBy('name', 'ASC')->get();
        $zilla  = Zilla::orderBy('name', 'ASC')->get();
        $category = CustomerCategory::orderBy('name', 'ASC')->get();
        $agent = Agent::orderBy('name', 'ASC')->get();

        return view('sales.sales')->with(['zilla' => $zilla, 'category' => $category, 'agent' => $agent, 'upa_zilla' => $upa_zilla, 'warehouse' => $warehouse, 'discount' => $discount, 'shipment' => $shipment, 'vat_tax' => $vat_tax, 'ac_book' => $ac_book]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:4|max:191|unique:purchase_invoices,code',
            'status' => 'required|string|max:10',
            'customers_id' => 'required|numeric',
            'warehouses_id' => 'required|numeric',
            'total_all_pay' => 'required|numeric',
            'additional_charges' => 'required|numeric',
            'vet_texes_amount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'created_at' => 'required|date_format:d/m/Y',
            'due_date' => 'required|date_format:d/m/Y',
            'name' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
            'discounts' => 'required|array',
            'discount_type' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        try{
            $customer = Customer::find($request->customers_id);
            
            $table = new SellInvoice();
            $table->code = $request->code ?? mt_rand();
            $table->name  = $customer->name;
            $table->address = $customer->address;
            $table->email  = $customer->email;
            $table->contact  = $customer->contact;
            $table->status  = $request->status;
            $table->discount_amount  = $request->discount_amount;
            $table->vet_texes_amount  = $request->vet_texes_amount;
            $table->additional_charges  = $request->additional_charges;
            $table->description  = $request->invoice_description;
            $table->customers_id  = $request->customers_id;
            $table->shipments_id  = $request->shipments_id;
            $table->discounts_id  = $request->discounts_id;
            $table->vet_texes_id  = $request->vet_texes_id;
            $table->warehouses_id  = $request->warehouses_id;
            $table->agents_id  = $customer->agent_id ?? null;
            $table->due_date  = $request->due_date;
            $table->created_at  = $request->created_at;
            $table->save();
            $invoice_id = $table->id;
            
            $qtys = $request->qty;
            $name = $request->name;
            $price = $request->price;
            $discount_type = $request->discount_type;
            $discounts = $request->discounts;
            $ck_status = ck_status($request->status, 'Final');//Change Status
            
            foreach ($qtys as $id => $qty){
                
                if($qty > 0){
                    $product = Product::find($id);
                    
                    $trItem = new InvoiceItem();
                    $trItem->name = $name[$id];
                    $trItem->sku = $product->sku;
                    $trItem->purchase_amount = $product->purchase_price;
                    $trItem->batch_no = $request->code;
                    $trItem->quantity = $qty;
                    $trItem->amount = $price[$id];
                    $trItem->unit = $product->unit['name'];
                    $trItem->discount_amount = $discounts[$id];
                    $trItem->discount_type = $discount_type[$id];
                    $trItem->products_id = $id;
                    $trItem->status = $ck_status;
                    $trItem->warehouses_id = $request->warehouses_id;
                    $trItem->sell_invoices_id = $invoice_id;
                    $trItem->created_at  = $request->created_at;
                    $trItem->save();
                }
            }
            
            $amounts = $request->amount;
            $payment_method = $request->payment_method;
            $cheque_number = $request->cheque_number;
            $bank_account_no = $request->bank_account_no;
            $transaction_no = $request->transaction_no;
            $description = $request->description;
            $account_books_id = $request->account_books_id;
            
            if($request->total_all_pay > 0){
				$t_amount = 0;
                foreach ($amounts as $i => $amount){
                    $payment = new Transaction();
                    $payment->amount = $amount;
                    $payment->transaction_point = 'Sales';
                    $payment->transaction_hub = 'General';
                    $payment->transaction_type = 'IN';
                    $payment->payment_method = $payment_method[$i];
                    $payment->cheque_number = null_filter($cheque_number[$i]);
                    $payment->bank_account_no = null_filter($bank_account_no[$i]);
                    $payment->transaction_no = null_filter($transaction_no[$i]);
                    $payment->description = null_filter($description[$i]);
                    $payment->warehouses_id = $request->warehouses_id;
                    $payment->account_books_id = $account_books_id[$i];
                    $payment->status = $ck_status;
                    $payment->customers_id = $request->customers_id;
                    $payment->sell_invoices_id = $invoice_id;
                    $payment->created_at  = $request->created_at;
                    $payment->save();
					
					$t_amount += $amount;
                }
				
    			//SMS
    			/*$mobile_number = new BdPhone($customer->contact);
    			if($mobile_number->check()){
    				$user_name = 'nne';
    				$password = 'Dhaka@8877';
    				$from = 'N.N.E';
    				$contact = "88".$customer->contact;
    				$sms = urlencode("Dear ".$customer->name.". Your Payment of tk. ".$t_amount." is received. Thank you from Nabil & Nahin Enterprise. Mobile: 01775178283");
    
    				file_get_contents("https://api.mobireach.com.bd/SendTextMessage?Username=nne&Password=Dhaka@8877&From=N.N.E&To=".$contact."&Message=".$sms);
    			}
                //SMS*/
            }
            
            DB::commit();
        }catch (\Exception $ex) {
            DB::rollback();
            dd($ex);
            return redirect()->back()->with(config('naz.error'));
        }
        
        return redirect()->route('sales.show', ['sale' => $invoice_id]);
        
    }

    public function show($id)
    {
        $table = SellInvoice::find($id);

        return view('sales.print.invoice')->with(['table' => $table]);
    }

    public function edit($id)
    {
        $table = SellInvoice::find($id);
        $products = Product::with('brand', 'company', 'productCategory', 'unit')->orderBy('name')->get();
        $customer = Customer::orderBy('name')->get();
        $warehouse = Warehouse::orderBy('name')->get();
        $discount = Discount::orderBy('name')->get();
        $shipment = Shipment::orderBy('name')->get();
        $vat_tax = VetTex::orderBy('name')->get();
        $ac_book = AccountBook::orderBy('name')->get();

        $items = $table->invoiceItems()->get();
        $payments = $table->transactions()->with('accountBook')->get();

        return view('sales.sales_edit')->with([
            'table' => $table,
            'customer' => $customer,
            'products' => $products,
            'warehouse' => $warehouse,
            'discount' => $discount,
            'shipment' => $shipment,
            'vat_tax' => $vat_tax,
            'ac_book' => $ac_book,
            'items' => $items,
            'payments' => $payments
        ]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:4|max:191|unique:sell_invoices,code,'.$id.',id',
            'status' => 'required|string|max:10',
            'customers_id' => 'required|numeric',
            'warehouses_id' => 'required|numeric',
            'total_all_pay' => 'required|numeric',
            'additional_charges' => 'required|numeric',
            'vet_texes_amount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'created_at' => 'required|date_format:d/m/Y',
            'due_date' => 'required|date_format:d/m/Y',
            'name' => 'required|array',
            'qty' => 'required|array',
            'price' => 'required|array',
            'discounts' => 'required|array',
            'discount_type' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try{

                $customer = Customer::find($request->customers_id);
    
                $table = SellInvoice::find($id);
                $table->code = $request->code ?? mt_rand();
                $table->name  = $customer->name;
                $table->address = $customer->address;
                $table->email  = $customer->email;
                $table->contact  = $customer->contact;
                $table->status  = $request->status;
                $table->discount_amount  = $request->discount_amount;
                $table->vet_texes_amount  = $request->vet_texes_amount;
                $table->additional_charges  = $request->additional_charges;
                $table->description  = $request->invoice_description;
                $table->customers_id  = $request->customers_id;
                $table->shipments_id  = $request->shipments_id;
                $table->discounts_id  = $request->discounts_id;
                $table->vet_texes_id  = $request->vet_texes_id;
                $table->warehouses_id  = $request->warehouses_id;
                $table->agents_id  = $customer->agent_id ?? null;
                $table->created_at  = $request->created_at;
                $table->due_date  = $request->due_date;
                $table->save();
                $invoice_id = $id;
    
                $qtys = $request->qty;
                $name = $request->name;
                $price = $request->price;
                $item_id = $request->item_id;
                $discount_type = $request->discount_type;
                $discounts = $request->discounts;
                $ck_status = ck_status($request->status, 'Final');//Change Status
    
                InvoiceItem::where('sell_invoices_id', $invoice_id)->delete(); //Delete Purchase Item
    
                foreach ($qtys as $pid => $qty){
    
                    if($qty > 0){
                        $product = Product::find($pid);
    
                        InvoiceItem::updateOrCreate(
                            ['id' => $item_id[$pid]],
                            [
                                'name' => $name[$pid],
                                'sku' => $product->sku,
                                'batch_no' => $request->code,
                                'quantity' => $qty,
                                'amount' => $price[$pid],
                                'discount_amount' => $discounts[$pid],
                                'discount_type' => $discount_type[$pid],
                                'unit' => $product->unit['name'],
                                'products_id' => $pid,
                                'status' => $ck_status,
                                'warehouses_id' => $request->warehouses_id,
                                'sell_invoices_id' => $invoice_id,
                                'created_at' => $request->created_at
                            ]
                        );
    
                    }
                }
    
                $amounts = $request->amount;
                $payment_method = $request->payment_method;
                $cheque_number = $request->cheque_number;
                $bank_account_no = $request->bank_account_no;
                $transaction_no = $request->transaction_no;
                $description = $request->description;
                $account_books_id = $request->account_books_id;
                $payment_id = $request->payment_id;
    
                Transaction::where('sell_invoices_id', $invoice_id)->delete(); //Delete Payment
    
                if($request->total_all_pay > 0){
                    foreach ($amounts as $i => $amount){
    
                        Transaction::updateOrCreate(
                            ['id' => $payment_id[$i]],
                            [
                                'amount' => $amount,
                                'transaction_point' => 'Sales',
                                'transaction_hub' => 'General',
                                'transaction_type' => 'IN',
                                'payment_method' => null_filter($payment_method[$i]),
                                'cheque_number' => null_filter($cheque_number[$i]),
                                'bank_account_no' => null_filter($bank_account_no[$i]),
                                'transaction_no' => null_filter($transaction_no[$i]),
                                'description' => null_filter($description[$i]),
                                'warehouses_id' => $request->warehouses_id,
                                'account_books_id' => $account_books_id[$i],
                                'status' => $ck_status,
                                'customers_id' => $request->customers_id,
                                'sell_invoices_id' => $invoice_id,
                                'created_at' => $request->created_at
                            ]
                        );
                    }
                    
                    
			
                }
                
                
    // 			//SMS
    // 			$mobile_number = new BdPhone($customer->contact);
    // 			if($mobile_number->check()){
    // 				$user_name = 'nne';
    // 				$password = 'Dhaka@8877';
    // 				$from = 'N.N.E';
    // 				$contact = "88".$customer->contact;
    // 				$sms = urlencode("Dear ".$customer->name.". Your Payment of tk. ".$t_amount." is received. Thank you from NNE");
    
    // 				file_get_contents("https://api.mobireach.com.bd/SendTextMessage?Username=nne&Password=Dhaka@8877&From=N.N.E&To=".$contact."&Message=".$sms);
    // 			}
            
            
            DB::commit();
        }catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->route('sales-list.index')->with(config('naz.edit'));
    }




    public function destroy($id)
    {
        try{

            SellInvoice::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }

}
