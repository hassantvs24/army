<?php

namespace App\Http\Controllers\Purchase;

use App\AccountBook;
use App\Discount;
use App\Http\Controllers\Controller;
use App\Product;
use App\PurchaseInvoice;
use App\PurchaseItem;
use App\Shipment;
use App\Supplier;
use App\Transaction;
use App\VetTex;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{

    public function index()
    {
        $products = Product::with('brand', 'company', 'productCategory', 'unit')->orderBy('name')->get();
        $supplier = Supplier::orderBy('name')->get();
        $warehouse = Warehouse::orderBy('name')->get();
        $discount = Discount::orderBy('name')->get();
        $shipment = Shipment::orderBy('name')->get();
        $vat_tax = VetTex::orderBy('name')->get();
        $ac_book = AccountBook::orderBy('name')->get();

        return view('purchase.purchase')->with(['supplier' => $supplier, 'products' => $products, 'warehouse' => $warehouse, 'discount' => $discount, 'shipment' => $shipment, 'vat_tax' => $vat_tax, 'ac_book' => $ac_book]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:4|max:191|unique:purchase_invoices,code',
            'status' => 'required|string|max:10',
            'suppliers_id' => 'required|numeric',
            'warehouses_id' => 'required|numeric',
            'total_all_pay' => 'required|numeric',
            'additional_charges' => 'required|numeric',
            'vet_texes_amount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'created_at' => 'required|date_format:d/m/Y',
            'qty' => 'required|array',
            'price' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try{

            $supplier = Supplier::find($request->suppliers_id);

            $table = new PurchaseInvoice();
            $table->code = $request->code ?? mt_rand();
            $table->name  = $supplier->name;
            $table->address = $supplier->address;
            $table->email  = $supplier->email;
            $table->contact  = $supplier->contact;
            $table->status  = $request->status;
            $table->discount_amount  = $request->discount_amount;
            $table->vet_texes_amount  = $request->vet_texes_amount;
            $table->additional_charges  = $request->additional_charges;
            $table->description  = $request->invoice_description;
            $table->suppliers_id  = $request->suppliers_id;
            $table->shipments_id  = $request->shipments_id;
            $table->discounts_id  = $request->discounts_id;
            $table->vet_texes_id  = $request->vet_texes_id;
            $table->warehouses_id  = $request->warehouses_id;
            $table->created_at  = $request->created_at;
            $table->save();
            $invoice_id = $table->id;

            $qtys = $request->qty;
            $price = $request->price;
            $ck_status = ck_status($request->status, 'Received');//Change Status

            foreach ($qtys as $id => $qty){

                if($qty > 0){
                    $product = Product::find($id);

                    $trItem = new PurchaseItem();
                    $trItem->name = $product->name;
                    $trItem->sku = $product->sku;
                    $trItem->batch_no = $request->code;
                    $trItem->quantity = $qty;
                    $trItem->amount = $price[$id];
                    $trItem->unit = $product->unit['name'];
                    $trItem->status = $ck_status;
                    $trItem->products_id = $id;
                    $trItem->warehouses_id = $request->warehouses_id;
                    $trItem->purchase_invoices_id = $invoice_id;
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

            $ck_status = ($request->status == 'Pending' ? 'Inactive':'Active');

            if($request->total_all_pay > 0){
                foreach ($amounts as $i => $amount){
                    $payment = new Transaction();
                    $payment->amount = $amount;
                    $payment->transaction_point = 'Purchase';
                    $payment->transaction_hub = 'General';
                    $payment->transaction_type = 'OUT';
                    $payment->payment_method = $payment_method[$i];
                    $payment->cheque_number = null_filter($cheque_number[$i]);
                    $payment->bank_account_no = null_filter($bank_account_no[$i]);
                    $payment->transaction_no = null_filter($transaction_no[$i]);
                    $payment->description = null_filter($description[$i]);
                    $payment->warehouses_id = $request->warehouses_id;
                    $payment->account_books_id = $account_books_id[$i];
                    $payment->status = $ck_status;
                    $payment->suppliers_id = $request->suppliers_id;
                    $payment->purchase_invoices_id = $invoice_id;
                    $payment->created_at  = $request->created_at;
                    $payment->save();
                }
            }

            DB::commit();
        }catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->route('purchase.show', ['purchase' => $invoice_id]);
    }


    public function show($id)
    {
        $table = PurchaseInvoice::find($id);

        return view('purchase.print.invoice')->with(['table' => $table]);
    }


    public function edit($id){
        $table = PurchaseInvoice::find($id);
        $products = Product::with('brand', 'company', 'productCategory', 'unit')->orderBy('name')->get();
        $supplier = Supplier::orderBy('name')->get();
        $warehouse = Warehouse::orderBy('name')->get();
        $discount = Discount::orderBy('name')->get();
        $shipment = Shipment::orderBy('name')->get();
        $vat_tax = VetTex::orderBy('name')->get();
        $ac_book = AccountBook::orderBy('name')->get();

        $items = $table->purchaseItems()->get();
        $payments = $table->transactions()->with('accountBook')->get();

        return view('purchase.purchase_edit')
            ->with(['table' => $table,
                'supplier' => $supplier,
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
            'code' => 'required|string|min:4|max:191|unique:purchase_invoices,code,'.$id.',id',
            'status' => 'required|string|max:10',
            'suppliers_id' => 'required|numeric',
            'warehouses_id' => 'required|numeric',
            'total_all_pay' => 'required|numeric',
            'additional_charges' => 'required|numeric',
            'vet_texes_amount' => 'required|numeric',
            'discount_amount' => 'required|numeric',
            'created_at' => 'required|date_format:d/m/Y',
            'qty' => 'required|array',
            'price' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try{

            $supplier = Supplier::find($request->suppliers_id);

            $table = PurchaseInvoice::find($id);
            $table->code = $request->code ?? mt_rand();
            $table->name  = $supplier->name;
            $table->address = $supplier->address;
            $table->email  = $supplier->email;
            $table->contact  = $supplier->contact;
            $table->status  = $request->status;
            $table->discount_amount  = $request->discount_amount;
            $table->vet_texes_amount  = $request->vet_texes_amount;
            $table->additional_charges  = $request->additional_charges;
            $table->description  = $request->invoice_description;
            $table->suppliers_id  = $request->suppliers_id;
            $table->shipments_id  = $request->shipments_id;
            $table->discounts_id  = $request->discounts_id;
            $table->vet_texes_id  = $request->vet_texes_id;
            $table->warehouses_id  = $request->warehouses_id;
            $table->created_at  = $request->created_at;
            $table->save();
            $invoice_id = $id;

            $qtys = $request->qty;
            $price = $request->price;
            $item_id = $request->item_id;
            $ck_status = ck_status($request->status, 'Received');//Change Status

            PurchaseItem::where('purchase_invoices_id', $invoice_id)->delete(); //Delete Purchase Item

            foreach ($qtys as $pid => $qty){

                if($qty > 0){
                    $product = Product::find($pid);

                    PurchaseItem::updateOrCreate(
                        ['id' => $item_id[$pid]],
                        [
                            'name' => $product->name,
                            'sku' => $product->sku,
                            'batch_no' => $request->code,
                            'quantity' => $qty,
                            'amount' => $price[$pid],
                            'unit' => $product->unit['name'],
                            'products_id' => $pid,
                            'status' => $ck_status,
                            'warehouses_id' => $request->warehouses_id,
                            'purchase_invoices_id' => $invoice_id,
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

            Transaction::where('purchase_invoices_id', $invoice_id)->delete(); //Delete Payment

            if($request->total_all_pay > 0){

                $ck_status = ($request->status == 'Pending' ? 'Inactive':'Active');

                foreach ($amounts as $i => $amount){

                    Transaction::updateOrCreate(
                        ['id' => $payment_id[$i]],
                        [
                            'amount' => $amount,
                            'transaction_point' => 'Purchase',
                            'transaction_hub' => 'General',
                            'transaction_type' => 'OUT',
                            'payment_method' => null_filter($payment_method[$i]),
                            'cheque_number' => null_filter($cheque_number[$i]),
                            'bank_account_no' => null_filter($bank_account_no[$i]),
                            'transaction_no' => null_filter($transaction_no[$i]),
                            'description' => null_filter($description[$i]),
                            'status' => $ck_status,
                            'warehouses_id' => $request->warehouses_id,
                            'account_books_id' => $account_books_id[$i],
                            'suppliers_id' => $request->suppliers_id,
                            'purchase_invoices_id' => $invoice_id,
                            'created_at' => $request->created_at
                        ]
                    );
                }
            }
            DB::commit();
        }catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->route('purchase-list.index')->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            PurchaseInvoice::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
