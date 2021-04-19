<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_real_puesto_venta extends Model
{
  protected $table = 'inventario_real_puesto_venta';
  public $timestamps = false;
protected $primaryKey = 'idinventario_real_puesto_venta';

  protected $fillable = [
    'idinventario_real_puesto_venta', 'idinventario', 'vin', 'tipo', 'visible', 'usuario_creador', 'fecha_guardado'
  ];

  public static function createInventarioRealPuestoVenta( $idinventario_real_puesto_venta, $idinventario, $vin, $tipo, $visible, $usuario_creador, $fecha_guardado){
    return inventario_real_puesto_venta::create([
        'idinventario'=>$idinventario,
        'vin'=>$vin,
        'tipo'=>$tipo,
        'visible'=>$visible,
        'usuario_creador'=>$usuario_creador,
        'fecha_guardado'=>$fecha_guardado,

    ]);
  }
}
