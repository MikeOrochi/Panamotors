<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class beneficiarios_proveedores extends Model
{
  protected $table = 'beneficiarios_proveedores';
  public $timestamps = false;

  protected $fillable = [
    'idbeneficiarios_proveedores', 'nombre', 'numero_cuenta', 'clabe', 'idproveedor', 'visible', 'fecha_creacion', 'fecha_guardado'
  ];

  public static function createBeneficiariosProveedores($nombre, $numero_cuenta, $clabe, $idproveedor, $visible, $fecha_creacion, $fecha_guardado){
    return beneficiarios_proveedores::create([      
      'nombre' => $nombre,
      'numero_cuenta' => $numero_cuenta,
      'clabe' => $clabe,
      'idproveedor' => $idproveedor,
      'visible' => $visible,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado
    ]);
  }
}
