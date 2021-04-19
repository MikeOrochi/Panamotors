@extends('layouts.appAdmin')
@section('titulo', 'CCP | Resumen pagos unidad')
@section('content')

<div id="wrapper">
  <div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-12">
      <center>
          <h2>
            @if(!empty($nombre_completo)){{$nombre_completo}}@else N/A @endif<br>@if(!empty($folio)){{$folio.'-'.$folio_anterior}}@else N/A @endif
          </h2>

          <i class="fa fa-car fa-3x" aria-hidden="true"></i>
          <h5 style="font-size: 12px;">
            @if(!empty($nombre_unidad)){{$nombre_unidad}}@else N/A @endif<br>@if(!empty($precio_general))${{$precio_general}}@else N/A @endif
          </h5>

          <h4 style="font-size: 14px;">
            @if(!empty($vin_unidad)){{$vin_unidad}}@else N/A @endif
          </h4>
      </center>
    </div>
  </div>

  <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Resumen de abonos para unidad</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
              <center>

                @php
                  date_default_timezone_set('America/Mexico_City');
                  $fechainicio= date("Y-m-d H:i:s");
                  $fecha=base64_encode($fechainicio);
                @endphp

                @if ($estatus_unidad=="Pendiente")
                  <div class="row text-center">

                    <a class="col" href='{{route('account.abono_unidad.show',[
                      'idcontacto'  => base64_encode($c10),
                      'idmovmiento' => base64_encode($idEC)
                    ])}}' title='Abonar a Unidad'><i class='fa fa-money fa-4x' aria-hidden='true'></i></a>

                    {{-- <a class="col" href='{{route('account.summary.pagare',[
                      'idcontacto'  => base64_encode($c10),
                      'idmovmiento' => base64_encode($idEC)
                    ])}}' title='Cargar Documentos por Cobrar'><i class='fa fa-archive fa-4x' aria-hidden='true'></i></a> --}}

                    @if ($concepto_general=="Devolución del VIN")
                      <a class="col" href='traspasos_proveedor2.php?idp={{$c10}}&f={{$fecha}}&m={{$idEC}}' title='Agregar Traspaso'><i class='fas fa-exchange-alt fa-4x' aria-hidden='true'></i></a>
                    @endif
                  </div>
                @endif

              </center>

              <div class="panel-body datatable-panel">
                <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Concepto</th>
                          <th>Saldo anterior</th>
                          <th>Monto</th>
                          <th>Saldo</th>

                          <th>Serie monto</th>
                          <th>Total abono</th>

                          <th>Fecha movimiento</th>
                          <th>Método de pago</th>
                          <th>Institución emisora</th>
                          <th>Agente emisor</th>
                          <th>Institución receptora</th>
                          <th>Agente receptor</th>
                          <th>Tipo comprobante</th>
                          <th>Referencia</th>

                           <!--<th>U. Marca</th>
                          <th>U. Versión</th>
                          <th>U. Color</th>
                          <th>U. Modelo</th>
                         <th>U. VIN</th>-->

                          <th>Archivo</th>
                          <th>Comentarios</th>
                          <th>Usuario guardo</th>
                          <th>Fecha guardado</th>

                      </tr>
                  </thead>

                  <tbody>
                    @foreach ($AbonosUP as $key => $AUP)
                    <tr class="odd gradeX">
                      <td>{{$key+1}}</td>
                      <td>@if(!empty($AUP->concepto)){{$AUP->concepto}}@else N/A @endif</td>
                      <td>@if(!empty($AUP->saldo_anterior))$ {{$AUP->saldo_anterior}}@else N/A @endif</td>
                      <td>$ {{$AUP->monto_precio_formato}}<br> ({{$AUP->saldo_letras}})</td>
                      <td>$ {{$AUP->saldo_actual}}</td>
                      <td>{{$AUP->serie_monto}}</td>
                      <td>$ {{$AUP->monto_total_general}}</td>
                      <td>{{$AUP->fecha_pago}}</td>
                      <td>{{$AUP->metodo_pago}}</td>
                      <td>{{$AUP->emisora_institucion}}</td>
                      <td>{{$AUP->emisora_agente}}</td>
                      <td>{{$AUP->receptora_institucion}}</td>
                      <td>{{$AUP->receptora_agente}}</td>
                      <td>{{ $AUP->tipo_comprobante}}{{!!$AUP->link_recibo_automatico!!}}</td>
                      <td>{{$AUP->referencia}}</td>
                      <td>{{!! $AUP->link_archivos !!}}</td>
                      <td>{{$AUP->comentarios}}</td>
                      <td>{{$AUP->usuario_creador}}</td>
                      <td>{{$AUP->fecha_guardado}}</td>
                    </tr>
                    @endforeach
                  </tbody>

                </table>
              </div>


            </div>
          </div>
        </div>
    </div>
  </div>


</div>
@endsection
