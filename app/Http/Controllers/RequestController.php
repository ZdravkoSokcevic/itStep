<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as AppRequest;
use Illuminate\Validation\Validator;
use App\Trip as Trip;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RefundTableController as Refund;
use App\worker;


// use Faker\Provider\DateTime;

class RequestController extends Controller
{
    public function store(Request $request)
    {

        // var_dump($request);
        // die();

         //VALIDATOR

        $validatorData=$request->validate([
            'type'=>'in:trip,overwork,refund,day_off,allowance',
            'description'=>''
        ]);
        $workers=worker::where('id',$request->id);
        
        $request->send_date=time('Y-m-d H:I:m');
        $request->decision='NULL';
        $request->decision_date='NULL';
        $reqData=new AppRequest($request->all());
        $req=$reqData->save();

        switch($request->type)
        {
            case 'trip':
            {
                $request->validate([
                    'go_time'=>'required|time',
                    'back_time'=>'required|time',
                    'country'=>'required',
                    'town'=>'required'
                ]);
                $request->merge(['request_id'=>$reqData->id]);
                // $insertData=new Trip($request->all());
                $data=TripController::store($request);
            };break;
            case 'day_off':
            {
                // toDo
                $request->validate([
                    'numberDays'=>'required'
                ]);
                $request->merge(['request_id'=>$reqData->id]);
                $data=DayOffController::save($request);

            };break;
            case 'overwork':
            {
                //toDo
                $request->validate([
                    'number_hours'=>'required|int',
                    'description'=>''
                ]);
                $request->merge([
                    'request_id'=>$reqData->id]);
                $data=OverworkController::save($request);
            };break;
            case 'allowance':
            {
                $request->validate([
                    'price'=>'required|int'
                ]);
                $request->merge(['request_id'=>$reqData->id]);
                $data=AllowanceController::save($request);
            };break;
            case 'refund':
            {
                //toDo
                $request->merge([
                    'request_id'=>$reqData->id,
                    'worker_id'=>$request->worker_id]);
                $data=Refund::store($request);
            };break;
        }

        // var_dump($data);
        // die();

        if(isset($data))
        {
            echo json_encode("Zahtjev uspjesno poslat!");
            http_response_code(200);
        }else{
            http_response_code(404);
            echo json_encode("Doslo je do greske,pokusajte ponovo");
        }
    }
}
