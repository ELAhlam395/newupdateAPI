<?php

namespace App\Http\Controllers;
use App\Models\Server;
use App\Models\Team;
use DataTables;
use Illuminate\Support\Facades\Form;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function filterProduct(Request $request)
    {
        $query = Server::query()->select('servers.*', 'domains.Name as dd',  'provider__servers.Name as tt','teams.Name as aa')
        ->leftJoin('domains', 'servers.Id_domain', '=', 'domains.id')
        ->leftJoin('acc__prv__srvs', 'servers.Id_Acc_prov', '=', 'acc__prv__srvs.id')
        ->leftJoin('provider__servers', 'servers.PROVIDER', '=', 'provider__servers.id')
        ->leftJoin('teams', 'servers.TEAM5', '=', 'teams.id')
        ->limit(10);
      
        
        $categories = Team::all();

        
        if($request->ajax()){
            if($request->category == "All")
            {
            
                    $products =  $query->get();
                    return response()->json(['products'=>$products]);
                
            }
            else
            {
                
                    $products =  $query->where(['TEAM5'=>$request->category])->get();
                    return response()->json(['products'=>$products]);
                
            }
        }
        
        

        $products = $query->get();
        return view('users',compact('products','categories'));
    }


  
}
