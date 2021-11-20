<?php

namespace App\Http\Controllers\Stock;

use App\Brand;
use App\Company;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\StockTransaction;
use App\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index()
    {
        $table = Product::with('brand', 'company', 'productCategory', 'unit')->orderBy('id', 'DESC')->get();
        $brand = Brand::orderBy('name', 'ASC')->get();
        $category = ProductCategory::orderBy('name', 'ASC')->get();
        $company = Company::orderBy('name', 'ASC')->get();
        $units = Units::orderBy('name', 'ASC')->get();

        return view('stock.products')->with(['table' => $table, 'brand' => $brand, 'category' => $category, 'company' => $company, 'units' => $units]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sku' => 'required|string|min:4|max:191|unique:products,sku',
            'name' => 'string|required|min:3|max:191',
            'sell_price' => 'numeric|required|min:0',
            'purchase_price' => 'numeric|required|min:0',
            'product_type' => 'string|required|min:4|max:5',
            'stock' => 'numeric|required|min:0',
            'product_categories_id' => 'numeric|required',
            'units_id' => 'numeric|required',
            'alert_quantity' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Product();
            $table->sku = $request->sku ?? mt_rand();
            $table->name = $request->name;
            $table->sell_price = $request->sell_price;
            $table->purchase_price = $request->purchase_price;
            $table->product_type = $request->product_type;
            $table->enable_stock = $request->enable_stock ?? 0;
            $table->enable_expire = $request->enable_expire ?? 0;
            $table->enable_serial = $request->enable_serial ?? 0;
            $table->alert_quantity = $request->alert_quantity ?? 0;
            $table->alert_expire_day = $request->alert_expire_day ?? 0;
            $table->barcode = $request->barcode;
            $table->description = $request->description;
            $table->stock = $request->stock;
            $table->product_categories_id = $request->product_categories_id;
            $table->brands_id = $request->brands_id;
            $table->companies_id = $request->companies_id;
            $table->units_id = $request->units_id;
            $table->vet_texes_id = $request->vet_texes_id;
            $table->tax_type = $request->tax_type;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'sku' => 'required|string|min:4|max:191|unique:products,sku,'.$id.',id',
            'name' => 'string|required|min:3|max:191',
            'sell_price' => 'numeric|required|min:0',
            'purchase_price' => 'numeric|required|min:0',
            'product_type' => 'string|required|min:4|max:5',
            'stock' => 'numeric|required|min:0',
            'product_categories_id' => 'numeric|required',
            'units_id' => 'numeric|required',
            'alert_quantity' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = Product::find($id);
            $table->sku = $request->sku ?? mt_rand();
            $table->name = $request->name;
            $table->sell_price = $request->sell_price;
            $table->purchase_price = $request->purchase_price;
            $table->product_type = $request->product_type;
            $table->enable_stock = $request->enable_stock ?? 0;
            $table->enable_expire = $request->enable_expire ?? 0;
            $table->enable_serial = $request->enable_serial ?? 0;
            $table->alert_quantity = $request->alert_quantity ?? 0;
            $table->alert_expire_day = $request->alert_expire_day ?? 0;
            $table->barcode = $request->barcode;
            $table->description = $request->description;
            $table->stock = $request->stock;
            $table->product_categories_id = $request->product_categories_id;
            $table->brands_id = $request->brands_id;
            $table->companies_id = $request->companies_id;
            $table->units_id = $request->units_id;
            $table->vet_texes_id = $request->vet_texes_id;
            $table->tax_type = $request->tax_type;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            Product::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }

    public function transaction($id){
        $table = StockTransaction::where('products_id', $id)->where('status', 'Active')->orderBy('id', 'DESC')->get();
        return view('stock.stock_transaction')->with(['table' => $table]);
    }

    public function product_api(Request $request){
        $search = $request->search;
        $type = $request->type;

        $table = Product::orderBy('name')
            ->where('name', 'like', $search.'%')
//            ->with(['productCategory' => function ($query)  use ($search) {
//                $query->orWhere('name', 'like', $search.'%');
//            }])
            ->take(15)
            ->get();

        $data = array();
        foreach ($table as $row){
            $rowData['id'] = $row->id.' -x- '.$row->sku.' -x- '.$row->name.' -x- '.($type == 'sales' ? $row->sell_price : $row->purchase_price);
            $rowData['text'] = $row->name.' ♦ '.$row->productCategory['name'].' ♦ $'.money_c($type == 'sales' ? $row->sell_price : $row->purchase_price).' ♦ ($'.money_c($type == 'sales' ? $row->purchase_price : $row->sell_price).') ♦ '.$row->currentStock().''.$row->unit['name'];
            array_push($data, $rowData);
        }

        return response()->json(['results' => $data]);
    }



}
