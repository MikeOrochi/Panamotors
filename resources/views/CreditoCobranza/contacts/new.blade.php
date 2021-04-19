

@extends('layouts.appAdmin')
@section('titulo', 'Agregar Cliente/ID')
@section('content')

  <script>
  $(document).ready(function(){
    //colonia_otra_div
      $("#colonia").change(function(){
          // let option_colony = document.getElementById('#colonia').value;
          var option_colony_select = document.getElementById("colonia");
          var option_colony = option_colony_select.options[option_colony_select.selectedIndex].value;
          if (option_colony=='no_ok') {
            $("#colonia_otra_div").fadeIn();
          }else {
            document.getElementById('colonia_otra').value='';
            $("#colonia_otra_div").fadeOut();
          }
          console.log(option_colony);
      });
  });
  </script>
  <script>
  function buscar_numero_celular() {
    var telefono_celular = $("#telefono_celular").val();
    if (telefono_celular == "") {
      $("#respuesta_numero_celular").html(' <i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>');
    }else{
      $.post("{{route('CreditoCobranza.contact.verifyMobilePhone')}}", {_token: "{{ csrf_token() }}",telefono_celular: telefono_celular}, function(respuesta) {
        $("#respuesta_numero_celular").html(respuesta);
        if(respuesta == ' <i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>'){
          $("#validar_formulario").attr("value","NO");
          $("#telefono_celular").val('');
        }else if (respuesta == ' <i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;"></i>'){
          $("#validar_formulario").attr("value","SI");
        }else if (respuesta == ''){
          $("#validar_formulario").attr("value","NO");
          $("#telefono_celular").val('');
        }
      });
    }
  };
  </script>
  <style>
  #preview {
    border:1px solid #ddd;
    padding:5px;
    border-radius:2px;
    background:#fff;
    max-width:200px;
  }
  #preview img {width:100%;display:block;}
  </style>
