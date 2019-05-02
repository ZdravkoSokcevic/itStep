<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\worker;
use App\Calendar;

$factory->define(App\Arrival::class, function (Faker $faker) {
    if(!count(worker::all()))
    {
        $worker=null;
    }else{
        $worker=worker::all()->random()->id;
    }
    if(!count(Calendar::all()))
    {
        $calendar=factory(App\Calendar::class)->create()->get('id');
    }else{
        $calendar=Calendar::all()->random()->id;
    }
    $workarr=['work','not_work'];
    $work=array_rand($workarr);
    return [
        'worker_id'=>$worker,
        'calendar_id'=>$calendar,
        'arrival'=>$faker->dateTime,
        'start_work'=>$faker->dateTime,
        'end_work'=>$faker->dateTime,
        'leave'=>$faker->dateTime,
        'work'=>$workarr[$work],
        'description'=>$faker->sentence
    ];
});
