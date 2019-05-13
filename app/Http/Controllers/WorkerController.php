<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use App\worker;
use App\Auth;
use App\Status;
use Illuminate\Support\Facades\DB;

use Validator;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Session as IlluminateSession;
use Symfony\Component\HttpFoundation\Response;

class WorkerController extends Controller
{
    public function store(Request $request)
    {
          //  Rules of input
          $rules=array(
            'first_name'=>'required',
            'last_name'=>'required',
            'account_type'=>'in:admin,manager,worker'
        );
        $arr=(array)$request;
        $validator=Validator::make($arr,$rules);

        $id=static::insertWorker($request);
        $_SESSION['id']=$id;
        $request->merge(['id'=>$id]);
        static::insertAuth($request);
        $data=worker::all();
        $request->merge(['id'=>$id]);
        $status=new StatusController($id);
        $status->intialize();
        return $this->find($request);
    }

    public static function insertWorker(Request $request)
    {
        unset($request->created_at);
        unset($request->updated_at);
        
      
        // var_dump($rules);
        // die();
        // if($validator->fails())
        // {
        //     return redirect('/');
        // }else{
            $request->first_name=$_POST['first_name'];
            $request->last_name=$_POST['last_name'];
            if(is_null($request->id_manager))
            {
                $request->id_manager='NULL';
            }else{
                $request->id_manager=$_POST['id_manager'];
            }
            $request->type=$_POST['type'];
            
            $worker=new worker($request->all());
            $worker->save();
            return $worker->id;
        // }
    }
    public static function insertAuth(Request $request)
    {
        $request->username=$_POST['username'];
        $pass=Hash::make($_POST['password']);
        $request->email=$_POST['email'];
        if(is_null($_POST['picture']))
        {
            $request->picture='NULL';
        }else{
            $request->picture=$_POST['picture'];
        }
        $request->merge(['password'=>$pass]);
        $auth=new Auth($request->all());
        $auth->save();
    }
    public function login(Request $request)
    {
        // var_dump($request);
        // die();
        $rules=array(
            'password'=>'required'
        );
        $loggedIn=DB::table('auths')
                            ->select('*')
                            ->where('username',$request->username)
                            ->orWhere('email',$request->username)
                            ->first();
        // var_dump($loggedIn);
        // die();
        if($loggedIn &&
            Hash::check($request->password,$loggedIn->password))
            {
                session(['id'=>$loggedIn->id]);
                return json_encode($loggedIn);

                // var_dump($id);
            }else{
                return json_encode("nije ulogovan");
                // echo json_encode("nije ulogovan");
            }
    }
    public function find(Request $request)
    {
        $user=DB::table('workers')
                                    ->join('auths','auths.id','=','workers.id')
                                    ->join('statuses','statuses.id','=','statuses.id')
                                    ->where('workers.id','=',$request->id)
                                    ->where('auths.id','=',$request->id)
                                    ->where('statuses.id','=',$request->id)
                                    ->get();

        // $user=DB::select(
        //     DB::raw("select * from workers 
        //             join auths on workers.id=auths.id
        //             join statuses on statuses.id=workers.id
        //             where workers.id={$request->id}")
        // );
        // var_dump(($user));
        // die();
        return response()->json($user);
    }

    public function getAllManagers()
    {
        $managers=DB::table('workers')
                                    ->join('auths','auths.id','=','workers.id')
                                    ->join('statuses','statuses.id','=','statuses.id')
                                    ->where('workers.type','=','manager')
                                    ->get();
        if(count($managers))
        {
            http_response_code(200);
            return response()->json($managers);
            
        }else{
            return false;
        }
    }
    public function workers()
    {
        // echo 'usao';
        $workers=DB::table('workers')
                                    ->join('auths','auths.id','=','workers.id')
                                    ->join('statuses','statuses.id','=','workers.id')
                                    ->get();
        if(count($workers))
        {
            return response()->json($workers);
        }else{
            return false;
        }
    }
    public function getManager($id)
    {
        // var_dump($id);
        $manager=DB::connection('mysql')
                        ->select("
                        select *
                        from workers s1
                        where s1.id=(
                           select w2.id 
                           from workers w1,workers w2
                           where w1.id=$id and
                           w1.id_manager=w2.id and
                           w1.id<>w2.id
                        )
                        ");
        // var_dump($manager);
        // die();
        if(count($manager))
        {
            return $manager;
        }else{
            return false;
        }
    }
    public function getMyWorkers($id)
    {
        $workers=DB::connection('mysql')
                            ->select("
                                select *
                                from workers
                                where id_manager=$id;
                            ");
        $workerArr=[];
        foreach($workers as $worker)
        {
            $workerArr[]=$worker;
        }
        if(count($workerArr))
        {
            return $workerArr;
        }else{
            return false;
        }
    }

}
