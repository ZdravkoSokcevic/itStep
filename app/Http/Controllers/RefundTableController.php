<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use App\Refund;

class RefundTableController extends Controller
{
    //
    public static function store(Request $request)
    {
        // var_dump($request->request_id);
        // die();
        $request->validate([
            'reason'=>'in:putovanje,slobodan_dan'
        ]);
        $refund=new Refund($request->all());
        $refund->save();
        return $refund;
    }
}
