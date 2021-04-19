<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class atencion_clientes extends Model
{
  protected $table = 'atencion_clientes';
  public $timestamps = false;
  protected $primaryKey = 'idatencion_clientes';

  protected $fillable = [
      'tipo', 'estatus', 'asignacion', 'responsable', 'fuente_informacion', 'master', 'comentarios', 'caso', 'accion', 'idcontacto', 'idestado_cuenta',
      'idusuario', 'idtipo_orden', 'usuario_cerro', 'fecha_estimada_solucion', 'fecha_real_solucion', 'visible', 'fecha_creacion', 'fecha_guardado',
      'precio', 'paga', 'tipo_movimiento', 'efecto_movimiento', 'fecha_movimiento', 'metodo_pago', 'monto_precio', 'tipo_moneda', 'tipo_cambio',
      'emisora_institucion', 'emisora_agente', 'receptora_institucion', 'receptora_agente', 'tipo_comprobante', 'no_comprobante', 'datos_vin',
      'archivo', 'comentarios_cotizacion', 'auxiliar', 'paga_cliente_v3', 'idcontacto_estado_cuenta_v3', 'paga_panamotors_v3', 'paga_ambos_v3',
      'paga_terceros_v3', 'monto_precio_cliente_v3', 'monto_precio_panamotors_v3', 'monto_precio_terceros_v3', 'proveedor_cliente'
  ];

  public static function createAtencionClientes($tipo, $estatus, $asignacion, $responsable, $fuente_informacion, $master,
    $comentarios, $caso, $accion, $idcontacto, $idestado_cuenta, $idusuario, $idtipo_orden, $usuario_cerro, $fecha_estimada_solucion,
    $fecha_real_solucion, $visible, $fecha_creacion, $fecha_guardado, $precio, $paga, $tipo_movimiento, $efecto_movimiento, $fecha_movimiento,
    $metodo_pago, $monto_precio, $tipo_moneda, $tipo_cambio, $emisora_institucion, $emisora_agente, $receptora_institucion,
    $receptora_agente, $tipo_comprobante, $no_comprobante, $datos_vin, $archivo, $comentarios_cotizacion, $auxiliar, $paga_cliente_v3,
    $idcontacto_estado_cuenta_v3, $paga_panamotors_v3, $paga_ambos_v3, $paga_terceros_v3, $monto_precio_cliente_v3, $monto_precio_panamotors_v3,
    $monto_precio_terceros_v3, $proveedor_cliente){
    return atencion_clientes::create([
      'tipo'=>$tipo,
      'estatus'=>$estatus,
      'asignacion'=>$asignacion,
      'responsable'=>$responsable,
      'fuente_informacion'=>$fuente_informacion,
      'master'=>$master,
      'comentarios'=>$comentarios,
      'caso'=>$caso,
      'accion'=>$accion,
      'idcontacto'=>$idcontacto,
      'idestado_cuenta'=>$idestado_cuenta,
      'idusuario'=>$idusuario,
      'idtipo_orden'=>$idtipo_orden,
      'usuario_cerro'=>$usuario_cerro,
      'fecha_estimada_solucion'=>$fecha_estimada_solucion,
      'fecha_real_solucion'=>$fecha_real_solucion,
      'visible'=>$visible,
      'fecha_creacion'=>$fecha_creacion,
      'fecha_guardado'=>$fecha_guardado,
      'precio'=>$precio,
      'paga'=>$paga,
      'tipo_movimiento'=>$tipo_movimiento,
      'efecto_movimiento'=>$efecto_movimiento,
      'fecha_movimiento'=>$fecha_movimiento,
      'metodo_pago'=>$metodo_pago,
      'monto_precio'=>$monto_precio,
      'tipo_moneda'=>$tipo_moneda,
      'tipo_cambio'=>$tipo_cambio,
      'emisora_institucion'=>$emisora_institucion,
      'emisora_agente'=>$emisora_agente,
      'receptora_institucion'=>$receptora_institucion,
      'receptora_agente'=>$receptora_agente,
      'tipo_comprobante'=>$tipo_comprobante,
      'no_comprobante'=>$no_comprobante,
      'datos_vin'=>$datos_vin,
      'archivo'=>$archivo,
      'comentarios_cotizacion'=>$comentarios_cotizacion,
      'auxiliar'=>$auxiliar,
      'paga_cliente_v3'=>$paga_cliente_v3,
      'idcontacto_estado_cuenta_v3'=>$idcontacto_estado_cuenta_v3,
      'paga_panamotors_v3'=>$paga_panamotors_v3,
      'paga_ambos_v3'=>$paga_ambos_v3,
      'paga_terceros_v3'=>$paga_terceros_v3,
      'monto_precio_cliente_v3'=>$monto_precio_cliente_v3,
      'monto_precio_panamotors_v3'=>$monto_precio_panamotors_v3,
      'monto_precio_terceros_v3'=>$monto_precio_terceros_v3,
      'proveedor_cliente'=>$proveedor_cliente,

    ]);
  }
}
