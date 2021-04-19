@extends('layouts.appAdmin')

@section('titulo', 'Moviento balance')


@section('head')
  <style media="screen">
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

  /* .open-modal {
    font-weight: bold;
    background: var(--blue);
    color: var(--white);
    padding: 0.75rem 1.75rem;
    margin-bottom: 1rem;
    border-radius: 5px;
  }


  .modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    background: var(--black);
    cursor: pointer;
    visibility: hidden;
    opacity: 0;
    z-index: 2;
    transition: all 0.35s ease-in;
  }

  .modal.is-visible {
    visibility: visible;
    opacity: 1;
    z-index: 2;
  }

  .modal-dialog {
    position: relative;
    max-width: 800px;
    max-height: 80vh;
    border-radius: 5px;
    background: var(--white);
    overflow: auto;
    cursor: default;
  }

  .modal-dialog > * {
    padding: 1rem;
  }

  .modal-header,
  .modal-footer {
    background: var(--lightgray);
  }

  .modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .modal-header .close-modal {
    font-size: 1.5rem;
  }

  .modal p + p {
    margin-top: 1rem;
  }


  [data-animation] .modal-dialog {
    opacity: 0;
    transition: all 0.5s var(--bounceEasing);
  }

  [data-animation].is-visible .modal-dialog {
    opacity: 1;
    transition-delay: 0.2s;
  }

  [data-animation="slideInOutDown"] .modal-dialog {
    transform: translateY(100%);
  }

  [data-animation="slideInOutTop"] .modal-dialog {
    transform: translateY(-100%);
  }

  [data-animation="slideInOutLeft"] .modal-dialog {
    transform: translateX(-100%);
  }

  [data-animation="slideInOutRight"] .modal-dialog {
    transform: translateX(100%);
  }

  [data-animation="zoomInOut"] .modal-dialog {
    transform: scale(0.2);
  }

  [data-animation="rotateInOutDown"] .modal-dialog {
    transform-origin: top left;
    transform: rotate(-1turn);
  }

  [data-animation="mixInAnimations"].is-visible .modal-dialog {
    animation: mixInAnimations 2s 0.2s linear forwards;
  }

  [data-animation="slideInOutDown"].is-visible .modal-dialog,
  [data-animation="slideInOutTop"].is-visible .modal-dialog,
  [data-animation="slideInOutLeft"].is-visible .modal-dialog,
  [data-animation="slideInOutRight"].is-visible .modal-dialog,
  [data-animation="zoomInOut"].is-visible .modal-dialog,
  [data-animation="rotateInOutDown"].is-visible .modal-dialog {
    transform: none;
  }

  @keyframes mixInAnimations {
    0% {
      transform: translateX(-100%);
    }

    10% {
      transform: translateX(0);
    }

    20% {
      transform: rotate(20deg);
    }

    30% {
      transform: rotate(-20deg);
    }

    40% {
      transform: rotate(15deg);
    }

    50% {
      transform: rotate(-15deg);
    }

    60% {
      transform: rotate(10deg);
    }

    70% {
      transform: rotate(-10deg);
    }

    80% {
      transform: rotate(5deg);
    }

    90% {
      transform: rotate(-5deg);
    }

    100% {
      transform: rotate(0deg);
    }
  } */


  .tooltipDetalleOrden{
    text-align: center;
  }
  .tooltipDetalleOrden p{
    position: relative;
    opacity: 0;
    visibility: hidden;
    font-size: 20px;
    font-weight: bold;
    color: #882439;
    transition: .5s;
    transform: translateY(10px);
  }
  .tooltipDetalleOrden p:before{
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background: #882439;
    bottom: -8px;
    left: 0;
    transition: .5s;
  }
  .icon-DOrden{
    width: 100%;
    text-align: center;
  }
  .icon-DOrden:hover ~ .tooltipDetalleOrden p:before{
    width: 100%;
  }
  .icon-DOrden:hover ~ .tooltipDetalleOrden p{
    opacity: 1;
    visibility: visible;
    transform: translateY(0px);
  }
  .font-icong, .font-iconr, .font-iconb{
    margin-bottom: 10px;
    font-size: 100px;
    cursor: pointer;
  }
  .font-icong{
    color: green;
  }
  .font-iconr{
    color: #E11515;
  }
  .font-iconb{
    color: #3A53A8;
  }
  .font-icong:hover, .font-iconr:hover, .font-iconb:hover{
    color: #882439;
  }
  .height-r{
    height: 300px;
  }
  @media only screen and (max-width: 868px){
    .height-r{
      height: 400px;
    }
  }
  @media only screen and (max-width: 580px){
    .height-r{
      height: 500px;
    }
  }
  a.iconos-estatus{
    display: inline-block;
    text-align: center;
    padding: 20px 25px;
    line-height: 50px;
    cursor: pointer;
    position: relative;
    margin: 0 auto;
  }
  /* Agregando estilo de Tooltip a iconos pagina atencion_talleres_detalle (Modulo Ordenes de Proveedores Detallado) EAM */
  a.tooltip_recibo:after,
  a.tooltip_recibo_qr:after,
  a.tooltip_pdf_filtrado:after,
  a.tooltip_abono_cargo:after,
  a.tooltip_evidencia:after,
  a.tooltip_mas_recibo:after,
  a.tooltip_mas_referencias:after,
  a.tooltip_agrar_mas_aux:after{
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: #444;
    opacity: 0;
    visibility: hidden;
    transition: .5s;
    font-size: 12px;
    line-height: 30px;
    color: #ccc;
    height: 30px;
    border-radius: 10px;
  }
  a.tooltip_recibo:after{
    content: 'Recibo';
    width: 200px;
  }
  a.tooltip_recibo_qr:after{
    content: 'Recibo QR';
    width: 200px;
  }
  a.tooltip_agrar_mas_aux:after{
    content: 'Agregar auxiliares';
    width: 250px;
  }
  a.tooltip_pdf_filtrado:after{
    content: 'Filtrado';
    width: 250px;
  }

  a.tooltip_evidencia:after{
    content: 'Evidencia';
    width: 250px;
  }
  a.tooltip_abono_cargo:after{
    content: 'Cargo / Abono sin aplicar';
    width: 250px;
  }
  a.tooltip_mas_recibo:after{
    content: 'Recibos';
    width: 250px;
  }
  a.tooltip_mas_referencias:after{
    content: 'Referencias';
    width: 250px;
  }




  a.tooltip_recibo:hover:after,
  a.tooltip_recibo_qr:hover:after,
  a.tooltip_pdf_filtrado:hover:after,
  a.tooltip_evidencia:hover:after,
  a.tooltip_abono_cargo:hover:after,
  a.tooltip_mas_recibo:hover:after,
  a.tooltip_mas_referencias:hover:after,
  a.tooltip_agrar_mas_aux:hover:after
  {
    opacity: 1;
    visibility: visible;
    top: -20px;
  }
  a.iconos-estatus:before{
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    top: 10px;
    background: white;
    left: 50%;
    transform: translateX(-50%) rotate(45deg);
    opacity: 0;
    visibility: hidden;
    transition: .5s;
  }
  a.iconos-estatus:hover:before{
    opacity: 1;
    visibility: visible;
    top: 5px;
  }

  .font-icong{
    color:gray !important;
  }
  .font-iconr{
    color:gray !important;
  }
  .font-iconb{
    color:gray !important;
  }

  .font-icong:hover{
    color:#882439 !important;
  }
  .font-iconr:hover{
    color:#882439 !important;
  }
  .font-iconb:hover{
    color:#882439 !important;
  }

  .font-iconrojo{
    color:gray !important;
  }
  .font-iconrojo:hover{
    color:#882439 !important;
  }

  table td {
    vertical-align: middle;
  }
  </style>
