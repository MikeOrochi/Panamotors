<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_galeria_trucks extends Model
{
  protected $table = 'inventario_galeria_trucks';
  protected $primaryKey = 'idinventario_galeria_trucks';
  public $timestamps = false;

  protected $fillable = [
    'idinventario_galeria_trucks','foto_vin','nombre_vista','descripcion','idinventario_trucks','visible','usuario_creador','fecha_creacion','fecha_guardado',
  ];

  public static function createInventarioGaleriaTrucks($foto_vin, $nombre_vista, $descripcion, $idinventario_trucks, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado){
    return inventario_galeria_trucks::create([
      'foto_vin'=>$foto_vin,
      'nombre_vista'=>$nombre_vista,
      'descripcion'=>$descripcion,
      'idinventario_trucks'=>$idinventario_trucks,
      'visible'=>$visible,
      'usuario_creador'=>$usuario_creador,
      'fecha_creacion'=>$fecha_creacion,
      'fecha_guardado'=>$fecha_guardado,

    ]);
  }
}
