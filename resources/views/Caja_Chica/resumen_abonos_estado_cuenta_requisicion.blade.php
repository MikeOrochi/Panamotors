@extends('layouts.appAdmin')

@section('titulo', 'Moviento balance')


@section('head')
  <style media="screen">
  .font-iconb{
    margin-bottom: 10px;
    font-size: 70px;
    cursor: pointer;
    color:#1e88e5;
  }
  .font-iconb:hover{
    color: #882439;
  }
  :root {
    --lightgray: #efefef;
    --blue: steelblue;
    --white: #fff;
    --black: rgba(0, 0, 0, 0.8);
    --bounceEasing: cubic-bezier(0.51, 0.92, 0.24, 1.15);
  }

  .btn-group {
    text-align: center;
  }
  </style>

@endsection


@section('content')

  @if (\Auth::user()->idempleados== 91 || \Auth::user()->idempleados== 88 || \Auth::user()->idempleados== 58 || \Auth::user()->idempleados== 170 || \Auth::user()->idempleados== 203 || \Auth::user()->idempleados== 206)

    <a href="{{route('Caja_Chica.agregar_requisicion_abono',[$idecr,$aux])}}">
      <i class="fa fa-money fa-5x icon-DOrden font-iconb" aria-hidden="true"></i>
      <div class="tooltipDetalleOrden">
        <p>Abono específico</p>
      </div>
    </a>

  @endif
@endsection
