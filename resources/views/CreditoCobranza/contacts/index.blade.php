

@extends('layouts.appAdmin')
@section('titulo', 'Cartera Clientes/ID')
@section('content')


  <div class="loader-wrapper">
    <div class="loader-circle">
      <div class="loader-wave"></div>
    </div>
  </div>
  <div class="container-fluid">

    {{-- <div class="col-sm-9 col-xs-12 content pt-3 pl-0" style="width: 100%;"> --}}
    <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
      <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
      {{-- <span class="text-secondary"> Cartera Clientes</span> --}}
      <br>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <center><h1><i class="far fa-address-book fa-2x"></i></h1></center>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <i class="fa fa-filter fa-2x fa-fw"></i><b>Asesor: &nbsp;</b>
        </div>
        @foreach ($asesores as $asesor)
          <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">
            <span>
              <input onchange='filterme()' type='checkbox' class='filtros' name='ases' value='{{$asesor->nomeclatura}}'> {{$asesor->nomeclatura}}<!-- &nbsp; &nbsp;-->
            </span>
          </div>
        @endforeach
      </div>
      <div class="row">
        <div class="col-12">
          <i class="fa fa-filter fa-2x fa-fw"></i><b>Cliente: </b>
        </div>
        @foreach ($clientes_tipos as $cliente_tipo)
          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">
            <span>
              <input onchange='filterme()' type='checkbox' class='filtros' name='tcli' value='{{$cliente_tipo->nombre}}'> {{$cliente_tipo->nombre}}&nbsp; &nbsp;
            </span>
          </div>
        @endforeach
      </div>
      <div class="row">
        <div class="col-12">
          <i class="fa fa-filter fa-2x fa-fw"></i><b>Crédito: </b>
        </div>
        @foreach ($credito_tipos as $credito_tipo)
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
            <span>
              <input onchange='filterme()' type='checkbox' class='filtros' name='cred' value='{{$credito_tipo->nombre}}'> {{$credito_tipo->nombre}}&nbsp; &nbsp;
            </span>
          </div>
        @endforeach
      </div>
      <hr>
      {{-- </center> --}}
      <div class="table-responsive">
        <div class="form-group">
          <div class="panel-body datatable-panel">
            <table class="ui celled table" style="width:100%" id="dataTables-example">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Alias</th>
                  <th>Teléfono Celular</th>
                  <th>Asesor</th>
                  <th>Tipo Cliente</th>
                  <th>Tipo Crédito</th>
                  <th>Municipio</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($contactos as $contacto)
                  <tr class='odd gradeX'>
                    <td><a href='{{route('CreditoCobranza.contact.show',Crypt::encrypt($contacto->idcontacto))}}'>{{$contacto->idcontacto}}</a></td>
                    <td>{{$contacto->nombre}}</td>
                    <td>{{$contacto->apellidos}}</td>
                    <td>{{$contacto->alias}}</td>
                    <td>{{$contacto->telefono_celular}}</td>
                    <td>{{$contacto->asesor_nomenclatura($contacto->asesor)['nomeclatura']}}</td>
                    <td>{{$contacto->tipo_cliente_nombre($contacto->tipo_cliente)['nombre']}}</td>
                    <td>{{$contacto->tipo_credito_nombre($contacto->tipo_credito)['nombre']}}</td>
                    {{-- <td>{{$contacto->tipo_credito}}</td> --}}
                    <td>{{$contacto->delmuni}}</td>
                    <td>{{$contacto->estado}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- </div> --}}
<script>
// $('#dataTables-example').dataTable( {
//     paging: false,
//     searching: false
// } );
// $(document).ready(function() {
//   $('#dataTables-example').DataTable({
//     language: {
//       "decimal": "",
//       "emptyTable": "No hay información",
//       "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
//       "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
//       "infoFiltered": "(Filtrado de _MAX_ total entradas)",
//       "infoPostFix": "",
//       "thousands": ",",
//       "lengthMenu": "Mostrar _MENU_ Entradas",
//       "loadingRecords": "Cargando...",
//       "processing": "Procesando...",
//       "search": "Buscar:",
//       "zeroRecords": "Sin resultados encontrados",
//       "paginate": {
//         "first": "Primero",
//         "last": "Ultimo",
//         "next": "Siguiente",
//         "previous": "Anterior"
//       }
//     },
//     responsive: true,
//     lengthMenu: [[10, 25, 50,-1], [10, 25, 50, "All"]],
//     dom: 'Blfrtip'
//   });
//   var table = $('#dataTables-example').DataTable();
//   table
//   .order([ 0, 'asc' ])
//   .draw();
// });
// $(function() {
//   otable = $('table').dataTable();
// })
function filterme() {
  otable = $('table').dataTable();
  var types = $('input:checkbox[name="ases"]:checked').map(function() {
    return '^' + this.value + '\$';
  }).get().join('|');
  otable.fnFilter(types, 5, true, false, false, false);
  var types = $('input:checkbox[name="tcli"]:checked').map(function() {
    return '^' + this.value + '\$';
  }).get().join('|');
  otable.fnFilter(types, 6, true, false, false, false);
  var types = $('input:checkbox[name="cred"]:checked').map(function() {
    return '^' + this.value + '\$';
  }).get().join('|');
  otable.fnFilter(types, 7, true, false, false, false);
}
</script>



@endsection
