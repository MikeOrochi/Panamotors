<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class recibos_requesicion_auxiliar extends Model
{
  protected $table = 'recibos_requesicion_auxiliar';
  public $timestamps = false;
  protected $primaryKey = 'idrecibos_requesicion_auxiliar';

  protected $fillable = [
    'idrecibos_requesicion_auxiliar', 'fecha', 'monto','emisora_institucion','emisora_agente','receptora_institucion',
    'receptora_agente','concepto','metodo_pago','referencia','comentarios','responsable','nombre_auxiliar',
    'idauxiliar_principales','usuario_creador','factura','fecha_guardado','tipo_moneda','tipo_cambio','gran_total'
  ];

  public static function createRecibosReqAuxiliar(
    $fecha, $monto,$emisora_institucion,$emisora_agente,$receptora_institucion,
    $receptora_agente,$concepto,$metodo_pago,$referencia,$comentarios,$responsable,$nombre_auxiliar,
    $idauxiliar_principales,$usuario_creador,$factura,$fecha_guardado,$tipo_moneda,$tipo_cambio,$gran_total
  ){
    return recibos_requesicion_auxiliar::create([
      'fecha' => $fecha,
      'monto' => $monto,
      'emisora_institucion' => $emisora_institucion,
      'emisora_agente' => $emisora_agente,
      'receptora_institucion' => $receptora_institucion,
      'receptora_agente' => $receptora_agente,
      'concepto' => $concepto,
      'metodo_pago' => $metodo_pago,
      'referencia' => $referencia,
      'comentarios' => $comentarios,
      'responsable' => $responsable,
      'nombre_auxiliar' => $nombre_auxiliar,
      'idauxiliar_principales' => $idauxiliar_principales,
      'usuario_creador' => $usuario_creador,
      'factura' => $factura,
      'fecha_guardado' => $fecha_guardado,
      'tipo_moneda' => $tipo_moneda,
      'tipo_cambio' => $tipo_cambio,
      'gran_total' => $gran_total
    ]);
  }

}
