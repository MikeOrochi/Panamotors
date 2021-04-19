<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\inventario_trucks;
use App\Models\empleados;

class LiberarSolicitudTallerTrucks extends Model
{
    protected $table = 'liberar_solicitud_taller_trucks';
    public $timestamps = false;
    protected $fillable = [
      'idsolicitud_taller_trucks', 'descripcion','porcentaje_estetica',
      'descripcion_estetica','descripcion_extra', 'combustible','comentarios',
      'fecha_salida', 'status', 'usuario_creador', 'fecha_creacion', 'fecha_guardado'
    ];
    public static function createSolicitudTallerTrucks($idsolicitud_taller_trucks, $descripcion,$porcentaje_estetica,
    $descripcion_estetica,$descripcion_extra, $combustible,$comentarios,
    $fecha_salida, $status, $usuario_creador, $fecha_creacion, $fecha_guardado){
      return LiberarSolicitudTallerTrucks::create([
        'idsolicitud_taller_trucks' => $idsolicitud_taller_trucks,
        'descripcion' => $descripcion,
        'porcentaje_estetica' => $porcentaje_estetica,
        'descripcion_estetica' => $descripcion_estetica,
        'descripcion_extra' => $descripcion_extra,
        'combustible' => $combustible,
        'comentarios' => $comentarios,
        'fecha_salida' => $fecha_salida,
        'status' => $status,
        'usuario_creador' => $usuario_creador,
        'fecha_creacion' => $fecha_creacion,
        'fecha_guardado' => $fecha_guardado
      ]);
    }

    public function getTruck($idinventario_trucks){
      return inventario_trucks::where('idinventario_trucks', $idinventario_trucks)->get(['vin_numero_serie','marca','modelo','color'])->last();
    }
    public function getEmployee($idempleados){
      $empleado = empleados::where('idempleados', $idempleados)->get(['nombre','apellido_paterno','apellido_paterno'])->last();
      return $empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno;
    }
}
