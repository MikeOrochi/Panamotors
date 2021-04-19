<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class check_list_expediente_original extends Model
{
  protected $table = 'check_list_expediente_original';
  public $timestamps = false;
  protected $primaryKey = 'idcheck_list_expediente_original';

  protected $fillable = [
    'tipo', 'descripcion', 'folio', 'archivo', 'idinventario', 'vin', 'marca', 'version', 'modelo', 'color', 'tipo_unidad', 'tabla_1', 'columna_1', 'columna_2', 'columna_3', 'columna_4', 'columna_5', 'columna_6', 'columna_7', 'columna_8', 'columna_9', 'columna_10', 'comentario', 'idcontacto', 'nombre', 'apellidos', 'alias', 'tipo_contacto', 'idestado_cuenta', 'idatencion_clientes', 'visible', 'usuario_creador', 'fecha_creacion', 'fecha_guardado_archivo', 'fecha_guardado', 'monto', 'tipo_moneda', 'tipo_cambio', 'gran_total', 'tipo_movimiento', 'idorden_compra_unidades', 'tipo_compra', 'area', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'tipo_check_list', 'entrega', 'procedencia', 'orden'
  ];

  public static function createCheckListExpedienteOriginal($tipo, $descripcion, $folio, $archivo, $idinventario, $vin, $marca, $version, $modelo, $color, $tipo_unidad, $tabla_1, $columna_1, $columna_2, $columna_3, $columna_4, $columna_5, $columna_6, $columna_7, $columna_8, $columna_9, $columna_10, $comentario, $idcontacto, $nombre, $apellidos, $alias, $tipo_contacto, $idestado_cuenta, $idatencion_clientes, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado_archivo, $fecha_guardado, $monto, $tipo_moneda, $tipo_cambio, $gran_total, $tipo_movimiento, $idorden_compra_unidades, $tipo_compra, $area, $c1, $c2, $c3, $c4, $c5, $c6, $c7, $c8, $c9, $tipo_check_list, $entrega, $procedencia, $orden){
    return check_list_expediente_original::create([
      'tipo' => $tipo,
      'descripcion' => $descripcion,
      'folio' => $folio,
      'archivo' => $archivo,
      'idinventario' => $idinventario,
      'vin' => $vin,
      'marca' => $marca,
      'version' => $version,
      'modelo' => $modelo,
      'color' => $color,
      'tipo_unidad' => $tipo_unidad,
      'tabla_1' => $tabla_1,
      'columna_1' => $columna_1,
      'columna_2' => $columna_2,
      'columna_3' => $columna_3,
      'columna_4' => $columna_4,
      'columna_5' => $columna_5,
      'columna_6' => $columna_6,
      'columna_7' => $columna_7,
      'columna_8' => $columna_8,
      'columna_9' => $columna_9,
      'columna_10' => $columna_10,
      'comentario' => $comentario,
      'idcontacto' => $idcontacto,
      'nombre' => $nombre,
      'apellidos' => $apellidos,
      'alias' => $alias,
      'tipo_contacto' => $tipo_contacto,
      'idestado_cuenta' => $idestado_cuenta,
      'idatencion_clientes' => $idatencion_clientes,
      'visible' => $visible,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado_archivo' => $fecha_guardado_archivo,
      'fecha_guardado' => $fecha_guardado,
      'monto' => $monto,
      'tipo_moneda' => $tipo_moneda,
      'tipo_cambio' => $tipo_cambio,
      'gran_total' => $gran_total,
      'tipo_movimiento' => $tipo_movimiento,
      'idorden_compra_unidades' => $idorden_compra_unidades,
      'tipo_compra' => $tipo_compra,
      'area' => $area,
      'c1' => $c1,
      'c2' => $c2,
      'c3' => $c3,
      'c4' => $c4,
      'c5' => $c5,
      'c6' => $c6,
      'c7' => $c7,
      'c8' => $c8,
      'c9' => $c9,
      'tipo_check_list' => $tipo_check_list,
      'entrega' => $entrega,
      'procedencia' => $procedencia,
      'orden' => $orden,

  ]);
  }
}
