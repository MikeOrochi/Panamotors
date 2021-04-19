<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class auxiliares extends Model
{
  protected $table = 'auxiliares';
  public $timestamps = false;
  protected $primaryKey = 'idauxiliriares';

  protected $fillable = [
      'nombre','nomenclatura', 'direccion','idauxiliar_principales','idfoliogo','idestado_cuenta_requisicion',
      'visible','usuario_creador','fecha_creacion','fecha_guardado','fecha_movimiento_estado_cuenta_requisicion','col1',
      'col2','col3'
  ];


  public static function createAuxiliares($nombre,$nomenclatura,$direccion,$idauxiliar_principales,$idfoliogo,
  $idestado_cuenta_requisicion,$visible,$usuario_creador,$fecha_creacion,$fecha_guardado,
  $fecha_movimiento_estado_cuenta_requisicion,$col1,$col2,$col3){
    return auxiliares::create([
      'nombre' => $nombre,
      'nomenclatura' => $nomenclatura,
      'direccion' => $direccion,
      'idauxiliar_principales' => $idauxiliar_principales,
      'idfoliogo' => $idfoliogo,
      'idestado_cuenta_requisicion' => $idestado_cuenta_requisicion,
      'visible' => $visible,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'fecha_movimiento_estado_cuenta_requisicion' => $fecha_movimiento_estado_cuenta_requisicion,
      'col1' => $col1,
      'col2' => $col2,
      'col2' => $col3,
    ]);
  }
}
