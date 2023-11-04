<?php

namespace App\Http\Controllers;
use App\Models\Server;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Form;
use Symfony\Component\Process\Process;
use App\Http\Controllers\Controller;
use phpseclib3\Net\SSH2;



class Controller extends BaseController
{


    public function Connectivity(Request $request, $id){


        $member = Server::find($id);
      
        $ip = $member->Ip;
        $password = $member->Password;
        

           
        $ssh = new SSH2($ip);

        try {
            if ($ssh->login('root', $password)) {
                $pb = "Connected";
                $output = $ssh->exec('ls -la');
    
            } 
            else 
            {
                $pb ="Authentication Failed";
            }
            }
             catch (\Exception $e) {
                $pb ="Cannot connect to the server: " . $e->getMessage();
            }
        

            if($request->ajax()){
                
                return response()->json(['tat'=>$pb]);
            }

    }
   
    

    public function getEmployees($departmentid=0){

        // SELECT acc__prov__servers.User from acc__prov__servers INNER JOIN link2s ON acc__prov__servers.id = link2s.Id_Acc_Server
        // INNER JOIN provider__servers ON link2s.Id_Prov_Server = provider__servers.id AND provider__servers.id = 1;

        $empData['data'] = DB::table('acc__prv__srvs')
        ->join('link2s', 'acc__prv__srvs.id', '=', 'link2s.Id_Acc_Server')
        ->join('provider__servers', 'link2s.Id_Prov_Server', '=', 'provider__servers.id')
        ->where('provider__servers.id', '=', $departmentid)
        ->select('acc__prv__srvs.id', 'acc__prv__srvs.User','acc__prv__srvs.Password','acc__prv__srvs.Location')
        ->orderBy('acc__prv__srvs.User', 'asc')
        ->get();

        return response()->json($empData);

    }

    public function store_servers(Request $request)
    {



            $validatedData = $request->validate([
                'Ip' =>'nullable|regex:/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/|unique:servers,Ip',
                'Name' =>'nullable|regex:/^[a-zA-Z]+_[0-9]+$/|unique:servers,Name',
                'Price' =>'nullable|regex:/^\d+$/',
                'Due_Date' =>'nullable|date|after:Date_Creation',
                'salma'=>'nullable|regex:/^(\d{1,3}\.){3}\d{1,3}(,\s*(\d{1,3}\.){3}\d{1,3})*$/'
                ]);






        //   ---     Add  Server     ----   //

        $ip = $request->Ip;
        $password = $request->Password;
        $name = $request->Name;
        $due_date = $request->Due_Date;
        $date_creation = $request->Date_Creation;
        $name_provider = $request->Name_Provider;
        $price = $request->Price;
        $payment_mth = $request->Payment_Method;
        $comment = $request->Comment;
        $additional_ips = $request->additional_ips;
        $account = $request->sel_emp;
        $Domain = $request->domains;
        $Team = $request->Teams;
        $PROVIDER_ = $request->provider_input;




        //Insertion

        $id = DB::table('servers')->insertGetId([
            'Ip'=>$ip,
            'Password'=>$password,
            'Name'=>$name,
            'Due_Date'=>$due_date,
            'Date_Creation'=>$date_creation,
            'Name_Provider'=>$name_provider,
            'Price'=>$price,
            'Payment_Method'=>$payment_mth,
            'Comment'=>$comment,
            'Additionnal_ips'=>$additional_ips,
            'Id_Acc_prov'=>$account,
            'Id_Domain'=>$Domain,
            'TEAM5'=>$Team,
            'PROVIDER'=>$PROVIDER_

        ]);


        //   ---     Add link Server with sub domain    ----   //
        $additional_ips = $request->additional_ips;

        $domains = $request->fruits2;
        $stringArray = explode(",", $domains);

        $counter = 0;

        $length = count($stringArray);

        if($additional_ips !=  null){
            while ($counter < $length) {

                \App\Models\link_srv_subdomain::create([

                    'id_subdomain'=>$stringArray[$counter],
                    'Id_Server'=>$id,

                ]);

           

            $counter++;

            }
        }



        return redirect()->back()->with('success','Item created successfully!');

    }



