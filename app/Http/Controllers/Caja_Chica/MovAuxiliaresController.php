<?php

namespace App\Http\Controllers\Caja_Chica;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\account_status;
use App\Models\usuarios;
use App\Models\perfiles;
use App\Models\proveedores;
use App\Models\auxiliares;
use App\Models\contactos;
use App\Models\estado_cuenta_requisicion;
use App\Models\auxiliar_principales;
use App\Models\catalogo_departamento;
use App\Models\catalago_conceptos_estado_cuenta_requisicion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
class MovAuxiliaresController extends Controller
{
	public function __construct(){
		$this->middleware('auth');
	}

	public function store(){
		DB::beginTransaction();
		try {
			$user_maker = usuarios::get()->where('visible', 'SI')->where('idempleados', \Auth::user()->idempleados)->where('rol', 50)->last()->idusuario;
			$nombre_provedor = trim(request()->nombre_provedor);
			$apellidos_provedor = trim(request()->apellidos_provedor);
			if ($apellidos_provedor == "") {
				$apellidos_provedor = "N/A";
			}
			$alias_provedor = trim(request()->alias_provedor);
			$tipo_mone_provedor = trim(request()->tipo_mone_provedor);

			$nomenclatura = $this->getNomenclatura($nombre_provedor, $apellidos_provedor);
			$today = Carbon::now();

			$actual= date("Y_m_d__H_i_s");
			$fecha_actual= date("Y-m-d H:i:s");
			$usuario_creador = \Request::cookie('usuario_creador');


			$file = request()->file('uploadedfile');
			if ($file == "" || $file == null) {
				$archivo_cargado="#";
			}else{
				$target_path_storage = storage_path('app/ProveedoresEvidencia/');
				$name_img = "PCP"."_".$actual."_Usr_".$usuario_creador."_".basename( $_FILES['uploadedfile']['name']);
				$target_path_img = $target_path_storage.$name_img;
				if ($target_path_img!=$target_path_storage) {
					if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path_img)) {
						$archivo_cargado='storage/app/ProveedoresEvidencia/'.$name_img;
					}
				}
			}



