<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\abonos_unidades;
class estado_cuenta_bitacora_cambio_estatus extends Model
{
  protected $table = 'estado_cuenta_bitacora_cambio_estatus';
  public $timestamps = false;
  protected $primaryKey = 'idestado_cuenta_bitacora_cambio_estatus';

  protected $fillable = [
      'idestado_cuenta_bitacora_cambio_estatus','idestado_cuenta',
      'usuario_creador_default','fecha_validacion'
    ];

  public static function createEstadoCuentaBitacoraCambioEstatus($idestado_cuenta,$usuario_creador_default,$fecha_validacion){
    return estado_cuenta_bitacora_cambio_estatus::create([
      'idestado_cuenta' => $idestado_cuenta,
      'usuario_creador_default' => $usuario_creador_default,
      'fecha_validacion' => $fecha_validacion
    ]);
  }
}
