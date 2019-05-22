<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Calendar;

class CalendarController extends Controller
{
    public function nonWorking()
    {
        $days=Calendar::where('type','=','neradni')->get();

        return response()->json($days,200);
    }
    public function store(Request $request)
    {
        
    }
}
