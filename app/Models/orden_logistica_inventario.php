<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orden_logistica_inventario extends Model
{
  protected $table = 'orden_logistica_inventario';
  public $timestamps = false;

  protected $fillable = [
    'idorden_logistica_inventario', 'tipo_unidad_inventario', 'vin', 'marca', 'version', 'color', 'modelo', 'idorden_logistia', 'estatus_unidad', 'tipo', 'visible', 'fecha_creacion', 'fecha_guardado', 'columna_a', 'columna_b', 'columna_c', 'columna_d', 'columna_e'
  ];

  public static function createOrdenLogisticaInventario($tipo_unidad_inventario, $vin, $marca, $version, $color, $modelo, $idorden_logistia, $estatus_unidad, $tipo, $visible, $fecha_creacion, $fecha_guardado, $columna_a, $columna_b, $columna_c, $columna_d, $columna_e){
    return orden_logistica_inventario::create([      
      'tipo_unidad_inventario' => $tipo_unidad_inventario,
      'vin' => $vin,
      'marca' => $marca,
      'version' => $version,
      'color' => $color,
      'modelo' => $modelo,
      'idorden_logistia' => $idorden_logistia,
      'estatus_unidad' => $estatus_unidad,
      'tipo' => $tipo,
      'visible' => $visible,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'columna_a' => $columna_a,
      'columna_b' => $columna_b,
      'columna_c' => $columna_c,
      'columna_d' => $columna_d,
      'columna_e' => $columna_e,

    ]);
  }
}
