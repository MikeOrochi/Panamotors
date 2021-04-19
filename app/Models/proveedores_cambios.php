<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class proveedores_cambios extends Model
{
  protected $table = 'proveedores_cambios';
  public $timestamps = false;

  protected $fillable = [
    'idproveedores_cambios', 'descripcion_cambio', 'usuario', 'fecha', 'idproveedores'
  ];

  public static function createProveedoresCambios($idproveedores_cambios, $descripcion_cambio, $usuario, $fecha, $idproveedores){
    return proveedores_cambios::create([
      'idproveedores_cambios' => $idproveedores_cambios,
      'descripcion_cambio' => $descripcion_cambio,
      'usuario' => $usuario,
      'fecha' => $fecha,
      'idproveedores' => $idproveedores,
    ]);
  }
}
