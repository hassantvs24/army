<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Product;
use App\StockAdjustment;
use App\StockAdjustmentItem;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdjustmentController extends Controller
{

    public function index()
    {
        $table = StockAdjustment::with('warehouse')->orderBy('id', 'DESC')->get();
        $warehouse = Warehouse::orderBy('id', 'DESC')->get();
        $products = Product::with('brand', 'company', 'productCategory', 'unit')->orderBy('id', 'DESC')->get();

        return view('stock.adjustment')->with(['table' => $table, 'products' => $products, 'warehouse' => $warehouse]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:4|max:191',
            'recover_amount' => 'required|numeric',
            'warehouses_id' => 'required|numeric',
            'qty' => "required|array",
            'created_at' => 'required|date_format:d/m/Y',
            'action' => "required|array"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{

            $table = new StockAdjustment();
            $table->code = $request->code ?? mt_rand();
            $table->recover_amount  = $request->recover_amount  ?? 0;
            $table->description = $request->description;
            $table->warehouses_id = $request->warehouses_id;
            $table->created_at = $request->created_at;
            $table->save();
            $stock_adjustments_id = $table->id;

            $qty = $request->qty;
            $action = $request->action;

            foreach ($qty as $id => $row){
                if($row > 0){
                    $product = Product::find($id);

                    $trItem = new StockAdjustmentItem();
                    $trItem->name = $product->name;
                    $trItem->sku = $product->sku;
                    $trItem->quantity = $row;
                    $trItem->amount = $product->purchase_price;
                    $trItem->unit = $product->unit['name'];
                    $trItem->adjustment_action = $action[$id];
                    $trItem->products_id = $id;
                    $trItem->warehouses_id = $request->warehouses_id;
                    $trItem->created_at = $request->created_at;
                    $trItem->stock_adjustments_id = $stock_adjustments_id;
                    $trItem->save();
                }
            }

            DB::commit();
        }catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    public function get_items($id)
    {
        $table = StockAdjustmentItem::where('stock_adjustments_id', $id)->get();

        $data = [];
        foreach ($table as $row){
            $rowData['id'] = $row->products_id;
            $rowData['sku'] = $row->sku;
            $rowData['name'] = $row->name;
            $rowData['qty'] = $row->quantity;
            $rowData['action'] = $row->adjustment_action;
            $data[] = $rowData;
        }

        return response()->json($data);
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|min:4|max:191',
            'recover_amount' => 'required|numeric',
            'warehouses_id' => 'required|numeric',
            'qty' => "required|array",
            'created_at' => 'required|date_format:d/m/Y',
            'action' => "required|array"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try{
            $table = StockAdjustment::find($id);
            $table->code = $request->code ?? mt_rand();
            $table->recover_amount  = $request->recover_amount  ?? 0;
            $table->description = $request->description;
            $table->warehouses_id = $request->warehouses_id;
            $table->created_at = $request->created_at;
            $table->save();

            $qty = $request->qty;
            $action = $request->action;

            StockAdjustmentItem::where('stock_adjustments_id', $id)->delete();

            foreach ($qty as $ids => $row){
                if($row > 0){
                    $product = Product::find($ids);

                    $trItem = new StockAdjustmentItem();
                    $trItem->name = $product->name;
                    $trItem->sku = $product->sku;
                    $trItem->quantity = $row;
                    $trItem->amount = $product->purchase_price;
                    $trItem->unit = $product->unit['name'];
                    $trItem->adjustment_action = $action[$ids];
                    $trItem->products_id = $ids;
                    $trItem->created_at = $request->created_at;
                    $trItem->warehouses_id = $request->warehouses_id;
                    $trItem->stock_adjustments_id = $id;
                    $trItem->save();
                }
            }

            DB::commit();
        }catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            StockAdjustment::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }

}
