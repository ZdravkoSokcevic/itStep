<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\overwork;

class OverworkController extends Controller
{
    public function store(Request $request)
    {
        $overwork=new overwork($request->all());
        $overwork->save();
    }
    public static function save(Request $request)
    {
        $overwork=new overwork($request->all());
        if($overwork->save())
            return $overwork;
    }
}
