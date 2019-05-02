<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public $created_at=false;
    public $updated_at=false;
    protected $fillable=[
        'request_id',
        'worker_id',
        'go_time',
        'back_time',
        'country',
        'town'
    ];

    
}
