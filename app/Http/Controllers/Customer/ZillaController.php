<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Zilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZillaController extends Controller
{
    public function index()
    {
        $table = Zilla::orderBy('id', 'DESC')->get();

        return view('customer.district')->with(['table' => $table]);
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

            $table = new Zilla();
            $table->name = $request->name;
            $table->divisions_id = $request->divisions_id;
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

            $table = Zilla::find($id);
            $table->name = $request->name;
            $table->divisions_id = $request->divisions_id;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function destroy($id)
    {
        try{

            Zilla::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }

}
