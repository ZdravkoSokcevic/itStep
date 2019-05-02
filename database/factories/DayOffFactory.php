<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\DayOff;

$factory->define(DayOff::class, function (Faker $faker) {
    return [
        'numberDays'=>rand(1,7)
    ];
});
