<?php

use Illuminate\Database\Seeder;

class CalendarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Ne radimo ovdje seeder zato sto treba da se 
        //preko arrival upise zapis ovdje
        
        factory(App\Calendar::class,10)->create();
    }
}
