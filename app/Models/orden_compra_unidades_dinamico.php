<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class orden_compra_unidades_dinamico extends Model
{
  protected $table = 'orden_compra_unidades_dinamico';
  public $timestamps = false;
  protected $primaryKey = 'idorden_compra_unidades_dinamico';

  protected $fillable = [
    'idorden_compra_unidades_dinamico', 'columna', 'contenido','idorden_compra_unidades','tipo','visible',
    'usuario_creador','fecha_creacion','fecha_guardado'    
  ];




}
