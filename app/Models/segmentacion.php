<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class segmentacion extends Model
{
  protected $table = 'segmentacion';
  public $timestamps = false;

  protected $fillable = [
    'idsegmentacion', 'nombre', 'nomenclatura', 'descripcion'
  ];

  public static function createSegmentacion($nombre, $nomenclatura, $descripcion){
    return segmentacion::create([
      'nombre' => $nombre,
      'nomenclatura' => $nomenclatura,
      'descripcion' => $descripcion,
    ]);
  }

}
