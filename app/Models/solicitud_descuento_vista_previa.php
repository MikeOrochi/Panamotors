<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class solicitud_descuento_vista_previa  extends Model
{

  protected $table = 'solicitud_descuento_vista_previa';
  protected $primaryKey = 'id_solicitud_descuento_vista_previa';
  public $timestamps = false;

  protected $fillable = [
    'id_solicitud_descuento_vista_previa', 'id_inventario','tipo_unidad','vin','precio','descuento',
    'precioFinal','status','usuario_creador','usuario_creador_admin'
    ,'fecha_creacion','fecha_guardado'
  ];


  public static function createSolicitudVistaPrevia($id_inventario,$tipo_unidad,$vin,$precio,$descuento,$precioFinal,$status,$usuario_creador,$usuario_creador_admin,$fecha_creacion,$fecha_guardado){
    return solicitud_descuento_vista_previa::create([
      'id_inventario' => $id_inventario,
      'tipo_unidad' => $tipo_unidad,
      'vin' => $vin,
      'precio' => $precio,
      'descuento' => $descuento,
      'precioFinal' => $precioFinal,
      'status' => $status,
      'usuario_creador' => $usuario_creador,
      'usuario_creador_admin' => $usuario_creador_admin,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado
    ]);
  }
}
