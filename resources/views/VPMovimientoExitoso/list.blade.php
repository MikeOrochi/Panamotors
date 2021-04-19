@extends('layouts.appAdmin')
@section('titulo', 'CCP | Vista Previa Movimiento Exitoso')

@section('js')


@endsection

@section('content')
  @if (!empty(session('pdfs_aceptacion_contrato')))
    <script type="text/javascript">
    $( document ).ready(function() {
      $('#exampleModal').modal('toggle')
    });


    </script>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Vista Previa Movimiento Exitoso - Aceptado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" align='center'>
            ¿Deseas visualizar los formatos?<br>
            <a href="{{route('vpme.pdf.contratoDirectaContado',['id'=>Crypt::encrypt(session('pdfs_aceptacion_contrato'))])}}" id='document_2' target="_blank" onclick="closeTootips();" class="btn btn-success" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Contrato"><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></a>
            <a href="{{route('vpme.pdf.vistaPrevia',['id'=>Crypt::encrypt(session('pdfs_aceptacion_contrato'))])}}" id='document_1' target="_blank" onclick="closeTootips();" class="btn btn-info" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Vista Previa Moviminiento Exitoso"><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></a>
            <a href="{{route('vpme.pdf.personasFisicas',['id'=>Crypt::encrypt(session('pdfs_aceptacion_contrato'))])}}" id='document_2' target="_blank" onclick="closeTootips();" class="btn btn-info" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Formato personas fisicas"><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></a>
            <a href="{{route('vpme.pdf.aviso_privacidad',['id'=>Crypt::encrypt(session('pdfs_aceptacion_contrato'))])}}" id='document_2' target="_blank" onclick="closeTootips();" class="btn btn-info" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Aviso de privacidad"><i class="fa fa-file-text fa-3x" aria-hidden="true"></i></a>
          </div>
          {{-- <div class="modal-footer"> --}}
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
          {{-- </div> --}}
        </div>
      </div>
    </div>
    @php
    session()->forget('pdfs_aceptacion_contrato');
    @endphp
  @endif



  <style media="screen">
  th {
    font-size: 11px !important;
  }
  td {
    font-size: 12px !important;
  }
  </style>


  <!-- Modal -->
  <div class="modal fade" id="ModalCodigo" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Codigo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form  enctype="multipart/form-data" method="post" action="{{route('vpMovimientoExitoso.guardarCodigo')}}" class="needs-validation confirmation">
            @csrf
            <input type="hidden" name="idVistaPrevia" id="idVistaPrevia" required>

            <label for="CodigoAdmin">Codigo de Autorización</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px"><i class="fas fa-barcode"></i></div>
              </div>
              <input type="text" id="CodigoAdmin" name="CodigoAdmin" class="form-control" required="" style="border-radius: 0px !important;" maxlength="15" minlength="5">
              <div class="input-group-prepend">
                <div class="input-group-text btn" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 0px 5px 5px 0px;" onclick="GenerarCodigo()">
                  Autogenerar
                </div>
              </div>
            </div>

            <label for="EvidenciaAutorizacion">Evidencia</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px"><i class="fas fa-file-upload"></i></div>
              </div>
              <input type="file" class="form-control" name="EvidenciaAutorizacion" id="EvidenciaAutorizacion" required="" style="border-radius: 0px !important;">
            </div>

            <label for="comentarios">Comentarios</label>
            <input type="text" name="comentarios" id="comentarios" value="" minlength="15" class="form-control">

            <div class="row" style="justify-content: center;margin-top: 15px;">
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>


          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="ModalCodigoAceptar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Codigo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <form enctype="multipart/form-data" method="post" action="{{route('vpMovimientoExitoso.UsarCodigo')}}" class="needs-validation confirmation">
            @csrf
            <input type="hidden" name="idVistaPrevia" id="idVistaPreviaAceptar" required>

            <label for="CodigoAdminAceptar">Codigo de Autorización</label>
            <div class="input-group mb-2">
              <div class="input-group-prepend">
                <div class="input-group-text" style="padding-bottom: 0px;padding-top: 0px;font-weight: bold;border-radius: 5px 0px 0px 5px"><i class="fas fa-barcode"></i></div>
              </div>
              <input type="text" id="CodigoAdminAceptar" name="CodigoAdminAceptar" class="form-control" required="" style="border-radius: 0px !important;" maxlength="15" minlength="5">
            </div>


            <div class="row" style="justify-content: center;margin-top: 15px;">
              <button type="submit" class="btn btn-primary">Desbloquear <i class="fas fa-lock"></i></button>
            </div>
          </form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="Documentos" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Documentos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col" style="text-align: center;">
              <a href="" target="_blank" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Vista Previa" id="PDF_Previa">
                <i class="far fa-file-pdf fa-2x" aria-hidden="true" style="color:red;"></i>
              </a>
            </div>
            <div class="col" style="text-align: center;">
              <a href="" target="_blank" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Contrato" id="PDF_Contrato">
                <i class="far fa-file-pdf fa-2x" aria-hidden="true" style="color:red;"></i>
              </a>
            </div>
            <div class="col" style="text-align: center;">
              <a href="" target="_blank" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Formato personas fisicas" id="PDF_FPF">
                <i class="far fa-file-pdf fa-2x" aria-hidden="true" style="color:red;"></i>
              </a>
            </div>
            <div class="col" style="text-align: center;">
              <a href="" target="_blank" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Aviso de privacidad" id="PDF_AP">
                <i class="far fa-file-pdf fa-2x" aria-hidden="true" style="color:red;"></i>
              </a>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


  <script type="text/javascript">
  function GenerarCodigo(){
    var Codigo = "";
    var Abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    for (var i = 0; i < 4; i++) {
      Codigo += aleatorio(0, 9);
      Codigo += Abecedario[aleatorio(0, 25)];
    }
    $('#CodigoAdmin').val(Codigo);
  }

  function aleatorio(inferior, superior) {
    var numPosibilidades = superior - inferior;
    var aleatorio = Math.random() * (numPosibilidades + 1);
    aleatorio = Math.floor(aleatorio);
    return inferior + aleatorio;
  }

  function ModalCodigoFunc(id){
    $('#idVistaPrevia').val(id);
  }

  function ModalCodigoAceptarFunc(id){
    $('#idVistaPreviaAceptar').val(id);
  }

  </script>

  <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaVencidos">
    <thead>
      <tr>
        <th>#</th>
        <th>Cliente</th>
        <th>Vin</th>
        <th>Marca</th>
        <th>Versi&oacute;n</th>
        <th>Color</th>
        <th>Modelo</th>
        <th>Tipo</th>
        <th>Venta</th>
        <th>Monto</th>
        <th>Documento</th>
        <th>Acciones</th>
        <th>Estatus</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($Ventas as $key => $V)
        <tr>
          <td>{{$key+1}}</td>
          <td>{{$V->Contacto->nombre.' '.$V->Contacto->apellidos}}</td>
          <td>{{$V->vin_numero_serie}}</td>
          <td>{{$V->Unidad->marca}}</td>
          <td>{{$V->Unidad->version}}</td>
          <td>{{$V->Unidad->color}}</td>
          <td>{{$V->Unidad->modelo}}</td>
          <td style="text-align: center;">
            @if ($V->tipo_unidad == "Unidad")
              <i class="fas fa-car fa-2x" data-toggle="tooltip" data-placement="top" title="Unidad"></i>
            @elseif ($V->tipo_unidad == "Trucks")
              <i class="fas fa-truck-moving fa-2x" data-toggle="tooltip" data-placement="top" title="Trucks"></i>
            @else
              {{$V->tipo_unidad}}
            @endif
          </td>
          <td>{{$V->tipo_venta}}</td>
          <td>${{number_format($V->monto_unidad,2)}}</td>
          <td style="text-align: center;">
            @if($V->estatus == "Aceptado")
              <button data-toggle="modal" data-target="#Documentos" class="btn" onclick="PDFS([
              `{{route('vpme.pdf.vistaPrevia',Crypt::encrypt($V->id))}}`,
              `{{route('vpme.pdf.contratoDirectaContado',['id'=>Crypt::encrypt($V->id)])}}`,
              `{{route('vpme.pdf.personasFisicas',['id'=>Crypt::encrypt($V->id)])}}`,
              `{{route('vpme.pdf.aviso_privacidad',['id'=>Crypt::encrypt($V->id)])}}`
              ])">
              <i class="far fa-file-pdf fa-2x" aria-hidden="true" style="color:red;"></i>
              <span class="badge" id="Notificaciones" style="background:green;border-radius: 20px;top: -26px;color:white;">4</span>
            </button>
          @else
            <a href="{{route('vpme.pdf.vistaPrevia',Crypt::encrypt($V->id))}}" target="_blank" style="margin-top: 30px; color:white;" data-toggle="tooltip" data-placement="bottom" title="Vista Previa">
              <i class="far fa-file-pdf fa-2x" aria-hidden="true" style="color:red;"></i>
              <span class="badge" id="Notificaciones">⠀</span>
            </a>
          @endif
        </td>
        <td>
          <ul style="list-style-type: none;">

            @if($V->estatus == "Pendiente" || $V->estatus == "Rechazado")
              <li data-toggle="tooltip" data-placement="right" title="Editar">
                <a style="margin-right: 15px;" href="{{route('vpMovimientoExitoso.edit_Movement',Crypt::encrypt($V->id))}}" class='iconos-estatus tool_editar_inventario'><i class="far fa-edit  icon-DOrden font-icond font-iconrojo"></i></a>
              </li>
              <li data-toggle="tooltip" data-placement="right" title="Complementar información del cliente">
                <a  style="margin-right: 15px;"  onclick="ActualizarMovimiento({{'"'.Crypt::encrypt($V->id).'"'.',"Complementar"'}})"  class='iconos-estatus tool_editar_inventario'><i class="fa fa-plus  icon-DOrden font-icond font-iconrojo"></i></a>
              </li>
              @if($usuario_creador == "100953" || $usuario_creador == "100989" || $usuario_creador == "100990" || $usuario_creador == "100954")
                <li data-toggle="modal" data-target="#ModalCodigo">
                  <a data-toggle="tooltip" data-placement="right" title="Generar Codigo" style="margin-right: 15px;" class='iconos-estatus tool_editar_inventario' onclick="ModalCodigoFunc(`{{Crypt::encrypt($V->id)}}`)">
                    <i class="fas fa-user-tie icon-DOrden font-icond font-iconrojo"></i>
                  </a>
                </li>
                <li data-toggle="tooltip" data-placement="right" title="Aceptar Venta">
                  <a style="margin-right: 15px;"  onclick="ActualizarMovimiento({{'"'.Crypt::encrypt($V->id).'"'.',"Aceptado"'}})"  class='iconos-estatus tool_editar_inventario'><i class="fa fa-check  icon-DOrden font-icond font-iconrojo"></i></a>
                </li>
                <li data-toggle="tooltip" data-placement="right" title="Rechazar">
                  <a style="margin-right: 15px;" onclick="ActualizarMovimiento({{'"'.Crypt::encrypt($V->id).'"'.',"Rechazado"'}})" class='iconos-estatus tool_editar_inventario'><i class="fa fa-close  icon-DOrden font-icond font-iconrojo" @if($V->estatus == "Rechazado")style="color:red; font-size:28px;"@endif></i></a>
                  </li>
                @elseif ($V->codigo != null)
                  <li data-toggle="modal" data-target="#ModalCodigoAceptar">
                    <a data-toggle="tooltip" data-placement="right" title="Ingresar Codigo" style="margin-right: 15px;" class="iconos-estatus tool_editar_inventario" onclick="ModalCodigoAceptarFunc(`{{Crypt::encrypt($V->id)}}`)">
                      <i class="fas fa-barcode icon-DOrden font-icond font-iconrojo" aria-hidden="true"></i>
                    </a>
                  </li>
                @endif
              @elseif($V->estatus == "Aceptado")
                <li>
                  <a style="margin-right: 15px; pointer-events:none;"  onclick=""  class='iconos-estatus tool_editar_inventario'><i class="fa fa-check  icon-DOrden font-icond font-iconrojo"  style="color:green; font-size:28px;"></i></a>
                </li>
                @if($usuario_creador == "100953" || $usuario_creador == "100989" || $usuario_creador == "100990" || $usuario_creador == "100954")
                <li data-toggle="tooltip" data-placement="right" title="Facturar">
                  <a style="margin-right: 15px;" onclick="ActualizarMovimiento({{'"'.Crypt::encrypt($V->id).'"'.',"Facturar"'}})" class='iconos-estatus tool_editar_inventario'><i class="fa fa-file-text-o  icon-DOrden font-icond font-iconrojo"></i></a>
                  </li>
                 @endif

              @endif
            </ul>
          </td>
          <td>

            @if ($V->estatus == "Pendiente")
              @php
              $Horas = \Carbon\Carbon::parse($V->created_at)->diffInHours($FechaActual)
              @endphp
              <p @if ($Horas >= 72)
                style="color:red;"
              @elseif ($Horas >= 36 && $Horas < 72)
                style="color:#ff8d00;"
              @else
                style="color:green;"
              @endif>

              @if ($Horas >= 72 )
                <a href="{{route('vpMovimientoExitoso.VistaPagares',$V->id)}}" class="btn btn-outline-info" data-toggle="tooltip" data-placement="left" title="Generar Pagares">
                  <i class="fas fa-money-check-alt"></i>
                </a>
              @endif
              <b>
                {{$V->estatus}}
              </b>


              @if ($Horas == 0)
                {{\Carbon\Carbon::parse($V->created_at)->diffForHumans($FechaActual)}}
              @else
                {{$Horas}} {{ $Horas > 1 ? 'hrs': 'hr' }}
              @endif

              <i class="fas fa-history"></i>

            </p>
          @else
            <p>
              <b>{{$V->estatus}}</b>
            </p>
          @endif
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<script type="text/javascript">



