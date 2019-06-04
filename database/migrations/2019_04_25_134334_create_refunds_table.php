<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_id')->unsigned();
            $table->bigInteger('worker_id')->unsigned();
            $table->string('attachment');
            $table->enum('reason',[
                'putovanje'
            ]);
            $table->bigInteger('quantity');
        });
        Schema::table('refunds',function($table){
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
        Schema::dropIfExists('refunds');
    }
}
