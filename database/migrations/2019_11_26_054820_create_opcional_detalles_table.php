<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionalDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcional_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('opcional_id')->nullable()->index();
            $table->foreign('opcional_id')->references('id')->on('opcionals')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('adicional_id')->nullable()->index();
            $table->foreign('adicional_id')->references('id')->on('adicionals')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->string('detalle_otro')->nullable();
            $table->decimal('monto',18,2);
            $table->decimal('service_fee',18,2);
            $table->decimal('importe',18,2);
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
        Schema::dropIfExists('opcional_detalles');
    }
}
