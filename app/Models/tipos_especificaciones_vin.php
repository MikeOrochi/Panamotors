<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class tipos_especificaciones_vin extends Model
{
  protected $table = 'tipos_especificaciones_vin';
  public $timestamps = false;
  protected $primaryKey = 'idtipos_especificaciones_vin';

  protected $fillable = [
    'tipo', 'descripcion', 'usuario_creador','visible','fecha_creacion','fecha_guardado'
  ];




}
