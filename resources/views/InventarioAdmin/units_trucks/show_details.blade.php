@extends('layouts.appAdmin')
@if($type == "truck") @section('titulo', 'Detalle de truck') @endif
@if($type == "unidad") @section('titulo', 'Detalle de unidad') @endif
@php
use App\Http\Controllers\GlobalFunctionsController;
@endphp

@section('head')
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<style type="text/css">

.fadeOutLeft_izi{
    -webkit-animation: iziT-fadeOutLeft .5s ease both;
    animation: iziT-fadeOutLeft .5s ease both;
}

.fadeOutRight_izi{
    -webkit-animation: iziT-fadeOutRight .5s ease both;
    animation: iziT-fadeOutRight .5s ease both;
}

.fadeInLeft_izi{
    -webkit-animation: iziT-fadeInLeft .85s cubic-bezier(.25,.8,.25,1) both;
    animation: iziT-fadeInLeft .85s cubic-bezier(.25,.8,.25,1) both;
}

.fadeInRight_izi{
    -webkit-animation: iziT-fadeInRight .85s cubic-bezier(.25,.8,.25,1) both;
    animation: iziT-fadeInRight .85s cubic-bezier(.25,.8,.25,1) both;
}


#rcorners2error {
    -webkit-box-shadow: 0px 0px 100px -15px rgba(164,30,54,1);
    -moz-box-shadow: 0px 0px 100px -15px rgba(164,30,54,1);
    box-shadow: 0px 0px 100px -15px rgba(164,30,54,1);
}

#rcorners2bien {
    -webkit-box-shadow: 0px 0px 100px -15px rgba(57,178,38,1);
    -moz-box-shadow: 0px 0px 100px -15px rgba(57,178,38,1);
    box-shadow: 0px 0px 100px -15px rgba(57,178,38,1);
}
img.rounded-circle{
    border-color: rgb(85, 79, 69);
    display: block;
    margin: auto;
    border-radius: 50%;
    border: 10px solid #dddddd;
    position: relative;
    z-index: 2;
}
}



.hidden{
    display: none;
}
@media (min-width:600px) {
    .card {
        max-width:70%;
    }

}

.botonCard{
    display: block;
    width: 200px;
    height: 40px;
    border: none;
    color: #fff !important;
    border-radius: 20px;
    text-align: center;
    position: relative;
    z-index: 1;
}

/**SLIDER*/
.content-swiper{
  width: 60%;
  margin: auto;
  height: 600px;
}

.swiper-container {
  width: 100%;
  height: 100%;
  margin-left: auto;
  margin-right: auto;
}

.swiper-slide {
  background-size: cover;
  background-position: center;
  position: relative;
}
.gallery-top {
  height: 80%;
  width: 100%;
}

.gallery-thumbs {
  height: 20%;
  box-sizing: border-box;
  padding: 10px 0;
}

.gallery-thumbs .swiper-slide {
  height: 100%;
  opacity: .4;
  position: relative;
}
.gallery-thumbs .swiper-slide:hover{
  opacity: 1;
}

.gallery-thumbs .swiper-slide:before{
  content: '';
  position: absolute;
  background: rgba(136,36,57,.5);
  width: 100%;
  height: 100%;
  transform: scale(0);
  transition: .5s;
}
.gallery-thumbs .swiper-slide:hover:before{
  transform: scale(1);
}

.gallery-thumbs .swiper-slide-thumb-active {
  opacity: 1;
}
.swiper-button-prev, .swiper-button-next{
  width: 50px;
  height: 50px;
  background: #00000080;
  border-radius: 50%;
}
.swiper-button-prev:hover, .swiper-button-next:hover{
  background: #882439;
}
.swiper-button-prev:after,
.swiper-button-next:after {
  content: '';
  font-family: none;
}
.swiper-button-next i, .swiper-button-prev i{
  font-size: 28px;
}
.swiper-slide .contenido-descripcion{
  width: 100%;
  background: rgba(0,0,0,.6);
  position: absolute;
  bottom: 0;
}




/* Agregando estilo de Tooltip a iconos pagina atencion_talleres_detalle (Modulo Ordenes de Proveedores Detallado) EAM */

a.tool_editar_inventario:after,
a.tool_add_ficha_tecnica:after{
  position: absolute;
  top: -10px;
  left: 50%;
  transform: translateX(-50%);
  background: #444;
  opacity: 0;
  visibility: hidden;
  transition: .5s;
  font-size: 12px;
  line-height: 30px;
  color: #ccc;
  height: 30px;
  border-radius: 10px;
}

a.tool_editar_inventario:after{
  content: 'Editar Inventario';
  width: 200px;
}

a.tool_add_ficha_tecnica:after{
  content: 'Agregar datos ficha técnica';
  width: 200px;
}

a.tool_editar_inventario:hover:after,
a.tool_add_ficha_tecnica:hover:after
{
  opacity: 1;
  visibility: visible;
  top: -20px;
}
a.iconos-estatus:before{
  content: '';
  position: absolute;
  width: 10px;
  height: 10px;
  top: 10px;
  background: #444;
  left: 50%;
  transform: translateX(-50%) rotate(45deg);
  opacity: 0;
  visibility: hidden;
  transition: .5s;
}
a.iconos-estatus:hover:before{
  opacity: 1;
  visibility: visible;
  top: 5px;
}

