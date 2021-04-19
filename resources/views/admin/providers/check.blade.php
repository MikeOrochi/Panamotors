

@extends('layouts.appAdmin')
@section('titulo', 'Revisar proveedores')
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
  </style>

  {{-- <form class="needs-validation" action="{{route('provider.store')}}" method="post" id='mi_formulario'> --}}
    {{-- @csrf --}}
    <div class="row mt-3">
      <div class="col-sm-12">
        <div class="shadow panel-head-primary">
          <div class="table-responsive">
            <div class="table-responsive">
              <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example">
                <thead>
                  <tr>
                    {{-- <th>#</th> --}}
                    <th>Nombre</th>
                    <th>Compra usd</th>
                    <th>Compra cad</th>
                    <th>Compra mxn</th>
                    <th>Compra null</th>
                    <th>Compra moneda null</th>
                    <th>Abono usd</th>
                    <th>Abono cad</th>
                    <th>Abono mxn</th>
                    <th>Abono null</th>
                    <th>Abono moneda null</th>
                  </tr>
                </thead>
                <tbody style="cursor: pointer;">
                  @foreach ($providers_no_ok as $provider_no_ok)
                    <tr>
                      <td>{{$provider_no_ok['provider']}} </br> {{$provider_no_ok['nombre']}} {{$provider_no_ok['apellidos']}}</td>
                      <td @if($provider_no_ok['usd']>0) style="color: red;" @endif>{{$provider_no_ok['usd']}}</td>
                      <td @if($provider_no_ok['cad']>0) style="color: red;" @endif>{{$provider_no_ok['cad']}}</td>
                      <td @if($provider_no_ok['mxn']>0) style="color: red;" @endif>{{$provider_no_ok['mxn']}}</td>
                      <td @if($provider_no_ok['undefined']>0 || $provider_no_ok['nulls']>0) style="color: red;" @endif>{{$provider_no_ok['undefined']+$provider_no_ok['nulls']}}</td>
                      <td @if($provider_no_ok['tipo_cambio_blank']>0 || $provider_no_ok['tipo_cambio_null']) style="color: red;" @endif>{{$provider_no_ok['tipo_cambio_blank']+$provider_no_ok['tipo_cambio_null']}}</td>
                      <td @if($provider_no_ok['abono_usd']>0) style="color: green;" @endif>{{$provider_no_ok['abono_usd']}}</td>
                      <td @if($provider_no_ok['abono_cad']>0) style="color: green;" @endif>{{$provider_no_ok['abono_cad']}}</td>
                      <td @if($provider_no_ok['abono_mxn']>0) style="color: green;" @endif>{{$provider_no_ok['abono_mxn']}}</td>
                      <td @if($provider_no_ok['abono_undefined']>0 || $provider_no_ok['abono_nulls']>0) style="color: green;" @endif>{{$provider_no_ok['abono_undefined']+$provider_no_ok['abono_nulls']}}</td>
                      <td @if($provider_no_ok['abono_tipo_cambio_blank']>0 || $provider_no_ok['abono_tipo_cambio_null']>0) style="color: green;" @endif>{{$provider_no_ok['abono_tipo_cambio_blank']+$provider_no_ok['abono_tipo_cambio_null']}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>
  {{-- </form> --}}

@endsection
