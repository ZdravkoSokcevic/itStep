<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Allowance;

class AllowanceController extends Controller
{
    public function store(Request $request)
    {
        $allowance=new Allowance($request->all());
        $allowance->save();
    }
    public static function save(Request $request)
    {
        $allowance=new Allowance($request->all());
        if($allowance->save())
        {
            return $allowance;
        }
    }
}