.font-icong{
  color:gray !important;
}
.font-iconr{
  color:gray !important;
}
.font-iconb{
  color:gray !important;
}

.font-icong:hover{
  color:#882439 !important;
}
.font-iconr:hover{
  color:#882439 !important;
}
.font-iconb:hover{
  color:#882439 !important;
}

.font-iconrojo{
  color:gray !important;
}
.font-iconrojo:hover{
  color:#882439 !important;
}




</style>

@endsection





@section('content')
<div class="container" id="resultado">
    <div class="row">
        <div class="col-lg-12">
            <!-- <h2 style="text-align:center;">{{---$id_contacto_completo---}}</h2> -->
            <!-- <ol class="breadcrumb">
            <li>
            <a href="index.php">Inicio</a>
        </li>
        <li class="active">
        <strong>Perfil</strong>
    </li>
    <li class="active">
</li>
</ol> -->
</div>
</div>

</div>
<div class="container">
    <div class="row mt-3">
        <div class="col-sm-12" style="padding-right: 0px;padding-left: 0px;">

            <div class="shadow panel-head-primary" style="padding-top: 2%; padding-bottom:2%;">
                <!-- <h5 class="mt-3 mb-3"><strong>Información Detallada</strong></h5> -->
                <!-- -----------------------------------INFORMACION DETALLADA----------------------------------------------------------------------- -->
                <div class="col-lg-8 offset-lg-2 col-sm-12 col-md-12 col-12">

                    <div class="card" style="margin:0 auto; min-height:710px;border-radius: 20px;background: #dadbe0;box-shadow: 0px 0px 20px rgb(136 36 57 / 20%);position: relative;overflow: hidden;">
                        <div class="card-header" style="padding:10px;background: #F3F3F3;">
                            <h2 style="text-align:center;">@if(!empty($inventario->vin_numero_serie)){{$inventario->vin_numero_serie}}@else{{'N/A'}}@endif</h2>
                        </div>
                        <div class="card-body" id="datos-principales" style="padding:0px;">
                            <div class="col-lg-12 imagen-perfil" style="background: #fff;padding: 20px 0px;">
                                <div class="" style="text-align: right;">
                                    @if($type == "truck")
                                        <a style="margin-right: 15px;" href="{{route('inventoryAdmin.editDetailsUnit',['type'=>'truck','id'=>$inventario->idinventario_trucks, 'vin'=>$inventario->vin_numero_serie])}}" class='iconos-estatus tool_editar_inventario'><i class="far fa-edit  icon-DOrden font-icond font-iconrojo"></i></a>
                                        <a style="margin-right: 15px;" href="{{route('inventoryAdmin.addTechnicalSheets',['id'=>$inventario->idinventario_trucks, 'vin'=>$inventario->vin_numero_serie])}}" class='iconos-estatus tool_add_ficha_tecnica'><i class="fas fa-plus  icon-DOrden font-icond font-iconrojo"></i></a>
                                    @endif
                                    @if($type == "unidad")<a style="margin-right: 15px;" href="{{route('inventoryAdmin.editDetailsUnit',['type'=>'unidad','id'=>$inventario->idinventario, 'vin'=>$inventario->vin_numero_serie])}}"><i class="far fa-edit"></i></a>@endif
                                </div>
                                <div class="text-center">
                                    @if (!empty($foto))
                                        <img alt='image' width='150' height='150' class='rounded-circle' src="{{url('/').'/'.$foto}}" alt="">
                                    @else
                                        <img alt='image' width='150' height='150' class='rounded-circle' src="https://www.panamotorscenter.com/Des/CCP/Fotos_Inventario/fondoblanco_actual.jpg" alt="">
                                    @endif
                                </div>

                            </div>
                            @php
                                if($type == "truck") $n1=strlen($inventario->idinventario_trucks);
                                if($type == "unidad") $n1=strlen($inventario->idinventario);
                                $n1_aux=6-$n1;
                                $mat="";
                                for ($i=0; $i <$n1_aux ; $i++) {
                                  $mat.="0";
                                }
                            @endphp
                            <h1 class="mt-3 mb-3" style="text-align: center; font-size:1rem;"><strong>
                                @if($type == "truck")@if(!empty($inventario->idinventario_trucks)){{$mat.$inventario->idinventario_trucks}}@else N/A @endif @endif
                                @if($type == "unidad")@if(!empty($inventario->idinventario)){{$mat.$inventario->idinventario}}@else N/A @endif @endif
                            </strong></h1>
                            <h5 class="mt-3 mb-3" style="text-align: center;"><strong>
                                @if(!empty($inventario->estatus_unidad))
                                    @if(strtoupper($inventario->estatus_unidad) == "VENDIDO")
                                        <h1><b style='color: red;'>{{strtoupper(GlobalFunctionsController::eliminar_tildes($inventario->estatus_unidad))}}</b></h1>
                                    @else
                                        <h1><b style='color: black;'>{{strtoupper(GlobalFunctionsController::eliminar_tildes($inventario->estatus_unidad))}}</b></h1>
                                    @endif
                                @else N/A @endif
                            </strong></h5>
                            <div class="table-responsive not-dataTable">
                                <table class="table table-striped not-dataTable">
                                        <tbody>
                                            <tr>
                                                <td colspan="4" style="text-align:center;"><b>
                                                    @if(!empty($inventario->version))
                                                    {{strtoupper(GlobalFunctionsController::eliminar_tildes($inventario->version))}}
                                                    @else N/A @endif
                                                </b></td>
                                            </tr>
                                            <tr style="text-align:center;">
                                                <td>
                                                    @if(!empty($inventario->marca))
                                                        Marca: {{$inventario->marca}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($inventario->color))
                                                        Color: {{$inventario->color}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!empty($inventario->modelo))
                                                        Modelo: {{$inventario->modelo}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="text-align:center;">Precio piso:
                                                <b>
                                                    @if (!empty($inventario->precio_piso))
                                                    $ {{number_format($inventario->precio_piso,2)}}
                                                    @else $ 0.00 @endif
                                                </b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"style="text-align:center;">Precio digital:
                                                <b>
                                                    @if (!empty($inventario->precio_digital))
                                                    $ {{number_format($inventario->precio_digital,2)}}
                                                    @else $ 0.00 @endif
                                                </b></td>
                                            </tr>
                                        </tbody>
                                </table>
                            </div>
                            <div class="row" style="margin-bottom: 15px;">
                                <!-- <h5 class="col-lg-12" style="text-align: center;"><strong>Estado de cuenta</strong></h5>
                                <div class="col-lg-12" style="text-align: center;margin-bottom: 10px;">
                                    <a href="{{route('account_status.showAccountStatus',['idc'=>''])}}" title='Estado de Cuenta'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/>
                                        </svg>
                                    </a>
                                </div> -->
                                <input type="button" class="btn btn-primary botonCard" id="ver_mas" style="margin: 3% auto;" value="Ver m&aacute;s">
                            </div>
                        </div>
                        <!-- Fin | Datos Personales -->
                        <!-- Direccion -->
                        <div class="card-body" id="datos-secundarios" style="display:none;">
                            <style>
                                #datos-secundarios .table td, #datos-secundarios .table th{
                                    padding: 0 .75rem;
                                }
                            </style>
                            <div class="table-responsive not-dataTable">
                                <table class="table table-striped not-dataTable">
                                    <tbody>
                                        <tr>
                                            <td>Transmisi&oacute;n</td>
                                            <td><b>@if(!empty($inventario->transmision)){{$inventario->transmision}}@else {{"N/A"}}@endif</b></td>
                                        </tr>
                                        <tr>
                                            <td>Procedencia</td>
                                            <td><b>@if(!empty($inventario->procedencia)){{$inventario->procedencia}}@else {{"N/A"}}@endif</b></td>
                                        </tr>

                                        <tr>
                                            <td>Matr&iacute;cula</td>
                                            <td><b>@if(!empty($inventario->matricula)){{$inventario->matricula}}@else {{"N/A"}}@endif
                                            </b></td>
                                        </tr>
                                        <tr>
                                            <td><br>Entidad </td>
                                            <td><br><b>@if(!empty($inventario->entidad)){{$inventario->entidad}}@else {{"N/A"}}@endif</b></td>
                                        </tr>
                                        <tr>
                                            <td>Fecha movimiento</td>
                                            <td colspan="2"><b>
                                                @if(!empty($inventario->fecha_apertura))
                                                    @if($inventario->fecha_apertura != "0001-01-01" && $inventario->fecha_apertura != "0001-01-01 00:00:00")
                                                    {{$inventario->fecha_apertura}}
                                                    @else Fecha desconocida @endif
                                                @else Fecha desconocida @endif
                                            </b></td>
                                        </tr>
                                        <tr>
                                            <td>Fecha ingreso</td>
                                            <td colspan="2"><b>
                                                @if(!empty($inventario->fecha_ingreso))
                                                    @if($inventario->fecha_ingreso != "0001-01-01" && $inventario->fecha_ingreso != "0001-01-01 00:00:00")
                                                    {{$inventario->fecha_ingreso}}
                                                    @else Fecha desconocida @endif
                                                @else Fecha desconocida @endif
                                            </b></td>
                                        </tr>
                                        <tr>
                                            <td>Fecha ingreso taller</td>
                                            <td colspan="2"><b>
                                                @if(!empty($inventario->fecha_ingreso_taller))
                                                    @if($inventario->fecha_ingreso_taller != "0001-01-01" && $inventario->fecha_ingreso_taller != "0001-01-01 00:00:00")
                                                    {{$inventario->fecha_ingreso_taller}}
                                                    @else Fecha desconocida @endif
                                                @else Fecha desconocida @endif
                                            </b></td>
                                        </tr>
                                        <tr>
                                            <td>Fecha salida piso<br><br></td>
                                            <td colspan="2"><b>
                                                @if(!empty($inventario->fecha_salida_piso))
                                                    @if($inventario->fecha_salida_piso != "0001-01-01" && $inventario->fecha_salida_piso != "0001-01-01 00:00:00")
                                                    {{$inventario->fecha_salida_piso}}
                                                    @else Fecha desconocida @endif
                                                @else Fecha desconocida @endif
                                            </b><br><br></td>
                                        </tr>
                                        <tr>
                                            <td>Raz&oacute;n social ingreso</td>
                                            <td colspan="2"><b>@if(!empty($inventario->razon_social_ingreso)){{$inventario->razon_social_ingreso}}@else {{"N/A"}}@endif</b></td>
                                        </tr>
                                        <tr>
                                            <td>Tipo impuesto</td>
                                            <td colspan="2"><b>@if(!empty($inventario->tipo_impuesto)){{$inventario->tipo_impuesto}}@else {{"N/A"}}@endif</b></td>
                                        </tr>
                                        <tr>
                                            <td>Tipo venta</td>
                                            <td colspan="2"><b>@if(!empty($inventario->tipo_venta)){{$inventario->tipo_venta}}@else {{"N/A"}}@endif</b></td>
                                        </tr>
                                        <tr>
                                            <td>Kilometraje</td>
                                            <td colspan="2"><b>@if(!empty($inventario->kilometraje)){{$inventario->kilometraje}}@else {{"N/A"}}@endif</b></td>
                                        </tr>
                                        <tr>
                                            <td>Segmentaci&oacute;n</td>
                                            <td colspan="2"><b>@if(!empty($inventario->segmentacion)){{$inventario->segmentacion}}@else {{"N/A"}}@endif</b></td>
                                        </tr>
                                        <tr>
                                            <td>Ubicaci&oacute;n</td>
                                            <td colspan="2"><b>@if(!empty($inventario->ubicacion)){{$inventario->ubicacion}}@else {{"N/A"}}@endif</b></td>
                                        </tr>
                                        <tr>
                                            <td>Comentarios</td>
                                            <td colspan="2"><b>@if(!empty($inventario->comentarios)){{$inventario->comentarios}}@else {{"N/A"}}@endif</b></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <input type="button"  class="btn btn-primary botonCard" id="regresar" style="margin: 15px auto;" value="Regresar">
                            </div>
                        </div>
                    </div>
                    <!-- Fin | Direccion -->
                </div>



                <!-- ---------------------------------------------------------------------------------------------------------- -->
            </div>



            <div class="shadow panel-head-primary" style="padding-top: 2%; padding-bottom:2%;">
                <a  data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" >
                    <h5 class="text-center mt-3 mb-3">
                        <i class="fas fa-plus"  data-toggle="tooltip" data-placement="top" title="Da clic aqui de desplegar el formulario."></i>
                        <strong>Imagenes</strong>
                    </h5>
                </a>
                <div class="col-lg-12">

                    <div class="panel-body datatable-panel">
                        <!-- <center>
                            <a href="{{route('account_status.showAccountStatus',['idc'=>''])}}" title='Estado de Cuenta'>
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/>
                                </svg>
                            </a>

                        </center>

                        <h5 class="mt-3 mb-3"><strong>Resumen Crediticio</strong></h5> -->
                        <!-- <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Saldo</td>
                                        <td colspan="3"><b><?php //echo "$ ".number_format($saldo_anterior,2); ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Último Abono</td>
                                        <td><b><?php //echo "$ ".number_format($ultimo_abono,2); ?></b></td>
                                        <td>Fecha Último Abono</td>
                                        <td><b><?php //echo $fecha_ultimo_abono; ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->


                        <div class="collapse" id="collapseExample">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label  for="validatedCustomFile">Seleccione Archivo</label>
                                    <input type="file" class="uploadedfile form-control" name="uploadedfile[]" required id="uploadedfile" multiple="" accept=".png, .jpg, .jpeg">
                                    <!-- <input type="file" class="uploadedfile form-control" name="uploadedfile" required id="uploadedfile"> -->
                                </div>
                            </div>

                            <div class="col-sm-12" style="margin-bottom: 20px;">
                                <!-- <a class="btn btn-primary btn-lg cargar" disabled="">Cargar</a> -->
                                <div class="col-sm-12 d-flex justify-content-center icon-DOrden">
                                    <!-- <button class="btn btn-primary btn-lg cargar font-icond" id="cargar" disabled="" style="width: 120px;">Cargar</button> -->
                                    <button class="btn btn-primary cargar botonCard" id="cargar" disabled="" style="width: 120px;">Cargar</button>
                                </div>
                                <div class="tooltipDetalleOrden mb-3">
                                    <p>Cargar Imagenes</p>
                                </div>
                            </div>

                            <br>

                            <div class="container">
                                <div class="row d-flex flex-wrap justify-content-center">
                                    <div class="col-sm-12">
                                        <div class="row" id="origen"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="idinventario" id="idinventario" value="<?php //echo $idi; ?>">

                            <div class="col-sm-12">
                                <div class="col-sm-12 d-flex justify-content-center icon-DOrden">
                                    <!-- <button class="btn btn-primary btn-lg enviar font-icond" id="enviar" disabled="" style="width: 120px; display: none;">Enviar</button> -->
                                    <button class="btn btn-primary enviar botonCard" id="enviar" disabled="" style="width: 120px; background-color:green; display:none;">Enviar</button>
                                </div>
                                <div class="tooltipDetalleOrden mb-3 ocultoTooltip" style="display: none;">
                                    <p>Enviar Imagenes</p>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>





            <div class="shadow panel-head-primary" style="padding-top: 2%; padding-bottom:2%;">
                <h5 class="mt-3 mb-3"><strong>Modificaciones de proveedor</strong></h5>
                <div class="col-lg-12">

                    <!-- ----------------------------------------------- -->


                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>IMAGEN</th>
                                    <th>NOMBRE IMAGEN</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach($inventario_galeria_trucks as $key => $fila)
                                    <tr class="odd gradeX">
                                        <td>{{$key+1}}</td>
                                        <td><a href='{{url('/').'/'.$fila->foto_vin}}' target='_blank'><i class='far fa-images fa-4x'></i></a></td>
                                        <td>
                                            @if ($fila->nombre_vista == "")
                                            <button type="button" class="btn btn-primary bloqueo" data-toggle="modal" data-target="#exampleModal{{$fila->idinventario_galeria_trucks}}"> Tipo </button>

                                            <div class="modal fade" id="exampleModal{{$fila->idinventario_galeria_trucks}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label  for="">Tipo</label>
                                                                    <div class="content-select">

                                                                        <select name="tipo"  class="form-control tipo tipos{{$fila->idinventario_galeria_trucks}}" id="{{$fila->idinventario_galeria_trucks}}">
                                                                            <option value=''>Elige Opción..</option>
                                                                            @foreach ($inventario_vistas_trucks as $fila2)
                                                                                <option value='{{$fila2->nombre}}'>{{$fila2->nombre}}</option>
                                                                            @endforeach
                                                                            </select>

                                                                            <i></i>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label  for="">Comentarios</label>
                                                                        <textarea class="form-control comentario comentarios{{$fila->idinventario_galeria_trucks}}" id="{{$fila->idinventario_galeria_trucks}}"></textarea>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="button" class="btn btn-primary enviar_tipo enviar_tipos{{$fila->idinventario_galeria_trucks}}" id="{{$fila->idinventario_galeria_trucks}}">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                {{$fila->nombre_vista}}
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->


                        <!-- ----------------------------------------------- -->




                        <div class="content-swiper" style="margin-top:8%;">
                            <!-- Swiper -->
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">

                                    @if (count($inventario_galeria_trucks)==0)
                                        <div class='swiper-slide' style="background-image:url('{{asset('public/img/fondo_blanco.jpg')}}');">
                                        <div class='contenido-descripcion'>
                                        <h1 style='color: #fff; text-align: center; font-size: 20px;'> Pendiente</h1>
                                        <p style='color: #fff; text-align: center;'>Pendiente</p>
                                        </div>
                                        </div>
                                    @else
                                        @foreach ($inventario_galeria_trucks as $fila2)
                                            <div class='swiper-slide' style="background-image:url('{{url('/').'/'.$fila2->foto_vin}}');">
                                            <div class='contenido-descripcion'>
                                            <h1 style='color: #fff; text-align: center; font-size: 20px;'>
                                                @if(!empty($fila2->nombre_vista)){{$fila2->nombre_vista}}@else Pendiente @endif
                                            </h1>
                                            <p style='color: #fff; text-align: center;'>
                                                @if(!empty($fila2->descripcion))
                                                    {{$fila2->descripcion}}
                                                @else Pendiente @endif

                                            </p>
                                            </div>
                                            </div>

                                        @endforeach
                                    @endif


                                </div>
                                <!-- Add Arrows -->
                                <div class="swiper-button-next swiper-button-white"><i class="fas fa-chevron-right"></i></div>
                                <div class="swiper-button-prev swiper-button-white"><i class="fas fa-chevron-left"></i></div>
                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">
                                    @if (count($inventario_galeria_trucks)==0)
                                        <div class='swiper-slide' style="background-image:url('{{asset('public/img/fondo_blanco.jpg')}}');"></div>
                                    @else
                                        @foreach ($inventario_galeria_trucks as $fila2)
                                            <div class='swiper-slide' style="background-image:url('{{url('/').'/'.$fila2->foto_vin}}');"></div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>






                        <!-- ----------------------------------------------- -->



                    </div>
                </div>




                <div class="shadow panel-head-primary" style="padding-top: 2%; padding-bottom:2%;">
                    <h5 class="mt-3 mb-3"><strong>Cambios {{$inventario->vin_numero_serie}}</strong></h5>
                    <div class="col-lg-12">

                        <!-- ----------------------------------------------- -->


                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example2" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Descripción de modificación</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventario_cambios_trucks_collect as $value)
                                        <tr class="odd gradeX">
                                            <td>@if(!empty($value->info['descripcion_cambio'])){!!$value->info['descripcion_cambio']!!}@else {{"Sin registro"}}@endif</td>
                                            <td>@if(!empty($value->usuario)) {!!$value->usuario!!}@else {{"Sin registro"}}@endif</td>
                                            <td>@if(!empty($value->info['fecha'])){!!$value->info['fecha']!!}@else {{"Sin registro"}}@endif</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->


                            <!-- ----------------------------------------------- -->



                        </div>
                    </div>









            </div>
        </div>

    </div>


























