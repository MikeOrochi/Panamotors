<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class autenticacion_pdf_costo_total extends Model
{
  protected $table = 'autenticacion_pdf_costo_total';
  public $timestamps = false;
  protected $primaryKey = 'idautenticacion_pdf_costo_total';

  protected $fillable = [
    'idautenticacion_pdf_costo_total', 'idempleado','contrasenia_apertura',
    'segunda_autenticacion','fecha_caducidad','idusuario','visible'
  ];


}
