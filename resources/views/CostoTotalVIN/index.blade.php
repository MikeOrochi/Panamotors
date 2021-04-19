@extends('layouts.appAdmin')
@section('titulo', 'CCP | Costo Total VIN')

@section('js')
@endsection

@section('head')
  @include('partials.loader')
@endsection

@section('content')

  <div class="row mt-3">
    <div class="col-sm-12">

      <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">

        <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
        <span class="text-secondary"> VIN</span>

        <form class="needs-validation" action="" method="post" onsubmit="BuscarVIN(event)">
          <div class="row">
            <div class="col-sm-12 form-group">
              <label for="">Buscar:</label>
              <input type="text" class="form-control buscar_vin" placeholder="Buscar VIN" id="buscar_vin" required>
            </div>
            <div style="height: 250px;display:none;" id="Loading">
              <div class="loaderT">
                <div class="innerLoading one"></div>
                <div class="innerLoading two"></div>
                <div class="innerLoading three"></div>
              </div>
            </div>
            <div class="col-sm-12 form-group">
              <center>
                <button type="submit" class="btn btn-primary btn-lg buscar">Buscar</button>
              </center>
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-12 form-group">
            <div id="respuesta" style="display:none;">
              <center><img src='{{secure_asset('storage/app/805.gif')}}' alt='' style='width:70px;'></center>
            </div>

            <div class="table-responsive" id="DivTabla" style="display:none;">
              <table id="TablaVIN" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>VIN</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Version</th>
                    <th>Color</th>
                  </tr>
                </thead>
                <tbody id="BodyTablaVIN">
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>VIN</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Version</th>
                    <th>Color</th>
                  </tr>
                </tfoot>
              </table>
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>


  <script type="text/javascript">

  var Ruta = '{{route('CostoTotalVIN.show','')}}';
  function BuscarVIN(event){

    event.preventDefault();
    event.stopPropagation();

    $('#Loading').fadeIn();

    let buscar_vin = $("#buscar_vin").val().trim();
    $("#respuesta").fadeIn();
    $('#DivTabla').fadeOut();
    $("#TablaVIN").dataTable().fnDestroy();
    $('#BodyTablaVIN').html('');

    fetch("{{route('CostoTotalVIN.searh')}}", {
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-Token": '{{csrf_token()}}',
      },
      method: "post",
      credentials: "same-origin",
      body: JSON.stringify({
        vin : buscar_vin
      })
    }).then(res => res.json())
    .catch(function(error){
      $('#Loading').fadeOut();
      $("#respuesta").fadeOut();
      iziToast.error({
        title: 'Error',
        message: error,
      });
      //console.error('Error:', error);
    })
    .then(function(response){

      console.log(response);
      $('#Loading').fadeOut();
      $("#respuesta").fadeOut();
      $('#DivTabla').fadeIn();

      response.forEach(function logArrayElements(element, index, array) {
        $('#BodyTablaVIN').append(`
          <tr>
          <td>`+(index+1)+`</td>
          <td><a href="`+(Ruta+'/'+element.vin_numero_serie)+`" target="_blank">`+element.vin_numero_serie+`</a></td>
          <td>`+element.marca+`</td>
          <td>`+element.modelo+`</td>
          <td>`+element.version+`</td>
          <td>`+element.color+`</td>
          </tr>
          `);
        });

        CrearDataT('TablaVIN');

      });


    }
    </script>

  @endsection
