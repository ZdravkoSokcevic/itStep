<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auths', function (Blueprint $table) {
            $table->engine='InnoDB';
            $table->bigInteger('id')->unsigned()->unique();
            $table->char('username',50);
            $table->char('password');
            $table->char('picture');
            $table->char('email');
        });
        Schema::table('auths',function($table)
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
        Schema::dropIfExists('auths');
    }
}
