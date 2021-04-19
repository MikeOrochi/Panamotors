<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bitacora_passwords extends Model
{
    protected $table = 'bitacora_passwords';
    public $timestamps = false;

    protected $fillable = [
        'idbitacora_passwords', 'password_anterior', 'password_nueva', 'password_completa', 'usuario_creador', 'fecha_generacion', 'fecha_caducidad'
    ];

    public static function createBitacoraPasswords($password_anterior, $password_nueva, $password_completa, $usuario_creador, $fecha_generacion, $fecha_caducidad){
      return bitacora_passwords::create([
        'password_anterior'=>$password_anterior,
        'password_nueva'=>$password_nueva,
        'password_completa'=>$password_completa,
        'usuario_creador'=>$usuario_creador,
        'fecha_generacion'=>$fecha_generacion,
        'fecha_caducidad'=>$fecha_caducidad,

      ]);
    }
}
