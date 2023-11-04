<?php

namespace App\Http\Controllers;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\singup;
use App\Models\proxy;
use App\Models\Server;
use App\Models\_deleted_team;
use Illuminate\Support\Facades\Form;

class TeamsController extends Controller
{
    //
    public function viewteams(Request $request)
    {
        $showteams= Team::all();
         return view('team',compact('showteams'));
        //viewpageteams
    }
    function addteam(Request $req)
    {
        $req->validate([
            
            'Name'=>'required',

        ]);

       $showteams=new Team();
       $showteams->Name=$req->Name;
       

       $res= $showteams->save();
        if($res){
            return redirect('viewpageteams')->with('success', 'Success');
        }
        return redirect('viewpageteams')->with('error', ' error');

    }
    public function searchtem(Request $request)
    {
        $querytm = $request->input('querytm');
       if ($querytm !='') {
        $showteams = Team::where('Name', 'LIKE', '%' . $querytm . '%')
        ->get();
       return view('team',compact('showteams'));
       }
        return redirect('viewpageteams');
    }
    public function deletetem($id)
    {
       // Retrieve all records in the 'singup' table where 'tm' is equal to $id
       $references = singup::where('tm', $id)->get();
       // Retrieve all records in the 'proxy' table where 'teamproxy' is equal to $id
       $references1 = proxy::where('teamproxy', $id)->get();
       // Retrieve all records in the 'Server' table where 'TEAM5' is equal to $id
       $references2 = Server::where('TEAM5', $id)->get();
       $showteams = Team::where('id', $id)->first();
       // Check if either $references or $references1 is empty
       if ($references->isEmpty() && $references1->isEmpty()  && $references2->isEmpty()) {
           // If both collections are empty, it means there are no references in 'singup' or 'proxy' or 'servers' tables
           // So, we can proceed with deleting the team
           // Delete the team
          // return redirect()->route('companies.index')->with('success','Company has been created successfully.');
           $showteams->delete();
           // Redirect to 'viewpageteams' route with a success message
           return redirect('viewpageteams')->with('success1', 'Deleted successfully!');
       } else {
           // If there are references in 'singup' or 'proxy' tables, we can't delete the team
           // Redirect to 'viewpageteams' route with an error message
           return redirect('viewpageteams')->with('error1', 'Cannot delete team, it is referenced in user or proxy or server!');
       }


       
    }




   

}
