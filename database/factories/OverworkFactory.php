<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\overwork::class, function (Faker $faker) {
    return [
        //
        'number_hours'=>rand(1,50),
        'description'=>$faker->sentence
    ];
});
