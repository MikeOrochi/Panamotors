@extends('layouts.appAdmin')
@section('titulo', 'Salida de tracktocamiones de taller')
@section('content')
  <style media="screen">
  /* Style the form */
  #regForm {
    background-color: #ffffff;
    margin: 100px auto;
    padding: 40px;
    width: 70%;
    min-width: 300px;
  }

  /* Style the input fields */
  input {
    padding: 10px;
    width: 100%;
    font-size: 17px;
    font-family: Raleway;
    border: 1px solid #aaaaaa;
  }

  /* Mark input boxes that gets an error on validation: */
  input.invalid {
    background-color: #ffdddd;
  }

  /* Hide all steps by default: */
  .tab {
    display: none;
  }

  /* Make circles that indicate the steps of the form: */
  .step {
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbbbbb;
    border: none;
    border-radius: 50%;
    display: inline-block;
    opacity: 0.5;
  }

  /* Mark the active step: */
  .step.active {
    opacity: 1;
  }

  /* Mark the steps that are finished and valid: */
  .step.finish {
    background-color: #4CAF50;
  }
  input[type='range'] {
    display: block;
    /* width: 250px; */
  }

  input[type='range']:focus {
    outline: none;
  }

  input[type='range'],
  input[type='range']::-webkit-slider-runnable-track,
  input[type='range']::-webkit-slider-thumb {
    -webkit-appearance: none;
  }

  input[type=range]::-webkit-slider-thumb {
    background-color: #777;
    width: 20px;
    height: 20px;
    border: 3px solid #333;
    border-radius: 50%;
    margin-top: -9px;
  }

  input[type=range]::-moz-range-thumb {
    background-color: #777;
    width: 15px;
    height: 15px;
    border: 3px solid #333;
    border-radius: 50%;
  }

  input[type=range]::-ms-thumb {
    background-color: #777;
    width: 20px;
    height: 20px;
    border: 3px solid #333;
    border-radius: 50%;
  }

  input[type=range]::-webkit-slider-runnable-track {
    background-color: #777;
    height: 3px;
  }

  input[type=range]:focus::-webkit-slider-runnable-track {
    outline: none;
  }

  input[type=range]::-moz-range-track {
    background-color: #777;
    height: 3px;
  }

  input[type=range]::-ms-track {
    background-color: #777;
    height: 3px;
  }

  input[type=range]::-ms-fill-lower {
    background-color: HotPink
  }

  input[type=range]::-ms-fill-upper {
    background-color: black;
  }
}
</style>
<div class="row mt-3">
  <div class="col-sm-12">
    <div class="shadow panel-head-primary">
      <div class="container" style="padding-bottom: 50px; padding-top: 50px;">
        <center><h3>Unidades pendientes de asignar</h3></center>
        <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaVencidos">
          <thead>
            <tr>
              <th>#</th>
              <th>Unidad</th>
              {{-- <th>Responsable</th> --}}
              <th>Motivo de ingreso</th>
              <th>Fecha estimada</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($solicitud_taller_trucks_pendientes as $key => $solicitud)
              <tr>
                <td>{{$key+1}}</td>
                <td>
                    {{-- @php $unidad = $solicitud->getTruck($solicitud->idinventario_trucks) @endphp --}}
                    <b>VIN: </b>{{$solicitud->vin}}<br>
                    <b>Marca: </b>{{$solicitud->marca}}<br>
                    <b>Marca: </b>{{$solicitud->version}}<br>
                    <b>Modelo: </b>{{$solicitud->modelo}}<br>
                    <b>Color: </b>{{$solicitud->color}}<br>
                </td>
                {{-- <td>{{$solicitud->empleado}}</td> --}}
                <td>{{$solicitud->descripcion}}</td>
                <td>
                  @if ($solicitud->fecha_ingreso=='0000-00-00 00:00:00')
                    00-00-0000                         
                  @else
                    {{\Carbon\Carbon::parse($solicitud->fecha_ingreso)->format('d-m-Y')}}</td>
                  @endif
                <td align='center'> 
                  {{-- <button type="button" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Asignar mecanico" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-user-plus" aria-hidden="true" style="color: white;"></i></button> --}}
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-toggle="tooltip" data-placement="top" title="Asignar mecanico" onclick="addMechanic('{{Crypt::encrypt($solicitud->id)}}');">
                    <i class="fa fa-user-plus" aria-hidden="true" style="color: white;"></i>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <center><h3>Unidades asignadas pendientes de reparación</h3></center>
        <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaVencidos">
          <thead>
            <tr>
              <th>#</th>
              <th>Unidad</th>
              <th>Responsable</th>
              <th>Motivo de ingreso</th>
              <th>Fecha ingreso</th>
              <th>Fecha estimada</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($solicitud_taller_trucks as $key => $solicitud2)
              <tr>
                <td>{{$key+1}}</td>
                <td>
                    {{-- @php $unidad = $solicitud->getTruck($solicitud->idinventario_trucks) @endphp --}}
                    <b>VIN: </b>{{$solicitud2->vin}}<br>
                    <b>Marca: </b>{{$solicitud2->marca}}<br>
                    <b>Marca: </b>{{$solicitud2->version}}<br>
                    <b>Modelo: </b>{{$solicitud2->modelo}}<br>
                    <b>Color: </b>{{$solicitud2->color}}<br>
                </td>
                <td>{{$solicitud2->empleado}}</td>
                <td>{{$solicitud2->descripcion}}</td>
                <td>{{\Carbon\Carbon::parse($solicitud2->fecha_ingreso)->format('d-m-Y')}}</td>
                <td>{{$solicitud2->fecha_estimada}}</td>
                <td align='center'>
                  <a href="{{route('taller_trackto.checks.new',Crypt::encrypt($solicitud2->id))}}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Cambiar a en proceso"><i class="fa fa-play" aria-hidden="true" style="color: white;"></i></a>
                  <a href="{{route('taller_trackto.asignacion.pdf',Crypt::encrypt($solicitud2->id))}}" target="_blank" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Orden de asignación"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: white;"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <center><h3>Unidades en proceso de reparación</h3></center>
        <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaVencidos">
          <thead>
            <tr>
              <th>#</th>
              <th>Unidad</th>
              <th>Responsable</th>
              <th>Motivo de ingreso</th>
              <th>Fecha de estimada</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($solicitud_taller_trucks_validando as $key => $solicitud3)
              <tr>
                <td>{{$key+1}}</td>
                <td>
                    {{-- @php $unidad = $solicitud->getTruck($solicitud->idinventario_trucks) @endphp --}}
                    <b>VIN: </b>{{$solicitud3->vin}}<br>
                    <b>Marca: </b>{{$solicitud3->marca}}<br>
                    <b>Marca: </b>{{$solicitud3->version}}<br>
                    <b>Modelo: </b>{{$solicitud3->modelo}}<br>
                    <b>Color: </b>{{$solicitud3->color}}<br>
                </td>
                <td>{{$solicitud3->empleado}}</td>
                <td>{{$solicitud3->descripcion}}</td>
                <td>{{$solicitud3->fecha_estimada}}</td>
                <td align='center'>
                  <a href="{{route('SalidasTallerTrackto.new',Crypt::encrypt($solicitud3->id))}}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Gestionar salida"><i class="fa fa-eye" aria-hidden="true" style="color: white;"></i></a>
                  <a href="{{route('taller_trackto.checks.new',Crypt::encrypt($solicitud3->id))}}" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Añadir revisión"><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: white;"></i></a>
                  <a href="" class="btn btn-success"><i class="fa fa-upload" aria-hidden="true" style="color: white;"></i></a>
                  <a href="" class="btn btn-info"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: white;"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <center><h3>Unidades enviadas a punto de venta</h3></center>
        <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="TablaVencidos">
          <thead>
            <tr>
              <th>#</th>
              <th>Unidad</th>
              <th>Responsable</th>
              <th>Motivo de ingreso</th>
              <th>Fecha de salida</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($solicitud_taller_trucks_liberado as $key => $solicitud4)
              <tr>
                <td>{{$key+1}}</td>
                <td>
                    {{-- @php $unidad = $solicitud->getTruck($solicitud->idinventario_trucks) @endphp --}}
                    <b>VIN: </b>{{$solicitud4->vin}}<br>
                    <b>Marca: </b>{{$solicitud4->marca}}<br>
                    <b>Marca: </b>{{$solicitud4->version}}<br>
                    <b>Modelo: </b>{{$solicitud4->modelo}}<br>
                    <b>Color: </b>{{$solicitud4->color}}<br>
                </td>
                <td>{{$solicitud4->empleado}}</td>
                <td>{{$solicitud4->descripcion}}</td>
                <td>@if ($solicitud4->fecha_salida)
                  {{\Carbon\Carbon::parse($solicitud4->fecha_salida)->format('d-m-Y')}}
                @endif</td>
                {{-- <td>{{\Carbon\Carbon::parse($solicitud->fecha_salida)->format('d-m-Y')}}</td> --}}
                <td align='center'>
                  <a href="" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true" style="color: white;"></i></a>
                  <a href="" class="btn btn-info"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: white;"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5  id="exampleModalLabel">Asignar mecánico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="text" name="request_mechanic" id='request_mechanic' class="form-control" value="{{8}}">
        <select class="js-example-basic-single" style="width:100%; height:50px !important;" id="employee" name="employee" value='employee'>
          {{-- @foreach ($empleados as $empleado)
            <option value='{{$empleado->idempleados}}'>{{$empleado->nombre.' '.$empleado->apellido_paterno.' '.$empleado->apellido_materno}}</option>
          @endforeach --}}
          <option value="José Israel Ceja Menchaca">José Israel Ceja Menchaca</option>
          <option value="Oscar Martínez Santillán">Oscar Martínez Santillán</option>
          <option value="Gerardo Eugenio Gonzales Cancino">Gerardo Eugenio Gonzales Cancino</option>
        </select>
      </div>
      <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
        <button type="button" class="btn btn-primary">Asignar</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function addMechanic(id) {
  console.log(id);
  $("#request_mechanic").val('30');
  // document.getElementById('request_mechanic').value=id;
}
$(document).ready(function() {
  $('#stetic_range').change(function() {
    let stetic_range = $("#stetic_range").val();
    document.getElementById('stetic').innerHTML = 'Nivel de estetica: '+stetic_range+'%';
  });
  $('#stetic_range').mousemove(function() {
    let stetic_range = $("#stetic_range").val();
    document.getElementById('stetic').innerHTML = 'Nivel de estetica: '+stetic_range+'%';
  });
  $('#petrol_range').change(function() {
    let petrol_range = $("#petrol_range").val();
    document.getElementById('petrol').innerHTML = 'Combustible: '+petrol_range+' cm';
  });
  $('#petrol_range').mousemove(function() {
    let petrol_range = $("#petrol_range").val();
    document.getElementById('petrol').innerHTML = 'Combustible: '+petrol_range+' cm';
  });

});
var Temporizador_VIN;
var BusquedaVinTexto = null;

