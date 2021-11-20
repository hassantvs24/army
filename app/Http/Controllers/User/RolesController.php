<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $table = Role::orderBy('id', 'DESC')->get();
        $permissions = Permission::orderBy('name', 'ASC')->get()->chunk(20);

        return view('users.roles')->with(['table' => $table, 'permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Role();
            $table->name = $request->name;
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $table = Role::find($id);
            $table->name = $request->name;
            $table->save();
        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }
        return redirect()->back()->with(config('naz.save'));
    }

    public function destroy($id)
    {
        try{
            Role::destroy($id);
        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }
        return redirect()->back()->with(config('naz.del'));
    }

    public function assign_role(Request $request, $id){
        try{
            $role = Role::find($id);

            $role->syncPermissions($request->permissions);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }
        return redirect()->back()->with(config('naz.save'));
    }
}