</head>
<body>
  <div class="loader-wrapper">
    <div class="loader-circle">
      <div class="loader-wave"></div>
    </div>
  </div>
  <div class="container-fluid">

    {{-- <div class="col-sm-9 col-xs-12 content pt-3 pl-0" style="width: 100%;"> --}}
    <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
      <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
      <span class="text-secondary"> Agregar Cliente/ID</span>
      <br>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <center><h1><i class="fas fa-user-plus"></i></h1><!--<h1>Agregar nuevo Cliente/ID</h1>--></center>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="sec-datos">
        </div>
      </div><br>
      <form id="contacto" name="contacto" method="post" action="{{route('CreditoCobranza.contact.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Nombre(s)</label>
                <input type="text" class="form-control"  id="nombre" name="nombre" required="" onKeyUp="mayus(this);">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Apellidos</label>
                <input type="text" class="form-control"  id="apellidos" name="apellidos" required="" onKeyUp="mayus(this);" disabled="">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Identificacion</label>
                <select name="sexo" id="sexo" class="form-control" disabled="">
                  <option value="" class="form-control">Selecciona una Opcion</option>
                  <option value="Hombre" class="form-control">Hombre</option>
                  <option value="Mujer" class="form-control">Mujer</option>
                  <option value="Empresa" class="form-control">Empresa</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Alias</label>
                <input type="text" class="form-control"  id="alias" name="alias" required="" onKeyUp="mayus(this);" disabled="">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>RFC</label>
                <input type="text" class="form-control"  id="rfc" name="rfc" disabled="">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Teléfono Celular</label> <label id="respuesta_numero_celular"></label>
                <input type="text" class="form-control" id="telefono_celular" name="telefono_celular" minlength="10" maxlength="10" required="" onKeyUp="buscar_numero_celular();numero(this);" disabled="">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Teléfono Fijo</label>
                <input type="text" class="form-control" id="telefono_fijo" name="telefono_fijo" minlength="10" maxlength="10" onKeyUp="numero(this);" disabled="">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>E-mail</label>
                <input type="e-mail" id="correo" name="correo" class="form-control" disabled="">
              </div>
            </div>
          </div>
        </div>
        <div id="imagen_identificacion" style="display: none;">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                  <div id="preview"></div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label>*INE/IFE</label>
                <input type="file" name="uploadedfile" id="uploadedfile" required="" class="form-control" disabled="" onchange="uploadedfilex()">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Asesor</label>
                <select name="asesor" id="asesor" class="form-control" required="" disabled="">
                  <option value="">Elige una opción…</option>
                  @foreach ($asesores as $asesor)
                    <option value="{{$asesor->idasesores}}">{{$asesor->nomeclatura}} {{$asesor->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Tipo de Cliente</label>
                <select name="tipo_cliente" id="tipo_cliente" class="form-control" required="" disabled="">
                  <option value="">Elige una opción…</option>
                  @foreach ($clientes_tipos as $cliente_tipo)
                    <option value="{{$cliente_tipo->idclientes_tipos}}">{{$cliente_tipo->nomeclatura}} {{$cliente_tipo->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Tipo de Crédito</label>
                <select name="credito" id="credito" class="form-control" required="" disabled="">
                  <option value="">Elige una opción…</option>
                  @foreach ($credito_tipos as $credito_tipo)
                    <option value="{{$credito_tipo->idcredito_tipos}}">{{$credito_tipo->nomeclatura}} {{$credito_tipo->nombre}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>*Línea de Crédito:</label>
                <input type="text" id="lim_credito" name="lim_credito" class="form-control" onKeyUp="numero(this);" readonly="" value="0">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                <label>*Código Postal</label>
                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" minlength="5" maxlength="5" onKeyUp="getZip(); numero(this);" onkeypress="" required="" disabled="">
              </div>
            </div>
          </div>
        </div>
        <div id="buscador_zip" style="display: none;">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>*Estado</label>
                  <input type="text" class="form-control" id="estado" name="estado" required="" readonly="">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>*Municipio</label>
                  <input type="text" class="form-control" id="municipio" name="municipio" required="" readonly="">
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-6">
                {{-- <div class="form-group" id='colonia_input'>
                <label>Colonia</label>
                <input type="text" class="form-control" id=""  disabled="">
              </div> --}}
              <div class="form-group" id='colonia_select'>
                <label>Colonia</label>
                <select name='colonia' class='form-control' id='colonia' name="colonia">
                  <option value=''>Elige una opción</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6" id='colonia_otra_div' style="display: none;">
              <div class="form-group">
                <label>Coloca el nombre de tu colonia en el campo de abajo</label>
                <input type="text" class="form-control" id="colonia_otra" name="colonia_otra">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label>Calle y Número</label>
                <input type="text" class="form-control" id="calle" name="calle">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="sec-datos"></div>
      </div><br>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <center><h1>Referencias</h1></center>
            <div class="form-group">
              <label>*1. Referencia nombre:</label>
              <input type="text" id="ref_nombre" name="ref_nombre" class="form-control" required="" onKeyUp="mayus(this);" disabled="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>*1. Referencia celular:</label>
              <input type="text" id="ref_celular" name="ref_celular" class="form-control" minlength="10" maxlength="10" onKeyUp="numero(this);" required="" disabled="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>*1. Referencia telefono fijo:</label>
              <input type="text" id="ref_fijo" name="ref_fijo" class="form-control" minlength="10" maxlength="10" onKeyUp="numero(this);" required="" disabled="">
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="sec-datos">
        </div>
      </div><br>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label>*2. Referencia Nombre: </label>
              <input type="text" id="ref_nombre2" name="ref_nombre2" class="form-control" onKeyUp="mayus(this);" disabled="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>*2. Referencia Celular: </label>
              <input type="text" id="ref_celular2" name="ref_celular2" class="form-control" minlength="10" maxlength="10" onKeyUp="numero(this);" disabled="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>*2. Referencia Fijo: </label>
              <input type="text" id="ref_fijo2" name="ref_fijo2" class="form-control" minlength="10" maxlength="10" onKeyUp="numero(this);" disabled="">
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="sec-datos"></div>
      </div><br>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label>3. Referencia Nombre: </label>
              <input type="text" id="ref_nombre3" name="ref_nombre3" class="form-control" onKeyUp="mayus(this);" disabled="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>3. Referencia Celular: </label>
              <input type="text" id="ref_celular3" name="ref_celular3" class="form-control" minlength="10" maxlength="10" onKeyUp="numero(this);" disabled="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label>3. Referencia Fijo: </label>
              <input type="text" id="ref_fijo3" name="ref_fijo3" class="form-control" minlength="10" maxlength="10" onKeyUp="numero(this);" disabled="">
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <center>
                <button class="btn btn-lg btn-primary" type="submit" id="guardar_info" style="display: none;">Guardar</button>
              </center>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <?php
  //include_once '../footer.php';
  ?>
  {{-- </div>
</div>
</div> --}}
<script type="text/javascript">
document.getElementById("uploadedfile").onchange = function(e) {
  var evidencia = $("#uploadedfile").val();
  if (evidencia.length === 0) {
    $("#asesor").attr('disabled', 'disabled');
    $('#preview').html('<i class="fas fa-exclamation-triangle fa-6x"></i>');
  } else {
    $("#asesor").removeAttr('disabled', 'disabled');
    document.getElementById('imagen_identificacion').style.display = 'block';
    let reader = new FileReader();
    $('#preview').html('<i class="fas fa-hourglass-half fa-6x"></i>');
    reader.onload = function(){
      let preview = document.getElementById('preview'),
      image = document.createElement('img');
      image.src = reader.result;
      preview.innerHTML = '';
      preview.append(image);
    };
    reader.readAsDataURL(e.target.files[0]);
  }
}
function mayus(letra){
  jQuery(letra).keyup(function () {
    this.value = this.value.toLowerCase();
    this.value = this.value.replace(/\b[a-z]/g,c=>c.toUpperCase());
  });
}
function numero(numero){
  jQuery(numero).keyup(function () {
    this.value = this.value.replace(/[^0-9]/g,'');
  });
}
$("#nombre").keyup(function(){
  if ($("#nombre").val().length === 0) {
    $("#apellidos").attr('disabled', 'disabled');
  } else {
    $("#apellidos").removeAttr('disabled', 'disabled');
  }
});
$("#apellidos").keyup(function(){
  if ($("#apellidos").val().length === 0) {
    $("#sexo").attr('disabled', 'disabled');
  } else {
    $("#sexo").removeAttr('disabled', 'disabled');
  }
});
$("#sexo").change(function(){
  var sexo_identificacion = document.getElementById("sexo").value;
  if (sexo_identificacion.length === 0) {
    $("#alias").attr('disabled', 'disabled');
    $("#rfc").attr('disabled', 'disabled');
  } else {
    $("#alias").removeAttr('disabled', 'disabled');
    $("#rfc").removeAttr('disabled', 'disabled');
  }
});
$("#alias").keyup(function(){
  if ($("#alias").val().length === 0) {
    $("#telefono_celular").attr('disabled', 'disabled');
  } else {
    $("#telefono_celular").removeAttr('disabled', 'disabled');
  }
});
$("#telefono_celular").keyup(function(){
  if ($("#telefono_celular").val().length === 0) {
    $("#telefono_fijo").attr('disabled', 'disabled');
  } else {
    $("#telefono_fijo").removeAttr('disabled', 'disabled');
  }
});
$("#telefono_fijo").keyup(function(){
  if ($("#telefono_fijo").val().length === 0) {
    $("#correo").attr('disabled', 'disabled');
    $("#uploadedfile").attr('disabled', 'disabled');
  } else {
    $("#correo").removeAttr('disabled', 'disabled');
    $("#uploadedfile").removeAttr('disabled', 'disabled');
  }

  if ($("#telefono_fijo").val() === $("#telefono_celular").val()) {
    alert('No puedes asignar el mismo numero en ambos campos');
    $("#telefono_fijo").val('');
    $("#telefono_fijo").focus();
  }

});
$("#uploadedfile").keyup(function(){
  if ($("#uploadedfile").val().length === 0) {
    $("#asesor").attr('disabled', 'disabled');
  } else {
    $("#asesor").removeAttr('disabled', 'disabled');
  }
});
function uploadedfilex() {
  var evidencia = $("#uploadedfile").val();
  console.log(evidencia);
  if (evidencia.length === 0) {
    $("#asesor").attr('disabled', 'disabled');
  }else{
    $("#asesor").removeAttr('disabled', 'disabled');
  }
}
$("#asesor").change(function(){
  var asesorx = document.getElementById("asesor").value;
  if (asesorx.length === 0) {
    $("#tipo_cliente").attr('disabled', 'disabled');
  } else {
    $("#tipo_cliente").removeAttr('disabled', 'disabled');
  }
});
$("#tipo_cliente").change(function(){
  var asesorx = document.getElementById("tipo_cliente").value;
  if (asesorx.length === 0) {
    $("#credito").attr('disabled', 'disabled');
  } else {
    $("#credito").removeAttr('disabled', 'disabled');
  }
});
$("#credito").change(function(){
  var creditox = document.getElementById("credito").value;
  if (creditox.length === 0) {
    $("#codigo_postal").attr('disabled', 'disabled');
  } else {
    $("#codigo_postal").removeAttr('disabled', 'disabled');
  }
});
$("#codigo_postal").keyup(function(){
  if ($("#codigo_postal").val().length === 0) {
    $("#ref_nombre").attr('disabled', 'disabled');
  } else {
    $("#ref_nombre").removeAttr('disabled', 'disabled');
  }
});
$("#ref_nombre").keyup(function(){
  if ($("#ref_nombre").val().length === 0) {
    $("#ref_celular").attr('disabled', 'disabled');
  } else {
    $("#ref_celular").removeAttr('disabled', 'disabled');
  }
});
$("#ref_celular").keyup(function(){
  if ($("#ref_celular").val().length === 0) {
    $("#ref_fijo").attr('disabled', 'disabled');
  } else {
    $("#ref_fijo").removeAttr('disabled', 'disabled');
  }
});
$("#ref_fijo").keyup(function(){
  if ($("#ref_fijo").val().length === 0) {
    $("#ref_nombre2").attr('disabled', 'disabled');
  } else {
    $("#ref_nombre2").removeAttr('disabled', 'disabled');
  }
});
$("#ref_nombre2").keyup(function(){
  if ($("#ref_nombre2").val().length === 0) {
    $("#ref_celular2").attr('disabled', 'disabled');
  } else {
    $("#ref_celular2").removeAttr('disabled', 'disabled');
  }
});
$("#ref_celular2").keyup(function(){
  if ($("#ref_celular2").val().length === 0) {
    $("#ref_fijo2").attr('disabled', 'disabled');
  } else {
    $("#ref_fijo2").removeAttr('disabled', 'disabled');
  }
});
$("#ref_fijo2").keyup(function(){
  if ($("#ref_fijo2").val().length === 0) {
    $("#ref_nombre3").attr('disabled', 'disabled');
    $("#ref_celular3").attr('disabled', 'disabled');
    $("#ref_fijo3").attr('disabled', 'disabled');
    $("#guardar_info").hide();
  } else {
    $("#ref_nombre3").removeAttr('disabled', 'disabled');
    $("#ref_celular3").removeAttr('disabled', 'disabled');
    $("#ref_fijo3").removeAttr('disabled', 'disabled');
    $("#guardar_info").show();
  }
});
function getZip(){
  zip_code = document.getElementsByName("codigo_postal")[0].value;
  console.log(zip_code.length);
  var valoresAceptados = /^[0-9]+$/;
  if (zip_code.match(valoresAceptados)){
    if (zip_code.length != 5) {
      $('#buscador_zip').fadeOut();
    }else {
      console.log(zip_code);
      fetch('{{route('zip.show','')}}/'+zip_code)
      .then(response => response.json())
      .catch(function(error){
        $('#buscador_zip').fadeOut();
        console.log(error);
      })
      .then(function(data){
        if (data) {
          // $("#buscador_cp").fadeIn();
          $('#buscador_zip').fadeIn();

          console.log(data);
          colonies = data.colony;
          console.log(colonies);
          document.getElementById("estado").value = data.state;
          // document.getElementById("state_hid").value = data.state;
          document.getElementById("municipio").value = data.township;
          // document.getElementById("township_hid").value = data.township;
          $('#colonia').empty();
          for(var i in colonies){
            document.getElementById("colonia").innerHTML += "<option value='"+colonies[i]+"'>"+colonies[i]+"</option>";
          }
          document.getElementById("colonia").innerHTML += "<option value='"+'no_ok'+"'>"+'No aparece mi colonia'+"</option>";
          // var state_hid = document.getElementById("state_hid");
          // var township_hid = document.getElementById("township_hid");
          document.getElementById('colonia_otra').value='';
          $("#colonia_otra_div").fadeOut();
        }else {
          document.getElementById('colonia_otra').value='';
          $("#colonia_otra_div").fadeOut();
        }
      });
    }
  } else {
    $('#buscador_zip').fadeOut();
  }

}
</script>

@endsection
