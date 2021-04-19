<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_metodos_pago extends Model
{
  protected $table = 'catalogo_metodos_pago';
  public $timestamps = false;

  protected $fillable = [
  'idcatalogo_metodos_pago', 'nombre', 'nomeclatura'
  ];

  public static function createCatalogoMetodoPagoProveedores($idcatalogo_metodos_pago, $nombre, $nomeclatura){
    return catalogo_metodo_pago_proveedores::create([
      'idcatalogo_metodos_pago' => $idcatalogo_metodos_pago,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura
    ]);
  }

}
