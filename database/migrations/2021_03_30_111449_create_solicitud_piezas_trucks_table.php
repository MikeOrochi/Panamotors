<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudPiezasTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_piezas_trucks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idsolicitud_taller_trucks',20);
            $table->text('concepto')->nullable();
            $table->integer('no_piezas')->nullable();
            $table->double('precio')->nullable();
            $table->text('comentarios')->nullable();
            $table->string('status',30)->nullable();
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
        Schema::dropIfExists('solicitud_piezas_trucks');
    }
}
