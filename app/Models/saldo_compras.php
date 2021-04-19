<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class saldo_compras extends Model
{
  protected $table = 'saldo_compras';
  public $timestamps = false;

  protected $fillable = [
  'id', 'idestado_cuenta_proveedores', 'idproveedores','concepto', 'cantidad','comentarios', 'visible', 'fecha_creacion', 'fecha_guardado'
  ];


  public static function createCostoImportacion($idestado_cuenta_proveedores, $idproveedores,$concepto, $cantidad,$comentarios, $visible, $fecha_creacion, $fecha_guardado){
    return saldo_compras::create([
      'idestado_cuenta_proveedores' => $idestado_cuenta_proveedores,
      'idproveedores' => $idproveedores,
      'concepto' => $concepto,
      'cantidad' => $cantidad,
      'comentarios' => $comentarios,
      'visible' => $visible,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado
    ]);
  }
}
