<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LiberarSolicitudTallerTrucks;
use App\Models\inventario_trucks;
use App\Models\empleados;

class RevisionReparacionTrucks extends Model
{
    protected $table = 'revision_reparacion_trucks';
    public $timestamps = false;
    protected $fillable = [
      'idsolicitud_taller_trucks', 'desempeño', 'avance',
      'observaciones', 'status', 'usuario_creador',
      'fecha_creacion', 'fecha_guardado'
    ];
    public static function createRevisionReparacionTrucks($idsolicitud_taller_trucks, $desempeño, $avance,
    $observaciones, $status, $usuario_creador, $fecha_creacion, $fecha_guardado){
      return RevisionReparacionTrucks::create([
        'idsolicitud_taller_trucks' => $idsolicitud_taller_trucks,
        'desempeño' => $desempeño,
        'avance' => $avance,
        'observaciones' => $observaciones,
        'status' => $status,
        'usuario_creador' => $usuario_creador,
        'fecha_creacion' => $fecha_creacion,
        'fecha_guardado' => $fecha_guardado
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
