<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class publicacion_vin_fotos extends Model
{
  protected $table = 'publicacion_vin_fotos';
  public $timestamps = false;
  protected $primaryKey = 'idpublicacio_vin_fotos';

  protected $fillable = [
    'idpublicacio_vin_fotos', 'tipo', 'ruta_foto', 'idpublicacion_vin', 'vin', 'visible', 'usuario_creador', 'fecha_creacion', 'fecha_guardado'
  ];




}
