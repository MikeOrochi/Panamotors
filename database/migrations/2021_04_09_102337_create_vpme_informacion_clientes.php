<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVpmeInformacionClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpme_informacion_clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_vista_previa_movimiento_exitoso');
            $table->string('pais_nacimiento');
            $table->string('pais_nacionalidad');
            $table->date('fecha_nacimiento');
            $table->string('ocupacion');
            $table->string('curp');
            $table->string('rfc');
            $table->string('facturacion',2);
            $table->string('identificacion');
            $table->string('folio_identificacion');
            $table->string('telefono');
            $table->string('correo');
            $table->string('beneficiario');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE vpme_informacion_clientes AUTO_INCREMENT = 8000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vpme_informacion_clientes');
    }
}
