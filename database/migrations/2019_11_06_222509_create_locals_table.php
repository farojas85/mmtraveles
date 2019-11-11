<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('empresa_id')->index();
            $table->foreign('empresa_id')->references('id')->on('empresas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->Integer('lugar_id')->index();
            $table->foreign('lugar_id')->references('id')->on('category')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('estado')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locals');
    }
}
