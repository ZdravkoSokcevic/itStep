<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrivalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrivals', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('worker_id')->unsigned();
            $table->bigInteger('calendar_id')->unsigned();
            $table->dateTime('arrival');
            $table->dateTime('start_work');
            $table->dateTime('end_work');
            $table->dateTime('leave');
            $table->enum('work',[
                'work',
                'not_work'
            ]);
            $table->string('description');
        });
        Schema::table('arrivals',function($table){
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('calendar_id')->references('id')->on('calendars');
            $table->unique(['worker_id','calendar_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrivals');
    }
}
