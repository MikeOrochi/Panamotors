@extends('layouts.appAdmin')
@section('titulo', 'CCP | Pagares proximos a vencer')

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




  <script type="text/javascript">

  var DonaPorVencer_Bol = false;
  var DonaVencidos_Bol = false;

  function MostrarPagaresPorVencer(){
    $('#PagaresVencidos').fadeOut();
    $('#PagaresPorVencer').fadeToggle();

    if(!DonaPorVencer_Bol){
      DonaPorVencer_Bol = true;
      CrearDona('DonaPorVencer',
      {{str_replace(",", "", $DolaresPVenc)}}
      ,{{str_replace(",", "", $DolaresCPVenc)}}
      ,{{str_replace(",", "", $PesosPVenc)}});
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


        <div class="row" style="justify-content: center;">

          <!--Tasks statistics card-->
          <div class="col-sm-4 custom-card" onclick="MostrarPagaresPorVencer()">
            <div class="mt-1 mb-3 button-container p-3 bg-white border shadow lh-sm">
              <div class="text-center mb-3">
                <h5 class="mb-0 mt-2"><small>Por vencer</small></h5>
                <h6>{{sizeof($PagaresPorVencer)}} Unidades - {{$TotalPagaresPorVencer}} Pagares</h6>
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
        </div>

        <div id="PagaresPorVencer" style="display:none">

          <div class="text-center">
            <h4>Pagares por vencer</h4>

            <div class="mt-1 mb-3 button-container bg-white border shadow-sm lh-sm">
              <div class="fb-follow-widget">
                <div class="row p-3 fb-widget-bottom">
                  <div class="col-sm-6 col-6 fb-wb-inner">
                    <p> <small><i class="fa fa-circle text-theme"></i> ${{$DolaresPVenc}} USD </small></p>
                    <p><small><i class="fa fa-circle text-theme"></i> ${{$DolaresCPVenc}} CAD</small></p>
                    <p><small><i class="fa fa-circle text-theme"></i> ${{$PesosPVenc}} MXN</small></p>
                    <!-- <h5>Total : <span class="text-theme">$</span></h5> -->
                  </div>
                  <div class="col-sm-6 col-6 text-right">
                    <div id="DonaPorVencer" style="height: 130px"></div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="row" style="width: 100%;justify-content: center;margin: 20px;">

            <label for="NombresFiltrosA" style="margin-right: 5px;"><i class="fas fa-filter" aria-hidden="true" style="vertical-align: -webkit-baseline-middle;"></i></label>
            <select class="js-example-basic-single" name="state" style="width: 50%;" id="NombresFiltrosA">
            @foreach ($NombresProvedoresPV as $npv => $NombresPV)
              <option value="{{$NombresPV}}">{{$NombresPV}}</option>
            @endforeach
            </select>
            <label for="NombresFiltrosA" style="margin-left: 5px;"><i onclick="LimpiarTablaA()" class="far fa-trash-alt" style="vertical-align: -webkit-baseline-middle;"></i></label>
          </div>



          <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaPorVencer">
            <thead>
              <tr>
                <th>#</th>
                <th>Estado de cuenta</th>
                <th>Proveedor</th>
                <th>VIN</th>
                <th>Pagares</th>
                <th>Monto total pagares</th>
                <th>Monto EDC</th>
                <th>Fecha primer pagare</th>
                <th>Fecha ultimo pagare</th>
              </tr>
            </thead>

            <tbody>
              @php
              $CountPPV = 0;
              @endphp
              @foreach ($PagaresPorVencer as $key => $PPV)
                <tr>
                  <td>{{++$CountPPV}}</td>
                  <td>
                    <button data-toggle="modal" data-target="#ModalEstadoCuenta" type="button" name="button" onclick="BuscarEstadoCuenta({{$key}})" class="btn btn-success"><i class="fas fa-file-alt"></i> &nbsp; {{$key}}</button>
                  </td>
                  <td>
                    <a href="{{route('wallet.showProvider',$PPV->first()->idproveedores)}}">
                      {{$PPV->first()->col2.' '.$PPV->first()->idproveedores.' - '.$PPV->first()->nombre.' '.$PPV->first()->apellidos}}
                    </a>
                  </td>
                  <td>{{$PPV->first()->datos_vin}}</td>
                  <td>
                    <button data-toggle="modal" data-target="#ModalPagares" type="button" class="btn btn-info" onclick="MostrarPagares({{$PPV}})">{{sizeof($PPV)}}</button>
                  </td>
                  <td>
                    @php
                    $MontoP = 0;
                    @endphp
                    @foreach ($PPV as $s => $p)
                      @if (is_numeric($p->monto))
                        @php
                        $MontoP+= floatval($p->monto);
                        @endphp
                      @endif
                    @endforeach
                    {{'$'.number_format($MontoP,2)}}
                  </td>
                  <td @if ($PPV->first()->monto_precio !=$MontoP) style="color:red; cursor:pointer" onclick="MostrarAbonosUnidadesP({{$key}})" data-toggle="modal" data-target="#ModalAbonosUP" @endif>
                    {{'$'.number_format($PPV->first()->monto_precio,2)}}
                  </td>
                  <td>{{\Carbon\Carbon::parse($PPV->first()->fecha_vencimiento)->format('d/m/Y')}}</td>
                  <td>
                    @if (sizeof($PPV) > 1)
                      {{\Carbon\Carbon::parse($PPV->last()->fecha_vencimiento)->format('d/m/Y')}}
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>


      <script type="text/javascript">

      function MostrarPagares(pagares){


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
            </tr>
            `);
          });

          CrearDataT('TablePagares');

        }


        function CrearDataT(id){
          $('#'+id).dataTable({
            "responsive": true,
            "ordering": true,
            language: {
              "sProcessing": "Procesando...",
              "sLengthMenu": "Mostrar _MENU_ registros",
              "sZeroRecords": "No se encontraron resultados",
              "sEmptyTable": "Ningún dato disponible en esta tabla",
              "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
              "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
              "sInfoPostFix": "",
              "sSearch": "Buscar:",
              "sUrl": "",
              "sInfoThousands": ",",
              "sLoadingRecords": "Cargando...",
              "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
              }
            },
            dom: 'Blfrtip',
            buttons: [

              'csv', 'excel', 'pdf',
              { extend: 'copy', text: 'Copiar' },
              { extend: 'print', text: 'Imprimir' }

            ]
          });
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
                  </tr>
                </thead>
                <tbody id="BodyTablasPagare">
                </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>


      <script type="text/javascript">

      $('#NombresFiltrosA').on('select2:select', function (e) {
        var data = e.params.data.text;
        $('#TablaPorVencer').dataTable().fnFilter(data);
      });

      function LimpiarTablaA(){
        $('#TablaPorVencer').dataTable().fnFilter("");
      }
      </script>
    @endsection