@endsection


@section('js')


<script src="{{asset('public/js/my-js.js')}}" type="text/javascript"></script>
<script type="text/javascript">


$('#alternar-respuesta-ej1').on('click',function(){
    $('#respuesta-ej1').toggle('slow');
});

$('#alternar-respuesta-ej2').on('click',function(){
    $('#respuesta-ej2').toggle('slow');
});


function confirmar(url){
    if (!confirm("¿Está seguro de que desea eliminar a este Proveedor?")) {
        return false;
    }
    else {
        document.location= url;
        return true;
    }
}

//<!------Se utiliza para que el campo de texto solo acepte letras------>
function SoloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    especiales = [8, 37, 39, 46, 6];
    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if(letras.indexOf(tecla) == -1 && !tecla_especial){
        return false;
    }
}
//<!-----Se utiliza para que el campo de texto solo acepte numeros----->
function SoloNumeros(evt){
    if(window.event){ //asignamos el valor de la tecla a keynum
        keynum = evt.keyCode; //IE
    }
    else{
        keynum = evt.which; //FF
    }

    //comprobamos si se encuentra en el rango numérico
    if((keynum >= 48 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
        return true;
    }
    else{
        return false;
    }

}


$("#ver_mas").click(function(){
    $("#datos-principales").addClass('fadeOutLeft_izi');
    $("#datos-principales").fadeOut( function(){
        $("#datos-secundarios").addClass("fadeInLeft_izi");
        $("#datos-secundarios").fadeIn(function(){
            $("#datos-secundarios").removeClass("fadeInLeft_izi");
            $("#datos-principales").removeClass('fadeOutLeft_izi');
        });
    }
);
});
$("#regresar").click(function(){
    $("#datos-secundarios").addClass('fadeOutRight_izi');
    $("#datos-secundarios").fadeOut(function(){
        $("#datos-principales").addClass("fadeInRight_izi");
        $("#datos-principales").fadeIn(function(){
            $("#datos-principales").removeClass('fadeInRight_izi');
            $("#datos-secundarios").removeClass('fadeOutRight_izi');
        });
    });
});

$(function() {
    $("[data-ref^='#']").bind('click', function(e) {
        //$('a[href*=#]').bind('click', function(e) {
        e.preventDefault();
        var target = $(this).attr("data-ref");
        $('html, body').stop().animate({
            scrollTop: $(target).offset().top
        }, 600, function() {
            // location.hash = target;
        });
        return false;
    });
});

$(document).ready(function(){
    $("#porcentaje").keyup(function(){
        var vari = $("#porcentaje").val();
        var contacid =  $("#contacid").val();
        var de =  $("#de").val();
        $.post("recibe_por.php", {vari: vari,contacid:contacid}, function(resultado) {
            $("#cantidad_de").val(parseFloat(resultado).toFixed(2));
            $("#new_saldos").val((parseFloat(resultado)+parseFloat(de)).toFixed(2));
            console.log(resultado);
            var textoletras = $("#new_saldos").val();

            if (textoletras != "") {
                $.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
                    delete mensaje_letras;
                    $("#letra").val(mensaje_letras);
                    console.log(mensaje_letras);
                });
            } else {
                $("#letra").val('');
            }
        });
    });
});
/* var  valor =resultado;*/

