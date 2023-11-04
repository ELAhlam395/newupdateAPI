<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\APIAccount;
use App\Models\APIProvider;
use Illuminate\Support\Facades\Validator;

class ApiProxyController extends Controller
{
    //
    public function viewaddprovider()
    {
        return view('API.AddnewProvider');
        //viewapiaddprovider
    }
    public function viewmangerprovider()
    {
        $APIProvider= APIProvider::all();
        return view('API.ManagerProviders',compact('APIProvider'));
        //viewapimangerprovider
    }
    public function viewaddaccounts()
    {
        $APIProvider= APIProvider::all();
        return view('API.AddAccounts',compact('APIProvider'));
        //viewapiaddaccounts
    }
    public function viewmangeraccounts()
    {
        $APIAccount= APIAccount::all();
        return view('API.ManagerAccounts',compact('APIAccount'));
        //viewapimangeraccounts
    }
    public function viewcreateproxy()
    {
        return view('API.CreateProxys');
        //viewcreateproxyapi
    }
    public function viewlistproxy()
    {

        $APIProvider = APIProvider::all();
    $APIAccount = APIAccount::all();
    $data = []; // Initialize an empty array to store the responses
    
    foreach ($APIAccount as $apiAcc) {
        $api_key = $apiAcc->api_key;
        $api_hash = $apiAcc->api_hash;
        $api_get = $apiAcc->api_get;
        
        $response = Http::withHeaders([
            $api_hash => $api_key,
        ])->get($api_get);
        
        if ($response->successful()) {
            $data[] = $response->json(); // Append the response data to the $data array
        }
    }
    
    return view('API.ListProxy', ['data' => $data, 'APIProvider' => $APIProvider]);
      /*  $APIProvider= APIProvider::all();
        return view('API.ListProxy',compact('APIProvider'));*/
        //viewlistproxyapi
    }

    public function addapiprovider(Request $req)
    {

        $req->validate([
            'name'=> 'required|unique:_a_p_i_provider,name',
            'link'=>'required',

        ]);

       $APIProvider=new APIProvider();
       $APIProvider->name=$req->name;
        $APIProvider->link=$req->link;

       $res= $APIProvider->save();
        if($res){
            return redirect('viewapiaddprovider')->with('success', 'Success');
        }
        return redirect('viewapiaddprovider')->with('error', ' error');

    }
    public function addapiaccount(Request $req)
    {

        $req->validate([
            'user'=> 'required',
            'password'=>'required',
            'api_key'=>'required',
            'api_hash'=>'required',
            'api_get'=>'required',
            'api_add'=>'required',
            'api_delete'=>'required',
            'api_edit'=>'required',
            'idprov'=>'required',
    

        ]);

       $APIAccount=new APIAccount();
       $APIAccount->user=$req->user;
        $APIAccount->password=$req->password;
        $APIAccount->api_key=$req->api_key;
        $APIAccount->api_hash=$req->api_hash;
        $APIAccount->api_get=$req->api_get;
        $APIAccount->api_add=$req->api_add;
        $APIAccount->api_delete=$req->api_delete;
        $APIAccount->api_edit=$req->api_edit;
        $APIAccount->idprov=$req->idprov;

       $res= $APIAccount->save();
        if($res){
            return redirect('viewapiaddaccounts')->with('success', 'Success');
        }
        return redirect('viewapiaddaccounts')->with('error', ' error');

    }

/////////////////////////////////get test /////////////////////
    public function getData01()
    {
        $APIAccount = APIAccount::all();
        foreach ($APIAccount as $apiAcc) {
        $api_key = $apiAcc->api_key;
        $api_hash = $apiAcc->api_hash;
        $api_get = $apiAcc->api_get;
        $response = Http::withHeaders([
            $api_hash =>   $api_key ,
        ])->get($api_get);
        $data = $response->json();
        }
        return view('API.ListProxy', ['data' => $data]);

    }
    public function getData02()
    {
        $response = Http::withHeaders([
            'apikey' => 'hBYDf1wDvsHEOCAoOYtlU1r7UfG4284a',
        ])->get('https://api.idcloudhost.com/v1/user-resource/user');

        $data['results'] = $response->json();
        //return view('API.ManagerProviders', ['data' => $data]);

         return view('test', ['data' => $data['results']]);

    }
    public function getData03()
    {
        $response = Http::withHeaders([
            'Authorization' => '1wdvx1gp204hne0ruglwpf5010wdu3xqne65tx7x',
        ])->get('https://proxy.webshare.io/api/v2/proxy/list/?mode=direct&page=1&page_size=25');

        $responseData = $response->json();

        // Check if the response data is an array or object
        if (is_array($responseData) || is_object($responseData)) {
            $data['results'] = $responseData;
        } else {
            // Handle the case where the response is not in the expected format
            $data['results'] = [];
        }
    
        return view('test', ['data' => $data['results']]);

    }
    public function appendaccapiproxy(Request $request)
    {
        $data['_a_p_i_account'] = APIAccount::where("idprov", $request->idprov)
                                ->get(["user", "id"]);

        return response()->json($data);
    }

