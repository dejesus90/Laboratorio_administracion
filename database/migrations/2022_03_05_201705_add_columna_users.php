<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnaUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->integer('rol_id')->after('remember_token');
            // $table->integer('tipousuario_id');
            $table->integer('usuarioinfo_id')->after('remember_token');
            $table->integer('activo')->default(0)->after('remember_token');
            // $table->softDeletes();
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
        Schema::table('users', function(Blueprint $table){
            $table->dropColumn('rol_id');
            $table->dropColumn('usuarioinfo_id');
            $table->dropColumn('activo');
        });
    }
}
