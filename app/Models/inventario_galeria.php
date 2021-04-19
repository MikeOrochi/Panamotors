<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_galeria extends Model
{
  protected $table = 'inventario_galeria';
  protected $primaryKey = 'idinventario_galeria';
  public $timestamps = false;

  protected $fillable = [
    'idinventario_galeria','foto_vin','nombre_vista','descripcion','idinventario'
  ];

  public static function createInventarioGaleria($foto_vin, $nombre_vista, $descripcion, $idinventario){
    return inventario_galeria::create([
      'foto_vin'=>$foto_vin,
      'nombre_vista'=>$nombre_vista,
      'descripcion'=>$descripcion,
      'idinventario'=>$idinventario,
    ]);
  }
}
