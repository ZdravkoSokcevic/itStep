<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    public $created_at=false;
    public $updated_at=false;
    // protected $fillable=[
    //     'id',
    //     'username',
    //     'password',
    //     'picture',
    //     'email'
    // ];
    protected $guarded = [
        'first_name',
        'last_name',
        'created_at',
        'updated_at',
        'id_manager',
        'type'
    ];
}
