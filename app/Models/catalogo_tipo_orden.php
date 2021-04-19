<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_tipo_orden extends Model
{
  protected $table = 'catalogo_tipo_orden';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_tipo_orden', 'nombre', 'nomeclatura','visible','idcatalogo_departamento','orden',
    'nombre_header','negociacion_costos','asignacion_empleado','dispersion_informacion','tipo_vin'
  ];

  /*public static function createCatalogoComprobantes($idcatalogo_comprobantes, $nombre, $nomeclatura){
    return catalogo_comprobantes::create([
      'idcatalogo_comprobantes' => $idcatalogo_comprobantes,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura
    ]);
  }*/
}
