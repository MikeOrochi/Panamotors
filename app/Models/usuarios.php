<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
  protected $table = 'usuarios';
  public $timestamps = false;

  protected $fillable = [
    'idusuario', 'usuario', 'password', 'nombre_usuario', 'rol', 'activo', 'sigla_ccp', 'puesto_ccp', 'autorizaciones', 'ubicacion', 'foto_perfil', 'usuario_creador', 'fecha_creacion', 'fecha_creacion_password', 'fecha_caducidad_password', 'visible', 'notificacion_caducidad_password', 'idempleados', 'foto_departamento'
  ];

  public static function createUsuarios(){
    return usuarios::create([
      'idusuario' => $idusuario,
      'usuario' => $usuario,
      'password' => $password,
      'nombre_usuario' => $nombre_usuario,
      'rol' => $rol,
      'activo' => $activo,
      'sigla_ccp' => $sigla_ccp,
      'puesto_ccp' => $puesto_ccp,
      'autorizaciones' => $autorizaciones,
      'ubicacion' => $ubicacion,
      'foto_perfil' => $foto_perfil,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_creacion_password' => $fecha_creacion_password,
      'fecha_caducidad_password' => $fecha_caducidad_password,
      'visible' => $visible,
      'notificacion_caducidad_password' => $notificacion_caducidad_password,
      'idempleados' => $idempleados,
      'foto_departamento' => $foto_departamento,
    ]);
  }
}
