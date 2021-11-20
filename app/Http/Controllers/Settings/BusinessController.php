<?php

namespace App\Http\Controllers\Settings;

use App\Business;
use App\Custom\ImgUpload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{

    public function show($id)
    {
        $table = Business::find($id);

        return view('settings.business')->with(['table' => $table]);
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


            $table = Business::find($id);
            $table->name = $request->name;
            $table->contact = $request->contact;
            $table->contact_alternate = $request->contact_alternate;
            $table->phone = $request->phone;
            $table->address = $request->address;
            $table->email = $request->email;
            $table->website = $request->website;
            $table->proprietor = $request->proprietor;

            if($request->hasFile('logo')){

                $img = $table->getRawOriginal('logo');
                $img2 = 'logo_'.$img;

                $imgUp = new ImgUpload('business');
                $imgUp->del_ex($img);
                $fileName = $imgUp->upload($request->file('logo'), 412, 64);

                $imgUp->del_ex($img2);
                $imgUp->upload($request->file('logo'), 206, 32, 'logo_'.$fileName);

                $table->logo = $fileName;
            }

            $table->save();


        }catch (\Exception $ex) {
            return redirect()->back()->with(config('naz.error'));
        }

        return redirect()->back()->with(config('naz.edit'));
    }
}
