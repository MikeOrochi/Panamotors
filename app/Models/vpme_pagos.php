<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vpme_pagos extends Model
{
  protected $table = 'vpme_pagos';
  // public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
      'id_vista_previa_movimiento_exitoso', 'monto', 'cantidad_pendiente', 'metodo_pago', 'tipo_comprobante', 'estatus',
       'archivo_comprobante', 'fecha_pago', 'comentarios','visible'
  ];

  public static function createVPMEPagos(
      $id_vista_previa_movimiento_exitoso, $monto, $cantidad_pendiente, $metodo_pago, $tipo_comprobante, $estatus,
      $archivo_comprobante, $fecha_pago, $comentarios, $visible
  ){
    return vpme_pagos::create([
        'id_vista_previa_movimiento_exitoso'=>$id_vista_previa_movimiento_exitoso,
        'monto'=>$monto,
        'cantidad_pendiente'=>$cantidad_pendiente,
        'metodo_pago'=>$metodo_pago,
        'tipo_comprobante'=>$tipo_comprobante,
        'estatus'=>$estatus,
        'archivo_comprobante'=>$archivo_comprobante,
        'fecha_pago'=>$fecha_pago,
        'comentarios'=>$comentarios,
        'visible'=>$visible
    ]);
  }
}
