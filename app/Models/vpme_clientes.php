<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vpme_clientes extends Model
{
  protected $table = 'vpme_clientes';
  // public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
      'id_vista_previa_movimiento_exitoso', 'nombre', 'apellidos', 'telefono', 'estado', 'municipio', 'cp','colonia','direccion'
  ];

  public static function createVPMEClientes( $id_vista_previa_movimiento_exitoso, $nombre, $apellidos, $telefono, $estado, $municipio, $cp, $colonia, $direccion ){
    return vpme_clientes::create([
        'id_vista_previa_movimiento_exitoso'=>$id_vista_previa_movimiento_exitoso,
        'nombre'=>$nombre,
        'apellidos'=>$apellidos,
        'telefono'=>$telefono,
        'estado'=>$estado,
        'municipio'=>$municipio,
        'cp'=>$cp,
        'colonia'=>$colonia,
        'direccion'=>$direccion,

    ]);
  }
}
