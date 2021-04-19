<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vpme_informacion_clientes extends Model
{
  protected $table = 'vpme_informacion_clientes';
  // public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
      'id_vista_previa_movimiento_exitoso', 'pais_nacimiento', 'pais_nacionalidad', 'fecha_nacimiento', 'ocupacion', 'curp', 'rfc', 'facturacion','identificacion',
      'folio_identificacion', 'telefono', 'correo', 'beneficiario'
  ];

  public static function createVPMEInformacionClientes(
      $id_vista_previa_movimiento_exitoso, $pais_nacimiento, $pais_nacionalidad, $fecha_nacimiento, $ocupacion, $curp, $rfc,$facturacion, $identificacion, $folio_identificacion,
      $telefono, $correo, $beneficiario
  ){
    return vpme_informacion_clientes::create([
            'id_vista_previa_movimiento_exitoso'=>$id_vista_previa_movimiento_exitoso,
            'pais_nacimiento'=>$pais_nacimiento,
            'pais_nacionalidad'=>$pais_nacionalidad,
            'fecha_nacimiento'=>$fecha_nacimiento,
            'ocupacion'=>$ocupacion,
            'curp'=>$curp,
            'rfc'=>$rfc,
            'facturacion'=>$facturacion,
            'identificacion'=>$identificacion,
            'folio_identificacion'=>$folio_identificacion,
            'telefono'=>$telefono,
            'correo'=>$correo,
            'beneficiario'=>$beneficiario,
    ]);
  }
}
