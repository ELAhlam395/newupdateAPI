<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\singup;
use App\Models\Team;
use App\Models\proxy;
use App\Models\Server;
use App\Models\Domain;
USE Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use session;
use App\Models\ProvListd;
use App\Models\providerproxy;
use Illuminate\Support\Facades\Form;

class singupController extends Controller
{
    public function viewhome()
    {
        $resultsteams=Team::paginate(10);
        $resultsusers=singup::paginate(10);
        
        $resultsproxy=proxy::paginate(10);
        $resultssever=Server::paginate(10);
        $resultsdomain=Domain::paginate(10);
        return view('singup.home', compact('resultsusers','resultsteams','resultsproxy','resultssever','resultsdomain'));
        //viewpagehome
    }
    public function viewlogin()
    {
        $showpvL= ProvListd::all();
        //return view('singup.login',compact('showpvL'));
        return view('singup.login',compact('showpvL'));
        //viewpagelogin
    }
    public function viewregister()
    {
        $showutm= Team::all();
        return view('singup.regist',compact('showutm'));

       // return view('singup.regist');
        //viewpageregist
    }

    public function viewusers()
    {

        $showuser = singup::all();
        $showutm= Team::all();
        return view('singup.showusers',compact('showuser','showutm'));


        /*return view('singup.showusers');*/


        //viewpageshowusers
    }



































    function registration(Request $req){
        $req->validate([
            'fname'=>'required',
            'lname'=>'required',
            'name'=>'required',
            'email'=>'required|email|unique:singuptable',
            'password'=>'required',
           'rd'=>'required',
           'tm'=>'required',
        ]);

       $usedadd=new singup;
       $usedadd->fname=$req->fname;
       $usedadd->lname=$req->lname;
        $usedadd->name=$req->name;
        $usedadd->email=$req->email;


     $usedadd->password=Hash::make($req->password);
      $usedadd->rd=$req->rd;
     $usedadd->tm=$req->tm;
       $res= $usedadd->save();
        if($res){


            return redirect('viewpageregist')->with('success', 'Login Success');
        }
        return redirect('viewpageregist')->with('error', 'Login error');

    }
    function login(Request $request ){

        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        $credentials = $request->only(['email', 'password']);
        if(auth::attempt($credentials)){
            return redirect()->intended('viewpagehome');
            }
        return redirect('viewpagehome')->with("error", "Login details are not valid");

    }
    public function logout()
    {
        Auth::logout();
        return redirect('viewpagehome');
    }


















    /////////add user page manger ---------------------
    function addusers(Request $req){
        $req->validate([
            'fname'=>'required',
            'lname'=>'required',
            'name'=>'required',
            'email'=>'required|email|unique:singuptable',
            'password'=>'required',
           'rd'=>'required',
           'tm'=>'required',
        ]);
       $usedadd=new singup;
       $usedadd->fname=$req->fname;
        $usedadd->lname=$req->lname;
        $usedadd->name=$req->name;
        $usedadd->email=$req->email;

        $usedadd->password=Hash::make($req->password);
      $usedadd->rd=$req->rd;
      $usedadd->tm=$req->tm;
       $res= $usedadd->save();
        if($res){
            return redirect('viewpageshowusers')->with('success', 'Login Success');
        }
        return redirect('viewpageshowusers')->with('error', 'Login error');

    }
















   /* public function dashboard()
    {
        return "welcom dashboard";

    }*/
    public function edituser($id)
    {
        $showuser= singup::find($id);
        $showutm= Team::all();
       // return view('setting.accsetting',compact('viewprofil'));
        return view('singup.edituser',compact('showuser','showutm'));

        //return redirect('viewpagesetting/{id}');

    }
    public function updateuser(Request $req,$id)
    {
        $req->validate([
            'name'=>'required',
            'email'=>'required',
            'rd'=>'required',
            'tm'=>'required',
           // 'password'=>'required',

        ]);
        $showuser= singup::find($id);
        $input=$req->all();
        $showuser->update($input);
        return redirect('viewpageshowusers')->with('success1', 'update successfully!');

       // return view('setting.accsetting',compact('viewprofil'));
       // return view('singup.edituser',compact('showuser','showutm'));

        //return redirect('viewpagesetting/{id}');

    }
     public function deleteuser($id)
    {
        $showuser= singup::find($id);
        $showuser ->delete();
        return redirect('viewpageshowusers')->with('success1', 'delete successfully!');

    }

    public function searchuser(Request $request)
    {

       $showutm= Team::all();
        $queryusr = $request->input('queryusr');
       if ($queryusr !='') {
        $showuser = singup::where('name', 'LIKE', '%' . $queryusr . '%')
        ->orWhere('email', 'LIKE', '%' . $queryusr . '%')
        ->orWhere('rd', 'LIKE', '%' . $queryusr . '%')
        ->get();
       return view('singup.showusers',compact('showuser','showutm'));
       }
        return redirect('viewpageshowusers');

    }
    




























}
