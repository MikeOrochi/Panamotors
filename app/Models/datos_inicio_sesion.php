<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class datos_inicio_sesion extends Model
{
  protected $table = 'datos_inicio_sesion';
  public $timestamps = false;

  protected $fillable = [
    'idsesion', 'fecha_acceso', 'ip', 'lat_lgn', 'usuario', 'tipo'
  ];

  public static function createInicioSesion($fecha_acceso, $ip, $lat_lgn, $usuario, $tipo){
    return datos_inicio_sesion::create([
      'fecha_acceso' => $fecha_acceso,
      'ip' => $ip,
      'lat_lgn' => $lat_lgn,
      'usuario' => $usuario,
      'tipo' => $tipo,
    ]);
  }
}
