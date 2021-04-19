<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_departamento extends Model
{
  protected $table = 'catalogo_departamento';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_departamento', 'nombre', 'nomenclatura', 'visible', 'visible_logistica'
  ];

  public static function createCatalogoDepartamento($idcatalogo_departamento, $nombre, $nomenclatura, $visible, $visible_logistica){
    return catalogo_departamento::create([
      'idcatalogo_departamento' => $idcatalogo_departamento,
      'nombre' => $nombre,
      'nomenclatura' => $nomenclatura,
      'visible' => $visible,
      'visible_logistica' => $visible_logistica
    ]);
  }
}
