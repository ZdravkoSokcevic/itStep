<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use App\Request;

$factory->define(App\Refund::class,function (Faker $faker) {

    return [
        'attachment'=>$faker->sentence,
        'reason'=>'putovanje',
        'quantity'=>rand(0,1000)
    ];
});
