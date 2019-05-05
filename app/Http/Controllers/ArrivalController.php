<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Calendar;

class ArrivalController extends Controller
{
    public function store(Request $request)
    {
        // var_dump($request->arrival);
        $days=explode('T',$request->arrival)[0];
        // var_dump($days);
        // die();
        $exists=DB::table('calendars')
                ->select('*')
                ->where('days',$days)
                ->get();
        // if not exists in table Calendar then we must insert
        //  in table Caledar that day
        if(!count($exists))
        {
            $data=DB::table('calendars')->insert([
                'days'=>$days,
                'type'=>'radni',
                'description'=>''
            ]);
            $exists[0]->id=DB::getPdo()->lastInsertId();
        }else{
            $exists[0]->id=$exists[0]->id;
        }
        // var_dump($exists[0]->id);
        // die();
        $arrivalData=DB::table('arrivals')->insert([
            'worker_id'=>$request->worker_id,
            'calendar_id'=>$exists[0]->id,
            'arrival'=>$request->arrival,
            'start_work'=>$request->start_work,
            'end_work'=>$request->end_work,
            'leave'=>$request->leave,
            'work'=>'work',
            'description'=>$request->description
        ]);
    }
}
