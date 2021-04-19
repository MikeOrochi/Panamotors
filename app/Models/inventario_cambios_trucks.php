<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_cambios_trucks extends Model
{
  protected $table = 'inventario_cambios_trucks';
  public $timestamps = false;
  protected $primaryKey = 'idinventario_cambios_trucks';

  protected $fillable = [
    'descripcion_cambio', 'usuario', 'fecha', 'idinventario_trucks'
  ];

  public static function createInventarioCambiosTrucks($descripcion_cambio, $usuario, $fecha, $idinventario_trucks){
    return inventario_cambios_trucks::create([
        'descripcion_cambio'=>$descripcion_cambio,
        'usuario'=>$usuario,
        'fecha'=>$fecha,
        'idinventario_trucks'=>$idinventario_trucks,

    ]);
  }
}
