<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('workers', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigIncrements('id');
            $table->char('first_name',30);
            $table->char('last_name',30);
            $table->bigInteger('id_manager')->unsigned()->nullable();
            $table->enum('account_type',[
                'admin',
                'manager',
                'worker'
            ]);

            // $table->foreign('id_manager')->references('id')->on('workers');
        });
        Schema::enableForeignKeyConstraints();
        Schema::table('workers',function($table)
        {
            $table->foreign('id_manager')->references('id')->on('workers');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workers');
    }
}
