@extends('layouts.appAdmin')
@section('titulo', 'CCP | Vista Previa Movimiento Exitoso')


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

  <form class="needs-validation" action="{{route('register')}}" method="post" id='mi_formulario'>
    @csrf
    <div class="row mt-3">
      <div class="col-sm-12">
        <div class="shadow panel-head-primary">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" align='right'>
            <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Requisitos </a>
          </div>
          <h6 class="text-center mt-3 mb-3"><strong>Verificación</strong></h6>
          <div class="table-responsive">
            <p align='center'>¿Es un cliente existente?</p>
            <div class="container">
              <div class="row" style="padding:30px">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" align='center'>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="exist_user" id="si" value="si" onclick="showSearch()">
                    <label class="form-check-label" for="si">
                      Si
                    </label>
                    <input class="form-check-input" type="radio" name="exist_user" id="no" value="no" checked onclick="hideSearch()" style="margin-left: 50px;">
                    <label class="form-check-label" for="no" style="margin-left: 80px;">
                      No
                    </label>
                  </div>
                </div>
          @include('VPMovimientoExitoso.partials.provider_form')
        </div>
      </div>
    </div>
  </div>
</div>
@include('VPMovimientoExitoso.partials.zip_form')
@include('VPMovimientoExitoso.partials.asigned_personal_form')
@include('VPMovimientoExitoso.partials.type_purchase')
@include('VPMovimientoExitoso.partials.type_provider_form')

</div>
</form>



@include('VPMovimientoExitoso.partials.js_general')
@include('admin.partials.providers.validations')
@endsection
