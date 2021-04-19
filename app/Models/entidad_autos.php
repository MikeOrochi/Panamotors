<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class entidad_autos extends Model
{
  protected $table = 'entidad_autos';
  public $timestamps = false;

  protected $fillable = [
    'identidad_autos', 'estado', 'descripcion'
  ];

}
