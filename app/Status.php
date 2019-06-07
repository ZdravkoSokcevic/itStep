<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $updated_at=false;
    public $created_at=false;
    const CREATED_AT=false;
    const UPDATED_AT=false;
    protected $fillable=[
        'id',
        'available_days',
        'overwork',
        'holiday_available'
    ];
}
