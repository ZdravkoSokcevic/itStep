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

    // public static function findOrFail($id)
    // {
    //     if($success=static::findOrFail($id)){
    //         return $success;
    //     }else{
    //         return false;
    //     }
    // }
}