    public function ssd(Request $request)
    {
        if($request->rowsTT == 10){
            $employees = \App\Models\Server::query()
            ->select('servers.*', 'domains.Name as dd',  'provider__servers.Name as tt','teams.Name as aa')
            ->leftJoin('domains', 'servers.Id_domain', '=', 'domains.id')
            ->leftJoin('acc__prv__srvs', 'servers.Id_Acc_prov', '=', 'acc__prv__srvs.id')
            ->leftJoin('provider__servers', 'servers.PROVIDER', '=', 'provider__servers.id')
            ->leftJoin('teams', 'servers.TEAM5', '=', 'teams.id')   
           ->paginate(10);
        }
        else if($request->rowsTT == 20){
            $employees = \App\Models\Server::query()
            ->select('servers.*', 'domains.Name as dd',  'provider__servers.Name as tt','teams.Name as aa')
            ->leftJoin('domains', 'servers.Id_domain', '=', 'domains.id')
            ->leftJoin('acc__prv__srvs', 'servers.Id_Acc_prov', '=', 'acc__prv__srvs.id')
            ->leftJoin('provider__servers', 'servers.PROVIDER', '=', 'provider__servers.id')
            ->leftJoin('teams', 'servers.TEAM5', '=', 'teams.id')   
           ->paginate(20);
        }
        else if($request->rowsTT == 50){
            $employees = \App\Models\Server::query()
            ->select('servers.*', 'domains.Name as dd',  'provider__servers.Name as tt','teams.Name as aa')
            ->leftJoin('domains', 'servers.Id_domain', '=', 'domains.id')
            ->leftJoin('acc__prv__srvs', 'servers.Id_Acc_prov', '=', 'acc__prv__srvs.id')
            ->leftJoin('provider__servers', 'servers.PROVIDER', '=', 'provider__servers.id')
            ->leftJoin('teams', 'servers.TEAM5', '=', 'teams.id')   
           ->paginate(50);
        }
        else if($request->rowsTT == 100){
            $employees = \App\Models\Server::query()
            ->select('servers.*', 'domains.Name as dd',  'provider__servers.Name as tt','teams.Name as aa')
            ->leftJoin('domains', 'servers.Id_domain', '=', 'domains.id')
            ->leftJoin('acc__prv__srvs', 'servers.Id_Acc_prov', '=', 'acc__prv__srvs.id')
            ->leftJoin('provider__servers', 'servers.PROVIDER', '=', 'provider__servers.id')
            ->leftJoin('teams', 'servers.TEAM5', '=', 'teams.id')   
           ->paginate(100);
        }
        else if($request->rowsTT == 150){
            $employees = \App\Models\Server::query()
            ->select('servers.*', 'domains.Name as dd',  'provider__servers.Name as tt','teams.Name as aa')
            ->leftJoin('domains', 'servers.Id_domain', '=', 'domains.id')
            ->leftJoin('acc__prv__srvs', 'servers.Id_Acc_prov', '=', 'acc__prv__srvs.id')
            ->leftJoin('provider__servers', 'servers.PROVIDER', '=', 'provider__servers.id')
            ->leftJoin('teams', 'servers.TEAM5', '=', 'teams.id')   
           ->paginate(150);
        }
     


        if($request->ajax()){
            
            return response()->json(['products'=>$employees]);
        }

        $products = $query->get();
        $employees = $products;






        if($request->ajax()){
            $products =  $query->where(['TEAM5'=>$request->category])->get();
            return response()->json(['products'=>$products]);
        }

        $products = $query->get();
        $employees = $products;


        
        $domains['data'] = \App\Models\Domain::orderby("Name","asc")
        ->select('id','Name')

        ->get();



        $departmentData['data'] = \App\Models\Provider_Server::orderby("Name","asc")
        ->select('id','Name')
        ->get();

       
      $x = \App\Models\Team::
      select('id', 'Name')
      ->pluck('Name','id')
      ->toArray();

      


        $y = \App\Models\Acc_Prv_Srv::query()
        ->select(DB::raw("CONCAT(provider__servers.Name,' ',acc__prv__srvs.User,' ',acc__prv__srvs.Password,' ',acc__prv__srvs.Location	) AS full_name"))
        ->join('link2s', 'acc__prv__srvs.id', '=', 'link2s.Id_Acc_Server')
        ->join('provider__servers', 'link2s.Id_Prov_Server', '=', 'provider__servers.id')
        ->pluck('full_name')->toArray();

       


      

        $categories = Team::all();

        $volk['data'] = \App\Models\Team::orderby("Name","asc")
        ->select('id','Name')
        ->get();

 
            $D = \App\Models\Domain::
      select('id', 'Name')
      ->pluck('Name','id')
      ->toArray();


        return view('welcome', compact('departmentData','domains','employees','x','y','categories','volk','D'));

      
    }

   
   

