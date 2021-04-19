<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\abonos_unidades;
class estado_cuenta extends Model
{
  protected $table = 'estado_cuenta';
  public $timestamps = false;
  protected $primaryKey = 'idestado_cuenta';

  protected $fillable = [
    'idestado_cuenta', 'concepto', 'apartado_usado', 'tipo_movimiento', 'efecto_movimiento', 'fecha_movimiento', 'metodo_pago', 'saldo_anterior', 'saldo', 'monto_precio', 'serie_monto', 'monto_total', 'tipo_moneda', 'tipo_cambio', 'gran_total', 'cargo', 'abono', 'emisora_institucion', 'emisora_agente', 'receptora_institucion', 'receptora_agente', 'tipo_comprobante', 'referencia', 'datos_marca', 'datos_version', 'datos_color', 'datos_modelo', 'datos_vin', 'datos_precio', 'datos_estatus', 'asesor1', 'enlace1', 'asesor2', 'enlace2', 'coach', 'archivo', 'comentarios', 'idcontacto', 'comision', 'visible', 'comentarios_eliminacion', 'usuario_elimino', 'fecha_eliminacion', 'usuario_creador', 'fecha_creacion', 'fecha_guardado'
  ];

  public static function createEstadoCuenta($concepto, $apartado_usado, $tipo_movimiento, $efecto_movimiento, $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio, $serie_monto, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $datos_marca, $datos_version, $datos_color, $datos_modelo, $datos_vin, $datos_precio, $datos_estatus, $asesor1, $enlace1, $asesor2, $enlace2, $coach, $archivo, $comentarios, $idcontacto, $comision, $visible, $comentarios_eliminacion, $usuario_elimino, $fecha_eliminacion, $usuario_creador, $fecha_creacion, $fecha_guardado){
    return estado_cuenta::create([
      // 'idestado_cuenta' => $idestado_cuenta,
      'concepto' => $concepto,
      'apartado_usado' => $apartado_usado,
      'tipo_movimiento' => $tipo_movimiento,
      'efecto_movimiento' => $efecto_movimiento,
      'fecha_movimiento' => $fecha_movimiento,
      'metodo_pago' => $metodo_pago,
      'saldo_anterior' => $saldo_anterior,
      'saldo' => $saldo,
      'monto_precio' => $monto_precio,
      'serie_monto' => $serie_monto,
      'monto_total' => $monto_total,
      'tipo_moneda' => $tipo_moneda,
      'tipo_cambio' => $tipo_cambio,
      'gran_total' => $gran_total,
      'cargo' => $cargo,
      'abono' => $abono,
      'emisora_institucion' => $emisora_institucion,
      'emisora_agente' => $emisora_agente,
      'receptora_institucion' => $receptora_institucion,
      'receptora_agente' => $receptora_agente,
      'tipo_comprobante' => $tipo_comprobante,
      'referencia' => $referencia,
      'datos_marca' => $datos_marca,
      'datos_version' => $datos_version,
      'datos_color' => $datos_color,
      'datos_modelo' => $datos_modelo,
      'datos_vin' => $datos_vin,
      'datos_precio' => $datos_precio,
      'datos_estatus' => $datos_estatus,
      'asesor1' => $asesor1,
      'enlace1' => $enlace1,
      'asesor2' => $asesor2,
      'enlace2' => $enlace2,
      'coach' => $coach,
      'archivo' => $archivo,
      'comentarios' => $comentarios,
      'idcontacto' => $idcontacto,
      'comision' => $comision,
      'visible' => $visible,
      'comentarios_eliminacion' => $comentarios_eliminacion,
      'usuario_elimino' => $usuario_elimino,
      'fecha_eliminacion' => $fecha_eliminacion,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado
    ]);
  }
  public static function updateStatusAsPayed($id_state_account){
    $state_account = estado_cuenta::findOrFail($id_state_account);
    $state_account->datos_estatus = 'Pagada';
    $state_account->saveOrFail();
    return $state_account;
  }
}
