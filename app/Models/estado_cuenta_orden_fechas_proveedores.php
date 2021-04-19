<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class estado_cuenta_orden_fechas_proveedores extends Model
{
  protected $table = 'estado_cuenta_orden_fechas_proveedores';
  public $timestamps = false;

  protected $fillable = [
    'idestado_cuenta_orden_fechas_proveedores', 'concepto', 'apartado_usado', 'tipo_movimiento', 'efecto_movimiento', 'fecha_movimiento', 'metodo_pago', 'saldo_anterior', 'saldo', 'monto_precio', 'serie_monto', 'monto_total', 'tipo_moneda', 'tipo_cambio', 'gran_total', 'cargo', 'abono', 'emisora_institucion', 'emisora_agente', 'receptora_institucion', 'receptora_agente', 'tipo_comprobante', 'referencia', 'datos_marca', 'datos_version', 'datos_color', 'datos_modelo', 'datos_vin', 'datos_precio', 'datos_estatus', 'asesor1', 'enlace1', 'asesor2', 'enlace2', 'coach', 'archivo', 'comentarios', 'idcontacto', 'comision', 'visible', 'comentarios_eliminacion', 'usuario_elimino', 'fecha_eliminacion', 'usuario_creador', 'fecha_creacion', 'fecha_guardado', 'orden'
  ];

  public static function createEstadoCuentaOrdenFechasProveedores($idestado_cuenta_orden_fechas_proveedores, $concepto, $apartado_usado, $tipo_movimiento, $efecto_movimiento, $fecha_movimiento, $metodo_pago, $saldo_anterior, $saldo, $monto_precio, $serie_monto, $monto_total, $tipo_moneda, $tipo_cambio, $gran_total, $cargo, $abono, $emisora_institucion, $emisora_agente, $receptora_institucion, $receptora_agente, $tipo_comprobante, $referencia, $datos_marca, $datos_version, $datos_color, $datos_modelo, $datos_vin, $datos_precio, $datos_estatus, $asesor1, $enlace1, $asesor2, $enlace2, $coach, $archivo, $comentarios, $idcontacto, $comision, $visible, $comentarios_eliminacion, $usuario_elimino, $fecha_eliminacion, $usuario_creador, $fecha_creacion, $fecha_guardado, $orden){
    return estado_cuenta_orden_fechas_proveedores::create([
      'idestado_cuenta_orden_fechas_proveedores' => $idestado_cuenta_orden_fechas_proveedores,
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
      // 'visible' => $visible,
      'visible' => 'Si',
      'comentarios_eliminacion' => $comentarios_eliminacion,
      'usuario_elimino' => $usuario_elimino,
      'fecha_eliminacion' => $fecha_eliminacion,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'orden' => $orden,

    ]);
  }
  public static function fillReportAccountStatusProviderInternal($id_proveedor){
     $count_orden=1;
     $estado_cuenta_proveedores = estado_cuenta_proveedores::where('idcontacto',$id_proveedor)->where('visible','SI')->orderBy('fecha_movimiento','ASC')->get();
     foreach($estado_cuenta_proveedores as $value) {

       if($value->concepto=='Compra Directa' || $value->concepto=='Cuenta de Deuda' || $value->concepto=='Compra Permuta' || $value->concepto=='Devolución del VIN' || $value->concepto=='Consignación'  || $value->concepto=='Devolucion del VIN' || $value->concepto=='Consignacion'){
         estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores(
          $value->idestado_cuenta_proveedores, $value->concepto,  $value->apartado_usado,  $value->tipo_movimiento,  $value->efecto_movimiento,
          $value->fecha_movimiento,  $value->metodo_pago,  $value->saldo_anterior,  $value->saldo,  $value->monto_precio,
          $value->serie_monto,  $value->monto_total,  $value->tipo_moneda,  $value->tipo_cambio,  $value->gran_total,
          $value->cargo,  $value->abono,  $value->emisora_institucion,  $value->emisora_agente,  $value->receptora_institucion,
          $value->receptora_agente,  $value->tipo_comprobante,  $value->referencia,  $value->datos_marca,  $value->datos_version,
          $value->datos_color,  $value->datos_modelo,  $value->datos_vin,  $value->datos_precio,  $value->datos_estatus,
          $value->asesor1,  $value->enlace1,  $value->asesor2,  $value->enlace2,  $value->coach,
          $value->archivo,  $value->comentarios,  $value->idcontacto,  $value->comision,  $value->visible,
          $value->comentarios_eliminacion,  $value->usuario_elimino,  '0001-01-01 00:00:00',  $value->usuario_creador,  $value->fecha_creacion,
          $value->fecha_guardado, $count_orden );
          $count_orden++;
       }
       else{
          if($value->concepto=='Abono'){
          $abonos_unidades_proveedores=abonos_unidades_proveedores::where('idestado_cuenta_movimiento',$value->idestado_cuenta_proveedores)->where('visible','SI')->get();
              if(count($abonos_unidades_proveedores)<=1){
             estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores(
               $value->idestado_cuenta_proveedores, $value->concepto,  $value->apartado_usado,  $value->tipo_movimiento,  $value->efecto_movimiento,
               $value->fecha_movimiento,  $value->metodo_pago,  $value->saldo_anterior,  $value->saldo,  $value->monto_precio,
               $value->serie_monto,  $value->monto_total,  $value->tipo_moneda,  $value->tipo_cambio,  $value->gran_total,
               $value->cargo,  $value->abono,  $value->emisora_institucion,  $value->emisora_agente,  $value->receptora_institucion,
               $value->receptora_agente,  $value->tipo_comprobante,  $value->referencia,  $value->datos_marca,  $value->datos_version,
               $value->datos_color,  $value->datos_modelo,  $value->datos_vin,  $value->datos_precio,  $value->datos_estatus,
               $value->asesor1,  $value->enlace1,  $value->asesor2,  $value->enlace2,  $value->coach,
               $value->archivo,  $value->comentarios,  $value->idcontacto,  $value->comision,  $value->visible,
               $value->comentarios_eliminacion,  $value->usuario_elimino,  '0001-01-01 00:00:00',  $value->usuario_creador,  $value->fecha_creacion,
               $value->fecha_guardado, $count_orden );
                 $count_orden++;
              }else{
                 $last_idestado_cuenta_movimiento = 0;
                 foreach ($abonos_unidades_proveedores as $abono_u_p){
                    try {
                       // if($abono_u_p->idestado_cuenta_movimiento != $last_idestado_cuenta_movimiento){
                          estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores($value['idestado_cuenta_proveedores'], $value['concepto'],  $value['apartado_usado'],  $value['tipo_movimiento'],  $value['efecto_movimiento'],
                          $value['fecha_movimiento'],  $value['metodo_pago'],  $abono_u_p['cantidad_inicial'],  $abono_u_p['cantidad_pendiente'],  $abono_u_p['cantidad_pago'],
                          $value['serie_monto'],  $value['monto_total'],  $value['tipo_moneda'],  $value['tipo_cambio'],  $value['gran_total'],
                          $value['cargo'],  $value['abono'],  $value['emisora_institucion'],  $value['emisora_agente'],  $value['receptora_institucion'],
                          $value['receptora_agente'],  $value['tipo_comprobante'],  $value['referencia'],  $value['datos_marca'],  $value['datos_version'],
                          $value['datos_color'],  $value['datos_modelo'],  $value['datos_vin'],  $value['datos_precio'],  $value['datos_estatus'],
                          $value['asesor1'],  $value['enlace1'],  $value['asesor2'],  $value['enlace2'],  $value['coach'],
                          $value['archivo'],  $value['comentarios'],  $value['idcontacto'],  $value['comision'],  $value['visible'],
                          $value['comentarios_eliminacion'],  $value['usuario_elimino'],  '0001-01-01 00:00:00',  $value['usuario_creador'],  $value['fecha_creacion'],
                          $value['fecha_guardado'], $count_orden );
                          $count_orden++;
                       // }
                    } catch (\Exception $e) {
                       dd($e->getMessage(),$abonos_unidades_proveedores,$abono_u_p);
                    }
                    $last_idestado_cuenta_movimiento = $abono_u_p->idestado_cuenta_movimiento;
                 }

              }
          }
       }
     }
     return $count_orden;
  }

  public static function fillReportAccountStatusProvider($id_contacto){
    $count_orden = 0;
    $estado_cuenta_proveedores = estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->orderBy('fecha_movimiento','ASC')->orderBy('fecha_guardado','ASC')->get();
    foreach($estado_cuenta_proveedores as $value) {
      $count_orden++;

      if ($value->concepto == 'Compra Permuta' && $count_orden == 1) {
          $result101x1 = estado_cuenta_proveedores::where('idcontacto',$id_contacto)->where('visible','SI')->where('concepto','Venta Permuta')->orderBy('fecha_movimiento','ASC')->take(1);
          foreach($result101x1 as $value_account) {
          estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores(
            $value_account->idestado_cuenta_proveedores, $value_account->concepto,  $value_account->apartado_usado,  $value_account->tipo_movimiento,  $value_account->efecto_movimiento,
            $value_account->fecha_movimiento,  $value_account->metodo_pago,  $value_account->saldo_anterior,  $value_account->saldo,  $value_account->monto_precio,
            $value_account->serie_monto,  $value_account->monto_total,  $value_account->tipo_moneda,  $value_account->tipo_cambio,  $value_account->gran_total,
            $value_account->cargo,  $value_account->abono,  $value_account->emisora_institucion,  $value_account->emisora_agente,  $value_account->receptora_institucion,
            $value_account->receptora_agente,  $value_account->tipo_comprobante,  $value_account->referencia,  $value_account->datos_marca,  $value_account->datos_version,
            $value_account->datos_color,  $value_account->datos_modelo,  $value_account->datos_vin,  $value_account->datos_precio,  $value_account->datos_estatus,
            $value_account->asesor1,  $value_account->enlace1,  $value_account->asesor2,  $value_account->enlace2,  $value_account->coach,
            $value_account->archivo,  $value_account->comentarios,  $value_account->idcontacto,  $value_account->comision,  $value_account->visible,
            $value_account->comentarios_eliminacion,  $value_account->usuario_elimino,  '0001-01-01 00:00:00',  $value_account->usuario_creador,  $value_account->fecha_creacion,
            $value_account->fecha_guardado, $count_orden );
          }
          $count_orden++;
        estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores(
          $value->idestado_cuenta_proveedores, $value->concepto,  $value->apartado_usado,  $value->tipo_movimiento,  $value->efecto_movimiento,
          $value->fecha_movimiento,  $value->metodo_pago,  $value->saldo_anterior,  $value->saldo,  $value->monto_precio,
          $value->serie_monto,  $value->monto_total,  $value->tipo_moneda,  $value->tipo_cambio,  $value->gran_total,
          $value->cargo,  $value->abono,  $value->emisora_institucion,  $value->emisora_agente,  $value->receptora_institucion,
          $value->receptora_agente,  $value->tipo_comprobante,  $value->referencia,  $value->datos_marca,  $value->datos_version,
          $value->datos_color,  $value->datos_modelo,  $value->datos_vin,  $value->datos_precio,  $value->datos_estatus,
          $value->asesor1,  $value->enlace1,  $value->asesor2,  $value->enlace2,  $value->coach,
          $value->archivo,  $value->comentarios,  $value->idcontacto,  $value->comision,  $value->visible,
          $value->comentarios_eliminacion,  $value->usuario_elimino,  '0001-01-01 00:00:00',  $value->usuario_creador,  $value->fecha_creacion,
          $value->fecha_guardado, $count_orden );
      }else{
        estado_cuenta_orden_fechas_proveedores::createEstadoCuentaOrdenFechasProveedores(
          $value->idestado_cuenta_proveedores, $value->concepto,  $value->apartado_usado,  $value->tipo_movimiento,  $value->efecto_movimiento,
          $value->fecha_movimiento,  $value->metodo_pago,  $value->saldo_anterior,  $value->saldo,  $value->monto_precio,
          $value->serie_monto,  $value->monto_total,  $value->tipo_moneda,  $value->tipo_cambio,  $value->gran_total,
          $value->cargo,  $value->abono,  $value->emisora_institucion,  $value->emisora_agente,  $value->receptora_institucion,
          $value->receptora_agente,  $value->tipo_comprobante,  $value->referencia,  $value->datos_marca,  $value->datos_version,
          $value->datos_color,  $value->datos_modelo,  $value->datos_vin,  $value->datos_precio,  $value->datos_estatus,
          $value->asesor1,  $value->enlace1,  $value->asesor2,  $value->enlace2,  $value->coach,
          $value->archivo,  $value->comentarios,  $value->idcontacto,  $value->comision,  $value->visible,
          $value->comentarios_eliminacion,  $value->usuario_elimino,  '0001-01-01 00:00:00',  $value->usuario_creador,  $value->fecha_creacion,
          $value->fecha_guardado, $count_orden );
      }
    }
    return $count_orden;
  }
}
