<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientes_tipos extends Model
{
  protected $table = 'clientes_tipos';
  public $timestamps = false;

  protected $fillable = [
    'idclientes_tipos', 'nombre', 'nomeclatura', 'descripcion'
  ];

  public static function createClientesTipos($idclientes_tipos, $nombre, $nomeclatura, $descripcion){
    return clientes_tipos::create([
      'idclientes_tipos' => $idclientes_tipos,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura,
      'descripcion' => $descripcion,
    ]);
  }
}
