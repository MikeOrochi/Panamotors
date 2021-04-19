<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_d_tipos_especificaciones extends Model
{
  protected $table = 'inventario_d_tipos_especificaciones';
  public $timestamps = false;
  protected $primaryKey = 'idinventario_d_tipos_especificaciones';

  protected $fillable = [
    'idinventario_d_tipos_especificaciones','idinventario_dinamico','idtipos_sub_especificaciones_vin','idtipos_especificaciones_vin','usuario_creador','visible','fecha_creacion','fecha_guardado'
  ];

  public static function createInventarioTiposEspecificaciones( $idinventario_dinamico, $idtipos_sub_especificaciones_vin, $idtipos_especificaciones_vin, $usuario_creador, $visible, $fecha_creacion, $fecha_guardado ){
    return inventario_d_tipos_especificaciones::create([
      'idinventario_dinamico'=>$idinventario_dinamico,
      'idtipos_sub_especificaciones_vin'=>$idtipos_sub_especificaciones_vin,
      'idtipos_especificaciones_vin'=>$idtipos_especificaciones_vin,
      'usuario_creador'=>$usuario_creador,
      'visible'=>$visible,
      'fecha_creacion'=>$fecha_creacion,
      'fecha_guardado'=>$fecha_guardado,

    ]);
  }

}
