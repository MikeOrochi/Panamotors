@extends('layouts.appAdmin')
@section('titulo', 'CCP | Costo Total VIN')

@section('js')
@endsection

@section('content')
  <div class="row mt-3">
    <div class="col-sm-12">
      <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
        <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
        <span class="text-secondary"> <a href="vin.php">  VIN</a> <i class="fa fa-angle-right"></i> </span>
        <span class="text-secondary"> Costo Total</span>
        <br>
        <br>
        <center>
          <h2>Costo Total del VIN</h2><i class="fa fa-car fa-3x" aria-hidden="true"></i>
        </center>
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
              <tr>
                <th><center>#</center></th>
                <th><center>Fecha</center></th>
                <th><center>Concepto</center></th>
                <th><center>Departamento</center></th>
                <th><center>Tipo</center></th>
                <th><center>No. de Referencia</center></th>
                <th><center>Proveedor</center></th>
                <th><center>Cantidad</center></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($Resultado as $key => $R)
                <tr
                @isset($R->link)
                  id="{{$R->link}}" data-toggle='tooltip' data-placement='top' title='Clic'
                @endisset
                >
                <td>{{($key+1)}}</td>
                <td>{{\Carbon\Carbon::parse($R->fecha_movimiento)->format('d/m/Y')}}</td>
                <td>{{$R->concepto}}</td>
                <td>{{$R->departamento}}</td>
                <td>Adquisicion</td>
                <td>{{$R->referencia}}</td>
                <td>{{$R->proveedor}}</td>
                <td>${{number_format($R->monto_precio,2)}}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th><center>#</center></th>
              <th><center>Fecha</center></th>
              <th><center>Concepto</center></th>
              <th><center>Departamento</center></th>
              <th><center>Tipo</center></th>
              <th><center>No. de Referencia</center></th>
              <th><center>Proveedor</center></th>
              <th><center>Cantidad</center></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="modal fade" id="pdf_costo_total" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visualizar PDF de costo total</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action='estado_cuenta_pdf.php' target='_blank'>
              <div class="form-group">
                <label for="password">Password Asignada</label>
                <input type="password" class="form-control" id="password1" onchange="validar_password_costo_total()" autocomplete="off" placeholder="Ingresa password">
                <center><i class="fa fa-eye fa-2x" id="mostrar"></i></center>
              </div>
              <input type='hidden' id='lat_l1' name='latlong'>
              <input type='hidden' id='rute' value=''>
              <input type='hidden' id='usuario_view' value='{{$usuario_creador}}'>
              <!-- <input type='text' name='pass' id='pass'> -->
              <input type='hidden' name='pase_visualizacion1' id='pase_visualizacion1' value="Tk8=">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="BtnVisualizar" class="btn btn-success" data-dismiss="modal" onclick="ver_pdf_costo_total()" disabled>Visualizar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">

document.addEventListener("DOMContentLoaded", function(event) {

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    iziToast.warning({
      title: 'Atención',
      message: 'Geolocalización no es soportada en este buscador',
    });
  }

  function showPosition(position) {
    var Latitud = position.coords.latitude;
    var Longitud = position.coords.longitude;
    var lat_long =Latitud+", "+Longitud;
    document.getElementById("lat_l1").value =  lat_long ;
  }

});

function validar_password_costo_total() {
  var password_access = $("#password1").val();
  var usuario_view = $("#usuario_view").val();

  $('#BtnVisualizar').prop("disabled",true);
  $('#BtnVisualizar').html('<i class="fas fa-spinner fa-spin"></i>');


  fetch("{{route('CostoTotalVIN.password')}}", {
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-Token": '{{csrf_token()}}',
    },
    method: "post",
    credentials: "same-origin",
    body: JSON.stringify({
      "password_access" : password_access,
      "usuario_view" : usuario_view
    })
  }).then(res => res.json())
  .catch(function(error){
    console.error('Error:', error)
  })
  .then(function(response){
    console.log(response);
    $('#BtnVisualizar').prop("disabled",false);
    $('#BtnVisualizar').html('Visualizar');
    if (response === "SI") {
      $("#pase_visualizacion1").val('U0k=');
    }else{
      $("#pase_visualizacion1").val('Tk8=');
    }
  });

}

$("#example tbody tr").click(function() {
  if ($(this).attr('id') === undefined){
    iziToast.warning({
      title: 'Atención',
      message: 'Este movimiento no genera costo total',
    });
  }else{

    @if ($Id_Empleado == 88 || $Id_Empleado == 91 || $Id_Empleado == 257 || $Id_Empleado == 258 || $Id_Empleado == 259)
    $("#rute").val($(this).attr('id'));
    $("#pdf_costo_total").modal();
    $("#password1").focus();
    @else
    iziToast.warning({
      title: 'Atención',
      message: 'No tienes los permisos nevesarios',
    });
    @endif

  }
});
$('#mostrar').click(function(){
  if($(this).hasClass('fa-eye')){
    $('#password1').removeAttr('type');
    $('#mostrar').addClass('fa-eye-slash').removeClass('fa-eye');
  }else{
    $('#password1').attr('type','password');
    $('#mostrar').addClass('fa-eye').removeClass('fa-eye-slash');
  }
});

function ver_pdf_costo_total() {
  var valiacion_pass = $("#pase_visualizacion1").val();
  if (valiacion_pass === 'U0k=' || true) {
    var rute = $("#rute").val();
    var lat_l1 = btoa($("#lat_l1").val());
    $("#password1").val('');
    window.open(rute+'/'+lat_l1)    
  }else{
    $("#password1").val('');
    iziToast.warning({
      title: 'Atención',
      message: 'Valida tu Contraseña',
    });
  }
}
</script>

@endsection
