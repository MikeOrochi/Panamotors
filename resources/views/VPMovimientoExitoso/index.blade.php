@extends('layouts.appAdmin')
@section('titulo', 'CCP | Vista Previa Movimiento Exitoso')

@section('js')


@endsection


@section('head')
  @include('partials.loader')
@endsection
<style media="screen">

.SeleccionLista{
  background: #882439 !important;
  color:white !important;
}
.content-op-busqueda:hover:before{
  width: 100%;
  opacity: 1;
}
.content-op-busqueda:hover .opcion{
  color:white !important;
}
.content-op-busqueda{
  justify-content: center;
  display: flex;
}
.content-op-busqueda:before{
  content: '';
  position: absolute;
  width: 50%;
  height: 20px;
  background: #882439 !important;
  z-index: 1;
  opacity: 0;
  transition: .5s;
}

.opcion{
  text-transform: capitalize;
  font-size: 14px;
  position: relative;
  cursor: pointer;
  z-index: 2;
  text-align: center;
}
.DivBusqueda{
  overflow-y: scroll;
  max-height: 200px;
  min-height: 200px;
  box-shadow: 0px 0px 10px rgb(136 36 57 / 50%);
  animation: animateBS 1s linear infinite alternate;
  background: #fff;
  border-radius: 20px;
  margin-top: 2px;
}
</style>
@section('content')


  <style media="screen">
  /*:hover*/


  tr > td {
    text-align: center;
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




  /* Multi Step Form --------------------------------- */
  #regForm {
    background-color: rgb(207 212 211 / 14%);
    margin: 50px auto;
    padding: 20px;
    width: 100%;
    min-width: 300px;
    border-radius: 20px;
  }

  /* Style the input fields */
  input {
    padding: 10px;
    width: 100%;
    font-size: 17px;
    font-family: Raleway;
    border: 1px solid #aaaaaa;
    border-radius: 20px !important;
  }

  /* Mark input boxes that gets an error on validation: */
  input.invalid {
    background-color: #ffdddd;
  }

  /* Hide all steps by default: */
  .tab {
    display: none;
  }

  /* Make circles that indicate the steps of the form: */
  .step {
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbbbbb;
    border: none;
    border-radius: 50%;
    display: inline-block;
    opacity: 0.8;
  }

  /* Mark the active step: */
  .step.active {
    opacity: 1;
    background-color: #36d63d;
  }

  /* Mark the steps that are finished and valid: */
  .step.finish {
    background-color: #4CAF50;
  }
  /* Multi Step Form --------------------------------- */

  /*selects*/
  option:hover{
    /*background-color: #80bdff;*/
  }

  /*------------------------ RANGE --------------------------*/
  input[type=range]:focus {
    outline: none;
  }
  input[type=range]::-webkit-slider-runnable-track {
    width: 100%;
    height: 4px;
    cursor: pointer;
    animate: 0.2s;
    background: #03a9f4;
    border-radius: 25px;
  }
  input[type=range]::-webkit-slider-thumb {
    height: 20px;
    width: 20px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 0 4px 0 rgba(0,0,0, 1);
    cursor: pointer;
    -webkit-appearance: none;
    margin-top: -8px;
  }
  input[type=range]:focus::-webkit-slider-runnable-track {
    background: #03a9f4;
  }
  .range-wrap{
    width: 500px;
    position: relative;
  }
  .range-value{
    position: absolute;
    top: -50%;
  }
  .range-value span{
    width: 30px;
    height: 24px;
    line-height: 24px;
    text-align: center;
    background: #03a9f4;
    color: #fff;
    font-size: 12px;
    display: block;
    position: absolute;
    left: 50%;
    transform: translate(-50%, 0);
    border-radius: 6px;
  }
  .range-value span:before{
    content: "";
    position: absolute;
    width: 0;
    height: 0;
    border-top: 10px solid #03a9f4;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    margin-top: -1px;
  }
  /*------------------------ RANGE --------------------------*/

  </style>



  <div class="container">
    <div class="row">
      @if (!empty(session('pdf_vpme')))
        <script type="text/javascript">
        $( document ).ready(function() {
          $('#exampleModal').modal('toggle')
        });


        </script>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Vista Previa Movimiento Exitoso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" align='center'>
                ¿Deseas visualizar el formato?<br>
                <a href="{{route('vpme.pdf.vistaPrevia',['id'=>Crypt::encrypt(session('pdf_vpme'))])}}" id='document_1' target="_blank" onclick="closeTootips();" class="btn btn-info" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Recibo de pago"><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></a>
                {{---<a href="{{route('vouchers.viewVoucherExpenses',['id'=>Crypt::encrypt(session('comprobantes_transferencia'))])}}" id='document_2' target="_blank" onclick="closeTootips();" class="btn btn-success" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Comprobante de transferencia"><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></a>--}}
              </div>
              {{-- <div class="modal-footer"> --}}
              {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
              {{-- </div> --}}
            </div>
          </div>
        </div>
        @php
        session()->forget('pdf_vpme');
        @endphp
      @endif


      <form id="regForm" action="{{route('vpMovimientoExitoso.storeNewMovement')}}" method="post" class="needs-validation" enctype="multipart/form-data">
        @csrf


        <!-- One "tab" for each step in the form: -->



        <div class="tab">

          <h1>Tipo de Cliente:</h1>

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


            <div class="row">
              <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                <label for=""><b style="color:red">*</b> Nombre:</label>
                <p class="col" style="padding: 0px 5px;"><input id="Nombre" name="nombre" class="form-control" required></p>
              </div>
              <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                <label for=""><b style="color:red">*</b> Apellidos:</label>
                <p class="col" style="padding: 0px 5px;"><input name="apellidos" class="form-control" required></p>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-12 col-sm-12" style="margin-bottom: 0px;">
                <label for=""><b style="color:red">*</b> Telefono:</label>
                <p class="col" style="padding: 0px 5px;"><input name="telefono" class="form-control" required minlength="10" maxlength="10"></p>
              </div>
            </div>

            <div class="row">

              <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                <label for="CodigoP">Codigo Postal:</label>
                <input id="CodigoP" name="cp" class="form-control" onkeyup="getZip()" minlength="5" maxlength="5">
              </div>


              <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                <label for="Estado"><b style="color:red">*</b> Estado:</label>
                <input id="Estado" name="estado" class="form-control" required>
                <i class="fas fa-spinner fa-spin LoadingCP" aria-hidden="true" style="position: absolute;left: 100px;top: 5px;display:none"></i>
              </div>

              <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                <label for="Municipio"><b style="color:red">*</b> Municipio:</label>
                <input id="Municipio" name="municipio" class="form-control" required>
                <i class="fas fa-spinner fa-spin LoadingCP" aria-hidden="true" style="position: absolute;left: 100px;top: 5px;display:none"></i>
              </div>

              <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                <label for="Colonia">Colonia:</label>
                <select class="form-control" name="colonia" style="border-radius:20px" id="Colonia" placeholder="Colonia" style="font-size: 13px;">
                </select>
                <i class="fas fa-spinner fa-spin LoadingCP" aria-hidden="true" style="position: absolute;left: 100px;top: 5px;display:none"></i>
              </div>

              <div class="form-group col-12 col-sm-6" style="margin-bottom: 0px;">
                <label for="Colonia">Calle y número:</label>
                <p style="padding: 0px 5px;"><input name="calle" class="form-control"></p>
              </div>


            </div>
          </div>

          <div style="display:none" id="BuscarClienteInputs">

            Cliente:
            <i id="LoadingClient" class="fas fa-spinner fa-spin" aria-hidden="true" style="display:none"></i>
            <div class="row">
              <p class="col-12">
                <input name="search_client" id="search_client" onkeyup="BuscarClienteTempo(this)" class="form-control" required>
              </p>
              <p class="col-12">
                <input name="cliente_seleccionado"  id="cliente_seleccionado" value="" class="form-control" required style="display:none;">

                <div class="col DivBusqueda" style="margin-left: 2%;margin-right: 2%;">
                  <div id="ListaClientes">
                  </div>
                </div>

              </p>
            </div>

          </div>
        </div>

        <div class="tab">

          <h1>Tipo de Venta:</h1>

          <div class="row" style="justify-content: center;">
            <a  class="grid-item Movil" style="display: table;"  id="SeleccionarVentaCredito" onclick="">

              <div class="inner" style="height: 100%; width:50%;display: table-cell;vertical-align: middle;">
                <span style="height: 33%;">Credito</span>
                <img src="{{secure_asset('storage/app/VPMovimientoExitoso/credito.png')}}" alt="">
              </div>

              <span style="text-align: center;height: 134px;width:50%;display: table-cell;vertical-align: middle;" class="spanOpcionesVenta">

                <div style="width:100%;margin-bottom: 5px;" class="btnPermuta BtnCredito">
                  <button type="button" class="btn btn-warning" style="padding: 2px;width: 100px;" onclick="OpcionVenta(1,this)">
                    Permuta
                  </button>
                </div>
                <!--

                <div style="width:100%;margin-bottom: 5px;margin-left: 0px;justify-content: center;" class="row">
                <div class="btnPermuta">
                <button type="button" class="btn btn-warning" style="padding: 2px;width: 100px;" onclick="OpcionVenta(2,this)">
                FAS/Sofom
              </button>
            </div>
          </div>
        -->
        <div style="width:100%;margin-bottom: 5px;" class="btnPermuta BtnCredito">
          <button type="button" class="btn btn-warning" style="padding: 2px;width: 100px;" onclick="OpcionVenta(4,this)" id="BtnCreditoPanamotors">
            Panamotors
          </button>
        </div>
      </span>
    </a>

    <a class="grid-item Movil" style="display: table;" id="SeleccionarVentaContado" onclick="">
      <div class="inner" style="height: 100%; width:50%;display: table-cell;vertical-align: middle;">
        <span style="height: 33%;">Contado</span>
        <img src="{{secure_asset('storage/app/VPMovimientoExitoso/contado.png')}}" alt="">
      </div>
      <span style="text-align: center;height: 134px;width:50%;display: table-cell;vertical-align: middle;" class="spanOpcionesVenta">
        <!--
        <div style="width:100%;margin-bottom: 5px;" class="btnPermuta">
        <button type="button" class="btn btn-warning" style="padding: 2px;width: 100px;" onclick="OpcionVenta(5,this)">
        Permuta
      </button>
    </div>
    <div style="width:100%;margin-bottom: 5px;margin-left: 0px;justify-content: center;" class="row">
    <div class="btnPermuta">
    <button type="button" class="btn btn-warning" style="padding: 2px;width: 100px;" onclick="OpcionVenta(6,this)">
    FAS/Sofom
  </button>
</div>
</div>
-->
<div style="width:100%;margin-bottom: 5px;" class="btnPermuta BtnContado">
  <button type="button" class="btn btn-warning" style="padding: 2px;width: 100px;" onclick="OpcionVenta(8,this)" id="BtnContadoPanamotors">
    Panamotors
  </button>
</div>
</span>
</a>
</div>



<div class="" id="DocumentosCredito" style="display:none">

  <div id="ReferenciasCredito">
    Referencias
    <div class="row" style="background: #f3ebeba8;border-radius: 20px;padding-top: 5px;margin-top: 10px;">
      <p class="col-12 col-sm-4" style="padding: 0px 5px;"><input name="nombre_ref_1" placeholder="Nombre(s)" class="form-control" required></p>
      <p class="col-12 col-sm-4" style="padding: 0px 5px;"><input name="apellidos_ref_1" placeholder="Apellidos" class="form-control" required></p>
      <p class="col-12 col-sm-4" style="padding: 0px 5px;"><input name="tel_ref_1" placeholder="Telefono" class="form-control" required minlength="10" maxlength="10"></p>
    </div>
    <div class="row" style="background: #f3ebeba8;border-radius: 20px;padding-top: 5px;margin-top: 10px;">
      <p class="col-12 col-sm-4" style="padding: 0px 5px;"><input name="nombre_ref_2" placeholder="Nombre(s)" class="form-control" required></p>
      <p class="col-12 col-sm-4" style="padding: 0px 5px;"><input name="apellidos_ref_2" placeholder="Apellidos" class="form-control" required></p>
      <p class="col-12 col-sm-4" style="padding: 0px 5px;"><input name="tel_ref_2" placeholder="Telefono" class="form-control" required minlength="10" maxlength="10"></p>
    </div>


    <div id="Referencias">
    </div>

    <input type="hidden" name="NumReferencias" value="2" class="form-control" id="NumReferencias">

  </div>
  <div class="row" style="text-align:right;">
    <div class="col-12 col-md-12" style="padding-bottom: 15px;">
      <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Eliminar Referencia" style="border-radius: 10px;display:none;" onclick="EliminarReferencia()" id="BtnEliminarRef">
        <i class="fas fa-minus"></i>
      </button>
      <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Agregar Referencia" style="border-radius: 10px" onclick="AgregarReferencia()" id="BtnAgregarRef">
        <i class="fas fa-plus"></i>
      </button>
    </div>
  </div>
</div>

<div class="" id="DocumentosFAS_SOFON" style="display:none;">
  <div class="col-md-6 offset-md-3" style="">
    <label for="comprobante_archivo_Contado">Carta de autorizacion:</label>
    <input type="file" name="uploadedfile_Contado" id="comprobante_archivo_Contado" class="form-control"  accept="image/*, .pdf" required disabled>
  </div>
</div>

<div class="" id="DatosPermuta" style="display:none">
  <div class="row">
    <div class="col-sm-3">
      <label for="busqueda_vin_Permuta">VIN - Vehiculo permuta</label>
      <input name="busqueda_vin" placeholder="Buscar" class="form-control" type="text" name="busqueda_vin" id="busqueda_vin_Permuta" minlength="2" maxlength="25" autocomplete="off" onkeyup="buscar_vin_bloqueado_Permuta();" size="19" width="300%" required disabled>
      <i id="LoadingBusquedaVIN_Permuta" class="fas fa-spinner fa-spin" aria-hidden="true" style="position: absolute;right: 23px;top: 9px;display:none"></i>
    </div>
    <div class="col-sm-9" style="padding-top: 5px;padding-bottom:10px;">
      <label for="resultadoBusquedaVin_Permuta">Vehiculo</label>
      <select class="form-control" style="border-radius:20px;font-family: 'FontAwesome';" id="resultadoBusquedaVin_Permuta" name="resultadoBusquedaVin_Permuta" required="" onchange="SeleccionPermuta(this)" disabled>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-3">
      <label for="MontoVehiculoCompra">Monto del Vehiculo </label>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
        </div>
        <input class="form-control" type="text" id="MontoVehiculoCompra" name="MontoVehiculoCompra" style="border-radius: 0px !important;" onchange="LetrasMontoPermuta()">
        <div class="input-group-prepend">
          <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;border-radius: 0px 5px 5px 0px">
            MXN
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-9">
      <div class="form-group">
        <label>Precio Letra</label>
        <input type="text" class="form-control" id="LetrasMontoPermutaInput" readonly="" value="" style="text-align:center;">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label>Marca</label>
        <input class="form-control Capitalizar" type="text" id="MarcaPermuta"  value="" autocomplete="off"  maxlength="30">
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Modelo</label>
        <input class="form-control Capitalizar" type="text" id="ModeloPermuta"  value="" autocomplete="off"  maxlength="30">
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Version</label>
        <input class="form-control Capitalizar" type="text" id="VersionPermuta"  value="" autocomplete="off"  maxlength="30">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label>Color</label>
        <input class="form-control Capitalizar" type="text" id="ColorPermuta"  value="" autocomplete="off"  maxlength="30">
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label>Tipo</label>
        <input class="form-control Capitalizar" type="text" id="TipoPermuta" value="" autocomplete="off"  maxlength="30">
      </div>
    </div>
  </div>
</div>

<input name="tipoVenta" id="tipoVenta" class="form-control" required style="display:none">
<input name="tipoVentaPlus" id="tipoVentaPlus" class="form-control" style="display:none">


</div>

<div class="tab">
  <div class="row" id="CampoBusquedaVIN">
    <label>
      Buscar VIN
      <i id="LoadingBusquedaVIN" class="fas fa-spinner fa-spin" aria-hidden="true" style="display:none"></i>
    </label>
    <div class="col-sm-12">
      <input name="busqueda_vin" placeholder="Buscar" class="form-control" type="text" name="busqueda_vin" id="busqueda_vin" value="{{old('busqueda_vin')}}" maxlength="25" autocomplete="off" onkeyup="buscar_vin_bloqueado();" size="19" width="300%" required>
    </div>
    <div class="col-sm-12" style="padding-top: 5px;padding-bottom:10px;">

      <div class="col DivBusqueda">
        <div id="resultadoBusquedaVin_X"></div>
      </div>

    </div>
  </div>
  <div class="row">

    <div class="col-md-6 offset-md-3" style="text-align: center;display:none" id="DivPrecioSinDescuento">
      <label for="MontoSinDescuento">Precio Digital</label>
      <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
        </div>
        <input type="text" class="form-control readonly" id="MontoSinDescuento" name="MontoSinDescuento" placeholder="$0.00" required="" maxlength="10" style="border-radius: 0px !important;">
        <div class="input-group-prepend">
          <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">MXN</div>
        </div>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" id="MontoSinDescuentoLetra" readonly="" value="" style="text-align:center;">
      </div>
    </div>


  </div>
  <div class="row" id="BotonesMostrarDescuento" style="display:none">
    <div class="col-md-6 offset-md-3" style="text-align: center;">
      <div class="row">
        <div class="col-6">
          <button type="button" class="btn btn-warning" onclick="MostrarDivDescuento()"><i class="far fa-edit"></i> Modificar precio</button>
        </div>
        <div class="col-6">
          <button type="button" class="btn btn-success" onclick="nextPrev(1)"> Continuar <i class="far fa-check-circle"></i></button>
        </div>
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
        <input type="number" class="form-control" id="MontoConDescuento" name="MontoConDescuento" placeholder="$0.00" required=""  style="border-radius: 0px !important;" step="0.01" onchange="EstablecerPrecioCompra(this)" onkeyup="ValidarMonto(this)">
        <div class="input-group-prepend">
          <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">MXN</div>
        </div>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" id="MontoConDescuentoLetra" readonly="" value="" style="text-align:center;">
      </div>
    </div>


  </div>
</div>

<div class="tab">

  <div class="" id="DivCredito">
    @include('VPMovimientoExitoso.partials.type_purchase_form2')
  </div>

</div>

<div class="tab">
  <h3>Responsables de venta</h3>

  <div class="row">
    <div class="col-sm-6">
      <label for="Asesor_uno">* 1.- Asesor:</label>
      <select class="js-example-basic-single form-control" id="Asesor_uno" required name="Asesor_uno" style="border-radius:20px;width:100%;">
        <option value="">Elige una opción…</option>
        @foreach ($Asesores as $key => $ase)
          <option value="{{$ase->idempleados}}">
            {{$ase->columna_b ." - ".$ase->nombre.' '.$ase->apellido_paterno.' '.$ase->apellido_materno}}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-sm-6">
      <label for="Asesor_dos">* 2.- Asesor:</label>
      <select class="js-example-basic-single form-control" id="Asesor_dos" required name="Asesor_dos" style="border-radius:20px;width:100%;">
        <option value="">Elige una opción…</option>
        <option value="N/A" selected>No Aplica</option>
        @foreach ($Asesores as $key => $ase)
          <option value="{{$ase->idempleados}}">
            {{$ase->columna_b ." - ".$ase->nombre.' '.$ase->apellido_paterno.' '.$ase->apellido_materno}}
          </option>
        @endforeach
      </select>
    </div>

  </div>

  <div class="row" style="margin-top: 10px; margin-bottom:10px;">

    <div class="col-sm-6">
      <label for="Enlace_uno">* Enlace:</label>
      <select class="js-example-basic-single form-control" id="Enlace_uno" required name="Enlace_uno" style="border-radius:20px;width:100%;">
        <option value="">Elige una opción…</option>
        <option value="N/A" selected>No Aplica</option>
        @foreach ($Asesores as $key => $ase)
          <option value="{{$ase->idempleados}}">
            {{$ase->columna_b ." - ".$ase->nombre.' '.$ase->apellido_paterno.' '.$ase->apellido_materno}}
          </option>
        @endforeach
      </select>
    </div>

    {{--<div class="col-sm-6">
    <label for="Enlace_dos">* 2.- Enlace:</label>
    <select class="form-control" style="border-radius:20px" id="Enlace_dos" style="font-size: 13px;" required name="Enlace_dos">
    <option value="">Elige una opción…</option>
    <option value="N/A">No Aplica</option>
    @foreach ($Asesores as $key => $ase)
    <option value="{{$ase->idempleados}}">
    {{$ase->columna_b ." - ".$ase->nombre.' '.$ase->apellido_paterno.' '.$ase->apellido_materno}}
  </option>
@endforeach
</select>
</div>--}}
</div>

</div>

<div class="tab">
  <div class="text-center">
    <div style="height: 150px;">
      <div class="loaderT" style="position: relative;">
        <div class="innerLoading one"></div>
        <div class="innerLoading two"></div>
        <div class="innerLoading three"></div>
      </div>
    </div>
  </div>
</div>


<div style="overflow:auto;margin-top: 15px;">
  <div style="float:right;">
    <button class="btn btn-outline-info" type="button" id="prevBtn" onclick="nextPrev(-1)">Regresar</button>
    <button class="btn btn-success" type="button" id="nextBtn" onclick="nextPrev(1)">Siguiente</button>
  </div>
</div>

<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px;">
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
  <span class="step"></span>
</div>

<button type="submit" name="button" style="display:none">Guardar</button>
</form>

</div>
</div>






<div class="modal fade" id="ModalDescuento" tabindex="-1" role="dialog" aria-labelledby="ModalDescuentoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDescuentoLabel">Solicitud de descuento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div id="LoadingDescuentos" style="display:none;">
          <div class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </div>
        <div id="DivMisDescuentos" style="display:none;">
        </div>
        <div style="display:none" id="DivPeticionDescuento">
          <div class="form-group">
            <label>Precio Piso</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
              </div>
              <input class="form-control" type="text" id="PrecioPisoDescuento" autocomplete="off"  onkeypress="return SoloNumeros(event);" required="" maxlength="9" style="border-radius: 0px !important;" readonly>
            </div>
          </div>
          <div class="form-group">
            <label for="RangeDescuentoSolicitado">
              <p id="PorcentajeDecuento"></p>
            </label>
            <input type="range" class="custom-range" id="RangeDescuentoSolicitado" name="descuento_solicitado" min="11" max="100" value="11" oninput="CalcularDescuento(this)">
          </div>

          <div class="form-group">
            <label>Precio Piso Final</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
              </div>
              <input class="form-control" type="text" id="PrecioFinalDescuento" autocomplete="off" required="" style="border-radius: 0px !important;" readonly>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="SolicitarDescuento()">Solicitar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">


function MostrarInputNU(t){

  idbusquedaContacto = 'N/A';
  $('#idContact').val(idbusquedaContacto);

  $('#BuscarClienteInputs').fadeOut();
  $('#BuscarClienteInputs .form-control').prop('disabled',true);

  $('#NuevoCliente').fadeIn();
  $('#NuevoCliente .form-control').prop('disabled',false);

  document.getElementById('ClienteCartera_S').classList.remove('seleccion');
  document.getElementById('ClienteNuevo_S').classList.remove('grises');
  document.getElementById('Nombre').focus();

  t.classList.add('seleccion');


  document.getElementById('ClienteCartera_S').classList.add('grises');
}

function BuscarCliente(t){

  $('#ListaClientes').empty();
  $('#search_client').val('');
  $('#cliente_seleccionado').val('');

  $('#NuevoCliente').fadeOut();
  $('#NuevoCliente .form-control').prop('disabled',true);

  $('#BuscarClienteInputs').fadeIn();
  $('#BuscarClienteInputs .form-control').prop('disabled',false);

  document.getElementById('ClienteNuevo_S').classList.remove('seleccion');
  document.getElementById('ClienteCartera_S').classList.remove('grises');
  document.getElementById('search_client').focus();


  t.classList.add('seleccion');

  document.getElementById('ClienteNuevo_S').classList.add('grises');
}




var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:

  if (currentTab == 2) {
    document.getElementById('busqueda_vin').focus();
  }

  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Guardar";
  } else {
    document.getElementById("nextBtn").innerHTML = "Siguiente";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;

  if(currentTab == 2){

    $('#ModificarPrecio').fadeOut();
    var Busqueda = $('#resultadoBusquedaVin_X').html();
    if (Busqueda != "") {
      $('#BotonesMostrarDescuento').fadeIn();
    }

    $('#prevBtn').fadeOut();
    $('#nextBtn').fadeOut();

  }else if (currentTab == 3) {
    MontoPagares();
    buscar_letras("saldo_nuevo_venta", "letra");
    buscar_letras("MontoConDescuento", "letra");
    $('#prevBtn').fadeIn();
    $('#nextBtn').fadeIn();
    BuscarImagen();
  }

  showTab(currentTab);
  // if you have reached the end of the form... :
  if (currentTab == (x.length-1)) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }

}


function BuscarImagen(){

  $('#img-header-unidad').html(`<img src="{{secure_asset('public/img/404llanta.webp')}}" alt="" style="height: 100px;animation: animatellanta 1s linear infinite;">`);

  fetch("{{route('VPMovimientoExitoso.BuscarImagen')}}", {
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-Token": '{{csrf_token()}}',
    },
    method: "post",
    credentials: "same-origin",
    body: JSON.stringify({
      vin : $("#vin_venta").val()
    })
  }).then(res => res.json())
  .catch(function(error){
    console.error('Error:', error)
    iziToast.error({
      title: 'Error',
      message: 'Error al obtener imagen',
    });
    $('#img-header-unidad').html("<img alt='image' height='150' class='rounded-circle' src='https://www.panamotorscenter.com/Des/CCP/Fotos_Inventario/fondoblanco_actual.jpg' alt=''>");
  })
  .then(function(img){

    if(img != "" && img != null){
      $('#img-header-unidad').html("<img alt='image' width='350' class='rounded-circle' src="+img+" alt=''>");
    }else {
      $('#img-header-unidad').html("<img alt='image' height='150' class='rounded-circle' src='https://www.panamotorscenter.com/Des/CCP/Fotos_Inventario/fondoblanco_actual.jpg' alt=''>");
    }

  });
}