function buscar_vin_bloqueado() {
  if (BusquedaVinTexto != $("#busqueda_vin").val().trim()) {
    BusquedaVinTexto = $("#busqueda_vin").val().trim();

    $('#resultadoBusquedaVin').html(`
      <div class="text-center">
      <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
      </div>
      </div>`);

      clearTimeout(Temporizador_VIN);
      Temporizador_VIN = setTimeout(function() {
        buscar_vin_bloqueado_Tempo();
      }, 350);
    }
  }



  //---------------------------------------------------------------------------------------------------------------------------------------------
  function buscar_vin_bloqueado_Tempo() {

    var textoBusquedaVin = $("#busqueda_vin").val().trim();

    if (textoBusquedaVin != "") {

      fetch("{{route('search.trackto.solicitud')}}", {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-Token": '{{csrf_token()}}',
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
          valorBusqueda: textoBusquedaVin
        })
      }).then(res => res.json())
      .catch(function(error) {
        console.error('Error:', error)
      })
      .then(function(response) {

        console.log(response);

        if (response != null) {

          $("#resultadoBusquedaVin").html('');
          $("#marca_venta").attr("readonly", "readonly");
          $("#version_venta").attr("readonly", "readonly");
          $("#color_venta").attr("readonly", "readonly");
          $("#modelo_venta").attr("readonly", "readonly");
          $("#vin_venta").attr("readonly", "readonly");

          response.forEach(function logArrayElements(element, index, array) {

            $("#resultadoBusquedaVin").append(`
              <option class="sugerencias_vin" onclick="SugerenciaVIN('` +
              (element.idinventario_trucks || element.idinventario) + `','` +
              element.marca + `','` +
              element.version + `','` +
              element.color + `','` +
              element.modelo + `','` +
              element.vin_numero_serie + `')">` +
              element.marca + `-` + element.version + `-` +
              element.color + `-` + element.modelo + `-` +
              element.vin_numero_serie + `</option>`);
            });
          } else {
            $("#resultadoBusquedaVin").html("<b>Ingresa un VIN valido para poder continuar</b>");
            $("#marca_venta").val("").removeAttr("readonly").css("border-color", "#A0213C").focus();
            $("#modelo_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
            $("#color_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
            $("#version_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
            $("#vin_venta").val("").removeAttr("readonly").css("border-color", "#A0213C");
            $("#orden_logistica").val("SI");
            $('#show_info_tracto').hide();

          }

        });


      } else {
        $("#resultadoBusquedaVin").html('<p><b>No es posible realizar la busqueda con datos incompletos.</b></p>');
      };
    }
    function SugerenciaVIN(id, marca, version, color, modelo, NoSerie) {

      var textoBusquedaVin = NoSerie;
      var unidad_marca = marca;
      var unidad_modelo = modelo;
      var unidad_version = version;
      var unidad_color = color;

      var idbusquedaContacto = '';

      $('#Myloader').fadeIn();

      fetch("{{route('search_lock.vin')}}", {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-Token": '{{csrf_token()}}',
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
          valorBusqueda: textoBusquedaVin,
          idCliente: idbusquedaContacto
        })
      }).then(res => res.json())
      .catch(function(error) {
        console.error('Error:', error);
        $('#Myloader').fadeOut();
      })
      .then(function(mensaje_vin_bloqueado) {

        $('#Myloader').fadeOut();

        if (mensaje_vin_bloqueado == 3) { //El vin aparece como pendiente en el estado de cuenta general

          iziToast.error({
            title: 'Atención',
            message: 'El VIN se encontró como Pendiente de otro cliente',
            position: 'topRight'
          });

          $("#marca_venta").val("").attr("readonly", "readonly");
          $("#modelo_venta").val("").attr("readonly", "readonly");
          $("#version_venta").val("").attr("readonly", "readonly");
          $("#color_venta").val("").attr("readonly", "readonly");
          $("#vin_venta").val("").attr("readonly", "readonly");
        } //end if; El vin aparece como pendiente en el estado de cuenta general
        else if (mensaje_vin_bloqueado == 2) { //El vin aparece activo en el inventario

          iziToast.error({
            title: 'Atención',
            message: 'El VIN se encontró activo en el Inventario',
            position: 'topRight'
          });

          $("#marca_venta").val("").attr("readonly", "readonly");
          $("#modelo_venta").val("").attr("readonly", "readonly");
          $("#version_venta").val("").attr("readonly", "readonly");
          $("#color_venta").val("").attr("readonly", "readonly");
          $("#vin_venta").val("").attr("readonly", "readonly");
        }
        //end elseif; El vin aparece activo en el inventario
        else if (mensaje_vin_bloqueado == 1) { //El vin ya fue ingresado en una orden logistica

          iziToast.warning({
            title: 'Atención',
            message: 'El VIN se encontró activo en una Orden de Logistica',
            position: 'topRight'
          });

          $("#marca_venta").val(unidad_marca).attr("readonly", "readonly");
          $("#modelo_venta").val(unidad_modelo).attr("readonly", "readonly");
          $("#version_venta").val(unidad_version).attr("readonly", "readonly");
          $("#color_venta").val(unidad_color).attr("readonly", "readonly");
          $("#vin_venta").val(textoBusquedaVin).attr("readonly", "readonly");
          $("#orden_logistica").val("NO");
        } //end elseif; El vin ya fue ingresado en una orden logistica
        else { //El VIN se puede recibir
          $("#marca_venta").val(unidad_marca).attr("readonly", "readonly");
          $("#modelo_venta").val(unidad_modelo).attr("readonly", "readonly");
          $("#version_venta").val(unidad_version).attr("readonly", "readonly");
          $("#color_venta").val(unidad_color).attr("readonly", "readonly");
          $("#vin_venta").val(textoBusquedaVin).attr("readonly", "readonly");
          $("#orden_logistica").val("SI");
        } //end else; El VIN se puede recibir
        $("#resultadoBusquedaVin").html("");
        $('#show_info_tracto').show();

      });

    }

    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab

    function showTab(n) {
      // This function will display the specified tab of the form ...
      var x = document.getElementsByClassName("tab");
      x[n].style.display = "block";
      // ... and fix the Previous/Next buttons:
      if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
      } else {
        document.getElementById("prevBtn").style.display = "inline";
      }
      if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Guardar";
      } else {
        document.getElementById("nextBtn").innerHTML = "Siguiente";
      }
      // ... and run a function that displays the correct step indicator:
      fixStepIndicator(n)
    }

    function nextPrev(n) {
      // This function will figure out which tab to display
      var x = document.getElementsByClassName("tab");
      // Exit the function if any field in the current tab is invalid:
      if (n == 1 && !validateForm()) return false;
      // Hide the current tab:
      x[currentTab].style.display = "none";
      // Increase or decrease the current tab by 1:
      currentTab = currentTab + n;
      // if you have reached the end of the form... :
      if (currentTab >= x.length) {
        //...the form gets submitted:
        document.getElementById("regForm").submit();
        return false;
      }
      // Otherwise, display the correct tab:
      showTab(currentTab);
    }

    function validateForm() {
      // This function deals with validation of the form fields
      var x, y, i, valid = true;
      x = document.getElementsByClassName("tab");
      y = x[currentTab].getElementsByTagName("input");
      // A loop that checks every input field in the current tab:
      for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
          // add an "invalid" class to the field:
          y[i].className += " invalid";
          // and set the current valid status to false:
          valid = false;
        }
      }
      // If the valid status is true, mark the step as finished and valid:
      if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
      }
      return valid; // return the valid status
    }

    function fixStepIndicator(n) {
      // This function removes the "active" class of all steps...
      var i, x = document.getElementsByClassName("step");
      for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
      }
      //... and adds the "active" class to the current step:
      x[n].className += " active";
    }
    </script>
  @endsection
