<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comprobantes_transferencia extends Model
{
   protected $table = 'comprabantes_transferencia';
   public $timestamps = false;
   protected $primaryKey = 'idcomprabantes_transferencia';

   protected $fillable = [
      'concepto', 'fecha_movimiento', 'folio', 'estatus', 'id',
      'tipo_id', 'vin', 'emisora_institucion', 'emisora_agente', 'receptora_institucion', 'receptora_agente',
      'tipo_comprobante', 'referencia', 'monto_entrada', 'tipo_moneda', 'tipo_cambio', 'gran_total',
      'evidencia', 'perfil', 'url', 'idmovimiento', 'tabla_movimiento', 'visible', 'comentarios',
      'ip', 'lat_long', 'empleador_creador', 'usuario_creador', 'fecha_creacion', 'fecha_guardado', 'metodo_pago',
      'tipo_pago'
   ];

   public static function createComprobantesTransferencia(
      $concepto, $fecha_movimiento, $folio, $estatus, $id, $tipo_id, $vin,
      $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia,
      $monto_entrada, $tipo_moneda, $tipo_cambio, $gran_total, $evidencia, $perfil, $url, $idmovimiento, $tabla_movimiento,
      $visible, $comentarios, $ip, $lat_long, $empleador_creador, $usuario_creador, $fecha_creacion, $fecha_guardado,
      $metodo_pago, $tipo_pago
   ){
     return comprobantes_transferencia::create([
        'concepto' => $concepto,
        'fecha_movimiento' => $fecha_movimiento,
        'folio' => $folio,
        'estatus' => $estatus,
        'id' => $id,
        'tipo_id' => $tipo_id,
        'vin' => $vin,
        'emisora_institucion' => $emisora_institucion,
        'emisora_agente' => $emisora_agente,
        'receptora_institucion' => $receptora_institucion,
        'receptora_agente' => $receptora_agente,
        'tipo_comprobante' => $tipo_comprobante,
        'referencia' => $referencia,
        'monto_entrada' => $monto_entrada,
        'tipo_moneda' => $tipo_moneda,
        'tipo_cambio' => $tipo_cambio,
        'gran_total' => $gran_total,
        'evidencia' => $evidencia,
        'perfil' => $perfil,
        'url' => $url,
        'idmovimiento' => $idmovimiento,
        'tabla_movimiento' => $tabla_movimiento,
        'visible' => $visible,
        'comentarios' => $comentarios,
        'ip' => $ip,
        'lat_long' => $lat_long,
        'empleador_creador' => $empleador_creador,
        'usuario_creador' => $usuario_creador,
        'fecha_creacion' => $fecha_creacion,
        'fecha_guardado' => $fecha_guardado,
        'metodo_pago' => $metodo_pago,
        'tipo_pago' => $tipo_pago,
     ]);
   }
}
