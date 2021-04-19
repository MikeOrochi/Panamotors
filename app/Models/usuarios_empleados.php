<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\UsuariosEmpleados as Authenticatable;

class usuarios_empleados  extends Authenticatable
{

  use Notifiable;

  protected $guard = "usuarios";
  protected $table = 'usuarios_empleados';
  protected $primaryKey = "idusuarios_empleados";
  public $timestamps = false;

  protected $fillable = [
    'idusuarios_empleados', 'idempleados', 'password', 'foto_perfil', 'fecha_creacion_password', 'fecha_caducidad_password', 'notificacion_caducidad_password', 'visible', 'fecha_creacion', 'fecha_guardado', 'col1', 'col2', 'col3', 'col4', 'col5', 'col6', 'col7', 'col8', 'col9', 'col10'
  ];

  public static function createUsuariosEmpleados($idusuarios_empleados, $idempleados, $password, $foto_perfil, $fecha_creacion_password, $fecha_caducidad_password, $notificacion_caducidad_password, $visible, $fecha_creacion, $fecha_guardado, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10){
    return usuarios_empleados::create([
      'idusuarios_empleados' => $idusuarios_empleados,
      'idempleados' => $idempleados,
      'password' => $password,
      'foto_perfil' => $foto_perfil,
      'fecha_creacion_password' => $fecha_creacion_password,
      'fecha_caducidad_password' => $fecha_caducidad_password,
      'notificacion_caducidad_password' => $notificacion_caducidad_password,
      'visible' => $visible,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'col1' => $col1,
      'col2' => $col2,
      'col3' => $col3,
      'col4' => $col4,
      'col5' => $col5,
      'col6' => $col6,
      'col7' => $col7,
      'col8' => $col8,
      'col9' => $col9,
      'col10' => $col10,
    ]);
  }
}
