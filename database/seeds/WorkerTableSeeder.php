<?php

use Illuminate\Database\Seeder;

class WorkerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workers')->insert([
            'first_name'=>str_random(10),
            'last_name'=>str_random(10),
            'id_manager'=>null,
            'type'=>'manager'
        ]);
    }
}
