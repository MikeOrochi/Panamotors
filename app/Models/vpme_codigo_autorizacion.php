<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vpme_codigo_autorizacion extends Model
{
  protected $table = 'vpme_codigo_autorizacion';
  // public $timestamps = false;
  protected $primaryKey = 'id_codigo_autorizacion';

  protected $fillable = [
      'id_codigo_autorizacion','id_vista_previa_movimiento_exitoso','codigo','comentarios',
      'evidencia','visible', 'id_usuario_autorizo','created_at','updated_at'
  ];

  public static function createCodigoAutorizacion(
      $id_vista_previa_movimiento_exitoso, $codigo,$comentarios,$evidencia,$visible,$id_usuario_autorizo
  ){
    return vpme_codigo_autorizacion::create([
        'id_vista_previa_movimiento_exitoso'=>$id_vista_previa_movimiento_exitoso,
        'codigo'=>$codigo,
        'comentarios'=>$comentarios,
        'evidencia'=>$evidencia,
        'visible'=>$visible,
        'id_usuario_autorizo'=>$id_usuario_autorizo
    ]);
  }
}
