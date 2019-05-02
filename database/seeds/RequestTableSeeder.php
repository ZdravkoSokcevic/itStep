<?php

use Illuminate\Database\Seeder;

class RequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<1000;$i++)
        {
            $obj=factory(App\Request::class,1)->create();
            // var_dump($obj->type);
            // die();
            $id=DB::getPdo()->lastInsertId();

            $request=new App\Request();
            $request=$request->find($id);
            // var_dump($insRequest);
            // die();
            switch($request->type)
            {
                case 'refund':
                {
                    factory(App\Refund::class,1)->create([
                        'request_id'=>$id,
                        'worker_id'=>$request->worker_id
                        ]);
                };break;
                case 'trip':
                {
                    factory(App\Trip::class,1)->create([
                        'request_id'=>$id,
                        'worker_id'=>$request->worker_id
                    ]);
                };break;
                case 'day_off':
                {
                    factory(App\DayOff::class,1)->create([
                        'request_id'=>$id
                    ]);
                };break;
                case 'overwork':
                {
                    factory(App\overwork::class,1)->create([
                        'request_id'=>$id
                    ]);
                };break;
                case 'allowance':
                {
                    factory(App\Allowance::class,1)->create([
                        'request_id'=>$id
                    ]);
                };break;
                default:break;
            }
            // var_dump($request);
            // die();
        }
    }
}
