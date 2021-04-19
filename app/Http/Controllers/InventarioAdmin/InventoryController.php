<?php

namespace App\Http\Controllers\InventarioAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\inventario;
use App\Models\inventario_cambios;
use App\Models\inventario_trucks;
use App\Models\inventario_dinamico;
use App\Models\inventario_galeria_trucks;
use App\Models\inventario_galeria;
use App\Models\inventario_vistas_trucks;
use App\Models\inventario_vistas_auto;
use App\Models\publicacion_vin_fotos;
use App\Models\inventario_d_tipos_especificaciones;
use App\Models\tipos_especificaciones_vin;
use App\Models\tipos_sub_especificaciones_vin;
use App\Models\usuarios;
use App\Models\entidad_autos;
use App\Models\razon_social;
use App\Models\estatus_unidad;
use App\Models\ubicacion;
use App\Models\segmentacion;
use App\Models\inventario_real_puesto_venta;
use App\Models\inventario_cambios_trucks;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(){
        $resultxxx=inventario::where('estatus_unidad','!=','Legal')->where('estatus_unidad','!=','Devolución')
        ->where('estatus_unidad','!=','N/A') ->where('estatus_unidad','!=','Traslados')->where('estatus_unidad','!=','Utilitaria')
        ->where('marca','!=','Pendiente') ->where('marca','!=','Panamotors Premium, S.A. de C.V.')->where('marca','!=','Chicles')
        ->where('marca','!=','Inventario')->where('visible','SI')->orderBy('idinventario','ASC')->get();
        $count = count($resultxxx);
        // while ( $filaxxx = mysql_fetch_array($resultxxx)) {$count++;}


        $resultxxx1=inventario_trucks::where('estatus_unidad','!=','Legal')->where('estatus_unidad','!=','Devolución')->where('estatus_unidad','!=','N/A')
        ->where('estatus_unidad','!=','Traslados')->where('estatus_unidad','!=','Utilitaria')->where('marca','!=','Pendiente')->where('marca','!=','Panamotors Premium, S.A. de C.V.')
        ->where('marca','!=','Chicles')->where('marca','!=','Inventario')->where('visible','!=','SI')->orderBy('idinventario_trucks','ASC')->get();
        $count1=count($resultxxx1);
        // while ( $filaxxx1 = mysql_fetch_array($resultxxx1)) {$count1++;}
        $suma_unidades =  count($resultxxx) + count($resultxxx1);

        // $result5="SELECT marca,count(marca) as cantidad FROM inventario WHERE (estatus_unidad <> 'Legal' and estatus_unidad <> 'Devolución' and estatus_unidad <> 'N/A' and estatus_unidad <> 'Traslados' and estatus_unidad <> 'Utilitaria') AND (marca <> 'Pendiente'  and  marca <> 'Panamotors Premium, S.A. de C.V.' and  marca <> 'Chicles' AND marca<> 'Inventario' $sql5) and visible='SI' group by marca ASC";
        $result5=inventario::where('estatus_unidad','!=','Legal')->where('estatus_unidad','!=','Devolución')
        ->where('estatus_unidad','!=','N/A')->where('estatus_unidad','!=','Traslados')->where('estatus_unidad','!=','Utilitaria')
        ->where('marca','!=','Pendiente')->where('marca','!=','Panamotors Premium, S.A. de C.V.')->where('marca','!=','Chicles')->where('marca','!=','Inventario')
        ->where('visible','!=','SI')->orderBy('marca','ASC')->get()->groupBy('marca');

        $marcas_cantidad = collect([]);
        foreach ($result5 as $key => $fila5) {
            $mar = strtolower(trim("$key"));
            $img = str_replace(" ", "", $mar);
            $row = (object)[
                'marca'=>strtoupper("$key"),
                'cantidad'=>count($fila5),
                'name_encrypt' => Crypt::encrypt($key),
                'img'=>$img
            ];
            $marcas_cantidad->push($row);
        }

        $result7=inventario_trucks::where('estatus_unidad','!=','Legal')->where('estatus_unidad','!=','Devolución')
        ->where('estatus_unidad','!=','N/A')->where('estatus_unidad','!=','Traslados')->where('estatus_unidad','!=','Utilitaria')
        ->where('marca','!=','Pendiente')->where('marca','!=','Panamotors Premium, S.A. de C.V.')->where('marca','!=','Chicles')->where('marca','!=','Inventario')
        ->where('visible','!=','SI')->orderBy('marca','ASC')->get()->groupBy('marca');

        $marcas_trucks_cantidad = collect([]);
        foreach ($result7 as $key => $fila5) {
            $mar = strtolower(trim("$key"));
            $img = str_replace(" ", "", $mar);
            $row = (object)[
                'marca'=>strtoupper("$key"),
                'cantidad'=>count($fila5),
                'name_encrypt' => Crypt::encrypt($key),
                'img'=>$img
            ];
            $marcas_trucks_cantidad->push($row);
        }



        return view('InventarioAdmin.index',compact('suma_unidades','count','count1','marcas_cantidad','marcas_trucks_cantidad'));
    }

    public function showMark($type, $marca){
        // $count =0;
        // if ($cero == 'MA==') {
        //   $sql20= "SELECT *FROM inventario WHERE (estatus_unidad <> 'Legal' and estatus_unidad <> 'Devolución' and estatus_unidad <> 'N/A' and estatus_unidad <> 'Traslados' and estatus_unidad <> 'Utilitaria' and precio_piso = '0' and estatus_unidad <> 'VENDIDO') AND (marca <> 'Pendiente'  and  marca <> 'Panamotors Premium, S.A. de C.V.' and  marca <> 'Chicles' AND marca<> 'Inventario' $sql5 and precio_piso = '0' and estatus_unidad <> 'VENDIDO') and visible='SI'";
        // } else {
        //   $sql20= "SELECT *FROM inventario WHERE (estatus_unidad <> 'Legal' and estatus_unidad <> 'Devolución' and estatus_unidad <> 'N/A' and estatus_unidad <> 'Traslados' and estatus_unidad <> 'Utilitaria') AND (marca <> 'Pendiente'  and  marca <> 'Panamotors Premium, S.A. de C.V.' and  marca <> 'Chicles' AND marca<> 'Inventario' $sql5) and visible='SI'";
        // }
        $inventario_unidades =""; $inventario_trucks = "";
        if($type == "unidades"){
            $marca_decrypt = Crypt::decrypt($marca);
            $inventario_unidades= inventario::where('estatus_unidad','!=','Legal' )->where('estatus_unidad','!=','Devolución')->where('estatus_unidad','!=','N/A')
            ->where('estatus_unidad','!=','Traslados')->where('estatus_unidad','!=','Utilitaria')->where('marca','!=','Pendiente')
            ->where('marca','!=','Panamotors Premium, S.A. de C.V.')->where('marca','!=','Chicles')->where('marca','!=','Inventario')
            ->where('visible','!=','SI')->where('marca',$marca_decrypt)->get();


            $resultxx = inventario::where('visible','SI')->get()->last();

            $fecha_act = date_create($resultxx->fecha_guardado);
            $actualizacion_inventario = $fecha_act->format("d-m-Y H:i:s");

            $resultx1=inventario_cambios::all()->last();

            $fecha_act_cambios = date_create($resultx1->fecha);
            $actualizacion_cambios = $fecha_act_cambios->format("d-m-Y H:i:s");
            if ($actualizacion_inventario > $actualizacion_cambios) {
              $actualizacion = $actualizacion_inventario;
            }else{
              $actualizacion = $actualizacion_cambios;
            }
        }
        if($type == "trucks"){
            $marca_decrypt = Crypt::decrypt($marca);
            $inventario= inventario_trucks::where('estatus_unidad','!=','Legal' )->where('estatus_unidad','!=','Devolución')->where('estatus_unidad','!=','N/A')
            ->where('estatus_unidad','!=','Traslados')->where('estatus_unidad','!=','Utilitaria')->where('marca','!=','Pendiente')
            ->where('marca','!=','Panamotors Premium, S.A. de C.V.')->where('marca','!=','Chicles')->where('marca','!=','Inventario')
            ->where('visible','!=','SI')->where('marca',$marca_decrypt)->get();
            // $inventario = inventario_trucks::all();

            $resultxx = inventario_trucks::where('visible','SI')->get()->last();

            $fecha_act = date_create($resultxx->fecha_guardado);
            $actualizacion_inventario = $fecha_act->format("d-m-Y H:i:s");

            $resultx1=inventario_cambios::all()->last();

            $fecha_act_cambios = date_create($resultx1->fecha);
            $actualizacion_cambios = $fecha_act_cambios->format("d-m-Y H:i:s");
            if ($actualizacion_inventario > $actualizacion_cambios) {
              $actualizacion = $actualizacion_inventario;
            }else{
              $actualizacion = $actualizacion_cambios;
            }

            $inventario_trucks = collect([]);
            foreach( $inventario as $truck) {
                $row = (object)["info"=>$truck,"motor"=>"", "eje_delantero"=>"", 'motor'=>"", 'eje_delantero'=>"", 'eje_trasero'=>"", 'rodado'=>"",
                'camarote'=>"", 'tipo_tracto'=>"", 'potencia'=>"", 'velocidades'=>"" ];

                $result6 = inventario_dinamico::where('columna','motor')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$truck->idinventario_trucks)->get();
                if (count($result6) == 0) {
                    $row->motor = "Pendiente";
                }else{
                    foreach ($result6 as $fila6) {
                        $row->motor = "$fila6->contenido";
                    }
                }

                $result7 = inventario_dinamico::where('columna','eje delantero')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$truck->idinventario_trucks)->get();
                if (count($result7) == 0) {
                    $row->eje_delantero = "Pendiente";
                }else{
                    foreach ($result7 as $fila7) {
                        $row->eje_delantero = "$fila7->contenido";
                    }
                }

                $result8 = inventario_dinamico::where('columna','eje trasero')->where('visible','SI')->where('tipo_unidad','Trucks' )->where('idinventario',$truck->idinventario_trucks)->get();
                if (count($result8) == 0) {
                    $row->eje_trasero = "Pendiente";
                }else{
                    foreach ($result8 as $fila8) {
                        $row->eje_trasero = "$fila8->contenido";
                    }
                }

                $result8 = inventario_dinamico::where('columna','rodado')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$truck->idinventario_trucks)->get();
                if (count($result8) == 0) {
                    $row->rodado = "Pendiente";
                }else{
                    foreach($result8 as $fila8) {
                        $row->rodado = "$fila8->contenido";
                    }
                }

                $result10 = inventario_dinamico::where('columna','camarote')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$truck->idinventario_trucks)->get();
                if (count($result10) == 0) {
                    $row->camarote = "Pendiente";
                }else{
                    foreach ($result10 as $fila10) {
                        $row->camarote = "$fila10->contenido";
                    }
                }

                $result11 = inventario_dinamico::where('columna','tipo_tracto')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$truck->idinventario_trucks)->get();
                if (count($result11) == 0) {
                    $row->tipo_tracto = "Pendiente";
                }else{
                    foreach($result11 as $fila11) {
                        $row->tipo_tracto = "$fila11->contenido";
                    }
                }

                $result12 = inventario_dinamico::where('columna','potencia')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$truck->idinventario_trucks)->get();
                if (count($result12) == 0) {
                    $row->potencia = "Pendiente";
                }else{
                    foreach ($result12 as $fila12) {
                        $row->potencia = "$fila12->contenido";
                    }
                }

                $result13 = inventario_dinamico::where('columna','velocidades')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$truck->idinventario_trucks)->get();
                if (count($result13) == 0) {
                    $row->velocidades = "Pendiente";
                }else{
                    foreach($result13 as $fila13) {
                        $row->velocidades = "$fila13->contenido";
                    }
                }

                $inventario_trucks->push($row);


            }//fin while










        }

        return view('InventarioAdmin.show_mark',compact('inventario_unidades','inventario_trucks','type','actualizacion'));

    }

    public function showDetailsUnit($type, $id){
        if($type == "truck"){
            $inventario = inventario_trucks::where('idinventario_trucks',$id)->get()->first();
            $publicacion_vin_fotos = publicacion_vin_fotos::where('vin',$inventario->vin_numero_serie)->where('visible','SI')->get();
            $foto = "";
            if(!$publicacion_vin_fotos->isEmpty()) $foto = $publicacion_vin_fotos->first()->ruta_foto;

            $inventario_galeria_trucks = inventario_galeria_trucks::where('idinventario_trucks',$id)->get();
            $inventario_vistas_trucks = inventario_vistas_trucks::all();

            $inventario_cambios_trucks= inventario_cambios_trucks::where('idinventario_trucks',$id)->orderBy('fecha','DESC')->get();
            $inventario_cambios_trucks_collect = collect([]);
            foreach ($inventario_cambios_trucks as $key => $value) {
                $usuario = usuarios::where('idusuario',$value->usuario)->get()->first()->nombre_usuario;
                $row = (object)['info'=>$value, 'usuario'=>$usuario];
                $inventario_cambios_trucks_collect->push($row);
            }
        }
        if($type == "unidad"){
            $inventario = inventario::where('idinventario',$id)->get()->first();
            $publicacion_vin_fotos = publicacion_vin_fotos::where('vin',$inventario->vin_numero_serie)->where('visible','SI')->get();
            $foto = "";
            if(!$publicacion_vin_fotos->isEmpty()) $foto = $publicacion_vin_fotos->first()->ruta_foto;

            $inventario_galeria_trucks = inventario_galeria::where('idinventario',$id)->get();
            $inventario_vistas_trucks = inventario_vistas_auto::all();

            $inventario_cambios_trucks= inventario_cambios::where('idinventario',$id)->orderBy('fecha','DESC')->get();
            $inventario_cambios_trucks_collect = collect([]);
            foreach ($inventario_cambios_trucks as $key => $value) {
                $usuario = usuarios::where('idusuario',$value->usuario)->get()->first()->nombre_usuario;
                $row = (object)['info'=>$value, 'usuario'=>$usuario];
                $inventario_cambios_trucks_collect->push($row);
            }
        }
        return view('InventarioAdmin.units_trucks.show_details',compact('inventario','foto','inventario_galeria_trucks','inventario_vistas_trucks','inventario_cambios_trucks_collect','type'));
    }

    public function editDetailsUnit($type, $id, $vin){
        $empleados = \Auth::user()->idempleados;
        if($type == "unidad"){
            $inventario = inventario::where('idinventario',$id)->where('vin_numero_serie',$vin)->get()->last();
            $entidades = entidad_autos::orderBy('estado','ASC')->get();
            $razones_sociales = razon_social::all();
            $segmentacion = segmentacion::orderBy('nombre','ASC')->get();
            $tipos = inventario::orderBy('tipo')->get()->groupBy('tipo');
            $estatuses = estatus_unidad::orderBy('estatus')->get();
            $ubicaciones = ubicacion::orderBy('nomenclatura','ASC')->get();
            $inventario_dinamico = inventario_dinamico::where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$id)->where('columna','!=','facturable')->where('columna','!=','iva') ->where('columna','!=','estatus')->get();
            // $inventario_dinamico = inventario_dinamico::where('visible','SI')->where('tipo_unidad','Unidad')->where('columna','!=','facturable')->where('columna','!=','iva') ->where('columna','!=','estatus')->get()->take(10);
            $inventario_dinamico_collect = collect([]);

            $con=0;
            $v=0;
            $v2x=1;
            $v99=20000000;
            $espe_ca = "";
            $epe_sub = "";
            foreach($inventario_dinamico as $fila9) {
                $enca1	="$fila9->columna";
                $enca2	="$fila9->columna";
                $info1="$fila9->contenido";
                $ids_id="$fila9->idinventario_dinamico";
                $enca2 = str_replace("_", " ",  ucfirst (mb_strtolower($enca2, 'UTF-8')));

                $resultado100 = inventario_d_tipos_especificaciones::where('idinventario_dinamico',$ids_id)->where('visible','SI')->get();
                if (count($resultado100) == 0) {
                    $espe_ca = "<option value=''>Eliga opción...</option>";
                    $epe_sub = "<option value=''>Eliga opción...</option>";
                }else{
                    foreach($resultado100 as $fila100) {
                        $idtipos_sub_especificaciones_vin = "$fila100->idtipos_sub_especificaciones_vin";
                        $idtipos_especificaciones_vin = "$fila100->idtipos_especificaciones_vin";

                        $resultado101 = tipos_especificaciones_vin::where('idtipos_especificaciones_vin',$idtipos_especificaciones_vin)->where('visible','SI')->get();
                        foreach($resultado101 as $fila101) {
                            $idtipos_especificaciones_vin_selec = "$fila101->idtipos_especificaciones_vin";
                            $tipo_es = "$fila101->tipo";
                            $espe_ca = "<option value='$idtipos_especificaciones_vin_selec'>$tipo_es</option>";
                        }

                        $resultado102 = tipos_sub_especificaciones_vin::where('idtipos_sub_especificaciones_vin',$idtipos_sub_especificaciones_vin)->where('visible','SI')->get();
                        foreach ($resultado102 as $fila102) {
                            $idtipos_especificaciones_vin_selec2 = "$fila102->idtipos_sub_especificaciones_vin";
                            $tipo_es2 = "$fila102->tipo";
                            $epe_sub = "<option value='$idtipos_especificaciones_vin_selec2'>$tipo_es2</option>";
                        }


                    }

                }

                if ($enca1 !="" || $info1!="" ) {

                    $string = '
                    <div class="row col-sm-12 form-group">
                    <div class="col-sm-6 form-group">
                    <label for="">'.$enca2.'</label>
                    <input type="hidden" name="caracteristicas[]"class="form-control"  value="'.$enca1.'" required="">
                    <input type="text" name="informacion[]"class="form-control"  value="'.$info1.'" required="">
                    </div>

                    <div class="col-sm-3 form-group">
                    <label for="">Tipo '.$v2x.'</label>
                    <div class="content-select">
                    <select name="tipo_especificaciones[]" class="form-control tipo_especificaciones2 tipo_especificaciones2'.$v99.'" id="'.$v99.'" onchange="nodo_sub_especificaiones('.$v99.')"  required>
                    '.$espe_ca.'
                    <option value="1">Especificaciones Tecnicas</option>
                    <option value="2">Dimensiones</option>
                    <option value="3">Equipamiento</option>
                    </select>
                    <i></i>
                    </div>
                    </div>

                    <div class="col-sm-3 form-group">
                    <label for="">Sub Tipo '.$v2x.'</label>
                    <select name="tipo_sub_especificaciones[]" class="form-control  tipo_sub_especificaciones2'.$v99.'"  required>
                    '.$epe_sub.'
                    </select>
                    </div>
                    </div> ';
                    $inventario_dinamico_collect->push($string);
                }
                $v++;
                $v99++;
                $v2x++;
                $con++;
            }

        }
        if($type == "truck"){
            $inventario = inventario_trucks::where('idinventario_trucks',$id)->where('vin_numero_serie',$vin)->get()->last();
            $transmisiones = inventario_trucks::all()->where('visible','SI')->groupBy('transmision'); ///
            $entidades = entidad_autos::orderBy('estado','ASC')->get();
            $razones_sociales = razon_social::all();
            $segmentacion = segmentacion::orderBy('nombre','ASC')->get();
            $estatuses = estatus_unidad::orderBy('estatus')->get();
            $ubicaciones = ubicacion::orderBy('nomenclatura','ASC')->get();

            /************************************************ INFORMACION EXTRA ************************************************/

            $inventario_dinamico_truck = (object)["motor"=>"", "eje_delantero"=>"", 'motor'=>"", 'eje_delantero'=>"", 'eje_trasero'=>"", 'rodado'=>"",
            'camarote'=>"", 'tipo_tracto'=>"", 'potencia'=>"", 'velocidades'=>"" ];;
            $motor = inventario_dinamico::where('columna','motor')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$id)->get();
            if (count($motor) == 0) {
                $inventario_dinamico_truck->motor = "Pendiente";
            }else{
                foreach ($motor as $fila6) {
                    $inventario_dinamico_truck->motor = "$fila6->contenido";
                }
            }

            $eje_delantero = inventario_dinamico::where('columna','eje delantero')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$id)->get();
            if (count($eje_delantero) == 0) {
                $inventario_dinamico_truck->eje_delantero = "Pendiente";
            }else{
                foreach ($eje_delantero as $fila7) {
                    $inventario_dinamico_truck->eje_delantero = "$fila7->contenido";
                }
            }

            $eje_trasero = inventario_dinamico::where('columna','eje trasero')->where('visible','SI')->where('tipo_unidad','Trucks' )->where('idinventario',$id)->get();
            if (count($eje_trasero) == 0) {
                $inventario_dinamico_truck->eje_trasero = "Pendiente";
            }else{
                foreach ($eje_trasero as $fila8) {
                    $inventario_dinamico_truck->eje_trasero = "$fila8->contenido";
                }
            }

            $rodado = inventario_dinamico::where('columna','rodado')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$id)->get();
            if (count($rodado) == 0) {
                $inventario_dinamico_truck->rodado = "Pendiente";
            }else{
                foreach($rodado as $fila8) {
                    $inventario_dinamico_truck->rodado = "$fila8->contenido";
                }
            }

            $camarote = inventario_dinamico::where('columna','camarote')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$id)->get();
            if (count($camarote) == 0) {
                $inventario_dinamico_truck->camarote = "Pendiente";
            }else{
                foreach ($camarote as $fila10) {
                    $inventario_dinamico_truck->camarote = "$fila10->contenido";
                }
            }

            $tipo_tracto = inventario_dinamico::where('columna','tipo_tracto')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$id)->get();
            if (count($tipo_tracto) == 0) {
                $inventario_dinamico_truck->tipo_tracto = "Pendiente";
            }else{
                foreach($tipo_tracto as $fila11) {
                    $inventario_dinamico_truck->tipo_tracto = "$fila11->contenido";
                }
            }

            $potencia = inventario_dinamico::where('columna','potencia')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$id)->get();
            if (count($potencia) == 0) {
                $inventario_dinamico_truck->potencia = "Pendiente";
            }else{
                foreach ($potencia as $fila12) {
                    $inventario_dinamico_truck->potencia = "$fila12->contenido";
                }
            }

            $velocidades = inventario_dinamico::where('columna','velocidades')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$id)->get();
            if (count($velocidades) == 0) {
                $inventario_dinamico_truck->velocidades = "Pendiente";
            }else{
                foreach($velocidades as $fila13) {
                    $inventario_dinamico_truck->velocidades = "$fila13->contenido";
                }
            }

            /************************************************ OPCIONES PARA RELLENAR CAMPOS ************************************************/
            $options_trucks = (object)["motor"=>collect([]), "eje_delantero"=>collect([]), 'motor'=>collect([]), 'eje_delantero'=>collect([]), 'eje_trasero'=>collect([]), 'rodado'=>collect([]),
            'camarote'=>collect([]), 'tipo_tracto'=>collect([]), 'potencia'=>collect([]), 'velocidades'=>collect([])];

            $result6 = inventario_dinamico::where('columna','motor')->where('visible','SI')->where('tipo_unidad','Trucks')->get()->groupBy('contenido');
            foreach ($result6 as $key => $fila6) {
                $options_trucks->motor->push($key);
            }

            $result7 = inventario_dinamico::where('columna','eje delantero')->where('visible','SI')->where('tipo_unidad','Trucks')->get()->groupBy('contenido');
            foreach ($result7 as $key => $fila7) {
                $options_trucks->eje_delantero->push($key);
            }

            $result8 = inventario_dinamico::where('columna','eje trasero')->where('visible','SI')->where('tipo_unidad','Trucks' )->get()->groupBy('contenido');
            foreach ($result8 as $key => $fila8) {
                $options_trucks->eje_trasero->push($key);
            }

            $result8 = inventario_dinamico::where('columna','rodado')->where('visible','SI')->where('tipo_unidad','Trucks')->get()->groupBy('contenido');
            foreach($result8 as $key => $fila8) {
                $options_trucks->rodado->push($key);
            }

            $result10 = inventario_dinamico::where('columna','camarote')->where('visible','SI')->where('tipo_unidad','Trucks')->get()->groupBy('contenido');
            foreach ($result10 as $key => $fila10) {
                $options_trucks->camarote->push($key);
            }

            $result11 = inventario_dinamico::where('columna','tipo_tracto')->where('visible','SI')->where('tipo_unidad','Trucks')->get()->groupBy('contenido');
            foreach($result11 as $key => $fila11) {
                $options_trucks->tipo_tracto->push($key);
            }

            $result12 = inventario_dinamico::where('columna','potencia')->where('visible','SI')->where('tipo_unidad','Trucks')->get()->groupBy('contenido');
            foreach ($result12 as $key => $fila12) {
                $options_trucks->potencia->push($key);
            }

            $result13 = inventario_dinamico::where('columna','velocidades')->where('visible','SI')->where('tipo_unidad','Trucks')->get()->groupBy('contenido');
            foreach($result13 as $key => $fila13) {
                $options_trucks->velocidades->push($key);
            }



        }


        return view('InventarioAdmin.units_trucks.edit',compact('inventario','entidades','razones_sociales','segmentacion','tipos','estatuses',
                    'ubicaciones','inventario_dinamico','empleados','inventario_dinamico_collect','type','transmisiones','options_trucks','inventario_dinamico_truck'));
    }

    public function storeEditDetailsUnit(){
        DB::beginTransaction();
        try {
            $usuario_creador = request()->cookie('usuario_creador');//usuario clave
            $vin = Crypt::decrypt(request('v'));
            $idinventario = Crypt::decrypt(request('idi'));
            $marca = request('marca');
            $version = request('version');
            $color = request('color');
            $modelo = request('modelo');
            $precio_piso=request('precio_piso');
            $precio_digital = request('precio_digital');
            $transmision = request('transmision');
            $vin_numero_serie = request('vin_numero_serie');
            $procedencia = request('procedencia');
            $matricula = request('matricula');
            $entidad=request('entidad');
            $fecha_apertura = request('fecha_apertura');
            $fecha_ingreso = request('fecha_ingreso');
            $fecha_ingreso_taller = request('fecha_ingreso_taller');
            $fecha_salida_piso = request('fecha_salida_piso');
            $razon_social_ingreso = request('razon_social_ingreso');
            $kilometraje = request('kilometraje');
            $segmentacion = request('segmentacion');
            $estatus_unidad = request('estatus_unidad');
            $ubicacion = request('ubicacion');
            $comentarios = request('comentarios');
            $consignacion = request('consignacion');
            $publicado = request('publicado');
            date_default_timezone_set('America/Mexico_City');
            $fechaactual= date("Y-m-d H:i:s");

            $facturable = 'Pendiente';
            $iva = request('iva');
            $estatus = request('estatus');

            $tipo_unidad = request('tipo');
            $segmento_unidad = request('segmento');
            $caracteristicas = request('caracteristicas');
            $informacion = request('informacion');
            $tipo_especificaciones = request('tipo_especificaciones');
            $tipo_sub_especificaciones = request('tipo_sub_especificaciones');

            // $otra_segmmentacion = request('otra_segmentacion');
            $otra_segmmentacion = "N/A";
            // $nombre_prestamo = request('nombre_prestamo');
            $nombre_prestamo = "N/A";
            // $nivel_pase = request('nivel_pase');
            $nivel_pase = "N/A";

            $array_caracteristicas = array();

            $c = 0;
            $c2 = 0;
            $c8 = 0;
            $c9 = 0;
            if(!empty($caracteristicas)){
                foreach ($caracteristicas as $key => $value) {
                    $value = trim($value);
                    $value = str_replace("  ", " ",  $value);
                    $value = str_replace("   ", " ",  $value);
                    $value = str_replace("    ", " ",  $value);
                    $value = str_replace("     ", " ",  $value);
                    $value = str_replace("      ", " ",  $value);
                    $value = str_replace(" ", "_",  $value);
                    $array_caracteristicas[$c][0] = $value;
                    $c++;
                }

                foreach ($informacion as $key2 => $value2) {
                    $array_caracteristicas[$c2][1] = $value2;
                    $c2++;
                }

                foreach ($tipo_especificaciones as $key8 => $value8) {
                    $array_caracteristicas[$c8][2] = $value8;
                    $c8++;
                }

                foreach ($tipo_sub_especificaciones as $key9 => $value9) {
                    $array_caracteristicas[$c9][3] = $value9;
                    $c9++;
                }
            }

            $cambios = "";
            $fecha_creacion = Crypt::decrypt(request('f'));
            $result=inventario::where('idinventario',$idinventario)->get();
            foreach($result as $fila) {
                $idinventario_bd="$fila->idinventario";
                $vin_numero_serie_bd="$fila->vin_numero_serie";
                $marca_bd="$fila->marca";
                $version_bd="$fila->version";
                $color_bd="$fila->color";
                $modelo_bd="$fila->modelo";
                $precio_piso_bd="$fila->precio_piso";
                $precio_digital_bd="$fila->precio_digital";
                $transmision_bd="$fila->transmision";
                $procedencia_bd="$fila->procedencia";
                $matricula_bd="$fila->matricula";
                $entidad_bd="$fila->entidad";
                $fecha_apertura_bd="$fila->fecha_apertura";
                $fecha_ingreso_bd="$fila->fecha_ingreso";
                $fecha_ingreso_taller_bd="$fila->fecha_ingreso_taller";
                $fecha_salida_piso_bd="$fila->fecha_salida_piso";
                $razon_social_ingreso_bd="$fila->razon_social_ingreso";
                $kilometraje_bd="$fila->kilometraje";
                $segmentacion_bd="$fila->segmentacion";
                $estatus_unidad_bd="$fila->estatus_unidad";
                $ubicacion_bd="$fila->ubicacion";
                $consignacion_bd="$fila->consignacion";
                $comentarios_bd="$fila->comentarios";
                $publicado_bd="$fila->publicado";
                $nivel_pase_bd="$fila->mercadolibre";

                $segmento_bd="$fila->segmento";
                $tipo_bd="$fila->tipo";

                $result3 = inventario_dinamico::where('columna','facturable')->where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$idinventario)->get();
                if (count($result3) == 0) {
                    $fac = "Pendiente";
                    // createInventarioDinamico( $columna, $contenido, $idinventario, $tipo_unidad, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado )
                    $result5 = inventario_dinamico::createInventarioDinamico('facturable',$facturable,$idinventario,'Unidad','SI',$usuario_creador,$fecha_creacion,$fechaactual);
                }else{
                    foreach ($result3 as $fila3) {
                        $fac = "$fila3->contenido";
                    }
                }
                $result4 = inventario_dinamico::where('columna','iva')->where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$idinventario)->get();
                if (count($result4) == 0) {
                    $iv = "Pendiente";
                    $result6 = inventario_dinamico::createInventarioDinamico('iva',$iva,$idinventario,'Unidad','SI',$usuario_creador,$fecha_creacion,$fechaactual);
                }else{
                    foreach ($result4 as $fila4) {
                        $iv = "$fila4->contenido";
                    }
                }

                $result12 = inventario_dinamico::where('columna','estatus')->where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$idinventario)->get();
                if (count($result12) == 0) {
                    $est = "Pendiente";
                    $result13 = inventario_dinamico::createInventarioDinamico('estatus',$estatus,$idinventario,'Unidad','SI',$usuario_creador,$fecha_creacion,$fechaactual);
                }else{
                    foreach($result12 as $fila12) {
                        $est = "$fila12->contenido";
                    }
                }


                $c3 = 0;
                $v3 = count($array_caracteristicas);
                $carac  = "";
                $info  = "";
                if ($v3 != 0) {
                    while ($c3 < $v3) {
                        $carac = $array_caracteristicas[$c3][0];
                        $info = $array_caracteristicas[$c3][1];
                        $ides = $array_caracteristicas[$c3][2];
                        $ides_sub = $array_caracteristicas[$c3][3];

                        $result39 = inventario_dinamico::where('columna',$carac)->where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$idinventario)->get();
                        if (count($result39) == 0) {
                            $info_ant = "Pendiente";
                            $query10= inventario_dinamico::createInventarioDinamico($carac,$info,$idinventario,'Unidad','SI',$usuario_creador,$fecha_creacion,$fechaactual);
                            if ($query10) {
                                // foreach ($query10 as $key => $row1) {
                                    $idmovimiento = trim($query10->idinventario_dinamico);
                                // }
                            }
                            // createInventarioTiposEspecificaciones( $idinventario_dinamico, $idtipos_sub_especificaciones_vin, $idtipos_especificaciones_vin, $usuario_creador, $visible, $fecha_creacion, $fecha_guardado ){
                            $result50 = inventario_d_tipos_especificaciones::createInventarioTiposEspecificaciones($idmovimiento,$ides_sub,$ides,$usuario_creador,'SI',$fecha_creacion,$fechaactual);

                        }else{
                            foreach($result39 as $fila39) {
                                $info_ant = "$fila39->contenido";
                                $idinventario_dinamico_ant = "$fila39->idinventario_dinamico";
                            }
                        }
                        if ($info_ant!=$info) {
                            $cambios.="$carac de: <b>$info_ant</b> fue actualizada a: <b>$info</b><br>";
                        }
                        $result40 = inventario_dinamico::where('columna',$carac)->where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$idinventario)->get()->last();
                        $result40->contenido = $info;

                        $resultado60 = inventario_d_tipos_especificaciones::where('idinventario_dinamico',$idinventario_dinamico_ant)->where('visible','SI')->get();
                        if (count($resultado60) == 0) {
                            $result50 = inventario_d_tipos_especificaciones::createInventarioTiposEspecificaciones($idinventario_dinamico_ant,$ides_sub,$ides,$usuario_creador,'SI',$fecha_creacion,$fechaactual);
                        }else{
                            foreach($resultado60 as $fila60) {
                                $idtipos_sub_especificaciones_vin_ant = "$fila60->idtipos_sub_especificaciones_vin";
                                $idtipos_especificaciones_vin_ant = "$fila60->idtipos_especificaciones_vin";
                            }

                            $resultado63 = tipos_especificaciones_vin::where('idtipos_especificaciones_vin',$idtipos_especificaciones_vin_ant)->where('visible','SI')->get();
                            foreach ($resultado63 as $fila63) {
                                $tipo_es_an = "$fila63->tipo";
                            }

                            $resultado64 = tipos_especificaciones_vin::where('idtipos_especificaciones_vin',$ides)->where('visible','SI')->get();
                            foreach($resultado64 as $fila64) {
                                $tipo_es_nu = "$fila64->tipo";
                            }

                            $resultado65 = tipos_sub_especificaciones_vin::where('idtipos_sub_especificaciones_vin',$idtipos_sub_especificaciones_vin_ant)->where('visible','SI')->get();
                            foreach($resultado65 as $fila65) {
                                $tipo_es_sub_an = "$fila65->tipo";
                            }

                            $resultado66 = tipos_sub_especificaciones_vin::where('idtipos_sub_especificaciones_vin',$ides_sub)->where('visible','SI')->get();
                            foreach ($resultado66 as $fila66) {
                                $tipo_es_sub_nu = "$fila66->tipo";
                            }


                            if ($idtipos_especificaciones_vin_ant != $ides) {
                                $cambios.="El tipo de especificación de: <b>$tipo_es_an</b> fue actualizada a: <b>$tipo_es_nu</b><br>";
                            }

                            if ($idtipos_sub_especificaciones_vin_ant != $ides_sub) {
                                $cambios.="El sub tipo de especificación de: <b>$tipo_es_sub_an</b> fue actualizada a: <b>$tipo_es_sub_nu</b><br>";
                            }


                            $resultado61 = inventario_d_tipos_especificaciones::where('idinventario_dinamico',$idinventario_dinamico_ant)->where('visible','SI')->get();
                            $resultado61->idtipos_sub_especificaciones_vin=$ides_sub;
                            $resultado61->idtipos_especificaciones_vin=$ides;
                        }

                        $c3++;
                    }
                }


            }

            if ($fecha_ingreso_taller_bd == "0001-01-01") {
                $fecha_ingreso_taller_bd = "Desconocida";
            }

            if ($fecha_salida_piso_bd == "0001-01-01") {
                $fecha_salida_piso_bd = "Desconocida";
            }

            if ($marca_bd!=$marca) {
                $cambios.="La marca de: <b>$marca_bd</b> fue actualizada a: <b>$marca</b><br>";
            }
            if ($version_bd!=$version) {
                $cambios.="La versión de: <b>$version_bd</b> fue actualizada a: <b>$version</b><br>";
            }
            if ($color_bd!=$color) {
                $cambios.="El Color de: <b>$color_bd</b> fue actualizado a: <b>$color</b><br>";
            }
            if ($modelo_bd!=$modelo) {
                $cambios.="El Modelo de: <b>$modelo_bd</b> fue actualizado a: <b>$modelo</b><br>";
            }
            if ($precio_piso_bd!=$precio_piso) {
                $cambios.="El Precio Piso de: <b>$precio_piso_bd</b> fue actualizado a: <b>$precio_piso</b><br>";
            }
            if ($precio_digital_bd!=$precio_digital) {
                $cambios.="El Precio digital de: <b>$precio_digital_bd</b> fue actualizado a: <b>$precio_digital</b><br>";
            }
            if ($transmision_bd!=$transmision) {
                $cambios.="La Transmisión de: <b>$transmision_bd</b> fue actualizada a: <b>$transmision</b><br>";
            }
            if ($vin_numero_serie_bd!=$vin_numero_serie) {
                $cambios.="El VIN de: <b>$vin_numero_serie_bd</b> fue actualizado a: <b>$vin_numero_serie</b><br>";
            }
            if ($procedencia_bd!=$procedencia) {
                $cambios.="La Procedencia de: <b>$procedencia_bd</b> fue actualizada a: <b>$procedencia</b><br>";
            }
            if ($matricula_bd!=$matricula) {
                $cambios.="La Matricula de: <b>$matricula_bd</b> fue actualizada a: <b>$matricula</b><br>";
            }
            if ($entidad_bd!=$entidad) {
                $cambios.="La Entidad de: <b>$entidad_bd</b> fue actualizada a: <b>$entidad</b><br>";
            }
            if ($fecha_apertura_bd!=$fecha_apertura) {
                if ($fecha_apertura_bd == "0001-01-01") {
                    $fecha_apertura_bd = "Desconocida";
                }
                $cambios.="La Fecha Apertura de: <b>$fecha_apertura_bd</b> fue actualizada a: <b>$fecha_apertura</b><br>";
            }
            if ($fecha_ingreso_bd!=$fecha_ingreso) {
                if ($fecha_ingreso_bd == "0001-01-01") {
                    $fecha_ingreso_bd = "Desconocida";
                }
                $cambios.="La Fecha Ingreso de: <b>$fecha_ingreso_bd</b> fue actualizada a: <b>$fecha_ingreso</b><br>";
            }
            if ($fecha_ingreso_taller_bd!=$fecha_ingreso_taller) {
                if ($fecha_ingreso_taller_bd == "0001-01-01") {
                    $fecha_ingreso_taller_bd = "Desconocida";
                }
                $cambios.="La Fecha Ingreso Taller de: <b>$fecha_ingreso_taller_bd</b> fue actualizada a: <b>$fecha_ingreso_taller</b><br>";
            }
            if ($fecha_salida_piso_bd!=$fecha_salida_piso) {
                if ($fecha_salida_piso_bd == "0001-01-01") {
                    $fecha_salida_piso_bd = "Desconocida";
                }
                $cambios.="La Fecha Salida a Piso de: <b>$fecha_salida_piso_bd</b> fue actualizada a: <b>$fecha_salida_piso</b><br>";
            }
            if ($razon_social_ingreso_bd!=$razon_social_ingreso) {
                $cambios.="La Razón de: <b>$razon_social_ingreso_bd</b> fue actualizada a: <b>$razon_social_ingreso</b><br>";
            }
            if ($kilometraje_bd!=$kilometraje) {
                $cambios.="El Kilometraje de: <b>$kilometraje_bd</b> fue actualizado a: <b>$kilometraje</b><br>";
            }

            if ($estatus_unidad_bd!=$estatus_unidad) {
                $cambios.="La Unidad de: <b>$estatus_unidad_bd</b> fue actualizada a: <b>$estatus_unidad</b><br>";
            }
            if ($ubicacion_bd!=$ubicacion) {
                $cambios.="La Ubicación de: <b>$ubicacion_bd</b> fue actualizada a: <b>$ubicacion</b><br>";
            }
            if ($consignacion_bd!=$consignacion) {
                $cambios.="La Consignación de: <b>$consignacion_bd</b> fue actualizada a: <b>$consignacion</b><br>";
            }
            if ($comentarios_bd!=$comentarios) {
                $cambios.="Los Comentarios de: <b>$comentarios_bd</b> fue actualizados a: <b>$comentarios</b><br>";
            }
            if ($publicado_bd!=$publicado) {
                $cambios.="Pase de VIN de: <b>$publicado_bd</b> fue actualizado a: <b>$publicado</b><br>";
            }
            if ($nivel_pase_bd!=$nivel_pase) {
                $cambios.="Nivel de pase de VIN de: <b>$nivel_pase_bd</b> fue actualizado a: <b>$nivel_pase</b><br>";
            }
            if ($fac!=$facturable) {
                $cambios.="Facturable de: <b>$fac</b> fue actualizado a: <b>$facturable</b><br>";
            }
            if ($iv!=$iva) {
                $cambios.="Iva de: <b>$iv</b> fue actualizado a: <b>$iva</b><br>";
            }
            if ($est!=$estatus) {
                $cambios.="Estatus de: <b>$est</b> fue actualizado a: <b>$estatus</b><br>";
            }
            if ($tipo_unidad!=$tipo_bd) {
                $cambios.="Tipo de: <b>$tipo_bd</b> fue actualizado a: <b>$tipo_unidad</b><br>";
            }
            if ($segmento_unidad!=$segmento_bd) {
                $cambios.="Segmentación de: <b>$segmento_bd</b> fue actualizado a: <b>$segmento_unidad</b><br>";
            }



            if($segmentacion == "Otra Segmentación"){
                $segmentacion = $otra_segmmentacion;
            }
            if($estatus_unidad == "Préstamo"){
                // createPrestamoInventario( $tipo, $nombre, $usuario_creador, $fecha_prestamo, $idinventario ){
                $resultx= prestamo_inventario::createPrestamoInventario($estatus_unidad,$nombre_prestamo,$usuario_creador,$fechaactual,$idinventario);
            }

            $result6 = inventario_dinamico::where('columna','facturable')->where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$idinventario)->get()->last();
            $result6->contenido=$facturable;
            $result6->save();

            $result9 = inventario_dinamico::where('columna','iva')->where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$idinventario)->get()->last();
            $result9->contenido=$iva;
            $result9->save();

            $result15 = inventario_dinamico::where('columna','estatus')->where('visible','SI')->where('tipo_unidad','Unidad')->where('idinventario',$idinventario)->get()->last();
            $result15->contenido=$estatus;
            $result15->save();

            if ($fecha_salida_piso == "Desconocida") {
                $fecha_salida_piso = "0001-01-01";
            }
            if ($fecha_ingreso_taller == "Desconocida") {
                $fecha_ingreso_taller = "0001-01-01";
            }

            $idinventario_encrypt = request('idi');

            if($cambios != "" && $comentarios_bd!=$comentarios){
                $result5 = inventario::where('idinventario',$idinventario)->update(['marca'=>$marca, 'version'=>$version, 'color'=>$color, 'modelo'=>$modelo, 'precio_piso'=>$precio_piso,
                'precio_digital'=>$precio_digital, 'transmision'=>$transmision, 'vin_numero_serie'=>$vin_numero_serie, 'procedencia'=>$procedencia, 'matricula'=>$matricula,
                'entidad'=>$entidad, 'fecha_apertura'=>$fecha_apertura, 'fecha_ingreso'=>$fecha_ingreso, 'fecha_ingreso_taller'=>$fecha_ingreso_taller, 'fecha_salida_piso'=>$fecha_salida_piso,
                'razon_social_ingreso'=>$razon_social_ingreso, 'kilometraje'=>$kilometraje, 'segmentacion'=>$segmentacion, 'estatus_unidad'=>$estatus_unidad, 'ubicacion'=>$ubicacion,
                'consignacion'=>$consignacion, 'publicado'=>$publicado, 'segmento'=>$segmento_unidad, 'tipo'=>$tipo_unidad, 'comentarios'=>$comentarios,
                'mercadolibre'=>$nivel_pase]) ;
                //
                inventario_cambios::createInventarioCambios($cambios, $usuario_creador, $fechaactual, $idinventario);
            }
            if($cambios != "" && $comentarios_bd==$comentarios){
                $result5 = inventario::where('idinventario',$idinventario)->update(['marca'=>$marca, 'version'=>$version, 'color'=>$color, 'modelo'=>$modelo, 'precio_piso'=>$precio_piso,
                'precio_digital'=>$precio_digital, 'transmision'=>$transmision, 'vin_numero_serie'=>$vin_numero_serie, 'procedencia'=>$procedencia, 'matricula'=>$matricula,
                'entidad'=>$entidad, 'fecha_apertura'=>$fecha_apertura, 'fecha_ingreso'=>$fecha_ingreso, 'fecha_ingreso_taller'=>$fecha_ingreso_taller, 'fecha_salida_piso'=>$fecha_salida_piso,
                'razon_social_ingreso'=>$razon_social_ingreso, 'kilometraje'=>$kilometraje, 'segmentacion'=>$segmentacion, 'estatus_unidad'=>$estatus_unidad, 'ubicacion'=>$ubicacion,
                'consignacion'=>$consignacion, 'publicado'=>$publicado, 'segmento'=>$segmento_unidad, 'tipo'=>$tipo_unidad,
                'mercadolibre'=>$nivel_pase]) ;
                inventario_cambios::createInventarioCambios($cambios, $usuario_creador, $fechaactual, $idinventario);
            }

            // $result5=mysql_query($sql10) or die("Error en consulta <br>MySQL dice: ".mysql_error());
            DB::commit();
            return redirect()->back()->with('success','Información editada correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
            return back()->with('error',$e->getMessage())->withInput();
            // return json_encode($e->getMessage() . "Error laravel");
        }


    }

    public function storeEditDetailsTruck(){
        DB::beginTransaction();
        try {
            $usuario_creador = request()->cookie('usuario_creador');//usuario clave
            $vin = Crypt::decrypt(request('v'));
            $idinventario = Crypt::decrypt(request('idi'));
            $marca = request('marca');
            $version = request('version');
            $color = request('color');
            $modelo = request('modelo');
            $precio_piso=request('precio_piso');
            $precio_digital = request('precio_digital');
            $transmision = request('transmision');
            $vin_numero_serie = request('vin_numero_serie');
            $procedencia = request('procedencia');
            $matricula = request('matricula');
            $entidad=request('entidad');
            $fecha_apertura = request('fecha_apertura');
            $fecha_ingreso = request('fecha_ingreso');
            $fecha_ingreso_taller = request('fecha_ingreso_taller');
            $fecha_salida_piso = request('fecha_salida_piso');
            $razon_social_ingreso = request('razon_social_ingreso');
            $kilometraje = request('kilometraje');
            $segmentacion = request('segmentacion');
            $estatus_unidad = request('estatus_unidad');
            $ubicacion = request('ubicacion');
            $comentarios = request('comentarios');
            $consignacion = request('consignacion');
            $publicado = request('publicado');
            date_default_timezone_set('America/Mexico_City');
            $fechaactual= date("Y-m-d H:i:s");

            $facturable = 'Pendiente';
            $iva = request('iva');
            $estatus = request('estatus');

            $motor = trim(request('motor'));
            $eje_delantero = trim(request('eje_delantero'));
            $eje_trasero = trim(request('eje_trasero'));
            $rodado = trim(request('rodado'));
            $camarote = trim(request('camarote'));
            $tipo_tracto= trim(request('tipo_tracto'));
            $potencia= trim(request('potencia'));
            $velocidades= trim(request('velocidades'));

            // $otra_segmmentacion = request('otra_segmentacion');
            $otra_segmmentacion = "N/A";
            // $nombre_prestamo = request('nombre_prestamo');
            $nombre_prestamo = "N/A";
            // $nivel_pase = request('nivel_pase');
            $nivel_pase = "N/A";

            // Validacion de datos
            $fecha_creacion = Crypt::decrypt(request('f'));
            $result=inventario_trucks::where('idinventario_trucks',$idinventario)->get()->last();

            $idinventario_bd="$result->idinventario_trucks";
            $vin_numero_serie_bd="$result->vin_numero_serie";
            $marca_bd="$result->marca";
            $version_bd="$result->version";
            $color_bd="$result->color";
            $modelo_bd="$result->modelo";
            $precio_piso_bd="$result->precio_piso";
            $precio_digital_bd="$result->precio_digital";
            $transmision_bd="$result->transmision";
            $procedencia_bd="$result->procedencia";
            $matricula_bd="$result->matricula";
            $entidad_bd="$result->entidad";
            $fecha_apertura_bd="$result->fecha_apertura";
            $fecha_ingreso_bd="$result->fecha_ingreso";
            $fecha_ingreso_taller_bd="$result->fecha_ingreso_taller";
            $fecha_salida_piso_bd="$result->fecha_salida_piso";
            $razon_social_ingreso_bd="$result->razon_social_ingreso";
            $kilometraje_bd="$result->kilometraje";
            $segmentacion_bd="$result->segmentacion";
            $estatus_unidad_bd="$result->estatus_unidad";
            $ubicacion_bd="$result->ubicacion";
            $consignacion_bd="$result->consignacion";
            $comentarios_bd="$result->comentarios";
            $publicado_bd="$result->publicado";
            $nivel_pase_bd="$result->mercadolibre";


            $result3 = inventario_dinamico::where('columna','facturable')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result3) == 0) {
                $fac = "Pendiente";
                $result5 = inventario_dinamico::createInventarioDinamico('facturable',$facturable,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result3 as $fila3) {
                    $fac = "$fila3->contenido";
                }
            }


            $result4 = inventario_dinamico::where('columna','iva')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result4) == 0) {
                $iv = "Pendiente";
                $result6 = inventario_dinamico::createInventarioDinamico('iva',$iva,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result4 as $fila4) {
                    $iv = "$fila4->contenido";
                }
            }

            $result12 = $result12 = inventario_dinamico::where('columna','estatus')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result12) == 0) {
                $est = "Pendiente";
                $result13 = inventario_dinamico::createInventarioDinamico('estatus',$estatus,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach($result12 as $fila12) {
                    $est = "$fila12->contenido";
                }
            }


            ////////////////invnetario admin//////////////////
            $result14 = inventario_dinamico::where('columna','motor')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result14) == 0) {
                $motor_ant = "Pendiente";
                $result15 = inventario_dinamico::createInventarioDinamico('motor',$motor,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result14 as $fila14) {
                    $motor_ant = "$fila14->contenido";
                }
            }


            $result16 = inventario_dinamico::where('columna','eje delantero')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result16) == 0) {
                $eje_delantero_ant = "Pendiente";
                $result17 = inventario_dinamico::createInventarioDinamico('eje delantero',$eje_delantero,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result16 as $fila16) {
                    $eje_delantero_ant = "$fila16->contenido";
                }
            }

            $result18 = inventario_dinamico::where('columna','eje trasero')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result18) == 0) {
                $eje_trasero_ant = "Pendiente";
                $result19 = inventario_dinamico::createInventarioDinamico('eje trasero',$eje_trasero,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result18 as $fila18) {
                    $eje_trasero_ant = "$fila18->contenido";
                }
            }

            $result20 = inventario_dinamico::where('columna','rodado')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result20) == 0) {
                $rodado_ant = "Pendiente";
                $result21 = inventario_dinamico::createInventarioDinamico('rodado',$rodado,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result20 as $fila20) {
                    $rodado_ant = "$fila20->contenido";
                }
            }

            $result30 = inventario_dinamico::where('columna','camarote')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result30) == 0) {
                $camarote_ant = "Pendiente";
                $result31 = inventario_dinamico::createInventarioDinamico('camarote',$camarote,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result30 as $fila30) {
                    $camarote_ant = "$fila30->contenido";
                }
            }

            $result32 = inventario_dinamico::where('columna','tipo_tracto')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result32) == 0) {
                $tipo_tracto_ant = "Pendiente";
                $result33 = inventario_dinamico::createInventarioDinamico('tipo_tracto',$tipo_tracto,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result32 as $fila32) {
                    $tipo_tracto_ant = "$fila32->contenido";
                }
            }



            $result34 = inventario_dinamico::where('columna','potencia')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result34) == 0) {
                $potencia_ant = "Pendiente";
                $result35 = inventario_dinamico::createInventarioDinamico('potencia',$potencia,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach($result34 as $fila34) {
                    $potencia_ant = "$fila34->contenido";
                }
            }


            $result36 = inventario_dinamico::where('columna','velocidades')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get();
            if (count($result36) == 0) {
                $velocidades_ant = "Pendiente";
                $result37 = inventario_dinamico::createInventarioDinamico('velocidades',$velocidades,$idinventario,'Trucks','SI',$usuario_creador,$fecha_creacion,$fechaactual);
            }else{
                foreach ($result36 as $fila36) {
                    $velocidades_ant = "$fila36->contenido";
                }
            }

            // //Fin de validacion de datos

            $cambios = "";
            if ($marca_bd!=$marca) {
                $cambios.="La marca de: <b> $marca_bd </b> fue actualizada a: <b>$marca</b><br>";
            }
            if ($version_bd!=$version) {
                $cambios.="La versión de: <b> $version_bd </b> fue actualizada a: <b> $version </b><br>";
            }
            if ($color_bd!=$color) {
                $cambios.="El Color de: <b>$color_bd</b> fue actualizado a: <b>$color</b><br>";
            }
            if ($modelo_bd!=$modelo) {
                $cambios.="El Modelo de: <b>$modelo_bd</b> fue actualizado a: <b>$modelo</b><br>";
            }
            if ($precio_piso_bd!=$precio_piso) {
                $cambios.="El Precio Piso de: <b>$precio_piso_bd</b> fue actualizado a: <b>$precio_piso</b><br>";
            }
            if ($precio_digital_bd!=$precio_digital) {
                $cambios.="El Precio Piso de: <b>$precio_digital_bd</b> fue actualizado a: <b>$precio_digital</b><br>";
            }
            if ($transmision_bd!=$transmision) {
                $cambios.="La Transmisión de: <b>$transmision_bd</b> fue actualizada a: <b>$transmision</b><br>";
            }
            if ($vin_numero_serie_bd!=$vin_numero_serie) {
                $cambios.="El VIN de: <b>$vin_numero_serie_bd</b> fue actualizado a: <b>$vin_numero_serie</b><br>";
            }
            if ($procedencia_bd!=$procedencia) {
                $cambios.="La Procedencia de: <b>$procedencia_bd</b> fue actualizada a: <b>$procedencia</b><br>";
            }
            if ($matricula_bd!=$matricula) {
                $cambios.="La Matricula de: <b>$matricula_bd</b> fue actualizada a: <b>$matricula</b><br>";
            }
            if ($entidad_bd!=$entidad) {
                $cambios.="La Entidad de: <b>$entidad_bd</b> fue actualizada a: <b>$entidad</b><br>";
            }
            if ($fecha_apertura_bd!=$fecha_apertura) {
                if ($fecha_apertura_bd == "0001-01-01") {
                    $fecha_apertura_bd = "Desconocida";
                }
                $cambios.="La Fecha Apertura de: <b>$fecha_apertura_bd</b> fue actualizada a: <b>$fecha_apertura</b><br>";
            }
            if ($fecha_ingreso_bd!=$fecha_ingreso) {
                if ($fecha_ingreso_bd == "0001-01-01") {
                    $fecha_ingreso_bd = "Desconocida";
                }
                $cambios.="La Fecha Ingreso de: <b>$fecha_ingreso_bd</b> fue actualizada a: <b>$fecha_ingreso</b><br>";
            }
            if ($fecha_ingreso_taller_bd!=$fecha_ingreso_taller) {
                if ($fecha_ingreso_taller_bd == "0001-01-01") {
                    $fecha_ingreso_taller_bd = "Desconocida";
                }
                $cambios.="La Fecha Ingreso Taller de: <b>$fecha_ingreso_taller_bd</b> fue actualizada a: <b>$fecha_ingreso_taller</b><br>";
            }
            if ($fecha_salida_piso_bd!=$fecha_salida_piso) {
                if ($fecha_salida_piso_bd == "0001-01-01") {
                    $fecha_salida_piso_bd = "Desconocida";
                }
                $cambios.="La Fecha Salida a Piso de: <b>$fecha_salida_piso_bd</b> fue actualizada a: <b>$fecha_salida_piso</b><br>";
            }
            if ($razon_social_ingreso_bd!=$razon_social_ingreso) {
                $cambios.="La Razón de: <b>$razon_social_ingreso_bd</b> fue actualizada a: <b>$razon_social_ingreso</b><br>";
            }
            if ($kilometraje_bd!=$kilometraje) {
                $cambios.="El Kilometraje de: <b>$kilometraje_bd</b> fue actualizado a: <b>$kilometraje</b><br>";
            }
            if ($segmentacion_bd!=$segmentacion) {
                if ($segmentacion == "" && $otra_segmmentacion !="") {
                    $cambios.="La Segmentación de: <b>$segmentacion_bd</b> fue actualizada a: <b>$otra_segmmentacion</b><br>";
                }
                $cambios.="La Segmentación de: <b>$segmentacion_bd</b> fue actualizada a: <b>$segmentacion</b><br>";
            }
            if ($estatus_unidad_bd!=$estatus_unidad) {
                $cambios.="La Unidad de: <b>$estatus_unidad_bd</b> fue actualizada a: <b>$estatus_unidad</b><br>";
            }
            if ($ubicacion_bd!=$ubicacion) {
                $cambios.="La Ubicación de: <b>$ubicacion_bd</b> fue actualizada a: <b>$ubicacion</b><br>";
            }
            if ($consignacion_bd!=$consignacion) {
                $cambios.="La Consignación de: <b>$consignacion_bd</b> fue actualizada a: <b>$consignacion</b><br>";
            }
            if ($comentarios_bd!=$comentarios) {
                $cambios.="Los Comentarios de: <b>$comentarios_bd</b> fue actualizados a: <b>$comentarios</b><br>";
            }

            if ($fac!=$facturable) {
                $cambios.="Facturable de: <b>$fac</b> fue actualizados a: <b>$facturable</b><br>";
            }


            if ($iv!=$iva) {
                $cambios.="Iva de: <b>$iv</b> fue actualizado a: <b>$iva</b><br>";
            }

            if ($est!=$estatus) {
                $cambios.="Estatus de: <b>$est</b> fue actualizado a: <b>$estatus</b><br>";
            }

            if ($motor!=$motor_ant) {
                $cambios.="Motor de: <b>$motor_ant</b> fue actualizado a: <b>$motor</b><br>";
            }

            if ($eje_delantero!=$eje_delantero_ant) {
                $cambios.="Eje Delantero de: <b>$eje_delantero_ant</b> fue actualizado a: <b>$eje_delantero</b><br>";
            }

            if ($eje_trasero!=$eje_trasero_ant) {
                $cambios.="Eje Trasero de: <b>$eje_trasero_ant</b> fue actualizado a: <b>$eje_trasero</b><br>";
            }

            if ($rodado!=$rodado_ant) {
                $cambios.="Rodado de: <b>$rodado_ant</b> fue actualizado a: <b>$rodado</b><br>";
            }

            if ($camarote!=$camarote_ant) {
                $cambios.="Camarote de: <b>$camarote_ant</b> fue actualizado a: <b>$camarote</b><br>";
            }

            if ($tipo_tracto!=$tipo_tracto_ant) {
                $cambios.="Tipo tracto de: <b>$tipo_tracto_ant</b> fue actualizado a: <b>$tipo_tracto</b><br>";
            }

            if ($potencia!=$potencia_ant) {
                $cambios.="Potencia de: <b>$potencia_ant</b> fue actualizado a: <b>$potencia</b><br>";
            }

            if ($velocidades!=$velocidades_ant) {
                $cambios.="Velocidades de: <b>$velocidades_ant</b> fue actualizado a: <b>$velocidades</b><br>";
            }


            if($segmentacion == "Otra Segmentación"){
                $segmentacion = $otra_segmmentacion;
            }
            if($estatus_unidad == "Préstamo"){
                $resultx=prestamo_inventario::createPrestamoInventario($estatus_unidad, $nombre_prestamo, $usuario_creador, $fechaactual, $idinventario);
            }

            if ($fecha_salida_piso == "Desconocida") {
                $fecha_salida_piso = "0001-01-01";
            }
            if ($fecha_ingreso_taller == "Desconocida") {
                $fecha_ingreso_taller = "0001-01-01";
            }

            $result6 = inventario_dinamico::where('columna','facturable')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result6->contenido=$facturable;
            $result6->save();

            $result9 = inventario_dinamico::where('columna','iva')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result9->contenido=$iva;
            $result9->save();

            $result15 = inventario_dinamico::where('columna','estatus')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result15->contenido=$estatus;
            $result15->save();

            $result30 = inventario_dinamico::where('columna','motor')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result30->contenido=$motor;
            $result30->save();

            $result31 = inventario_dinamico::where('columna','eje delantero')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result31->contenido=$eje_delantero;
            $result31->save();

            $result32 = inventario_dinamico::where('columna','eje trasero')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result32->contenido=$eje_trasero;
            $result32->save();

            $result33 = inventario_dinamico::where('columna','rodado')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result33->contenido=$rodado;
            $result33->save();

            $result60 = inventario_dinamico::where('columna','camarote')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result60->contenido=$camarote;
            $result60->save();



            $result61 = inventario_dinamico::where('columna','tipo_tracto')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result61->contenido=$tipo_tracto;
            $result61->save();


            $result62 = inventario_dinamico::where('columna','potencia')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result62->contenido=$potencia;
            $result62->save();

            $result63 = inventario_dinamico::where('columna','velocidades')->where('visible','SI')->where('tipo_unidad','Trucks')->where('idinventario',$idinventario)->get()->last();
            $result63->contenido=$velocidades;
            $result63->save();


            $result_id= inventario_real_puesto_venta::where('idinventario',$idinventario)->where('tipo','Trucks')->where('visible','SI')->where('vin',$vin_numero_serie)->get();
            foreach($result_id as $fila_id) {
                $result_inv_real=inventario_real_puesto_venta::where('idinventario_real_puesto_venta',$fila_id->idinventario_real_puesto_venta)->get()->last();
                $result_inv_real->visible = 'NO'; $result_inv_real->save();
            }

            $idinventario_encrypt = request('idi');

            if($cambios != "" && $comentarios_bd!=$comentarios){
                $result5=inventario_trucks::where('idinventario_trucks',$idinventario)->update(['marca' => $marca, 'version' => $version, 'color' => $color, 'modelo' => $modelo, 'precio_piso' => $precio_piso,
                'precio_digital' => $precio_digital, 'transmision' => $transmision, 'vin_numero_serie' => $vin_numero_serie, 'procedencia' => $procedencia, 'matricula' => $matricula, 'entidad' => $entidad,
                'fecha_apertura' => $fecha_apertura, 'fecha_ingreso' => $fecha_ingreso, 'fecha_ingreso_taller' => $fecha_ingreso_taller, 'fecha_salida_piso' => $fecha_salida_piso,
                'razon_social_ingreso' => $razon_social_ingreso, 'kilometraje' => $kilometraje, 'segmentacion' => $segmentacion, 'estatus_unidad' => $estatus_unidad, 'ubicacion' => $ubicacion,
                'consignacion' => $consignacion, 'mercadolibre'=>$nivel_pase,'comentarios' => $comentarios]);

                inventario_cambios::createInventarioCambios($cambios, $usuario_creador, $fechaactual, $idinventario);
            }
            if($cambios != "" && $comentarios_bd==$comentarios){
                $result5=inventario_trucks::where('idinventario_trucks',$idinventario)->update(['marca' => $marca, 'version' => $version, 'color' => $color, 'modelo' => $modelo, 'precio_piso' => $precio_piso,
                'precio_digital' => $precio_digital, 'transmision' => $transmision, 'vin_numero_serie' => $vin_numero_serie, 'procedencia' => $procedencia, 'matricula' => $matricula, 'entidad' => $entidad,
                'fecha_apertura' => $fecha_apertura, 'fecha_ingreso' => $fecha_ingreso, 'fecha_ingreso_taller' => $fecha_ingreso_taller, 'fecha_salida_piso' => $fecha_salida_piso,
                'razon_social_ingreso' => $razon_social_ingreso, 'kilometraje' => $kilometraje, 'segmentacion' => $segmentacion, 'estatus_unidad' => $estatus_unidad, 'ubicacion' => $ubicacion,
                'consignacion' => $consignacion, 'mercadolibre'=>$nivel_pase]);
                inventario_cambios::createInventarioCambios($cambios, $usuario_creador, $fechaactual, $idinventario);
            }
            DB::commit();
            return redirect()->back()->with('success','Información editada correctamente');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
            return back()->with('error',$e->getMessage())->withInput();
            // return json_encode($e->getMessage() . "Error laravel");
        }






    }

    public function addTechnicalSheets($id, $vin){
        $inventario = inventario_trucks::where('idinventario_trucks',$id)->get()->first();
        return view('InventarioAdmin.units_trucks.add_technical_sheets',compact('inventario'));

    }


    public function saveGalleryImages(){
        DB::beginTransaction();
        try {
            $fila = 0; $flag = "true";
            $id_inventario = request('id');
            $usuario_creador = request()->cookie('usuario_creador');
            foreach($_FILES["result_image"]['tmp_name'] as $key => $tmp_name){

                $fecha_actual_img= date("Y_m_d__H_i_s");
                $fecha_actual= date("Y-m-d H:i:s");

                $target_path_storage = storage_path('app/Gallery_inventary_trucks/');
                $name_img = "img_adicional_inv_".$id_inventario."_".$fecha_actual_img."_usr_".$usuario_creador."_".basename($_FILES["result_image"]['name'][$key].$fila.".jpeg");
                $target_path_img = $target_path_storage.$name_img;

                if ($target_path_img != $target_path_storage) {
                    if(move_uploaded_file($_FILES["result_image"]['tmp_name'][$key], $target_path_img)) {
                        $archivo_cargado=$target_path_img;
                        date_default_timezone_set('America/Mexico_City');
                    } else{
                        $archivo_cargado="Pendiente";
                    }

                }else{
                    $archivo_cargado="Pendiente";
                }

                $destino=$archivo_cargado;
                $destino_temporal=@tempnam($target_path_img,"tmp");//El @ es para que no mande mensaje o alert despues de crear el temporal
                if($this->redimensionarImagen($destino, $destino_temporal, 1000, 1000, 80)) {
                    // guardamos la imagen redimensionada
                    $fp=fopen($destino,"w");
                    fputs($fp,fread(fopen($destino_temporal,"r"),filesize($destino_temporal)));
                    fclose($fp);
                    // mostramos la imagen
                }

                $fecha_guardado=date("Y-m-d H:i:s");
                $path_no_full = 'storage/app/Gallery_inventary_trucks/'.$name_img;
                // createInventarioGaleriaTrucks($foto_vin, $nombre_vista, $descripcion, $idinventario_trucks, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado){
                $resultado = inventario_galeria_trucks::createInventarioGaleriaTrucks( $path_no_full, '', '', $id_inventario, 'SI', $usuario_creador, $fecha_guardado, $fecha_guardado);
                if (!$resultado) {
                    $flag = "false";
                }
                $fila++;

            }
            DB::commit();
            return json_encode(['message' => 'paso'] );
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
            // return json_encode($e->getMessage() . "Error laravel");
        }

    }

    public function updateGalleryTypeTruck(){
        DB::beginTransaction();
        try {
            $id = request('id');
            $resultado = inventario_galeria_trucks::where('idinventario_galeria_trucks',$id)->get()->first();
            $resultado->nombre_vista=request('tipo');
            $resultado->descripcion=request('comentario');
            $resultado->save();
            DB::commit();
            return json_encode(['message' => 'success'] );
        } catch (\Exception $e) {
            DB::rollback();
            // return $e->getMessage();
            return json_encode(['message' => 'error'] );
            // return back()->with('error','Ocurrio un error inesperado intente de nuevo')->withInput();
        }


    }









    public function getSubEspecificationsVin(){
        try {
            $id = request('valor');
            $result6 = tipos_sub_especificaciones_vin::where('idtipos_especificaciones_vin',$id)->where('visible','SI')->get();
            $options = "";
            foreach($result6 as $fila6) {
                $idtipos_sub_especificaciones_vin = "$fila6->idtipos_sub_especificaciones_vin";
                $tipo = "$fila6->tipo";
                $options .= "<option value='$idtipos_sub_especificaciones_vin'>$tipo</option>";
            }
            return json_encode(['options' => $options, 'id'=>$id] );
        } catch (\Exception $e) {
            return json_encode(['message'=>'error']);
            return json_encode($e->getMessage());
        }

    }
    /**
     * Funcion para redimensionar imagenes
     *
     * @param string $origin Imagen origen en el disco duro ($_FILES["image1"]["tmp_name"])
     * @param string $destino Imagen destino en el disco duro ($destino=tempnam("tmp/","tmp");)
     * @param integer $newWidth Anchura máxima de la nueva imagen
     * @param integer $newHeight Altura máxima de la nueva imagen
     * @param integer $jpgQuality (opcional) Calidad para la imagen jpg
     * @return boolean true = Se ha redimensionada|false = La imagen es mas pequeña que el nuevo tamaño
     */
    function redimensionarImagen($origin,$destino,$newWidth,$newHeight,$jpgQuality=100) {
        // getimagesize devuelve un array con: anchura,altura,tipo,cadena de
        // texto con el valor correcto height="yyy" width="xxx"
    	$datos=getimagesize($origin);

        // comprobamos que la imagen sea superior a los tamaños de la nueva imagen
    	if($datos[0]>$newWidth || $datos[1]>$newHeight) {
            // creamos una nueva imagen desde el original dependiendo del tipo
    		if($datos[2]==1)
    			$img=imagecreatefromgif($origin);
    		if($datos[2]==2)
    			$img=imagecreatefromjpeg($origin);
    		if($datos[2]==3)
    			$img=imagecreatefrompng($origin);

            // Redimensionamos proporcionalmente
    		if(rad2deg(atan($datos[0]/$datos[1]))>rad2deg(atan($newWidth/$newHeight)))
    		{
    			$anchura=$newWidth;
    			$altura=round(($datos[1]*$newWidth)/$datos[0]);
    		}else{
    			$altura=$newHeight;
    			$anchura=round(($datos[0]*$newHeight)/$datos[1]);
    		}

            // creamos la imagen nueva
    		$newImage = imagecreatetruecolor($anchura,$altura);

            // redimensiona la imagen original copiandola en la imagen
    		imagecopyresampled($newImage, $img, 0, 0, 0, 0, $anchura, $altura, $datos[0], $datos[1]);

            // guardar la nueva imagen redimensionada donde indicia $destino
    		if($datos[2]==1)
    			imagegif($newImage,$destino);
    		if($datos[2]==2)
    			imagejpeg($newImage,$destino,$jpgQuality);
    		if($datos[2]==3)
    			imagepng($newImage,$destino);

            // eliminamos la imagen temporal
    		imagedestroy($newImage);

    		return true;
    	}
    	return false;
    }

}
