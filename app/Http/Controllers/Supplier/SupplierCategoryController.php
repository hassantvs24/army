<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\SupplierCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierCategoryController extends Controller
{

    public function index()
    {
        $table = SupplierCategory::orderBy('id', 'DESC')->get();

        return view('supplier.category')->with(['table' => $table]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'string|required|max:191',
            'name' => 'string|required|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new SupplierCategory();
            $table->name = $request->name;
            $table->code = $request->code;
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
            'name' => 'string|required|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = SupplierCategory::find($id);
            $table->name = $request->name;
            $table->code = $request->code;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            SupplierCategory::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
