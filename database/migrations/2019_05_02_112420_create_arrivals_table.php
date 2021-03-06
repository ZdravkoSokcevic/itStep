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
            $table->dateTime('arrival')->nullable();
            $table->dateTime('start_work')->nullable();
            $table->dateTime('end_work')->nullable();
            $table->dateTime('leave')->nullable();
            $table->enum('work',[
                'work',
                'not_work'
            ]);
            $table->string('description')->nullable();
        });
        Schema::table('arrivals',function($table){
            $table->foreign('worker_id')->references('id')->on('workers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('calendar_id')->references('id')->on('calendars')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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