<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpmeVentasPermutas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpme_ventas_permutas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_vista_previa_movimiento_exitoso');
            $table->string('vin_numero_serie_recibido');
            $table->double('valoracion_vin_recibido');
            $table->string('vin_numero_serie_cambio');
            $table->double('valoracion_vin_cambio');
            $table->string('estatus');
            $table->text('imagenes_vin_recibido');
            $table->date('fecha_guardado');
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
        Schema::dropIfExists('vpme_ventas_permutas');
    }
}