$(document).ready(function(){
    var porcen2 = $("#porcen").val();
    var debe2 = $("#debe").val();
    var cantidad2 = $("#cantidad_porcentaje").val();
    var di3 = $("#di").val();
    var nuevo_s= parseFloat(debe2) + (((parseFloat(porcen2)/100)/30)*parseFloat(di3))*parseFloat(debe2);

    $("#new_saldo").val(nuevo_s.toFixed(2));
    $("#cantidad_porcentaje").val(((((parseFloat(porcen2)/100)/30)*parseFloat(di3))*parseFloat(debe2)).toFixed(2));
    $("#porcen").keyup(function(){
        var debe = $("#debe").val();
        var porcen = $("#porcen").val();
        var di2 = $("#di").val();
        var cantidad = ((((parseFloat(porcen)/100)/30)*parseFloat(di2))*parseFloat(debe));
        var nuevo_saldo = parseFloat(debe) + parseFloat(cantidad);
        if (porcen < 2) {
            $("#porcen").css("border-color","red");
            $("#cantidad_porcentaje").val("");
            $("#new_saldo").val("");
        }else{
            $("#cantidad_porcentaje").val(cantidad.toFixed(2));
            $("#porcen").css("border-color","white");
            $("#new_saldo").val(nuevo_saldo.toFixed(2));
        }
    });

    $("#cantidad_porcentaje").keyup(function(){
        var debe = $("#debe").val();
        var di = $("#di").val();
        var cantidad = $("#cantidad_porcentaje").val();
        var nuevo_sal = parseFloat(debe) + parseFloat(cantidad);
        var p = ((parseFloat(cantidad)/parseFloat(debe))/parseFloat(di)*30*100)  ;
        if (p < 2) {
            $("#porcen").css("border-color","red");
            $("#new_saldo").val("");
        }else{
            $("#porcen").val(p.toFixed(2));
            $("#porcen").css("border-color","white");
            $("#new_saldo").val(nuevo_sal.toFixed(2));
        }
    });

    $("#cantidad_porcentaje").keyup(function(){
        var textoletras = $("#new_saldo").val();
        if (textoletras != "") {
            $.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
                delete mensaje_letras;
                $("#letra").val(mensaje_letras);
                console.log(mensaje_letras);
            });
        } else {
            $("#letra").val('');
        }
    });

    $("#porcen").keyup(function(){
        var textoletras = $("#new_saldo").val();
        if (textoletras != "") {
            $.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
                delete mensaje_letras;
                $("#letra").val(mensaje_letras);
                console.log(mensaje_letras);
            });
        } else {
            $("#letra").val('');
        }
    });

    $("#agregar_po").click(function(){
        var checado = "no";
        if( $("#check").prop('checked') ) {
            checado = "si";
        }
        var porcen = $("#porcen").val();
        var di = $("#di").val();
        var cantidad_porcentaje = $("#cantidad_porcentaje").val();
        var new_saldo = $("#new_saldo").val();
        var contac = $("#contac").val();
        $.post("guardar_porcentaje.php", {checado: checado,porcen: porcen,di: di,cantidad_porcentaje: cantidad_porcentaje,new_saldo: new_saldo,contac: contac }, function(resultado) {
            alert(resultado);
            $("#ibox-content").load(" #ibox-content");
        });
    });

    $("#agregar_po2").click(function(){
        var checado1 = "no";
        if( $("#check2").prop('checked') ) {
            checado1 = "si";
        }
        var porcentaje = $("#porcentaje").val();
        var di = $("#di").val();
        var cantidad_de = $("#cantidad_de").val();
        var new_saldos = $("#new_saldos").val();
        var contacid = $("#contacid").val();
        var total_vencido = $("#de").val();
        var pagares_numero = $("#pagares_numero").val();
        var fecha_creaci =$("#fecha_creacion2").val();
        var total_de =$("#total_de").val();
        if (new_saldos !="") {
            if (porcentaje < 2) {
                alert("El Porcentaje es Inferior a 2");
                $("#porcentaje").val("");
                $("#cantidad_de").val("");
                $("#new_saldos").val("");
            }else{
                $.post("guardar_porcentaje_por_pagare.php", {checado: checado1,porcen: porcentaje,di: di,cantidad_porcentaje: cantidad_de,new_saldo: new_saldos,contac: contacid,total_vencido: total_vencido,pagares_numero :pagares_numero,fecha_creaci:fecha_creaci,total_de: total_de }, function(resultado) {
                    if (new_saldos != "NaN") {
                        if (resultado=="Se Presentó un Error" && resultado== "El Nuevo Saldo  no es un valor numérico") {
                            alert(resultado);
                        }else{
                            if (checado1 == "si") {
                                alert("Agregado Correctamente");
                                window.open(resultado);
                            }else{
                                alert("Agregado Correctamente");
                            }
                        }
                    }else{
                        alert("No hay datos");
                    }

                    $("#ibox-content").load(" #ibox-content");
                    $("#conte").load(" #conte");
                });
            }
        }else{
            alert("Los Campos estan vacíos");
        }
    });
});

