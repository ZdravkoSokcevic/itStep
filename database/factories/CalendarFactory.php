<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Calendar;

$factory->define(App\Calendar::class, function (Faker $faker) {
    // $date=$faker->dateTime;
    $dat=Calendar::all()->get('date');
    var_dump($dat);
    die();
    $dates[]=Calendar::all()->get('date')|null;
    do{
        $date=$faker->dateTime;
        $exists=in_array($date,$dates);
    }while($exists=false);
    var_dump($date);
    die();
    return [
        'date'=>$faker->date(),
        'type'=>$faker->in_array('radni','neradni'),
        'description'=>$faker->sentence
    ];
});
