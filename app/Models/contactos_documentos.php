<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contactos_documentos extends Model
{
  protected $table = 'contactos_documentos';
  public $timestamps = false;
  protected $primaryKey = 'idcontactos_documentos';
  protected $fillable = [
    'idcontactos_documentos', 'documento', 'tipo', 'visible', 'descripcion', 'fecha_creacion',
    'fecha_guardado', 'idcontacto', 'validacion', 'usuario_creador', 'evidencia_validacion'
  ];

  public static function createContactosDocumentos($documento, $tipo, $visible, $descripcion, $fecha_creacion, $fecha_guardado, $idcontacto, $validacion, $usuario_creador, $evidencia_validacion){
    return contactos_documentos::create([
      'documento'=>$documento,
      'tipo'=>$tipo,
      'visible'=>$visible,
      'descripcion'=>$descripcion,
      'fecha_creacion'=>$fecha_creacion,
      'fecha_guardado'=>$fecha_guardado,
      'idcontacto'=>$idcontacto,
      'validacion'=>$validacion,
      'usuario_creador'=>$usuario_creador,
      'evidencia_validacion'=>$evidencia_validacion
    ]);
  }
}
