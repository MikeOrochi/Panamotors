<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class perfiles extends Model
{
  protected $table = 'perfiles';
  public $timestamps = false;

  protected $fillable = [
    'idperfiles', 'rol', 'perfil_nombre', 'descripcion', 'direccion', 'tags'
  ];

  public static function createPerfiles($idperfiles, $rol, $perfil_nombre, $descripcion, $direccion, $tags){
    return segmentacion::create([
      'idperfiles' => $idperfiles,
      'rol' => $rol,
      'perfil_nombre' => $perfil_nombre,
      'descripcion' => $descripcion,
      'direccion' => $direccion,
      'tags' => $tags,

    ]);
  }
}
