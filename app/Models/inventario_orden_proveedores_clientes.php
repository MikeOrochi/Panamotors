<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_orden_proveedores_clientes extends Model
{
  protected $table = 'inventario_orden_proveedores_clientes';
  public $timestamps = false;

  protected $fillable = [
    'idinventario_orden_proveedores_clientes', 'idorden_compra', 'tipo_inventario', 'idinventario', 'vin', 'fecha_ingreso', 'usuario_creador_inventario', 'fecha_guardado_inventario', 'tipo_identificativo', 'idestado_cuenta', 'usuario_creador_estado_cuenta', 'fecha_guardado_estado_cuenta', 'visible'
  ];

  public static function createInventarioOrdenProveedoresClientes($idinventario_orden_proveedores_clientes, $idorden_compra, $tipo_inventario, $idinventario, $vin, $fecha_ingreso, $usuario_creador_inventario, $fecha_guardado_inventario, $tipo_identificativo, $idestado_cuenta, $usuario_creador_estado_cuenta, $fecha_guardado_estado_cuenta, $visible){
    return inventario_orden_proveedores_clientes::create([
      'idinventario_orden_proveedores_clientes' => $idinventario_orden_proveedores_clientes,
      'idorden_compra' => $idorden_compra,
      'tipo_inventario' => $tipo_inventario,
      'idinventario' => $idinventario,
      'vin' => $vin,
      'fecha_ingreso' => $fecha_ingreso,
      'usuario_creador_inventario' => $usuario_creador_inventario,
      'fecha_guardado_inventario' => $fecha_guardado_inventario,
      'tipo_identificativo' => $tipo_identificativo,
      'idestado_cuenta' => $idestado_cuenta,
      'usuario_creador_estado_cuenta' => $usuario_creador_estado_cuenta,
      'fecha_guardado_estado_cuenta' => $fecha_guardado_estado_cuenta,
      'visible' => $visible,

    ]);
  }
}
