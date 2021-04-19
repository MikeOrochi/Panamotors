<?php

namespace App\Http\Controllers\TallerTracktocamiones;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\SolicitudTallerTrucks;
use App\Models\SolicitudPiezasTrucks;
use App\Models\inventario_trucks;
use App\Models\inventario;
use App\Models\empleados;

class TallerTracktoController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  public function index(){

    $empleados = empleados::where('visible', 'SI')
    ->where('puesto','like', '%mecanico%')
    ->orWhere('puesto','like', '%taller%')
    ->orWhere('puesto','like', '%dissel%')
    ->orWhere('puesto','like', '%electrico%')
    ->orderBy('idempleados','desc')
    ->get(['idempleados','nombre','apellido_paterno','apellido_materno','puesto']);
    return view('TallerTracktocamiones.dashboard.new', compact('empleados'));
  }
  public function store(Request $request){
    // return $request;
    DB::beginTransaction();
    try {
      if ($request->status=='Pendiente') { $employe=''; }
      else { $employe=$request->employee; }
      $solicitud_taller_trucks = SolicitudTallerTrucks::createSolicitudTallerTrucks2('',$request->vin_venta,$request->marca_venta,$request->version_venta,
      $request->modelo_venta,$request->color_venta,'',0, $request->description, $request->stetic_range, $request->description_stetic, 
      '', $request->petrol_range, $request->comments, $request->date_entry, $request->date_estimated, '',$request->status, $request->priority_range, 
      '100923', $request->date_start, \Carbon\Carbon::now(),$employe);
      // return $solicitud_taller_trucks;
      // $inventario_trucks = inventario_trucks::where('vin_numero_serie', $request->vin_venta)->get(['idinventario_trucks','vin_numero_serie'])->last();
      // $solicitud_taller_trucks = SolicitudTallerTrucks::createSolicitudTallerTrucks($inventario_trucks->idinventario_trucks, $request->description, $request->stetic_range,
      // $request->description_stetic, $request->description_other, $request->petrol_range, $request->comments, $request->date_entry, $request->date_estimated, $request->employee,
      // 'taller', $request->priority_range, '100923', $request->date_start, \Carbon\Carbon::now());
      for ($i=0; $i <$request->no_piezas ; $i++) {
        SolicitudPiezasTrucks::createSolicitudPiezasTrucks($solicitud_taller_trucks->id, request('pieza_'.($i+1)), 1, 0,
        '', 'pendiente', '100923', $request->date_start, \Carbon\Carbon::now());
      }
      DB::commit();
      return redirect()->route('SalidasTallerTrackto.index')->with('success', 'Ingreso a taller registrado exitosamente');
    } catch (\Exception $e) {
      DB::rollback();
      return $e->getMessage();
      return back()->with('error', 'Problemas al guardar la información');
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


    if(sizeof($Inventario) == 0){
        return json_encode(null);
    }else{
      return $Inventario;
    }
  }
  public function formatoAsignar($id){
    $id = Crypt::decrypt($id);
    // return $id;
    try {
      $solicitud_taller_trucks = SolicitudTallerTrucks::where('status', 'taller')->where('id', $id)->get(['id','idinventario_trucks','idempleado','descripcion','fecha_estimada'])->last();
      $inventario_trucks = inventario_trucks::where('idinventario_trucks', $solicitud_taller_trucks->idinventario_trucks)
      ->get(['vin_numero_serie','marca','version','color','modelo'])
      ->last();
      $empleados = empleados::where('idempleados', $solicitud_taller_trucks->idempleado)
      ->get(['idempleados','nombre','apellido_paterno','apellido_materno'])
      ->last();
      $solicitud_piezas_trucks = SolicitudPiezasTrucks::where('idsolicitud_taller_trucks', $solicitud_taller_trucks->id)
      ->get(['concepto']);
      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => storage_path('mpdf/temp/'),
        'format' => 'Letter'
      ]);
      $mpdf->defaultheaderfontsize = 10;
      $mpdf->defaultheaderfontstyle = 'B';
      $mpdf->defaultheaderline = 0;
      $mpdf->defaultfooterfontsize = 10;
      $mpdf->defaultfooterfontstyle = 'BI';
      $mpdf->defaultfooterline = 0;

      $mpdf->SetHTMLHeader('<img src="'.secure_asset('storage/app/CostoTotalVIN/header_costo_total.png').'" class="img_header" alt=""><br>');
      $mpdf->SetHTMLFooter('<p class="text-datos-obs">
         <div style="width: 100%;">

            <div style="width: 19%; float: left;">
               <div style="width: 100px; float: right;"></div>
            </div>
         </div>
         <img src="'.public_path('/img/mpdf/footer.png').'" alt=""><p style="text-align: right; font-size: 10px; color: gray;">{PAGENO} de {nb}</p>
      </p>');
      // <div style="width: 80%; float: left;">
      //   <p class="tit3" style="text-align: center; color: #AFAEAE; margin-top: 80px; margin-left: 40px;">El presente recibo no es válido si los datos desplegados con la lectura del QR son diferentes al impreso. Valide la información y asegúrese de recibir un comprobante válido.</p>
      // </div>
      $html_content = view('TallerTracktocamiones.pdf.asignacion',compact('solicitud_taller_trucks','empleados','solicitud_piezas_trucks'))->render();
      $mpdf->WriteHTML($html_content);

      $mpdf->Output('Prueba', 'I');
    } catch (\Exception $e) {
      return $e;
    }
  }
}
