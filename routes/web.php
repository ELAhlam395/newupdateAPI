<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AjaxController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\singupController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProxyController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\ApiProxyController;
use App\Models\proxy;
use App\Models\Server;
use App\Models\Domain;
use App\Models\Team;
use App\Models\singup;
/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





//Route::get('/welcome/Connectivity', ['\App\Http\Controllers\Controller','Connectivity'])->name('Connectivity');

Route::get("/page", function(){
    return view("show");
 });

Route::get('/welcome', [Controller::class, 'index2']); 


Route::get('/welcome/Connectivity/{id}', [Controller::class,'Connectivity'])->name('Connectivity');


Route::get('/welcome/view', ['\App\Http\Controllers\Controller','view'])->name('view');



Route::get('/welcome/getEmployeeDetails/{empid}', [Controller::class, 'getEmployeeDetails'])->name('getEmployeeDetails');


Route::get('/welcome/getEmployees/{id}', [Controller::class, 'getEmployees']);

Route::get('/welcome/getEmployees2/{id}', [Controller::class, 'getEmployees2']);


Route::post('/welcome/Add_in_Bulk', [Controller::class, 'Add_in_Bulk'])->name('Add_in_Bulk');


 Route::post('/welcome/store', ['\App\Http\Controllers\Controller' , 'store_servers'])

 ->name('store_servers');

 

Route::delete('/welcome/{server}',[Controller::class,'destroy'])
->name('destroy');


Route::get('/welcome/search', ['\App\Http\Controllers\Controller','search'])->name('search');


Route::PATCH('/update/{id}', ['as' => 'member.update', 'uses' => '\App\Http\Controllers\AjaxController@update']);


Route::delete('delete-all', [Controller::class, 'removeMulti']);


Route::get('welcome/filter',[UserController::class,'filterProduct'])->name('filter');

/*
Route::get("/", function(){
    return view("test");
 });*/

 Route::post('/ss/store', ['\App\Http\Controllers\Controller' , 'store_servers'])

 ->name('store_servers2');
 


 Route::get('/welcome/ssd', ['\App\Http\Controllers\Controller','ssd'])->name('ssd');






 Route::get('/welcome/anotherpage', [Controller::class, 'anotherpage']); 

 Route::get('/welcome/sanotherpagesd', ['\App\Http\Controllers\Controller','anotherpage'])->name('anotherpage');



 

//---------------------controls ahlam---------////

Route::get('viewpagehome',[singupController::class,'viewhome']);
Route::get('viewpagelogin',[singupController::class,'viewlogin']);
Route::get('viewpageregist',[singupController::class,'viewregister']);
Route::get('viewpageshowusers',[singupController::class,'viewusers']);

////----------------show pages----------------//////////

Route::post('register',[singupController::class,'registration']);
Route::post('loginuser',[singupController::class,'login']);
Route::get('exit',[singupController::class,'logout']);
//Route::get('dashboard',[singupController::class,'dashboard']);

Route::post('adduserss',[singupController::class,'addusers']);


////----------------show servers----just test------------//////////
Route::get('viewpageservers',[ServerController::class,'viewservers']);
Route::post('addsrvers',[ServerController::class,'addsrvs']);


////----------------show setting----------------//////////

Route::get('viewpagesetting/{id}',[SettingController::class,'viewsetting']);


Route::post('viewpagesetting/{id}',[SettingController::class,'updatepassword']);


Route::post('updateset/{id}',[SettingController::class,'updatesetting']);





///////////////////////////////////////
Route::get('viewpageedituser/{id}',[singupController::class,'edituser']);
Route::post('viewpageedituser/{id}',[singupController::class,'updateuser']);

Route::get('deleteus/{id}',[singupController::class,'deleteuser']);



//////////////////////////////

Route::post('viewpageservers', [ServerController::class, 'requestcancel']);
Route::get('edited/{id}', [ServerController::class, 'cancelserver']);

Route::post('cancel/{id}', [ServerController::class, 'updatestatusserver']);


Route::get('returnedd/{id}', [ServerController::class, 'cancelrequestserver']);
Route::post('returncancel/{id}', [ServerController::class, 'updatestatuscancel']);



////////////////////////////////////////Proxy/////////////////////
Route::get('viewpageproxy',[ProxyController::class,'viewProxy']);


Route::get('viewpageproviderproxy',[ProxyController::class,'viewproviderProxy']);
Route::post('addprvpxy',[ProxyController::class,'addproviderproxy']);


