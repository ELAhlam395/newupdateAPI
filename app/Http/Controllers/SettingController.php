<?php

namespace App\Http\Controllers;

use App\Models\singup;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
USE Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Form;
class SettingController extends Controller
{
    //
    public function viewsetting($id)
    {
         $viewprofil= singup::find($id);
         return view('setting.accsetting',compact('viewprofil'));
        //viewpagesetting
    }



    public function updatesetting(Request $req,$id )
    {

        $req->validate([
            'fname'=>'required',
            'lname'=>'required',
            'name'=>'required',
            'email'=>'required',
           // 'password'=>'required',

        ]);
        $viewprofil= singup::find($id);
        $input=$req->all();
        $viewprofil->update($input);
    	return redirect('viewpagesetting/{id}')->with('success', 'update successfully!');


    }

    public function updatepassword(Request $req,$id)
    {

        $req->validate([
            'oldpassword'=>'required',
            'newpassword'=>'required',
            'confirmpassword'=>'same:newpassword',


        ]);

        $data=$req->all();
        $viewprofil= singup::find($id);
        if (!Hash::check($data['oldpassword'],$viewprofil->password)) {
            return redirect('viewpagesetting/{id}')->with('error', ' incorect password!');

        }

        else {

            $viewprofil->update([
                'password' =>Hash::make($req->newpassword),
            ]);
            return redirect('viewpagesetting/{id}')->with('success', 'update  password!');
        }


    }


}
