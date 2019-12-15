<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPasajeTable extends Migration
{
    public function up()
    {
        Schema::table('pasaje', function (Blueprint $table) {
            $table->decimal('deuda_soles',18,2)->nullable()->after('deuda_monto');
            $table->decimal('deuda_dolares',18,2)->nullable()->after('deuda_soles');
            $table->decimal('deuda_visa',18,2)->nullable()->after('deuda_dolares');
            $table->decimal('deuda_depo_soles',18,2)->nullable()->after('deuda_visa');
            $table->decimal('deuda_depo_dolares',18,2)->nullable()->after('deuda_depo_soles');

        });
    }

    public function down()
    {
        Schema::table('pasaje', function (Blueprint $table) {
            $table->dropColumn(['deuda_soles','deuda_dolares',
                                'deuda_visa','deuda_depo_soles',
                                'deuda_depo_dolares']);
        });
    }
}
