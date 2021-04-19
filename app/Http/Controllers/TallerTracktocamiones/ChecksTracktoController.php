<?php

namespace App\Http\Controllers\TallerTracktocamiones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\LiberarSolicitudTallerTrucks;
use App\Models\RevisionReparacionTrucks;
use App\Models\SolicitudPiezasTrucks;
use App\Models\SolicitudTallerTrucks;
use App\Models\inventario_trucks;
use App\Models\inventario;
use App\Models\empleados;

class ChecksTracktoController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  public function index(){
    $solicitud_taller_trucks = SolicitudTallerTrucks::where('status', 'taller')->get(['id','idinventario_trucks','idempleado','descripcion','fecha_estimada']);
    $solicitud_taller_trucks_validando = SolicitudTallerTrucks::where('status', 'validando')->get(['id','idinventario_trucks','idempleado','descripcion','fecha_estimada']);
    $solicitud_taller_trucks_liberado = SolicitudTallerTrucks::where('status', 'liberado')->get(['id','idinventario_trucks','idempleado','descripcion','fecha_estimada']);
    // return $solicitud_taller_trucks;
    return view('TallerTracktocamiones.salidas.index', compact('solicitud_taller_trucks','solicitud_taller_trucks_validando','solicitud_taller_trucks_liberado'));
  }
  public function new($id){
    $id = Crypt::decrypt($id);
    $solicitud_taller_trucks = SolicitudTallerTrucks::where('id', $id)
    ->get(['id','idinventario_trucks','descripcion','fecha_estimada','idempleado','prioridad'])->last();
    $inventario_trucks = inventario_trucks::where('idinventario_trucks', $solicitud_taller_trucks->idinventario_trucks)
    ->get(['vin_numero_serie','marca','version','color','modelo'])
    ->last();
    $empleados = empleados::where('idempleados', $solicitud_taller_trucks->idempleado)
    ->get(['idempleados','nombre','apellido_paterno','apellido_materno'])
    ->last();
    $solicitud_piezas_trucks = SolicitudPiezasTrucks::where('idsolicitud_taller_trucks', $solicitud_taller_trucks->id)
    ->get(['concepto']);
    $revision_reparacion_trucks = RevisionReparacionTrucks::where('idsolicitud_taller_trucks', $solicitud_taller_trucks->id)
    ->orderBy('id','desc')
    ->get(['desempeño','avance','observaciones','fecha_guardado']);
    if ($revision_reparacion_trucks->count()>0) {
      $desempeno = (($revision_reparacion_trucks->sum('desempeño') / $revision_reparacion_trucks->count())*100)/4;
    }else { $desempeno = 0; }
    // return $revision_reparacion_trucks;
    // return $solicitud_taller_trucks;
    return view('TallerTracktocamiones.revisiones.new', compact(
      'solicitud_taller_trucks','inventario_trucks','empleados',
      'solicitud_piezas_trucks','revision_reparacion_trucks',
      'desempeno'
    ));
  }
  public function store(Request $request){
    // return request();
    try {
      RevisionReparacionTrucks::createRevisionReparacionTrucks($request->id_solicitud_taller_trucks, $request->work, $request->percent_range,
      $request->comments, 'visible', '100923', $request->date_start, \Carbon\Carbon::now());
      return redirect()->route('SalidasTallerTrackto.index')->with('success', 'Solicitud de salida de taller generada correctamente');

    } catch (\Exception $e) {
      return $e->getMessage();
    }

  }
  public function BusquedaVIN(){

    $Busqueda = '%'.request()->valorBusqueda.'%';

    $Inventario = inventario_trucks::select('idinventario_trucks','marca','version','color','modelo','vin_numero_serie')->where(function ($query)  {
      $query->where('visible','SI');
    })->where(function ($query) use ($Busqueda) {
      $query->where('vin_numero_serie', 'like' , $Busqueda )
      ->orWhere('marca', 'like' , $Busqueda )
      ->orWhere('version', 'like' , $Busqueda )
      ->orWhere('color', 'like' , $Busqueda )
      ->orWhere('modelo', 'like' , $Busqueda );
    })->limit(5)->get();
    foreach ($Inventario as $Inv) {
      if (SolicitudTallerTrucks::where('idinventario_trucks', $Inv->idinventario_trucks)->count()==0) {
        $Inventario->pop()->where('idinventario_trucks', $Inv->idinventario_trucks);
      }
    }
    if(sizeof($Inventario) == 0){
      return json_encode(null);
    }else{
      return $Inventario;
    }
  }
}
