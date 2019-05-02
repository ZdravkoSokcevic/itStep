<?php

use Illuminate\Database\Seeder;

class ArrivalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Arrival::class,200)->create();
    }
}
