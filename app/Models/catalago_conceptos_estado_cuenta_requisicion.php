<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalago_conceptos_estado_cuenta_requisicion extends Model
{
  protected $table = 'catalago_conceptos_estado_cuenta_requisicion';
  public $timestamps = false;


  protected $fillable = [
    'idcatalago_conceptos_estado_cuenta_requisicion', 'concepto', 'departamento', 'idtipo', 'visible', 'empleado_creador', 'usuario_creador', 'fecha_creacion', 'fecha_guardado', 'col1', 'col2', 'col3'
  ];


  public static function createCatalogoDepartamento($concepto, $departamento, $visible, $empleado_creador, $usuario_creador, $fecha_creacion ,$fecha_guardado,$col1){
    return catalago_conceptos_estado_cuenta_requisicion::create([
      'concepto' => $concepto,
      'departamento' => $departamento,
      'visible' => $visible,
      'empleado_creador' => $empleado_creador,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'col1' => $col1
    ]);
  }

}
