@extends('layouts.appAdmin')
@section('titulo', 'Catalogo de proveedores')



@section('head')
  <style>
  #estado_cuenta_interno_1, #estado_cuenta_cliente_1, #estado_cuenta_interno, #estado_cuenta_cliente {
    background: transparent;
    border: 0px;
  }


  span > div {
    white-space: nowrap;
    text-align: left;
    font-size: 14px;
    width: 100%;
  }

  @media (min-width: 576px) {
    span > div {
      width: 40%;
    }
  }

  @media (min-width: 768px) {
    span > div {
      width: 40%;
    }
  }

  @media (min-width: 992px) {
    span > div {
      width: 45%;
    }
  }

  @media (min-width: 1200px) {
    span > div {
      width: 23%;
    }
  }



  span > div:hover {
    color: #2e57cc;
    background: #f0f0f9;
    border-radius: 15px;
  }
</style>

@endsection



@section('content')

  <!-- Modal -->
<div class="modal fade" id="ModalAbonosEmpalmados" tabindex="-1" role="dialog" aria-labelledby="ModalAbonosEmpalmadosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAbonosEmpalmadosLabel">Abonos Empalmados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaAbonosEmpalmados">
          <thead>
            <tr>
              <th>#</th>
              <th>Abono</th>
              <th>U. Marca</th>
              <th>U. Versión</th>
              <th>U. Color</th>
              <th>U. Modelo</th>
              <th>U. VIN</th>
              <th>U. Estatus</th>
            </tr>
          </thead>
          <tbody id="BodyTablaAbonosEmpalmados">
          </tbody>
      </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

  <div class="row mt-3">
    <div class="col-sm-12">
      <div class="shadow panel-head-primary">
        <a class="btn-back" style="margin-left:15px;" href="{{route('wallet.showProvider',$id_proveedor)}}"><i class="fas fa-chevron-left"></i> Perfil</a>


        <center>
          <h5 class="text-center mt-3 mb-3"><strong><?php echo $proveedor->nombre." ".$proveedor->apellidos;?></strong></h5>
          <i class="fa fa-calculator fa-3x" aria-hidden="true"></i>
        </center>

        <!-- <ol class="breadcrumb">
        <li>
        <a href="index.php">Inicio</a>
      </li>
      <li>
      <a href="proveedor_detalles.php?idatn=<?php //echo $id_proveedor;?>">Perfil</a>
    </li>
    <li  class="active">
    <strong>Estado de Cuenta</strong>
  </li>
</ol> -->





