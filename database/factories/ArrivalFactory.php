<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\worker;
use App\Calendar;
use Illuminate\Support\Facades\DB;
use App\Arrival;

$factory->define(App\Arrival::class, function (Faker $faker) {
    return [
        'arrival'=>$faker->dateTime,
        'start_work'=>$faker->dateTime,
        'end_work'=>$faker->dateTime,
        'leave'=>$faker->dateTime,
        'description'=>$faker->sentence
    ];
});