function validateForm() {

  var CamposInvalidos = $(document.getElementsByClassName("tab")[currentTab]).find('.form-control:invalid').length;

  if (CamposInvalidos == 0) {
    return true;
  }else{
    $(document.getElementsByClassName("tab")[currentTab]).find('.form-control:invalid').first()[0].reportValidity();
    iziToast.info({
      title: 'Revisa los campos de tu fromulario',
    });
    return false;
  }

}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

function SolicitarDescuento(){

  var Desc = $('#RangeDescuentoSolicitado').val();
  var Final = $('#PrecioFinalDescuento').val();

  swal({
    title: "Estas seguto?",
    text: "Aplicar descuento del "+Desc+"% resultando en  $"+Final,
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {

      fetch("{{route('VPMovimientoExitoso.solicitudDescuento')}}", {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-Token": '{{csrf_token()}}',
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
          descuento : Desc,
          vin : $('#vin_venta').val(),
          tipo : $('#tipo_unidad').val(),
          id : idBusquedaInventario,
        })
      }).then(res => res.json())
      .catch(function(error){
        console.error('Error:', error)
        swal({
          title: "Error",
          text: error,
          icon: "error",
        });
      })
      .then(function(response){
        console.log(response);

        if (response == 'Ok') {
          swal("Solicitud realizada", {
            icon: "success",
          });
        }else{
          swal({
            title: "Ocurrio un error",
            icon: "error",
          });
        }

      });
    }
  });
}