<!-- row -->
<div class="row">
  <div class="col-lg-12">


    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Resumen de movimientos</h5>
      </div>

      <div class="ibox-content">
        <center>

          <style media="screen">
              .Enlace_A:hover ~ .Titulos::after {
                content: "Agregar compra";
              }
              .Enlace_B:hover ~ .Titulos::after {
                content: "Estado de cuenta interno";
              }
              .Enlace_C:hover ~ .Titulos::after {
                content: "Documentos por cobrar";
              }
              .Enlace_D:hover ~ .Titulos::after {
                content: "Estado de cuenta";
              }
              .Enlace_E:hover ~ .Titulos::after {
                content: "Agregar traspaso";
              }
              .Enlace_F:hover ~ .Titulos::after {
                content: "Recibos";
              }
              .Enlace_G:hover ~ .Titulos::after {
                content: "Reporte de compras de proveedor";
              }
              .Enlace_H:hover ~ .Titulos::after {
                content: "Reporte de compras de proveedor deuda sin inventario";
              }
              .Enlace_I:hover ~ .Titulos::after {
                content: "Reporte de compras de proveedor pagados sin Inventario";
              }
              .Enlace_J:hover ~ .Titulos::after {
                content: "Reporte de compras de proveedor deuda";
              }
              .Enlace_K:hover ~ .Titulos::after {
                content: "Reporte de compras de proveedor deuda general";
              }
              .Enlace_L:hover ~ .Titulos::after {
                content: "Reporte ejecutivo mensual";
              }
              .EnlacesMovimientos a{
                padding: 10px;
                color: #4b4b4b;
              }
              .EnlacesMovimientos a:hover{
                color:#c3c7cc;
                filter: brightness(75%);
              }
          </style>
          <?php $id_empleado = 2; ?>
          @if($usuario_creador == 1 || $usuario_creador==2005)
            <?php date_default_timezone_set('America/Mexico_City');
            $fechainicio = date("Y-m-d H:i:s");
            $fecha=base64_encode($fechainicio);
            ?>

            <div class="row">
                <div class="col-sm-12 EnlacesMovimientos">
                  <a class="Enlace_A" href="{{ route('shopping_entrance.index',['idc' => $id_proveedor,'f' => Crypt::encrypt($fechainicio) ]) }}"><i class='fa fa-handshake-o fa-3x' aria-hidden='true'></i></a>
                  <a class="Enlace_C" href="{{route('account_status.promisoryNotesProvider',['id' => $id_proveedor])}}" title='Documentos por Cobrar'><i class='fa fa-archive fa-3x' aria-hidden='true'></i></a>
                  <a class="Enlace_D" href="{{route('account_status.pdfAccountStatusProviders',['id' => $id_proveedor])}}" target="_blank"><i class='fa fa-id-badge fa-3x' aria-hidden='true'></i></a>
                  <a class="Enlace_E" href='{{route('transfer.show',['id' => $id_proveedor])}}' title='Agregar Traspaso'><i class='fas fa-exchange-alt fa-3x' aria-hidden='true'></i></a>
                  <a class="Enlace_F" href='{{route('recibos.show',['id' => $id_proveedor])}}' title='Recibos'><i class='fa fa-files-o fa-3x' aria-hidden='true'></i></a>
                    <div class="Titulos" style="font-size:23px;color: #007ea6;height:45px;">
                    </div>
                </div>
            </div>
          @else
            <?php
            date_default_timezone_set('America/Mexico_City');
            $fechainicio= date("Y-m-d H:i:s");
            $fecha=base64_encode($fechainicio);
            ?>

            <div class="row">
                <div class="col-sm-12 EnlacesMovimientos">
                    <a class="Enlace_A" href="{{ route('shopping_entrance.index',['idc' => $id_proveedor,'f' => Crypt::encrypt($fechainicio) ]) }}"><i class='fa fa-handshake-o fa-3x' aria-hidden='true'></i></a>
                    <a class="Enlace_C" href="{{route('account_status.promisoryNotesProvider',['id' => $id_proveedor])}}" title='Documentos por Cobrar'><i class='fa fa-archive fa-3x' aria-hidden='true'></i></a>
                    <a class="Enlace_D" href="{{route('account_status.pdfAccountStatusProviders',['id' => $id_proveedor])}}" target="_blank"><i class='fa fa-id-badge fa-3x' aria-hidden='true'></i></a>
                    <a class="Enlace_E" href='{{route('transfer.show',['id' => $id_proveedor])}}' title='Agregar Traspaso'><i class='fas fa-exchange-alt fa-3x' aria-hidden='true'></i></a>
                    <a class="Enlace_F" href='{{route('recibos.show',['id' => $id_proveedor])}}' title='Recibos'><i class='fa fa-files-o fa-3x' aria-hidden='true'></i></a>
                    <div class="Titulos" style="font-size:23px;color: #007ea6;height:45px;">
                    </div>
                </div>
            </div>


            @if ($id_empleado == 2 || $id_empleado == 88 || $id_empleado == 91 || $id_empleado == 4 || $id_empleado == 176)
              <div class="row">
                  <div class="col-sm-12 EnlacesMovimientos">
                       @php //$id_recibo = Crypt::encrypt($r->idrecibos_proveedores)@endphp
                      <a class="Enlace_L" data-toggle="modal" data-target="#ModalEstadoCuenta" onclick="BuscarEstadoCuenta({{""}},'{{ ""}}')"><i class='fa fa-table fa-3x' aria-hidden='true'></i></a>

                      <a class="Enlace_B" href="{{route('account_status.pdfAccountStatusProviderInternal',['id' => $id_proveedor])}}" target="_blank"><i class='fa fa-file-pdf-o fa-3x' aria-hidden='true'></i></a>
                      <!--reporte_compras_directas_proveedores.php---->
                      <a class="Enlace_G" href="{{route('account_status.reportDirectPurchasesProviders',['type_report_direct_purchases'=>'compras_directas_proveedores','id_proveedor'=>$id_proveedor])}}" title='Reporte de compras de Proveedor' target='_blank'><i class='far fa-file-alt fa-3x' aria-hidden='true'></i></a>
                      <!--reporte_compras_directas_proveedores_deuda_sin_inventario_pdf---->
                      <!-- <a href='reporte_compras_directas_proveedores_deuda_sin_inventario_pdf.php?idc=$id_proveedor' title='Reporte de compras de Proveedor Deuda sin Inventario' target='_blank'><i class='fa fa-money fa-3x' aria-hidden='true' style='color: #CA2A15;'></i></a> -->
                      <a class="Enlace_H" href="{{route('account_status.reportDirectPurchasesProviders',['type_report_direct_purchases'=>'compras_directas_proveedores_deuda_sin_inventario','id_proveedor'=>$id_proveedor])}}" title='Reporte de compras de Proveedor Deuda sin Inventario' target='_blank'><i class='fa fa-money fa-3x' aria-hidden='true'></i></a>
                      <!--reporte_compras_directas_proveedores_pagado_sin_inventario_pdf---->
                      <!-- <a href='reporte_compras_directas_proveedores_pagado_sin_inventario_pdf.php?idc=$id_proveedor' title='Reporte de compras de Proveedor Pagados sin Inventario' target='_blank'><i class='fa fa-car fa-3x' aria-hidden='true' style='color: #0F920F;'></i></a> -->
                      <a class="Enlace_I" href="{{route('account_status.reportDirectPurchasesProviders',['type_report_direct_purchases'=>'compras_directas_proveedores_pagado_sin_inventario','id_proveedor'=>$id_proveedor])}}" title='Reporte de compras de Proveedor Pagados sin Inventario' target='_blank'><i class='fa fa-car fa-3x' aria-hidden='true'></i></a>
                      <!--reporte_compras_directas_proveedores_deuda_pdf---->
                      <!-- <a href='reporte_compras_directas_proveedores_deuda_pdf.php?idc=$id_proveedor' title='Reporte de compras de Proveedor Deuda General' target='_blank'><i class='fa fa-check-square fa-3x' aria-hidden='true' style='color: #DF2A06;'></i></a> -->
                      <a class="Enlace_J" href="{{route('account_status.reportDirectPurchasesProviders',['type_report_direct_purchases'=>'compras_directas_proveedores_deuda','id_proveedor'=>$id_proveedor])}}" title='Reporte de compras de Proveedor Deuda General' target='_blank'><i class='fa fa-check-square fa-3x' aria-hidden='true'></i></a>
                      <!--reporte_compras_directas_comisiones_pdf---->
                      <!-- <a href='reporte_compras_directas_comisiones_pdf.php?idc=$id_proveedor' title='Reporte de compras de Proveedor Deuda General' target='_blank'><i class='fa fa-credit-card fa-3x' aria-hidden='true'></i></a> -->
                      <a class="Enlace_K" href="{{route('account_status.reportDirectPurchasesProviders',['type_report_direct_purchases'=>'compras_directas_comisiones','id_proveedor'=>$id_proveedor])}}" title='Reporte de compras de Proveedor Deuda General' target='_blank'><i class='fa fa-credit-card fa-3x' aria-hidden='true'></i></a>
                      <div class="Titulos" style="font-size:23px;color: #007ea6;height:45px;">
                      </div>
                  </div>
              </div>
            @endif

          @endif
        </center>
        <div class="col-lg-12">
          <br>
          <br>
        </div>

        <i class="fa fa-filter fa-2x fa-fw"></i><b>Conceptos: &nbsp;</b>
        <center>
          <span class="row" style="padding-left: 15px;">



            @php
              $resultado = array();
            @endphp


            @foreach ($resultado as $key => $value)
              <div class="" style="margin-left: 10px; margin-right:10px;">
                <input onchange='filterme()' type='checkbox' class='conceptos' name='ases' value='{{$value}}'> {{$value}}
              </div>
            @endforeach
          </span>
          <hr>
          <!-- <?php
          //echo "<a href='historial_pagares.php?idc=$id_proveedor' title='Historial de documentos por cobrar'><i class='fa fa-balance-scale fa-3x' aria-hidden='true'></i></a>";
          ?> -->



        </center>
        <div class="panel-body datatable-panel">
          <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example">
            <thead>
              <tr>
                <th>#</th>
                <th>Concepto</th>
                <th>Fecha movimiento</th>
                <th>Método de pago</th>
                <th>Monto</th>
                <th>Saldo anterior</th>
                <th>Cargo (+)</th>
                <th>Abono (-)</th>
                <th>Saldo</th>
                <th>Institución emisora</th>
                <th>Agente emisor</th>
                <th>Institución receptora</th>
                <th>Agente receptor</th>
                <th>Tipo comprobante</th>
                <th>Referencia</th>
                <th>U. Marca</th>
                <th>U. Versión</th>
                <th>U. Color</th>
                <th>U. Modelo</th>
                <th>U. VIN</th>
                <th>U. Precio</th>
                <th>U. Estatus</th>
                <th>Archivos</th>
                <th>Comentarios</th>
                <th>Usuario guardo</th>
                <th>Fecha guardado</th>
              </tr>
            </thead>
            <tbody>

              @php
                $contador = 0;
                $saldo_anterior = 0;
                $nuevo_saldo = 0;
              @endphp
              @foreach ($estado_cuenta_proveedores as $Referencia => $EstadosCuenta)


                <tr class='odd gradeX'>
                  <td>{{++$contador}}</td>
                  <td>{!! $EstadosCuenta->EstadosC->first()->concepto !!}</td>
                  <td>{{\Carbon\Carbon::parse($EstadosCuenta->EstadosC->last()->fecha_creacion)->format('d/m/Y')}}</td>
                  <td>
                    @if ($EstadosCuenta->EstadosC->last()->metodo_pago!=null)
                        {{'M-'.$EstadosCuenta->EstadosC->last()->metodo_pago}}
                    @endif
                  </td>
                  <td>
                    @if ($EstadosCuenta->Empalme == null)
                      {{$EstadosCuenta->EstadosC->first()->monto_precio}}
                      @else
                        {{-- <font size=1> --}}
                      <a style="font-size:12px;" name="button" onclick="MostrarEmpalme({{json_encode($EstadosCuenta->EstadosC)}})" data-toggle="modal" data-target="#ModalAbonosEmpalmados">
                        @foreach ($EstadosCuenta->Empalme as $Moned => $Mont)
                            @if ($Mont != 0)
                              {{'$'.number_format($Mont,2)}}
                              @php $letrass = App\Http\Controllers\Admin\TransferController::getNumberToLetters($Mont,'M/A') @endphp
                            @endif
                            {{-- {{$EstadosCuenta->Empalme}} --}}
                        @endforeach
                      </a>
                      ({{$letrass['info']}})
                    {{-- </font> --}}
                    @endif
                  </td>
                  <td>
                    {{-- {{'$'.number_format($EstadosCuenta->EstadosC->first()->saldo_anterior,2)}} --}}
                    {{'$'.number_format($saldo_anterior,2)}}
                    @php
                      if ($EstadosCuenta->EstadosC->first()->cargo!='' && $EstadosCuenta->EstadosC->first()->cargo!=null) {
                        $saldo_anterior+=$EstadosCuenta->EstadosC->sum('cargo');
                      }elseif ($EstadosCuenta->EstadosC->first()->abono!='' && $EstadosCuenta->EstadosC->first()->abono!=null) {
                        $saldo_anterior-=$EstadosCuenta->EstadosC->sum('abono');
                      }
                    @endphp
                  </td>
                  <td>
                    @if (floatval($EstadosCuenta->EstadosC->first()->cargo)!=0)
                      {{'$'.number_format(floatval($EstadosCuenta->EstadosC->first()->cargo),2)}}</td>
                    @endif
                  <td>
                    @if ($EstadosCuenta->Empalme == null)
                      @if (floatval($EstadosCuenta->EstadosC->first()->abono)!=0)
                          {{'$'.number_format(floatval($EstadosCuenta->EstadosC->first()->abono),2)}}
                      @endif

                      @else
                        @foreach ($EstadosCuenta->Empalme as $Moned => $Mont)
                            @if ($Mont != 0)
                              {{'$'.number_format($Mont,2)}}
                            @endif
                        @endforeach
                    @endif
                  </td>

                  <td>
                    {{-- {{'$'.number_format(floatval($EstadosCuenta->EstadosC->last()->saldo),2)}} --}}
                    @php
                    if ($EstadosCuenta->EstadosC->first()->cargo!='' && $EstadosCuenta->EstadosC->first()->cargo!=null) {
                      $nuevo_saldo+=$EstadosCuenta->EstadosC->sum('cargo');
                    }elseif ($EstadosCuenta->EstadosC->first()->abono!='' && $EstadosCuenta->EstadosC->first()->abono!=null) {
                      $nuevo_saldo-=$EstadosCuenta->EstadosC->sum('abono');
                    }
                    @endphp
                    {{'$'.number_format(floatval($nuevo_saldo),2)}}
                  </td>
                  <td>{{$EstadosCuenta->EstadosC->last()->emisora_institucion}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->emisora_agente}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->receptora_institucion}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->receptora_agente}}</td>
                  <td>{!! $EstadosCuenta->EstadosC->last()->tipo_comprobante !!}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->referencia}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->datos_marca}}</td>

                  <td>{{$EstadosCuenta->EstadosC->last()->datos_version}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->datos_color}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->datos_modelo}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->datos_vin}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->datos_precio}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->datos_estatus}}</td>
                  <td>{!! $EstadosCuenta->EstadosC->last()->archivo !!}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->comentarios}}</td>
                  <td>{{$EstadosCuenta->EstadosC->last()->Nombre_UsuarioC}}</td>
                  <td>{{\Carbon\Carbon::parse($EstadosCuenta->EstadosC->last()->fecha_guardado)->format('d/m/Y')}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->

      </div>
      <!-- Fin | ibox-content -->
    </div>
  </div>
</div>
<!-- fin | row -->



</div>
</div>
</div>


<script>

  function MostrarEmpalme(EstadosCuenta){

    $("#TablaAbonosEmpalmados").dataTable().fnDestroy();
    $('#BodyTablaAbonosEmpalmados').html('');

    EstadosCuenta.forEach(function logArrayElements(element, index, array) {
      console.log(element.col5);
      if (element.col5 == null) {
        $('#BodyTablaAbonosEmpalmados').append(`
          <tr>
          <td>`+(index+1)+`</td>
          <td>`+element.abono+`</td>
          <td>`+element.datos_marca+`</td>
          <td>`+element.datos_version+`</td>
          <td>`+element.datos_color+`</td>
          <td>`+element.datos_modelo+`</td>
          <td>`+element.datos_vin+`</td>
          <td>`+element.datos_estatus+`</td>
          </tr>
          `);
      }else{
        $('#BodyTablaAbonosEmpalmados').append(`
          <tr>
          <td>`+(index+1)+`</td>
          <td>`+element.abono+`</td>
          <td>`+element.col5+`</td>
          <td>`+element.col5+`</td>
          <td>`+element.col5+`</td>
          <td>`+element.col5+`</td>
          <td>`+element.col5+`</td>
          <td>`+element.col5+`</td>
          </tr>
          `);
      }

    });

    CrearDataT('TablaAbonosEmpalmados');
    console.log(EstadosCuenta)
  }

  function filterme() {
    //build a regex filter string with an or(|) condition
    var types = $('input:checkbox[name="ases"]:checked').map(function() {
      return '^' + this.value + '\$';
    }).get().join('|');
    //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
    $('#dataTables-example').dataTable().fnFilter(types, 1, true, false, false, false);

  }

</script>


<script type="text/javascript">
    function confirmar(url){
      var txt;
      var person = prompt("Comentarios:", txt);

      if(!confirm("¿Estás seguro de eliminar este registro?")){
        return person;

      }else
      txt = person;
      document.location = url+"&comentarios="+txt;
      return true;


      {

      }
    }
</script>

<script>

$(document).ready(function() {
  $("#estado_cuenta_interno").click(function() {

    if ($("#lat_l").val() == "") {
      alert("Activa tu Ubicación");
      reg = false;
    }
    if ($("#lat_l").val() != "") {
      var lat_long = $("#lat_l").val();



      var pss = prompt("Por Favor Ingresa Tu Contraseña: ", "");

      var pss = Base64.encode(pss);
      var bb = Base64.decode(pss);
      //console.log(pss);


      if (pss != "" && pss=="QE1QQioxOQ==" || pss != "" && pss=="QDE5Kk1BTU0=" || pss != "" && pss=="QUNMKjE5" || pss != "" && pss=="QEFBQlMqMjAxOQ==") {
        $("#pass").val(pss);
        reg=true;

      }else{
        alert("Permiso Denegado");
        reg=false;
      }

    }
    return reg;


  });

});

</script>

<script>

$(document).ready(function() {
  $("#estado_cuenta_cliente").click(function() {

    if ($("#lat_l1").val() == "") {
      alert("Activa tu Ubicación");
      reg = false;
    }
    if ($("#lat_l1").val() != "") {
      var lat_long = $("#lat_l1").val();



      var pss = prompt("Por Favor Ingresa Tu Contraseña: ", "");

      var pss = Base64.encode(pss);
      console.log(pss);


      if (pss != "" && pss=="QE1QQioxOQ==" || pss != "" && pss=="QDE5Kk1BTU0=" || pss != "" && pss=="QUNMKjE5" || pss != "" && pss=="QEFBQlMqMjAxOQ==") {
        $("#pass1").val(pss);
        reg=true;

      }else{
        alert("Permiso Denegado");
        reg=false;
      }

    }
    return reg;


  });

});

</script>

<script>/**
*
*  Base64 encode / decode
*  http://www.webtoolkit.info/
*
**/

var Base64 = {

  // private property
  _keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

  // public method for encoding
  encode : function (input) {
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;

    input = Base64._utf8_encode(input);

    while (i < input.length) {

      chr1 = input.charCodeAt(i++);
      chr2 = input.charCodeAt(i++);
      chr3 = input.charCodeAt(i++);

      enc1 = chr1 >> 2;
      enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
      enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
      enc4 = chr3 & 63;

      if (isNaN(chr2)) {
        enc3 = enc4 = 64;
      } else if (isNaN(chr3)) {
        enc4 = 64;
      }

      output = output +
      this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
      this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

    }

    return output;
  },

  // public method for decoding
  decode : function (input) {
    var output = "";
    var chr1, chr2, chr3;
    var enc1, enc2, enc3, enc4;
    var i = 0;

    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

    while (i < input.length) {

      enc1 = this._keyStr.indexOf(input.charAt(i++));
      enc2 = this._keyStr.indexOf(input.charAt(i++));
      enc3 = this._keyStr.indexOf(input.charAt(i++));
      enc4 = this._keyStr.indexOf(input.charAt(i++));

      chr1 = (enc1 << 2) | (enc2 >> 4);
      chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
      chr3 = ((enc3 & 3) << 6) | enc4;

      output = output + String.fromCharCode(chr1);

      if (enc3 != 64) {
        output = output + String.fromCharCode(chr2);
      }
      if (enc4 != 64) {
        output = output + String.fromCharCode(chr3);
      }

    }

    output = Base64._utf8_decode(output);

    return output;

  },

  // private method for UTF-8 encoding
  _utf8_encode : function (string) {
    string = string.replace(/\r\n/g,"\n");
    var utftext = "";

    for (var n = 0; n < string.length; n++) {

      var c = string.charCodeAt(n);

      if (c < 128) {
        utftext += String.fromCharCode(c);
      }
      else if((c > 127) && (c < 2048)) {
        utftext += String.fromCharCode((c >> 6) | 192);
        utftext += String.fromCharCode((c & 63) | 128);
      }
      else {
        utftext += String.fromCharCode((c >> 12) | 224);
        utftext += String.fromCharCode(((c >> 6) & 63) | 128);
        utftext += String.fromCharCode((c & 63) | 128);
      }

    }

    return utftext;
  },

  // private method for UTF-8 decoding
  _utf8_decode : function (utftext) {
    var string = "";
    var i = 0;
    var c = c1 = c2 = 0;

    while ( i < utftext.length ) {

      c = utftext.charCodeAt(i);

      if (c < 128) {
        string += String.fromCharCode(c);
        i++;
      }
      else if((c > 191) && (c < 224)) {
        c2 = utftext.charCodeAt(i+1);
        string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
        i += 2;
      }
      else {
        c2 = utftext.charCodeAt(i+1);
        c3 = utftext.charCodeAt(i+2);
        string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
        i += 3;
      }

    }

    return string;
  }

}</script>





<!-- Modal -->
<div class="modal fade" id="ModalEstadoCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Reporte ejecutivo mensual</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @php $date_time=(new \Datetime(now()))->format('Y-m-d');@endphp
    <form id="reporte_ejecutivo_mensual" name="reporte_ejecutivo_mensual" enctype="multipart/form-data" method="get" action="{{route('reportExecutive.reportExecutive')}}" class="needs-validation ">
        @csrf
        <div class="modal-body" id="ModalBody">
            <div class="row">
                <div class="col-md-6" style="position: relative;top: -8px;">
                    <label>Fecha inicial:</label>
                    <input type="date" name="fecha_inicial" value="" class="form-control" required>
                </div>
                <div class="col-md-6" style="position: relative;top: -8px;">
                    <label>Fecha final:</label>
                    <input type="date" name="fecha_final" value="{{$date_time}}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" >Enviar</button>
        </div>
    </form>
  </div>
</div>
</div>

@endsection
