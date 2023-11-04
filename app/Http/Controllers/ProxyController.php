<?php

namespace App\Http\Controllers;
use App\Models\accproxy;
use App\Models\providerproxy;
use App\Models\proxy;
use App\Models\Team;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\ProvListd;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Form;

class ProxyController extends Controller
{
    //
    public function viewProxy(Request $request)
    {
        $showaccprx= accproxy::all();
        $showprovprx= providerproxy::all();
    //    $showproxy = proxy::paginate(10);
        $showatems= Team::all();

    //  $perPage = $request->input('per_page',10); // Default to 10 per page

     //
      $showproxy = proxy::paginate(10);

  //  return view('Proxys.listproxy',compact('showproxy'));

        return view('Proxys.listproxy',compact('showaccprx','showprovprx','showatems','showproxy'));
        //viewpageproxy
    }
    public function viewproviderProxy()
    {
        $showprovprx= providerproxy::all();
        return view('Proxys.providerproxy',compact('showprovprx'));
        //viewpageproviderproxy
    }
    function addproviderproxy(Request $req)
    {
        $req->validate([
            'nameprovider'=> 'required|unique:providerproxy,nameprovider',
            'linkprovider'=>'required',

        ]);

       $provadd=new providerproxy();
       $provadd->nameprovider=$req->nameprovider;
        $provadd->linkprovider=$req->linkprovider;

       $res= $provadd->save();
        if($res){
            return redirect('viewpageproviderproxy')->with('success', 'Success');
        }
        return redirect('viewpageproviderproxy')->with('error', ' error');

    }
    public function viewAccountproviderProxy()
    {
        $showprovprx= providerproxy::all();
        $provaddacc=accproxy::all();
        return view('Proxys.addaccprvprxy',compact('showprovprx','provaddacc'));
        //viewpageAccountproviderProxy
    }
    function addaccountprvproxy(Request $req)
    {
        $req->validate([
            'idprovprxy'=>'required',
            'locationacc'=>'required',
            'passwordacc'=>'required',
            'useracc' => 'required', 

        ]);
        // Check if useracc is unique for the given idprovprxy
                $isUnique = accproxy::where('idprovprxy', $req->idprovprxy)
                ->where('useracc', $req->useracc)
                ->doesntExist();

            if (!$isUnique) {
            return redirect('viewpageAccountproviderProxy')->with('error001', 'Useracc is not unique for this idprovprxy');
            }

       $provaddacc=new accproxy();
       $provaddacc->idprovprxy=$req->idprovprxy;
        $provaddacc->locationacc=$req->locationacc;
        $provaddacc->passwordacc=$req->passwordacc;
        $provaddacc->useracc=$req->useracc;
       $res= $provaddacc->save();
        if($res){
            return redirect('viewpageAccountproviderProxy')->with('success001', 'Success');
        }
        return redirect('viewpageAccountproviderProxy')->with('error001', ' error');

    }
    //////ajax////////
    public function appendaccproxy(Request $request)
    {
        $data['accountproxy'] = accproxy::where("idprovprxy", $request->idprovprxy)
                                ->get(["useracc", "id"]);

        return response()->json($data);
    }
    function addproxys(Request $req)
    {
        $req->validate([

            'ipproxy'=>'required|unique:proxytable,ipproxy',
            'port'=>'required',
            'userproxy'=>'required',
            'passwordproxy'=>'required',
            'providerproxy'=>'required',
            'idaccproxy'=>'required',
            'teamproxy'=>'required',
            'ispproxy'=>'required',

        ]);


       $showproxy=new proxy();
       $showproxy->ipproxy=$req->ipproxy;
       $showproxy->port=$req->port;
       $showproxy->userproxy=$req->userproxy;
       $showproxy->passwordproxy=$req->passwordproxy;
       $showproxy->providerproxy=$req->providerproxy;
       $showproxy->idaccproxy=$req->idaccproxy;
       $showproxy->teamproxy=$req->teamproxy;
       $showproxy->ispproxy=$req->ispproxy;

       $res= $showproxy->save();
        if($res){
            return redirect('viewpageproxy')->with('success', 'Success');
        }
        return redirect('viewpageproxy')->with('error', ' error');

    }
    /*
         function addbulkproxy(Request $request)
    {
      $data = $request->input('dataproxy');
      ////////////////
      $data1 = $request->input('providerproxy');
      $data2 = $request->input('idaccproxy');
      $data3 = $request->input('teamproxy');
      $data4 = $request->input('ispproxy');
        $dataC = explode("\n", $data );
        foreach ($dataC as $items) {
            $dataB = explode(":", $items );
         proxy::create(['ipproxy' => $dataB[0] ,'port' => $dataB[1],'userproxy' => $dataB[2],'passwordproxy' => $dataB[3],'providerproxy' => $data1,'idaccproxy' => $data2,'teamproxy' => $data3,'ispproxy' => $data4]);
        }
       return redirect('viewpageproxy')->with('success', 'Success');
    }
    */ 
    function addbulkproxy(Request $request)
    {

        $data = $request->input('dataproxy');
        $data1 = $request->input('providerproxy');
        $data2 = $request->input('idaccproxy');
        $data3 = $request->input('teamproxy');
        $data4 = $request->input('ispproxy');
        $dataC = explode("\n", $data);
        $nonUniqueEncountered = false;
        foreach ($dataC as $items) {
            $dataB = explode(":", $items);
    
            $existingProxy = proxy::where('ipproxy', $dataB[0])->first();
    
            if ($existingProxy === null) {
                proxy::create([
                    'ipproxy' => $dataB[0],
                    'port' => $dataB[1],
                    'userproxy' => $dataB[2],
                    'passwordproxy' => $dataB[3],
                    'providerproxy' => $data1,
                    'idaccproxy' => $data2,
                    'teamproxy' => $data3,
                    'ispproxy' => $data4
                ]);
            } else {
                $nonUniqueEncountered = true;
                // You can add any other handling for non-unique records here if needed.
            }
        }
    
        if ($nonUniqueEncountered) {
            return redirect('viewpageproxy')->with('error', 'At least ip non-unique record was encountered.');
        }
    
        return redirect('viewpageproxy')->with('success', 'All records were added successfully.');
    }
    /////////////////search proxy//////////////////////
    public function index(Request $request)
    {
        $showaccprx= accproxy::all();
        $showprovprx= providerproxy::all();
        $showatems= Team::all();
        $query = $request->input('query');
       if ($query !='') {
        $showproxy = proxy::where('ipproxy', 'LIKE', '%' . $query . '%')
        ->orWhere('port', 'LIKE', '%' . $query . '%')
        ->orWhere('userproxy', 'LIKE', '%' . $query . '%')
        ->orWhere('ispproxy', 'LIKE', '%' . $query . '%')
        
        ->paginate(10);
      //  ->get();
       return view('Proxys.listproxy',compact('showaccprx','showprovprx','showproxy','showatems'));
       }
        return redirect('viewpageproxy')->with('error', ' error');
    }
    ////////////////////////////////////
    ///////////////////////////////////////
    public function deleteproxy($id)
    {
        $showproxy= proxy::find($id);
        $showproxy ->delete();
        return redirect('viewpageproxy')->with('success1', 'delete successfully!');
    }
    ///////////////////////
    //////
    public function alldeleteproxy(Request $request)
    {
        $selectedItems = $request->selected_items;

        if($selectedItems== null){
            return redirect('viewpageproxy')->with('error', 'delete successfully!');
        }
        proxy::whereIn('id', $selectedItems)->delete();
        return redirect('viewpageproxy')->with('success1', 'delete successfully!');

    }
    public function indexx(Request $request)
    {
        $showaccprx= accproxy::all();
        $showprovprx= providerproxy::all();
        $showatems= Team::all();


        $perPage = $request->input('per_page'); // Default to 10 per page

        $showproxy = proxy::paginate($perPage);

        return view('Proxys.listproxy', compact('showproxy','showaccprx','showprovprx','showatems'));
    }
    public function filtrsbyteam(Request $request)
    {
        $showaccprx= accproxy::all();
        $showprovprx= providerproxy::all();
        $showatems= Team::all();
        $teamproxy = $request->input('teamproxy');
        $showproxy = proxy::where('teamproxy', 'LIKE', '%' . $teamproxy . '%')->paginate(10);
        return view('Proxys.listproxy',compact('showaccprx','showprovprx','showproxy','showatems'));
    }
    public function editproxy($id)
    {
        $showaccprx= accproxy::all();
        $showprovprx= providerproxy::all();
        $showatems= Team::all();
        $showproxy = proxy::find($id);
        return view('Proxys.editproxy',compact('showaccprx','showprovprx','showproxy','showatems'));
        //editproxy

    }
    public function updateproxy(Request $req,$id)
    {

        $req->validate([

            'ipproxy'=>'required',
            'port'=>'required',
            'userproxy'=>'required',
            'passwordproxy'=>'required',
            'ispproxy'=>'required',
            

        ]);
        $showproxy = proxy::find($id);
      

        $showproxy->ipproxy=$req->ipproxy;
        $showproxy->port=$req->port;
        $showproxy->userproxy=$req->userproxy;
        $showproxy->passwordproxy=$req->passwordproxy;
     //   $showproxy->teamproxy=$req->teamproxy;
        $showproxy->ispproxy=$req->ispproxy;
 
        $res= $showproxy->update();
         if($res){
             return redirect('viewpageproxy')->with('success', 'Success');
         }
         return redirect('viewpageproxy')->with('error', ' error');
 
        
    
    }
    ///////search Account Provider Proxy//////
    public function searchaccprv(Request $request)
    {
       $showprovprx= providerproxy::all();

       
        $queryacc = $request->input('queryacc');
       if ($queryacc !='') {
       // $showprovprx= providerproxyArr::join($array, 'glue')

        $provaddacc = accproxy::where('accountproxy.useracc', 'LIKE', '%' . $queryacc . '%')
        ->join('providerproxy','accountproxy.idprovprxy','=','providerproxy.id')
        ->orWhere('accountproxy.locationacc', 'LIKE', '%' . $queryacc . '%')
        
        ->orWhere('providerproxy.nameprovider', 'LIKE', '%' . $queryacc . '%')
        ->get();
        
       // ->orWhere('userproxy', 'LIKE', '%' . $queryacc . '%')
       // ->orWhere('ispproxy', 'LIKE', '%' . $queryacc . '%')
       // ->paginate(10);
      //  ->get();
      return view('Proxys.addaccprvprxy',compact('showprovprx','provaddacc'));
       }
      
        return redirect('viewpageAccountproviderProxy')->with('error', ' error');





        
        
    }
    public function deleteaccprvproxy($id)
    {
        $provaddacc = accproxy::find($id);

        if (!$provaddacc) {
            // Handle case where the record with $id does not exist
            return redirect('viewpageAccountproviderProxy')->with('error001', 'Record not found');
        }
    
        // Check if there are dependent records in proxytable
        $dependentRecordsCount = DB::table('proxytable')->where('idaccproxy', $id)->count();
    
        if ($dependentRecordsCount > 0) {
            // There are dependent records, so do something (e.g., display an error message)
            return redirect('viewpageAccountproviderProxy')->with('error001', 'Cannot delete this record as there are dependent records in proxytable.');
        } else {
            // No dependent records, proceed with deletion
            $provaddacc->delete();
            return redirect('viewpageAccountproviderProxy')->with('success001', 'Record deleted!');
        }
    }
    public function updateaccprvproxy(Request $req,$id)
    {
        $req->validate([
            'useracc'=>'required',
            'passwordacc'=>'required',
            'locationacc'=>'required',
        ]);
        
        $provaddacc = accproxy::find($id);
        $provaddacc->useracc = $req->input('useracc');
        $provaddacc->passwordacc = $req->input('passwordacc');
        $provaddacc->locationacc = $req->input('locationacc');
        
        $ress= $provaddacc->update();
        if($ress) {
            return redirect('viewpageAccountproviderProxy')->with('success001', 'Record updated successfully');
            
        }
        return redirect('viewpageAccountproviderProxy')->with('error001', ' error');
       
    
       
    
        
    
        
 
        
    
    }
    ///////search  Provider Proxy//////
     public function searchproviderpx(Request $request)
    {
       // $showprovprx= providerproxy::all();
        $queryprv = $request->input('queryprv');
       if ($queryprv !='') {
       // $showprovprx= providerproxyArr::join($array, 'glue')

        $showprovprx = providerproxy::where('nameprovider', 'LIKE', '%' . $queryprv . '%')
        
        ->get();
        
       // ->orWhere('userproxy', 'LIKE', '%' . $queryacc . '%')
       // ->orWhere('ispproxy', 'LIKE', '%' . $queryacc . '%')
       // ->paginate(10);
      //  ->get();
      return view('Proxys.providerproxy',compact('showprovprx'));
       }
      
        return redirect('viewpageproviderproxy')->with('error', ' error');





        
        
    }
    public function deleteproviderpx($id)
    {
        $showprovprx = providerproxy::find($id);
        // Check if there are dependent records in accountproxy
        $dependentRecordsCount = DB::table('accountproxy')->where('idprovprxy', $id)->count();
        if ($dependentRecordsCount > 0) {
            return redirect('viewpageproviderproxy')->with('error001', 'Cannot delete this record as there are dependent records in accountproxy.');
        }
        $showprovprx->delete();
        return redirect('viewpageproviderproxy')->with('success1', 'Deleted successfully!');
    }

    public function updateproviderpx(Request $req,$id)
    {
        $req->validate([
            'nameprovider'=>'required',
            'linkprovider'=>'required', 
        ]);
        $showprovprx = providerproxy::find($id);
        $showprovprx->nameprovider = $req->input('nameprovider');
        $showprovprx->linkprovider = $req->input('linkprovider');
        $ressp= $showprovprx->update();
        if($ressp) {
            return redirect('viewpageproviderproxy')->with('success001', 'Record updated successfully');
        }
        return redirect('viewpageproviderproxy')->with('error001', ' error');
       
    }


    


  


















}
