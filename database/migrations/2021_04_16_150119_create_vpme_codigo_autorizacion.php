<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpmeCodigoAutorizacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpme_codigo_autorizacion', function (Blueprint $table) {
            $table->bigIncrements('id_codigo_autorizacion');
            $table->unsignedBigInteger('id_vista_previa_movimiento_exitoso');
            $table->string('codigo',15);
            $table->string('comentarios');
            $table->string('evidencia');
            $table->string('visible',2);
            $table->integer('id_usuario_autorizo');
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
        Schema::dropIfExists('vpme_codigo_autorizacion');
    }
}
