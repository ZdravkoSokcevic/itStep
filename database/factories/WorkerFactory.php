<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */
namespace App\WorkerFactory;
use App\Model;
use Faker\Generator as Faker;
use App\worker;

$factory->define(worker::class, function (Faker $faker) {
    return [
        'first_name'=>$faker->firstName,
        'last_name'=>$faker->lastName,
        'id_manager'=>App\worker::all()->random()->id,
        'type'=>array_rand([
            'admin',
            'manager',
            'worker'
        ]),
    ];
});
