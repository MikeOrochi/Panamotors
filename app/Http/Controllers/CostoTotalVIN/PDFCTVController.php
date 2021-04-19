<?php

namespace App\Http\Controllers\CostoTotalVIN;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\estado_cuenta;
/*use App\Models\inventario;
use App\Models\inventario_trucks;
use App\Models\estado_cuenta_proveedores;
use App\Models\inventario_cortes_trucks;
use App\Models\autenticacion_pdf_costo_total;
use App\Models\inventario_dinamico;
use App\Models\publicacion_vin_fotos;
use App\Models\orden_compra_unidades;
use App\Models\check_list_expediente_original;
*/
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class PDFCTVController extends Controller{

  public function __construct(){
    $this->middleware('auth');
  }

  public function pdf($vin,$fecha,$coordenadas){
    try {



      $coordenadas = base64_decode($coordenadas);

      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
      $month = ucfirst($meses[date('m') - 1]);
      $day = date('d');
      $year = date('Y');
      $hour = date('H:i:s');

      $EstadoCuenta = estado_cuenta::select(
        'estado_cuenta_proveedores.idestado_cuenta_proveedores',
        'estado_cuenta.fecha_movimiento', 'estado_cuenta.monto_precio',
      DB::raw("CONCAT('ID',contactos.idcontacto,'-',contactos.nombre,' ',contactos.apellidos) AS nombre_cliente"))
      ->join('contactos','estado_cuenta.idcontacto','=','contactos.idcontacto')
      ->where('estado_cuenta.visible', 'SI')->where('estado_cuenta.datos_vin', $vin)
      ->where('estado_cuenta.fecha_movimiento', '>=', $fecha)
      ->where(function ($query) {
        $query->where('estado_cuenta.concepto', 'Venta Directa' )
        ->orWhere ('estado_cuenta.concepto' , 'Venta Permuta' );
      })->orderBy('estado_cuenta.fecha_movimiento','ASC')->limit(1)->first();

      if ($EstadoCuenta) {
        $estatus = "Vendido";
      }else{
        $estatus = "Disponible";
      }

      estado_cuenta_proveedores::select(
        'estado_cuenta_proveedores.idestado_cuenta_proveedores','estado_cuenta_proveedores.fecha_movimiento',
        'estado_cuenta_proveedores.datos_vin','estado_cuenta_proveedores.datos_marca',
        'estado_cuenta_proveedores.datos_modelo','estado_cuenta_proveedores.datos_version',
        'estado_cuenta_proveedores.datos_color','estado_cuenta_proveedores.tipo_cambio',
        'estado_cuenta_proveedores.tipo_moneda',
        DB::raw(' "Compras" as departamento'),
        'estado_cuenta_proveedores.concepto',
        DB::raw('CONCAT(estado_cuenta_proveedores.col1 , "(",  estado_cuenta_proveedores.col2 ,")" ) as folio'),
        'estado_cuenta_proveedores.referencia',
        DB::raw('CONCAT("IDP",estado_cuenta_proveedores.idcontacto," ",UPPER(proveedores.nombre)," ",UPPER(proveedores.apellidos)) as proveedor'),
        'estado_cuenta_proveedores.datos_precio',
        'estado_cuenta_proveedores.col1',
        'estado_cuenta_proveedores.gran_total'
        )
        ->join('proveedores','estado_cuenta_proveedores.idcontacto','=','proveedores.idproveedores')
        ->whereBetween('estado_cuenta_proveedores.fecha_movimiento', [$fecha_inicio, $fecha_venta])
        ->where('estado_cuenta_proveedores.visible', 'SI')
        ->where('estado_cuenta_proveedores.datos_vin', $vin)
        ->where(function ($query) {
          $query->where('estado_cuenta_proveedores.concepto', 'Compra Directa' )
          ->orWhere('estado_cuenta_proveedores.concepto', 'Compra Permuta' )
          ->orWhere('estado_cuenta_proveedores.concepto', 'Cuenta de Deuda' )
          ->orWhere('estado_cuenta_proveedores.concepto', 'Consignacion' );
        })->unionAll(estado_cuenta::select(
          'estado_cuenta.idestado_cuenta',
          'estado_cuenta.fecha_movimiento','estado_cuenta.datos_vin',
          'estado_cuenta.datos_marca','estado_cuenta.datos_modelo',
          'estado_cuenta.datos_version','estado_cuenta.datos_color',
          'estado_cuenta.tipo_cambio', 'estado_cuenta.tipo_moneda',
          DB::raw(' "Ventas" as departamento'),
          'estado_cuenta.concepto',
          DB::raw(' "S/F" as folio'),
          'estado_cuenta.referencia',
          DB::raw('CONCAT("ID",estado_cuenta.idcontacto," ",UPPER(contactos.nombre)," ",UPPER(contactos.apellidos)) as proveedor'),
          'estado_cuenta.datos_precio',
          DB::raw(' "S/F" as col1'),
          'estado_cuenta.gran_total'
          )->join('contactos','estado_cuenta.idcontacto','=','contactos.idcontacto')
          ->where('estado_cuenta.visible', 'SI')
          ->where('estado_cuenta.datos_vin', $vin)
          ->where(function ($query) {
            $query->where('estado_cuenta.concepto', 'Compra Directa' )
            ->orWhere('estado_cuenta.concepto', 'Compra Permuta' )
            ->orWhere('estado_cuenta.concepto', 'Cuenta de Deuda' )
            ->orWhere('estado_cuenta.concepto', 'Consignacion' )
            ->orWhere('estado_cuenta.concepto', 'Venta Directa' )
            ->orWhere('estado_cuenta.concepto', 'Venta Permuta' );
          }))->orderBy('fecha_movimiento','DESC')->get();

        /*FROM estado_cuenta JOIN contactos ON (estado_cuenta.fecha_movimiento BETWEEN '$fecha_inicio' AND '$fecha_venta') AND estado_cuenta.idcontacto=contactos.idcontacto WHERE estado_cuenta.visible='SI' AND estado_cuenta.datos_vin='$vin' AND (estado_cuenta.concepto='Compra Directa' OR estado_cuenta.concepto='Compra Permuta' OR estado_cuenta.concepto='Cuenta de Deuda' OR estado_cuenta.concepto='Consignacion')
      ORDER BY fecha_movimiento ASC LIMIT 1;*/



      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => storage_path('mpdf/temp/'),
        // 'mode' => 'utf-8',
        'mode' => 'c',
        'format' => 'A4',
        // 'format' => [190, 236],
        // 'format' => [200, 236],
        'margin_top' => 28,
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_bottom' => 30,
        'margin_header'=>18,
        /*debug*/
        // DEPURACIÓN Y DESARROLLADORES
      // 'debug' => true ,
      ]);


      $mpdf->defaultheaderfontsize = 10;
      $mpdf->defaultheaderfontstyle = 'B';
      $mpdf->defaultheaderline = 0;
      $mpdf->defaultfooterfontsize = 10;
      $mpdf->defaultfooterfontstyle = 'BI';
      $mpdf->defaultfooterline = 0;

      $mpdf->SetHTMLHeader('<img src="'.secure_asset('storage/app/CostoTotalVIN/header_costo_total.png').'" class="img_header" alt=""><br>');
      $mpdf->SetHTMLFooter('<p class="text-datos-obs">INFORMACIÓN CONFIDENCIAL Y RESTRINGIDA PROPIEDAD DE PANAMOTORS CENTER S.A. DE C.V. {PAGENO} de {nb}</p>');
      //return view('CostoTotalVIN.costo_total_pdf2',compact('vin','month','day','year','hour','estatus'));
      $html_content = view('CostoTotalVIN.costo_total_pdf2',compact('vin','month','day','year','hour','estatus','fecha','EstadoCuenta'))->render();
      $mpdf->WriteHTML($html_content);

      $mpdf->Output('Prueba', 'I');
    } catch (\Exception $e) {
      return $e;
    }

  }

  public function pdfV2($vin,$fecha,$coordenadas){
    $coordenadas = base64_decode($coordenadas);
    dd(2,$vin,$fecha,$coordenadas);
  }


}
