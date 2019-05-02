<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arrival extends Model
{
    public $created_at=false;
    public $updated_at=false;
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
}
