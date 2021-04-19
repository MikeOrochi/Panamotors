<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostoImportacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costo_importacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('idestado_cuenta_proveedores')->unsigned();
            $table->unsignedInteger('idproveedores')->unsigned();
            $table->double('cantidad');
            $table->string('visible',2)->default('SI');
            $table->dateTime('fecha_creacion');
            $table->dateTime('fecha_guardado');
            // $table->foreign('idestado_cuenta_proveedores')->references('idestado_cuenta_proveedores')->on('estado_cuenta_proveedores')->onDelete('cascade');
            // $table->foreign('idproveedores')->references('idproveedores')->on('proveedores')->onDelete('cascade');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costo_importacion');
    }
}
