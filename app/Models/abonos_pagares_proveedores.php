<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class abonos_pagares_proveedores extends Model
{
  protected $table = 'abonos_pagares_proveedores';
  public $timestamps = false;
  protected $primaryKey = 'idabonos_pagares_proveedores';

  protected $fillable = [
'idabonos_pagares_proveedores', 'cantidad_inicial', 'cantidad_pago', 'cantidad_pendiente', 'serie_monto', 'monto_total', 'emisora_institucion', 'emisora_agente', 'receptora_institucion', 'receptora_agente', 'tipo_comprobante', 'referencia', 'metodo_pago', 'fecha_pago', 'archivo', 'comentarios', 'iddocumentos_pagar', 'usuario_guardo', 'fecha_creacion', 'fecha_guardado', 'visible', 'idestado_cuenta_movimiento', 'tipo_moneda', 'tipo_cambio', 'gran_total'
  ];

  public static function createAbonoPagaresProveedores($cantidad_inicial,$cantidad_pago,$cantidad_pendiente,$serie_monto,$monto_total,$emisora_institucion,$emisora_agente,$receptora_institucion,$receptora_agente,$tipo_comprobante,$referencia,$metodo_pago,$fecha_pago,$archivo,$comentarios,$iddocumentos_pagar,$usuario_guardo,$fecha_creacion,$fecha_guardado,$visible,$idestado_cuenta_movimiento,$tipo_moneda,$tipo_cambio,$gran_total){
    return abonos_pagares_proveedores::create([
      'cantidad_inicial' => $cantidad_inicial,
      'cantidad_pago' => $cantidad_pago,
      'cantidad_pendiente' => $cantidad_pendiente,
      'serie_monto' => $serie_monto,
      'monto_total' => $monto_total,
      'emisora_institucion' => $emisora_institucion,
      'emisora_agente' => $emisora_agente,
      'receptora_institucion' => $receptora_institucion,
      'receptora_agente' => $receptora_agente,
      'tipo_comprobante' => $tipo_comprobante,
      'referencia' => $referencia,
      'metodo_pago' => $metodo_pago,
      'fecha_pago' => $fecha_pago,
      'archivo' => $archivo,
      'comentarios' => $comentarios,
      'iddocumentos_pagar' => $iddocumentos_pagar,
      'usuario_guardo' => $usuario_guardo,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'visible' => $visible,
      'idestado_cuenta_movimiento' => $idestado_cuenta_movimiento,
      'tipo_moneda' => $tipo_moneda,
      'tipo_cambio' => $tipo_cambio,
      'gran_total' => $gran_total,

    ]);
  }
}
