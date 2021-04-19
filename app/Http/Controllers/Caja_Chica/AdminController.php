<?php

namespace App\Http\Controllers\Caja_Chica;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\account_status;
use App\Models\usuarios;
use App\Models\perfiles;
use App\Models\proveedores;
use App\Models\estado_cuenta_proveedores;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

	public function __construct(){
		$this->middleware('auth');
	}

	public static function DatosUsuario(){

    //$all = account_status::select('id','name')->where('id',4)->get();
    //SELECT * FROM usuarios where visible='SI' AND rol='$rol_global' AND idempleados='$empleados' AND idusuario='$usuario_creador'

    //$rol_global = "Plantilla_CCP_Nueva";

		DB::beginTransaction();
		try {
			$IdEmpleado = Auth::guard('usuarios')->user()->idempleados;
			$usuario_creador = \Request::cookie('usuario_creador');

			if($usuario_creador == null){
				dd(Auth::user());
				dd('Se caduco tu galleta de usuario_creador :( ');
			}

			$usuario = usuarios::where('visible','SI')->where('idempleados', $IdEmpleado)->where('idusuario', $usuario_creador)->first();

			$IdEmpleado = Auth::guard('usuarios')->user()->idempleados;
			$usuario_creador = \Request::cookie('usuario_creador');

			DB::commit();
			return $usuario = usuarios::where('visible','SI')->where('idempleados', $IdEmpleado)->where('idusuario', $usuario_creador)->first();
		} catch (\Exception $e) {
			return redirect()->route('logout');
		}
	}

	public function index(){
		return view('Caja_Chica.index');
	}

	public function profiles(){

		DB::beginTransaction();
		try {
			$IdEmpleado = Auth::guard('usuarios')->user()->idempleados;
			$usuarios = usuarios::where('idempleados', $IdEmpleado)->where('visible', 'SI')->get();
			foreach ($usuarios as $key => $usuario) {
				$usuario->perfiles = perfiles::where('rol', $usuario->rol)->first();
			}
			DB::commit();
			return view('Caja_Chica.profiles',compact('usuarios','IdEmpleado'));
		} catch (\Exception $e) {
			DB::rollback();
			return back()->with('error','Ocurrio un erro inesperado intente de nuevo')->withInput();
		}
	}

	public function profiles_home(){
		try {

			$usuario_creador = request()->id;
      // dd($usuario_creador);
			$IdEmpleado = Auth::guard('usuarios')->user()->idempleados;
			$usuarios = usuarios::select('rol')->where('idusuario', $usuario_creador)->where('visible', 'SI')->where('idempleados', $IdEmpleado)->first();

			return $this->Direccion($usuarios->rol);
			return redirect()->route($this->Direccion($usuarios->rol))->withCookie(cookie('usuario_creador',$usuario_creador,720));

		} catch (\Exception $e) {
			return back()->with('error', 'El perfil se encuentra en desarrollo')->withInput();
		}
	}



	public function Direccion($rol){
		$Direcciones = array(
			'logout' => 1,
			'Perfiles/Credito_Cobranza/home.php'          => 3,
			'Perfiles/Fuerza_Ventas/home.php'          => 4,
			'Perfiles/Gerencia_Cobranza/home.php'         => 40,
			'Perfiles/Atencion_Clientes/home.php'          => 5,
			'Perfiles/Coordinacion_Administrativa/home.php'          => 6,
			'Perfiles/Evaluacion_Diagnostico/home.php'          => 7,
			'Perfiles/Administracion_Ventas/home.php'          => 8,
			'Perfiles/Seguimiento_Individual/home.php'        => 150,
			'Perfiles/Administracion_Compras/home.php'        => 700,
			'Perfiles/Reportes/home.php'     => 'root',
			'Perfiles/Consulta_Fuerza_Ventas/home.php'         => 20,
			'Perfiles2/Informativo/index.php'        => 500,
			'Perfiles/Inventario_Completo/home.php'        => 600,
			'Perfiles2/Mercadotecnia/home.php'        => 800,
			'Perfiles2/Recursos_Humanos/home.php'       => 1200,
			'Perfiles/Administracion_Compras/home.php'         => 15,
			'Caja_Chica.index'         => 50,
			'Perfiles/Inventario/home.php'        => 900,
			'Perfiles/Gestion_Financiera/home.php'       => 1300,
			'Perfiles/Logistica_Interna/home.php'       => 1301,
			'Perfiles/Relaciones/home.php'         => 16,
			'Perfiles/Inventario_Refacciones/home.php'       => 2000,
			'Perfiles/Vendedores_Externos_Trucks/home.php'      => 'VET',
			'Perfiles/Movimiento_Exitoso/home.php'  => 'TEMP@ME',
			'Perfiles/Logistica/home.php'        => 100,
			'Perfiles/Generar_Logistica/home.php'        => 101,
			'Perfiles/Ejecutivos_Traslado/home.php'        => 102,
      'Admin.index'               => 17,  //Antes -> Perfiles/Admon_Compras/home.php
      'Perfiles/Gestoria_Externa/home.php'           => 'GEXT',
      'Perfiles/Contabilidad/home.php'   => 'CONTABILIDAD',
      'Perfiles/Ordenes_Talleres_Clientes/home.php'            => 'OTC',
      'Perfiles/Admon_Ventas/home.php'    => 'AdmonVentas',
      'Perfiles/Inventario_Estatus_Cambios/home.php'            => 'IEC',
      'Perfiles/Prospectos/home.php'     => 'Prospectos',
      'Perfiles/Exp_VIN/home.php'  => 'Reg. Exp. VIN',
      'Perfiles2/Desarrollo_Jacko/index.php'          => 'JACKO',
      'Perfiles/Cartera_Contactos/home.php'  => 'Cartera Contactos',
      'Perfiles/Ordenes_Talleres/home.php'   => 'Ordenes Talleres',
      'Perfiles2/Legal/home.php'              => 'LEGAL',
      'Perfiles/Movimientos_Credito_Cobranza/home.php' => 'Movimientos_Credito_Cobranza',
      'Perfiles2/Comisiones/index.php'         => 'Comisiones',
      'Perfiles/Encargado_Piso/home.php'         => 103,
      'Perfiles/DualTrucks/home.php'     => 'DualTrucks',
      'Perfiles2/New_User/index.php'       => 'New_User',
      'Perfiles2/orden_compra/index.php'      =>  'orden_compra',
      'Perfiles/Gerencia_Trucks/home.php'      =>  'Gerencia_Trucks',
      'Perfiles/Orden_Proveedores_Admon_Compras/home.php'      =>  'Orden_Proveedores_Admon_Compras',
      'Perfiles2/Tesorerias/index.php'      =>  'Tesorerias',
      'Perfiles2/Ordenes_Proveedores_Detallado/index.php'      =>  'Ordenes_Proveedores_Detallado',
      'Perfiles2/Inventario_Bajas/index.php'      =>  'Inventario_Bajas',
      'Perfiles2/Inventario_Historial/index.php'      =>  'Inventario_Historial',
      'Perfiles2/Costo_total_VIN/index.php'      =>  'Costo_total_VIN',
      'Perfiles2/Chat_Panamotors/index.php'      =>  'Chat_Panamotors',
      'Perfiles2/Inventario_Admin/index.php'      =>  'Inventario_Admin',
      'Perfiles2/Inventario_Cortes/index.php'      =>  'Inventario_Cortes',
      'Perfiles2/Plantilla_CCP_Nueva/index.php'      =>  'Plantilla_CCP_Nueva',
      'Perfiles2/Cartera_Fuerza_Ventas/index.php'      => 'Cartera_Fuerza_Ventas' ,
      'Perfiles2/Movimiento_Exitoso_General/index.php'      =>  'Movimiento_Exitoso_General',
      'Perfiles2/Credito_Cobranza/index.php'      =>  'Credito_Cobranza',
      'Perfiles2/Ordenes_Proveedores_Clientes/index.php'      =>  'Ordenes_Proveedores_Clientes',
      'Perfiles2/Proveedores_Transacciones/index.php'      =>  'Proveedores_Transacciones',
      'Perfiles2/Proveedores_Prestamos/index.php'      =>  'Proveedores_Prestamos',
      'Perfiles2/Proveedores_Bienes_Raices/index.php'      =>  'Proveedores_Bienes_Raices',
      'Perfiles2/Admon_Compras/index.php'      =>  'Admon_Compras',
      'Perfiles2/Reportes_ejecutivos/index.php'      =>  'Reportes_ejecutivos',
      'Perfiles2/Admon_Edo_Cuenta/index.php'      =>  'Admon_Edo_Cuenta',
      'Perfiles2/Comprobantes_egresos/index.php'      =>  'Comprobantes_egresos',
      'Perfiles2/Solicitud_Compra/index.php'      =>  'Solicitud_Compra',
      'Perfiles2/Wallet/index.php'      =>  'Wallet',
  );

$RutaDireccion = array_search($rol, $Direcciones);
return $RutaDireccion ?  $RutaDireccion : 'logout';
}

