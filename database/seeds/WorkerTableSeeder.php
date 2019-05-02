<?php

use Illuminate\Database\Seeder;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusTableController;
use Illuminate\Support\Facades\Hash;

class WorkerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i=0;
        for($i=0;$i<150;$i++)
        {
            if(!count(App\worker::all()))
            {
                $manager=null;
            }else{
                $manager=App\worker::all()->random()->id;
            }
            $faker=Faker\Factory::create();
            $array=['admin','manager','worker'];
            $index=array_rand($array);
            DB::table('workers')->insert([
                'first_name'=>$faker->firstName,
                'last_name'=>$faker->lastName,
                'id_manager'=>$manager,
                'type'=>$array[$index]
            ]);
            $id=0;
            if(DB::getPdo()->lastInsertId())
            {
                $id=DB::getPdo()->lastInsertId();
            }
            $password=Hash::make($faker->password);
            DB::table('auths')->insert([
                'id'=>$id,
                'username'=>$faker->userName,
                'password'=>$password,
                'picture'=>str_random(20),
                'email'=>$faker->email
            ]);
            DB::table('statuses')->insert([
                'id'=>$id,
                'available_days'=>rand(0,100),
                'overwork'=>rand(0,200),
                'holiday_available'=>rand(0,10)
            ]);
        }

        // request for auth table

    }
}
