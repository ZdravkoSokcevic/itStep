<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Schema\Blueprint;
use App\worker;
use App\Auth;
use App\Status;
use Illuminate\Support\Facades\DB;
// use Illuminate\Validation\Validator;
use App\Http\Controllers\Controller;
use \Validator;
// use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Session as IlluminateSession;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Runner\Exception;

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
            $path=WorkerController::picture_path($request->id);
            $request->file('picture')->move($path);
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
        $exists=DB::table('auths')
                            ->select('*')
                            ->where('username',$request->username)
                            ->orWhere('email',$request->username)
                            ->first();
        // var_dump($loggedIn);
        // die();
        if($exists &&
            Hash::check($request->password,$exists->password))
            {
                session(['id'=>$exists->id]);
                return json_encode($exists);

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
        return response()->json($user);
    }

    public function getAllManagers()
    {
        $managers=DB::table('workers')
                                    ->join('auths','auths.id','=','workers.id')
                                    ->join('statuses','statuses.id','=','workers.id')
                                    ->where('workers.account_type','=','manager')
                                    ->get();
        // foreach($managers as $manager)
        // {
        //     $manager->id=$manager->sid;
        //     unset($manager->sid);
        // }
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
                                    ->select([
                                        'workers.id',
                                        'workers.first_name',
                                        'workers.last_name',
                                        'workers.id_manager',
                                        'auths.username',
                                        'auths.picture',
                                        'auths.email',
                                        'statuses.available_days',
                                        'statuses.overwork',
                                        'statuses.holiday_available'
                                    ])
                                    ->join('auths','auths.id','=','workers.id')
                                    ->join('statuses','statuses.id','=','workers.id')
                                    ->get();
        if(count($workers))
        {
            return response()->json(collect($workers)->except('password'));
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

    public static function picture_path($extender=null)
    {
        $defPath='/app/public/profile_pictures';
        $defPath.=$extender;
        return $defPath;
    }

    public function delete($id)
    {
        $worker=worker::findOrFail($id);
        echo json_encode($worker);
        die();
        if(count((array)$worker)>1)
        {
            $success=$worker->delete();
            return response()->json("Radnik uspjesno obrisan");
            die();
        }else{
            return response()->json("Worker not found");
        }
        die();
        if($success)
        {
            return response()->json("Uspjesno obrisan");
        }else{
            return response()->json($worker);
        }
        
    }

    public function updWorker($id,Request $request)
    {
        $req=new worker();
        $succ=$req->validateInput($request,$req->rules);
        //  If validation approves and id's match 
        if($id==$request->id && $succ)
        {
            $workerColumns=$request->only([
                'first_name',
                'last_name',
                'id_manager',
                'account_type'
            ]);
            $statusColumns=$request->only([
                'available_days',
                'overwork',
                'holiday_available'
            ]);
            $authColumns=$request->only([
                'username',
                'picture',
                'email'
            ]);
            
             
            $wUpdate=DB::table('workers')
                            ->where('id','=',$request->id)
                            ->update($workerColumns);
            $sUpdate=DB::table('statuses')
                                ->where('id','=',$id)
                                ->update($statusColumns);
            $aUpdate=DB::table('auths')
                            ->where('id','=',$request->id)
                            ->update($authColumns);
           
            return response()->json(['message'=>'Uspesno update-ovan'],200);
        }else{
            return response()->json(['message'=>'Validation not approved'],400);
        }
       
    }

    public function chPasswd(Request $request)
    {
        $worker=DB::table('auths')
                    ->select('*')
                    ->where('username',$request->user)
                    ->orWhere('email',$request->user)
                    ->first();
        // return response()->json($worker->password);
        // die();
        if(Hash::check($request->pass,$worker->password))
        {
            $updatePass=new Auth();
            $worker->password=Hash::make($request->newPsswd);
            $upd=DB::table('auths')
                        ->where('id','=',$worker->id)
                        ->update((array)$worker);
            return response()->json($upd,200);
        }
        return response()->json(['message'=>'Invalid creditials'],404);
    }

}

// $2y$12$alOTvb2iW1VcRM2oF6HVYuKpnXT7lKhcvCXrO3Dh8ZKiHNWtgqR/a
// $2y$12$alOTvb2iW1VcRM2oF6HVYuKpnXT7lKhcvCXrO3Dh8ZKiHNWtgqR/a