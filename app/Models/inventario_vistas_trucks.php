<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_vistas_trucks extends Model
{
  protected $table = 'inventario_vistas_trucks';
  public $timestamps = false;

  protected $fillable = [
    'idinventario_vistas_trucks','nombre','descripcion','orden'
  ];

}
