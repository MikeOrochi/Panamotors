<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ubicacion extends Model
{
  protected $table = 'ubicacion';
  public $timestamps = false;

  protected $fillable = [
    'idubicacion', 'nombre', 'nomenclatura','ubicacion','visible','descripcion','columna_a'
  ];

}
