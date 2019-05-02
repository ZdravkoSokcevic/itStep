<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DayOff extends Model
{
    public $created_at=false;
    public $updated_at=false;
    protected $fillable=[
        'request_id',
        'numberDays'
    ];
}
