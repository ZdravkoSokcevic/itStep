<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Allowance::class, function (Faker $faker) {
    return [
        'price'=>$faker->numberBetween(1,20000)
    ];
});
