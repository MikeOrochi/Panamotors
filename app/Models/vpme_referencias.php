<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vpme_referencias extends Model
{
  protected $table = 'vpme_referencias';
  // public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
      'id_vista_previa_movimiento_exitoso','nombre','apellidos','telefono'
  ];

  public static function createVPMEReferencias(
     $id_vista_previa_movimiento_exitoso, $nombre, $apellidos, $telefono
  ){
    return vpme_referencias::create([
        'id_vista_previa_movimiento_exitoso'=>$id_vista_previa_movimiento_exitoso,
        'nombre'=>$nombre,
        'apellidos'=>$apellidos,
        'telefono'=>$telefono,
    ]);
  }
}
