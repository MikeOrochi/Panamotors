@extends('layouts.appAdmin')
@section('titulo', 'CCP | Recibos proveedor')
@section('content')

  <div class="container">
    <a class="btn-back" style="margin-left:1px;" href="{{route('account_status.showAccountStatus',$id)}}"><i class="fas fa-chevron-left"></i> Resumen de movimientos</a>


    <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Concepto</th>
          <th>Monto</th>
          <th>Moneda</th>
          <th>Tipo de cambio</th>
          <th>Gran total</th>
          <th>Referencia</th>
          <th>Estado de Cuenta</th>
        </tr>
      </thead>

      <tbody>
        @foreach ($Recibos as $key => $r)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$r->concepto}}</td>
            <td>{{$r->monto}}</td>
            <td>{{$r->tipo_moneda}}</td>
            <td>{{$r->tipo_cambio}}</td>
            <td>{{$r->gran_total}}</td>
            <td>{{$r->referencia}}</td>
            <td class="text-center">
               @php $id_recibo = Crypt::encrypt($r->idrecibos_proveedores)@endphp
              <button data-toggle="modal" data-target="#ModalEstadoCuenta" type="button" name="button" onclick="BuscarEstadoCuenta({{$r->id_estado_cuenta}},'{{ $id_recibo }}')" class="btn btn-success"><i class="fas fa-file-alt"></i></button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>


  <script type="text/javascript">
  function BuscarEstadoCuenta(id, id_recibo){

    var Ruta = "{{route('account.summary.index',$id)}}";
    var pdfVoucher = "{{route('vouchers.viewVoucher',['type_view'=>'pdf',''])}}/"+id_recibo;

    $('#ModalBody').html(
    `<div class="text-center">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>`);


    fetch("{{route('pagare.search')}}", {
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-Token": '{{csrf_token()}}',
      },
      method: "post",
      credentials: "same-origin",
      body: JSON.stringify({
        idEC : id
      })
    }).then(res => res.json())
    .catch(function(error){
      console.error('Error:', error);
      $('#ModalBody').html(error);
    })
    .then(function(response){
      $('#ModalBody').html('');
      console.log(response);

      if (response == null) {
          $('#ModalBody').html('<p style="color:red;">No se pudo encontrar o hubo un error</p>');
      }else{
        $('#ModalBody').append('<p><b>Concepto: &nbsp;</b>'+response.concepto+'</p>');
        $('#ModalBody').append('<p><b>Efecto: &nbsp;</b>'+response.efecto_movimiento+'</p>');
        $('#ModalBody').append('<p><b>Color: &nbsp;</b>'+response.datos_color+'</p>');
        $('#ModalBody').append('<p><b>Estatus: &nbsp;</b>'+response.datos_estatus+'</p>');
        $('#ModalBody').append('<p><b>Marca: &nbsp;</b>'+response.datos_marca+'</p>');
        $('#ModalBody').append('<p><b>Modelo: &nbsp;</b>'+response.datos_modelo+'</p>');
        $('#ModalBody').append('<p><b>Precio: &nbsp;</b>'+response.datos_precio+'</p>');
        $('#ModalBody').append('<p><b>Version: &nbsp;</b>'+response.datos_version+'</p>');
        $('#ModalBody').append('<p><b>VIN: &nbsp;</b>'+response.datos_vin+'</p>');
        $('#ModalBody').append('<p><b>Emisor Agente: &nbsp;</b>'+response.emisora_agente+'</p>');
        $('#ModalBody').append('<p><b>Institución Emisora: &nbsp;</b>'+response.emisora_institucion+'</p>');
        $('#ModalBody').append('<p><b>Institución Receptora: &nbsp;</b>'+response.receptora_institucion+'</p>');
        $('#ModalBody').append('<p><b>Referencia: &nbsp;</b>'+response.referencia+'</p>');
        $('#ModalBody').append('<a class="btn btn-info" href="'+Ruta+'/'+response.idestado_cuenta_proveedores+'"><font color=white>Resumen</font></a>');
        // $('#ModalBody').append('<a class="btn btn-success" href="https://www.dualtrucks.com/Des/CCDT/Perfiles2/CCP/vista-recibo/pdf/eyJpdiI6IjBKYWdCRU5PcDNPeTMwbnNMSUpyR0E9PSIsInZhbHVlIjoiTDdFSXVqSHFDQUc4UzhIN2xtb2QrQT09IiwibWFjIjoiYWQ0NDNiZjYyM2ViNWJmZGU5ZmM0NTc4MzliMTc2MmZhMWUwNjhlNTUyYTMxMjI5NjEyNzlkZDczYWY0ZTY4OCJ9" target="_blank">Recibo</a>');
        $('#ModalBody').append('<a class="btn btn-success" href="'+pdfVoucher+'" target="_blank"><font color=white>Recibo</font></a>');
      }





    });
  }
</script>

<!-- Modal -->
<div class="modal fade" id="ModalEstadoCuenta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Estado de Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="ModalBody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endsection
