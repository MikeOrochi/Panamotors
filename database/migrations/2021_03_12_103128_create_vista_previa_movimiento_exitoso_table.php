<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVistaPreviaMovimientoExitosoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vista_previa_movimiento_exitoso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('idinventario');
            $table->string('vin_numero_serie');
            $table->string('numero_motor');
            $table->string('tipo_unidad');
            $table->string('estatus');
            $table->bigInteger('usuario_creador');
            $table->string('tipo_venta');
            $table->string('descuento');
            $table->string('area');
            $table->bigInteger('idcontacto');
            $table->string('estatus_orden');
            $table->string('tipo_moneda');
            $table->string('tipo_cambio');
            $table->double('monto_unidad');
            $table->double('saldo');
            $table->double('anticipo');
            $table->string('metodo_pago_anticipo');
            $table->string('tipo_comprobante_anticipo');
            $table->string('referencia_anticipo');
            $table->string('archivo_anticipo');
            $table->string('comentarios_anticipo');
            $table->string('institucion_emisora');
            $table->string('agente_emisor');
            $table->string('institucion_receptora');
            $table->string('agente_receptor');
            $table->string('referencia_venta');
            $table->string('tipo_comprobante_venta');
            $table->string('archivo_comprobante_venta');
            $table->string('comentarios_venta');
            $table->string('procedencia');
            $table->string('carta_autorizacion');
            $table->dateTime('fecha_guardado');
            $table->string('visible');
            $table->timestamps();

        });
         DB::statement("ALTER TABLE vista_previa_movimiento_exitoso AUTO_INCREMENT = 11000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vista_previa_movimiento_exitoso');
    }
}
