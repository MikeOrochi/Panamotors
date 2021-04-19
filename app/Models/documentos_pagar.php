<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentos_pagar extends Model
{
  protected $table = 'documentos_pagar';
  public $timestamps = false;
  protected $primaryKey = 'iddocumentos_pagar';

  protected $fillable = [
    'iddocumentos_pagar', 'num_pagare', 'monto', 'fecha_vencimiento', 'tipo', 'estatus', 'archivo_original', 'archivo_entregado', 'comentarios', 'idestado_cuenta', 'usuario_creador', 'fecha_guardado', 'visible'
  ];

  public static function createDocumentosPagar($num_pagare, $monto, $fecha_vencimiento, $tipo, $estatus, $archivo_original, $archivo_entregado, $comentarios, $idestado_cuenta, $usuario_creador, $fecha_guardado, $visible){
    return documentos_pagar::create([
      'num_pagare' => $num_pagare,
      'monto' => $monto,
      'fecha_vencimiento' => $fecha_vencimiento,
      'tipo' => $tipo,
      'estatus' => $estatus,
      'archivo_original' => $archivo_original,
      'archivo_entregado' => $archivo_entregado,
      'comentarios' => $comentarios,
      'idestado_cuenta' => $idestado_cuenta,
      'usuario_creador' => $usuario_creador,
      'fecha_guardado' => $fecha_guardado,
      'visible' => $visible
    ]);
  }
  public static function updatePayedDocumentosPagat($iddocumentos_pagar,$idestado_cuenta){
    $documentos_pagar = documentos_pagar::where('iddocumentos_pagar', $iddocumentos_pagar)/*->where('idestado_cuenta', $idestado_cuenta)*/->get(['iddocumentos_pagar','idestado_cuenta','estatus'])->first();
    try {
      if(!empty($documentos_pagar)){
        $documentos_pagar->estatus = 'Pagado';
        $documentos_pagar->saveOrFail();
      }
    } catch (\Exception $e) {
      return $e->getMessage();
    }

    return $documentos_pagar;
    return 'Fail';
  }
}