$('#TablaVencidos').on( 'draw', function () {
  $('[data-toggle="tooltip"]').tooltip();
} );

function PDFS(rutas){
  $('#PDF_Previa').attr('href',rutas[0]);
  $('#PDF_Contrato').attr('href',rutas[1]);
  $('#PDF_FPF').attr('href',rutas[2]);
  $('#PDF_AP').attr('href',rutas[3]);
}


function ActualizarMovimiento(id,estado){

  var ruta_A = '{{route('vpMovimientoExitoso.updateMovement',['',''])}}';
  var ruta_B = '{{route('vpMovimientoExitoso.DatosExtra','')}}';
  var ruta_C = '{{route('vpMovimientoExitoso.verificarAprobarVenta',['',''])}}';
  var ruta_D = '{{route('vpMovimientoExitoso.facturacion',[''])}}';
  var ruta_index = '{{route('VPMovimientoExitoso.listaVentas')}}';


  title = ""; text = ""; className = "btn-success";
  if(estado == "Aceptado"){
    title = '¿Desea aceptar esta venta?';
  }
  if(estado == "Complementar"){
    title = '¿Desea completar esta venta?';
    text = "Requiere datos complementarios";
  }
  if(estado == "Rechazado"){
    title = "¿Actualizar a estatus "+estado+"?";
    className = "btn-danger";
  }
  if(estado == "Facturar"){
    title = "¿Desea generar factura?";
  }


  swal({
    title:   title ,
    text: text,
    icon: "info",
    buttons: {
      cancel: {
        text: "Cancelar",
        visible: true,
        className: "",
        closeModal: true,
      },
      confirm: {
        text: "OK",
        visible: true,
        className: className,
        closeModal: true
      }
    }
    ,
  })
  .then((willDelete) => {
    if (willDelete) {
      if (estado == "Aceptado") {
        var SinActivacionAdmin = `{{Crypt::encrypt(false)}}`;
        location.href = ruta_C+'/'+id+'/'+SinActivacionAdmin;
      }
      if(estado == "Rechazado"){
        location.href = ruta_A+'/'+id+'/'+estado;
      }
      if(estado == "Complementar"){
        location.href = ruta_B+'/'+id;
      }
      if(estado == "Facturar"){
        location.href = ruta_D+'/'+id;
      }
    }
  });
}

</script>

@endsection
