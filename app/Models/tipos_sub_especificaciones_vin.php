<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class tipos_sub_especificaciones_vin extends Model
{
  protected $table = 'tipos_sub_especificaciones_vin';
  public $timestamps = false;
  protected $primaryKey = 'idtipos_sub_especificaciones_vin';

  protected $fillable = [
    'idtipos_sub_especificaciones_vin', 'idtipos_especificaciones_vin', 'tipo','descripcion',
    'usuario_creador','visible','fecha_creacion','fecha_guarado'
  ];




}