Route::get('viewpageAccountproviderProxy',[ProxyController::class,'viewAccountproviderProxy']);
Route::post('addaccprvpxy',[ProxyController::class,'addaccountprvproxy']);

Route::post('addacc', [ProxyController::class, 'appendaccproxy']);

Route::post('addprx',[ProxyController::class,'addproxys']);

Route::post('addprxx',[ProxyController::class,'addbulkproxy']);
Route::get('/search', [ProxyController::class,'index']);
/////////////////////////////////////
Route::get('products', [ProxyController::class,'indexx']);
Route::get('delete/{id}',[ProxyController::class,'deleteproxy']);
Route::post('/deleted',[ProxyController::class,'alldeleteproxy']);
////////////////////////control teams////
Route::get('viewpageteams',[TeamsController::class,'viewteams']);
Route::post('addtm',[TeamsController::class,'addteam']);
Route::get('filterteam', [ProxyController::class,'filtrsbyteam']);
//Route::get('show/{id}', [ProxyController::class,'viewdetailsproxy']);
Route::get('/', function () {
    $resultsproxy=proxy::paginate(10);
    $resultssever=Server::paginate(10);
    $resultsdomain=Domain::paginate(10);
    $resultsteams=Team::paginate(10);
    $resultsusers=singup::paginate(10);
    return view('singup.home', compact('resultsusers','resultsteams','resultsproxy','resultssever','resultsdomain'));
});
Route::get('editproxy/{id}', [ProxyController::class,'editproxy']);
Route::post('editproxy1/{id}', [ProxyController::class, 'updateproxy']);
//Route::post('editproxy/{id}', [ProxyController::class, 'updateproxy']);
Route::get('/searchacc', [ProxyController::class,'searchaccprv']);
Route::get('deleteaccprvprx/{id}',[ProxyController::class,'deleteaccprvproxy']);
Route::post('updateacc/{id}', [ProxyController::class, 'updateaccprvproxy']);
///////////////////////////provider////////////////////////////////////////////
Route::get('/searchprovider', [ProxyController::class,'searchproviderpx']);
Route::get('deleteprovpx/{id}',[ProxyController::class,'deleteproviderpx']);
Route::post('updateprvpx/{id}', [ProxyController::class, 'updateproviderpx']);

///////////////////////////search user////////////////////////////////////////////
Route::get('/searchusr', [singupController::class,'searchuser']);
Route::get('/searchtm', [TeamsController::class,'searchtem']);
Route::get('deleteteam/{id}',[TeamsController::class,'deletetem']);

Route::post('addprvlisted',[ToolsController::class,'addpv']);
Route::get('deleteprvlist/{id}',[ToolsController::class,'deleteprvlist']);
Route::get('/searchp', [ToolsController::class,'searchindex']);
Route::post('updateprvpx/{id}', [ToolsController::class,'updateprvlisted']);

///////////////////////////API////////////////////////////////////////
Route::get('viewapiaddprovider', [ApiProxyController::class,'viewaddprovider']);
Route::get('viewapimangerprovider', [ApiProxyController::class,'viewmangerprovider']);
Route::get('viewapiaddaccounts', [ApiProxyController::class,'viewaddaccounts']);
Route::get('viewapimangeraccounts', [ApiProxyController::class,'viewmangeraccounts']);
Route::post('addapiprov',[ApiProxyController::class,'addapiprovider']);
Route::post('addapiacc',[ApiProxyController::class,'addapiaccount']);
Route::get('viewcreateproxyapi', [ApiProxyController::class,'viewcreateproxy']);
Route::get('viewlistproxyapi', [ApiProxyController::class,'viewlistproxy']);
Route::post('addaccprvapi', [ApiProxyController::class, 'appendaccapiproxy']);
Route::get('deleteapiprv/{id}', [ApiProxyController::class,'deleteapiprovider']);
Route::get('deleteapiacc/{id}', [ApiProxyController::class,'deleteapiaccount']);
Route::get('ViewActvetypage', [ApiProxyController::class,'viewproxyactvety']);








Route::get('/root', function () {
    return view('singup.edituser');
});

Route::get('/root012', function () {
    return view('singup.login');
});


Route::get('/testah', function () {
    return view('justtest');
});



Route::get('get01', [ApiProxyController::class,'getData01']);
Route::get('get02', [ApiProxyController::class,'getData02']);
Route::get('get03', [ApiProxyController::class,'getData03']);
Route::get('get04', [ApiProxyController::class,'getwebshar']);
Route::get('test06', [ApiProxyController::class,'test006']);
Route::get('Getproxywebshare', [ApiProxyController::class,'GETProxy']);