@endsection
@section('content')
  <center>
    <h2><b>{{Crypt::decrypt($aux)}}</b></h2>
  </center>


  <div class="table-responsive">
    <table id="example" class="table table-striped table-bordered" style="width: 100%;">
      <thead>
        <tr>
          <th>#</th>
          <th>Concepto</th>
          <th>Orden</th>
          <th>Tipo Movimiento </th>
          <th>Instituciónes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
          <th>Movimiento exitoso</th>
          <th>Fecha Movimiento</th>
          <th>Referencia</th>
          <th>Más</th>
          <th>Comentarios</th>
          <th>Usuario Creador</th>
        </tr>
      </thead>
      <tbody>
        @php
        $i = 1;
        @endphp
        @foreach ($auxiliares as $auxiliar)
          <tr>
            <td>{{$i}}</td>
            <td>
              @if ($auxiliar->tipo_movimiento == "cargo")
                @if ($auxiliar->estatus_password_modal == "Admin")
                  <a href='{{route("Caja_Chica.resumen_abonos_estado_cuenta_requisicion",[$auxiliar->idestado_cuenta_requisicion,$aux])}}' target="_blank">{{$auxiliar->concepto}}</a>
                @elseif ($auxiliar->estatus_password_modal == "SI")
                  <a class='abrir abrir{{$auxiliar->idestado_cuenta_requisicion}}' id='{{$auxiliar->idestado_cuenta_requisicion}}' data- data-toggle="modal" data-target="#exampleModalCenter2{{$auxiliar->idestado_cuenta_requisicion}}">{{$auxiliar->concepto}}</a>
                  <input type='hidden' class='ruta_evi ruta_evi{{$auxiliar->idestado_cuenta_requisicion}}' id='{{$auxiliar->idestado_cuenta_requisicion}}' value='{{$auxiliar->idestado_cuenta_requisicion}}**{{$aux}}'>

                  <div class="modal fade" id="exampleModalCenter2{{$auxiliar->idestado_cuenta_requisicion}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">  Bienvenido...</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class='row'>
                            <div class='col-sm-12 form-group'>
                              <label>Ingresa tu clave</label>
                              <input type='password' class='pass pass{{$auxiliar->idestado_cuenta_requisicion}} form-control' id='{{$auxiliar->idestado_cuenta_requisicion}}' placeholder='Password'>
                              <center><i class='fa fa-eye fa-2x mostrar mostrar{{$auxiliar->idestado_cuenta_requisicion}}' id='{{$auxiliar->idestado_cuenta_requisicion}}'></i></center>
                            </div>

                            <div class='col-sm-12 form-group'>
                              <center>
                                <button class='btn btn-primary btn-lg enviar_log enviar_log{{$auxiliar->idestado_cuenta_requisicion}}' id='{{$auxiliar->idestado_cuenta_requisicion}}'>Acceder..</button>
                              </center>
                            </div>
                          </div>
                          <footer class='modal-footer'>
                            Si no cuenta con un acceso comuníquese con el administrador
                          </footer>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  {{-- <div class='modal' id='modal{{$auxiliar->idestado_cuenta_requisicion}}'>
                    <div class='modal-dialog'>
                      <header class='modal-header'>
                        Bienvenido...
                        <button class='close-modal' aria-label='close modal' data-close>
                          ✕
                        </button>
                      </header>
                      <section class='modal-content'>

                        <div class='row'>
                          <div class='col-sm-12 form-group'>
                            <label>Ingresa tu clave</label>
                            <input type='password' class='pass pass{{$auxiliar->idestado_cuenta_requisicion}} form-control' id='{{$auxiliar->idestado_cuenta_requisicion}}' placeholder='Password'>
                            <center><i class='fa fa-eye fa-2x mostrar mostrar{{$auxiliar->idestado_cuenta_requisicion}}' id='{{$auxiliar->idestado_cuenta_requisicion}}'></i></center>
                          </div>

                          <div class='col-sm-12 form-group'>
                            <center>
                              <button class='btn btn-primary btn-lg enviar_log enviar_log{{$auxiliar->idestado_cuenta_requisicion}}' id='{{$auxiliar->idestado_cuenta_requisicion}}'>Acceder..</button>
                            </center>
                          </div>
                        </div>
                      </section>
                      <footer class='modal-footer'>
                        Si no cuenta con un acceso comuníquese con el administrador
                      </footer>
                    </div>
                  </div> --}}

                @elseif ($auxiliar->estatus_password_modal == "NO")
                  {{$auxiliar->concepto}}
                @endif
                @if ($auxiliar->datos_estatus == "Pendiente")
                  <div style='background: #ef5353; color: #fff; text-align: center;'>PENDIENTE</div>
                @else
                  <div style='background: #52ef90; text-align: center;'>PAGADO</div>
                @endif
              @else
                {{$auxiliar->concepto}}
              @endif
            </td>
            <td>
              @if ($auxiliar->at == "NO")
                No se encontro orden
              @endif
              @if ($auxiliar->at == "SI")
                Orden: <b>{{$auxiliar->id_orden_at}}</b><br>
                Estatus <b>{{$auxiliar->estatus_orden}}</b><b></b>
                <i class="far fa-file-pdf fa-2x" ></i>
              @endif
            </td>
            <td>{{$auxiliar->tipo_movimiento}}</td>
            <td>
              Institucion emisora: <b>{{$auxiliar->emisora_institucion}}</b><br>
              Agente emisora: <b>{{$auxiliar->emisora_agente}}</b><br>
              Institucion receptora: <b>{{$auxiliar->receptora_institucion}}</b><br>
              Agente receptora: <b>{{$auxiliar->receptora_agente}}</b><br>
            </td>
            <td>
              @if ($auxiliar->monto_pendiente == "N/A")
                N/A
              @endif
              @if ($auxiliar->monto_pendiente != "N/A")
                Monto cargo : <b>$ {{$auxiliar->monto_precio_formato}}</b> <br>
                Monto abono : <b>{{$auxiliar->monto_abono}}</b> <br>
                Saldo : <b>{{$auxiliar->monto_pendiente}}</b> <br>
              @endif
            </td>
            <td>{{$auxiliar->fecha_mov_for}}</td>
            <td>{{$auxiliar->referencia}}</td>
            <td>
              <i class="fas fa-plus fa-3x" style="color:#0B68DD;cursor:pointer;" data-toggle="modal" data-target="#exampleModalCenter{{$auxiliar->idestado_cuenta_requisicion}}"></i>

              <div class="modal fade2" id="exampleModalCenter{{$auxiliar->idestado_cuenta_requisicion}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Más</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <div class="row ">

                        <div class="col-sm-3 d-flex align-items-center">
                          <a href="#" target="_blank" class="iconos-estatus tooltip_evidencia"><span><i class="fas fa-photo-video fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></span></a>
                        </div>

                        <div class="col-sm-3 d-flex align-items-center">
                          <a href="#" target="_blank" class="iconos-estatus tooltip_recibo"><span><i class="far fa-file-pdf fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></span></a>
                        </div>

                        <div class="col-sm-3 d-flex align-items-center">
                          <a href="#" target="_blank" class="iconos-estatus tooltip_agrar_mas_aux"><span><i class="fas fa-plus-circle fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></span></a>
                        </div>

                        <div class="col-sm-3 d-flex align-items-center">

                          <a href="{{route('Caja_Chica.recibo_qr_pdf',[$auxiliar->idestado_cuenta_requisicion])}}" target="_blank" class="iconos-estatus tooltip_recibo_qr"><span><i class="fas fa-qrcode fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></span></a>
                        </div>

                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                </div>
              </div>

            </td>
            <td>{{$auxiliar->comentarios}}</td>
            <td>{{$auxiliar->usuario_creador_mov}}</td>

          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th>#</th>
          <th>Concepto</th>
          <th>Orden</th>
          <th>Tipo Movimiento </th>
          <th>Instituciónes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
          <th>Movimiento exitoso</th>
          <th>Fecha Movimiento</th>
          <th>Referencia</th>
          <th>Más</th>
          {{-- <th>Evidencia</th>
          <th>Recibo Automático</th>
          <th>Más Auxiliares</th>
          <th>Recibo QR</th> --}}
          <th>Comentarios</th>
          <th>Usuario Creador</th>
        </tr>
      </tfoot>
    </table>
  </div>


