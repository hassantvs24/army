<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{

    public function index()
    {
        $table = Shipment::orderBy('id', 'DESC')->get();

        return view('settings.shipment')->with(['table' => $table]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Shipment();
            $table->name = $request->name;
            $table->description = $request->description;
            $table->shipping_company = $request->shipping_company;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = Shipment::find($id);
            $table->name = $request->name;
            $table->description = $request->description;
            $table->shipping_company = $request->shipping_company;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            Shipment::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
