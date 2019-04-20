<?php

use Illuminate\Database\Seeder;
// use Faker\Provider\Internet;
use App\worker;
use App\Status;

class AuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password=Hash::make(str_random(10));

        $workers=worker::all();
        $arr=[];
        foreach($workers as $worker)
        {
            $arr[]=$worker['id'];
        }
        $statuses=Status::all();
        $arrr=[];
        if(count($statuses))
        { 
            foreach($statuses as $status)
            {
                $arrr[]=$status->id;
            }

        }
        $resarr=[];
        if(count($arrr))
        {
            $result=array_intersect_key($arr,$arrr);
            foreach($result as $r)
            {
                $resarr[]=$r;
            }
        }else{
            foreach($arr as $ar)
            {
                $resarr[]=$ar;
            }
        }
        $id=array_random($resarr,1)[0];
        // var_dump($resarr);
        // echo "\nNiz je: ";
        // var_dump(array_random($resarr));
        // die();

        DB::table('auths')->insert([
            'id'=>"$id",
            'username'=>str_random(10),
            'password'=>$password,
            'picture'=>str_random(10),
            'email'=>str_random(10)
        ]);
         
    }
}