    public function getwebshar()
    {

        
        
      
        /*
        $APIProvider= APIProvider::all();
        $APIAccount = APIAccount::all();
        foreach ($APIAccount as $apiAcc) {
            $api_key = $apiAcc->api_key;
            $api_hash = $apiAcc->api_hash;
            $api_get = $apiAcc->api_get;
        $response = Http::withHeaders([
            $api_hash => $api_key ,
            ])->get($api_get);
        }
        */
        $APIProvider= APIProvider::all();
        $response = Http::withHeaders([
            'Authorization' => '1wdvx1gp204hne0ruglwpf5010wdu3xqne65tx7x',
        ])->get('https://proxy.webshare.io/api/v2/proxy/list/?mode=direct&page=1&page_size=25');

        
        $data = $response->json();

        return view('API.ListProxy', ['data' => $data],['APIProvider'=>$APIProvider]);

    }
    ////////////////////////////////delete////////////////////////////////

    public function deleteapiprovider($id)
    {
        $APIProvider = APIProvider::find($id);

        if ($APIProvider) {
            // Find and delete related APIAccount records
            $relatedAccounts = APIAccount::where('idprov', $APIProvider->id)->get();
            foreach ($relatedAccounts as $account) {
                $account->delete();
            }

            // Delete the APIProvider after related accounts are deleted
            $APIProvider->delete();

            return redirect('viewapimangerprovider')->with('success', 'Provider and related accounts deleted successfully!');
        }

        return redirect('viewapimangerprovider')->with('error', 'Provider not found.');
    }
    public function deleteapiaccount($id)
    {
        $APIAccount= APIAccount::find($id);
        $APIAccount ->delete();
        return redirect('viewapimangeraccounts')->with('success', 'delete successfully!');
       // return view('API.AddnewProvider');
        //viewapimangeraccounts
    }
 ////////////////////////////////get data ////////////////////////////////


    public function test006(Request $request)
    {
        $APIProvider= APIProvider::all();
        $query = $request->input('idprov');
        $queryuser = $request->input('user');
       if ($query !='' &&  $queryuser !='') {
        $APIAccount = APIAccount::where('idprov', 'LIKE', '%' . $query . '%')
        ->orWhere('user', 'LIKE', '%' . $queryuser . '%')
        ->get();
        foreach ($APIAccount as $apiAcc) {
            $api_key = $apiAcc->api_key;
            $api_hash = $apiAcc->api_hash;
            $api_get = $apiAcc->api_get;
            
            $response = Http::withHeaders([
                $api_hash =>   $api_key ,
            ])->get($api_get);
            $data = $response->json();
            }

       return view('API.ListProxy',compact('data','APIAccount','APIProvider'));
       }
        return redirect('viewlistproxyapi')->with('error', ' error');
    }
    public function GETProxy(Request $request)
    {
        $APIProvider = APIProvider::all();
        $query = $request->input('idprov');
        $queryuser = $request->input('user');

        // Validation rules for the inputs
        $rules = [
            'idprov' => 'required',
            'user' => 'required',
        ];

        // Custom error messages for validation
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        // Validate the inputs
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('viewlistproxyapi')->withErrors($validator)->withInput();
        }

        $APIAccount = APIAccount::where('idprov', 'LIKE', '%' . $query . '%')
            ->orWhere('user', 'LIKE', '%' . $queryuser . '%')
            ->get();

        $data = [];

        foreach ($APIAccount as $apiAcc) {
            if ($queryuser==$apiAcc->id) {
                $api_key = $apiAcc->api_key;
                $api_hash = $apiAcc->api_hash;
                $api_get = $apiAcc->api_get;
    
                $response = Http::withHeaders([
                    'Authorization' => $api_key, // Use 'Authorization' as the key
                ])->get($api_get);
                if ($response->successful()) {
                    $data[] = $response->json(); // Append response data to $data array
                }
                # code...
            }
           

            
        }
        
        return view('API.ListProxy', compact('data', 'APIAccount', 'APIProvider'));
    }
    public function viewproxyactvety()
    {
        return view('API.ViewActvety');
        //ViewActvetypage
    }


  

}
