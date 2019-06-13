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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Routing\RequestContext;
use Illuminate\Support\Facades\File;

// use Faker\Provider\DateTime;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        header('Content-Type: text/plain; charset=utf-8');

        // var_dump($request);
        // die();

         //VALIDATOR
        $validatorData=$request->validate([
            'type'=>'in:trip,overwork,refund,day_off,allowance',
            'description'=>''
        ]);
        $workers=worker::where('id',$request->id);
        // return response()->json($request->only([
        //     'type',
        //     'thirdPerson',
        //     'worker_id',
        //     'description',
        //     'attachment',
        //     'reason',
        //     'quantity',
        //     'description'
        // ]));
        // die();
        $request->send_date=time('Y-m-d H:I:m');
        $request->decision='NULL';
        $request->decision_date='NULL';
        $reqData=new AppRequest($request->all());
        $req=$reqData->save();
        $filePath='';
        if(isset($_FILES['attachment']))
        {
            $file=$request->file('attachment');
            $filePath=RequestController::storeFile($reqData,$file);
            // return response()->json($filePath);
        }else{
            $filePath=null;
        }
        

        // return response()->json($request->type);
        // die();
        switch($request->type)
        {
            case 'trip':
            {
                $request->validate([
                    'go_time'=>'required',
                    'back_time'=>'required',
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
                var_dump("usao");
                return response()->json($filePath);
                die();
                $request->merge([
                    'attachment'=>$filePath,
                    'request_id'=>$reqData->id,
                    'worker_id'=>$request->worker_id]);
                $data=\App\Http\Controllers\RefundTableController::stor($request);
            };break;
            default:
            {
                return response()->json("Usao u default");
            }
        }
        return response()->json("izasao iz switch");
        die();
        if(isset($data))
        {
            echo json_encode("Zahtjev uspjesno poslat!");
            http_response_code(200);
        }else{
            http_response_code(404);
            echo json_encode("Doslo je do greske,pokusajte ponovo");
        }
    }

    /*
    *       Storing an attachment sent with refund request
    */
    public static function storeFile($r,$file)
    {
        $fileName=$file->getClientOriginalName();
        $to_return="attachments/$fileName";
        $file->name=$fileName;
        Storage::disk('local')->putFileAs('attachments',$file,$fileName);
        return $to_return;
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
            $reqData=[];
            $extender='s';
            foreach($reqArr as $requestsFromWorker)
            {
                foreach($requestsFromWorker as $request)
                {
                    // return response()->json($request);
                    // die();
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
                        where requests.id=$request->id
                        
                    ");
                }
               
            }
            return response()->json($reqData);
        }else{
            return response()->json('Not found',200);
        }
        
        
    }
    public function all()
    {
        $justRequests=DB::table('requests')
                        ->select()
                        ->get();
        $allRequests=[];
        foreach($justRequests as $request)
        {
            $allRequests[]=DB::table('requests')
                                ->select()
                                ->join('workers','workers.id','=','requests.worker_id')
                                ->join($request->type.'s',$request->type.'s.request_id','=','requests.id')
                                ->get();
                                
        }
        // die();
        return response()->json($allRequests);
    }
    public function find($id)
    {
        $request=AppRequest::findOrFail($id);
        $extension='s';
        $reqData=DB::connection('mysql')
                        ->select("
                            SELECT * 
                            FROM requests
                            JOIN $request->type$extension
                            ON requests.id=$request->type$extension.id
                            JOIN workers
                            ON workers.id=requests.worker_id 
                            JOIN statuses
                            ON statuses.id=requests.id
                            WHERE requests.id=$id
                        ");
        return response()->json($reqData,200);
    }
    public function approveRequest(Request $request)
    {
        $req=new AppRequest();
        $oldRequest=$req->find($request->id);
        $timeNow=Date('Y-m-d h:i:s');
        // $timeNow=$time->getTimestamp();
        // switch($oldRequest)
        $success=DB::update("
                update requests set decision=?,
                decision_date=? 
                where id=?
            ",[
            $request->decision,
            $timeNow,
            $oldRequest->id
        ]);
        $controller=new RequestController();
        $oldData=$controller->find($oldRequest->id)->original[0];
        return response()->json($oldData);
        die();
        switch($oldData->type)
        {
            case 'allowance':
            {
                var_dump('Allowance');
                // $newValue=$oldData->;
                // DB::update("
                //     update status
                //     set 
                // ");
            };break;
            case 'overwork':
            {
                $newValue=($oldData->numberHours)%8;
                $newDays=$number_hours->overwork+$oldData->overwork;
                $status=Status::find($request->id);
                $status->overwork=$newDays;
                $status->save();
                var_dump('Overwork');
            };break;
            case 'trip':
            {
                var_dump('trip');
            };break;
            case 'day_off':
            {
                var_dump('Day_off');
            };break;
            case 'refund':
            {
                var_dump('Refund');
            };break;
        }
        return response()->json($success);
    }
}
