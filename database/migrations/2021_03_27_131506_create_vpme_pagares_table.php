<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpmePagaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpme_pagares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_vista_previa_movimiento_exitoso');
            $table->string('num_pagare');
            $table->double('monto');
            $table->dateTime('fecha_vencimiento');
            $table->string('estatus');
            $table->string('tipo');
            $table->string('archivo_original');
            $table->text('comentarios');
            $table->dateTime('fecha_guardado');
            $table->string('visible');
            $table->timestamps();

            // $table->foreign('id_vista_previa_movimiento_exitoso')->references('id')->on('vista_previa_movimiento_exitoso');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vpme_pagares');
    }
}
