<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class razon_social extends Model
{
  protected $table = 'razon_social';
  public $timestamps = false;

  protected $fillable = [
    'idrazon_social', 'nombre', 'descripcion'
  ];

}
