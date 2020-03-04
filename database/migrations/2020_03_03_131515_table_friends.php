<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableFriends extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('user1_id')->unsigned();
            $table->foreign('user1_id')->references('id')->on('users');
            $table->biginteger('user2_id')->unsigned();
            $table->foreign('user2_id')->references('id')->on('users');

      $table->boolean('request');
      $table->boolean('add');
      $table->boolean('block');
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
        Schema::dropIfExists('friends');
    }
}
