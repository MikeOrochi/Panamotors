<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_colaborador extends Model
{
  protected $table = 'catalogo_colaborador';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_colaborador', 'nombre', 'nomeclatura','idcatalogo_departamento','visible'
  ];

  /*public static function createCatalogoComprobantes($idcatalogo_comprobantes, $nombre, $nomeclatura){
    return catalogo_comprobantes::create([
      'idcatalogo_comprobantes' => $idcatalogo_comprobantes,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura
    ]);
  }*/
}
