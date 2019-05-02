<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;

class StatusController extends Controller
{
    protected $id;
    public function __construct($id)
    {
        $this->id=$id;
    }
    public function intialize()
    {
        $status=new Status([
            'id'=>$this->id,
            'available_days'=>null,
            'overwork'=>null,
            'holiday_available'=>null
        ]);
        $status->save();
    }
}
