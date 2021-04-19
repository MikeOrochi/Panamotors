<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estatus_unidad extends Model
{
  protected $table = 'estatus_unidad';
  public $timestamps = false;

  protected $fillable = [
    'idestatus_unidad', 'estatus', 'descripcion'
  ];

}
