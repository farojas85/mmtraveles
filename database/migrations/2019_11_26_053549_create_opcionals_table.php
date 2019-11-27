<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->string('pasajero');
            $table->unsignedBigInteger('tipo_documento_id')->nullable();
            $table->string('numero_documento',20);
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos');
            $table->decimal('sub_total',18,2);
            $table->decimal('igv',18,2);
            $table->decimal('total',18,2);
            $table->decimal('monto_pagar',18,2);
            $table->string('moneda',10);
            $table->decimal('cambio',10,2);
            $table->decimal('pago_dolares',18,2)->default(0);
            $table->decimal('pago_soles',18,2)->default(0);
            $table->decimal('deposito_soles',18,2)->default(0);
            $table->decimal('deposito_dolares',18,2)->default(0);
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
        Schema::dropIfExists('opcionals');
    }
}