    public function index2(){

      


        $domains['data'] = \App\Models\Domain::orderby("Name","asc")
        ->select('id','Name')

        ->get();



        $departmentData['data'] = \App\Models\Provider_Server::orderby("Name","asc")
        ->select('id','Name')
        ->get();

       
      $x = \App\Models\Team::
      select('id', 'Name')
      ->pluck('Name','id')
      ->toArray();


      $D = \App\Models\Domain::
      select('id', 'Name')
      ->pluck('Name','id')
      ->toArray();




        $y = \App\Models\Acc_Prv_Srv::query()
        ->select(DB::raw("CONCAT(provider__servers.Name,' ',acc__prv__srvs.User,' ',acc__prv__srvs.Password,' ',acc__prv__srvs.Location	) AS full_name"))
        ->join('link2s', 'acc__prv__srvs.id', '=', 'link2s.Id_Acc_Server')
        ->join('provider__servers', 'link2s.Id_Prov_Server', '=', 'provider__servers.id')
        ->pluck('full_name')->toArray();


      
       
           
        $employees = \App\Models\Server::query()
        ->select('servers.*', 'domains.Name as dd',  'provider__servers.Name as tt','teams.Name as aa')
        ->leftJoin('domains', 'servers.Id_domain', '=', 'domains.id')
        ->leftJoin('acc__prv__srvs', 'servers.Id_Acc_prov', '=', 'acc__prv__srvs.id')
        ->leftJoin('provider__servers', 'servers.PROVIDER', '=', 'provider__servers.id')
        ->leftJoin('teams', 'servers.TEAM5', '=', 'teams.id')   
       ->paginate(10);
      

      
       


        $categories = Team::all();

        $volk['data'] = \App\Models\Team::orderby("Name","asc")
        ->select('id','Name')
        ->get();


       
       

        return view('welcome', compact('departmentData','domains','employees','x','y','categories','volk','D'));

       
     }


     public function getEmployeeDetails($empid = 0){

        $employee = \App\Models\Server::find($empid);

        if($employee->Payment_Method == null)
        {
            $test = "You haven't yet entered the Payment Method.";
        }
        else 
        {
          
            $test = $employee->Payment_Method;
        }

        ////////////////

        if($employee->Additionnal_ips == null)
        {
            $test1 = "You haven't yet entered the Additionnal ips.";
        }
        else 
        {
          
            $test1 = $employee->Additionnal_ips;
        }

        ////////////////

        if($employee->Comment == null)
        {
            $test2 = "You haven't yet entered the Comment.";
        }
        else 
        {
          
            $test2 = $employee->Comment;
        }


        ////////////////


        if($employee->Price == null)
        {
            $test3 = "You haven't yet entered the Price.";
        }
        else 
        {
          
            $test3 = $employee->Price;
        }

        ////////////////

        if($employee->Name_Provider == null)
        {
            $test4 = "You haven't yet entered the Name of the Provider.";
        }
        else 
        {
          
            $test4 = $employee->Name_Provider;
        }


        $html = "";
        if(!empty($employee)){
           $html = "

            <tr>
                <td><b>PAYMENT METHOD</b></td>
               
                <td> <b>: </b>".$test."</td>
            </tr>

            <tr>
                <td><b>ADDITIONNAL IPS</b></td>
                <td> <b>: </b>".$test1."</td>
            </tr>


            <tr>
                <td><b>COMMENT</b></td>
                <td> <b>: </b>".$test2."</td>
            </tr>

            <tr>
                <td><b>PRICE</b></td>
                <td> <b>: </b>".$test3."</td>
            </tr>

            <tr>
                <td><b>NAME IN PROVIDER</b></td>
                <td> <b>: </b>".$test4."</td>
            </tr>


            ";
        }
        $response['html'] = $html;

        return response()->json($response);
     }

