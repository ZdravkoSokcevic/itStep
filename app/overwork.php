<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class overwork extends Model
{
    public $created_at=false;
    public $updated_at=false;
    protected $fillable=[
        'request_id',
        'number_hours',
        'reason'
    ];
}
