<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class at_oc extends Model
{
  protected $table = 'at_oc';
  public $timestamps = false;
  protected $primaryKey = 'idat_oc';

  protected $fillable = [
      'idatencion_clientes','idorden_compra_unidades','visible','usuario_creador','fecha_creacion','fecha_guardado','tipo'
  ];

  public static function createAtOc($idatencion_clientes,$idorden_compra_unidades,$visible,$usuario_creador,$fecha_creacion,$fecha_guardado,$tipo){
    return at_oc::create([
      'idatencion_clientes'=>$idatencion_clientes,
      'idorden_compra_unidades'=>$idorden_compra_unidades,
      'visible'=>$visible,
      'usuario_creador'=>$usuario_creador,
      'fecha_creacion'=>$fecha_creacion,
      'fecha_guardado'=>$fecha_guardado,
      'tipo'=>$tipo

    ]);
  }
}
