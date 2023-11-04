<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Teams;
USE Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Writer;
use Illuminate\Support\Facades\Form;
class ServerController extends Controller
{
    //
    public function viewservers()
    {


        $showsrvs= Server::paginate(10);
        $showteams= Teams::all();

        return view('servers.serverslist',compact('showsrvs','showteams'));
      //  return view('servers.serverslist');

        //viewpageservers
    }





    function addsrvs(Request $req){
        $req->validate([
            'names'=>'required',
            'passwords'=>'required',
            'teams'=>'required',
        ]);
       $srvadd=new Server();
       $srvadd->names=$req->names;
        $srvadd->passwords=$req->passwords;
        $srvadd->teams=$req->teams;
       $res= $srvadd->save();
        if($res){
            return redirect('viewpageservers')->with('success', 'Login Success');
        }
        return redirect('viewpageservers')->with('error', 'Login error');

    }

    public function cancelserver($id)
    {
        $showsrvs= Server::find($id);

       // return view('setting.accsetting',compact('viewprofil'));
        return view('servers.canceldserver',compact('showsrvs'));

        //return redirect('viewpagesetting/{id}');

    }

    public function updatestatusserver(Request $req,$id)
    {
        $req->validate([
            'passwords'=>'required',

           // 'password'=>'required',

        ]);
        $showsrvs= Server::find($id);
        $input=$req->all();
        $showsrvs->update($input);
        return redirect('viewpageservers');
        //return view('servers.serverslist',compact('showsrvs'));


    }
    public function cancelrequestserver($id)
    {
        $showsrvs= Server::find($id);

       // return view('setting.accsetting',compact('viewprofil'));
        return view('servers.returnd',compact('showsrvs'));

        //return redirect('viewpagesetting/{id}');

    }
    public function updatestatuscancel(Request $req,$id)
    {
        $req->validate([
            'passwords'=>'required',

           // 'password'=>'required',

        ]);
        $showsrvs= Server::find($id);
        $input=$req->all();
        $showsrvs->update($input);
        return redirect('viewpageservers');
        //return view('servers.serverslist',compact('showsrvs'));


    }






}
