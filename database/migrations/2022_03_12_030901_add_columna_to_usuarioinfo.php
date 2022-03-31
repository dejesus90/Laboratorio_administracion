<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnaToUsuarioinfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('usuario_info', function (Blueprint $table) {
            $table->integer('laboratorio__id')->after('tipousuario_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usuario_info', function (Blueprint $table) {
            //
            $table->dropColumn('laboratorio__id');
        });
    }
}
