<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoIdentificacionPacientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('pacientes', function (Blueprint $table) {
            $table->integer('tipo_identificacion')->default(1)->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('pacientes', function (Blueprint $table) {
            //
            $table->dropColumn('tipo_identificacion');
        });
    }
}
