<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLaboratorio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono',30)->nullable();
            $table->string('rut',40)->nullable();
            $table->string('comercio',100)->nullable();
            $table->integer('pais_id');
            $table->integer('estado_id');
            $table->string('zipcode',40)->nullable();
            $table->string('file_rut',100)->nullable();
            $table->string('file_comercio',100)->nullable();
            $table->integer('activo')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laboratorio');
    }
}