     public function test()
     {

        $news = \App\Models\Server::join('domains', 'servers.Id_domain', '=', 'domains.id')
        ->select('servers.*', 'domains.Name as name_d')
        ->get();

        return view('test',compact('news'));
    }

    public function Add_in_Bulk(Request $request)
    {
        
        
        $ips = $request->input__;
        $id_domains = $request->input___;

        $arr_ips =  explode(',', $ips);
        $arr_id_domains = explode(',', $id_domains);


    
      

        

        $lines_textarea = $request->lines;
        $Name_Bulk = $request->name_bulk;
        $eliminer_ = "_";        
        $parts = explode($eliminer_, $Name_Bulk);
        $digits = isset($parts[1]) ? $parts[1] : '';
        $numberWithoutZeros = ltrim($digits, '0');     
        $name_withought_number = substr($Name_Bulk, 0, strpos($Name_Bulk, "_"));
   
        $array = [];
        $textareaInput = request('message');
        $rows = explode("\n", $textareaInput);
        $rows = array_map('trim', $rows);
        $arrayOfRows = $rows;      
        
        $beforeSpaceArray = [];

        foreach ($arrayOfRows as $element) {
        $split = explode(' ', $element);
        $beforeSpaceArray[] = $split[0];
        }

        $NAME_SERVERs = [];
        
        for ($i = $numberWithoutZeros; $i < $numberWithoutZeros+$lines_textarea; $i++) 
        {    
            array_push($NAME_SERVERs, $name_withought_number . "_" .sprintf("%03d", $i));     
        }

        $input = $request->atton2;
        $array_inputs = explode(",", $input);

        $val = ["Price","Due_Date", "Date_Creation", "Name_Provider","Payment_Method","Comment","TEAM5","Provider/Account"];
 
        $filteredFoo = array_diff($array_inputs, $val);

        $Attribut = $request->atton;
        $array_Attribut = explode(",", $Attribut);
   
        $valuesToKeep = ["Price","Due_Date", "Date_Creation", "Name_Provider","Payment_Method","Comment","TEAM5","Provider/Account"];

        foreach ($array_Attribut as $key => $value) {
        if (!in_array($value, $valuesToKeep)) {
        unset($array_Attribut[$key]);
        }
        }

        $foo1 = array_values($array_Attribut);
        $foo2 = array_values($filteredFoo);
      

        for ($j = 0; $j < count($beforeSpaceArray); $j++) 
        {
       
            $PASSWORD = $request->pass;

            if(count($foo1)<0)
            {
                \App\Models\Server::create([     
       
                    'Ip'=>$beforeSpaceArray[$j],
                    'Password'=>$PASSWORD,
                    'Name'=>$NAME_SERVERs[$j],
                  
                ]);
        
            }

           else  if($ips!="" && $arr_ips[$j] == $beforeSpaceArray[$j])
            {
                \App\Models\Server::create([     
       
                    'Ip'=>$beforeSpaceArray[$j],
                    'Password'=>$PASSWORD,
                    'Name'=>$NAME_SERVERs[$j],
                    'Id_domain'=>$arr_id_domains[$j]
                  
                ]);
            }

           

            else{
                   
                $row = new \App\Models\Server();
                $row->Ip = $beforeSpaceArray[$j];
                $row->Password = $PASSWORD;
                $row->Name =$NAME_SERVERs[$j];

                for ($k = 0; $k < count($foo1); $k++) 
                {
                    $attribut = $foo1[$k];
                    $input = $foo2[$k];

                    if($foo1[$k] == "Provider/Account")
                    {
                        $array = explode(' ', $foo2[$k]);
                    
                        $test = implode(' ', $array);
                    
                        $p = collect($test)->implode('');
                        $pieces = explode(" ", $p);
                            
                        $t = DB::table('acc__prv__srvs')
                        ->where('User','=',$pieces[1])
                        ->where('Password','=',$pieces[2])
                        ->where('Location','=',$pieces[3])
                        ->pluck('id')->toArray();

                        $d = DB::table('provider__servers')
                        ->where('Name','=',$array[0])
                        
                        ->pluck('id')->toArray();

                        $attribut ="Id_Acc_prov";
                        $input = $t[0];

                        $row->$attribut = $input;

                        $attribut =  "PROVIDER";
                        $input = $d[0];
                    
                        $row->$attribut = $input;
                             
                    }
                $row->$attribut = $input;
                $row->save();

                }

            }
        }
            
       
        
        return redirect()->back()->with('success','Item created successfully!');
    
    }
    


