<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentos_contacto_cambios extends Model
{
  protected $table = 'documentos_contacto_cambios';
  public $timestamps = false;
  protected $primaryKey = 'iddocumentos_contacto_cambios';
  protected $fillable = [
    'iddocumentos_contacto_cambios', 'descripcion', 'usuario', 'fecha', 'idcontacto'
  ];

  public static function createContactosDocumentosCambios($descripcion, $usuario, $fecha, $idcontacto){
    return documentos_contacto_cambios::create([
      'descripcion' => $descripcion,
      'usuario' => $usuario,
      'fecha' => $fecha,
      'idcontacto' => $idcontacto
    ]);
  }
}
