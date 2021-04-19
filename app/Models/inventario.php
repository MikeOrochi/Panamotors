<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario extends Model
{
  protected $table = 'inventario';
  public $timestamps = false;
  protected $primaryKey = 'idinventario';

  protected $fillable = [
    'idinventario', 'folio', 'marca', 'modelo', 'version', 'color', 'anio', 'precio_piso', 'precio_digital', 'transmision', 'vin_numero_serie', 'procedencia', 'matricula', 'entidad', 'fecha_apertura', 'fecha_ingreso', 'fecha_ingreso_taller', 'fecha_salida_piso', 'razon_social_ingreso', 'tipo_impuesto', 'tipo_venta', 'kilometraje', 'segmentacion', 'estatus_unidad', 'ubicacion', 'comentarios', 'mercadolibre', 'publicado', 'consignacion', 'visible', 'usuario_creador', 'fecha_creacion', 'fecha_guardado', 'segmento', 'tipo'
  ];

  public static function createInventario($folio, $marca, $modelo, $version, $color, $anio, $precio_piso, $precio_digital, $transmision, $vin_numero_serie, $procedencia, $matricula, $entidad, $fecha_apertura, $fecha_ingreso, $fecha_ingreso_taller, $fecha_salida_piso, $razon_social_ingreso, $tipo_impuesto, $tipo_venta, $kilometraje, $segmentacion, $estatus_unidad, $ubicacion, $comentarios, $mercadolibre, $publicado, $consignacion, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $segmento, $tipo){
    return inventario::create([
      'folio' => $folio,
      'marca' => $marca,
      'modelo' => $modelo,
      'version' => $version,
      'color' => $color,
      'anio' => $anio,
      'precio_piso' => $precio_piso,
      'precio_digital' => $precio_digital,
      'transmision' => $transmision,
      'vin_numero_serie' => $vin_numero_serie,
      'procedencia' => $procedencia,
      'matricula' => $matricula,
      'entidad' => $entidad,
      'fecha_apertura' => $fecha_apertura,
      'fecha_ingreso' => $fecha_ingreso,
      'fecha_ingreso_taller' => $fecha_ingreso_taller,
      'fecha_salida_piso' => $fecha_salida_piso,
      'razon_social_ingreso' => $razon_social_ingreso,
      'tipo_impuesto' => $tipo_impuesto,
      'tipo_venta' => $tipo_venta,
      'kilometraje' => $kilometraje,
      'segmentacion' => $segmentacion,
      'estatus_unidad' => $estatus_unidad,
      'ubicacion' => $ubicacion,
      'comentarios' => $comentarios,
      'mercadolibre' => $mercadolibre,
      'publicado' => $publicado,
      'consignacion' => $consignacion,
      'visible' => $visible,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'segmento' => $segmento,
      'tipo' => $tipo
    ]);
  }
}
