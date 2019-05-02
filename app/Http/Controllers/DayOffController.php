<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\DayOff;

class DayOffController extends Controller
{
    public function store(Request $request)
    {
        $data=new DayOff($request->all());
        if($dayOff=$data->save())
        {
            return $data;
        }else{
            return false;
        }
    }
    public static function save(Request $req)
    {
        $dayOff=new DayOffController;
        $data=$dayOff->store($req);
        return $data;
        // {
        //     return $data;
        // }else{
        //     return false;
        // }
        
    }
}
