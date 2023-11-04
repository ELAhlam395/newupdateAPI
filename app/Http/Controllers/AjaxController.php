<?php


namespace App\Http\Controllers;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Form;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use DB;
use App\Models\Member;
use DataTables;


class AjaxController extends BaseController
{
    //

    public function index(Request $request){

        $domains['data'] = \App\Models\Domain::orderby("Name","asc")
        ->select('id','Name')
        ->get();

      
        // Fetch departments
        $departmentData['data'] = \App\Models\Provider_Server::orderby("Name","asc")
        ->select('id','Name')
        ->get();

        $x = \App\Models\Team::select("Name")
        ->pluck('Name')->toArray();


        $y = \App\Models\Acc_Prv_Srv::query()
        ->select(DB::raw("CONCAT(provider__servers.Name,' ',acc__prv__srvs.User,' ',acc__prv__srvs.Password,' ',acc__prv__srvs.Location	) AS full_name"))
        ->join('link2s', 'acc__prv__srvs.id', '=', 'link2s.Id_Acc_Server')
        ->join('provider__servers', 'link2s.Id_Prov_Server', '=', 'provider__servers.id')
        ->pluck('full_name')->toArray();
        
    

        $search = $request->q;

       
        $employees = \App\Models\Server::where('Ip','LIKE',"%{$search}%")
        ->select('servers.*', 'domains.Name as dd',  'provider__servers.Name as tt')
       ->leftJoin('domains', 'servers.Id_domain', '=', 'domains.id')
       ->orWhere('domains.Name','LIKE',"%{$search}%")
       ->leftJoin('acc__prv__srvs', 'servers.Id_Acc_prov', '=', 'acc__prv__srvs.id')
        ->leftJoin('provider__servers', 'servers.PROVIDER', '=', 'provider__servers.id')
        ->orWhere('provider__servers.Name','LIKE',"%{$search}%")
        ->orWhere('servers.Name','LIKE',"%{$search}%")
        ->leftJoin('teams', 'servers.TEAM5', '=', 'teams.id')
        ->orWhere('teams.Name','LIKE',"%{$search}%")
       ->get();
       
       $cat['data'] = \App\Models\Team::orderby("Name","asc")
        ->select('id','Name')
        ->get();

      
        return view('welcome', compact('departmentData','domains','employees','x','y','cat'));
       
    }
 
    public function update(Request $request, $id){


      

            $validatedData = $request->validate([
                'Ip1' =>'nullable|regex:/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',
                'Name1' =>'nullable|regex:/^[a-zA-Z]+_[0-9]+$/',
                'Price1' =>'nullable|regex:/^\d+$/',
                'Due_Date1' =>'nullable|date|after:Date_Creation1',
                'Additionnal_ips1'=>'nullable|regex:/^(\d{1,3}\.){3}\d{1,3}(,\s*(\d{1,3}\.){3}\d{1,3})*$/'
                ]);



        $member = Server::find($id);
        $member->Ip = $request->input('Ip1');
        $member->Password = $request->input('Password1');
        $member->Name = $request->input('Name1');
        $member->Due_Date = $request->input('Due_Date1');
        $member->Date_Creation = $request->input('Date_Creation1');
        $member->Name_Provider = $request->input('Name_Provider1');
        $member->Price = $request->input('Price1');
        $member->Comment = $request->input('Comment1');
        $member->Payment_Method = $request->Payment_Method1;
        $member->Additionnal_ips = $request->input('Additionnal_ips1');
        $member->PROVIDER = $request->sel_depart1;
        $member->Id_domain = $request->domains1;
        $member->TEAM5 = $request->volk;

       
      
        $member->save();


        



        return redirect('http://104.194.228.126/welcome');
        
    }

    public function indexoo(Request $request)
    {
        if ($request->ajax()) {
            $data = Server::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('approved', function($row){
                         if($row->approved){
                            return '<span class="badge badge-primary">Yes</span>';
                         }else{
                            return '<span class="badge badge-danger">No</span>';
                         }
                    })
                    ->filter(function ($instance) use ($request) {
                        if ($request->get('approved') == '0' || $request->get('approved') == '1') {
                            $instance->where('approved', $request->get('approved'));
                        }
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->rawColumns(['approved'])
                    ->make(true);
        }
        
        return view('test');
    }

    public function filterData(Request $request)
{
    $number = $request->input('number');
 
    $post = Server::where('id', $number)->get();

    return view('welcome', compact('post'));
}



 
}


