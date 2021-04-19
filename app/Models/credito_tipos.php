<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class credito_tipos extends Model
{
  protected $table = 'credito_tipos';
  public $timestamps = false;

  protected $fillable = [
    'idcredito_tipos', 'nombre', 'nomeclatura'
  ];

  public static function createCreditoTipos($idcredito_tipos, $nombre, $nomeclatura){
    return credito_tipos::create([
      'idcredito_tipos' => $idcredito_tipos,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura
    ]);
  }
}
