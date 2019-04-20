<?php

use Illuminate\Database\Seeder;
use App\worker;
use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
            $resarr=array_intersect($arr,$arrr);
        }else{
            foreach($arr as $ar)
            {
                $resarr[]=$ar;
            }
        }
        $id=array_rand($resarr,1);
        $idS=$workers->where('id',$id);
        
        var_dump($idS[0]->id);
        die();

        DB::table('statusues')->insert([
            'id'=>$worker->where('id',$id)->id,
            'available_days'=>rand(0,100),
            'overwork'=>rand(0,200),
            'holiday_available'=>rand(0,10)
        ]);
    }
}
