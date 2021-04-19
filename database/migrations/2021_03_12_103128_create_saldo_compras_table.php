<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldoComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldo_compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('idestado_cuenta_proveedores')->unsigned();
            $table->unsignedInteger('idproveedores')->unsigned();
            $table->string('concepto',50);
            $table->double('cantidad');
            $table->string('comentarios');
            $table->string('visible',2)->default('SI');
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
        Schema::dropIfExists('saldo_compras');
    }
}
