<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    public $created_at=false;
    public $updated_at=false;
    protected $fillable=[
        'send_date',
        'type',
        'decision',
        'decision_date',
        'third_person',
        'worker_id',
        'description'
    ];
}
