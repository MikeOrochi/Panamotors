<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class costo_importacion extends Model
{
  protected $table = 'costo_importacion';
  public $timestamps = false;

  protected $fillable = [
  'id', 'idestado_cuenta_proveedores', 'idproveedores', 'cantidad', 'visible', 'fecha_creacion', 'fecha_guardado'
  ];

  public static function createCostoImportacion($idestado_cuenta_proveedores, $idproveedores, $cantidad, $visible, $fecha_creacion, $fecha_guardado){
    return costo_importacion::create([
      'idestado_cuenta_proveedores' => $idestado_cuenta_proveedores,
      'idproveedores' => $idproveedores,
      'cantidad' => $cantidad,
      'visible' => $visible,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado
    ]);
  }
}
