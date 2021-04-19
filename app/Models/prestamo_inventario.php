<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prestamo_inventario extends Model
{
  protected $table = 'prestamo_inventario';
  public $timestamps = false;
  protected $primaryKey = 'idprestamo_inventario';

  protected $fillable = [
    'idprestamo_inventario','tipo','nombre','usuario_creador','fecha_prestamo','idinventario'
  ];

  public static function createPrestamoInventario( $tipo, $nombre, $usuario_creador, $fecha_prestamo, $idinventario ){
      return prestamo_inventario::create([
          'tipo'=>$tipo,
          'nombre'=>$nombre,
          'usuario_creador'=>$usuario_creador,
          'fecha_prestamo'=>$fecha_prestamo,
          'idinventario'=>$idinventario,
      ]);
  }

}
