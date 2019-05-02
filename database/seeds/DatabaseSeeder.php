<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WorkerTableSeeder::class);
        // $this->call(AuthTableSeeder::class);
        // $this->call(StatusTableSeeder::class);
        $this->call(RequestTableSeeder::class);
        $this->call(CalendarTableSeeder::class);
        $this->call(ArrivalSeeder::class);
    }
}
