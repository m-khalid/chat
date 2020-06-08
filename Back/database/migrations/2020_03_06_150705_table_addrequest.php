<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableAddrequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addrequests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('sender')->unsigned();
            $table->foreign('sender')->references('id')->on('users');
            $table->biginteger('reciever')->unsigned();
            $table->foreign('reciever')->references('id')->on('users');
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
        Schema::dropIfExists('addrequests');
    }
}
