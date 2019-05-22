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


Route::get('/', function () {
    return view('insert');
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
Route::post('/worker/insert','WorkerController@store');
Route::get('worker/get/{id}','WorkerController@find');
Route::get('/manager/mymanager/{id}','WorkerController@getManager');


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