function buscar_letras() {
    var textoletras = $("#new_saldo").val();
    if (textoletras != "") {
        $.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
            $("#letra").val(mensaje_letras);
        });
    } else {
        $("#letra").val('');
    };
};


var formatNumber = {
    separador: ",", // separador para los miles
    sepDecimal: '.', // separador para los decimales
    formatear:function (num){
        num +='';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
            splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
        }
        return this.simbol + splitLeft  +splitRight;
    },
    new:function(num, simbol){
        this.simbol = simbol ||'';
        return this.formatear(num);
    }
}
</script>
<!-- ****************************************************************************************************************** -->

<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
  var galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });
  var galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 10,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: galleryThumbs,
    },
  });
</script>
<script  type="text/javascript">
  $(document).ready(function() {



    $("#uploadedfile").change(function(){
      var cantidad_archivos = document.getElementById("uploadedfile").files.length;
      var cont = 0;
      var cont1 = 0;
      $("#origen").empty();

      if (cantidad_archivos <= 20) {
        $(".cargar").removeAttr('disabled');
      }else{
        alert("El limite de archivos es 20")
        $("#uploadedfile").val(''); ;
        $(".cargar").attr('disabled','disabled');
        $(".enviar").attr('disabled','disabled');
      }
      $(".enviar").css('display','none');
    });


    $(".cargar").click(function(){
      var cantidad_archivos = document.getElementById("uploadedfile").files.length;
      var cont = 0;
      var cont1 = 0;
      var cont1x = 1;


      if (cantidad_archivos <= 20) {
        $(".enviar").removeAttr('disabled');
        while(cont1 < cantidad_archivos){
          $("#origen").append('<div class="col-sm-6 p-0 pb-2 mb-4" style="background: #161616;"><h2 class="text-center p-3" id="txtIOriginal" style=" background: #444; color: #fff; font-size: 20px;">Imagen Original '+cont1x+'</h2><img id="image_carga'+cont1+'" class="centrado"  style="margin:0 auto;" /></div>');
          $("#origen").append('<div class="col-sm-6 p-0 pb-2 mb-4" style="background: #161616;"><h2 class="text-center p-3" id="txtIOptimizada" style=" background: #444; color: #fff; font-size: 20px;">Imagen Optimizada '+cont1x+'</h2><img id="result_image'+cont1+'" class="centrado" style="margin:0 auto;"/></div>');
          cont1++;
          cont1x++;
          $("#enviar").show();
          $(".ocultoTooltip").show();
        }

        while(cont < cantidad_archivos){
          var uploadedfile2 = document.getElementById("uploadedfile").files[cont];
          var reader = new FileReader();
          reader.readAsDataURL(uploadedfile2 );
          var tmppath = URL.createObjectURL(uploadedfile2);
          document.getElementById('image_carga'+cont+'').src = tmppath;
          document.getElementById('image_carga'+cont+'').style.width="320px";
          document.getElementById('image_carga'+cont+'').style.height="auto";
          console.log(uploadedfile2);
          cont++;
        }
      }else{
        $("#uploadedfile").val(''); ;
        $(".cargar").attr('disabled','disabled');
        $(".enviar").attr('disabled','disabled');
      }
      $(".cargar").attr('disabled','disabled');

    });




    function b64toBlob(b64Data, contentType, sliceSize) {
      contentType = contentType || '';
      sliceSize = sliceSize || 512;

      var byteCharacters = atob(b64Data);
      var byteArrays = [];

      for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
        var slice = byteCharacters.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
          byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
      }

      var blob = new Blob(byteArrays, {type: contentType});
      return blob;
    }

    $(".enviar").click(function(){
      $(".enviar").attr('disabled','disabled');
      $(".bloqueo").attr('disabled','disabled');
      $("#resultado").show();
      var cantidad_archivos = document.getElementById("uploadedfile").files.length;
      var idinventario = document.getElementById("idinventario").value;
      var con = 0;
      var output_format = "jpg";
      var formData = new FormData();
      var colores =  new Array();
      var duration;
      var data;
      var block;
      var contentType;
      var realData;
      var blob;
      var source_image;
      var result_image;
      var quality;
      var time_start;
      while(con < cantidad_archivos){
        source_image = document.getElementById('image_carga'+con+'');
        console.log(source_image.src);
        result_image = document.getElementById('result_image'+con+'');
        console.log("resultado "+result_image);
        if (source_image.src == "") {
          alert("No se a cargado ninguna imagen...");

        }
        quality = parseInt("20");
        console.log("Quality >>" + quality);
        console.log("process start...");
        time_start = new Date().getTime();

        result_image.src = jic.compress(source_image,quality,output_format).src;
        result_image.style.width="320px";
        result_image.style.height="auto";
        duration = new Date().getTime() - time_start;
        console.log("process finished...");
        console.log('Processed in: ' + duration + 'ms');
        data = result_image.src;
        block = data.split(";");
        contentType = block[0].split(":")[1];
        realData = block[1].split(",")[1];
        blob = b64toBlob(realData, contentType);
        console.log(blob);
        colores[con] = blob;
        formData.append('result_image[]',colores[con]);
        con++;
      }

      formData.append('cantidad_archivos',cantidad_archivos);
      formData.append('idinventario',idinventario);
      console.log(formData);
      $.ajax({
          headers: {
                  "Accept": "application/json",
                  "X-Requested-With": "XMLHttpRequest",
                  "X-CSRF-Token": '{{csrf_token()}}',
              },
        data : formData,
        url : '{{route("inventoryAdmin.saveGalleryImages", ["id" => $inventario->idinventario_trucks])}}',
        type : 'post',
        processData: false,
        contentType: false,
        beforeSend: function () {
          $("#resultado").html("<div style='text-align: center;'><i class='fas fa-spinner fa-pulse' style='font-size: 50px; color: #fff;'></i><h1 style='font-size: 24px; color: #fff;'>Procesando, espere por favor...</h1></div>");
        },
        success : function(json) {
            // console.log(json);
            $("#resultado").html("");
            $("#resultado").hide();
            $("#respuesta").html(json);
            iziToast.success({
                title: '¡Operación exitosa!',
                message: 'Las imagenes se guardaron correctamente. <br>La página se recargará en breve.',
                timeout: false,
                closeOnClick: true,
                closeOnEscape: true,
            });
            setInterval(function(){
                location.reload();
            },5000);


        },
        error : function(xhr, status) {
            var err = JSON.parse(xhr.responseText);
            alert(err.message);
        }
      });

    });


    /********************************************/


    $(".enviar_tipo").click(function(){
      var id = $(this).attr("id");
      var tipo = $(".tipos"+id).val();
      var comentario = $(".comentarios"+id).val();
      var formData2 = new FormData();

      if (tipo != "" && comentario != "") {




        formData2.append('id',id);
        formData2.append('tipo',tipo);
        formData2.append('comentario',comentario);

        $.ajax({
            headers: {
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": '{{csrf_token()}}',
                },
          data : formData2,
          url : '{{route("inventoryAdmin.updateGalleryTypeTruck")}}',
          type : 'post',
          processData: false,
          contentType: false,
          success : function(json) {
              if(JSON.parse(json).message == "success"){
                  iziToast.success({
                      title: '¡Operación exitosa!',
                      message: 'Los datos se actualizaron correctamente. <br>La página se recargará en breve.',
                      timeout: false,
                      closeOnClick: true,
                      closeOnEscape: true,
                  });
                  setInterval(function(){
                    location.reload();
                  },3000);
              }else {
                  iziToast.error({
                      title: '¡Operación fallida!',
                      message: 'Los datos no se actualizaron.',
                      timeout: false,
                      closeOnClick: true,
                      closeOnEscape: true,
                  });
              }
          },
          error : function(xhr, status) {
              iziToast.error({
                  title: '¡Operación exitosa!',
                  message: 'Los datos se actualizaron correctamente. <br>La página se recargará en breve.',
                  timeout: false,
                  closeOnClick: true,
                  closeOnEscape: true,
              });
          }
        });
      }

    });





  });


</script>



<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
  var galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });
  var galleryTop = new Swiper('.gallery-top', {
    spaceBetween: 10,
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: galleryThumbs,
    },
  });
</script>




@endsection
