<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_tesorerias extends Model
{
  protected $table = 'catalogo_tesorerias';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_tesorerias', 'nombre', 'nomeclatura'
  ];

  public static function createCatalogoTesorerias($idcatalogo_tesorerias, $nombre, $nomenclatura){
    return catalogo_tesorerias::create([
      'idcatalogo_tesorerias' => $idcatalogo_tesorerias,
      'nombre' => $nombre,
      'nomeclatura' => $nomenclatura
    ]);
  }
}