@endsection

@section('js')
  <script  type="text/javascript" class="init">
  $(document).ready(function() {

    const openEls = document.querySelectorAll("[data-open]");
    const closeEls = document.querySelectorAll("[data-close]");
    const isVisible = "is-visible";

    for (const el of openEls) {
      el.addEventListener("click", function() {
        const modalId = this.dataset.open;
        document.getElementById(modalId).classList.add(isVisible);
      });
    }

    for (const el of closeEls) {
      el.addEventListener("click", function() {
        this.parentElement.parentElement.parentElement.classList.remove(isVisible);
      });
    }

    document.addEventListener("click", e => {
      if (e.target == document.querySelector(".modal.is-visible")) {
        document.querySelector(".modal.is-visible").classList.remove(isVisible);
      }
    });

    document.addEventListener("keyup", e => {

      if (e.key == "Escape" && document.querySelector(".modal.is-visible")) {
        document.querySelector(".modal.is-visible").classList.remove(isVisible);
      }
    });

    $('.mostrar').click(function(){
      var id2 = $(this).attr("id");
      if($('.mostrar'+id2).hasClass('fa-eye')){
        $(".pass"+id2).removeAttr('type');
        $('.mostrar'+id2).addClass('fa-eye-slash').removeClass('fa-eye');
      }else{
        $(".pass"+id2).attr('type','password');
        $('.mostrar'+id2).addClass('fa-eye').removeClass('fa-eye-slash');
      }
    });

    $(".enviar_log").click(function() {
      var id = $(this).attr("id");
      var pass = $(".pass"+id).val();
      var val = $(".ruta_evi"+id).val().split("**");
      // console.log(val[0]);
      // console.log(val[1]);
      let ruta = "{{route('Caja_Chica.resumen_abonos_estado_cuenta_requisicion',['',''])}}/"+val[0]+"/"+val[1];
      var tipo ="Pago de auxiliares";
      if (pass != ""){
        var formData = new FormData();
        formData.append('password',pass);
        formData.append('tipo',tipo);
        formData.append('ruta',ruta);
        formData.append('id',id);
        $.ajax({
          headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": '{{csrf_token()}}',
          },
          data : formData,
          url : '{{route("Caja_Chica.validar_user_password_pagos")}}',
          type : 'post',
          processData: false,
          contentType: false,
          success : function(response) {
            console.log(response.estatus_acceso);
            console.log(response);

            if (response.estatus_acceso == "Entra") {
              $(".pass"+id).val("");
              id=btoa(id);
              window.open(ruta)
              const isVisible2 = "is-visible";
              document.querySelector(".modal.is-visible").classList.remove(isVisible2);
            }else{

              Swal.fire({
                title:'Error en la Contraseña',
                icon:'error',
                timer:20000,
                timerProgressBar:true
              });
              $(".pass"+id).val("");
            }
          },
          error : function(xhr, status) {
            alert("Error");
          }
        });
      }else {
        Swal.fire({
          title:'Contraseña no ingresada...',
          icon:'error',
          timer:20000,
          timerProgressBar:true
        });
        $(".pass"+id).val("");
      }
    });



  });
  </script>

@endsection
