<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as AppRequest;
use Illuminate\Validation\Validator;

// use Faker\Provider\DateTime;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        // $validatorData=$request->validate([
        //     'type'=>'in:trip,overwork,refund',
        //     'thirdPerson'=>'exists:mysql.workers.id',
        //     'worker_id'=>'exists:mysql.workers.id',
        //     'description'=>''
        // ]);
        $request->send_date=time('Y:m:d H:I:m');
        $request->decision='NULL';
        $request->decision_date='NULL';
        $reqData=new AppRequest($request->all());
        if($reqData->save())
        {
            echo json_encode("Zahtjev uspjesno poslat!");
            http_response_code(200);
        }else{
            http_response_code(404);
            echo json_encode("Doslo je do greske,pokusajte ponovo");
        }
    }
}
