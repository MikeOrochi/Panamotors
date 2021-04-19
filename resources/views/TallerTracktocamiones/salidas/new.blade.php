@extends('layouts.appAdmin')
@section('titulo', 'Ingreso de tracktocamiones a taller')
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
        <div class="container" style="padding-bottom: 50px;">
          <div class="row">
            <form id="regForm" action="{{route('trackto.free.store')}}" method="post">
              @csrf
              <h1>Documentar salida:</h1>

              <!-- One "tab" for each step in the form: -->
              <div class="tab"><br>
                @php $unidad = $solicitud_taller_trucks->getTruck($solicitud_taller_trucks->idinventario_trucks) @endphp
                <b>VIN: </b>{{$unidad->vin_numero_serie}}<br>
                <b>Marca: </b>{{$unidad->marca}}<br>
                <b>Modelo: </b>{{$unidad->modelo}}<br>
                <b>Color: </b>{{$unidad->color}}<br>
                <b>Descripción: </b>{{$solicitud_taller_trucks->descripcion}}<br>
                <b>Responsable: </b>{{$solicitud_taller_trucks->getEmployee($solicitud_taller_trucks->idempleado)}}
                {{-- {{$solicitud_taller_trucks}} --}}

                {{-- <p><input placeholder="Otro dato..." oninput="this.className = ''"></p> --}}
                {{-- <p><input placeholder="Last name..." oninput="this.className = ''"></p> --}}
              </div>

              <div class="tab">
                <div class="form-group">
                  {{-- <label for="exampleFormControlTextarea1">Motivo del ingreso:</label> --}}
                  {{-- <input class="form-control" id="exampleFormControlTextarea1" placeholder="Describe las reparaciones que se realizaran a la unidad" rows="3" name="description" oninput="this.className = ''" required minlength='10'> --}}
                  <label for="">Condiciones de salida:</label><br>
                  <label for="customRange1">Estetica</label>
                  <input type="range" class="custom-range" min="0" max="100" name="stetic_range" value='100' id="stetic_range" oninput="this.className = ''">
                  <small id="stetic">Nivel de estetica: 100%</small><br>
                  <label for="exampleFormControlTextarea1">Detalles sobre estetica:</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Observaciones sobre detalles/problemas esteticos en caso de existir" rows="2" name="description_stetic"></textarea>
                  <label for="exampleFormControlTextarea1">Detalles extras sobre funcionamiento:</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Observaciones sobre fallas existentes no atendidas en esta orden en caso de existir" rows="2" name="description_other"></textarea>
                  <label for="customRange1">Cantidad de combustible al momento del ingreso</label>
                  <input type="range" class="custom-range" min="1" max="120" name="petrol_range" value='1' id="petrol_range" oninput="this.className = ''">
                  <small id="petrol">Combustible: 1 cm</small><br>
                  {{-- <p><input type="text" class="form-control" placeholder="E-mail..." oninput="this.className = ''"></p> --}}
                </div>
                {{-- <p><input placeholder="Phone..." oninput="this.className = ''"></p> --}}
              </div>

              <div class="tab">
                <div class="form-group">
                  <label for="">Fecha salida:</label>
                  <p><input type="date" name="date_estimated" class="form-control" placeholder="" oninput="this.className = ''" value='{{\Carbon\Carbon::tomorrow()->format('Y-m-d')}}' min='{{\Carbon\Carbon::now()->format('Y-m-d')}}' max='{{\Carbon\Carbon::now()->addWeek()->format('Y-m-d')}}'></p>
                  <label for="exampleFormControlTextarea1">Comentarios:</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="" rows="2" name="comments"></textarea>
                </div>

                {{-- <p><input placeholder="mm" oninput="this.className = ''"></p> --}}
                {{-- <p><input placeholder="yyyy" oninput="this.className = ''"></p> --}}
              </div>

              <div class="tab">Verificar información:<br><br>
                <input type="hidden" name="date_start" value="{{\Carbon\Carbon::now()}}">
                <input type="hidden" name="id" value="{{$id}}">
                <p><b>Estetica de ingreso: </b>{{$solicitud_taller_trucks->porcentaje_estetica}}%  </p>
                <p id='p_stetic'><b>Estetica de salida: </b>  100%</p><br>
                <p><b>Combustible de entrada: </b> {{$solicitud_taller_trucks->combustible}} cm</p>
                <p id='p_petrol'><b>Combustible de salida: </b> 1 cm</p><br>
                <p id='p_fails'><b>Fallos no atendidos: </b> {{$solicitud_taller_trucks->descripcion_extra}}</p>
                {{-- <p><input placeholder="Username..." oninput="this.className = ''"></p> --}}
                {{-- <p><input placeholder="Password..." oninput="this.className = ''"></p> --}}
              </div>

              <div style="overflow:auto;">
                <div style="float:right;">
                  <button type="button" class="btn btn-dark" id="prevBtn" onclick="nextPrev(-1)">Anterior</button>
                  <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Siguiente</button>
                </div>
              </div>

              <!-- Circles which indicates the steps of the form: -->
              <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
                <span class="step"></span>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  
  $(document).ready(function() {
//     p_stetic
// p_petrol
// p_fails
    $('#stetic_range').change(function() {
      let stetic_range = $("#stetic_range").val();
      document.getElementById('stetic').innerHTML = 'Nivel de estetica: '+stetic_range+'%';
      document.getElementById('p_stetic').innerHTML = '<b>Estetica de salida: </b>'+stetic_range+'%';
    });
    $('#stetic_range').mousemove(function() {
      let stetic_range = $("#stetic_range").val();
      document.getElementById('stetic').innerHTML = 'Nivel de estetica: '+stetic_range+'%';
    });
    $('#petrol_range').change(function() {
      let petrol_range = $("#petrol_range").val();
      document.getElementById('petrol').innerHTML = 'Combustible: '+petrol_range+' cm';
      document.getElementById('p_petrol').innerHTML = '<b>Combustible de salida: </b> '+petrol_range+'%';
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

        fetch("{{route('search.trackto.vin')}}", {
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
