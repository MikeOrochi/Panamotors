<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpmeClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpme_clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_vista_previa_movimiento_exitoso');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('telefono');
            $table->string('estado');
            $table->string('municipio');
            $table->string('cp');
            $table->string('colonia');
            $table->string('direccion');

            $table->timestamps();


            // $table->foreign('id_vista_previa_movimiento_exitoso')->references('id')->on('vista_previa_movimiento_exitoso');
        });
        DB::statement("ALTER TABLE vpme_clientes AUTO_INCREMENT = 8000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vpme_clientes');
    }
}
