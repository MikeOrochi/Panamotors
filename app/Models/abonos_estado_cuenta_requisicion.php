<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class abonos_estado_cuenta_requisicion extends Model
{
  protected $table = 'abonos_estado_cuenta_requisicion';
  public $timestamps = false;
  protected $primaryKey = 'idabonos_estado_cuenta_requisicion';

  protected $fillable = [
    'idabonos_estado_cuenta_requisicion', 'concepto', 'cantidad_inicial', 'cantidad_pago', 'cantidad_pendiente', 'serie_monto', 'monto_total', 'emisora_institucion', 'emisora_agente', 'receptora_institucion', 'receptora_agente', 'tipo_comprobante', 'referencia', 'metodo_pago', 'fecha_pago', 'datos_marca', 'datos_version', 'datos_color', 'datos_modelo', 'datos_precio', 'datos_vin', 'archivo', 'comentarios', 'idestado_cuenta_requisicion', 'idfoliogo', 'usuario_guardo', 'fecha_creacion', 'fecha_guardado', 'visible', 'idestado_cuenta_requisicion_movimineto', 'tipo_moneda', 'tipo_cambio', 'gran_total'
  ];

  public static function createAbonoUnidadesRequisicion($concepto, $cantidad_inicial, $cantidad_pago, $cantidad_pendiente, $serie_monto, $monto_total, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $metodo_pago, $fecha_pago, $datos_marca, $datos_version, $datos_color, $datos_modelo, $datos_precio, $datos_vin, $archivo, $comentarios, $idestado_cuenta_requisicion, $idfoliogo, $usuario_guardo, $fecha_creacion, $fecha_guardado, $visible, $idestado_cuenta_requisicion_movimineto, $tipo_moneda, $tipo_cambio, $gran_total){
    return abonos_estado_cuenta_requisicion::create([
      'concepto' => $concepto,
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
      'datos_marca' => $datos_marca,
      'datos_version' => $datos_version,
      'datos_color' => $datos_color,
      'datos_modelo' => $datos_modelo,
      'datos_precio' => $datos_precio,
      'datos_vin' => $datos_vin,
      'archivo' => $archivo,
      'comentarios' => $comentarios,
      'idestado_cuenta_requisicion' => $idestado_cuenta_requisicion,
      'idfoliogo' => $idfoliogo,
      'usuario_guardo' => $usuario_guardo,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'visible' => $visible,
      'idestado_cuenta_requisicion_movimineto' => $idestado_cuenta_requisicion_movimineto,
      'tipo_moneda' => $tipo_moneda,
      'tipo_cambio' => $tipo_cambio,
      'gran_total' => $gran_total

    ]);
  }


}
