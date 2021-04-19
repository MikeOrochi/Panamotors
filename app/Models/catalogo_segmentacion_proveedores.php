<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_segmentacion_proveedores extends Model
{
  protected $table = 'catalogo_segmentacion_proveedores';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_segmentacion_proveedores', 'nombre', 'nomeclatura', 'col1', 'col2', 'col3', 'col4', 'col5', 'col6', 'col7', 'col8', 'col9', 'col10'
  ];

  public static function createCatalogoSegmentacionProveedores($idcatalogo_segmentacion_proveedores, $nombre, $nomeclatura, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10){
    return catalogo_segmentacion_proveedores::create([
      'idcatalogo_segmentacion_proveedores' => $idcatalogo_segmentacion_proveedores,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura,
      'col1' => $col1,
      'col2' => $col2,
      'col3' => $col3,
      'col4' => $col4,
      'col5' => $col5,
      'col6' => $col6,
      'col7' => $col7,
      'col8' => $col8,
      'col9' => $col9,
      'col10' => $col10
    ]);
  }
}
