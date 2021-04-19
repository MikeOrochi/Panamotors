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

  .Pagare:hover > div {
    box-shadow: 0 0 15px 2px rgba(0, 0, 0, 0.45);
  }

  .readonly{
    background: #e9ecef;
    cursor: default;
  }

  .BTipoPagare{
    background: #5a5961;
  }
  .BTipoPagare:hover{
    background: #79787f;
  }

  .Pagare{
    margin-top: 5px; margin-bottom:5px
  }

  .ComentariosPagare::placeholder{
    color:white;
  }

  @media (max-width: 576px) {
    .Pagare{
      padding: 0px;
    }
    .LabelsPagare{
      display: none;
    }
    .ComentariosPagare::placeholder{
      color:#495057;
    }
  }
  </style>

  {{--@include('admin.partials.providers.js_edit_general')--}}

  <div class="">

    <div style="text-align:center">
      <h3>
        <b>Monto ${{number_format($VistaPrevia->monto_unidad,2)}}</b>
      </h3>
      @if ($VistaPrevia->anticipo > 0)
        <h3>
          <b>Enganche ${{number_format($VistaPrevia->anticipo,2)}}</b>
        </h3>
        <h3>
          <b>Total ${{number_format($VistaPrevia->monto_unidad-$VistaPrevia->anticipo,2)}}</b>
        </h3>
      @endif

    </div>

    <form id="venta" name="venta" enctype="multipart/form-data" method="post" action="{{route('vpMovimientoExitoso.GuardarPagares')}}" class="needs-validation confirmation">
      @csrf
      <input type="hidden" name="idVistaPrevia" value="{{$VistaPrevia->id}}">
      <div class="row" style="margin-bottom:15px;">
        <div class="col-sm-12">
          <label for="RangePagares" class="row">Número de Pagares: &nbsp;<p id="NumeroPagares"></p></label>
          <input type="hidden" id="NumeroPagaresInput" name="NumeroPagares">
          <input type="range" class="custom-range" id="RangePagares" min="1" max="12" value="1" oninput="GenerarPagares(this)">
        </div>

        <div class="row" id="Pagares" style="width: 100%;justify-content: center;margin-left: 0px;">
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
      </form>



      <script type="text/javascript">

      var PagaresCreados = 0;
      var FechaMinima = '{{\Carbon\Carbon::now()->format('Y-m-d')}}';


      var TotalPrepagares = {{sizeof($Pagares)}};

      if (TotalPrepagares > 0) {
        document.getElementById('RangePagares').value = TotalPrepagares;

        var PagaresPre = [
          @foreach ($Pagares as $key => $p)
            {{
              '{monto :'. $p->monto .',fecha : `'. \Carbon\Carbon::parse($p->fecha_vencimiento)->format('Y-m-d').'`},'
            }}
          @endforeach
        ];


        GenerarPagares(document.getElementById('RangePagares'),PagaresPre);
      }else{
        GenerarPagares(document.getElementById('RangePagares'));
      }


      function GenerarPagares(input,Pagares_PreCargados = null){

        while (input.value != PagaresCreados) {

          if (input.value > PagaresCreados) {
            var Logo = '{{secure_asset('public/img/logo_gran_pana.png')}}';
            var tipo_cambioOld =  '0';
            var tipo_cambioNew =  0;
            var tipo_Cambio = tipo_cambioOld || tipo_cambioNew;


            var Pagare = `
            <div class="Pagare col-12 col-sm-12 col-md-6 fadeIn_izi" id="Pagare_`+PagaresCreados+`">
            <div class="" style="padding:15px;border-radius: 10px;background: rgb(70,69,78);background: linear-gradient(240deg, rgba(70,69,78,0.8883928571428571) 72%, rgba(29,28,28,1) 100%);">
            <div class="" style="border: solid #ddfbfb 2px;border-radius: 10px;padding: 10px;">
            <div class="row" style="margin-bottom: 7px;">

            <div class="col">
            <p class="row" style="color:white;margin-left: 0px;">
            <b>Pagare `+(PagaresCreados+1)+`/</b>
            <b class="CantidadPagares"></b>
            </p>
            </div>

            <p class="col" style="color:white;position: relative;top: -21px;">
            <b class="BTipoPagare" style="border-radius: 20px;border: solid 1px;padding-left: 10px;padding-right: 10px;cursor: pointer;" onclick="CambiarTipoPagare(`+PagaresCreados+`,this)">Físico</b>
            <input type="hidden" name="TipoPagare_`+PagaresCreados+`" id="TipoPagare_`+PagaresCreados+`" value="Físico">
            </p>

            <img src="`+Logo+`" alt="" style="height: 30px;position: relative;top: -8px;right: 10px;">
            </div>

            <div class="row" style="margin-bottom: 7px;">
            <div style="padding-left: 15px;" class="LabelsPagare">
            <p style="color:white;">Vence el día &nbsp;</p>
            </div>
            <div class="col" style="position: relative;top: -8px;">
            <input type="date" name="FechaPagare_`+PagaresCreados+`" value="" class="FechaPagare form-control" min="`+FechaMinima+`" required>
            </div>
            </div>

            <div class="row">
            <div style="padding-left: 15px;" class="LabelsPagare">
            <p style="color:white;">Comentarios </p>
            </div>
            <div class="col" style="position: relative;top: -8px;">
            <input type="text" name="ComentariosPagare_`+PagaresCreados+`" value="Unidad sin validar" class="ComentariosPagare form-control" required placeholder="Comentarios">
            </div>
            </div>

            <div class="row" style="display: none;margin-top: 7px;">
            <div style="padding-left: 15px;padding-right: 22px;" class="LabelsPagare">
            <p style="color:white;">Evidencia</p>
            </div>
            <div class="col" style="position: relative;top: -8px;">
            <input type="file" name="Evidencia_`+PagaresCreados+`" id="Evidencia_`+PagaresCreados+`" value="" class="form-control" required disabled accept=".jpg,.png,.pdf">
            </div>
            </div>

            <div class="input-group mb-2">
            <div style="padding-right: 57px;" class="LabelsPagare">
            <p style="color:white;">Monto </p>
            </div>
            <div class="input-group-prepend">
            <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px">$</div>
            </div>
            <input type="text" class="form-control PrecioPagareUSD"  name="CantidadPagare_`+PagaresCreados+`" placeholder="$0.00" required onkeypress="return SoloNumeros(event);" onchange="CambiarMontoPagare(this.value,`+PagaresCreados+`)" maxlength="10">
            <div class="input-group-prepend">
            <div class="input-group-text TCambioText" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;">MXN</div>
            </div>
            </div>

            </div>
            </div>
            </div>
            `;
            $('#Pagares').append(Pagare);
            PagaresCreados++;

          }else{
            PagaresCreados--;

            var PagareEliminado = $('#Pagare_'+PagaresCreados).removeAttr('id');
            PagareEliminado.removeClass('fadeIn_izi');
            PagareEliminado.addClass('flipOutX_izi');
            PagareEliminado.fadeOut('slow',function(){
              $(this).remove();
            });


          }

        }
        
        if(Pagares_PreCargados != null ){
          PagaresPre.forEach(function logArrayElements(element, index, array) {
            document.getElementsByName('CantidadPagare_'+index)[0].value = element.monto;
            document.getElementsByName('FechaPagare_'+index)[0].value = element.fecha;
          });
        }else{
          var Total = {{$VistaPrevia->monto_unidad-$VistaPrevia->anticipo}};

          var PrecioPagare = getFlooredFixed(Total/PagaresCreados);
          $('.PrecioPagareUSD').val(PrecioPagare);
          if(PrecioPagare*PagaresCreados < Total){

            var Diferencia = getFlooredFixed( (Total - (PrecioPagare*PagaresCreados)).toFixed(2));
            var NuevoPrecio = parseFloat((PrecioPagare+Diferencia).toFixed(2));

            var SumaFinal = (parseFloat((PrecioPagare* (PagaresCreados-1)).toFixed(2)) +NuevoPrecio).toFixed(2);
            $('.PrecioPagareUSD:first').val(NuevoPrecio);

          }
        }


        $('.CantidadPagares').html(input.value)
        document.getElementById('NumeroPagares').innerHTML = input.value;
        document.getElementById('NumeroPagaresInput').value = input.value;

      }

      function getFlooredFixed(v) {
        return parseFloat((Math.floor(v * Math.pow(10, 2)) / Math.pow(10, 2)).toFixed(2));
      }

      function CambiarTipoPagare(id,campo){
        if(campo.textContent == "Virtual"){
          campo.textContent = "Físico";
          $('#Evidencia_'+id).prop('disabled', false);
          $('#Evidencia_'+id).parent().parent().fadeIn();
          $('#TipoPagare_'+id).val('Físico');
        }else{
          campo.textContent = "Virtual";
          $('#TipoPagare_'+id).val('Virtual');
          $('#Evidencia_'+id).prop('disabled', true);
          $('#Evidencia_'+id).parent().parent().fadeOut()
        }
      }

      function SoloNumeros(evt) {

        if (window.event) { //asignamos el valor de la tecla a keynum
          keynum = evt.keyCode; //IE
        } else {
          keynum = evt.which; //FF
        }
        //comprobamos si se encuentra en el rango numérico
        if ((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 || keynum == 47) {
          return true;
        } else {
          return false;
        }
      }

      </script>


    @endsection
