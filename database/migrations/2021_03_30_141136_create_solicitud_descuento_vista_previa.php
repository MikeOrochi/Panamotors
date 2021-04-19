<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudDescuentoVistaPrevia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_descuento_vista_previa', function (Blueprint $table) {
            $table->bigIncrements('id_solicitud_descuento_vista_previa');
            $table->unsignedBigInteger('id_inventario');
            $table->string('tipo_unidad');
            $table->string('vin',20);
            $table->double('precio');
            $table->double('descuento');
            $table->double('precioFinal');
            $table->string('status',30);
            $table->string('usuario_creador');
            $table->string('usuario_creador_admin')->nullable();;
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
        Schema::dropIfExists('solicitud_descuento_vista_previa');
    }
}