public function Busqueda(){

	try {

		if (request()->Tipo == "contactos") {
        /*
        $Proveedores = proveedores::select('nombre','apellidos','idproveedores')->where(function ($query) {
        $query->where('col10','8');
      })->where(function ($query) {
      $query->where('idproveedores','like','%'.request()->Buscar.'%')->
      orWhere('telefono_celular','like','%'.request()->Buscar.'%')->
      orWhere('telefono_otro','like','%'.request()->Buscar.'%')->
      orWhere('idproveedores','like','%'.request()->Buscar.'%')->
      orWhere(
      DB::raw("concat_ws(' ',nombre,apellidos,alias,nomeclatura)")
      ,'like','%'.request()->Buscar.'%');
    })->get();
    */

    $Proveedores = DB::select("select nombre,apellidos,idproveedores,col2 from proveedores where col10='8' AND
    	(idproveedores like '%" . request()->Buscar . "%' OR telefono_celular like '%" . request()->Buscar . "%'
    	OR telefono_otro like '%" . request()->Buscar . "%' OR concat_ws(' ', nombre, apellidos, alias, nomeclatura)
    	like '%" . request()->Buscar . "%') limit 25");

    return $Proveedores;
}else if (request()->Tipo == "carros") {

	$EstadoCP = estado_cuenta_proveedores::select('datos_vin','idcontacto','datos_marca','datos_version','datos_color','datos_modelo')
	->where('datos_vin', 'like','%'.request()->Buscar.'%')->where('visible', 'SI')->get();

	if (sizeof($EstadoCP) == 0) {
		return [];
	}else{

		$Proveedor = [];

		foreach ($EstadoCP as $key => $ECP) {
			$Proveedor[$key]['Proveedor'] = proveedores::select('nombre', 'apellidos','idproveedores')->where('idproveedores', $ECP->idcontacto)->first();
			$Proveedor[$key]['ECP'] = $ECP;
		}

		return $Proveedor;

	}

}else{
	return null;
}


} catch (\Exception $e) {
	return json_encode($e->getMessage());
}
}


public function searchModules(Request $request){
  // return json_encode($request->bus);
	DB::connection()->enableQueryLog();
	$profiles = DB::table('usuarios')
	->join('perfiles', 'usuarios.rol', '=', 'perfiles.rol')
	->select('usuarios.idusuario', 'usuarios.rol',
		'perfiles.direccion' ,'perfiles.perfil_nombre', 'perfiles.descripcion')
	->where('usuarios.idempleados', '=', \Auth::user()->idempleados)
	->where('usuarios.visible', '=', 'SI')
	->where('perfiles.perfil_nombre', 'LIKE', '%'.$request->bus.'%')
	->get();
	$tags = DB::table('usuarios')
	->join('perfiles', 'usuarios.rol', '=', 'perfiles.rol')
	->select('usuarios.idusuario', 'usuarios.rol',
		'perfiles.direccion' ,'perfiles.perfil_nombre', 'perfiles.descripcion','perfiles.tags')
	->where('usuarios.idempleados', '=', \Auth::user()->idempleados)
	->where('usuarios.visible', '=', 'SI')
	->where('perfiles.tags', 'LIKE', '%'.$request->bus.'%')
	->get();
  // $sql ="SELECT , perfiles.tags FROM perfiles INNER JOIN usuarios ON usuarios.rol=perfiles.rol WHERE perfiles.tags LIKE '%$busqueda%' AND usuarios.idempleados='$empleados' and  usuarios.visible='SI'";

	$queries = DB::getQueryLog();
  // return $queries;
  // return $profiles;
	$count = 1;
	$url = route("Caja_Chica.profiles_home");
	$token = csrf_token();
	$styles[0] = '<div class="col-sm12"><b><span style="color:#F9F9F9; "><font size=6>Perfiles</font></span></b></div>';
	foreach ($profiles as $profile) {
		$styles[$count]=
		'<form class="" action="'.$url.'" method="post">
		<input type="hidden" name="_token" value="'.$token.'">
		<div id="primero" class="col-sm-12 mb-3">
		<div>
		<button name="id" type="submit" class="btn rol btn-theme btn-round btn-block shadow txt-btn-dp" value="'.$profile->idusuario.'" id="'.$profile->idusuario.'"> <img src="../public/style_direccionador/'.$profile->direccion.'" style="width: 50px; height: 50px;"> <br> '.$profile->perfil_nombre.'</button>
		<div class="primero" style="background-color: black; opacity: 60%">
		<img src="../public/style_direccionador/'.$profile->direccion.'" style="width: 70px; height: 70px;"> <br>
		<h6 class="mb-4 text-white center text-btn" style="text-align: justify;"> '.$profile->descripcion.'</h6>
		</div>
		</div>
		</div>
		</form>';
		$count++;
	}
	$count = 1;
	$styles_tags[0] ='';
	if ($tags->count()>0) {
    // $styles_tags[0] ='<div class="col-sm-12"><h3><b><span style="color:#EAEAEA;">Perfiles Relacionados</span></b></h3></div>';
		$styles_tags[0] = '<div class="col-sm12"><b><span style="color:#F9F9F9; "><font size=6>Perfiles Relacionados</font></span></b></div>';
		foreach ($tags as $tag) {
			$styles_tags[$count] =
			'<form class="" action="'.$url.'" method="post">
			<input type="hidden" name="_token" value="'.$token.'">
			<div id="primero">
			<div>
			<button name="id" type="submit" class="btn rol btn-dark btn-round btn-block shadow txt-btn-dp" value="'.$tag->idusuario.'" id="'.$tag->idusuario.'"> <img src="../public/style_direccionador/'.$tag->direccion.'" style="width: 50px; height: 50px;"> <br> '.$tag->perfil_nombre.'</button>
			</div>
			</div></br>
			'
			;
			$arreglo_tags = explode(",", $tag->tags);
			foreach ($arreglo_tags as $arreglo_tag) {
				$styles_tags[$count]=$styles_tags[$count].'
				<div style="float: left;">
				<div class="content-tags" style="background: transparent;">
				<button name="id" type="submit" class="rol estilos_boton d-flex" value="'.$tag->idusuario.'" id="'.$tag->idusuario.'">
				<i class="fa fa-tags fa-2x" style="color: white; font-size: 18px; margin-right: 10px; margin-top: 0px; line-height: 30px; "></i>
				<h6 class="mb-4 text-white center" style="text-align: justify;display: inline-block;">  '.$arreglo_tag.'</h6>
				</button>
				</div>
				<br>
				</div>
				';
			}
			$styles_tags[$count]=$styles_tags[$count].'</br></form>';
			$count++;
		}
	}
	return ['profiles'=>$styles,
	'tags'=>$styles_tags];
}
}
