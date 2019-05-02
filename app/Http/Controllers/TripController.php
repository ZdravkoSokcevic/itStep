<?php

namespace App\Http\Controllers;

use App\Request;
use Illuminate\Http\Request as Req;
use Validator;
use App\worker;
use App\Trip;

class TripController extends Controller
{
    public static function store(Req $request)
    {
        $request->validate([
            'go_time'=>'required',
            'back_time'=>'required'
        ]);
        // $validate=Validator::make((array)$request,[
        //     $request->go_time=>'required',
        //     $request->back_time=>'required'
        // ]);
        // var_dump($validate);
        // die();
        $req=Request::where('id',$request->request_id);
        $worker=worker::where('id',$request->worker_id);
        if($req!==null && $worker!==null)
        {
            $trip=new Trip($request->all());
            $trip->save();
        }

    }
}
