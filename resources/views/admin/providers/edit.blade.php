@extends('layouts.appAdmin')
@section('titulo', 'Editar proveedor')
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
  <form class="needs-validation" action="{{route('provider.update')}}" method="post" id='mi_formulario'>
    <div class="row mt-3">
      <div class="col-sm-12">
        <div class="shadow panel-head-primary">
          <a class="btn-back" style="margin-left:15px;" href="{{route('wallet.showProvider',$id)}}"><i class="fas fa-chevron-left"></i> Perfil</a>
          <h6 class="text-center mt-3 mb-3"><strong>Datos de usuario</strong></h6>
          <div class="table-responsive">
            <div class="container">
              @csrf
              @include('admin.partials.providers.provider_edit_form')
            </div>
          </div>
        </div>
        @include('admin.partials.providers.zip_edit_form')
        @include('admin.partials.providers.asigned_personal_edit_form')
        @include('admin.partials.providers.type_provider_form')
      </div>
    </div>
  </form>
  @include('admin.partials.providers.js_edit_general')
  {{-- @include('admin.partials.providers.validations') --}}

  <script type="text/javascript">
    var  TipoMoneda = '{{$provider->col2}}';
    $("#money option[value='"+TipoMoneda+"']").attr("selected", true);
    $('#ocultar_moneda').fadeOut();
    // $("#money").addClass("readonly");
    // $(".readonly").on('keydown paste focus mousedown', function(e){
    //   e.preventDefault();
    // });
  </script>


@endsection
