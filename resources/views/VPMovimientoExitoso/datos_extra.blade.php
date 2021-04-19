@extends('layouts.appAdmin')
@section('titulo', 'Editar Vista Previa de Movimiento Exitoso')
@php
use App\Http\Controllers\GlobalFunctionsController;
@endphp
@section('content')
  <style media="screen">
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

  .readonly{
    background: #e9ecef;
    cursor: default;
  }

  </style>

  {{--@include('admin.partials.providers.js_edit_general')--}}

  <div class="">

    <div style="text-align:center">
      <h3>
        <b>Datos extra</b>
      </h3>
    </div>

    <form id="venta" name="venta" enctype="multipart/form-data" method="post" action="{{route('vpMovimientoExitoso.GuardarDatos')}}" class="needs-validation confirmation">
      @csrf

      <input type="hidden" name="idVistaPrevia" value="{{$VistaPrevia->id}}" value="{{old('idVistaPrevia')}}">

      <div class="row" style="margin-bottom:15px;">



        <div class="col-sm-6">
          <label for="INE"><b style="color:red;padding-right: 10px;">*</b>Identificacion con la que se identifico y número de la misma</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false" style="padding-bottom: 3px;" id="BotonIdentificacion">{{old('TipoIdentificacion') != "" ? old('TipoIdentificacion'):($InfoExtra ? $InfoExtra->identificacion:'INE')}}</button>
              <input type="" name="TipoIdentificacion" id="Identificacion" required style="display:none;"
              value="{{old('TipoIdentificacion') != "" ? old('TipoIdentificacion'):($InfoExtra ? $InfoExtra->identificacion:'INE')}}">
              <div class="dropdown-menu">
                <a class="dropdown-item" onclick="Identificacion('INE')">INE</a>
                <a class="dropdown-item" onclick="Identificacion('Pasaporte')">Pasaporte</a>
                <a class="dropdown-item" onclick="Identificacion('Licencia de conducir')">Licencia de conducir</a>
              </div>
            </div>
            <input type="text" class="form-control" placeholder="#" maxlength="20" required name="NumeroIdentificacion"
            value="{{old('NumeroIdentificacion') != "" ? old('NumeroIdentificacion'):($InfoExtra ? $InfoExtra->folio_identificacion:'')}}">
          </div>
        </div>
        <div class="col-sm-6">
          <label for="CURP"><b style="color:red;padding-right: 10px;">*</b>CURP</label>
          <input type="text" name="CURP" id="CURP" class="form-control" maxlength="18" minlength="18"required onkeyup="RevisarCURP(this)"
          value="{{old('CURP') != "" ? old('CURP'):($InfoExtra ? $InfoExtra->curp:'')}}">
        </div>
      </div>

      <div class="row" style="margin-bottom:15px;">
        <div class="col-sm-6">
          <label for="RFC"><b style="color:red;padding-right: 10px;">*</b> <b>RFC</b>

            <div class="col" style="display:inline">
              (Desea Facturar
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="Facturar" id="inlineRadio1" value="SI" {{($InfoExtra ? ($InfoExtra->facturacion == "SI" ? 'checked':''):'')}}>
                <label class="form-check-label" for="inlineRadio1">SI</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="Facturar" id="inlineRadio2" value="NO" {{($InfoExtra ? ($InfoExtra->facturacion == "SI" ? '':'checked'):'checked')}}>
                <label class="form-check-label" for="inlineRadio2">NO</label>
              </div>
              )
            </div>

          </label>
          <input type="text" name="RFC" id="RFC" class="form-control" maxlength="13" minlength="13" required
          value="{{old('RFC') != "" ? old('RFC'):($InfoExtra ? $InfoExtra->rfc:'')}}">
        </div>
        <div class="col-sm-6">
          <label for="Ocupacion"><b style="color:red;padding-right: 10px;">*</b>Ocupación o giro</label>
          <input type="text" name="Ocupacion" id="Ocupacion" class="form-control"  required value="{{old('Ocupacion') != "" ? old('Ocupacion'):($InfoExtra ? $InfoExtra->ocupacion:'')}}">
        </div>
      </div>


      <div class="row" style="margin-bottom:15px;">
        <div class="col-sm-6">
          @if ($VistaPrevia->tipo_unidad == "Trucks")
            <label for="numMotor"><b style="color:red;padding-right: 10px;">*</b>Número de Motor</label>
            <input type="text" name="numMotor" id="numMotor" class="form-control" required
            value="{{old('numMotor') != "" ? old('numMotor'):($VistaPrevia ? $VistaPrevia->numero_motor:'')}}">
          @else
            <label for="numMotor"><b style="color:red;padding-right: 10px;">*</b>Número de Motor</label>
            <input type="text" name="numMotor" id="numMotor" class="form-control" value="N/A" readonly>
          @endif
        </div>


        <div class="col-sm-6">
          <label for="FechaNacimiento"><b style="color:red;padding-right: 10px;">*</b>Fecha de Nacimiento</label>
          <input type="date" name="FechaNacimiento" id="FechaNacimiento" class="form-control" required
          value="{{old('FechaNacimiento') != "" ? old('FechaNacimiento'):($InfoExtra ? $InfoExtra->fecha_nacimiento:'')}}">
        </div>
      </div>

      <div class="row" style="margin-bottom:15px;">
        <div class="col-sm-6">
          <label for="Telefono">Telefono</label>
          <div class="input-group mb-2">
            <input type="tel" name="Telefono" id="Telefono" class="form-control" maxlength="10" minlength="10"
            value="{{old('Telefono') != "" ? old('Telefono'):($InfoExtra ? $InfoExtra->telefono:'')}}">
            <div class="input-group-prepend">
              <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;" onclick="VaciarCampo('Telefono')">
                <i class="far fa-trash-alt"></i>
              </div>
            </div>
          </div>

        </div>
        <div class="col-sm-6">
          <label for="Email">Correo electronico (Opcional)</label>
          <input type="email" name="Email" id="Email" class="form-control"
          value="{{old('Email') != "" ? old('Email'):($InfoExtra ? ($InfoExtra->correo != 'N/A' ? $InfoExtra->correo :''):'')}}">
        </div>
      </div>

      <div class="row" style="margin-bottom:15px;">
        <div class="col-sm-6">
          <label for="PaisNacimiento"><b style="color:red;padding-right: 10px;">*</b>País de nacimiento</label>
          <div class="input-group mb-2">
            <input type="text" name="PaisNacimiento" id="PaisNacimiento" class="form-control" required
            value="{{old('PaisNacimiento') != "" ? old('PaisNacimiento'):($InfoExtra ? $InfoExtra->pais_nacimiento:'México')}}">
            <div class="input-group-prepend">
              <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;" onclick="VaciarCampo('PaisNacimiento')">
                <i class="far fa-trash-alt"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <label for="PaisNacionalidad"><b style="color:red;padding-right: 10px;">*</b>País de nacionalidad</label>
          <div class="input-group mb-2">
            <input type="text" name="PaisNacionalidad" id="PaisNacionalidad" class="form-control" required
            value="{{old('PaisNacionalidad') != "" ? old('PaisNacionalidad'):($InfoExtra ? $InfoExtra->pais_nacionalidad:'México')}}">
            <div class="input-group-prepend">
              <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;" onclick="VaciarCampo('PaisNacionalidad')">
                <i class="far fa-trash-alt"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="margin-bottom:15px;">
        <div class="col-sm-6">
          <label for="">¿Tiene usted conocimiento de la existencia de algún dueño beneficiario?</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="Beneficiario" id="flexRadioDefault1" onchange="RadioBeneficiario(true)" value="SI" {{($InfoExtra ?  ($InfoExtra->beneficiario != 'No' ? 'checked':''):'')}}>
            <label class="form-check-label" for="flexRadioDefault1">
              SI
            </label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="Beneficiario" id="flexRadioDefault2" onchange="RadioBeneficiario(false)" value="NO" {{($InfoExtra ?  ($InfoExtra->beneficiario != 'No' ? '':'checked'):'checked')}}>
            <label class="form-check-label" for="flexRadioDefault2">
              NO
            </label>
          </div>
        </div>
        <div class="col-sm-6" id="DivNombreBeneficiario"  style="{{($InfoExtra ?  ($InfoExtra->beneficiario != 'No' ? '':'display:none;'):'display:none;')}}">
          <label for="NombreBeneficiario">Nombre completo del beneficiario</label>
          <input type="text" name="NombreBeneficiario" id="NombreBeneficiario" class="form-control" required {{($InfoExtra ?  ($InfoExtra->beneficiario != 'No' ? '':'disabled'):'disabled')}}
          value="{{old('NombreBeneficiario') != "" ? old('NombreBeneficiario'):($InfoExtra ? ($InfoExtra->beneficiario != "No" ? $InfoExtra->beneficiario:''):'')}}">
        </div>
      </div>

      <button type="submit" class="btn btn-success">Guardar</button>
    </form>


    <script type="text/javascript">
    function VaciarCampo(id){
      document.getElementById(id).value = "";
      document.getElementById(id).focus();
    }

    function RadioBeneficiario(valor){
      if (valor) {
        $('#NombreBeneficiario').prop('disabled',false);
        $('#DivNombreBeneficiario').fadeIn();
      }else{
        $('#NombreBeneficiario').prop('disabled',true);
        $('#DivNombreBeneficiario').fadeOut();
        $('#NombreBeneficiario').val('');
      }
    }

    function Identificacion(valor){
      $('#BotonIdentificacion').text(valor);
      $('#Identificacion').val(valor);
    }

    function RevisarCURP(InputCURP){


      var Curp = InputCURP.value = InputCURP.value.toUpperCase();

      var Valido = validarCurp(Curp);
      if (Curp.length == 18) {
        if (!Valido) {
          InputCURP.setCustomValidity('CURP invalido');
          InputCURP.reportValidity();
        }else{
          var FechaNacimiento = Curp.substring(4,10);
          var Year = FechaNacimiento.substring(0,2);
          if (Year <= 20) {
            Year = "20"+""+Year;
          }else{
            Year = "19"+""+Year;
          }
          var Month = FechaNacimiento.substring(2,4);
          var Day = FechaNacimiento.substring(4);

          $('#FechaNacimiento').val(Year+"-"+Month+"-"+Day)

          InputCURP.setCustomValidity('');
        }
      }else{
        InputCURP.setCustomValidity('El CURP ingresado debe contener 18 caracteres');
      }
    }

    //Función para validar una CURP
    function validarCurp(curp) {
      var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
      validado = curp.match(re);

      if (!validado)  //Coincide con el formato general?
      return false;

      //Validar que coincida el dígito verificador
      function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
        lngSuma = 0.0,
        lngDigito = 0.0;
        for (var i = 0; i < 17; i++)
        lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10)
        return 0;
        return lngDigito;
      }

      if (validado[2] != digitoVerificador(validado[1]))
      return false;

      return true; //Validado
    }


    </script>

  @endsection
