<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class recibos_proveedores extends Model
{
  protected $table = 'recibos_proveedores';
  public $timestamps = false;
  protected $primaryKey = 'idrecibos_proveedores';

  protected $fillable = [
    'idrecibos_proveedores', 'fecha', 'monto', 'emisora_institucion', 'emisora_agente', 'receptora_institucion', 'receptora_agente', 'concepto', 'metodo_pago', 'referencia', 'comentarios', 'id_estado_cuenta', 'id_tesoreria', 'idcontacto', 'usuario_creador', 'departamento', 'fecha_guardado', 'tipo_moneda', 'tipo_cambio', 'gran_total'
  ];

  public static function createRecibosProveedores($fecha, $monto, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $concepto, $metodo_pago, $referencia, $comentarios, $id_estado_cuenta, $id_tesoreria, $idcontacto, $usuario_creador, $departamento, $fecha_guardado, $tipo_moneda, $tipo_cambio, $gran_total){
    return recibos_proveedores::create([
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
      'id_estado_cuenta' => $id_estado_cuenta,
      'id_tesoreria' => $id_tesoreria,
      'idcontacto' => $idcontacto,
      'usuario_creador' => $usuario_creador,
      'departamento' => $departamento,
      'fecha_guardado' => $fecha_guardado,
      'tipo_moneda' => $tipo_moneda,
      'tipo_cambio' => $tipo_cambio,
      'gran_total' => $gran_total,

    ]);
  }

}
