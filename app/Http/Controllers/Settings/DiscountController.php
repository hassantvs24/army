<?php

namespace App\Http\Controllers\Settings;

use App\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = Discount::orderBy('id', 'DESC')->get();

        return view('settings.discount')->with(['table' => $table]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'amount' => 'required|numeric',
            'discount_type' => 'required|string|min:5|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Discount();
            $table->name = $request->name;
            $table->discount_type = $request->discount_type;
            $table->amount = $request->amount;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'amount' => 'required|numeric',
            'discount_type' => 'required|string|min:5|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = Discount::find($id);
            $table->name = $request->name;
            $table->discount_type = $request->discount_type;
            $table->amount = $request->amount;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function destroy($id)
    {
        try{

            Discount::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
