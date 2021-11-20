<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\UpaZilla;
use App\Zilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpaZillaController extends Controller
{

    public function index()
    {
        $table = UpaZilla::orderBy('id', 'DESC')->get();
        $zilla = Zilla::orderBy('name')->get();

        return view('customer.sub_district')->with(['table' => $table, 'zilla' => $zilla]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zillas_id' => 'numeric|required',
            'name' => 'string|required|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new UpaZilla();
            $table->name = $request->name;
            $table->zillas_id = $request->zillas_id;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'zillas_id' => 'numeric|required',
            'name' => 'string|required|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = UpaZilla::find($id);
            $table->name = $request->name;
            $table->zillas_id = $request->zillas_id;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function destroy($id)
    {
        try{

            UpaZilla::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
