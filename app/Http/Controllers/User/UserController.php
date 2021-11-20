<?php

namespace App\Http\Controllers\User;

use App\AccountBook;
use App\Http\Controllers\Controller;
use App\User;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $table = User::orderBy('id', 'DESC')->get();
        $warehouse = Warehouse::orderBy('name')->get();
        $ac_book = AccountBook::orderBy('name')->get();
        $roles = Role::orderBy('id', 'DESC')->get();

        return view('users.users')->with(['table' => $table, 'ac_book' => $ac_book, 'warehouse' => $warehouse, 'roles' => $roles]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:191',
            'email' => 'required|string|email|min:4|max:191|unique:users,email',
            'password' => 'required|string|min:8|max:191|confirmed',
            'warehouses_id' => 'required|numeric',
            'account_books_id' => 'required|numeric',
            'role_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new User();
            $table->name = $request->name;
            $table->email = $request->email;
            $table->business_id = $request->business_id;
            $table->password = bcrypt($request->password);
            $table->warehouses_id = $request->warehouses_id;
            $table->account_books_id = $request->account_books_id;
            $table->save();

            $table->assignRole($request->role_id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:191',
            'email' => 'required|string|email|min:4|max:191|unique:users,email,'.$id.',id',
            'password' => 'required|string|min:8|max:191|confirmed',
            'warehouses_id' => 'required|numeric',
            'account_books_id' => 'required|numeric',
            'role_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = User::find($id);
            $table->name = $request->name;
            $table->email = $request->email;
            $table->business_id = $request->business_id;
            $table->password = bcrypt($request->password);
            $table->warehouses_id = $request->warehouses_id;
            $table->account_books_id = $request->account_books_id;
            $table->save();

            $table->syncRoles($request->role_id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }

    public function destroy($id)
    {
        try{

            User::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
