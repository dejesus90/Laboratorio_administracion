<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre1', 60)->nullable();
            $table->string('nombre2', 60)->nullable();
            $table->string('apellidos', 60)->nullable();
            $table->string('cedula', 30)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('password', 30)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->integer('estado')->default(1);
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
        Schema::dropIfExists('pacientes');
    }
}
