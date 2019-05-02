<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Faker\Provider\zh_TW\DateTime;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->storage='InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->timestamp('send_date')->default(DB::raw('CURRENT_TIMESTAMP(0)'));
            $table->enum('type',[
                'trip',
                'day_off',
                'allowance',
                'overwork',
                'refund'
            ]);
            $table->enum('decision',[
                'null',     //Nije odluceno
                '0',        //Odbijeno
                '1',        //Odobreno
            ]);
            $table->timestamp('decision_date')->nullable();
            $table->bigInteger('thirdPerson')->nullable();
            $table->bigInteger('worker_id')->unsigned();
            $table->text('description');
        });
        Schema::table('requests',function($table){
            $table->foreign('worker_id')->references('id')->on('workers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
