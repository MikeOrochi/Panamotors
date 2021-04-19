<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisionReparacionTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_reparacion_trucks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idsolicitud_taller_trucks',20);
            $table->integer('desempeño');
            $table->integer('avance');
            $table->text('observaciones');
            $table->string('status',30);
            $table->string('usuario_creador');
            $table->dateTime('fecha_creacion');
            $table->dateTime('fecha_guardado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revision_reparacion_trucks');
    }
}
