<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vpme_pagares extends Model
{
  protected $table = 'vpme_pagares';
  // public $timestamps = false;
  protected $primaryKey = 'id';

  protected $fillable = [
      'id_vista_previa_movimiento_exitoso','num_pagare','monto','fecha_vencimiento','estatus','tipo','archivo_original','comentarios','fecha_guardado','visible'
  ];

  public static function createVPMEPagares(
     $id_vista_previa_movimiento_exitoso, $num_pagare, $monto, $fecha_vencimiento, $estatus, $tipo, $archivo_original, $comentarios,
     $fecha_guardado, $visible
  ){
    return vpme_pagares::create([
        'id_vista_previa_movimiento_exitoso'=>$id_vista_previa_movimiento_exitoso,
        'num_pagare'=>$num_pagare,
        'monto'=>$monto,
        'fecha_vencimiento'=>$fecha_vencimiento,
        'estatus'=>$estatus,
        'tipo'=>$tipo,
        'archivo_original'=>$archivo_original,
        'comentarios'=>$comentarios,
        'fecha_guardado'=>$fecha_guardado,
        'visible'=>$visible,
    ]);
  }
}
