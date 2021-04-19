@extends('layouts.appAdmin')
@section('titulo', 'CCP | Pagares')

@section('js')
  <script src="{{secure_asset('public/js/raphael.min.js')}}"></script>
  <script src="{{secure_asset('public/js/morris.min.js')}}"></script>

  <script type="text/javascript">

  function CrearDona(id,A,B,C){
    Morris.Donut({
      element: id,
      data: [
        {label: "USD", value: A },
        {label: "CAD", value: B },
        {label: "MXN", value: C },
      ],
      colors: ['#0D47A1', '#EA5941' , '#5ecc5e'],
      resize: true,
    });
  }
</script>
@endsection

@section('content')

  <style media="screen">
    .content {
      padding-left: 0px !important;
    }
    .container {
      padding-left: 0px !important;
    }
  </style>

  <script type="text/javascript">

  var DonasCreada = false;
  var filtroActivo = 0;



  function MostrarPagaresTabla(filtro){


    if(filtroActivo  != 0){
      $('#TablaVencidos').dataTable().fnFilter('', filtroActivo);
      filtroActivo = 0;
    }

    if (filtro == 5 || filtro == 6) {//Mostrar Vencidos  == 5  , Por Vencer == 6
      $('#TablaVencidos').dataTable().fnFilter('^(?!\s*$).+', filtro, true, false, false, false);
      filtroActivo = filtro;
    }

    if(!DonasCreada){

      $('#PagaresVencidos').fadeIn();

      DonasCreada = true;
      CrearDona('DonaVencidos',
      {{$DineroVenc['USD']}}
      ,{{$DineroVenc['CAD']}}
      ,{{$DineroVenc['MXN']}});

      CrearDona('DonaPorVencer',
      {{$DineroPorVenc['USD']}}
      ,{{$DineroPorVenc['CAD']}}
      ,{{$DineroPorVenc['MXN']}});
    }
  }

  function MostrarAbonosUnidadesP(id){

    $('#LoadingAbonos').html(`
      <div class="d-flex align-items-center" style="margin: 20px;color: #6495ed;">
      <strong>Cargando...</strong>
      <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
      </div>
      `);


      $("#TablaAbonosUP").dataTable().fnDestroy();
      $('#BodyTablaAbonosUP').html('');

      fetch("{{route('pagare.search.AUP')}}", {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-Token": '{{csrf_token()}}',
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
          id : id
        })
      }).then(res => res.json())
      .catch(function(error){
        console.error('Error:', error);
        $('#LoadingAbonos').html(`<div style="color:red;">`+error+`</div>`);
      })
      .then(function(response){

        $('#LoadingAbonos').html('');
        console.log(response);

        var Total = 0;
        const options2 = { style: 'currency', currency: 'USD' };
        const numberFormat2 = new Intl.NumberFormat('en-US', options2);



        response.forEach(function logArrayElements(element, index, array) {
          Total+= parseFloat(element.cantidad_pago);

          var FechaFormateada = element.fecha_creacion.split(' ')[0].split('-');
          var Fecha = FechaFormateada[2]+'/'+FechaFormateada[1]+'/'+FechaFormateada[0];

          $('#BodyTablaAbonosUP').append(`
            <tr>
            <td>`+(index+1)+`</td>
            <td>`+element.concepto+`</td>
            <td>`+numberFormat2.format(element.cantidad_pago)+`</td>
            <td>`+element.tipo_moneda+`</td>
            <td>`+Fecha+`</td>
            </tr>
            `);
          });

          CrearDataT('TablaAbonosUP')

          if(response.length > 1){
            $('#LoadingAbonos').append(`<p style="text-align: center;font-weight: bold;"> Total `+numberFormat2.format(Total)+`</p>`);
          }

        });
      }

      </script>


      <style media="screen">
      tr > td {
        text-align: center;
      }
      </style>

      <div class="container">


        <div class="row">

          <!--Tasks statistics card-->
          <div class="col-sm-4 custom-card" onclick="MostrarPagaresTabla(6)">
            <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm" style="border-radius: 16px;">
              <div class="text-center mb-3">
                <h5 class="mb-0 mt-2"><small>Por vencer</small></h5>
                <h6>{{$UnidadesPorVencer}} Unidades - {{$TotalPagaresPorVencer}} Pagares</h6>
              </div>

              <svg viewBox="0 0 36 25" class="circular-chart green">
                <path class="circle-bg" d="M18 2.0845
                a 7.9567 7.9567 0 0 1 0 15.9134
                a 7.9567 7.9567 0 0 1 0 -15.9134"></path>
                <path class="circle" stroke-dasharray="40, 60" d="M18 2.0845
                a 7.9567 7.9567 0 0 1 0 15.9134
                a 7.9567 7.9567 0 0 1 0 -15.9134"></path>
                <text x="18" y="12.00" class="percentage">🧾</text>
              </svg>

              <div class="row mx-2">
                <div class="col-sm-6 col-12">
                  <h5>{{\Carbon\Carbon::parse($FechasPorVencer->Minima)->format('d/m/Y')}}</h5>
                  <span class="text-muted small"><strong>Desde</strong></span>
                </div>
                <div class="col-sm-6 col-12 text-right">
                  <h5>{{\Carbon\Carbon::parse($FechasPorVencer->Maxima)->format('d/m/Y')}}</h5>
                  <span class="text-muted small"><strong>Hasta</strong></span>
                </div>
              </div>
            </div>
          </div>
          <!--Transaction statistics card-->


          <!--Visitors statistics card-->
          <div class="col-sm-4 custom-card" onclick="MostrarPagaresTabla()">
            <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm" style="border-radius: 16px;">
              <div class="text-center mb-3">
                <h5 class="mb-0 mt-2"><small> Total </small></h5>
                <h6>{{sizeof($ArregloPagares)}} Unidades - {{$TotalPagaresVencidos + $TotalPagaresPorVencer}} Pagares</h6>
              </div>

              <svg viewBox="0 0 36 25" class="circular-chart blue">
                <path class="circle-bg" d="M18 2.0845
                a 7.9567 7.9567 0 0 1 0 15.9134
                a 7.9567 7.9567 0 0 1 0 -15.9134"></path>
                <path class="circle" stroke-dasharray="40, 60" d="M18 2.0845
                a 7.9567 7.9567 0 0 1 0 15.9134
                a 7.9567 7.9567 0 0 1 0 -15.9134"></path>
                <text x="18" y="12.00" class="percentage">🧾</text>
              </svg>
              <div class="row mx-2">
                <div class="col-sm-6 col-12">
                  <span class="text-muted small"><strong></strong></span>

                </div>
                <div class="col-sm-6 col-12 text-right">
                  <span class="text-muted small"><strong></strong></span>

                </div>
              </div>
            </div>
          </div>
          <!--/Visitors statistics card-->

          <!--Transaction statistics card-->
          <div class="col-sm-4 custom-card" onclick="MostrarPagaresTabla(5)">
            <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm" style="border-radius: 16px;">
              <div class="text-center mb-3">
                <h5 class="mb-0 mt-2"><small>Vencidos</small></h5>
                <h6>{{$UnidadesVencidas}} Unidades - {{$TotalPagaresVencidos}} Pagares</h6>
              </div>

              <svg viewBox="0 0 36 25" class="circular-chart red">
                <path class="circle-bg" d="M18 2.0845
                a 7.9567 7.9567 0 0 1 0 15.9134
                a 7.9567 7.9567 0 0 1 0 -15.9134"></path>
                <path class="circle" stroke-dasharray="40, 60" d="M18 2.0845
                a 7.9567 7.9567 0 0 1 0 15.9134
                a 7.9567 7.9567 0 0 1 0 -15.9134"></path>
                <text x="18" y="12.00" class="percentage">🧾</text>
              </svg>

              <div class="row mx-2">
                <div class="col-sm-6 col-12">
                  <h5>{{\Carbon\Carbon::parse($FechasVencidas->Minima)->format('d/m/Y')}}</h5>
                  <span class="text-muted small"><strong>Desde</strong></span>
                </div>
                <div class="col-sm-6 col-12 text-right">
                  <h5>{{\Carbon\Carbon::parse($FechasVencidas->Maxima)->format('d/m/Y')}}</h5>
                  <span class="text-muted small"><strong>Hasta</strong></span>
                </div>
              </div>
            </div>
          </div>
          <!--/Transaction statistics card-->


        </div>






        <div id="PagaresVencidos" style="display:none;">

          <div class="text-center">
            <h4>Compras Pendientes</h4>

            <div class="mt-1 mb-3 button-container bg-white border shadow-sm lh-sm">
              <div class="fb-follow-widget">
                <div class="row p-3 fb-widget-bottom">
                  <div class="col-sm-3 col-3 fb-wb-inner">
                    <h5><span class="text-theme">Vencidos</span></h5>
                    <p> <small><i class="fa fa-circle text-theme"></i> ${{number_format($DineroVenc['USD'])}} USD </small></p>
                    <p><small><i class="fa fa-circle text-theme"></i> ${{number_format($DineroVenc['CAD'])}} CAD</small></p>
                    <p><small><i class="fa fa-circle text-theme"></i> ${{number_format($DineroVenc['MXN'])}} MXN</small></p>
                  </div>
                  <div class="col-sm-3 col-3 text-right">
                    <div id="DonaVencidos" style="height: 130px"></div>
                  </div>

                  <div class="col-sm-3 col-3 fb-wb-inner">
                    <h5><span class="text-theme">Por Vencer</span></h5>
                    <p> <small><i class="fa fa-circle text-theme"></i> ${{number_format($DineroPorVenc['USD'])}} USD </small></p>
                    <p><small><i class="fa fa-circle text-theme"></i> ${{number_format($DineroPorVenc['CAD'])}} CAD</small></p>
                    <p><small><i class="fa fa-circle text-theme"></i> ${{number_format($DineroPorVenc['MXN'])}} MXN</small></p>
                  </div>
                  <div class="col-sm-3 col-3 text-right">
                    <div id="DonaPorVencer" style="height: 130px"></div>
                  </div>
                </div>

              </div>
            </div>

          </div>

          <div class="row" style="width: 100%;justify-content: center;margin: 20px;">

            <label for="NombresFiltrosB" style="margin-right: 5px;"><i class="fas fa-filter" aria-hidden="true" style="vertical-align: -webkit-baseline-middle;"></i></label>
            <select class="js-example-basic-single col" name="state" style="width: 50%;" id="NombresFiltrosB">
              <option>Seleccione una opción</option>
              @foreach ($NombresProveedores as $npv => $Nombre)
                <option>{{$npv.' - '.$Nombre}}</option>
              @endforeach
            </select>
            <label for="NombresFiltrosB" style="margin-left: 5px;"><i onclick="LimpiarTablaB()" class="far fa-trash-alt" style="vertical-align: -webkit-baseline-middle;"></i></label>

            <div class="col" style="text-align: center;display:none;" id="DivMostrarErrores">
                <button type="button" class="btn btn-danger" id="MostrarDescuadres" onclick="FiltrarDescuadres()" style="padding-top: 0px;padding-bottom: 0px;"> Errores 0</button>
            </div>

          </div>

          <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaVencidos">
            <thead>
              <tr>
                <th>#</th>
                <th>Estado de cuenta</th>
                <th>Proveedor</th>
                <th>VIN</th>
                <th>Pagados</th>
                <th>Vencidos</th>
                <th>Por vencer</th>
                <th>Monto Pagares</th>
                <th>Abonos UP</th>
                <th>Monto EDC</th>
              </tr>
            </thead>

            <tbody>
              @php
              $CountPV = 0;
              $CountErrores = 0;
              @endphp
              @foreach ($ArregloPagares as $key => $Pagares)
                <tr>
                  <td>{{++$CountPV}}</td>
                  <td>
                    <button style="font-size: 12px;" data-toggle="modal" data-target="#ModalEstadoCuenta" type="button" name="button" onclick="BuscarEstadoCuenta({{$key}})" class="btn btn-light"><i class="fas fa-file-alt"></i> &nbsp; {{$key}} </button>
                  </td>
                  <td>
                    <a href="{{route('wallet.showProvider',$Pagares['ECP']->idproveedores)}}" style="font-size: 13px;">
                      {{$Pagares['ECP']->col2.' - '.$Pagares['ECP']->idproveedores.' - '.$Pagares['ECP']->nombre.' '.$Pagares['ECP']->apellidos}}
                    </a>
                  </td>
                  <td>{{$Pagares['ECP']->datos_vin}}</td>
                  <td>
                    @php
                      $SumaPagaresP = [];
                    @endphp
                    @if (sizeof($Pagares['Pagados']) > 0)
                      <button data-toggle="modal" data-target="#ModalPagares" type="button" class="btn btn-light" onclick="MostrarPagares({{$Pagares['Pagados']}},
                      `{{route('account.abono_unidad.show',[
                        'idcontacto'  => base64_encode($Pagares['ECP']->idproveedores),
                        'idmovmiento' => base64_encode($key)
                        ])}}`)">{{sizeof($Pagares['Pagados'])}}</button>
                      @endif
                      @php
                        foreach ($Pagares['Pagados'] as $MontosPagados) {
                          $SumaPagaresP[$MontosPagados->tipo_moneda] = 0;
                        }
                        foreach ($Pagares['Pagados'] as $MontosPagados) {
                          $SumaPagaresP[$MontosPagados->tipo_moneda] += floatval($MontosPagados->cantidad_pago);
                        }
                      @endphp
                      @foreach ($SumaPagaresP as $T_Moneda => $MontoPago)
                          <p>{{$T_Moneda.' $'.number_format($MontoPago ,2)}}</p>
                      @endforeach
                    </td>
                    <td>
                      @php
                        $SumaPagaresV = 0;
                      @endphp
                      @if (isset($Pagares['Vecidos']))
                        <button data-toggle="modal" data-target="#ModalPagares" type="button" class="btn btn-light" onclick="MostrarPagares( {{$Pagares['Vecidos']}},
                        `{{route('account.abono_unidad.show',[
                          'idcontacto'  => base64_encode($Pagares['ECP']->idproveedores),
                          'idmovmiento' => base64_encode($key)
                          ])}}`)">{{sizeof($Pagares['Vecidos'])}}</button>
                          @php
                              foreach ($Pagares['Vecidos'] as $MontosVencidos) {
                                if ($MontosVencidos->AbonoUP == null) {
                                  $SumaPagaresV+= floatval($MontosVencidos->monto);
                                }else{
                                  $SumaPagaresV += round( (floatval($MontosVencidos->monto) - floatval($MontosVencidos->AbonoUP)), 2 );//Se suma la parte restante
                                }
                              }
                          @endphp
                          {{'$'.number_format($SumaPagaresV ,2)}}
                        @endif
                      </td>
                      <td>
                        @php
                          $SumaPagaresPorV = 0;
                        @endphp
                        @if (isset($Pagares['PorVencer']))
                          <button data-toggle="modal" data-target="#ModalPagares" type="button" class="btn btn-light" onclick="MostrarPagares({{$Pagares['PorVencer']}},
                          `{{route('account.abono_unidad.show',[
                            'idcontacto'  => base64_encode($Pagares['ECP']->idproveedores),
                            'idmovmiento' => base64_encode($key)
                            ])}}`)">{{sizeof($Pagares['PorVencer'])}}</button>
                            @php
                            foreach ($Pagares['PorVencer'] as $MontosPorV) {
                              if ($MontosPorV->AbonoUP == null) {
                                $SumaPagaresPorV+= floatval($MontosPorV->monto);
                              }else{
                                $SumaPagaresPorV += round( (floatval($MontosPorV->monto) - floatval($MontosPorV->AbonoUP)), 2 );//Se suma la parte restante
                              }
                            }
                            @endphp
                            {{'$'.number_format($SumaPagaresPorV,2)}}
                          @endif
                        </td>
                        <td

                          @php
                            $SumaFinal = floatval($SumaPagaresPorV) +floatval($SumaPagaresV);
                            foreach ($Pagares['SumaAbonos'] as $Moneda => $MontosAbono) {
                              $SumaFinal+=floatval($MontosAbono);
                            }
                            $SumaFinal = round($SumaFinal,2);
                          @endphp

                          @if (sizeof($SumaPagaresP) == 0 )
                            @if ($SumaFinal > round(floatval($Pagares['ECP']->monto_precio),2))
                              @php
                                $CountErrores++;
                              @endphp
                              class="Error" style="color:red" data-toggle="tooltip" data-placement="top" title="Sobran ${{number_format($Pagares['ECP']->monto_precio-$SumaFinal,2)}}"
                            @elseif ($SumaFinal == round(floatval($Pagares['ECP']->monto_precio),2))
                                style="color:green"
                              @elseif ($SumaFinal < round(floatval($Pagares['ECP']->monto_precio),2))
                                @php
                                  $CountErrores++;
                                @endphp
                                class="Error" style="color:#8324ea" data-toggle="tooltip" data-placement="top" title="Faltan ${{number_format($SumaFinal-$Pagares['ECP']->monto_precio,2)}}"
                            @endif
                          @elseif(sizeof($SumaPagaresP) == 1)

                            @if (current($SumaPagaresP) > current($Pagares['SumaAbonos']))
                              style="background: #da0000;color: white;" data-toggle="tooltip" data-placement="top"
                              title="Los Abonos a Pagares son mayores que los Abonos a Unidades"
                              @else
                                @if ($SumaFinal > round(floatval($Pagares['ECP']->monto_precio),2))
                                  @php
                                    $CountErrores++;
                                  @endphp
                                  class="Error" style="color:red" data-toggle="tooltip" data-placement="top" title="Sobra ${{number_format($Pagares['ECP']->monto_precio-$SumaFinal,2)}}"
                                @elseif ($SumaFinal == round(floatval($Pagares['ECP']->monto_precio),2))
                                    style="color:green"
                                  @elseif ($SumaFinal < round(floatval($Pagares['ECP']->monto_precio),2))
                                    @php
                                      $CountErrores++;
                                    @endphp
                                    class="Error" style="color:#8324ea" data-toggle="tooltip" data-placement="top" title="Faltan ${{number_format($SumaFinal-$Pagares['ECP']->monto_precio,2)}}"
                                @endif
                            @endif


                          @else
                              style="background:red"
                          @endif>
                          @if (sizeof($SumaPagaresP) == 0)
                            {{'$'.number_format($SumaPagaresPorV+$SumaPagaresV,2)}}
                          @elseif (sizeof($SumaPagaresP) == 1)
                            @foreach ($SumaPagaresP as $TMone => $MoneP)
                              {{'$'.number_format($SumaPagaresPorV+$SumaPagaresV+$MoneP,2)}}
                            @endforeach
                            @else
                              {{'?????????'}}
                          @endif
                        </td>
                        <td @if (sizeof($Pagares['SumaAbonos'])>0)
                            onclick="MostrarAbonosUnidadesP({{$key}})" data-toggle="modal" data-target="#ModalAbonosUP" style="color:blue; cursor:pointer"
                          @endif
                          >
                          @foreach ($Pagares['SumaAbonos'] as $Moneda => $MontosAbono)
                              {{$Moneda.' $'.number_format($MontosAbono,2)}}
                          @endforeach
                        </td>
                        <td >
                          {{$Pagares['ECP']->tipo_moneda.' $'.number_format($Pagares['ECP']->monto_precio,2)}}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

            </div>



            <script type="text/javascript">

            var TotalDescuadres = {{$CountErrores}};
            var FiltroDescuadreA = false;

            if (TotalDescuadres > 0) {
              document.getElementById('MostrarDescuadres').textContent = "Errores "+TotalDescuadres;
              $('#DivMostrarErrores').fadeIn();
            }

            function FiltrarDescuadres(){

              if (!FiltroDescuadreA) {
                FiltroDescuadreA = true;
                var table = $('#TablaVencidos').dataTable();
                $('#TablaVencidos').dataTable.ext.search.push(
                  function (settings, searchData, index, rowData) {
                    return $(table.fnGetNodes(index)).find('td.Error').length;
                  }
                );
                $('#TablaVencidos').dataTable().fnDraw();
                $('#TablaVencidos').dataTable.ext.search.pop();
              }else{
                FiltroDescuadreA = false;
                $('#TablaVencidos').dataTable().fnDraw();
              }

            }



            function MostrarPagares(pagares,ruta){

              console.log(pagares);

              $("#TablePagares").dataTable().fnDestroy();
              $('#BodyTablasPagare').html('');

              const options2 = { style: 'currency', currency: 'USD' };
              const numberFormat2 = new Intl.NumberFormat('en-US', options2);

              pagares.forEach(function logArrayElements(element, index, array) {


                var FechaFormateada = element.fecha_vencimiento.split('-');
                var Fecha = FechaFormateada[2]+'/'+FechaFormateada[1]+'/'+FechaFormateada[0];

                $('#BodyTablasPagare').append(`
                  <tr>
                  <td>`+(index+1)+`</td>
                  <td>`+element.num_pagare+`</td>
                  <td>`+numberFormat2.format(element.monto)+`</td>
                  <td>`+Fecha+`</td>
                  <td>`+element.tipo+`</td>
                  <td>`
                  +
                  (element.archivo_original != 'N/A' ? '<a href="'+element.archivo_original+'" target="_blank"><i class="fas fa-file-alt"></i></a>' : '')
                  +`</td>
                  <td>`+element.comentarios+`</td>
                  <td>`+element.estatus+`</td>
                  </tr>
                  `);
                });

                CrearDataT('TablePagares');

                $('#BotonAbonar').html(`
                  <a href="`+ruta+`" class="btn btn-success">Abonar</a>
                  `);


                }





                function BuscarEstadoCuenta(id){

                  var Ruta = "{{route('account.summary.index','')}}";

                  $('#ModalBody').html(
                    `<div class="text-center">
                    <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                    </div>
                    </div>`);


                    fetch("{{route('pagare.search')}}", {
                      headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": '{{csrf_token()}}',
                      },
                      method: "post",
                      credentials: "same-origin",
                      body: JSON.stringify({
                        idEC : id
                      })
                    }).then(res => res.json())
                    .catch(function(error){
                      console.error('Error:', error);
                      $('#ModalBody').html(error);
                    })
                    .then(function(response){
                      $('#ModalBody').html('');
                      console.log(response);

                      if (response == null) {
                        $('#ModalBody').html('<p style="color:red;">No se pudo encontrar o hubo un error</p>');
                      }else{
                        $('#ModalBody').append('<p><b>Concepto: &nbsp;</b>'+response.concepto+'</p>');
                        $('#ModalBody').append('<p><b>Efecto: &nbsp;</b>'+response.efecto_movimiento+'</p>');
                        $('#ModalBody').append('<p><b>Color: &nbsp;</b>'+response.datos_color+'</p>');
                        $('#ModalBody').append('<p><b>Estatus: &nbsp;</b>'+response.datos_estatus+'</p>');
                        $('#ModalBody').append('<p><b>Marca: &nbsp;</b>'+response.datos_marca+'</p>');
                        $('#ModalBody').append('<p><b>Modelo: &nbsp;</b>'+response.datos_modelo+'</p>');
                        $('#ModalBody').append('<p><b>Precio: &nbsp;</b>'+response.datos_precio+'</p>');
                        $('#ModalBody').append('<p><b>Version: &nbsp;</b>'+response.datos_version+'</p>');
                        $('#ModalBody').append('<p><b>VIN: &nbsp;</b>'+response.datos_vin+'</p>');
                        $('#ModalBody').append('<p><b>Emisor agente: &nbsp;</b>'+response.emisora_agente+'</p>');
                        $('#ModalBody').append('<p><b>Institución emisora: &nbsp;</b>'+response.emisora_institucion+'</p>');
                        $('#ModalBody').append('<p><b>Institución receptora: &nbsp;</b>'+response.receptora_institucion+'</p>');
                        $('#ModalBody').append('<p><b>Referencia: &nbsp;</b>'+response.referencia+'</p>');
                        $('#ModalBody').append('<a class="btn btn-info" href="'+Ruta+'/'+response.idestado_cuenta_proveedores+'">Resumen</a>');
                      }





                    });
                  }
                  </script>


                  <!-- Modal -->
                  <div class="modal fade" id="ModalAbonosUP" tabindex="-1" role="dialog" aria-labelledby="ModalLabelAbonosUP" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="ModalLabelAbonosUP">Abonos Unidades Proveedores</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="ModalAbonosUPBody">

                          <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaAbonosUP">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Concepto</th>
                                <th>Pago</th>
                                <th>Moneda</th>
                                <th>Fecha</th>
                              </tr>
                            </thead>
                            <tbody id="BodyTablaAbonosUP">
                            </tbody>
                          </table>

                          <div id="LoadingAbonos">
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="ModalEstadoCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Estado de Cuenta</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="ModalBody">

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="ModalPagares" tabindex="-1" role="dialog" aria-labelledby="ModalLabelPagares" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="ModalLabelPagares">Pagares</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body" id="ModalBodyPagares">
                          <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablePagares">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Serie</th>
                                <th>Monto</th>
                                <th>Fecha vencimiento</th>
                                <th>Tipo</th>
                                <th>Archivo original</th>
                                <th>Comentarios</th>
                                <th>Estatus</th>
                              </tr>
                            </thead>
                            <tbody id="BodyTablasPagare">
                            </tbody>
                          </table>
                          <div id="BotonAbonar">

                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>



                  <script type="text/javascript">

                  $('#NombresFiltrosB').on('select2:select', function (e) {
                    var data = e.params.data.text;
                    $('#TablaVencidos').dataTable().fnFilter(data);
                  });

                  function LimpiarTablaB(){
                    if(filtroActivo  != 0){
                      $('#TablaVencidos').dataTable().fnFilter('', filtroActivo);
                      filtroActivo = 0;
                    }
                    $('#TablaVencidos').dataTable().fnFilter("");
                  }


                  </script>
                @endsection
