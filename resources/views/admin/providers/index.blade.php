

@extends('layouts.appAdmin')
@section('titulo', 'Agregar proveedor')
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

  <form class="needs-validation" action="{{route('provider.store')}}" method="post" id='mi_formulario'>
    @csrf
    <div class="row mt-3">
      <div class="col-sm-12">
        <div class="shadow panel-head-primary">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" align='right'>
            <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Requisitos </a>
          </div>
          <h6 class="text-center mt-3 mb-3"><strong>Verificación</strong></h6>
          <div class="table-responsive">
            <p align='center'>¿El nuevo proveedor es un cliente o un proveedor existente?</p>
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
                {{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="form-check">
                <input class="form-check-input" type="radio" name="exist_user" id="no" value="no" checked onclick="hideSearch()">
                <label class="form-check-label" for="no">
                No
              </label>
            </div>
          </div> --}}
          @include('admin.partials.providers.contact_provider_form')
          @include('admin.partials.providers.provider_form')
        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.partials.providers.zip_form')
@include('admin.partials.providers.asigned_personal_form')
@include('admin.partials.providers.type_provider_form')
</div>
</form>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <center><h4>Requisitos para registrar nuevo proveedor</h4></center>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          {{-- @foreach ($requisitos as $requisito)
          {{$requisito}}
        @endforeach --}}
        <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Requisito</th>
              <th scope="col">Tipo requisito</th>
              <th scope="col">Detalles</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Nombre y apellidos</td>
              <td>Obligatorio</td>
              <td>-</td>
            </tr>
            <tr>
              <td>2</td>
              <td>RFC</td>
              <td>En caso de contar con el</td>
              <td>-</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Alias</td>
              <td>Opcional</td>
              <td>-</td>
            </tr>
            <tr>
              <td>4</td>
              <td>Telefono</td>
              <td>Obligatorio</td>
              <td>-</td>
            </tr>
            <tr>
              <td>5</td>
              <td>Telefono adicional</td>
              <td>Opcional</td>
              <td>-</td>
            </tr>
            <tr>
              <td>6</td>
              <td>Email</td>
              <td>Obligatorio</td>
              <td>-</td>
            </tr>
            <tr>
              <td>7</td>
              <td>Tipo de persona</td>
              <td>Moral/Fisica</td>
              <td>-</td>
            </tr>
            <tr>
              <td>8</td>
              <td>Razón social</td>
              <td>Obligatorio</td>
              <td>-</td>
            </tr>
            <tr>
              <td>9</td>
              <td>Dirección</td>
              <td>Obligatorio</td>
              <td>Código postal, Municipio, Colonia/Localidad, calle y número</td>
            </tr>
            <tr>
              <td>10</td>
              <td>Personal asignado</td>
              <td>1 obligatorio </br> 2 opcionales</td>
              <td>Nombre completo y teléfono</td>
            </tr>
            <tr>
              <td>11</td>
              <td>Tipo de moneda utilizada</td>
              <td>Obligatorio</td>
              <td>MXN, USD, CAD, etc.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary">Save changes</button> --}}
    </div>
  </div>
</div>
</div>


@include('admin.partials.providers.js_general')
@include('admin.partials.providers.validations')
@endsection
