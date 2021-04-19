<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_vistas_auto extends Model
{
  protected $table = 'inventario_vistas_auto';
  public $timestamps = false;

  protected $fillable = [
    'idinventario_vistas_auto','nombre','descripcion','orden'
  ];

}