function VerMisDescuentos(){

  $('#LoadingDescuentos').fadeIn();
  $('#DivPeticionDescuento').fadeOut();
  $('#DivMisDescuentos').fadeOut();



  fetch("{{route('VPMovimientoExitoso.misDescuentos')}}", {
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-Token": '{{csrf_token()}}',
    },
    method: "post",
    credentials: "same-origin",
    body: JSON.stringify({
      vin : $('#vin_venta').val()
    })
  }).then(res => res.json())
  .catch(function(error){
    console.error('Error:', error)
    $('#LoadingDescuentos').fadeOut();
  })
  .then(function(response){
    $('#LoadingDescuentos').fadeOut();
    console.log(response);
    if (response.length == 0) {
      $('#DivPeticionDescuento').fadeIn();
    }else{

      $('#DivMisDescuentos').fadeIn();
      $('#DivMisDescuentos').html(`
        <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table">
        <thead>
        <tr>
        <th>Precio</th>
        <th>%</th>
        <th>Precio Final</th>
        <th>Estatus</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <td>`+response.precio+`</td>
        <td>`+response.descuento+`</td>
        <td>`+response.precioFinal+`</td>
        <td>`+response.status+`</td>
        </tr>
        </tbody>
        </table>
        `);
      }

    });
  }

  function ModificarDescuento(Descuento){
    $('#RangeDescuento').attr('max',Descuento);
    $('#RangeDescuento').val(Descuento);
    CalculoDescuento(document.getElementById('RangeDescuento'));
  }

  var contacts = null;

  var Temporizador_Cliente;
  var BuscandoCliente = false;
  var BusquedaClienteTexto = null;

  function BuscarClienteTempo(input) {

    var Busq = input.value.trim();


    if (Busq == "") {
      BusquedaClienteTexto = null;
      $('#ListaClientes').empty();
      idbusquedaContacto = null;
      $('#idContact').val('');
      $('#cliente_seleccionado').val('');
    }else if (BusquedaClienteTexto != Busq) {
      BusquedaClienteTexto = Busq;

      if (!BuscandoCliente) {
        $('#ListaClientes').html(`
          <div style="height: 100px;">
          <div class="loaderT">
          <div class="innerLoading one"></div>
          <div class="innerLoading two"></div>
          <div class="innerLoading three"></div>
          </div>
          </div>`
        );
        BuscandoCliente = true;
      }


      clearTimeout(Temporizador_Cliente);
      Temporizador_Cliente = setTimeout(function() {
        SearchClient(input);
      }, 350);

    }
  }

  function SearchClient(input){
    $('#LoadingClient').fadeIn();


    fetch('{{route('provider.search','')}}/'+input.value)
    .then(response => response.json())
    .catch(function(error){
      console.error('Error: ',error);
      validate_search = 0;
      idbusquedaContacto = idbusquedaContacto;
      $('#LoadingClient').fadeOut();
      BuscandoCliente = false;
    })
    .then(function(data){
      validate_search = 0;
      BuscandoCliente = false;
      $('#LoadingClient').fadeOut();
      if (data) {

        contacts = data.contacts;

        $('#ListaClientes').empty();
        for(var i in contacts){
          document.getElementById("ListaClientes").innerHTML +=
          `<div class="content-op-busqueda" onclick="ClienteSeleccionado(`+contacts[i].idcontacto+`,this)">
          <p class="opcion">`+contacts[i].idcontacto+" - "+contacts[i].nombre+" "+contacts[i].apellidos+`</p>
          </div>
          `;
        }
        if (contacts.length > 0) {
          idbusquedaContacto = contacts[0].idcontacto;
          $('#idContact').val(idbusquedaContacto);


          $('#DocumentosCredito').fadeOut();
          $('#DocumentosCredito input').prop('disabled',true);

        }else{
          idbusquedaContacto = 'N/A';
          $('#idContact').val(idbusquedaContacto);
          $("#ListaClientes").append(
            `<div class="content-op-busqueda">
            <p class="opcion" value="null"><b>Cliente NO Encontrado</b> <b>Completa los campos marcados</p>
            </div>`);
          }


        }else {
          console.log('no_ok');
        }
      });
    }

    function VentaCredito(){

      if (idbusquedaContacto != 'N/A') {
        //$('#DocumentosCredito').fadeOut();
        //$('#DocumentosCredito input').prop('disabled',true);

        var Contacto = contacts.find(element => element.idcontacto == idbusquedaContacto);

        if (Contacto.referencia_nombre == "" || Contacto.referencia_nombre2 == "") {
          $('#DocumentosCredito').fadeIn();
          $('#DocumentosCredito input').prop('disabled',false);

          iziToast.warning({
            title: 'Atencion',
            message: 'El contacto no tiene todas las referencias registradas',
            timeout : 6000
          });


          document.getElementsByName('nombre_ref_1')[0].value = Contacto.referencia_nombre;
          document.getElementsByName('nombre_ref_2')[0].value = Contacto.referencia_nombre2;
          //document.getElementsByName('nombre_ref_3')[0].value = Contacto.referencia_nombre3;

          document.getElementsByName('tel_ref_1')[0].value = Contacto.referencia_celular;
          document.getElementsByName('tel_ref_2')[0].value = Contacto.referencia_celular2;

          if (Contacto.referencia_nombre != "" && Contacto.referencia_celular != "") {
            $('#ReferenciasCredito .row:first').find('.form-control').prop('disabled',true);
          }
          if (Contacto.referencia_nombre2 != "" && Contacto.referencia_celular2 != "") {
            $('#ReferenciasCredito .row').eq(1).find('.form-control').prop('disabled',false);
          }


          //document.getElementsByName('tel_ref_3')[0].value = Contacto.referencia_celular3;
        }

      }else{
        $('#DocumentosCredito').fadeIn();
        $('#DocumentosCredito input').prop('disabled',false);
      }


      document.getElementById('tipoVenta').value = 'Directa a Crédito';
      document.getElementById('SeleccionarVentaCredito').classList.remove('grises');
      document.getElementById('SeleccionarVentaCredito').classList.add('seleccion');

      document.getElementById('SeleccionarVentaContado').classList.add('grises');
      document.getElementById('SeleccionarVentaContado').classList.remove('seleccion');

      $('#RangePagares').attr('min',1);
      document.getElementById('RangePagares').value = 1;
      GenerarPagares(document.getElementById('RangePagares'));

      $('#Pagares').parent().fadeIn();

      $('#metodo_pago').prop('disabled',true);
      $('#DivMetodosPago').fadeOut();
    }

    function VentaContado(){

      $('#DocumentosCredito').fadeOut();
      $('#DocumentosCredito input').prop('disabled',true);


      document.getElementById('tipoVenta').value = 'Directa de Contado';
      document.getElementById('SeleccionarVentaContado').classList.remove('grises');
      document.getElementById('SeleccionarVentaContado').classList.add('seleccion');

      document.getElementById('SeleccionarVentaCredito').classList.add('grises');
      document.getElementById('SeleccionarVentaCredito').classList.remove('seleccion');

      $('#RangePagares').attr('min',0);
      document.getElementById('RangePagares').value = 0;
      GenerarPagares(document.getElementById('RangePagares'));

      $('#Pagares').parent().fadeOut();

      $('#metodo_pago').prop('disabled',false);
      $('#DivMetodosPago').fadeIn();
    }

    function ClienteSeleccionado(selectC,div){
      $('.Seleccion_Cliente').removeClass('SeleccionLista');
      $(div).addClass('SeleccionLista Seleccion_Cliente');
      idbusquedaContacto = selectC;
      $('#idContact').val(selectC);
      $('#cliente_seleccionado').val(selectC);
    }

    var ReferenciasExtra = 2;
    function AgregarReferencia(){
      ReferenciasExtra++;
      $('#Referencias').append(`
        <div class="row" style="background: #f3ebeba8;border-radius: 20px;padding-top: 5px;margin-top: 10px;">
        <p class="col-12 col-sm-4" style="padding: 0px 5px;"><input name="nombre_ref_`+(ReferenciasExtra)+`" placeholder="Nombre(s)" class="form-control" required minlength="10" maxlength="10"></p>
        <p class="col-12 col-sm-4" style="padding: 0px 5px;"><input name="apellidos_ref_`+(ReferenciasExtra)+`" placeholder="Apellidos" class="form-control" required minlength="10" maxlength="10"></p>
        <p class="col-12 col-sm-4"" style="padding: 0px 5px;"><input name="tel_ref_`+(ReferenciasExtra)+`" placeholder="Telefono" class="form-control" required minlength="10" maxlength="10"></p>
        </div>
        `);
        if (ReferenciasExtra == 3) {
          $('#BtnEliminarRef').fadeIn(function(){
            $('#BtnAgregarRef').fadeOut();
          });
        }
        $('#NumReferencias').val(ReferenciasExtra);
      }

      function EliminarReferencia(){
        ReferenciasExtra--;
        $('#Referencias').children().last().remove();

        if (ReferenciasExtra == 2) {
          $('#BtnEliminarRef').fadeOut(function(){
            $('#BtnAgregarRef').fadeIn();
          });
        }

        $('#NumReferencias').val(ReferenciasExtra);
      }

      function CalcularDescuento(input){
        var PorcentajeD = input.value;
        var Total = parseFloat($('#PrecioPisoDescuento').val());
        var Descuento = (Total/100)*PorcentajeD;
        $('#PorcentajeDecuento').html('Descuento Solicitado: '+PorcentajeD+'%');
        $('#PrecioFinalDescuento').val(Total-Descuento);
      }


      var TipoContadoActivo = 0;
      var TipoCreditoActivo = 0;
      var PermutaActiva = 0;

      function OpcionVenta(tipo,btn){

        if (btn.parentElement.classList.contains('btnPermutaSeleccion')) {

          if (tipo == 1 || tipo == 5) {
            $('#DatosPermuta').fadeOut();
            $('#DatosPermuta .form-control').prop('disabled',true);
            PermutaActiva = 0;

          }else if (tipo == 2 || tipo == 3 || tipo == 6 || tipo == 7){
            $('#DocumentosFAS_SOFON').fadeOut();
            $('#DocumentosFAS_SOFON .form-control').prop('disabled',true);
          }
          btn.parentElement.classList.remove('btnPermutaSeleccion');

          if (tipo >= 1 && tipo <= 4) {
            TipoCreditoActivo--;
          }else if(tipo >= 5){
            TipoContadoActivo--;
          }
          if (TipoContadoActivo == 0 || TipoCreditoActivo == 0) {
            $('#tipoVenta').val('');
            $('#tipoVentaPlus').val('');
          }
          console.log(tipo,'  Contado -> ',TipoContadoActivo,'  Credito -> ',TipoCreditoActivo);

        }else{


          btn.parentElement.classList.add('btnPermutaSeleccion');

          if (tipo >= 1 && tipo <= 4) {
            $('.BtnContado').removeClass('btnPermutaSeleccion');
            VentaCredito();
            TipoCreditoActivo++;
            if (PermutaActiva == 5) {
              $('#DatosPermuta').fadeOut();
              $('#DatosPermuta .form-control').prop('disabled',true);
            }
          }else if(tipo >= 5){
            $('.BtnCredito').removeClass('btnPermutaSeleccion');
            VentaContado();
            TipoContadoActivo++;
            if (PermutaActiva == 1) {
              $('#DatosPermuta').fadeOut();
              $('#DatosPermuta .form-control').prop('disabled',true);
            }
          }




          console.log(tipo,'  Contado -> ',TipoContadoActivo,'  Credito -> ',TipoCreditoActivo);

          if (tipo == 1 || tipo == 5) {
            $('#DatosPermuta').fadeIn();
            $('#DatosPermuta .form-control').prop('disabled',false);
            $('#tipoVentaPlus').val('Permuta');
            PermutaActiva = tipo;
          }else if (tipo == 2 || tipo == 3 || tipo == 6 || tipo == 7){
            $('#DocumentosFAS_SOFON').fadeIn();
            $('#DocumentosFAS_SOFON .form-control').prop('disabled',false);
            $('#tipoVentaPlus').val('Permuta');
            if (tipo == 2 || tipo == 6) {
              $('#tipoVentaPlus').val('FAS');
            }else{
              $('#tipoVentaPlus').val('Sofom');
            }
          }else{
            $('#DocumentosFAS_SOFON').fadeOut();
            $('#DocumentosFAS_SOFON .form-control').prop('disabled',true);
          }






        }


      }


      function getZip(){
        zip_code = document.getElementById('CodigoP').value;

        if (zip_code.length < 5) {

          /*div_state.style.display = "none";
          div_township.style.display = "none";
          div_colony.style.display = "none";
          div_other_colony.style.display = "none";
          div_street.style.display = "none";*/

        }else if (zip_code.length > 5){
          /*div_state.style.display = "none";
          div_township.style.display = "none";
          div_colony.style.display = "none";
          div_other_colony.style.display = "none";
          div_street.style.display = "none";
          error_zip.style.display = "block";*/
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
              /*document.getElementById("state_hid").value = data.state;
              document.getElementById("township_hid").value = data.township;
              */
              $('#Colonia').empty();
              colonies = data.colony;
              for(var i in colonies){
                document.getElementById("Colonia").innerHTML += "<option value='"+colonies[i]+"'>"+colonies[i]+"</option>";
              }

              /*
              var div_state = document.getElementById("div_state");
              var div_township = document.getElementById("div_township");
              var div_colony = document.getElementById("div_colony");
              var div_other_colony = document.getElementById("div_other_colony");
              var div_street = document.getElementById("div_street");
              var error_zip = document.getElementById("error_zip");
              div_state.style.display = "block";
              div_township.style.display = "block";
              div_colony.style.display = "block";
              div_other_colony.style.display = "block";
              div_street.style.display = "block";
              error_zip.style.display = "none";
              */
            }else {
              console.log('no_ok');
              /*var error_zip = document.getElementById("error_zip");
              var div_state = document.getElementById("div_state");
              var township = document.getElementById("div_township");
              var div_colony = document.getElementById("div_colony");
              var div_other_colony = document.getElementById("div_other_colony");
              var div_street = document.getElementById("div_street");
              var error_zip = document.getElementById("error_zip");
              div_state.style.display = "none";
              township.style.display = "none";
              div_colony.style.display = "none";
              div_other_colony.style.display = "none";
              div_street.style.display = "none";
              error_zip.style.display = "block";
              */
            }
          });
        }
      }

      function MostrarDivDescuento(){
        $('#BotonesMostrarDescuento').fadeOut(function(){
          $('#ModificarPrecio').fadeIn();
          $('#prevBtn').fadeIn();
          $('#nextBtn').fadeIn();
          document.getElementById('MontoConDescuento').focus();
        });
      }

      function EstablecerPrecioCompra(Inp){
        $('#saldo_nuevo_venta').val(Inp.value);
        $('#monto_abono_venta').val(Inp.value);
        $('#PrecioPisoDescuento').val(Inp.value);
        $('#td-precio-digital').html(Inp.value);

        buscar_letras("MontoConDescuento", "MontoConDescuentoLetra");
      }

      function ValidarMonto(Monto){
        if(parseFloat(Monto.value) <  parseFloat(Monto.min)){
          Monto.classList.remove('is-valid');
          Monto.classList.add('is-invalid');
          Monto.reportValidity();
        }else{
          Monto.classList.remove('is-invalid');
          Monto.classList.add('is-valid');
        }
      }

      function LetrasMontoPermuta(){
        buscar_letras("MontoVehiculoCompra", "LetrasMontoPermutaInput");
      }

      function SeleccionPermuta(S){


        var Datos = S.value.split('~*~');

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

        $('#MarcaPermuta').val(unidad_marca);
        $('#ModeloPermuta').val(unidad_modelo);
        $('#VersionPermuta').val(unidad_version);
        $('#ColorPermuta').val(unidad_color);
        $('#TipoPermuta').val(tipo);


      }


      </script>

    @endsection
