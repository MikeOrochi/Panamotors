<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpmePagos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpme_pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_vista_previa_movimiento_exitoso');
            $table->double('monto');
            $table->double('cantidad_pendiente');
            $table->string('metodo_pago');
            $table->string('tipo_comprobante');
            $table->string('estatus');
            $table->text('archivo_comprobante');
            $table->date('fecha_pago');
            $table->string('visible');
            $table->text('comentarios');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vpme_pagos');
    }
}
