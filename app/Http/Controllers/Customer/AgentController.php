<?php

namespace App\Http\Controllers\Customer;

use App\Agent;
use App\Http\Controllers\Controller;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{

    public function index()
    {
        $table = Agent::orderBy('id', 'DESC')->get();
        $warehouse = Warehouse::orderBy('name', 'ASC')->get();

        return view('customer.agent')->with(['table' => $table, 'warehouse' => $warehouse]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'string|required|max:191',
            'name' => 'string|required|max:191',
            'warehouses_id' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Agent();
            $table->name = $request->name;
            $table->code = $request->code;
            $table->warehouses_id = $request->warehouses_id;
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
            'name' => 'string|required|max:191',
            'warehouses_id' => 'numeric|required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = Agent::find($id);
            $table->name = $request->name;
            $table->code = $request->code;
            $table->warehouses_id = $request->warehouses_id;
            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function destroy($id)
    {
        try{

            Agent::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
