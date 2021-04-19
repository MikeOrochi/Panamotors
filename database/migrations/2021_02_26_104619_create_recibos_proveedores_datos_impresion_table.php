<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecibosProveedoresDatosImpresionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos_proveedores_datos_impresion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('id_recibos_proveedores');
            $table->text('qrcode_url');
            $table->string('id_generic_voucher',120);
            $table->string('nombre_usuario_recepcionista',120);
            $table->string('estatus',50);
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
        Schema::dropIfExists('recibos_proveedores_datos_impresion');
    }
}
