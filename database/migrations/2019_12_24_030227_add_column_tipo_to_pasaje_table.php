<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTipoToPasajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasaje', function (Blueprint $table) {
            $table->string('tipo_pasaje')->nullable()->after('id');
            $table->string('ticket_anterior')->nullable()->after('pasajero');
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
            $table->dropColumn(['tipo_pasaje','ticket_anterior']);
        });
    }
}
