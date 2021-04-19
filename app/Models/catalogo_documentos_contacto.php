<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catalogo_documentos_contacto extends Model
{
  protected $table = 'catalogo_documentos_contacto';
  public $timestamps = false;

  protected $fillable = [
    'idcatalogo_documentos_contacto', 'nombre', 'nomenclatura', 'visible', 'visible_logistica'
  ];


}
