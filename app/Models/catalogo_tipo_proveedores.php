<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_tipo_proveedores extends Model
{
  protected $table = 'catalogo_tipo_proveedores';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_tipo_proveedores', 'tipo', 'visible'
  ];

  public static function createCatalogoTipoProveedores($idcatalogo_tipo_proveedores, $tipo, $visible){
    return catalogo_tipo_proveedores::create([
      'idcatalogo_tipo_proveedores' => $idcatalogo_tipo_proveedores,
      'tipo' => $tipo,
      'visible' => $visible
    ]);
  }
}
