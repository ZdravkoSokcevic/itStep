<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Calendar;
use Illuminate\Support\Facades\Validator;
use App\Arrival;
use App\Auth;

class ArrivalController extends Controller
{
    public function store(Request $request)
    {       
        $validate=$request->validate([
            'worker_id'=>'required',
            'arrival'=>'required',
            'start_work'=>'',
            'end_work'=>'',
            'leave'=>'',
            'description'=>''
        ]);
        $days=explode(' ',$request->arrival)[0];
        
        //  Check if this day exists in calendars table
        $calendar=DB::table('calendars')
                ->select('*')
                ->where('days',$days)
                ->get();
        // if not exists in table Calendar then we must insert
        //  in table Caledar that day
        if(!count($calendar))
        {
            
            $data=DB::table('calendars')->insert([
                'days'=>$days,
                'type'=>'radni',
                'description'=>''
            ]);
            $calendar=DB::table('calendars')
                        ->select('*')
                        ->where('days',$days)
                        ->get();
        }else{
            $calendar[0]->id=$calendar[0]->id;
        }

        //  Check if he exists in arrival table this day
        $existsInArrival=Arrival::workerExists($calendar[0]->id,$request->worker_id);
        if(!$existsInArrival || !count($existsInArrival))
        {
            $arrivalData=DB::table('arrivals')->insert([
                'worker_id'=>$request->worker_id,
                'calendar_id'=>$calendar[0]->id,
                'arrival'=>$request->arrival,
                'start_work'=>$request->start_work,
                'end_work'=>$request->end_work,
                'leave'=>$request->leave,
                'work'=>'work',
                'description'=>$request->description
            ]);
            $id=DB::table('arrivals')
                    ->select('id')
                    ->where('worker_id',$request->worker_id)
                    ->where('calendar_id',$calendar[0]->id)
                    ->get();
        }else{
            $exArrival=DB::table('arrivals')
                            ->select('*')
                            ->where('worker_id','=',$request->worker_id)
                            ->where('calendar_id','=',$calendar[0]->id)
                            ->get();


            $request->merge([
                'id'=>$exArrival[0]->id,
                'calendar_id'=>$calendar[0]->id
                ]);
            // var_dump($request->leave);
            // die();
            $sucess=ArrivalController::updateArrival($request);
            $arrivalData=$sucess;
            
        }
        if($arrivalData)
        {
            return response()->json($arrivalData);
        }else{
            $message="Something went wrong";
            return response()->json($message,404);
        }
        
    }
    public function findAllForWorker($id)
    {
        $data=new Arrival();
        $data->id=$id;
        $validate=Validator::make((array)$data,[
            'id'=>'required'
        ]);
        $arrivals=DB::connection('mysql')
                                ->select("
                                SELECT * 
                                FROM arrivals
                                JOIN calendars
                                ON arrivals.calendar_id=calendars.id
                                JOIN workers
                                ON arrivals.worker_id=workers.id
                                WHERE workers.id=$data->id
                                ORDER BY calendars.days desc
                                ");
        return response()->json($arrivals,200);
    }
    public static function updateArrival(Request $request)
    {
    $updData=$request->only([
        'id',
        'arrival',
        'calendar_id',
        'worker_id',
        'arrival',
        'start_work',
        'end_work',
        'leave',
        'description',
        'work'
    ]); 
    // var_dump($updData);
    // die();

    $newArrival=Arrival::where('calendar_id','=',$request->calendar_id)
                        ->where('worker_id','=',$request->worker_id)
                        ->get()
                        ->first();
    //var_dump($newArrival);
    $newArrival->update($updData);
    return $newArrival;
    }
}
