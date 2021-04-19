<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\usuarios_empleados;
use App\Models\usuarios;
use App\Models\bitacora_passwords;

class ChangePasswordAutomaticController extends Controller
{
    // change_password_automatic.changePassword
    // change_password_automatic.verifyTimePassword
    public function changePassword(){
        $proveedor = "";
        $auth_user = \Auth::user();
        $usuario = usuarios::where('idempleados',$auth_user->idempleados)->get()->first();

        $new_password = Crypt::encrypt($usuario->rol."__".bin2hex(random_bytes(10)));
        $verify_password = usuarios_empleados::where('password',$new_password)->get()->first();
        if(!is_Null($verify_password)){
            while(!$verify_password->isEmpty()){
                $new_password = Crypt::encrypt($usuario->rol."__".bin2hex(random_bytes(10)));
                $verify_password = usuarios_empleados::where('password',$new_password)->get()->first();
            }
        }
        return view('auth.change_password',compact('usuario','new_password'));
    }

    public function storePassword(){
        $user = \Auth::user();
        $id_user = $user->idusuarios_empleados;
        DB::beginTransaction();
        try {
            $usuario_empleado = usuarios_empleados::where('idusuarios_empleados',$id_user)->get()->first();
            $fecha_caducidad = new \DateTime($usuario_empleado->fecha_caducidad_password);
            $fecha_actual = new \DateTime(now());

            $new_password=request('nuevo-password');
            $usuario = usuarios::where('idempleados',$usuario_empleado->idempleados)->get()->last();

            $usuario_creador = request()->cookie('usuario_creador');
            $fecha_generacion = (new \DateTime(now()))->format('Y-m-d h:m:s');
            $bitacora_passwords = bitacora_passwords::createBitacoraPasswords($usuario_empleado->password, $new_password, Crypt::decrypt($new_password), $usuario_creador, $fecha_generacion, $fecha_caducidad->format('Y-m-d h:m:s'));

            $next_month = ((new \DateTime(now()))->modify('next month'))->format('Y-m-d h:m:s');

            $usuario_empleado->password = $new_password;
            $usuario_empleado->fecha_creacion_password = $fecha_generacion;
            $usuario_empleado->fecha_caducidad_password = $next_month;
            $usuario_empleado->save();

            \Cookie::forget('usuario_creador');
            \Cookie::forget('user');
            DB::commit();
            return redirect()->route('logout');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
            return json_encode($e->getMessage());
        }
    }

    public function verifyTimePassword(){
        $user = \Auth::user();
        $id_user = $user->idusuarios_empleados;
        $new_password="";
        if(!empty($id_user)){
            DB::beginTransaction();
            try {
                $usuario_empleado = usuarios_empleados::where('idusuarios_empleados',$id_user)->get()->first();
                $fecha_caducidad = new \DateTime($usuario_empleado->fecha_caducidad_password);
                $fecha_actual = new \DateTime(now());
                $date_dif = date_diff($fecha_caducidad, $fecha_actual);
                $days = $date_dif->days;
                $hours = $date_dif->h;
                $minutes = $date_dif->m;
                $seconds = $date_dif->s;
                $cadena_tiempo_restante = "";
                $color_message = "";
                if($fecha_caducidad > $fecha_actual){
                    if($days <= 4 && $days > 0){
                        if($days == 1) {
                            $cadena_tiempo_restante = "La contraseña caducará en ".$days." día.";
                            $color_message = "rgba(100, 8, 12, 0.9)";
                        }
                        if($days > 1){
                            $cadena_tiempo_restante = "La contraseña caducará en ".$days." días.";
                            $color_message = "rgba(152, 154, 13, 0.9)";
                        }
                    }else{
                        if($days == 0){
                            if($hours > 0){
                                if($hours == 1)$cadena_tiempo_restante = "La contraseña caducará en ".$hours." hr. con ".$minutes." m.";
                                if($hours > 1)$cadena_tiempo_restante = "La contraseña caducará en ".$hours." hrs. con ".$minutes." m.";
                            }else {
                                if($hours == 0 && $minutes > 1)$cadena_tiempo_restante = "La contraseña caducará en ".$minutes." minutos.";
                                if($hours == 0 && $minutes == 1)$cadena_tiempo_restante = "La contraseña caducará en ".$minutes." minuto.";
                                if($hours == 0 && $minutes == 0 && $seconds > 0)$cadena_tiempo_restante = "La contraseña caducará en ".$seconds." segundos.";
                            }
                            $color_message = "rgba(0, 0, 0, 0.9)";
                        }
                    }
                }else {
                    $usuario = usuarios::where('idempleados',$usuario_empleado->idempleados)->get()->last();
                    $new_password = Crypt::encrypt($usuario->rol."__".bin2hex(random_bytes(10)));
                    $verify_password = usuarios_empleados::where('password',$new_password)->get()->first();
                    if(!is_Null($verify_password)){
                        while(!$verify_password->isEmpty()){
                            $new_password = Crypt::encrypt($usuario->rol."__".bin2hex(random_bytes(10)));
                            $verify_password = usuarios_empleados::where('password',$new_password)->get()->first();
                        }
                    }
                    $usuario_creador = request()->cookie('usuario_creador');
                    $fecha_generacion = (new \DateTime(now()))->format('Y-m-d h:m:s');
                    $bitacora_passwords = bitacora_passwords::createBitacoraPasswords($usuario_empleado->password, $new_password, Crypt::decrypt($new_password), $usuario_creador, $fecha_generacion, $fecha_caducidad->format('Y-m-d h:m:s'));

                    $usuario_empleado->password = $new_password;
                    $usuario_empleado->save();

                    \Cookie::forget('usuario_creador');
                    \Cookie::forget('user');
                    DB::commit();
                    return redirect()->route('logout');
                }
                DB::commit();
                return json_encode(['tiempo_restante' => $cadena_tiempo_restante, 'color_message'=>$color_message] );

            } catch (\Exception $e) {
                DB::rollback();
                return json_encode($e->getMessage());
                return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
            }
        }

    }




}
