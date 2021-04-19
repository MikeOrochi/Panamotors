<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estado_cuenta_requesicion_sobrantes extends Model
{
  protected $table = 'estado_cuenta_requesicion_sobrantes';
  public $timestamps = false;

  protected $fillable = [
    'idestado_cuenta_requesicion_sobrantes', 'concepto', 'nombre_auxiliar', 'fecha_movimiento', 'referencia',
     'idestado_cuenta_requisicion_abono_movimiento','idauxiliar_principales','monto_abono','tipo_moneda',
     'tipo_cambio','gran_total','metodo_pago','tipo_movimiento','visible','usuario_creador','fecha_creacion',
     'fecha_guardado','col1','col2','col3','col4','col5','col6','col7','col8','col9','col10'
  ];


  /*public static function createEC_Requisicion($concepto,$idcatalogo_provedores,$responsable,$idcatalogo_departamento,$estatus,
  $idfoliogo,$apartado_usado,$tipo_movimiento,$efecto_movimiento,$fecha_movimiento,$metodo_pago,$saldo_anterior,$saldo,$monto_precio,
  $serie_monto,$monto_total,$tipo_moneda,$tipo_cambio,$gran_total,$cargo,$abono,$emisora_institucion,$emisora_agente,$receptora_institucion,
  $receptora_agente,$tipo_comprobante,$referencia,$datos_vin,$archivo,$comentarios,$idauxiliar_principales,$comision,$columna1,
  $columna2,$columna3,$columna5,$columna6,$columna7,$columna8,$columna9,$columna10,$factura,$datos_estatus,$usuario,$fecha,
  $visible,$comentarios_eliminacion,$usuario_elimino,$fecha_eliminacion,$usuario_creador,$fecha_creacion,$fecha_guardado){
    return estado_cuenta_requisicion::create([
      'concepto' => $concepto,
      'idcatalogo_provedores' => $idcatalogo_provedores,
      'responsable' => $responsable,
      'idcatalogo_departamento' => $idcatalogo_departamento,
      'estatus' => $estatus,
      'idfoliogo' => $idfoliogo,
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
      'datos_vin' => $datos_vin,
      'archivo' => $archivo,
      'comentarios' => $comentarios,
      'idauxiliar_principales' => $idauxiliar_principales,
      'comision' => $comision,
      'columna1' => $columna1,
      'columna2' => $columna2,
      'columna3' => $columna3,
      'columna5' => $columna5,
      'columna6' => $columna6,
      'columna7' => $columna7,
      'columna8' => $columna8,
      'columna9' => $columna9,
      'columna10' => $columna10,
      'factura' => $factura,
      'datos_estatus' => $datos_estatus,
      'usuario' => $usuario,
      'fecha' => $fecha,
      'visible' => $visible,
      'comentarios_eliminacion' => $comentarios_eliminacion,
      'usuario_elimino' => $usuario_elimino,
      'fecha_eliminacion' => $fecha_eliminacion,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado
    ]);
  }*/


}
