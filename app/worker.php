<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use \Illuminate\Validation\Factory as Valid;

class worker extends Model
{
    public $created_at=false;
    public $updated_at=false;
    const CREATED_AT=false;
    const UPDATED_AT=false;
    protected $fillable=[
        'first_name',
        'last_name',
        'id_manager',
        'account_type'
    ];

    public $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'account_type'=>'in:admin,worker,manager',
            'username'=>'required'
    ];
    public function validateInput(Request $request)
    {

        $validator     = new \Validator($request, $this->rules);
        $succ=\Validator::make($request->all(),$this->rules);
        if($succ->fails())
        {
            return false;
        }
            return true;

    }
}
