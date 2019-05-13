<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class worker extends Model
{
    public $created_at=false;
    public $updated_at=false;
    protected $fillable=[
        'first_name',
        'last_name',
        'id_manager',
        'account_type'
    ];
}
