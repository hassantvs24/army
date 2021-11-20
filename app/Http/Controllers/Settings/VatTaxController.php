<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\VetTex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VatTaxController extends Controller
{

    public function index()
    {
        $table = VetTex::orderBy('id', 'DESC')->get();

        return view('settings.vat_tax')->with(['table' => $table]);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new VetTex();
            $table->name = $request->name;
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = VetTex::find($id);
            $table->name = $request->name;
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

            VetTex::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
