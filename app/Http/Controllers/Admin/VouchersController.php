<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\GlobalFunctionsController;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http as Http;
use Illuminate\Support\Facades\Route;
use QrCode;
use Illuminate\Support\Facades\Crypt;
use App\Models\proveedores;
use App\Models\recibos_proveedores;
use App\Models\usuarios;
use App\Models\catalogo_metodos_pago;
use App\Models\comprobantes_transferencia;
use App\Models\recibos_proveedores_datos_impresion;
use App\Models\estado_cuenta_proveedores;
use App\Models\empleados;
use GuzzleHttp\Client;


class VouchersController extends Controller
{
   public function viewVoucherProviders($type_view, $id){
      // $id = Crypt::encrypt($id);
      $id_recibo= Crypt::decrypt($id);
      // dd($id_recibo,$id);
      $recibo = recibos_proveedores::where('idrecibos_proveedores',$id_recibo)->get()->first();
      if(!empty($recibo)){
         $recibo_impreso = recibos_proveedores_datos_impresion::where('id_recibos_proveedores',$recibo->idrecibos_proveedores)->get()->first();
         $proveedor = proveedores::where('idproveedores',$recibo->idcontacto)->get()->first();
         /*Fecha recibo encabezado*/
         $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
         $fecha_recibo = new \DateTime($recibo->fecha_guardado);
         $mes = $meses[($fecha_recibo->format('n')) - 1];
         $fecha_recibo_encabezado = $fecha_recibo->format('d') . ' de ' . $mes . ' de ' . $fecha_recibo->format('Y');
         /*Usuario*/
         $usuario = usuarios::where('idusuario',$recibo->usuario_creador)->get()->first();
         if(!empty($usuario)) $nombre_usuario = $usuario->nombre_usuario;
         // $num_random = rand(1,10000);
         $estado_cuenta_proveedor = estado_cuenta_proveedores::where('idestado_cuenta_proveedores',$recibo->id_estado_cuenta)->get()->first();

         /*id-proveedor / fecha / id-usuario / id-empleado / id-movimiento / random*/
         if(!empty($recibo_impreso))$id_generic_voucher = $recibo_impreso->id_generic_voucher;
         // else $id_generic_voucher = $proveedor->idproveedores."/".$fecha_recibo->format('Ymdhms')."/".$usuario->idusuario."/".$usuario->idempleados."/".$recibo->idrecibos_proveedores."/".$num_random;
         else if(!empty($estado_cuenta_proveedor))$id_generic_voucher = $estado_cuenta_proveedor->referencia;

         /*Metodo Pago*/
         $metodo_pago = catalogo_metodos_pago::where('idcatalogo_metodos_pago',$recibo->metodo_pago)->get()->first();
         if(!empty($recibo->gran_total))$total = number_format((float)$recibo->gran_total, 2);
         if(!empty($recibo->gran_total))$total_text = GlobalFunctionsController::convertir($recibo->gran_total,$recibo->tipo_moneda);
         /*Fecha*/
         if(!empty($recibo_impreso))$fecha_actual = new \DateTime($recibo_impreso->created_at);
         else $fecha_actual = new \DateTime(now());
         $mes = $meses[($fecha_actual->format('n')) - 1];
         $string_fecha = $fecha_actual->format('d') . ' de ' . $mes . ' de ' . $fecha_actual->format('Y');

      }else return redirect()->back()->with('error','Recibo no encontrado');

      $url_root = request()->root()."/verificar/";
      if(!empty($recibo_impreso))$url_path = $recibo_impreso->qrcode_url;
      else $url_path = Crypt::encrypt(request()->path());

      // dd(Crypt::decrypt($url_path), $id_recibo);

      $newqrcode = QrCode::size(150)->backgroundColor(255,255,255)->generate($url_root.$url_path);
      $newqrcode_explode = explode("?>", $newqrcode);

      if(empty($recibo_impreso)){
         DB::beginTransaction();
         try {
            recibos_proveedores_datos_impresion::createRecibosProveedoresDatosImpresion($recibo->idrecibos_proveedores, $url_path, $id_generic_voucher, $nombre_usuario, "Guardado");
            DB::commit();
         } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
            return back()->with('error', $e->getMessage() )->withInput();
         }
      }

