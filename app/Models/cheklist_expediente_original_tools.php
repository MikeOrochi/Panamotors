<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cheklist_expediente_original_tools extends Model
{
  protected $table = 'cheklist_expediente_original_tools';
  public $timestamps = false;
  protected $primaryKey = 'idcheklist_expediente_original_tools';

  protected $fillable = [
    'idcheklist_expediente_original_tools','idcheck_list_expediente_original','tipo','estatus','archivo',
    'usuario_creador','visible','fecha_creacion','fecha_guardado','col1','col2','col3','col4',
    'col5','col6','col7'
  ];


}
