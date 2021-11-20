<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{

    public function index()
    {
        $table = Units::orderBy('id', 'DESC')->get();

        return view('stock.units')->with(['table' => $table]);
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

            $table = new Units();
            $table->name = $request->name;
            $table->full_name = $request->full_name;
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

            $table = Units::find($id);
            $table->name = $request->name;
            $table->full_name = $request->full_name;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }


    public function destroy($id)
    {
        try{

            Units::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
