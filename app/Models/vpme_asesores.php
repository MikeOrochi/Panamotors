<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vpme_asesores extends Model
{
  protected $table = 'vpme_asesores';
  // public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
      'id_vista_previa_movimiento_exitoso','id_empleados','tipo','nomenclatura'
  ];

  public static function createVPMEAsesores(
     $id_vista_previa_movimiento_exitoso,$id_empleados,$tipo,$nomenclatura
  ){
    return vpme_asesores::create([
        'id_vista_previa_movimiento_exitoso'=>$id_vista_previa_movimiento_exitoso,
        'id_empleados'=>$id_empleados,
        'tipo'=>$tipo,
        'nomenclatura'=>$nomenclatura,
    ]);
  }
}
