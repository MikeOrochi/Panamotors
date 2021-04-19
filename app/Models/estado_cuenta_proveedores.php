<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estado_cuenta_proveedores extends Model
{
  protected $table = 'estado_cuenta_proveedores';
  public $timestamps = false;
  protected $primaryKey = 'idestado_cuenta_proveedores';

  protected $fillable = [
    'idestado_cuenta_proveedores', 'concepto', 'apartado_usado', 'tipo_movimiento', 'efecto_movimiento', 'fecha_movimiento', 'metodo_pago', 'saldo_anterior', 'saldo', 'monto_precio', 'serie_monto', 'monto_total', 'tipo_moneda', 'tipo_cambio', 'gran_total', 'cargo', 'abono', 'emisora_institucion', 'emisora_agente', 'receptora_institucion', 'receptora_agente', 'tipo_comprobante', 'referencia', 'datos_marca', 'datos_version', 'datos_color', 'datos_modelo', 'datos_vin', 'datos_precio', 'datos_estatus', 'asesor1', 'enlace1', 'asesor2', 'enlace2', 'coach', 'archivo', 'comentarios', 'idcontacto', 'comision', 'visible', 'comentarios_eliminacion', 'usuario_elimino', 'fecha_eliminacion', 'usuario_creador', 'fecha_creacion', 'fecha_guardado', 'col1', 'col2', 'col3', 'col4', 'col5', 'col6', 'col7', 'col8', 'col9', 'col10'
  ];

  public static function createEstadoCuentaProveedores($concepto, $apartado_usado, $tipo_movimiento, $efecto_movimiento, $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio, $serie_monto, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $datos_marca, $datos_version, $datos_color, $datos_modelo, $datos_vin, $datos_precio, $datos_estatus, $asesor1, $enlace1, $asesor2, $enlace2, $coach, $archivo, $comentarios, $idcontacto, $comision, $visible, $comentarios_eliminacion, $usuario_elimino, $fecha_eliminacion, $usuario_creador, $fecha_creacion, $fecha_guardado, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10){
    return estado_cuenta_proveedores::create([
      'concepto' => $concepto,
      'apartado_usado' => $apartado_usado,
      'tipo_movimiento' => $tipo_movimiento,
      'efecto_movimiento' => $efecto_movimiento,
      'fecha_movimiento' => $fecha_movimiento,
      'metodo_pago' => $metodo_pago,
      'saldo_anterior' => $saldo_anterior,
      'saldo' => $saldo,
      'monto_precio' => $monto_precio,
      'serie_monto' => $serie_monto,
      'monto_total' => $monto_total,
      'tipo_moneda' => $tipo_moneda,
      'tipo_cambio' => $tipo_cambio,
      'gran_total' => $gran_total,
      'cargo' => $cargo,
      'abono' => $abono,
      'emisora_institucion' => $emisora_institucion,
      'emisora_agente' => $emisora_agente,
      'receptora_institucion' => $receptora_institucion,
      'receptora_agente' => $receptora_agente,
      'tipo_comprobante' => $tipo_comprobante,
      'referencia' => $referencia,
      'datos_marca' => $datos_marca,
      'datos_version' => $datos_version,
      'datos_color' => $datos_color,
      'datos_modelo' => $datos_modelo,
      'datos_vin' => $datos_vin,
      'datos_precio' => $datos_precio,
      'datos_estatus' => $datos_estatus,
      'asesor1' => $asesor1,
      'enlace1' => $enlace1,
      'asesor2' => $asesor2,
      'enlace2' => $enlace2,
      'coach' => $coach,
      'archivo' => $archivo,
      'comentarios' => $comentarios,
      'idcontacto' => $idcontacto,
      'comision' => $comision,
      'visible' => $visible,
      'comentarios_eliminacion' => $comentarios_eliminacion,
      'usuario_elimino' => $usuario_elimino,
      'fecha_eliminacion' => $fecha_eliminacion,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'col1' => $col1,
      'col2' => $col2,
      'col3' => $col3,
      'col4' => $col4,
      'col5' => $col5,
      'col6' => $col6,
      'col7' => $col7,
      'col8' => $col8,
      'col9' => $col9,
      'col10' => $col10,

    ]);
  }
  public function searchUser(){
    return usuarios::where('idusuario',$this->usuario_creador)->get()->first();
  }
  public function searchDocumentosPagar(){
    return documentos_pagar::where('idestado_cuenta',$this->idestado_cuenta_proveedores)->where('visible','SI')->get()->first();
  }
  public function searchRecibosProveedores(){
    return recibos_proveedores::where('id_estado_cuenta',$this->idestado_cuenta_proveedores)->get()->first();
  }
  public static function getSaldo($id_contact){
    $count_state_add = estado_cuenta_proveedores::get()->where('idcontacto', $id_contact)->where('efecto_movimiento', 'suma')->where('visible', 'SI')->sum('monto_precio');
    $count_state_sub = estado_cuenta_proveedores::get()->where('idcontacto', $id_contact)->where('efecto_movimiento', 'resta')->where('visible', 'SI')->sum('monto_precio');
    $saldo = $count_state_add - $count_state_sub;
    return $saldo;
  }
  public static function stateOfDevolution($provider,$total_pesos){
    $no_movementes = estado_cuenta_proveedores::where('idcontacto', $provider)
    ->where('datos_precio', $total_pesos)
    ->where('datos_estatus', 'Pendiente')
    ->whereIn('concepto', ['Devolución del VIN', 'Devolucion del VIN'])
    ->count();
    return $no_movementes;
  }
  public static function getStateAccountPendient($provider,$total_pesos){
    $no_movementes = estado_cuenta_proveedores::where('idcontacto', $provider)
    ->where('datos_precio', $total_pesos)
    ->where('datos_estatus', 'Pendiente')
    ->whereIn('concepto', ['Devolución del VIN', 'Devolucion del VIN'])
    ->count();
    if ($no_movementes == 0) {
      return ['idestado_cuenta_proveedores' => '',
      'idcontacto'=>$provider,
      'datos_estatus'=>'',
      'datos_precio' => '',
      'concepto' => 'Traspaso',
      'datos_vin' => '',
      'datos_marca' => '',
      'datos_modelo' => '',
      'datos_color' => '',
      'datos_version' => '',
      'fecha_movimiento' => ''
    ];
  }else {
    return estado_cuenta_proveedores::where('idcontacto', $provider)
    ->where('datos_precio', $total_pesos)
    ->where('datos_estatus', 'Pendiente')
    ->whereIn('concepto', ['Devolución del VIN', 'Devolucion del VIN'])
    ->orderBy('fecha_movimiento', 'asc')
    ->get(['idestado_cuenta_proveedores','idcontacto','datos_estatus','datos_precio','concepto','datos_vin','datos_marca','datos_modelo','datos_color','datos_version','fecha_movimiento'])
    ->last();
  }
}
public static function updateStateAccountProviders($idcontacto, $idestado_cuenta_proveedores,$folio,$folio_anterior){
  $estado_cuenta_proveedores = estado_cuenta_proveedores::where('idcontacto', $idcontacto)->where('visible','SI')->where('idestado_cuenta_proveedores', $idestado_cuenta_proveedores)->get(['idestado_cuenta_proveedores', 'datos_precio', 'col1', 'col2'])->first();
  $estado_cuenta_proveedores->col1 = $folio;
  $estado_cuenta_proveedores->col2 = $folio_anterior;
  $estado_cuenta_proveedores->saveOrFail();
  return $estado_cuenta_proveedores;
}
public static function updatePayedStateAccountProviders($idestado_cuenta_proveedores){
  $estado_cuenta_proveedores = estado_cuenta_proveedores::where('idestado_cuenta_proveedores', $idestado_cuenta_proveedores)->get(['idestado_cuenta_proveedores', 'datos_estatus'])->first();
  $estado_cuenta_proveedores->datos_estatus = 'Pagada';
  $estado_cuenta_proveedores->saveOrFail();
  return $estado_cuenta_proveedores;
}
}
