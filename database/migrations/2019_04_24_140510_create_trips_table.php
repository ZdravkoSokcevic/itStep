<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Request;
use App\worker;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('request_id')->unsigned();
            $table->bigInteger('worker_id')->unsigned();
            $table->dateTime('go_time')->nullable();
            $table->dateTime('back_time')->nullable();
            $table->string('country',100);
            $table->string('town',100);
        });
        Schema::table('trips',function($table){
            $table->foreign('request_id')->references('id')->on('requests')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('workers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
