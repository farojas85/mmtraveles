<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEmailPasajeroToPasajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasaje', function (Blueprint $table) {
            $table->string('telefono_pasajero',50)->nullable()->after('pasajero');
            $table->string('email_pasajero')->nullable()->after('telefono_pasajero');
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
            $table->dropColum(['telefono_pasajero','email_pasajero']);
        });
    }
}
