<?php
use Illuminate\Queue\Console\WorkCommand;
use App\Http\Controllers\WorkerController;
use Symfony\Component\HttpFoundation\Request;
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
Route::get('logout',function(){
    if(!is_null(session('id')))
    {
        session()->pull('id');
    }
    return "Odlogovan";
});

Route::post('worker/insert','WorkerController@store');


//  Request routes
Route::post('request/insert','RequestController@store');