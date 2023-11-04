<?php

namespace App\Http\Controllers;
use App\Models\ProvListd;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    //
    function addpv(Request $req)
    {
        $showpl = new ProvListd();
        $showpl->name = $req->name;
       // $showpl->login = $req->login;
       if ($req->name == null) {
        return redirect('viewpagelogin')->with('error1', 'error name is empty '); // Set a default value for 'comment'
       }
    
        // Check if 'comment' is provided in the request
        if ($req->comment == null) {
            $showpl->comment = ''; // Set a default value for 'comment'
        } else {
            $showpl->comment = $req->comment;
        }
        
        if ( $req->login == null) {
            $showpl->login = ''; // Set a default value for 'login'
        } else {
            $showpl->login =  $req->login;
        }
    
        $res1 = $showpl->save();
    
        if ($res1) {
            return redirect('viewpagelogin')->with('success1', 'Success');
        }
    
        return redirect('viewpagelogin')->with('error1', 'error');
    }
    function deleteprvlist($id)
    {
        $showpl= ProvListd::find($id);
        $showpl ->delete();
        return redirect('viewpagelogin')->with('success1', 'delete successfully!');

    }
    /*function deleteprvlist1($id)
    {
      
        $confirmation = request()->input('confirmation');

        if ($confirmation === 'true') {
            $showpl= ProvListd::find($id);
            $showpl->delete();

            return redirect('viewpagelogin')->with('success', 'Deleted successfully');
        }

        return redirect('viewpagelogin')->with('error', 'Deletion not confirmed');
    }*/
    public function searchindex(Request $request)
    {
        
        $queryd = $request->input('queryd');
       if ($queryd !='') {
        $showpvL = ProvListd::where('name', 'LIKE', '%' . $queryd . '%')
        ->orWhere('comment', 'LIKE', '%' . $queryd . '%')->get();
        
       // ->paginate(10);
       
       return view('singup.login',compact('showpvL'));
       }
        return redirect('viewpagelogin')->with('error1', ' error');
    }
    public function updateprvlisted(Request $req ,$id)
    {
        /*
        $showpl =  ProvListd::find($id);
        $showpl->name = $req->name;
        if ($req->name == null) {
            return redirect('viewpagelogin')->with('error1', 'error name is empty '); // Set a default value for 'comment'
        }
        if ($req->comment == null) {
            $showpl->comment = ''; // Set a default value for 'comment'
        } else {
            $showpl->comment = $req->comment;
        }
        if ( $req->login == null) {
            $showpl->login = ''; // Set a default value for 'login'
        } else {
            $showpl->login =  $req->login;
        }
        $resup= $showpl->update();
         if($resup){
             return redirect('viewpagelogin')->with('success1', 'Success');
         }
         return redirect('viewpagelogin')->with('error1', ' error');*/
    
         
         $req->validate([

            'name'=>'required',
            'login'=>'required',
            'comment'=>'required',
            

        ]);
        $showpvL = ProvListd::find($id);
      

        $showpvL->name=$req->name;
        $showpvL->login=$req->login;
        $showpvL->comment=$req->comment;
 
        $res= $showpvL->update();
         if($res){
             return redirect('viewpagelogin')->with('success1', 'Success');
         }
         return redirect('viewpagelogin')->with('error1', ' error');
        
    }

    

}
