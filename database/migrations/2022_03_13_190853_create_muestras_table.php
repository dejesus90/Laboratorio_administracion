<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMuestrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muestras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_muestra', 60)->nullable();
            $table->integer('examen_id')->default(0);
            $table->integer('paciente_id')->default(0);
            $table->integer('laboratorio_id')->default(0);
            $table->integer('usuario_id')->default(0);
            $table->string('archivo_adjunto')->nullable();
            $table->date('fecha_registro')->nullable();
            $table->integer('estado_id')->default(1);
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
        Schema::dropIfExists('muestras');
    }
}
