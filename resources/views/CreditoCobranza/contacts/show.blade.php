
@php use App\Http\Controllers\CreditoCobranza\ContactController;
use App\Models\estado_cuenta;
@endphp
@extends('layouts.appAdmin')
@section('titulo', 'Detalles del cliente')
@section('content')
  <style>
  input:focus.error, select:focus.error{
    border: 1px solid red;
  }
  .card-perfil{
    height: 750px;
  }
  .card-front .content-id{
    padding: 10px;
  }
  .card-front .content-img img{
    width: 200px;
    height: 200px;
  }
  @media (max-width: 479px){
    .card-front .content-nombre h1{
      font-size: 20px;
    }
    .card-perfil{
      height: 800px;
    }
  }
  </style>
  {{-- <div class="container-fluid">
  <div class="col-sm-9 col-xs-12 content pt-3 pl-0">
  <div class="row mt-3"> --}}
  <div class="col-sm-12">
    <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
      <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
      <span class="text-secondary"> Clientes Detalles</span>
      <br>
      <br>
      <div class="row">
        <div class="col-sm-12 d-flex justify-content-center">
          <div class="card-perfil">
            <div class="card-front" id="card-front">
              <div class="content-id">
                <h2>{{$contacto->idcontacto}}</h2>
              </div>
              <div class="content-img">
                {!!$contacto->foto_perfil != "NO" ? "<img alt='image' class='img-circle' src=../../storage/app/$contacto->foto_perfil>" : "<img alt='image' class='img-circle' src='https://www.panamotorscenter.com/Des/CCP/img/avatar_hombre.png'>"!!}
              </div>
              <div class="content-nombre">
                <h1>{{$contacto->nombre.' '.$contacto->apellidos}}</h1>
              </div>
              <div class="content-direccion">
                <p>{{$contacto->estado}}, <span>{{$contacto->delmuni}}</span></p>
              </div>
              {{$contacto->fecha_nacimiento === '0001-01-01' || $contacto->fecha_nacimiento  === '' ? "Sin fecha de nacimiento" : '<i class="fas fa-birthday-cake fa-2x"></i>&nbsp;&nbsp'.date_format(date_create($contacto->fecha_nacimiento ), 'd-m-Y')}}
              <div class="content-telefono">
                <div class="celular">
                  <p>Celular</p>
                  <p>{!! $contacto->telefono_celular != "" ? "<a title='Llamar' href='tel:+52$contacto->telefono_celular'><i class='fa fa-mobile' aria-hidden='true'></i></a> $contacto->telefono_celular" : "<i class='far fa-times-circle' style='color: red;'></i>"!!}</p>
                </div>
                <div class="fijo mt-4">
                  <p>Teléfono Fijo</p>
                  <p>{!! $contacto->telefono_otro != "" ? "<a title='Llamar' href='tel:+52$contacto->telefono_otro'><i class='fa fa-phone' aria-hidden='true'></i></a> $contacto->telefono_otro" : "<i class='far fa-times-circle' style='color: red;'></i>" !!}</p>
                </div>
              </div>
              <div class="content-btnCard">
                <a class="btnCard" id="btnVer">Ver Más</a>
              </div>
              <div class="content-btnCard">
                <a class="btnCard" data-toggle="modal" data-target="#modal_editar_contacto">Editar</a>
              </div>
              <br>
            </div>
            <div class="card-back" id="card-back">
              <div class="dato">
                <h1 class="mb-4">Datos Personales</h1>
                <div class="des-dato">
                  <p><strong>Alias</strong></p>
                  <p>{!! $contacto->alias != "" ? $contacto->alias : "<i class='far fa-times-circle' style='color: red;'></i>" !!}
                  </div>
                  <div class="des-dato">
                    <p><strong>RFC</strong></p>
                    <p>{!! $contacto->rfc != "" ? "$contacto->rfc" : "<i class='far fa-times-circle' style='color: red;'></i>" !!} </p>
                  </div>
                  <div class="des-dato">
                    <p><strong>E-mail </strong></p>
                    <p>{!! $contacto->email != "" ? "<a title='Redactar' href='mailto:$contacto->email'><i class='fa fa-envelope-o' aria-hidden='true'></i></a> $contacto->email" : "<i class='far fa-times-circle' style='color: red;'></i>" !!} </p>
                  </div>
                  <div class="des-dato">
                    <p><strong>Celular</strong></p>
                    <p>{!! $contacto->telefono_celular != "" ? "<a title='Llamar' href='tel:+52$contacto->telefono_celular'><i class='fa fa-mobile' aria-hidden='true'></i></a> $contacto->telefono_celular" : "<i class='far fa-times-circle' style='color: red;'></i>" !!} </p>
                  </div>
                  <div class="des-dato">
                    <p><strong>Teléfono Fijo</strong></p>
                    <p>{!! $contacto->telefono_otro != "" ? "<a title='Llamar' href='tel:+52$contacto->telefono_otro'><i class='fa fa-phone' aria-hidden='true'></i></a> $contacto->telefono_otro" : "<i class='far fa-times-circle' style='color: red;'></i>" !!} </p>
                  </div>
                </div>
                <div class="dato">
                  <h1 class="mb-4">Dirección</h1>
                  <div class="des-dato">
                    <p><strong>Estado</strong></p>
                    <p>{!! $contacto->estado != "" ? $contacto->estado : "<i class='far fa-times-circle' style='color: red;'></i>" !!}</p>
                  </div>
                  <div class="des-dato">
                    <p><strong>Delegación</strong></p>
                    <p>{!! $contacto->delmuni != "" ? $contacto->delmuni : "<i class='far fa-times-circle' style='color: red;'></i>" !!}</p>

                  </div>
                  <div class="des-dato">
                    <p><strong>Código Postal</strong></p>
                    <p>{!! $contacto->codigo_postal != "" ? $contacto->codigo_postal : "<i class='far fa-times-circle' style='color: red;'></i>" !!}</p>
                  </div>
                  <div class="des-dato">
                    <p><strong>Colonia/Zona</strong></p>
                    <p>{!! $contacto->colonia != "" ? $contacto->colonia : "<i class='far fa-times-circle' style='color: red;'></i>" !!}</p>
                  </div>
                  <div class="des-dato">
                    <p><strong>Calle y Número</strong></p>
                    <p>{!! $contacto->calle != "" ? $contacto->calle : "<i class='far fa-times-circle' style='color: red;'></i>" !!}</p>
                  </div>
                </div>
                <div class="content-btnCard">
                  <a class="btnCard" id="btnRegresar">Regresar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="hr-line-dashed"></div>
          {!! $contacto->referencia_nombre == NULL ? "" : '<p><font size=3><b>Referencias Cliente</b></font></p><font size=2><b>Referencia 1</b></font>' !!}
          <div id="referencia1">
            <div class="table-responsive">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td>Nombre</td>
                    <td colspan="3"><b>{!!$contacto->referencia_nombre == NULL ? '<i class="far fa-times-circle" style="color: red;"></i>' : $contacto->referencia_nombre!!}</b></td>
                  </tr>
                  <tr>
                    <td>Teléfono Celular</td>
                    <td><b>{!!$contacto->telefono_celular == NULL ? '<i class="far fa-times-circle" style="color: red;"></i>' : $contacto->telefono_celular!!}</b></td>
                    <td>Teléfono Fijo</td>
                    <td><b>{!!$contacto->telefono_otro == NULL ? '<i class="far fa-times-circle" style="color: red;"></i>' : $contacto->telefono_otro!!}</b></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          @if ($contacto->referencia_nombre2 != NULL)
            <font size=2><b>Referencia 2 </b></font>
          @endif
          <div id="referencia2">
            <div class="table-responsive">
              <table class="table table-striped">
                <tbody>
                  <?php if($contacto->referencia_nombre2 == NULL){
                  } else {
                    ?>
                    <tr>
                      <td>2.- Nombre</td>
                      <td colspan="3"><b><?php echo $contacto->referencia_nombre2; ?></b></td>
                    </tr>
                    <tr>
                      <td>2.- Teléfono Celular</td>
                      <td><b><?php echo $contacto->referencia_nombre2; ?></b></td>
                      <td>2.- Teléfono Fijo</td>
                      <td><b><?php echo $contacto->referencia_nombre2; ?></b></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="container-fluid">
            <?php
            if($contacto->referencia_nombre3 == NULL){
              ?>
              <?php
            } else {
              ?>
              <h4 class="m-t-none m-b">Referencia 3</h4>
              <?php } ?>
              <div id="referencia3">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <tbody>
                      <?php if($contacto->referencia_nombre3 == NULL){
                      } else {
                        ?>
                        <tr>
                          <td>3.- Nombre</td>
                          <td colspan="3"><b><?php echo $contacto->referencia_nombre3; ?></b></td>
                        </tr>
                        <tr>
                          <td>3.- Teléfono Celular</td>
                          <td><b><?php echo $contacto->referencia_celular3; ?></b></td>
                          <td>3.- Teléfono Fijo</td>
                          <td><b><?php echo $contacto->referencia_fijo3; ?></b></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="sec-datos">
                </div>
                <h3 class="m-t-none m-b">Estado de cuenta</h3>
                <div class="panel-body datatable-panel">
                  <center>
                    <a href='{{route('CreditoCobranza.state_account.show',Crypt::encrypt($contacto->idcontacto))}}' title='Estado de Cuenta'><i class='fa fa-file-text-o fa-4x' aria-hidden='true'></i></a>
                  </center>
                  <div><h3 class="m-t-none m-b">Resumen Crediticio</h3>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td>Saldo</td>
                          <td colspan="3"><b><?php
                          if (strlen($saldo_total) < 1) {
                            echo "$ ".$saldo_total = '0.00';
                          } else {
                            echo "$ ".$saldo_total;
                          }
                          ?></b></td>
                        </tr>
                        <tr>
                          <td>Último Abono</td>
                          <td><b><?php echo "$ ".number_format($ultimo_mov, 2); ?></b></td>
                          <td>Fecha Último Abono</td>
                          <td><b><?php echo $ultimo_mov_fecha; ?></b></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="container-fluid">
                <div class="sec-datos">
                </div>
                <h3 class="m-t-none m-b">Estado de cuenta PF</h3>
                <div class="panel-body datatable-panel">
                  <center>
                    <?php
                    echo "<a href='estado_cuenta_fondeo_pf.php?idc=$contacto->idcontacto' title='Estado de Cuenta Fondeo PF'><i class='fa fa-usd fa-4x' aria-hidden='true'></i></a>";
                    ?>
                  </center>
                  <br>
                </div>
              </div>
              <div class="container-fluid">
                <div class="sec-datos">
                </div>
                <h3 class="m-t-none m-b">Saldo Vencido</h3>
                <div class="panel-body datatable-panel">
                  <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-examplex3">
                    <thead>
                      <tr>
                        <th>VIN</th>
                        <th>Serie</th>
                        <th>Fecha de vencimiento</th>
                        <th>Dias transcurridos</th>
                        <th>Monto</th>
                        <th>Saldo</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if (!empty($pagares))
                        @foreach ($pagares as $pagare)
                          <tr>

                            <td>
                              Marca: {{$pagare->datos_marca}}</br>
                              Version: {{$pagare->datos_version}}</br>
                              Modelo: {{$pagare->datos_modelo}}
                              Color: {{$pagare->datos_color}}
                              <b>VIN: {{$pagare->datos_vin}}</b>
                            </td>
                            <td>{{$pagare->num_pagare}}</td>
                            <td>{{\Carbon\Carbon::parse($pagare->fecha_vencimiento)->format('d-m-Y')}}</td>
                            <td>{{ContactController::get_date_format($pagare->fecha_vencimiento)}}</td>
                            <td>{{number_format($pagare->monto,2,'.',',')}}</td>
                            <td>{{number_format($pagare->monto-ContactController::getPagareSaldo($pagare->iddocumentos_cobrar),2,'.',',')}}</td>
                          </tr>
                        @endforeach
                      @endif
                    </tbody>
                    <h5 style="color: red;">Saldo Vencido: $ {{ number_format($saldo_vencido, 2,'.',',')}}</h5>
                  </table>
                </div>
              </div>
              <div class="container-fluid">
                <div class="sec-datos">
                </div>
                <h3 class="m-t-none m-b">Historial del VIN</h3>
                <div class="panel-body datatable-panel">
                  <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-examplex4">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Tipo de Transaccion</th>
                        <th>VIN</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Versión</th>
                        <th>Color</th>
                        <th>Precio</th>
                        <th>Fecha Movimiento</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($estados_cuenta as $count => $estado_cuenta)
                        <tr class='odd gradeX'>
                          <td>{{$count+1}}</td>
                          <td>{{$estado_cuenta->concepto}}</td>
                          <td>{{$estado_cuenta->datos_vin}}</td>
                          <td>{{$estado_cuenta->datos_marca}}</td>
                          <td>{{$estado_cuenta->datos_modelo}}</td>
                          <td>{{$estado_cuenta->datos_version}}</td>
                          <td>{{$estado_cuenta->datos_color}}</td>
                          <td>{{$estado_cuenta->datos_precio}}</td>
                          <td>{{\Carbon\Carbon::parse($estado_cuenta->fecha_guardado)->format('d-m-Y')}}</td>
                        </tr>
                      @endforeach
                    </tbody >
                  </table>
                </div>
              </div>
              <div class="container-fluid">
                <div class="sec-datos">
                </div>
                <h3 class="m-t-none m-b">Resumen de Ventas: {{$contacto->nombre}} {{$contacto->apellidos}}</h3>
                <div class="panel-body datatable-panel table-responsive">
                  <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example_resumen">
                    <thead>
                      <tr>
                        <th>Mes</th>
                        <th>VIN</th>
                        <th>Ventas</th>
                        <th>Abonos</th>
                        <th style="display:none;">Saldo</th>
                        <th>Movimientos</th>
                        <th>Abonos Por Metodo de Pago</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($estados_cuenta_resumen as $key => $estado_cuenta_resumen)
                        <tr>
                          <td>{{$key}}</td>
                          <td>
                            @php $resumenes = $estado_cuenta_resumen->where('tipo_movimiento', 'cargo') @endphp
                            @if ($resumenes->count()>0)
                              @foreach ($resumenes as $resumen)
                                <b> VIN:    {{$resumen->datos_vin}}</b><br>
                                Marca:  {{$resumen->datos_marca}}<br>
                                Versión:{{$resumen->datos_version}}<br>
                                Color:  {{$resumen->datos_color}}<br>
                                Modelo: {{$resumen->datos_modelo}}<br>
                              @endforeach
                            @endif
                          </td>
                          <td>${{number_format($estado_cuenta_resumen->where('tipo_movimiento', 'cargo')->sum('monto_precio'),2,'.',',') }}</td>
                          <td>${{number_format($estado_cuenta_resumen->where('tipo_movimiento', 'abono')->sum('monto_precio'),2,'.',',') }}</td>
                          <td>
                            @php
                            $count = $estado_cuenta_resumen->where('tipo_movimiento', 'abono')->count();
                            $met_pago = '';
                            @endphp
                            @foreach ($estado_cuenta_resumen as $k => $resumen)
                              @if ($resumen->tipo_movimiento=='abono')
                                @if ($resumen->concepto=='Abono')@php $met_pago = 'M' @endphp
                                @elseif ($resumen->concepto=='Compra Permuta')@php $met_pago = 'CP' @endphp
                                @else @php $met_pago = 'M' @endphp @endif
                                  <b>{{$met_pago.$resumen->metodo_pago}}</b> {{$resumen->concepto}}<br>
                                  $ {{$resumen->monto_precio}}<br>
                                  {{-- {{$resumen->referencia}} --}}
                                  @if ($count>$k) <hr> @endif
                                  @endif
                                @endforeach
                              </td>
                              <td>
                                @php
                                $count = $estado_cuenta_resumen->where('tipo_movimiento', 'abono')->count();
                                $m1 = ['met_pago'=>'M1','total'=>0];
                                $m3 = ['met_pago'=>'M3','total'=>0];
                                $m6 = ['met_pago'=>'M6','total'=>0];
                                $cp = ['met_pago'=>'CP','total'=>0];
                                @endphp
                                @foreach ($estado_cuenta_resumen as $k => $resumen)
                                  @if ($resumen->tipo_movimiento=='abono')
                                    @if ($resumen->concepto=='Abono' || $resumen->concepto=='Enganche')
                                      @if ($resumen->metodo_pago==1)
                                        @php $m1['total'] = $m1['total']+$resumen->monto_precio; @endphp
                                      @elseif ($resumen->metodo_pago==3)
                                        @php $m3['total'] = $m3['total']+$resumen->monto_precio; @endphp
                                      @elseif ($resumen->metodo_pago==6)
                                        @php $m6['total'] = $m6['total']+$resumen->monto_precio; @endphp
                                      @endif
                                    @elseif ($resumen->concepto=='Compra Permuta')
                                      @php $cp['total'] = $cp['total']+$resumen->monto_precio; @endphp
                                    @endif
                                  @endif
                                @endforeach
                                @if ($m1['total']!=0)
                                  <b>{{$m1['met_pago']}}</b><br>
                                  {{number_format($m1['total'],2,'.',',')}}<br>
                                  @if ($m3['total']!=0||$m6['total']!=0||$cp['total']!=0) <hr> @endif
                                  @endif
                                  @if ($m3['total']!=0)
                                    <b>{{$m3['met_pago']}}</b><br>
                                    {{number_format($m3['total'],2,'.',',')}}<br>
                                    @if ($m6['total']!=0||$cp['total']!=0) <hr> @endif
                                    @endif
                                    @if ($m6['total']!=0)
                                      <b>{{$m6['met_pago']}}</b><br>
                                      {{number_format($m6['total'],2,'.',',')}}<br>
                                      @if ($cp['total']!=0) <hr> @endif
                                      @endif
                                      @if ($cp['total']!=0)
                                        <b>{{$cp['met_pago']}}</b><br>
                                        {{number_format($cp['total'],2,'.',',')}}<br>
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                            @php
                            $saldo=0;
                            $count = $estados_cuenta_resumen->count();
                            $cargos = 0;
                            $abonos = 0;
                            $m1 = ['met_pago'=>'M1','total'=>0];
                            $m3 = ['met_pago'=>'M3','total'=>0];
                            $m6 = ['met_pago'=>'M6','total'=>0];
                            $cp = ['met_pago'=>'CP','total'=>0];
                            @endphp
                            @foreach ($estados_cuenta_resumen as $resumen)
                              @php
                              $cargos = $cargos+$resumen->where('tipo_movimiento', 'cargo')->sum('monto_precio');
                              $abonos = $abonos+$resumen->where('tipo_movimiento', 'abono')->sum('monto_precio');
                              $saldo = $saldo+$resumen->where('tipo_movimiento', 'cargo')->sum('monto_precio');
                              $saldo = $saldo-$resumen->where('tipo_movimiento', 'abono')->sum('monto_precio');
                              foreach ($resumen as $res) {
                                if ($res->concepto=='Abono' || $res->concepto=='Enganche'){
                                  if ($res->metodo_pago==1) { $m1['total'] = $m1['total']+$res->monto_precio; }
                                  elseif ($res->metodo_pago==3) {$m3['total'] = $m3['total']+$res->monto_precio; }
                                  elseif ($res->metodo_pago==6) {$m6['total'] = $m6['total']+$res->monto_precio; }
                                } elseif ($res->concepto=='Compra Permuta') {$cp['total'] = $cp['total']+$res->monto_precio; }

                              }
                              @endphp
                              {{-- {{$resumen}} --}}
                            @endforeach
                            @php $movimientos = [$m1,$m3,$m6,$cp] @endphp
                            <div style="width:100%; padding:3px; text-align: center;">
                              <div style="width:50%;  float:left;">
                                <label for="">Saldo: </label>&nbsp;&nbsp; ${{ number_format($saldo,2,'.',',') }} <br>
                                <label for="">Ventas Promedio: </label>&nbsp;&nbsp; $
                                @php
                                  try { echo number_format($cargos/$count,2,'.',',');
                                  } catch (\Exception $e) { echo number_format(0,2,'.',','); }
                                @endphp
                                <br>
                                <label for="">Abonos Promedio:</label>&nbsp;&nbsp; $
                                @php
                                  try { echo number_format($abonos/$count,2,'.',',');
                                  } catch (\Exception $e) { echo number_format(0,2,'.',','); }
                                @endphp
                                <label for="">Fecha Ultimo Abono:</label>&nbsp;&nbsp;
                                @if (!empty($resumen))
                                  {{\Carbon\Carbon::parse($resumen->where('tipo_movimiento', 'abono')->last()->fecha_movimiento)->format('d-m-Y')}} <br>
                                @endif
                                <input type="hidden" name="total_de" id="total_de" value="<?php //$total_deuda = base64_encode($toti); echo $total_deuda; ?>">
                                <label for="">Meses Activo: </label>&nbsp;&nbsp;
                                {{$count}} @if($count>1) meses @else mes @endif
                                </div>
                                <div style="width:50%;  float:right;">
                                  @foreach ($movimientos as $movimiento)
                                    @if ($movimiento['total']>0)
                                      Suma {{$movimiento['met_pago']}}: ${{number_format($movimiento['total'],2,'.',',')}}<br>
                                    @endif
                                  @endforeach
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="container-fluid">
                            <div class="sec-datos">
                            </div>
                            <h3 class="m-t-none m-b">Documentos por Cobrar</h3>
                            <div class="panel-body datatable-panel table-responsive">
                              <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-examplex5">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Datos VIN</th>
                                    <th>Descripción</th>
                                    <th>Número Pagaré</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Tipo</th>
                                    <th>Estatus</th>
                                    <th>Archivo Original</th>
                                    <th>Monto</th>
                                    <th>Monto Restante</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($pagares_vencidos as $key => $pagare_vencido)
                                    <tr>
                                      <td>{{$key+1}}</td>
                                      <td>{{$pagare_vencido->datos_vin}}</td>
                                      <td>
                                        <b>Marca: </b>  {{$pagare_vencido->datos_marca}}
                                        <b>Versión: </b>{{$pagare_vencido->datos_version}}
                                        <b>Color: </b>  {{$pagare_vencido->datos_color}}
                                        <b>Módelo: </b> {{$pagare_vencido->datos_modelo}}
                                      </td>
                                      <td>{{$pagare_vencido->num_pagare}}</td>
                                      <td>{{$pagare_vencido->fecha_vencimiento}}</td>
                                      <td>{{$pagare_vencido->tipo}}</td>
                                      <td>{{$pagare_vencido->estatus}}</td>
                                      <td>
                                        <a href="{{asset($pagare_vencido->archivo_original)}}">
                                          <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        </a>
                                      </td>
                                      <td>${{number_format($pagare_vencido->monto,2,'.',',')}}</td>
                                      <td>${{ContactController::saldoDocumentosCobrar($pagare_vencido->iddocumentos_cobrar, $pagare_vencido->monto)}}</td>
                                    </tr>
                                  @endforeach

                                </tbody>

                              </table>
                              {{-- Monto Letra: <input type="text" class="form-control" id="letra" name="letra" required readonly> --}}
                            </div>
                          </div>
                          <div class="container-fluid">
                            <div class="sec-datos">
                            </div>
                            <h3 class="m-t-none m-b">Documentos Cliente/ID <a data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">&nbsp;&nbsp;<i class="fa fa-plus"></i> </a></h3>
                            <div class="collapse" id="collapseExample1">
                              <div class="card card-body">
                                <form name="formulario" id="formulario" action="guardar_documentos_contacto.php" method="POST" enctype="multipart/form-data">
                                  <?php
                                  date_default_timezone_set('America/Mexico_City');
                                  $fe= date("Y-m-d H:i:s");
                                  $f=base64_encode($fe);

                                  ?>


                                  <div class="col-lg-12">
                                    <div class="row">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>*Documentos</label>
                                          <select name="tipo" class="form-control" required>
                                            @foreach ($catalogo_documentos_contacto as $catalogo_documento_contacto)
                                              <option value="{{$catalogo_documento_contacto->nombre}}">{{$catalogo_documento_contacto->idcatalogo_documentos_contacto}} - {{$catalogo_documento_contacto->nombre}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>*Descripción</label>
                                          <input type="text" name="descripcion" required="" class="form-control">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-lg-12">
                                    <div class="row">
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>*Imagen</label>
                                          <input type="file" name="uploadedfile" required="" class="form-control"><br>
                                          <input type="hidden" name="idcontacto" required="" class="form-control" value="<?php// echo $idc_get; ?>">
                                          <input type="hidden" name="f" required="" class="form-control" value="<?php// echo $f; ?>">
                                        </div>
                                      </div>
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>*Verificado &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" class="form-check-input" id="verificado" name="verificado" onclick="verificado_fun();"></label><br>

                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-lg-12">
                                    <div class="row">
                                      <div class="col-lg-12">
                                        <div class="form-group">
                                          <div class="" id="validacion_archivo" style="display: none;">
                                            <label>Evidencia Verificado</label>
                                            <input type="file" name="uploadedfile_evidencia_verificacion" class="form-control"><br>
                                          </div>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                  <center>
                                    <button class="btn btn-lg btn-primary " id="enviar" type="submit">Guardar</button>
                                  </center>
                                </form>
                              </div>
                            </div>
                            <div class="panel-body datatable-panel">
                              <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example30x">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Documento</th>
                                    <th>Descripcion</th>
                                    <th>Validacion Usuario</th>
                                    <th>Check</th>

                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($contactos_documentos as $key => $contacto_documento)
                                    <tr>
                                      <td>{{$key+1}}</td>
                                      <td>
                                        <a href="{{asset($contacto_documento->documento)}}">{{$contacto_documento->tipo}}</a>
                                      </td>
                                      <td>{{$contacto_documento->descripcion}}</td>
                                      <td>{{$contacto_documento->validacion}}</td>
                                      <td>
                                        @if ($contacto_documento->evidencia_validacion!='N/A')
                                          <a href="{{asset($contacto_documento->evidencia_validacion)}}"><i class="far fa-eye"></i></a>
                                        @else -
                                        @endif
                                      </td>
                                    </tr>
                                  @endforeach
                                  </tbody >
                              </table>
                            </div>
                          </div>
                          <div class="container-fluid">
                            <div class="sec-datos">
                            </div>
                            <h3 class="m-t-none m-b">Modificaciones de Cliente/ID</h3>
                            <div class="panel-body datatable-panel">
                              <table class="ui celled table" style="width:100%" id="dataTables-example">
                                <thead>
                                  <tr>
                                    <th>Descripción de modificación</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contactos_cambios as $key => $contacto_cambio)
                                      <tr class="odd gradeX">
                                        <td>{!! $contacto_cambio->descripcion_cambio !!}</td>
                                        <td>{{$contacto_cambio->usuario}}</td>
                                        <td>{{$contacto_cambio->fecha}}</td>
                                      </tr>
                                    @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>


                        </div>
                      </div>

                      <script>
                      function verificado_fun(){
                        console.log('click');
                        // $("#verificado").click(function() {
                          console.log('xD');
                        if($("#verificado").is(':checked')) {
                        $("#validacion_archivo").show();
                        $("#verificado").attr("value","SI");
                        } else {
                        $("#verificado").attr("value","NO");
                        $("#validacion_archivo").hide();
                        }
                      }
                      // $("#agregar_po2").click(function(){
                      //
                      // var checado1 = "no";
                      // if( $("#check2").prop('checked') ) {
                      // checado1 = "si";
                      // }
                      //
                      // var porcentaje = $("#porcentaje").val();
                      // var di = $("#di").val();
                      // var cantidad_de = $("#cantidad_de").val();
                      // var new_saldos = $("#new_saldos").val();
                      // var contacid = $("#contacid").val();
                      // var total_vencido = $("#de").val();
                      // var pagares_numero = $("#pagares_numero").val();
                      // var fecha_creaci =$("#fecha_creacion2").val();
                      // var total_de =$("#total_de").val();
                      // if (new_saldos !="") {
                      // if (porcentaje <= 0) {
                      // alert("El Porcentaje es Inferior a 2");
                      // $("#porcentaje").val("");
                      // $("#cantidad_de").val("");
                      // $("#new_saldos").val("");
                      // }else{
                      // $.post("guardar_porcentaje_por_pagare.php", {checado: checado1,porcen: porcentaje,di: di,cantidad_porcentaje: cantidad_de,new_saldo: new_saldos,contac: contacid,total_vencido: total_vencido,pagares_numero :pagares_numero,fecha_creaci:fecha_creaci,total_de: total_de }, function(resultado) {
                      //
                      // console.log(resultado);
                      //
                      // if (new_saldos != "NaN") {
                      //
                      // if (resultado=="Se Presentó un Error" && resultado== "El Nuevo Saldo  no es un valor numérico") {
                      //
                      // alert(resultado);
                      // }else{
                      //
                      // if (checado1 == "si") {
                      //   /*console.log(resultado);*/
                      //   alert("Agregado Correctamente");
                      //   window.open(resultado);
                      //
                      // }else{
                      //   alert("Agregado Correctamente");
                      // }
                      //
                      //
                      // }
                      //
                      // }else{
                      // alert("No hay datos");
                      // }
                      // /* console.log(resultado);*/
                      //
                      // $("#ibox-content").load(" #ibox-content");
                      // $("#conte").load(" #conte");
                      //
                      // });
                      // }
                      // }else{
                      // alert("Los Campos estan vacíos");
                      //
                      // }
                      //
                      // });
                      //
                      // $("#porcentaje").keyup(function(){
                      //
                      // var vari = $("#porcentaje").val();
                      //
                      // var contacid =  $("#contacid").val();
                      // var de =  $("#de").val();
                      //
                      // $.post("recibe_por.php", {vari: vari,contacid:contacid}, function(resultado) {
                      //
                      // $("#cantidad_de").val(parseFloat(resultado).toFixed(2));
                      // $("#new_saldos").val((parseFloat(resultado)+parseFloat(de)).toFixed(2));
                      //
                      //
                      //
                      // console.log(resultado);
                      //
                      // /*$("#ibox-content2").load(" #ibox-content2");*/
                      // var textoletras = $("#new_saldos").val();
                      //
                      //
                      // if (textoletras != "") {
                      //
                      //
                      // $.post("buscar_letras.php", {valorBusqueda: textoletras}, function(mensaje_letras) {
                      //
                      // delete mensaje_letras;
                      // $("#letra").val(mensaje_letras);
                      //
                      // console.log(mensaje_letras);
                      // //alert("resultado:"+mensaje_letras);
                      //
                      //
                      // });
                      // } else {
                      // $("#letra").val('');
                      //
                      // }
                      //
                      // });
                      //
                      //
                      //
                      // });
                      //
                      // $("#telefono_otro").keyup(function(){
                      // if ($("#telefono_otro").val() === $("#telefono_celular").val()) {
                      // alert('No puedes asignar el mismo numero en ambos campos');
                      // $("#telefono_otro").val('');
                      // $("#telefono_otro").focus();
                      // }
                      // });
                      // function buscar_numero_celular() {
                      // var telefono_celular = $("#telefono_celular").val();
                      // if (telefono_celular == "") {
                      // $("#respuesta_numero_celular").html(' <i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>');
                      // }else{
                      // $.post("buscar_telefono_celular.php", {telefono_celular: telefono_celular}, function(respuesta) {
                      // $("#respuesta_numero_celular").html(respuesta);
                      // if(respuesta == ' <i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>'){
                      // $("#validar_formulario").attr("value","NO");
                      // $("#telefono_celular").val('');
                      // }else if (respuesta == ' <i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;"></i>'){
                      // $("#validar_formulario").attr("value","SI");
                      // }else if (respuesta == ''){
                      // $("#validar_formulario").attr("value","NO");
                      // $("#telefono_celular").val('');
                      // }
                      // });
                      // }
                      // };
                      // jQuery.datetimepicker.setLocale('es');
                      // jQuery('#fecha_nacimiento').datetimepicker({
                      // i18n:{
                      // de:{
                      // months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                      // ],
                      // dayOfWeek:['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'
                      // ]
                      // }
                      // },
                      // timepicker: false,
                      // format:'Y-m-d'
                      // });
                      const cardB = document.getElementById("card-back");
                      const cardF = document.getElementById("card-front");
                      const btnVer = document.getElementById("btnVer");
                      const btnRegresar = document.getElementById("btnRegresar");
                      btnVer.onclick = function(){
                        cardF.style.left = "-100%";
                        cardB.style.left = "0%";
                      }

                      btnRegresar.onclick = function(){
                        cardB.style.left = "100%";
                        cardF.style.left = "0%";
                      }
                      </script>
                      <script>
                      // function mayus(letra){
                      // jQuery(letra).keyup(function () {
                      // this.value = this.value.toLowerCase();
                      // this.value = this.value.replace(/\b[a-z]/g,c=>c.toUpperCase());
                      // });
                      // }
                      // function numero(numero){
                      // jQuery(numero).keyup(function () {
                      // this.value = this.value.replace(/[^0-9]/g,'');
                      // });
                      // }
                      // $(document).ready(function(){
                      //
                      // $("#verificado").click(function() {
                      //   console.log('xD');
                      // if($("#verificado").is(':checked')) {
                      // $("#validacion_archivo").show();
                      // $("#verificado").attr("value","SI");
                      // } else {
                      // $("#verificado").attr("value","NO");
                      // $("#validacion_archivo").hide();
                      // }
                      // });
                      //
                      // $("#codigo_postal").change(function(){
                      // cp_buscar=$("#codigo_postal").val();
                      // $("#buscador_cp").html('<div><img src="../../img/load.gif"/></div>');
                      // $.ajax({
                      // type: "POST",
                      // url: "cp_busqueda.php?cp="+cp_buscar,
                      // success: function(a) {
                      // $("#buscador_cp").html(a);
                      // }
                      // });
                      // });
                      // $('#dataTables-example').DataTable({
                      // language: {
                      // "decimal": "",
                      // "emptyTable": "No hay información",
                      // "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                      // "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                      // "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                      // "infoPostFix": "",
                      // "thousands": ",",
                      // "lengthMenu": "Mostrar _MENU_ Entradas",
                      // "loadingRecords": "Cargando...",
                      // "processing": "Procesando...",
                      // "search": "Buscar:",
                      // "zeroRecords": "Sin resultados encontrados",
                      // "paginate": {
                      // "first": "Primero",
                      // "last": "Ultimo",
                      // "next": "Siguiente",
                      // "previous": "Anterior"
                      // }
                      // },
                      // responsive: true,
                      // lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
                      // dom: 'Blfrtip',
                      // buttons: [
                      // 'copy', 'excel'
                      // ]
                      // });
                      // var table = $('#dataTables-example').DataTable();
                      // table
                      // .order([ 2, 'desc' ])
                      // .draw();
                      // $('#dataTables-examplex3').DataTable({
                      // language: {
                      // "decimal": "",
                      // "emptyTable": "No hay información",
                      // "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                      // "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                      // "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                      // "infoPostFix": "",
                      // "thousands": ",",
                      // "lengthMenu": "Mostrar _MENU_ Entradas",
                      // "loadingRecords": "Cargando...",
                      // "processing": "Procesando...",
                      // "search": "Buscar:",
                      // "zeroRecords": "Sin resultados encontrados",
                      // "paginate": {
                      // "first": "Primero",
                      // "last": "Ultimo",
                      // "next": "Siguiente",
                      // "previous": "Anterior"
                      // }
                      // },
                      // responsive: true,
                      // lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
                      // dom: 'Blfrtip',
                      // buttons: [
                      // 'copy', 'excel'
                      // ]
                      // });
                      // var table = $('#dataTables-examplex3').DataTable();
                      // table
                      // .order([ 2, 'asc' ])
                      // .draw();
                      // $('#dataTables-examplex4').DataTable({
                      // language: {
                      // "decimal": "",
                      // "emptyTable": "No hay información",
                      // "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                      // "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                      // "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                      // "infoPostFix": "",
                      // "thousands": ",",
                      // "lengthMenu": "Mostrar _MENU_ Entradas",
                      // "loadingRecords": "Cargando...",
                      // "processing": "Procesando...",
                      // "search": "Buscar:",
                      // "zeroRecords": "Sin resultados encontrados",
                      // "paginate": {
                      // "first": "Primero",
                      // "last": "Ultimo",
                      // "next": "Siguiente",
                      // "previous": "Anterior"
                      // }
                      // },
                      // responsive: true,
                      // lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
                      // dom: 'Blfrtip',
                      // buttons: [
                      // 'copy', 'excel'
                      // ]
                      // });
                      // var table = $('#dataTables-examplex4').DataTable();
                      // table
                      // .order([ 0, 'asc' ])
                      // .draw();
                      // $('#dataTables-example_resumen').DataTable({
                      // language: {
                      // "decimal": "",
                      // "emptyTable": "No hay información",
                      // "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                      // "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                      // "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                      // "infoPostFix": "",
                      // "thousands": ",",
                      // "lengthMenu": "Mostrar _MENU_ Entradas",
                      // "loadingRecords": "Cargando...",
                      // "processing": "Procesando...",
                      // "search": "Buscar:",
                      // "zeroRecords": "Sin resultados encontrados",
                      // "paginate": {
                      // "first": "Primero",
                      // "last": "Ultimo",
                      // "next": "Siguiente",
                      // "previous": "Anterior"
                      // }
                      // },
                      // responsive: true,
                      // lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
                      // dom: 'Blfrtip',
                      // buttons: [
                      // 'copy', 'excel'
                      // ]
                      // });
                      // var table = $('#dataTables-example_resumen').DataTable();
                      // table
                      // .order([ 0, 'asc' ])
                      // .draw();
                      // $('#dataTables-examplex5').DataTable({
                      // language: {
                      // "decimal": "",
                      // "emptyTable": "No hay información",
                      // "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                      // "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                      // "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                      // "infoPostFix": "",
                      // "thousands": ",",
                      // "lengthMenu": "Mostrar _MENU_ Entradas",
                      // "loadingRecords": "Cargando...",
                      // "processing": "Procesando...",
                      // "search": "Buscar:",
                      // "zeroRecords": "Sin resultados encontrados",
                      // "paginate": {
                      // "first": "Primero",
                      // "last": "Ultimo",
                      // "next": "Siguiente",
                      // "previous": "Anterior"
                      // }
                      // },
                      // responsive: true,
                      // lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
                      // dom: 'Blfrtip',
                      // buttons: [
                      // 'copy', 'excel'
                      // ]
                      // });
                      // var table = $('#dataTables-examplex5').DataTable();
                      // table
                      // .order([ 0, 'asc' ])
                      // .draw();
                      // $('#dataTables-example30x').DataTable({
                      // language: {
                      // "decimal": "",
                      // "emptyTable": "No hay información",
                      // "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                      // "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                      // "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                      // "infoPostFix": "",
                      // "thousands": ",",
                      // "lengthMenu": "Mostrar _MENU_ Entradas",
                      // "loadingRecords": "Cargando...",
                      // "processing": "Procesando...",
                      // "search": "Buscar:",
                      // "zeroRecords": "Sin resultados encontrados",
                      // "paginate": {
                      // "first": "Primero",
                      // "last": "Ultimo",
                      // "next": "Siguiente",
                      // "previous": "Anterior"
                      // }
                      // },
                      // responsive: true,
                      // lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
                      // dom: 'Blfrtip',
                      // buttons: [
                      // 'copy', 'excel'
                      // ]
                      // });
                      // var table = $('#dataTables-example30x').DataTable();
                      // table
                      // .order([ 0, 'asc' ])
                      // .draw();
                      // $("#guardar_info").click(function(){
                      // var idcontacto = "{{$contacto->id}}";
                      // var nomeclatura = "{{$contacto->nomenclatura}}";
                      // var nombre = $("#nombre").val();
                      // var apellidos = $("#apellidos").val();
                      // var sexo = $("#sexo").val();
                      // var rfc = $("#rfc").val();
                      // var alias = $("#alias").val();
                      // var telefono_otro = $("#telefono_otro").val();
                      // var telefono_celular = $("#telefono_celular").val();
                      // var email = $("#email").val();
                      // var referencia_nombre = $("#referencia_nombre").val();
                      // var referencia_celular = $("#referencia_celular").val();
                      // var referencia_fijo = $("#referencia_fijo").val();
                      // var referencia_nombre2 = $("#referencia_nombre2").val();
                      // var referencia_celular2 = $("#referencia_celular2").val();
                      // var referencia_fijo2 = $("#referencia_fijo2").val();
                      // var referencia_nombre3 = $("#referencia_nombre3").val();
                      // var referencia_celular3 = $("#referencia_celular3").val();
                      // var referencia_fijo3 = $("#referencia_fijo3").val();
                      // var asesor = $("#asesor").val();
                      // var tipo_cliente = $("#tipo_cliente").val();
                      // var tipo_credito = $("#tipo_credito").val();
                      // var linea_credito = $("#linea_credito").val();
                      // var codigo_postal = $("#codigo_postal").val();
                      // var estado = $("#estado").val();
                      // var delmuni = $("#delmuni").val();
                      // var colonia = $("#colonia").val();
                      // var colonia_select = $("#colonia_otra").val();
                      // var calle = $("#calle").val();
                      // var fecha_nacimiento = $("#fecha_nacimiento").val();
                      // if (fecha_nacimiento == "") {
                      // $("#fecha_nacimiento").focus();
                      // $('#fecha_nacimiento').addClass('error');
                      // } else if (nombre == "") {
                      // $("#nombre").focus();
                      // $('#nombre').addClass('error');
                      // } else if (apellidos == "") {
                      // $("#apellidos").focus();
                      // $('#apellidos').addClass('error');
                      // } else if (sexo == "") {
                      // $("#sexo").focus();
                      // $('#sexo').addClass('error');
                      // } else if (alias == "") {
                      // $("#alias").focus();
                      // $('#alias').addClass('error');
                      // } else if (telefono_celular == "") {
                      // $("#telefono_celular").focus();
                      // $('#telefono_celular').addClass('error');
                      // } /*else if (telefono_otro == "") {
                      // $("#telefono_otro").focus();
                      // $('#telefono_otro').addClass('error');
                      // }*/ else if (asesor == "") {
                      // $("#asesor").focus();
                      // $('#asesor').addClass('error');
                      // } else if (tipo_cliente == "") {
                      // $("#tipo_cliente").focus();
                      // $('#tipo_cliente').addClass('error');
                      // } else if (tipo_credito == "") {
                      // $("#tipo_credito").focus();
                      // $('#tipo_credito').addClass('error');
                      // } else if (linea_credito == "") {
                      // $("#linea_credito").focus();
                      // $('#linea_credito').addClass('error');
                      // } else if (codigo_postal == "") {
                      // $("#codigo_postal").focus();
                      // $('#codigo_postal').addClass('error');
                      // } else if (estado == "") {
                      // $("#estado").focus();
                      // $('#estado').addClass('error');
                      // } else if (delmuni == "") {
                      // $("#delmuni").focus();
                      // $('#delmuni').addClass('error');
                      // } else if (colonia == "") {
                      // $("#colonia").focus();
                      // $('#colonia').addClass('error');
                      // } else if (calle == "") {
                      // $("#calle").focus();
                      // $('#calle').addClass('error');
                      // } else if (referencia_nombre == "") {
                      // $("#referencia_nombre").focus();
                      // $('#referencia_nombre').addClass('error');
                      // } else if (referencia_celular == "") {
                      // $("#referencia_celular").focus();
                      // $('#referencia_celular').addClass('error');
                      // } else if (referencia_fijo == "") {
                      // $("#referencia_fijo").focus();
                      // $('#referencia_fijo').addClass('error');
                      // } else if (referencia_nombre2 == "") {
                      // $("#referencia_nombre2").focus();
                      // $('#referencia_nombre2').addClass('error');
                      // } else if (referencia_celular2 == "") {
                      // $("#referencia_celular2").focus();
                      // $('#referencia_celular2').addClass('error');
                      // } else if (referencia_fijo2 == "") {
                      // $("#referencia_fijo2").focus();
                      // $('#referencia_fijo2').addClass('error');
                      // } else {
                      // parametros = {
                      // "idcontacto" : idcontacto,
                      // "nomeclatura" : nomeclatura,
                      // "nombre" : nombre,
                      // "apellidos" : apellidos,
                      // "sexo" : sexo,
                      // "rfc" : rfc,
                      // "alias" : alias,
                      // "telefono_otro" : telefono_otro,
                      // "telefono_celular" : telefono_celular,
                      // "email" : email,
                      // "referencia_nombre" : referencia_nombre,
                      // "referencia_celular" : referencia_celular,
                      // "referencia_fijo" : referencia_fijo,
                      // "referencia_nombre2" : referencia_nombre2,
                      // "referencia_celular2" : referencia_celular2,
                      // "referencia_fijo2" : referencia_fijo2,
                      // "referencia_nombre3" : referencia_nombre3,
                      // "referencia_celular3" : referencia_celular3,
                      // "referencia_fijo3" : referencia_fijo3,
                      // "asesor" : asesor,
                      // "tipo_cliente" : tipo_cliente,
                      // "tipo_credito" : tipo_credito,
                      // "linea_credito" : linea_credito,
                      // "codigo_postal" : codigo_postal,
                      // "estado" : estado,
                      // "delmuni" : delmuni,
                      // "colonia" : colonia,
                      // "colonia_select" : colonia_select,
                      // "calle" : calle,
                      // "fecha_nacimiento" : fecha_nacimiento
                      // };
                      // $.ajax({
                      // data:  parametros,
                      // url:   'guardar_editar_contacto.php',
                      // type:  'post',
                      // beforeSend: function () {
                      // $("#guardar_info").remove();
                      // $("#btn_eliminar").append('<center><button class="btn btn-primary" type="button" disabled id="act_btn">  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>  Cargando</button></center>');
                      // },
                      // success:  function (response) {
                      // var get_response = response.trim();
                      // console.log(get_response);
                      // if (get_response === "Contacto editado correctamente") {
                      // $("#act_btn").remove();
                      // $("#btn_eliminar").append('<center><button type="button" class="btn btn-success">Guardado</button></center>');
                      // act_page();
                      // } else if (get_response === "No se han detectado cambios") {
                      // $("#act_btn").remove();
                      // $("#btn_eliminar").append('<center><button type="button" class="btn btn-warning">No se han detectado cambios</button></center>');
                      // act_page();
                      // } else {
                      // $("#act_btn").remove();
                      // $("#btn_eliminar").append('<center><button type="button" class="btn btn-danger">Error detectado</button></center>');
                      // act_page();
                      // }
                      // }
                      // });
                      // }
                      // });
                      // });
                      // function act_page() {
                      // setTimeout(function(){ location.reload(); }, 1000);
                      // }
                      </script>
                    @endsection
