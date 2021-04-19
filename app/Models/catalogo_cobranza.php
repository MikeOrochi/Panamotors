<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_cobranza extends Model
{
  protected $table = 'catalogo_cobranza';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_cobranza', 'nombre', 'nomeclatura', 'visible'
  ];

  public static function createCatalogoCobranza($idcatalogo_cobranza, $nombre, $nomeclatura, $visible){
    return catalogo_cobranza::create([
      'idcatalogo_cobranza' => $idcatalogo_cobranza,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura,
      'visible' => $visible
    ]);
  }
}
