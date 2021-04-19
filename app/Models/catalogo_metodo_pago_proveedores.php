<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_metodo_pago_proveedores extends Model
{
  protected $table = 'catalogo_metodo_pago_proveedores';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_metodo_pago_proveedores', 'tipo', 'visible'
  ];

  public static function createCatalogoMetodoPagoProveedores($idcatalogo_metodo_pago_proveedores, $tipo, $visible){
    return catalogo_metodo_pago_proveedores::create([
      'idcatalogo_metodo_pago_proveedores' => $idcatalogo_metodo_pago_proveedores,
      'tipo' => $tipo,
      'visible' => $visible
    ]);
  }
}
