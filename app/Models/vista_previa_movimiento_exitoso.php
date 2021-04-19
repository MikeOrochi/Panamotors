<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vista_previa_movimiento_exitoso extends Model
{
  protected $table = 'vista_previa_movimiento_exitoso';
  // public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
      'idinventario', 'vin_numero_serie','numero_motor' ,'tipo_unidad', 'estatus', 'usuario_creador', 'tipo_venta', 'descuento', 'area', 'idcontacto', 'estatus_orden',
      'tipo_moneda', 'tipo_cambio', 'monto_unidad', 'saldo', 'anticipo', 'metodo_pago_anticipo', 'tipo_comprobante_anticipo', 'referencia_anticipo',
      'archivo_anticipo', 'comentarios_anticipo', 'institucion_emisora', 'agente_emisor', 'institucion_receptora', 'agente_receptor', 'referencia_venta',
      'tipo_comprobante_venta', 'archivo_comprobante_venta', 'comentarios_venta', 'procedencia', 'carta_autorizacion', 'fecha_guardado','visible'
  ];

  public static function createVistaPreviaMovimientoExitoso(
      $idinventario, $vin_numero_serie, $numero_motor,$tipo_unidad, $estatus, $usuario_creador, $tipo_venta, $descuento, $area, $idcontacto, $estatus_orden,
      $tipo_moneda, $tipo_cambio, $monto_unidad, $saldo, $anticipo, $metodo_pago_anticipo, $tipo_comprobante_anticipo, $referencia_anticipo,
      $archivo_anticipo, $comentarios_anticipo, $institucion_emisora, $agente_emisor, $institucion_receptora, $agente_receptor, $referencia_venta,
      $tipo_comprobante_venta, $archivo_comprobante_venta, $comentarios_venta, $procedencia, $carta_autorizacion, $fecha_guardado, $visible
  ){
    return vista_previa_movimiento_exitoso::create([
        'idinventario'=>$idinventario,
        'vin_numero_serie'=>$vin_numero_serie,
        'numero_motor'=>$numero_motor,
        'tipo_unidad'=>$tipo_unidad,
        'estatus'=>$estatus,
        'usuario_creador'=>$usuario_creador,
        'tipo_venta'=>$tipo_venta,
        'descuento'=>$descuento,
        'area'=>$area,
        'idcontacto'=>$idcontacto,
        'estatus_orden'=>$estatus_orden,
        'tipo_moneda'=>$tipo_moneda,
        'tipo_cambio'=>$tipo_cambio,
        'monto_unidad'=>$monto_unidad,
        'saldo'=>$saldo,
        'anticipo'=>$anticipo,
        'metodo_pago_anticipo'=>$metodo_pago_anticipo,
        'tipo_comprobante_anticipo'=>$tipo_comprobante_anticipo,
        'referencia_anticipo'=>$referencia_anticipo,
        'archivo_anticipo'=>$archivo_anticipo,
        'comentarios_anticipo'=>$comentarios_anticipo,
        'institucion_emisora'=>$institucion_emisora,
        'agente_emisor'=>$agente_emisor,
        'institucion_receptora'=>$institucion_receptora,
        'agente_receptor'=>$agente_receptor,
        'referencia_venta'=>$referencia_venta,
        'tipo_comprobante_venta'=>$tipo_comprobante_venta,
        'archivo_comprobante_venta'=>$archivo_comprobante_venta,
        'comentarios_venta'=>$comentarios_venta,
        'procedencia'=>$procedencia,
        'carta_autorizacion'=>$carta_autorizacion,
        'fecha_guardado'=>$fecha_guardado,
        'visible'=>$visible
    ]);
  }
}
