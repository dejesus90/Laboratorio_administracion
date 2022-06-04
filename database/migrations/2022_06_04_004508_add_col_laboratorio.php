<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColLaboratorio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('laboratorio', function (Blueprint $table) {
            $table->text('logotipo')->nullable()->after('activo');
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
        Schema::table('laboratorio', function (Blueprint $table) {
            //
            $table->dropColumn('logotipo');
        });
    }
}
