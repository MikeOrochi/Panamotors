<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiberarSolicitudTallerTrucksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liberar_solicitud_taller_trucks', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('idsolicitud_taller_trucks',20);
          $table->text('descripcion')->nullable();
          $table->integer('porcentaje_estetica')->nullable();
          $table->text('descripcion_estetica')->nullable();
          $table->text('descripcion_extra')->nullable();
          $table->integer('combustible')->nullable();
          $table->text('comentarios')->nullable();
          $table->dateTime('fecha_salida');
          $table->string('status',30)->nullable();
          $table->dateTime('usuario_creador');
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
        Schema::dropIfExists('liberar_solicitud_taller_trucks');
    }
}
