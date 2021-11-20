<?php

namespace App\Http\Controllers\Settings;

use App\Custom\ImgUpload;
use App\Http\Controllers\Controller;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class WareHouseController extends Controller
{

    public function index()
    {
        $table = Warehouse::orderBy('id', 'DESC')->get();

        return view('settings.warehouse')->with(['table' => $table]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:191',
            'contact' => 'required|string|min:11|max:11',
            'address' => 'required|string|max:191',
            'proprietor' => 'required|string|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = new Warehouse();
            $table->name = $request->name;
            $table->contact = $request->contact;
            $table->phone = $request->phone;
            $table->address = $request->address;
            $table->email = $request->email;
            $table->proprietor = $request->proprietor;

            if($request->hasFile('logo')){

                $imgUp = new ImgUpload('business');
                $fileName = $imgUp->upload($request->file('logo'), 412, 64);
                $imgUp->upload($request->file('logo'), 206, 32, 'logo_'.$fileName);

                $table->logo = $fileName;
            }

            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:4|max:191',
            'contact' => 'required|string|min:11|max:11',
            'address' => 'required|string|max:191',
            'proprietor' => 'required|string|max:191'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{

            $table = Warehouse::find($id);
            $table->name = $request->name;
            $table->contact = $request->contact;
            $table->phone = $request->phone;
            $table->address = $request->address;
            $table->email = $request->email;
            $table->proprietor = $request->proprietor;

            if($request->hasFile('logo')){

                $img = $table->getRawOriginal('logo');
                $img2 = 'logo_'.$img;

                $imgUp = new ImgUpload('business');
                $imgUp->del_ex($img);
                $imgUp->del_ex($img2);
                $fileName = $imgUp->upload($request->file('logo'), 412, 64);
                $imgUp->upload($request->file('logo'), 206, 32, 'logo_'.$fileName);

                $table->logo = $fileName;
            }

            $table->save();

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.save'));
    }


    public function destroy($id)
    {
        try{
            $table = Warehouse::find($id);

            $img = $table->getRawOriginal('logo');
            $img2 = 'logo_'.$img;

            $imgUp = new ImgUpload('business');
            $imgUp->del_ex($img);
            $imgUp->del_ex($img2);

            Warehouse::destroy($id);

        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.del'));
    }
}
