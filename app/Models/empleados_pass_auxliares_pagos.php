<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class empleados_pass_auxliares_pagos extends Model
{
  protected $table = 'empleados_pass_auxliares_pagos';
  public $timestamps = false;
  protected $primaryKey = 'idempleados_pass_auxliares_pagos';

  protected $fillable = [
    'idempleados_pass_auxliares_pagos', 'idempleados', 'password', 'referencia', 'estatus', 'tipo', 'estatus_at', 'comentarios', 'usuario_creador', 'visible', 'fecha_creacion', 'fecha_guardado', 'palabra_clave'
  ];

  public static function createEmpleadosPassAuxliaresPagos($idempleados, $password, $referencia, $estatus, $tipo, $estatus_at, $comentarios, $usuario_creador, $visible, $fecha_creacion, $fecha_guardado, $palabra_clave){
    return empleados_pass_auxliares_pagos::create([
      'idempleados' => $idempleados,
      'password' => $password,
      'referencia' => $referencia,
      'estatus' => $estatus,
      'tipo' => $tipo,
      'estatus_at' => $estatus_at,
      'comentarios' => $comentarios,
      'usuario_creador' => $usuario_creador,
      'visible' => $visible,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'palabra_clave' => $palabra_clave
    ]);
  }


  public static function updateAccesPassEmployedPay($idempleados_pass_auxliares_pagos){
    $estatus_acces = empleados_pass_auxliares_pagos::findOrFail($idempleados_pass_auxliares_pagos);
    $estatus_acces->estatus = 'Usado';
    $estatus_acces->saveOrFail();
    return $estatus_acces;
  }
}
