<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overworks', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('request_id')->unsigned();
            $table->integer('number_hours');
            $table->string('description',255);
        });
        Schema::table('overworks',function($table){
            $table->foreign('request_id')->references('id')->on('requests')
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
        Schema::dropIfExists('overworks');
    }
}
