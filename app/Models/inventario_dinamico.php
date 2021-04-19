<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_dinamico extends Model
{
  protected $table = 'inventario_dinamico';
  public $timestamps = false;
protected $primaryKey = 'idinventario_dinamico';

  protected $fillable = [
    'idinventario_dinamico', 'columna', 'contenido', 'idinventario', 'tipo_unidad', 'visible', 'usuario_creador', 'fecha_creacion', 'fecha_guardado'
  ];

  public static function createInventarioDinamico( $columna, $contenido, $idinventario, $tipo_unidad, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado ){
    return inventario_dinamico::create([
      'columna' => $columna,
      'contenido' => $contenido,
      'idinventario' => $idinventario,
      'tipo_unidad' => $tipo_unidad,
      'visible' => $visible,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
    ]);
  }
}
