<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fechas_compromiso_pagrares_proveedores extends Model
{
  protected $table = 'fechas_compromiso_pagrares_proveedores';
  public $timestamps = false;

  protected $fillable = [
      'idfechas_compromiso_pagrares_proveedores',
      'comentarios',
      'tipo',
      'start',
      'end',
      'ejecutivo',
      'color',
      'iddocumentos_cobrar',
      'usuario_guardo',
      'fecha_creacion',
      'fecha_guardado',
      'archivo',
      'cumplimiento',
      'fecha_real_archivo',
      'fecha_carga_archivo',
      'titulo',
      'visible'
  ];

  public static function createFechaCompromisoPP(
    $comentarios,$tipo,$start,$end,$ejecutivo,$color,$iddocumentos_cobrar,
    $usuario_guardo,$fecha_creacion,$fecha_guardado,$archivo,
    $cumplimiento,$fecha_real_archivo,$fecha_carga_archivo,
    $titulo,$visible){
    return fechas_compromiso_pagrares_proveedores::create([
      'comentarios' => $comentarios,
      'tipo' => $tipo,
      'start' => $start,
      'end' => $end,
      'ejecutivo' => $ejecutivo,
      'color' => $color,
      'iddocumentos_cobrar' => $iddocumentos_cobrar,
      'usuario_guardo' => $usuario_guardo,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'archivo' => $archivo,
      'cumplimiento' => $cumplimiento,
      'fecha_real_archivo' => $fecha_real_archivo,
      'fecha_carga_archivo' => $fecha_carga_archivo,
      'titulo' => $titulo,
      'visible' => $visible
    ]);
  }
}
