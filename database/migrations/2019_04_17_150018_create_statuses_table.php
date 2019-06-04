<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->storage='InnoDB';
            
            $table->bigInteger('id')->unsigned()->unique();
            $table->integer('available_days')->nullable();
            $table->integer('overwork')->nullable();
            $table->integer('holiday_available')->nullable();
        });
        Schema::table('statuses',function($table)
        {
            $table->foreign('id')->references('id')->on('workers')
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
        Schema::dropIfExists('statuses');
    }
}
