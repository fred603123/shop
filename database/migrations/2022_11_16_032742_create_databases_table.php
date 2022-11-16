<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->string('u_account', 15)->primary();
            $table->string('u_name', 10);
            $table->string('u_password', 100);
            $table->timestamps();
        });

        Schema::create('commodity', function (Blueprint $table) {
            $table->increments('c_id');
            $table->string('c_name', 50);
            $table->integer('c_price');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('o_id');
            $table->string('u_account', 15);
            $table->foreign('u_account')->references('u_account')->on('user')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('c_id');
            $table->foreign('c_id')->references('c_id')->on('commodity')->onDelete('cascade')->onUpdate('cascade');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
