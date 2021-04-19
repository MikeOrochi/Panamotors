<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class check_list_expediente_original_datos extends Model
{
  protected $table = 'check_list_expediente_original_datos';
  public $timestamps = false;
  protected $primaryKey = 'idcheck_list_expediente_original_datos';

  protected $fillable = [
    'idcheck_list_expediente_original_datos','idcheck_list_expediente_original',
    'idorden_compra_unidades','origen','destino','descripcion','visible',
    'usuario_creador','fecha_creacion','fecha_guardado','idcontacto','tipo_contacto',
    'idinventario','vin','fecha_emision','estado_emision','col7','col8','col9','col10'
  ];


}
