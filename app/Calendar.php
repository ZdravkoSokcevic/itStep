<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $created_at=false;
    public $updated_at=false;
    protected $fillable=[
        'id',
        'date',
        'type',
        'description'
    ];
    public function existsDate($date)
    {
        $date=Calendar::find('days',$date);
        if(isset($date))
        {
            return $date;
        }else{
            return null;
        }
    }
}
