<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_cambios extends Model
{
  protected $table = 'inventario_cambios';
  public $timestamps = false;
  protected $primaryKey = 'idinventario_cambios';

  protected $fillable = [
    'descripcion_cambio', 'usuario', 'fecha', 'idinventario'
  ];

  public static function createInventarioCambios($descripcion_cambio, $usuario, $fecha, $idinventario){
    return inventario_cambios::create([
        'descripcion_cambio'=>$descripcion_cambio,
        'usuario'=>$usuario,
        'fecha'=>$fecha,
        'idinventario'=>$idinventario,

    ]);
  }
}