      $view=View::make('admin.wallet.voucher.pdfQr',compact('newqrcode_explode','recibo','proveedor','fecha_recibo_encabezado','id_generic_voucher','metodo_pago','total','total_text','nombre_usuario','string_fecha'));
      GlobalFunctionsController::createPdf($view, 'Recibo', '1', 0000001,"admon_compras","recibo",$newqrcode_explode[1],"");

      return view('admin.wallet.voucher.view_voucher_providers',compact(
         'newqrcode_explode','recibo','proveedor','fecha_recibo_encabezado','id_generic_voucher','metodo_pago','total','total_text','nombre_usuario','string_fecha'));
   }

   public function verifyVoucher($url){
      $decrypt_path = Crypt::decrypt($url);
      $url_root = request()->root()."/";
      $path_explode = explode("/",$decrypt_path);
      $id_recibo = last($path_explode);
      try {
         $client = new \GuzzleHttp\Client();
         $res = $client->request('GET', $url_root.$decrypt_path);
         if($res->getStatusCode() == 200){
            $recibo_impreso = recibos_proveedores_datos_impresion::where("id_recibos_proveedores",Crypt::decrypt($id_recibo))->get()->first();
            if(!empty($recibo_impreso)){
               return redirect()->route('vouchers.verifyNextVoucher',[$id_recibo]);
            }else abort(404);
         }else abort(404);

      } catch (\Exception $e) {
         if($e->getStatusCode()==404) abort(404);
         dd($e->getMessage());
      }

   }

   public function verifyNextVoucher($id){
      $id_recibo= Crypt::decrypt($id);
      $recibo = recibos_proveedores::where('idrecibos_proveedores',$id_recibo)->get()->first();
      if(!empty($recibo)){
         $recibo_impreso = recibos_proveedores_datos_impresion::where('id_recibos_proveedores',$recibo->idrecibos_proveedores)->get()->first();
         $proveedor = proveedores::where('idproveedores',$recibo->idcontacto)->get()->first();
         /*Fecha recibo encabezado*/
         $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
         $fecha_recibo = new \DateTime($recibo->fecha_guardado);
         $mes = $meses[($fecha_recibo->format('n')) - 1];
         $fecha_recibo_encabezado = $fecha_recibo->format('d') . ' de ' . $mes . ' de ' . $fecha_recibo->format('Y');
         /*Usuario*/
         if(!empty($recibo_impreso)) $nombre_usuario = $recibo_impreso->nombre_usuario_recepcionista;
         /*id-proveedor / fecha / id-usuario / id-empleado / id-movimiento / random*/
         if(!empty($recibo_impreso))$id_generic_voucher = $recibo_impreso->id_generic_voucher;
         /*Metodo Pago*/
         $metodo_pago = catalogo_metodos_pago::where('idcatalogo_metodos_pago',$recibo->metodo_pago)->get()->first();
         if(!empty($recibo->gran_total))$total = number_format((float)$recibo->gran_total, 2);
         if(!empty($recibo->gran_total))$total_text = GlobalFunctionsController::convertir($recibo->gran_total,$recibo->tipo_moneda);
         /*Fecha*/
         if(!empty($recibo_impreso)){
            $fecha_actual = new \DateTime($recibo_impreso->created_at);
            $mes = $meses[($fecha_actual->format('n')) - 1];
            $string_fecha = $fecha_actual->format('d') . ' de ' . $mes . ' de ' . $fecha_actual->format('Y');
         }

      }else abort(404);

      $url_root = request()->root()."/verificar/";
      if(!empty($recibo_impreso))$url_path = $recibo_impreso->qrcode_url;

      $newqrcode = QrCode::size(130)->backgroundColor(255,255,255)->generate($url_root.$url_path);
      $newqrcode_explode = explode("?>", $newqrcode);

      return view('admin.wallet.voucher.view_voucher_providers',compact(
         'newqrcode_explode','recibo','proveedor','fecha_recibo_encabezado','id_generic_voucher','metodo_pago','total','total_text','nombre_usuario','string_fecha'));
   }

   public function viewVoucherExpenses($id_comprobante){
      $id_decode = Crypt::decrypt($id_comprobante);
      $comprobante_transferencia = comprobantes_transferencia::where('visible','SI')->where('idcomprabantes_transferencia',$id_decode)->get()->first();
      $modo_pago = "";
      $conceptos = "";
      if(!empty($comprobante_transferencia)){
         if(!empty($comprobante_transferencia->metodo_pago)){
            if ($comprobante_transferencia->metodo_pago == "1") {
               $modo_pago ="Efectivo:";
               $conceptos = "Abono";
            }else{
               if ($comprobante_transferencia->metodo_pago == "6") {
                  $conceptos = "Traspaso";
               }else{
                  $conceptos = "Abono";
               }
               $modo_pago ="Transferencia: ";
            }
         }
         if(!empty($comprobante_transferencia->emisora_agente)){
            if ($comprobante_transferencia->emisora_agente == "CCH") {
               $emisora_agente = "Caja chica";
            }else if ($comprobante_transferencia->emisora_agente == "B2") {
               $emisora_agente = "BANORTE";
            }else if ($comprobante_transferencia->emisora_agente == "B1") {
               $emisora_agente = "BANCOMER";
            }else if ($comprobante_transferencia->emisora_agente == "B3") {
               $emisora_agente = "SCOTIABANK";
            }else if ($comprobante_transferencia->emisora_agente == "B4") {
               $emisora_agente = "BANAMEX";
            }else {
               $emisora_agente = $comprobante_transferencia->emisora_agente;
            }
         }

         $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
         if(!empty($comprobante_transferencia->fecha_creacion)){
            $date = new \DateTime($comprobante_transferencia->fecha_creacion);
            $mes = $meses[($date->format('n')) - 1];
            $fecha = $date->format('d') . ' de ' . $mes . ' de ' . $date->format('Y');
            $hora = $date->format('H:i:s');
         }
         if(!empty($comprobante_transferencia->empleador_creador)){
            $empleado = empleados::where('visible','SI')->where('idempleados',$comprobante_transferencia->empleador_creador)->get()->first();
            if(!empty($empleado))$nombre_completo = $empleado->nombre." ".$empleado->apellido_paterno." ".$empleado->apellido_materno;
         }

         if(!empty($comprobante_transferencia->tipo_id)){
            if ($comprobante_transferencia->tipo_id == "Auxiliares" ) {
               $tipo_id = "Balance";
            }else{
               $tipo_id = $comprobante_transferencia->tipo_id ;
            }
            if ($comprobante_transferencia->tipo_id == "Auxiliares" || $comprobante_transferencia->tipo_id == "Balance") {
               $proveedor = proveedores::where('idprovedores_compuesto',$comprobante_transferencia->id)->where('visible','SI')->get()->first();
               if(!empty($proveedor))$nombre_receptor= $proveedor->nombre." ".$proveedor->apellidos;
            }
            if ($comprobante_transferencia->tipo_id == "Proveedor") {
               $proveedor = proveedores::where('idproveedores',$comprobante_transferencia->id)->where('visible','SI')->get()->first();
               if(!empty($proveedor))$nombre_receptor= $proveedor->nombre." ".$proveedor->apellidos;
            }
         }

      }else return redirect()->back()->with('error','Comprobante no encontrado');

      $view=View::make('admin.wallet.voucher.view_voucher_expenses',compact( 'nombre_completo', 'fecha', 'hora', 'modo_pago', 'nombre_receptor', 'comprobante_transferencia', 'conceptos' ));
      GlobalFunctionsController::createPdf($view, 'Comprobante', '1', $comprobante_transferencia->folio,"admon_compras","comprobante_egreso","","");
      return view('admin.wallet.voucher.view_voucher_expenses',compact( 'nombre_completo', 'fecha', 'hora', 'modo_pago', 'nombre_receptor', 'comprobante_transferencia', 'conceptos' ));
   }

}
