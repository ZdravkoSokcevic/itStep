<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Trip::class, function (Faker $faker) {
    return [
        'go_time'=>$faker->dateTime,
        'back_time'=>$faker->dateTime,
        'country'=>$faker->country,
        'town'=>$faker->city
    ];
});
