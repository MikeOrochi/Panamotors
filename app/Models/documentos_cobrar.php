<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentos_cobrar extends Model
{
  protected $table = 'documentos_cobrar';
  public $timestamps = false;
  protected $primaryKey = 'iddocumentos_cobrar';

  protected $fillable = [
    'iddocumentos_cobrar', 'num_pagare', 'monto', 'fecha_vencimiento', 'tipo', 'estatus', 'archivo_original', 'archivo_entregado', 'comentarios', 'idestado_cuenta', 'usuario_creador', 'fecha_guardado', 'visible'
  ];

  public static function createDocumentosCobrar($num_pagare, $monto, $fecha_vencimiento, $tipo, $estatus, $archivo_original, $archivo_entregado, $comentarios, $idestado_cuenta, $usuario_creador, $fecha_guardado, $visible){
    return documentos_cobrar::create([
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
  public static function updateSetPagadoDocumentoCobrar($id_document){
    $documentos_cobrar = documentos_cobrar::findOrFail($id_document);
    $documentos_cobrar->estatus = 'Pagado';
    $documentos_cobrar->saveOrFail();
    return $documentos_cobrar;
  }
}
