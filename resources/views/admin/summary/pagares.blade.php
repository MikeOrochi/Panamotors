@extends('layouts.appAdmin')
@section('titulo', 'CCP | Resumen pagos unidad')
@section('content')


  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
      <center>
        <h2>{{$nombre_completo}}<br>{{$folio.' '.$folio_anterior}}</h2>
        <i class="fa fa-car fa-3x" aria-hidden="true"></i>
        <h5>{{$nombre_unidad}}<br>${{$precio_general}}</h5>
        <h4>{{$vin_unidad}}</h4>
      </center>
    </div>
  </div>

  <div class="wrapper wrapper-content">
    <div class="row animated fadeInRight">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Nuevo documento por pagar</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>

          <div class="ibox-content">
            <div class="row">
              <div id="nuevo_pagare" style="width: 100%;padding: 20px">
                <form id="cobranza" name="cobranza" enctype="multipart/form-data" method="post" action="{{route('account.pagare.save')}}" class="needs-validation confirmation">
                  @csrf
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Serie</label>
                        <input class="form-control" type="text" id="n_serie" name="n_serie" onkeypress="return SoloNumeros(event);" required="" />
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Monto</label>
                        <input class="form-control" type="text" id="monto_pagare" name="monto_pagare" onkeypress="return SoloNumeros(event);" required="" onKeyUp="buscar_letras('monto_pagare','letra');"/>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Tipo</label>
                        <select name="tipo" id="tipo" class="form-control" onChange="ocultar_referencia(this.value);" required>
                          <option value="">Elige una opción…</option>
                          <option value="Físico">Físico</option>
                          <option value="Virtual">Virtual</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Precio letra</label>
                        <input type="text" class="form-control" id="letra" name="letra" id="letras" required readonly>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Fecha de vencimiento <i id="clean1" class="fa fa-trash-o fa-1x" aria-hidden="true"></i></label>
                        <input class="form-control" type="date" id="fechapago1" name="fechapago1" required="" />
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Evidencia:</label>
                        <input type="file" placeholder="Evidencia de Comprobante" name="uploadedfile" id="comprobante_archivo" class="form-control" required="">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label>Comentarios:</label>
                        <textarea class="form-control" rows="3" id="descripcion" name="descripcion" maxlength="8950" required=""></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="hr-line-dashed"></div>

                  <input type="hidden" name="contacto_original" value='{{$idconta}}'>
                  <input type="hidden" name="movimiento_general" value='{{$id_movimiento}}'>
                  <input type="hidden" name="nombre_com" value='{{$nombre_completo}}'>
                  <input type="hidden" name="idcontacto" value='{{$idconta}}'>

                  <div class="form-group">
                    <div class="col-lg-12">
                      <br>
                      <center>
                        <button class="btn btn-lg btn-primary" type="submit">Guardar</button>
                      </center>
                    </div>
                  </div>

                </form>
              </div>
            </div>
          </div>



        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  //<!-----Se utiliza para que el campo de texto solo acepte numeros----->
  function SoloNumeros(evt){
    if(window.event){ //asignamos el valor de la tecla a keynum
      keynum = evt.keyCode; //IE
    }
    else{
      keynum = evt.which; //FF
    }
    //comprobamos si se encuentra en el rango numérico
    if((keynum > 47 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 47 || keynum == 46 ){
      return true;
    }
    else{
      return false;
    }
  }

  //<!------Se utiliza para que el campo de texto solo acepte letras------>
  function SoloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toString();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    especiales = [8, 37, 39, 46, 6];

    tecla_especial = false
    for(var i in especiales) {
      if(key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial){
      //alert('Tecla no aceptada');
      return false;
    }
  }

  function ocultar_referencia(id) {

      if (id == "Virtual") {
          $("#comprobante_archivo").prop('disabled', true);
      }else{
          $("#comprobante_archivo").prop('disabled', false);
      }
  }


  function buscar_letras(inputNum, Destino) {

    var numero = $("#" + inputNum).val();
    var tipo_cambio = 'MXN';
    var InputDestino = $('#' + Destino);

    console.log(numero,tipo_cambio);

    if (numero == "") {
      InputDestino.val('');
    } else {

      var label = InputDestino.parent().find('label');
      label.html('Precio Letra <i class="fas fa-spinner fa-spin" style="position: initial;"></i>');

      fetch(" {{route('number.letters.convert',['',''])}}/" + numero + "/" + tipo_cambio, {
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-Token": '{{csrf_token()}}',
        },
        method: "get",
        credentials: "same-origin",
      }).then(res => res.json())
      .catch(function(error) {
        console.error('Error:', error);
        label.html('Precio Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
      })
      .then(function(response) {

        if (response.info == null) {
          iziToast.error({
            title: 'Error',
            message: 'Error al obtener la cantidad en letras',
          });
          label.html('Precio Letra <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red;"></i>');
          InputDestino.val('');
        } else {
          InputDestino.val(response.info);
          label.html('Precio Letra');
        }

      });
    }
  }
  </script>

@endsection
