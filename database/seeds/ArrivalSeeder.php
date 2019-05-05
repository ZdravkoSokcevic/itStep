<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\worker;
use App\Calendar;
use Illuminate\Support\Facades\DB;
use App\Arrival;

class ArrivalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=new Faker();
        $workers=worker::all();
        $calendars=Calendar::all();
        $arrivals=Arrival::all();
        var_dump('usao');
        // var_dump($faker->firstName);
        // die();
        if(count($workers) && count($calendars) && !count($arrivals))
        {
            foreach($calendars as $calendar)
            {
                foreach($workers as $worker)
                {
                    $workarr=['work','not_work'];
                    $work=array_rand($workarr);
                    $data=factory(App\Arrival::class,1)->create([
                        'worker_id'=>$worker->id,
                        'calendar_id'=>$calendar->id,
                        'work'=>$workarr[$work],
                    ]);
                }
            }
        }
        // factory(App\Arrival::class,1)->make();
    }
}
