<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_comprobantes extends Model
{
  protected $table = 'catalogo_comprobantes';
  public $timestamps = false;

  protected $fillable = [
  'idcatalogo_comprobantes', 'nombre', 'nomeclatura'
  ];

  public static function createCatalogoComprobantes($idcatalogo_comprobantes, $nombre, $nomeclatura){
    return catalogo_comprobantes::create([
      'idcatalogo_comprobantes' => $idcatalogo_comprobantes,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura
    ]);
  }
}
