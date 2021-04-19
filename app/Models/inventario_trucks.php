<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_trucks extends Model
{
  protected $table = 'inventario_trucks';
  public $timestamps = false;
  protected $primaryKey = 'idinventario_trucks';

  protected $fillable = [
    'idinventario_trucks', 'folio', 'marca', 'submarca', 'version', 'color', 'modelo', 'precio_piso', 'precio_digital', 'transmision', 'vin_numero_serie', 'procedencia', 'matricula', 'entidad', 'fecha_apertura', 'fecha_ingreso', 'fecha_ingreso_taller', 'fecha_salida_piso', 'razon_social_ingreso', 'tipo_impuesto', 'tipo_venta', 'kilometraje', 'segmentacion', 'estatus_unidad', 'ubicacion', 'descripcion_diferenciales', 'estatus_expediente_original', 'estatus_seguro', 'comentarios', 'mercadolibre', 'publicado', 'consignacion', 'visible', 'usuario_creador', 'fecha_creacion', 'fecha_guardado'
  ];

  public static function createInventarioTrucks($idinventario_trucks, $folio, $marca, $submarca, $version, $color, $modelo, $precio_piso, $precio_digital, $transmision, $vin_numero_serie, $procedencia, $matricula, $entidad, $fecha_apertura, $fecha_ingreso, $fecha_ingreso_taller, $fecha_salida_piso, $razon_social_ingreso, $tipo_impuesto, $tipo_venta, $kilometraje, $segmentacion, $estatus_unidad, $ubicacion, $descripcion_diferenciales, $estatus_expediente_original, $estatus_seguro, $comentarios, $mercadolibre, $publicado, $consignacion, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado){
    return inventario_trucks::create([
      'idinventario_trucks' => $idinventario_trucks,
      'folio' => $folio,
      'marca' => $marca,
      'submarca' => $submarca,
      'version' => $version,
      'color' => $color,
      'modelo' => $modelo,
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
      'descripcion_diferenciales' => $descripcion_diferenciales,
      'estatus_expediente_original' => $estatus_expediente_original,
      'estatus_seguro' => $estatus_seguro,
      'comentarios' => $comentarios,
      'mercadolibre' => $mercadolibre,
      'publicado' => $publicado,
      'consignacion' => $consignacion,
      'visible' => $visible,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,

    ]);
  }
}
