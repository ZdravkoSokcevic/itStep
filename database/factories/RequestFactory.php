<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Request::class, function (Faker $faker) {
    $typeArr=['trip','overwork','refund','day_off','allowance'];
    $decisionArr=['0','1','NULL'];

    $decision_date=NULL;
    $decision=array_rand($decisionArr,1);
    $type=array_rand($typeArr,1);

    if($decision!==2)
    {
        $decision_date=$faker->dateTime;
    }

    // var_dump($faker->date('Y-m-d H:i:s'));
    // die();
    return [
        'type'=>$typeArr[$type],
        'description'=>$faker->sentence,
        'decision'=>$decisionArr[$decision],
        'send_date'=>$faker->date('Y-m-d H:i:s'),
        'decision_date'=>$decision_date,
        'thirdPerson'=>App\worker::all()->random()->id,
        'worker_id'=>App\worker::all()->random()->id
    ];
});