    public function destroy(\App\Models\Server $server)
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $server->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->back();

    }

    public function search(Request $request)
    {

        $domains['data'] = \App\Models\Domain::orderby("Name","asc")
        ->select('id','Name')
        ->get();


        $departmentData['data'] = \App\Models\Provider_Server::orderby("Name","asc")
        ->select('id','Name')
        ->get();

        $x = \App\Models\Team::
        select('id', 'Name')
        ->pluck('Name','id')
        ->toArray();


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
        ->paginate(10);
        //->get();
       $categories = Team::all();

       $volk['data'] = \App\Models\Team::orderby("Name","asc")
        ->select('id','Name')
        ->get();

        $D = \App\Models\Domain::
      select('id', 'Name')
      ->pluck('Name','id')
      ->toArray();

     
        return view('welcome', compact('departmentData','domains','employees','x','y','categories','volk','D'));


    }

    public function removeMulti(Request $request)
    {
        $ids = $request->ids;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Server::whereIn('id',explode(",",$ids))->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return response()->json(['status'=>true,'message'=>"Student successfully removed."]);

    }

    public function filterServer(Request $request)
    {
        $query = Server::query();
        $team = Server::all();

        if($request->ajax()){
            $server = $query->where(['TEAM5'=>$request->team])-get();
            return response()->json(['server'=>$server]);
        }
        $server = $query->get();

        return view('welcome',compact('team','server'));
    }


    public function filterProduct(Request $request)
    {


        $domains['data'] = \App\Models\Domain::orderby("Name","asc")
        ->select('id','Name')
        ->get();



        $departmentData['data'] = \App\Models\Provider_Server::orderby("Name","asc")
        ->select('id','Name')
        ->get();

        $x = \App\Models\Team::
        select('id', 'Name')
        ->pluck('Name','id')
        ->toArray();


        $y = \App\Models\Acc_Prv_Srv::query()
        ->select(DB::raw("CONCAT(provider__servers.Name,' ',acc__prv__srvs.User,' ',acc__prv__srvs.Password,' ',acc__prv__srvs.Location	) AS full_name"))
        ->join('link2s', 'acc__prv__srvs.id', '=', 'link2s.Id_Acc_Server')
        ->join('provider__servers', 'link2s.Id_Prov_Server', '=', 'provider__servers.id')
        ->pluck('full_name')->toArray();


       $tester = [1,2,3,4,5];
      

        $categories = Team::all();

      
        $volk['data'] = \App\Models\Team::orderby("Name","asc")
        ->select('id','Name')
        ->get();

        return view('welcome', compact('departmentData','domains','employees','x','y','categories','volk'));
    }

}




