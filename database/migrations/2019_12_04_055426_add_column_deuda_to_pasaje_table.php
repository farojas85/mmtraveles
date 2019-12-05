<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDeudaToPasajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasaje', function (Blueprint $table) {
            $table->string('deuda_detalle');
            $table->decimal('deuda_monto',18,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasaje', function (Blueprint $table) {
            $table->dropColumn(['deuda_monto','deuda_detalle']);
        });
    }
}