			$providers = proveedores::createProveedores($nomenclatura['id_provider_comp'], $nomenclatura['nomenclatura'], $nombre_provedor,
			$apellidos_provedor, '', '', $alias_provedor, null, '', '', '','', '', '', '','', '', '', '','', null, null, null, 'N/A', 'N/A', 'N/A', 'N/A', '','', '',
			'', '', 'N/A', 'SI', $user_maker, $today, $today, null, '', $tipo_mone_provedor, null, null, null, '',
			'', '', '', '', 'N/A', "$archivo_cargado");
			DB::commit();
			return $providers;

		} catch (\Exception $e) {
			DB::rollback();
			return json_encode($e->getMessage());
		}
	}

	public function generar_recibo_pdf_qr(){
		$view=View::make('Caja_Chica.recibo_qr_pdf',compact(
		'id'));

		$nombre = "PDdsafdfsdfsdF"; $apellidos = "fdsfs dfPDF"; $id_contacto_completo = "949343294";

		GlobalFunctionsController::createPdf($view, $nombre, $apellidos, $id_contacto_completo,"admon_compras", "reporte_ejecutivo_compras","","");
		return view('Caja_Chica.recibo_qr_pdf',compact(
				'id'));
	}
	public function edit(){
	}

	public function update(){
	}

	public function find_provider(){
		DB::beginTransaction();
		try {
			$valorBusqueda = request()->valorBusqueda;
			$providers = DB::select("select idprovedores_compuesto,nombre,apellidos,nomeclatura,col10,col2 from proveedores where idproveedores='".$valorBusqueda."' || concat_ws(' ', nombre, apellidos) LIKE '".$valorBusqueda."%' || nombre LIKE '".$valorBusqueda."%' || apellidos LIKE '".$valorBusqueda."%' || alias LIKE '%".$valorBusqueda."%'LIMIT 5");
			$contacts = DB::select("select idcontacto,nombre,apellidos,nomeclatura from contactos where idcontacto='".$valorBusqueda."' || concat_ws(' ', nombre, apellidos) LIKE '".$valorBusqueda."%' || nombre LIKE '".$valorBusqueda."%' || apellidos LIKE '".$valorBusqueda."%' || alias LIKE '%".$valorBusqueda."%'  LIMIT 5");

			$proveedores_infos = DB::select("select idproveedores_info,nombre,apellidos,nomeclatura,tipo,moneda from proveedores_info where idproveedores_info='".$valorBusqueda."' || concat_ws(' ', nombre, apellidos) LIKE '".$valorBusqueda."%' || nombre LIKE '".$valorBusqueda."%' || apellidos LIKE '".$valorBusqueda."%' || alias LIKE '%".$valorBusqueda."%' LIMIT 5");

			foreach ($proveedores_infos as $proveedor_infos ) {
				$proveedor_infos->idprovedores_compuesto = $proveedor_infos->idproveedores_info;
				$proveedor_infos->idcontacto = $proveedor_infos->idproveedores_info;
				$proveedor_infos->tipo_moneda =$proveedor_infos->moneda;
			}

			foreach ($contacts as $contact) {
				$contact->idprovedores_compuesto = $contact->idcontacto;
				$contact->tipo ="Crédito y Cobranza";
				$contact->tipo_moneda ="MXN";
			}
			foreach ($providers as $provider) {
				$provider->idcontacto = $provider->idprovedores_compuesto;
				$tipo = $provider->col10;
				$mon = $provider->col2;
				if ($mon == "") {
					$provider->tipo_moneda ="Moneda pendiente";
				}else{
					$provider->tipo_moneda =$mon;
				}
				if ($tipo == 8) {
					$provider->tipo ="Admon Compras";
				}else{
					$provider->tipo ="Auxiliares";
				}
			}

			DB::commit();
			return   ['contacts'=>$contacts,'providers'=>$providers ,'providers_inf'=>$proveedores_infos ,'balance'=>$valorBusqueda];
		} catch (\Exception $e) {
			DB::rollback();
			return json_encode($e->getMessage());
		}
	}

	public function auxiliares_tokenfield(){
		DB::beginTransaction();
		try{
			$dato = request()->query;
			$auxiliares = auxiliares::where('visible','SI')->where('nombre','like','%'.$dato.'%')->groupby('nombre')->get('nombre');

			DB::commit();
			return $auxiliares;
		}catch(\Exception $e){
			DB::rollback();
			return json_encode($e->getMessage());
		}
	}


	public function verificar_referencias(){
		DB::beginTransaction();
		try{
			$referencia = request()->referencia;
			$nombre_auxliar = request()->nombre_auxliar;
			$tipo_movimiento = request()->tipo_movimiento;
			if ($tipo_movimiento == "cargo") {
				if ($referencia == "N/A" || $referencia == "S/N" || $referencia == "S/F" || $referencia == "n/a" || $referencia == "s/n" || $referencia == "s/f" || $referencia == "SN" || $referencia == "NA"|| $referencia == "sn" || $referencia == "na") {
					$respuesta->respuesta = "no";
				}else{
					$auxiliares = auxiliares::seletc('estado_cuenta_requisicion.idestado_cuenta_requisicion')->join('estado_cuenta_requisicion','estado_cuenta_requisicion.idestado_cuenta_requisicion','=','auxiliares.idestado_cuenta_requisicion')->where('estado_cuenta_requisicion.visible','SI')->where('auxiliares.visible','SI')->where('auxiliares.nombre',$nombre_auxliar)->where('estado_cuenta_requisicion.tipo_movimiento','abono')->where('estado_cuenta_requisicion.referencia',$referencia)->get('estado_cuenta_requisicion.idestado_cuenta_requisicion');
					if ($auxiliares->isEmpty()) {
						$auxiliares = auxiliares::seletc('estado_cuenta_requisicion.idestado_cuenta_requisicion')->join('estado_cuenta_requisicion','estado_cuenta_requisicion.idestado_cuenta_requisicion','=','auxiliares.idestado_cuenta_requisicion')->where('estado_cuenta_requisicion.visible','SI')->where('auxiliares.visible','SI')->where('auxiliares.nombre',$nombre_auxliar)->where('estado_cuenta_requisicion.tipo_movimiento','cargo')->where('estado_cuenta_requisicion.referencia',$referencia)->get('estado_cuenta_requisicion.idestado_cuenta_requisicion');
						if ($auxiliares->isEmpty()) {
							$auxiliares->respuesta = "si";
						}else{
							$respuesta->respuesta = "talvez";
						}
					}else{
						$respuesta->respuesta = "no";
					}
				}
			}else if ($tipo_movimiento == "abono") {
				if ($referencia == "N/A" || $referencia == "S/N" || $referencia == "S/F" || $referencia == "n/a" || $referencia == "s/n" || $auxiliares == "s/f" || $referencia == "SN" || $referencia == "NA"|| $referencia == "sn" || $referencia == "na") {
					$respuesta->respuesta = "no";
				}else{
					$auxiliares = auxiliares::seletc('estado_cuenta_requisicion.idestado_cuenta_requisicion')->join('estado_cuenta_requisicion','estado_cuenta_requisicion.idestado_cuenta_requisicion','=','auxiliares.idestado_cuenta_requisicion')->where('estado_cuenta_requisicion.visible','SI')->where('auxiliares.visible','SI')->where('auxiliares.nombre',$nombre_auxliar)->where('estado_cuenta_requisicion.tipo_movimiento','cargo')->where('estado_cuenta_requisicion.referencia',$referencia)->get('estado_cuenta_requisicion.idestado_cuenta_requisicion');
					if ($auxiliares->isEmpty()) {
						$auxiliares = auxiliares::seletc('estado_cuenta_requisicion.idestado_cuenta_requisicion')->join('estado_cuenta_requisicion','estado_cuenta_requisicion.idestado_cuenta_requisicion','=','auxiliares.idestado_cuenta_requisicion')->where('estado_cuenta_requisicion.visible','SI')->where('auxiliares.visible','SI')->where('auxiliares.nombre',$nombre_auxliar)->where('estado_cuenta_requisicion.tipo_movimiento','abono')->where('estado_cuenta_requisicion.referencia',$referencia)->get('estado_cuenta_requisicion.idestado_cuenta_requisicion');
						if ($auxiliares->isEmpty()) {
							$auxiliares->respuesta = "si";
						}else{
							$auxiliares->respuesta = "talvez";
						}
					}else{
						$auxiliares->respuesta = "no";
					}
				}
			}else{
				if ($referencia == "N/A" || $referencia == "S/N" || $referencia == "S/F" || $referencia == "n/a" || $referencia == "s/n" || $referencia == "s/f" || $referencia == "SN" || $referencia == "NA"|| $referencia == "sn" || $referencia == "na") {
					$auxiliares->respuesta = "no";
				}else{
					$auxiliares = estado_cuenta_requisicion::where('visible','SI')->where('referencia',$referencia)->get('idestado_cuenta_requisicion');
					if ($auxiliares->isEmpty()) {
						$auxiliares->respuesta = "si";
					}else{
						$auxiliares->respuesta = "no";
					}
				}
			}

			DB::commit();
			return json_encode($auxiliares);
		}catch(\Exception $e){
			DB::rollback();
			return json_encode($e->getMessage());
		}
	}

	public static function getNumberToLetters($number,$type_change){
		$formatter = new NumeroALetras();
		return ['info'=>$formatter->toInvoice($number, 2, $type_change)];
	}

	public function buscar_conceptos(){
		DB::beginTransaction();
		try{
			$empleados = \Auth::user()->idempleados;
			$departamento = request()->departamentos;
			if ($empleados == 91 || $empleados == 88 || $empleados == 204 || $empleados == 257 || $empleados == 258 || $empleados == 259) {
				$conceptos = catalago_conceptos_estado_cuenta_requisicion::where('visible','SI')->where('departamento',$departamento)->groupBy('concepto')->get('concepto');
			}else{
				$conceptos = catalago_conceptos_estado_cuenta_requisicion::where('visible','SI')->where('col1',$departamento)->where('departamento',$departamento)->groupBy('concepto')->get('concepto');
			}
			DB::commit();
			return $conceptos;
		}catch(\Exception $e){
			DB::rollback();
			return json_encode($e->getMessage());
		}

	}


	public function getNomenclatura($name, $lastname){
		$names_array = explode(" ", $name);
		$lastnames_array = explode(" ", $lastname);
		$nomenclatura = '';
		foreach ($names_array as $name_array) {
			$nomenclatura = $nomenclatura.substr($name_array, 0, 1);
		}
		foreach ($lastnames_array as $lastname_array) {
			$nomenclatura = $nomenclatura.substr($lastname_array, 0, 1);
		}
		$date = Carbon::now()->format('dmY');
		return ['nomenclatura' => $nomenclatura,
		'id_provider_comp' =>(proveedores::get()->last()->idproveedores+1).'-'.$nomenclatura.'-'.$date];
	}
}
