<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LiberarSolicitudTallerTrucks;
use App\Models\inventario_trucks;
use App\Models\empleados;

class SolicitudTallerTrucksHistorial extends Model
{
    protected $table = 'solicitud_taller_trucks_historial';
    public $timestamps = false;
    protected $fillable = [
      'idinventario_trucks', 'descripcion', 'porcentaje_estetica',
      'descripcion_estetica', 'descripcion_extra', 'combustible',
      'comentarios', 'fecha_ingreso', 'fecha_estimada', 'idempleado',
      'status','prioridad', 'usuario_creador', 'fecha_creacion', 'fecha_guardado',
      'vin','marca','version','modelo','no_orden','avance','color','empleado',
      'compras','dias_trabajo'
    ];
    public static function createSolicitudTallerTrucks($idinventario_trucks, $descripcion, $porcentaje_estetica,
    $descripcion_estetica, $descripcion_extra, $combustible, $comentarios, $fecha_ingreso, $fecha_estimada, $idempleado,
    $status, $prioridad, $usuario_creador, $fecha_creacion, $fecha_guardado){
      return SolicitudTallerTrucksHistorial::create([
        'idinventario_trucks' => $idinventario_trucks,
        'descripcion' => $descripcion,
        'porcentaje_estetica' => $porcentaje_estetica,
        'descripcion_estetica' => $descripcion_estetica,
        'descripcion_extra' => $descripcion_extra,
        'combustible' => $combustible,
        'comentarios' => $comentarios,
        'fecha_ingreso' => $fecha_ingreso,
        'fecha_estimada' => $fecha_estimada,
        'idempleado' => $idempleado,
        'status' => $status,
        'prioridad' => $prioridad,
        'usuario_creador' => $usuario_creador,
        'fecha_creacion' => $fecha_creacion,
        'fecha_guardado' => $fecha_guardado,
        
      ]);
    }
    public static function createSolicitudTallerTrucks2($idinventario_trucks,$vin,$marca,$version,$modelo,$color,$no_orden,$avance, $descripcion, $porcentaje_estetica,
    $descripcion_estetica, $descripcion_extra, $combustible, $comentarios, $fecha_ingreso, $fecha_estimada, $idempleado,
    $status, $prioridad, $usuario_creador, $fecha_creacion, $fecha_guardado,$empleado,$compras,$dias_trabajo){
      return SolicitudTallerTrucksHistorial::create([
        'idinventario_trucks' => $idinventario_trucks,
        'descripcion' => $descripcion,
        'porcentaje_estetica' => $porcentaje_estetica,
        'descripcion_estetica' => $descripcion_estetica,
        'descripcion_extra' => $descripcion_extra,
        'combustible' => $combustible,
        'comentarios' => $comentarios,
        'fecha_ingreso' => $fecha_ingreso,
        'fecha_estimada' => $fecha_estimada,
        'idempleado' => $idempleado,
        'status' => $status,
        'prioridad' => $prioridad,
        'usuario_creador' => $usuario_creador,
        'fecha_creacion' => $fecha_creacion,
        'fecha_guardado' => $fecha_guardado,
        'vin' => $vin,
        'marca' => $marca,
        'version' => $version,
        'modelo' => $modelo,
        'no_orden' => $no_orden,
        'avance' => $avance,
        'color' => $color,
        'empleado' => $empleado,
        'compras' => $compras,
        'dias_trabajo' => $dias_trabajo
      ]);
    }
    public function getDateToFree($id){
      return LiberarSolicitudTallerTrucks::where('id', $id)->get('fecha_salida')->last();
    }
    public function getTruck($idinventario_trucks){
      return inventario_trucks::where('idinventario_trucks', $idinventario_trucks)->get(['vin_numero_serie','marca','modelo','color'])->last();
    }
    public function getEmployee($idempleados){
      $empleado = empleados::where('idempleados', $idempleados)->get(['nombre','apellido_paterno','apellido_paterno'])->last();
      return $empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno;
    }
}
