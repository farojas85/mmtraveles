<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPasajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasaje', function (Blueprint $table) {
           $table->unsignedBigInteger('tipo_documento_id')->nullable()->after('counter_id');
           $table->foreign('tipo_documento_id')->references('id')->on('tipo_documentos');
           $table->string('numero_documento',20)->nullable()->after('tipo_documento_id');
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
            $table->dropColumn('numero_documento');
            $table->dropForeign('pasaje_tipo_documento_id_foreign');
            $table->dropColumn('tipo_documento_id');
        });
    }
}
