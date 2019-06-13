<?php
use Illuminate\Queue\Console\WorkCommand;
use App\Http\Controllers\WorkerController;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\View;
use App\worker;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// header('Content-Type: application/x-www-form-urlencoded');



Route::get('/', function () {
    return view('insert');
});
// Route::get('/refund',function(){
//     return view('refund');
// });
Route::post('/hash',function(){
    $data=json_decode(file_get_contents("php://input"));
   
    $password=$data->password;
    $hash=Illuminate\Support\Facades\Hash::make($password);
    return response()->json($hash);
});

Route::post('worker/login','WorkerController@login');
Route::get('/login',function(){
    return view('login');
});
Route::get('/logout',function(){
    if(!is_null(session('id')))
    {
        session()->pull('id');
    }
    return "Odlogovan";
});
Route::get('/worker/all','WorkerController@workers');
Route::post('/worker/update/{id}','WorkerController@updWorker');
Route::post('/worker/insert','WorkerController@store');
Route::get('worker/get/{id}','WorkerController@find');
Route::get('/manager/mymanager/{id}','WorkerController@getManager');
Route::delete('worker/delete/{id}','WorkerController@delete');
Route::post('worker/chpsswd','WorkerController@chPasswd');


//  Request routes
Route::get('/request/all','RequestController@all');
Route::post('request/insert','RequestController@store');
Route::get('/request/get/{id}','RequestController@find');
Route::post('/request/setDecision','RequestController@approveRequest');
Route::get('request/forManager/{id}','RequestController@getForManager');


Route::get('/arrival',function(){
    $workers=worker::all();
    return view('arrival',['workers'=>$workers]);
});
//      Retrun all arrivals for worker with id
Route::get('/arrival/getAll/{id}','ArrivalController@findAllForWorker');

Route::post('/arrival/insert','ArrivalController@store');


Route::get('/nonWorkingDays','CalendarController@nonWorking');

///////////////////////////////////////////////////////////
//              MANAGER ROUTES                           //
///////////////////////////////////////////////////////////
Route::get('/manager/all','WorkerController@getAllManagers');


///////////////////////////////////////////////////////////
//              WORKER ROUTES                            //
///////////////////////////////////////////////////////////
