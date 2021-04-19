<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detalle_seguimiento extends Model
{
  protected $table = 'detalle_seguimiento';
  public $timestamps = false;
  protected $primaryKey = 'iddetalle_seguimiento';

  protected $fillable = [
    'iddetalle_seguimiento', 'comentarios', 'tipo', 'start', 'end', 'archivo', 'idatencion_clientes',
     'idusuario', 'fecha_creacion', 'fecha_guardado', 'titulo_archivo', 'descripcion_archivo', 'visible'
  ];

  public static function createDetalleSeguimiento($comentarios,$tipo,$start,$end,$archivo,$idatencion_clientes,
  $idusuario,$fecha_creacion,$fecha_guardado,$titulo_archivo,$descripcion_archivo,$visible
  ){
    return detalle_seguimiento::create([
      'comentarios' => $comentarios,
      'tipo' => $tipo,
      'start' => $start,
      'end' => $end,
      'archivo' => $archivo,
      'idatencion_clientes' => $idatencion_clientes,
      'idusuario' => $idusuario,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'titulo_archivo' => $titulo_archivo,
      'descripcion_archivo' => $descripcion_archivo,
      'visible' => $visible
    ]);
  }

}
