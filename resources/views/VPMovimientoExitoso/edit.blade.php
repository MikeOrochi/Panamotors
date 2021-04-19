@extends('layouts.appAdmin')
@section('titulo', 'Editar Vista Previa de Movimiento Exitoso')
@php
use App\Http\Controllers\GlobalFunctionsController;
@endphp
@section('content')
  <style media="screen">

  .readonly{
    background: #e9ecef;
    cursor: default;
  }

  @media (max-width: 576px) {
    .grid-item{
      width: 50% !important;
      margin-right: 0px !important;
    }
    .Movil{
      width: 100% !important;
    }
    .grid-item .btnPermuta{
      display: block !important;
    }

    .container{
      padding-left: 0px !important;
      padding-right: 0px !important;
    }
  }




  .grid-item {
    display: block;
    width: 30%;
    height: 134px;
    margin-right: 27px;
    border-radius: 7px;
    margin-bottom: 27px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    background-size: cover;
  }
  .grid-item span {
    text-transform: uppercase;
    /*color: #fff;*/
    font-family: "Poppins-Medium";
    font-weight: 500;
    display: block;
    margin-top: 11px;
  }

  .grid-item:hover , .seleccion{
    box-shadow: 0 2px 7px 0 rgb(0 0 0 / 25%);
    -webkit-box-shadow: 0 2px 7px 0 rgb(0 0 0 / 25%);
    -moz-box-shadow: 0 2px 7px 0 rgba(0,0,0,.25);
    -ms-box-shadow: 0 2px 7px 0 rgba(0,0,0,.25);
    -o-box-shadow: 0 2px 7px 0 rgba(0,0,0,.25);
  }

  .grid-item:hover .btnPermuta ,.btnPermutaSeleccion{
    display: block !important;
  }
  .grid-item .btnPermuta{
    display: none;
  }

  .btnPermutaSeleccion button{
    background-color: #e0a800 !important;
    border-color: #d39e00 !important;
  }



  .grid-item .spanOpcionesVenta{
    width: 30%;
  }
  .grid-item.grises .spanOpcionesVenta{
    width: 100%;
  }

  .btnPermuta button{
    background-color: #c9cdd0;
    border-color: #e9ecef;
  }

  .btnPermuta button:hover{
    background-color: #e0a800;
    border-color: #d39e00;
  }



  .grises{
    filter: grayscale(1);
  }

  .dataTables_filter {
    display: none;
  }
  .dataTables_length{
    display: none;
  }
  .dataTables_info{
    display: none;
  }
  .dataTables_paginate{
    /* display: none; */
  }
  #select2-search_provider_client-container{
    font-size: 17px;
  }

  #select2-search_provider_client-results > li{
    color: #161714;
    font-size: 17px;

  }
  .flipOutX_izi{
    -webkit-backface-visibility: visible!important;
    backface-visibility: visible!important;
    -webkit-animation: iziT-flipOutX .7s cubic-bezier(.4,.45,.15,.91) both;
    animation: iziT-flipOutX .7s cubic-bezier(.4,.45,.15,.91) both;
  }

  .fadeInDown_izi{
    -webkit-animation: iziT-fadeInDown .7s ease both;
    animation: iziT-fadeInDown .7s ease both;
  }
  .flipInX_izi{
    -webkit-animation: iziT-flipInX .85s cubic-bezier(.35,0,.25,1) both;
    animation: iziT-flipInX .85s cubic-bezier(.35,0,.25,1) both;
  }
  .flipInRight_izi{
    -webkit-animation: iziT-fadeInRight .85s cubic-bezier(.25,.8,.25,1) both;
    animation: iziT-fadeInRight .85s cubic-bezier(.25,.8,.25,1) both;
  }
  .fadeOutLeft_izi {
    -webkit-animation: iziT-fadeOutLeft .5s ease both;
    animation: iziT-fadeOutLeft .5s ease both;
  }
  .bounceInUp_izi {
    -webkit-animation: iziT-bounceInUp .7s ease-in-out both;
    animation: iziT-bounceInUp .7s ease-in-out both;
  }
  .fadeOutDown_izi {
    -webkit-animation: iziT-fadeOutDown .7s cubic-bezier(.4,.45,.15,.91) both;
    animation: iziT-fadeOutDown .7s cubic-bezier(.4,.45,.15,.91) both;
  }
  </style>



  <div class="modal fade" id="ModalCambiaVIN" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Cambio de Unidad</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="venta" name="venta" enctype="multipart/form-data" method="post" action="{{route('vpMovimientoExitoso.CambioUnidad')}}" class="needs-validation confirmation">
            @csrf
            <input type="hidden" name="tipoUnidad" id="tipoUnidad" value="">
            <input type="hidden" name="idVistaPrevia"  value="{{$vpme->id}}">

            <div class="row" id="CampoBusquedaVIN">
              <label>Buscar VIN</label>
              <div class="col-sm-12">
                <input placeholder="Buscar" class="form-control" type="text" id="busqueda_vin" maxlength="25" autocomplete="off" onkeyup="buscar_vin_bloqueado();" size="19" width="300%" required value="{{$vpme->vin_numero_serie}}">
                <i id="LoadingBusquedaVIN" class="fas fa-spinner fa-spin" aria-hidden="true" style="position: absolute;right: 23px;top: 9px;display:none"></i>
              </div>
              <div class="col-sm-12" style="padding-top: 5px;padding-bottom:10px;">
                <select class="form-control" style="border-radius:20px;font-family: 'FontAwesome';" id="resultadoBusquedaVin_X" name="idUnidad" required="" onchange="SugerenciaVIN()">
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 offset-md-3" style="text-align: center;display:none" id="DivPrecioSinDescuento">
                <label for="MontoSinDescuento">Precio Digital</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
                  </div>
                  <input type="text" class="form-control" id="MontoSinDescuento" placeholder="$0.00" required="" maxlength="10" style="border-radius: 0px !important;" readonly>
                  <div class="input-group-prepend">
                    <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">MXN</div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="MontoSinDescuentoLetra" readonly="" value="" style="text-align:center;">
                </div>
              </div>
            </div>


            <div id="ModificarPrecio" style="display:none;">
              <div class="col-md-6 offset-md-3" style="text-align: center;">
                <i class="fas fa-arrow-down"></i>
              </div>
              <div class="col-md-6 offset-md-3" style="text-align: center;">
                <label for="MontoConDescuento"></label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
                  </div>
                  <input type="number" class="form-control" id="MontoConDescuento" name="MontoConDescuento" placeholder="$0.00" required=""  style="border-radius: 0px !important;" step="0.01" onchange="EstablecerPrecioCompra(this)" required>
                  <div class="input-group-prepend">
                    <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">MXN</div>
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="MontoConDescuentoLetra" readonly="" value="" style="text-align:center;">
                </div>
              </div>
            </div>
            <div class="row" id="BotonesMostrarDescuento" style="display:none">
              <div class="col-md-6 offset-md-3" style="text-align: center;">
                <div class="row">
                  <div class="col">
                    <button type="button" id="BtnMostrarD" class="btn btn-warning" onclick="MostrarDivDescuento(this)"><i class="far fa-edit"></i> Modificar precio</button>
                  </div>
                  <div class="col">
                    <button type="submit" class="btn btn-success"> Guardar <i class="far fa-check-circle"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="ModalUsuario" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Tipo de Cliente:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="row" style="justify-content: center;">
            <a  class="grid-item" style="" onclick="MostrarInputNU(this)" id="ClienteNuevo_S">
              <div class="inner">
                <img src="{{secure_asset('storage/app/VPMovimientoExitoso/NewClient.png')}}" alt="">
                <span>Nuevo</span>
              </div>
            </a>

            <a class="grid-item" style="" onclick="BuscarCliente(this)" id="ClienteCartera_S">
              <div class="inner">
                <img src="{{secure_asset('storage/app/VPMovimientoExitoso/Wallet.png')}}" alt="">
                <span>Cartera</span>
              </div>
            </a>

            <input type="hidden" class="form-control" name="idContact" id="idContact" value="N/A">
          </div>

          <div style="display:none;" id="NuevoCliente">
            <form class="needs-validation" action="{{route('vpMovimientoExitoso.CambioNuevoContacto')}}" method="post" style="width:100%;">
              @csrf
              <input type="hidden" name="idVistaPrevia"  value="{{$vpme->id}}">
              <input type="hidden" name="ContactoNuevo" value="{{$ContactoNuevo}}">

              <div class="row">
                <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                  <label for=""><b style="color:red">*</b> Nombre:</label>
                  <p class="col" style="padding: 0px 5px;"><input name="nombre" class="form-control" required
                    @if ($ContactoNuevo)
                      value="{{$Contacto->nombre}}"
                    @endif
                    ></p>
                  </div>
                  <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                    <label for=""><b style="color:red">*</b> Apellidos:</label>
                    <p class="col" style="padding: 0px 5px;"><input name="apellidos" class="form-control" required
                      @if ($ContactoNuevo)
                        value="{{$Contacto->apellidos}}"
                      @endif
                      ></p>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-12 col-sm-12" style="margin-bottom: 0px;">
                      <label for=""><b style="color:red">*</b> Telefono:</label>
                      <p class="col" style="padding: 0px 5px;"><input name="telefono" class="form-control" required minlength="10" maxlength="10"
                        @if ($ContactoNuevo)
                          value="{{$Contacto->telefono}}"
                        @endif
                        ></p>
                      </div>
                    </div>

                    <div class="row">

                      <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                        <label for="CodigoP">Codigo Postal:</label>
                        <input id="CodigoP" name="cp" class="form-control" onkeyup="getZip()" minlength="5" maxlength="5"
                        @if ($ContactoNuevo)
                          value="{{$Contacto->cp}}"
                        @endif
                        >
                      </div>


                      <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                        <label for="Estado"><b style="color:red">*</b> Estado:</label>
                        <input id="Estado" name="estado" class="form-control" required
                        @if ($ContactoNuevo)
                          value="{{$Contacto->estado}}"
                        @endif
                        >
                        <i class="fas fa-spinner fa-spin LoadingCP" aria-hidden="true" style="position: absolute;left: 100px;top: 5px;display:none"></i>
                      </div>

                      <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                        <label for="Municipio"><b style="color:red">*</b> Municipio:</label>
                        <input id="Municipio" name="municipio" class="form-control" required
                        @if ($ContactoNuevo)
                          value="{{$Contacto->municipio}}"
                        @endif
                        >
                        <i class="fas fa-spinner fa-spin LoadingCP" aria-hidden="true" style="position: absolute;left: 100px;top: 5px;display:none"></i>
                      </div>

                      <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                        <label for="Colonia">Colonia:</label>
                        <select class="form-control" name="colonia" style="border-radius:20px" id="Colonia" placeholder="Colonia" style="font-size: 13px;">
                          @if ($ContactoNuevo)
                            <option value="{{$Contacto->colonia}}">{{$Contacto->colonia}}</option>
                          @endif
                        </select>
                        <i class="fas fa-spinner fa-spin LoadingCP" aria-hidden="true" style="position: absolute;left: 100px;top: 5px;display:none"></i>
                      </div>

                      <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                        <label for="Colonia">Calle y número:</label>
                        <p style="padding: 0px 5px;"><input name="calle" class="form-control"
                          @if ($ContactoNuevo)
                            value="{{$Contacto->direccion}}"
                          @endif
                          ></p>
                        </div>
                      </div>

                      <div class="col-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                      </div>

                    </form>
                  </div>

                  <div style="display:none" id="BuscarClienteInputs">

                    Cliente:
                    <div class="row">
                      <p class="col-12">
                        <input name="search_client" id="search_client" onkeyup="SearchClient(this)" class="form-control" required>
                        <i id="LoadingClient" class="fas fa-spinner fa-spin" aria-hidden="true" style="position: absolute;right: 23px;top: 9px;display:none"></i>
                      </p>

                      <form class="needs-validation" action="{{route('vpMovimientoExitoso.CambioContacto')}}" method="post" style="width:100%;">
                        @csrf
                        <input type="hidden" name="idVistaPrevia"  value="{{$vpme->id}}">
                        <p class="col-12">
                          <select class="form-control" name="Cliente" style="border-radius:20px" id="ListaClientes" class="form-control" required>
                          </select>
                        </p>
                        <div class="col-12" style="text-align: center;">
                          <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>

                      </form>
                    </div>

                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
              </div>
            </div>
          </div>


          <!-- Modal -->
          <div class="modal fade" id="ModalCambiaTipoVenta" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tipo de Venta</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form enctype="multipart/form-data" method="post" action="{{route('vpMovimientoExitoso.cambioTipoVenta')}}" class="needs-validation confirmation">
                    @csrf

                    <input type="hidden" name="idVistaPrevia"  value="{{$vpme->id}}">
                    <input name="tipoVenta" id="tipoVenta" class="form-control" required="" style="display:none;">

                    <div class="row" style="justify-content: center;">

                      <a class="grid-item Movil" style="display: table;" id="SeleccionarVentaCredito" onclick="CambioVenta(this,'Directa a Crédito')">
                        <div class="inner" style="height: 100%; width:50%;display: table-cell;vertical-align: middle;">
                          <span style="height: 33%;">Credito</span>
                          <img src="https://www.dualtrucks.com/Des/CCDT/Perfiles2/CCP/storage/app/VPMovimientoExitoso/credito.png" alt="">
                        </div>
                      </a>

                      <a class="grid-item Movil" style="display: table;" id="SeleccionarVentaContado" onclick="CambioVenta(this,'Directa de Contado')">
                        <div class="inner" style="height: 100%; width:50%;display: table-cell;vertical-align: middle;">
                          <span style="height: 33%;">Contado</span>
                          <img src="https://www.dualtrucks.com/Des/CCDT/Perfiles2/CCP/storage/app/VPMovimientoExitoso/contado.png" alt="">
                        </div>
                      </a>

                    </div>
                    <div class="row">
                      <div class="col-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="CerrarModal">Cancelar</button>
                </div>
              </div>
            </div>
          </div>


          <div class="row mt-3">
            <div class="col-sm-12">
              <div class="shadow panel-head-primary">
                <div class="table-responsive">
                  <div class="container">


                    <!-- ------------------------------------------- -->


                    <div class="row" style="padding:30px">
                      <div class="row" id='form_provider' style="width: 100%;">

                        <!-- ------------------------------------- -->

                        <div class="col-sm-12 col-xs-12 content pt-3 pl-0" style="width: 100%;">

                          <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
                            <span class="text-secondary"> <a href=""><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
                            <span class="text-secondary"> Editar</span>
                            <br>



                            <div class="card" style="margin:0 auto; width: 450px;border-radius: 20px;background: #dadbe0;box-shadow: 0px 0px 20px rgb(136 36 57 / 20%);position: relative;overflow: hidden;">
                              <div class="card-header" style="padding:10px;background: #F3F3F3;">
                                <h2 style="text-align:center;">@if(!empty($inventario->vin_numero_serie)){{$inventario->vin_numero_serie}}@else{{'N/A'}}@endif</h2>
                                </div>
                                <div class="card-body" id="datos-principales" style="padding:0px;">
                                  <div class="col-lg-12 imagen-perfil" style="background: #fff;padding: 20px 0px;">
                                    <div class="" style="text-align: right;">

                                    </div>
                                    <div class="text-center">
                                      @if (!empty($img))
                                        <img alt='image' width='350' class='rounded-circle' src="{{$img}}" alt="">
                                      @else
                                        <img alt='image' width='350'  class='rounded-circle' src="https://www.panamotorscenter.com/Des/CCP/Fotos_Inventario/fondoblanco_actual.jpg" alt="">
                                      @endif
                                    </div>

                                  </div>

                                  <h5 class="mt-3 mb-3" style="text-align: center;"><strong>
                                    @if(!empty($vpme->estatus))
                                      @if(strtoupper($inventario->estatus_unidad) == "Pendiente")
                                        <h1><b style='color: red;'>{{strtoupper(GlobalFunctionsController::eliminar_tildes($vpme->estatus))}}</b></h1>
                                      @else
                                        <h1><b style='color: black;'>{{strtoupper(GlobalFunctionsController::eliminar_tildes($vpme->estatus))}}</b></h1>
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
                                              </b>
                                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCambiaVIN">
                                                <i class="far fa-edit"></i>
                                              </button>
                                            </td>
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
                                            <td colspan="3"style="text-align:center;">Tipo:

                                              @if (!empty($vpme->tipo_unidad))
                                                {{($vpme->tipo_unidad)}}
                                              @endif
                                            </td>
                                          </tr>
                                          <tr>
                                            <td colspan="3" style="text-align:center;">Precio:
                                              <b>
                                                @if (!empty($vpme->monto_unidad))
                                                  $ {{number_format($vpme->monto_unidad,2)}}
                                                @else $ 0.00 @endif
                                                </b></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>

                                      </div>
                                      <!-- Fin | Datos Personales -->
                                      <!-- Direccion -->

                                    </div>



                                    <div id="accordion" style="margin-top:20px;">
                                      <div class="card">
                                        <div class="card-header" id="headingTwo">
                                          <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                              Datos Venta
                                            </button>
                                          </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                          <div class="card-body">
                                            <form class="needs-validation" action="{{route('vpMovimientoExitoso.CambioDatos')}}" method="post">
                                              @csrf
                                              <input type="hidden" name="idVistaPrevia"  value="{{$vpme->id}}">
                                              <div class="row wrapper border-bottom white-bg page-heading" style="margin-top:5%;">

                                                <div class="col-sm-6">
                                                  <div class="form-group">
                                                    <label>Venta</label>
                                                    <div class="input-group mb-2">
                                                      <input type="text" class="form-control" id="tipo_venta" name="tipo_venta" maxlength="17" required value="{{$vpme->tipo_venta}}" readonly="">
                                                      <div class="input-group-prepend">
                                                        <div class="input-group-text btn-primary" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;" data-toggle="modal" data-target="#ModalCambiaTipoVenta">
                                                          <i class="far fa-edit" aria-hidden="true" style="color:white;"></i>
                                                        </div>
                                                      </div>
                                                    </div>

                                                  </div>
                                                </div>
                                                <div class="col-sm-6">
                                                  <div class="form-group">
                                                    <label>Fecha</label>
                                                    <input type="date" class="form-control" id="Fecha" name="Fecha" required value="{{ \Carbon\Carbon::parse($vpme->created_at)->format('Y-m-d')}}" >
                                                  </div>
                                                </div>
                                                @if (str_contains($vpme->tipo_venta,'Crédito'))
                                                  <div class="col-sm-4">
                                                    <div class="form-group">
                                                      <label>Enganche</label>
                                                      <input type="number" class="form-control" id="Anticipo" name="Anticipo" required value="{{$vpme->anticipo}}" step="0.01" onchange="LetrasEngranche()">
                                                    </div>
                                                  </div>
                                                  <div class="col-sm-8">
                                                    <div class="form-group">
                                                      <label>Monto letra</label>
                                                      <input type="text" class="form-control" id="letra_anticipo" name="letra_anticipo" required="" readonly="" value="">
                                                    </div>
                                                  </div>

                                                  <div class="col-sm-4" style="">
                                                    <label for="m_pago_anticipo">Metodo de pago</label>
                                                    <select class="form-control" id="m_pago_anticipo" name="m_pago_anticipo" onchange="changeComprobantePrincipal();" required="">
                                                      <option value="" disabled="">Elige una opción…</option>
                                                      <option value="N/A">N/A</option>
                                                      <option value="1">1 Efectivo</option>
                                                      <option value="3">3 Panamotors Center, S.A. de C.V.</option>
                                                    </select>
                                                  </div>
                                                  <div class="col-sm-4" style="4">
                                                    <label for="comprobante_anticipo">Tipo de comprobante</label>
                                                    <select class="form-control" id="comprobante_anticipo" name="comprobante_anticipo" onchange="ocultar_referencia_anticipo(this.value);" required="">
                                                      <option value="" disabled="">Elige una opción…</option>
                                                      <option value="N/A">N/A</option>
                                                      <option value="Recibo">Recibo</option>
                                                      <option value="Recibo Automático">Recibo automático</option>
                                                      <option value="Notificación digital">Notificación digital</option>
                                                    </select>
                                                  </div>
                                                @endif
                                                <div class="col-sm-4">
                                                  @if (str_contains($vpme->tipo_venta,'Crédito') || $NumPagares > 0)
                                                    <label>Pagares</label>
                                                    <div class="form-group">
                                                      <a href="{{route('vpMovimientoExitoso.VistaPagares',$vpme->id)}}" class="btn btn-outline-info">
                                                        Modificar Pagares <i class="fas fa-money-check-alt"></i>
                                                      </a>
                                                    </div>
                                                  @endif
                                                </div>




                                                <div class="col-sm-12">
                                                  <div class="form-group">
                                                    <label>Comentarios</label>
                                                    <textarea name="comentarios" class="form-control" rows="4" value="{{$vpme->comentarios_venta}}" >{{$vpme->comentarios_venta}}</textarea>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <center>
                                                    <button class="btn btn-lg btn-primary" type="submit">Guardar</button>
                                                  </center>
                                                </div>
                                              </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="card">
                                        <div class="card-header" id="headingThree">
                                          <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                              Datos Usuario
                                            </button>
                                          </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                          <div class="card-body">
                                            <div class="row wrapper border-bottom white-bg page-heading" style="margin-top:5%;">
                                              <div class="col-sm-6">
                                                <label>Nombre</label>
                                                <div class="input-group mb-2">
                                                  <input type="text" class="form-control" style="border-radius: 0px !important;" value="{{$Contacto->nombre}}" readonly>
                                                </div>
                                              </div>
                                              <div class="col-sm-6">
                                                <label>Apellidos</label>
                                                <div class="input-group mb-2">
                                                  <input type="text" class="form-control" style="border-radius: 0px !important;" value="{{$Contacto->apellidos}}" readonly>
                                                </div>
                                              </div>

                                              <div class="col-sm-6">
                                                <label>Telefono</label>
                                                <div class="input-group mb-2">
                                                  <input type="text" class="form-control" style="border-radius: 0px !important;" readonly
                                                  @if (isset($Contacto->telefono))
                                                    value="{{$Contacto->telefono}}"
                                                  @else
                                                    value="{{$Contacto->telefono_celular}}"
                                                  @endif
                                                  >
                                                </div>
                                              </div>

                                              <div class="col-sm-6">
                                                <label>Editar</label>
                                                <div class="form-group">
                                                  <a class="btn btn-primary" data-toggle="modal" data-target="#ModalUsuario">
                                                    <i class="far fa-edit" aria-hidden="true"></i>
                                                  </a>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>




                                  </div>
                                </div>
                                <!-- ------------------------------------- -->



                              </div>
                            </div>





                            <!-- ------------------------------------------- -->








                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  {{--@include('admin.partials.providers.js_edit_general')--}}




                  <script type="text/javascript">


                  function CambioVenta(div,valor){
                    $('.seleccion').removeClass('seleccion');
                    $(div).addClass('seleccion');
                    $('#tipoVenta').val(valor);
                  }
                  var Temporizador_VIN;
                  var BusquedaVinTexto = null;

                  var CargaVinInicial = true;
                  $(document).ready(function() {
                    buscar_vin_bloqueado();
                  });


                  @if (str_contains($vpme->tipo_venta,'Crédito'))
                  LetrasEngranche();
                  $('#m_pago_anticipo').val("{{$vpme->metodo_pago_anticipo}}");
                  $('#comprobante_anticipo').val("{{$vpme->tipo_comprobante_anticipo}}");

                  function LetrasEngranche(){
                    buscar_letras("Anticipo", "letra_anticipo");
                  }
                  @endif

                  function changeComprobantePrincipal(){
                    var m_pago_anticipo = $('#m_pago_anticipo').val();
                    if (m_pago_anticipo==3) {
                      $('#comprobante_anticipo').empty();
                      document.getElementById("comprobante_anticipo").innerHTML += "<option disabled>"+"Selecciona una opción"+"</option>";
                      document.getElementById("comprobante_anticipo").innerHTML += "<option value='Boucher'>"+"Boucher"+"</option>";
                    }else if (m_pago_anticipo==1) {
                      $('#comprobante_anticipo').empty();
                      document.getElementById("comprobante_anticipo").innerHTML += "<option disabled>"+"Selecciona una opción"+"</option>";
                      document.getElementById("comprobante_anticipo").innerHTML += "<option value='Recibo'>"+"Recibo"+"</option>";
                      document.getElementById("comprobante_anticipo").innerHTML += "<option value='Recibo Automático'>"+"Recibo Automático"+"</option>";
                      document.getElementById("comprobante_anticipo").innerHTML += "<option value='Notificación digital'>"+"Notificación digital"+"</option>";

                    }
                  }



                  function buscar_vin_bloqueado() {
                    if (BusquedaVinTexto != $("#busqueda_vin").val().trim()) {
                      BusquedaVinTexto = $("#busqueda_vin").val().trim();

                      $('#LoadingBusquedaVIN').fadeIn();
                      clearTimeout(Temporizador_VIN);
                      Temporizador_VIN = setTimeout(function() {
                        buscar_vin_bloqueado_Tempo();
                      }, 350);
                      $('#resultadoBusquedaVin_X').attr('size','8');
                      if($('#busqueda_vin').val() == "") $('#resultadoBusquedaVin_X').removeAttr('size');
                    }
                  }

                  //---------------------------------------------------------------------------------------------------------------------------------------------
                  function buscar_vin_bloqueado_Tempo() {

                    var textoBusquedaVin = $("#busqueda_vin").val().trim();

                    if (textoBusquedaVin != "") {

                      fetch("{{route('VPMovimientoExitoso.BuscarVIN')}}", {
                        headers: {
                          "Content-Type": "application/json",
                          "Accept": "application/json",
                          "X-Requested-With": "XMLHttpRequest",
                          "X-CSRF-Token": '{{csrf_token()}}',
                        },
                        method: "post",
                        credentials: "same-origin",
                        body: JSON.stringify({
                          valorBusqueda: textoBusquedaVin
                        })
                      }).then(res => res.json())
                      .catch(function(error) {
                        console.error('Error:', error)
                      })
                      .then(function(response) {

                        console.log(response);

                        if (response != null) {

                          $("#resultadoBusquedaVin_X").empty();
                          $('#LoadingBusquedaVIN').fadeOut();
                          $("#marca_venta").attr("readonly", "readonly");
                          $("#version_venta").attr("readonly", "readonly");
                          $("#color_venta").attr("readonly", "readonly");
                          $("#modelo_venta").attr("readonly", "readonly");
                          $("#vin_venta").attr("readonly", "readonly");


                          if (response.length > 0) {
                            $("#resultadoBusquedaVin_X").append(`<option value="" disabled selected>Seleccione una opción</option>`);
                          }else {
                            $("#resultadoBusquedaVin_X").append('<option class="sugerencias_vin" value=""><b>VIN NO Encontrado</b> <b>Completa los campos marcados<b></option>');
                            $('#resultadoBusquedaVin_X').attr('size','1');
                          }


                          response.forEach(function logArrayElements(element, index, array) {

                            $("#resultadoBusquedaVin_X").append(`
                              <option class="sugerencias_vin" `
                              +(  element.pasa_compra_permuta  == "NO" ? 'style="color:red;"':'')
                              +`value="`+(element.idinventario_trucks || element.idinventario) +`"`
                              +`data-info="` +
                              (element.idinventario_trucks || element.idinventario) + `~*~` +
                              element.marca + `~*~` +
                              element.version + `~*~` +
                              element.color + `~*~` +
                              element.modelo + `~*~` +
                              element.vin_numero_serie + `~*~`+
                              element.precio_digital +`~*~`+
                              element.tipo +`~*~`+
                              element.pasa_compra_permuta +`~*~`+
                              element.img +`">` +(element.tipo == "Unidad" ?  '':'' ) +'&nbsp;'+
                              element.vin_numero_serie + `-` +
                              element.marca + `-` +  element.color + `-` +
                              element.version + `-` + element.modelo + `-` +
                              `</option>`);
                            });


                            if (CargaVinInicial) {
                              $('#resultadoBusquedaVin_X').val({{$vpme->idinventario}});
                              SugerenciaVIN();
                            }
                          } else {
                            //$("#resultadoBusquedaVin").html("<b>VIN NO Encontrado</b> <b>Completa los campos marcados<b>");
                            $('#resultadoBusquedaVin_X').empty();
                            $("#marca_venta").val("").removeAttr("readonly").css("border-color", "#A0213C").focus();
                            $("#modelo_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
                            $("#color_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
                            $("#version_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
                            $("#vin_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
                            $("#orden_logistica").val("SI");
                          }

                        });


                      } else {
                        //$("#resultadoBusquedaVin").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
                        $('#resultadoBusquedaVin_X').empty();
                      };
                    }

                    function SugerenciaVIN(){

                      $('#resultadoBusquedaVin_X').attr('size','1');

                      var Datos = $("#resultadoBusquedaVin_X option:selected").attr('data-info').split('~*~');

                      console.log(Datos);


                      var idInventario = Datos[0];
                      var unidad_marca = Datos[1];
                      var unidad_version = Datos[2];
                      var unidad_color = Datos[3];
                      var unidad_modelo = Datos[4];
                      var textoBusquedaVin = Datos[5];
                      var precioPiso = parseFloat(Datos[6]);
                      var tipo = Datos[7];
                      var pasa_compra_permuta = Datos[8];

                      $('#DivPrecioSinDescuento').fadeIn();
                      $('#BotonesMostrarDescuento').fadeIn();

                      $('#tipoUnidad').val(tipo);


                      if (pasa_compra_permuta == 'NO') {


                        iziToast.warning({
                          title: 'Atención',
                          message: 'El VIN seleccionado contiene inconsistencia de ingreso.!',
                        });

                      }

                      var Cantidad_Minima = parseFloat(precioPiso - ((precioPiso/100)*15));

                      if (Cantidad_Minima == 0) {

                        iziToast.warning({
                          title: 'Atencion',
                          message: 'La unidad no cuenta con un precio establecido, <br>comunicarse con el area correspondiente',
                          position: 'center',
                          overlay: true,
                          transitionIn: 'flipInX',
                          transitionOut: 'flipOutX',
                        });

                        $('#MontoConDescuento').attr('min', 0);
                        //$('#MontoConDescuento').attr('max',precioPiso);
                        $('#MontoConDescuento').val('');
                        $('#MontoConDescuento').addClass('readonly');
                      }else{





                        $('#MontoConDescuento').attr('min', Cantidad_Minima);
                        //$('#MontoConDescuento').attr('max',precioPiso);

                        if (CargaVinInicial) {
                          MostrarDivDescuento(document.getElementById('BtnMostrarD'));
                          $('#MontoConDescuento').val({{$vpme->monto_unidad}});
                          CargaVinInicial = false;
                        }else{
                          $('#MontoConDescuento').val(precioPiso);
                        }
                        $('#MontoConDescuento').removeClass('readonly');
                      }



                      $('#MontoSinDescuento').val(precioPiso);
                      $('#saldo_nuevo_venta').val(precioPiso);
                      $('#td-precio-digital').html(precioPiso);
                      $('#monto_abono_venta').val(precioPiso);
                      $('#PrecioPisoDescuento').val(precioPiso);

                      buscar_letras("MontoSinDescuento", "MontoSinDescuentoLetra");
                      buscar_letras("MontoConDescuento", "MontoConDescuentoLetra");

                      $("#marca_venta").val(unidad_marca);
                      $("#modelo_venta").val(unidad_modelo);
                      $("#version_venta").val(unidad_version);
                      $("#color_venta").val(unidad_color);
                      $("#vin_venta").val(textoBusquedaVin);

                      $("#td-marca").html(unidad_marca);
                      $("#td-modelo").html(unidad_modelo);
                      $("#td-version").html(unidad_version);
                      $("#td-color").html(unidad_color);
                      $("#td-vin-numero-serie").html(textoBusquedaVin);

                      $('#nextBtn').prop('disabled',false);

                      //buscar_letras("saldo_nuevo_venta", "letra");
                    }

                    function MostrarDivDescuento(btn){
                      $(btn).parent().fadeOut();
                      $('#ModificarPrecio').fadeIn();
                    }

                    function EstablecerPrecioCompra(Inp){
                      buscar_letras("MontoConDescuento", "MontoConDescuentoLetra");
                    }

                    function buscar_letras(inputNum, Destino) {

                      var numero = $("#" + inputNum).val();
                      var tipo_cambio = 'MXN';

                      if (numero != "") {

                        var label = $('#' + Destino).parent().find('label');
                        label.html('Precio Letra <i class="fas fa-spinner fa-spin" style="position: initial;"></i>');

                        fetch(" {{route('number.letters.convert',['',''])}}/" + numero + "/" + tipo_cambio, {
                          headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-Token": '{{csrf_token()}}',
                          },
                          method: "get",
                          credentials: "same-origin",
                        }).then(res => res.json())
                        .catch(function(error) {
                          console.error('Error:', error);
                          label.html('Precio Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
                        })
                        .then(function(response) {

                          if (response.info == null) {
                            iziToast.error({
                              title: 'Error',
                              message: 'Error al obtener la cantidad en letras',
                            });
                            label.html('Precio Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
                            $('#' + Destino).val('');
                          } else {
                            $('#' + Destino).val(response.info);
                            label.html('Precio Letra');
                          }

                        });
                      }
                    }

                    function MostrarInputNU(t){

                      idbusquedaContacto = 'N/A';
                      $('#idContact').val(idbusquedaContacto);

                      $('#BuscarClienteInputs').fadeOut();
                      $('#BuscarClienteInputs .form-control').prop('disabled',true);

                      $('#NuevoCliente').fadeIn();
                      $('#NuevoCliente .form-control').prop('disabled',false);

                      document.getElementById('ClienteCartera_S').classList.remove('seleccion');
                      document.getElementById('ClienteNuevo_S').classList.remove('grises');

                      t.classList.add('seleccion');


                      document.getElementById('ClienteCartera_S').classList.add('grises');
                    }

                    function BuscarCliente(t){

                      $('#ListaClientes').empty();
                      $('#search_client').val('');

                      $('#NuevoCliente').fadeOut();
                      $('#NuevoCliente .form-control').prop('disabled',true);

                      $('#BuscarClienteInputs').fadeIn();
                      $('#BuscarClienteInputs .form-control').prop('disabled',false);

                      document.getElementById('ClienteNuevo_S').classList.remove('seleccion');
                      document.getElementById('ClienteCartera_S').classList.remove('grises');


                      t.classList.add('seleccion');

                      document.getElementById('ClienteNuevo_S').classList.add('grises');
                    }

                    var contacts = null;

                    function SearchClient(input){
                      $('#LoadingClient').fadeIn();
                      $('#ListaClientes').attr('size','8');
                      if($('#search_client').val() == "") $('#ListaClientes').removeAttr('size');

                      fetch('{{route('provider.search','')}}/'+input.value)
                      .then(response => response.json())
                      .catch(function(error){
                        console.error('Error: ',error);
                        validate_search = 0;
                        idbusquedaContacto = idbusquedaContacto;
                        $('#LoadingClient').fadeOut();
                      })
                      .then(function(data){
                        validate_search = 0;
                        $('#LoadingClient').fadeOut();
                        if (data) {

                          contacts = data.contacts;

                          $('#ListaClientes').empty();
                          for(var i in contacts){
                            document.getElementById("ListaClientes").innerHTML += `<option value="`+contacts[i].idcontacto+`">`+contacts[i].idcontacto+" - "+contacts[i].nombre+" "+contacts[i].apellidos+`</option>`;
                          }
                          if (contacts.length > 0) {
                            idbusquedaContacto = contacts[0].idcontacto;
                            $('#idContact').val(idbusquedaContacto);


                            $('#DocumentosCredito').fadeOut();
                            $('#DocumentosCredito input').prop('disabled',true);

                          }else{
                            idbusquedaContacto = 'N/A';
                            $('#idContact').val(idbusquedaContacto);
                            $("#ListaClientes").append('<option class="sugerencias_vin" value=""><b>Cliente NO Encontrado</b> <b>Completa los campos marcados<b></option>');
                            $('#ListaClientes').attr('size','1');
                          }


                        }else {
                          console.log('no_ok');
                        }
                      });
                    }

                    function getZip(){
                      zip_code = document.getElementById('CodigoP').value;

                      if (zip_code.length < 5) {
                      }else if (zip_code.length > 5){
                      }else {
                        console.log(zip_code);
                        $('.LoadingCP').fadeIn();

                        fetch('{{route('zip.show','')}}/'+zip_code)
                        .then(response => response.json())
                        .catch(function(error){
                          console.error('Error: ',error);
                        })
                        .then(function(data){

                          $('.LoadingCP').fadeOut();

                          if (data) {
                            console.log(data);

                            document.getElementById("Estado").value = data.state;
                            document.getElementById("Municipio").value = data.township;

                            $('#Colonia').empty();
                            colonies = data.colony;
                            for(var i in colonies){
                              document.getElementById("Colonia").innerHTML += "<option value='"+colonies[i]+"'>"+colonies[i]+"</option>";
                            }

                          }else {
                            console.log('no_ok');
                          }
                        });
                      }
                    }

                    $(document).on('keydown paste focus mousedown', '.readonly', function (e) {
                      e.preventDefault();
                    });

                    </script>

                    <script type="text/javascript">
                    var  TipoMoneda = '{{--$provider->col2--}}';
                    $("#money option[value='"+TipoMoneda+"']").attr("selected", true);
                    $('#ocultar_moneda').fadeOut();
                    // $("#money").addClass("readonly");
                    // $(".readonly").on('keydown paste focus mousedown', function(e){
                    //   e.preventDefault();
                    // });
                    </script>


                  @endsection

                  @section('js')
                    <script type="text/javascript">
                    $(document).ready(function(){
                      var addButton = $('#add_button');
                      var wrapper = $('.field_wrapper');
                      var x = 0;

                      $(addButton).click(function(){
                        x++;
                        $(wrapper).append('<div class="row"><div class="col-sm-3 form-group"> <label for="">Caracteristaica '+x+'</label><input type="text" name="caracteristicas[]" class="form-control carac"  list="caracte" value="" required/><div class="res"></div></div> <div class="col-sm-3 form-group"> <label for="">Información '+x+'</label><input type="text" name="informacion[]" class="form-control info" value="" list="infor" required/></div> <div class="col-sm-2 form-group"> <label for="">Tipo '+x+'</label><div class="content-select"><select name="tipo_especificaciones[]" class="form-control tipo_especificaciones2 tipo_especificaciones2'+x+'" id="'+x+'" onchange="nodo_sub_especificaiones('+x+')"  required><option value="">Elija una opción...</option><option value="1">Especificaciones Tecnicas</option><option value="2">Dimensiones</option><option value="3">Equipamiento</option></select><i></i></div> </div> <div class="col-sm-3 form-group"> <label for="">Sub Tipo '+x+'</label><select name="tipo_sub_especificaciones[]" class="form-control  tipo_sub_especificaciones2'+x+'"  required><option value="">Elija una opción...</option></select></div> <a class="remove_button" title="Remove field"><i class="fas fa-times fa-2x" style="color:red;"></i></a></div>');
                        $(".numero_carac").val(x);
                        if (x == 0) {
                          $(".numero_carac").val("0");
                        }
                      });
                      $(wrapper).on('click', '.remove_button', function(e){
                        x--;
                        e.preventDefault();
                        $(this).parent('div').remove();
                        $(".numero_carac").val(x);
                      });
                    });

                    function nodo_sub_especificaiones(id){
                      var ids =id;
                      var valor =$(".tipo_especificaciones2"+ids).val();
                      $(".tipo_sub_especificaciones2"+ids).empty();

                      fetch("{{route('inventoryAdmin.getSubEspecificationsVin')}}", {
                        headers: {
                          "Content-Type": "application/json",
                          "Accept": "application/json",
                          "X-Requested-With": "XMLHttpRequest",
                          "X-CSRF-Token": '{{csrf_token()}}',
                        },
                        method: "post",
                        credentials: "same-origin",
                        body: JSON.stringify({
                          valor : valor
                        })
                      })
                      .then(res => res.json())
                      .then(function(response){
                        if (response.tiempo_restante != "" ) {
                          var NumNotificaciones = 1;
                          // $('#body-notification-password').append('<h6 class="mt-0"><strong>Tu Key Access esta por expirar, favor de renovarla.</strong></h6><p>Ver</p><small class="text-success">Tiempo Restante: '+response.tiempo_restante+' </small>');
                          $(".tipo_sub_especificaciones2"+ids).append(response.options);
                        }
                      })
                      .catch(function(error){
                        console.error('Error:', error);
                      });
                    }


                    </script>








                    <script  type="text/javascript" class="init">



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

                  @endsection
