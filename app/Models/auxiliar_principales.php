<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class auxiliar_principales extends Model
{
  protected $table = 'auxiliar_principales';
  public $timestamps = false;
  protected $primaryKey ='idauxiliar_principales';
  protected $fillable = [
    'concepto','estatus','departamento','comentarios','usuario_creador','visible','fecha_creacion','fecha_guardado','tipo_auxliar','balance','id','beneficiario'
  ];
}
