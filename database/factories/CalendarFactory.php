<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;
use App\Calendar;

$factory->define(App\Calendar::class, function (Faker $faker) {
    // $date=$faker->dateTime;
    $dates=DB::table('calendars')->pluck('days');
    
    if(isset($dates))
    {
        do{
            $date=$faker->date;
            foreach($dates as $singleDate)
            {
                $dat1=explode(' ',$singleDate);
                $dat2=explode(' ',$date);
               if($dat1===$dat2)
               {
                   $exists=false;
               }else{
                   $exists=true;
               }
            }
        }while($exists=false);
    }else{
        $date=$faker->dateTime;
    }
    $days=['radni','neradni'];
    $dayind=array_random($days);
    return [
        'days'=>$date,
        'type'=>$dayind,
        'description'=>$faker->sentence
    ];
});
