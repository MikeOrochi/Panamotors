<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vpme_ventas_permutas extends Model
{
  protected $table = 'vpme_ventas_permutas';
  // public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
      'id_vista_previa_movimiento_exitoso','vin_numero_serie_recibido','valoracion_vin_recibido','vin_numero_serie_cambio',
      'valoracion_vin_cambio','estatus', 'imagenes_vin_recibido', 'fecha_guardado'
  ];

  public static function createVPMEVentasPermutas(
      $id_vista_previa_movimiento_exitoso, $vin_numero_serie_recibido, $valoracion_vin_recibido, $vin_numero_serie_cambio,
      $valoracion_vin_cambio, $estatus, $imagenes_vin_recibido, $fecha_guardado
  ){
    return vpme_ventas_permutas::create([
        'id_vista_previa_movimiento_exitoso'=>$id_vista_previa_movimiento_exitoso,
        'vin_numero_serie_recibido'=>$vin_numero_serie_recibido,
        'valoracion_vin_recibido'=>$valoracion_vin_recibido,
        'vin_numero_serie_cambio'=>$vin_numero_serie_cambio,
        'valoracion_vin_cambio'=>$valoracion_vin_cambio,
        'estatus'=>$estatus,
        'imagenes_vin_recibido'=>$imagenes_vin_recibido,
        'fecha_guardado'=>$fecha_guardado,

    ]);
  }
}
