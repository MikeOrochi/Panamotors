<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\usuarios_empleados;
use App\Models\datos_inicio_sesion;
use App\Models\usuarios;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
//use App\User;

use App\Http\Controllers\Admin\AdminController;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except(['logout','LoginExterno','LogOutExteno']);
    }

    protected function guard(){
      return Auth::guard('usuarios');
    }

    public function login(Request $r){

      DB::beginTransaction();
      try {

        $usuario =  usuarios_empleados::where('password', $r->password)->where('visible', 'SI')->first();
        // dd($usuario);
        if($usuario){
          Auth::login($usuario);

          if (Auth::guard('usuarios')->user() != null ){

              $user = Auth::guard('usuarios')->user()->idempleados;

              date_default_timezone_set('America/Mexico_City');
            	$fecha_acceso = date("Y-m-d H:i:s");
              $ip = $_SERVER['REMOTE_ADDR'];

              $InicioSesion = datos_inicio_sesion::createInicioSesion($fecha_acceso, $ip, $r->lat_long, $usuario->idempleados, 'Empleados');

              DB::commit();

              return redirect()->route('admin.profiles')->with([
                'success' => 'Bienvenido ',
                'hola' => 123
              ])->withCookie(cookie('user', $user, 720)
              )->withCookie(cookie('Sitio', 'DualTrucks'));
          }
        }

        return back()->with('error', 'Estas credenciales no coinciden con nuestros registros.');

      } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
        return back()->with('error', $e->getMessage());
      }

    }


    public function LoginExterno($usuario_creador,$password){

      try {
        $password = base64_decode($password);
        $usuario_creador = base64_decode($usuario_creador);


        $usuario =  usuarios_empleados::where('password', $password)->where('visible', 'SI')->first();


        // dd($usuario);
        if($usuario){
          Auth::login($usuario);

          if (Auth::guard('usuarios')->user() != null ){

              $user = Auth::guard('usuarios')->user()->idempleados;

              date_default_timezone_set('America/Mexico_City');
            	$fecha_acceso = date("Y-m-d H:i:s");
              $ip = $_SERVER['REMOTE_ADDR'];

              $InicioSesion = datos_inicio_sesion::createInicioSesion($fecha_acceso, $ip, $lat_long = '?', $usuario->idempleados, 'Empleados');
        			$usuarios = usuarios::select('rol','idusuario')->where('idusuario', $usuario_creador)->where('visible', 'SI')->where('idempleados', $usuario->idempleados)->first();


              return redirect()->route(AdminController::Direccion($usuarios->rol))
              ->withCookie(cookie('user', $user, 720)
              )->withCookie(cookie('Sitio', 'Panamotors'))
              ->withCookie(cookie('usuario_creador', $usuario_creador,720));
          }
        }

        return 'Estas credenciales no coinciden con nuestros registros.';
        //return back()->with('error', 'Estas credenciales no coinciden con nuestros registros.');

      } catch (\Exception $e) {
        //return redirect('https://www.panamotorscenter.com/Des/CCP/direcionador_perfiles.php');
        return $e->getMessage();
        //return back()->with('error', $e->getMessage());
      }
    }

    public function LogOutExteno(){
      \Auth::logout();
      return redirect('https://www.panamotorscenter.com/Prod/CCP/logout.php');
    }

}
