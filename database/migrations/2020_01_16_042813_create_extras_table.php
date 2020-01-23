<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('operacion_tipo_id');
            $table->unsignedBigInteger('pago_id')->nullable();
            $table->string('concepto');
            $table->decimal('gasto_soles',18,2)->nullable();
            $table->decimal('gasto_dolares',18,2)->nullable();
            $table->decimal('gasto_visa',18,2)->nullable();
            $table->date('fecha');
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('operacion_tipo_id')->references('id')->on('operation_type');
            $table->foreign('pago_id')->references('id')->on('pagos');
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extras');
    }
}
