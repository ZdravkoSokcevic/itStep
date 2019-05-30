<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Arrival extends Model
{
    const CREATED_AT = NULL;

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = NULL;
    protected $fillable=[
        'id',
        'worker_id',
        'calendar_id',
        'arrival',
        'start_work',
        'end_work',
        'leave',
        'work',
        'description'
    ];

    public static function workerExists($calendarId,$workerId)
    {
        // var_dump($workerId);
        // die();
        $exists=DB::table('arrivals')
                        ->select()
                        ->where('calendar_id','=',$calendarId)
                        ->where('worker_id','=',$workerId)
                        ->get();
        // var_dump($workerId,$calendarId);
        // var_dump($exists);
        // die();
        if(isset($exists))
        {
            return $exists;
        }else{
            return false;
        }
    }
}
