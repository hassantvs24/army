<?php

namespace App\Http\Controllers\Report;

use App\Brand;
use App\Company;
use App\Custom\DbDate;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCategory;
use App\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function index(){

        $table = Product::with('brand', 'company', 'productCategory', 'unit')->orderBy('name')->get();
        $brand = Brand::orderBy('name', 'ASC')->get();
        $category = ProductCategory::orderBy('name', 'ASC')->get();
        $company = Company::orderBy('name', 'ASC')->get();
        return view('reports.stock')->with(['table' => $table, 'brand' => $brand, 'category' => $category, 'company' => $company]);
    }

    public function reports(Request $request){

       // dd($request->all());

        $tablex = Product::with('brand', 'company', 'productCategory', 'unit')->orderBy('name');

            if(!empty($request->expense_categories_id)){
                $tablex->where('product_type', $request->product_type);
            }

            if(!empty($request->product_categories_id)){
                $tablex->where('product_categories_id', $request->product_categories_id);
            }

            if(!empty($request->companies_id)){
                $tablex->where('companies_id', $request->companies_id);
            }

        $table = $tablex->get();

        return view('reports.print.stock-product')->with(['table' => $table, 'request' => $request->all()]);
    }


    public function transaction(Request $request){
        $validator = Validator::make($request->all(), [
            'date_range' => 'required|string|min:23|max:23',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $dt = new DbDate($request->date_range);
        $tablex = StockTransaction::whereBetween('created_at', $dt->ftr())->where('status', 'Active');
        if(!empty($request->products_id)){
            $tablex->where('products_id', $request->products_id);
        }
        $table = $tablex->get();

        return view('reports.print.product-transaction')->with(['table' => $table, 'request' => $request->all()]);
    }
}
