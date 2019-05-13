<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as AppRequest;
use Illuminate\Validation\Validator;
use App\Trip as Trip;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RefundTableController as Refund;
use App\worker;
use Illuminate\Support\Facades\DB;


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
    public function getForManager($id)
    {
        $me=worker::find($id);
        $workercontroller=new WorkerController($me);
        //  workers where i am manager
        $workers=$workercontroller->getmyWorkers($me->id);
        // var_dump($workers);
        // die();
        $workers_id=[];
        if($workers!==false)
        {
            for($x=0;$x<count($workers);$x++)   
            {
                $workers_id[]=$workers[$x]->id;
                // var_dump($workers[$x]);
            }
            // var_dump($workers_id);
            // die();
            $reqArr=[];
            for($x=0;$x<count($workers_id);$x++)
            {
            $requests=DB::connection('mysql')
                                        ->select("
                                            select * 
                                            from requests
                                            where worker_id = $workers_id[$x]
    
                                        ");
            $reqArr[]=$requests;
            }
            // var_dump($reqArr);
            //     die();
            $reqData=[];
            $extender='s';
            foreach($reqArr as $requestsFromWorker)
            {
                foreach($requestsFromWorker as $request)
                $reqData[]=DB::connection('mysql')
                                    ->select("
                                        select * 
                                        from requests 
                                        join workers 
                                        on requests.worker_id=workers.id
                                        join $request->type$extender
                                        on requests.id=$request->type$extender.request_id
                                        join statuses
                                        on statuses.id=workers.id
                                        
                                    ");
            }
            return response()->json($reqData);
        }else{
            return response()->json('Not found',200);
        }
        
        
    }
}
