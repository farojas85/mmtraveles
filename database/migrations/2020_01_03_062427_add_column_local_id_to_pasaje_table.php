<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnLocalIdToPasajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasaje', function (Blueprint $table) {
            $table->unsignedBigInteger('local_id')->nullable()->index();
            $table->foreign('local_id')->references('id')->on('locals');
            $table->unsignedBigInteger('etapa_persona_id')->nullable()->index();
            $table->foreign('etapa_persona_id')->references('id')->on('etapa_persona');
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
            $table->dropForeign(['pasaje_local_id_foreign','pasaje_etapa_persona_id_foreign']);
            $table->dropIndex(['pasaje_local_id_index','pasaje_etapa_persona_id_index']);
            $table->dropColumn(['local_id','etapa_persona_id']);
        });
    }
}
