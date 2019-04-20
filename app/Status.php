<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable=[
        'available_days',
        'overwork',
        'holiday_available'
    ];
}
