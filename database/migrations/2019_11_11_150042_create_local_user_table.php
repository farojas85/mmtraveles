<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('local_id');
            $table->foreign('local_id')->references('id')->on('locals');
            $table->Integer('user_id');
            $table->foreign('user_id')->references('id')->on('user');
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
        Schema::dropIfExists('local_user');
    }
}
