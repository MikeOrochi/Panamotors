<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class empleados_pass_auxiliares_cambios extends Model
{
  protected $table = 'empleados_pass_auxiliares_cambios';
  public $timestamps = false;
  protected $primaryKey = 'idempleados_pass_auxiliares_cambios';

  protected $fillable = [
    'idempleados_pass_auxiliares_cambios', 'idempleados', 'password_ingresada', 'estatus', 'ip', 'tipo', 'referencia', 'idestado_cuenta_requisicion', 'usuario_creador', 'visible', 'fecha_creacion', 'fecha_guardado', 'archivo_consultado'
  ];

  public static function createEmpleadosPassAuxliaresPagosCambios($idempleados, $password_ingresada, $estatus, $ip, $tipo, $referencia, $idestado_cuenta_requisicion, $usuario_creador, $visible, $fecha_creacion, $fecha_guardado, $archivo_consultado){
    return empleados_pass_auxiliares_cambios::create([
      'idempleados' => $idempleados,
      'password_ingresada' => $password_ingresada,
      'estatus' => $estatus,
      'ip' => $ip,
      'tipo' => $tipo,
      'referencia' => $referencia,
      'idestado_cuenta_requisicion' => $idestado_cuenta_requisicion,
      'usuario_creador' => $usuario_creador,
      'visible' => $visible,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'archivo_consultado' => $archivo_consultado
    ]);
  }


}
