@extends('layouts.appAdmin')
@section('titulo', 'Abono - Pagares de Proveedores')



@section('head')
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
    $.datepicker.regional['es'] = {
      closeText: 'Cerrar',
      prevText: '< Ant',
      nextText: 'Sig >',
      currentText: 'Hoy',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
      dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
      weekHeader: 'Sm',
      dateFormat: 'yy-mm-dd',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
  </script>
  <script>
    $(function() {
      $.datepicker.setDefaults($.datepicker.regional["es"]);
      $("#fechapago1").datepicker({
        gotoCurrent: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "1990:2100"
      });
      $("#fechapago_venta1").datepicker({
        gotoCurrent: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "1990:2100"
      });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#clean1").click(function () {
        $("#fechapago1").val("");
      });
      $("#clean_venta1").click(function () {
        $("#fechapago_venta1").val("");
      });
      $('select#tipo_moneda1').on('change',function(){
        var cambio1 = "19.50";
        var cambio2 = "15.20";
        var cambio3 = "1";
        var nada = "0";
        var valor = $(this).val();
        if(valor == 'USD'){
          $('#tipo_cambio2').removeAttr('readonly', 'readonly');
          $("#tipo_cambio2").val("");
          $("#monto_abono_pagare").attr("readonly", "readonly");
          $("#tipo_cambio2").attr("placeholder", "Ejemplo: 19.5");
          $("#tipo_cambio2").focus();
          $("#monto_abono_pagare").val("");
          $("#monto_abono").val("");
          $("#saldo_nuevo_pagare").val("");
          $("#monto_abono_pagare").val("");
          $("#monto_abono_unidad").val("");
          $("#saldo_nuevo_unidad").val("");
          $("#monto_abono_general").val("");
          $("#saldo_nuevo").val("");
          $("#monto_general").val("");
          $("#serie_general").val("");
          $("#check1").html("");
        }else if (valor == 'CAD'){
          $('#tipo_cambio2').removeAttr('readonly', 'readonly');
          $("#tipo_cambio2").val("");
          $("#tipo_cambio2").attr("placeholder", "Ejemplo: 14.5");
          $("#monto_abono_pagare").attr("readonly", "readonly");
          $("#monto_abono_pagare").val("");
          $("#monto_abono").val("");
          $("#saldo_nuevo_pagare").val("");
          $("#monto_abono_pagare").val("");
          $("#monto_abono_unidad").val("");
          $("#saldo_nuevo_unidad").val("");
          $("#monto_abono_general").val("");
          $("#saldo_nuevo").val("");
          $("#monto_general").val("");
          $("#serie_general").val("");
          $("#check1").html("");

        }else if(valor == 'MXN'){
          $("#tipo_cambio2").val(parseFloat(cambio3));
          $('#tipo_cambio2').prop('readonly', true);
          $('#monto_abono_pagare').removeAttr('readonly', 'readonly');
          $("#monto_abono_pagare").val("");
          $("#monto_abono").val("");
          $("#saldo_nuevo_pagare").val("");
          $("#monto_abono_pagare").val("");
          $("#monto_abono_unidad").val("");
          $("#saldo_nuevo_unidad").val("");
          $("#monto_abono_general").val("");
          $("#saldo_nuevo").val("");
          $("#monto_general").val("");
          $("#serie_general").val("");
          $("#check1").html("");

        }else if(valor == ''){
          $("#tipo_cambio2").val(parseFloat(nada));
        }
      });

      $("#tipo_cambio2").keyup(function(){
        if ($('#tipo_cambio2').val()==="") {
          $('#monto_abono_pagare').attr("readonly");
        }else{
          $('#monto_abono_pagare').removeAttr('readonly', 'readonly');
          $("#monto_abono_pagare").val("");
          $("#monto_abono").val("");
          $("#saldo_nuevo_pagare").val("");
          $("#monto_abono_pagare").val("");
          $("#monto_abono_unidad").val("");
          $("#saldo_nuevo_unidad").val("");
          $("#monto_abono_general").val("");
          $("#check1").html("");
        }
      });



      //-----------------Calculo por monto

      $("#monto_abono_pagare").keyup(function(){
        result_mul = 0;
        var tipo_cambio2 = parseFloat($("#tipo_cambio2").val());
        var monto_abono_pagare = parseFloat($("#monto_abono_pagare").val());
        result_mul = tipo_cambio2*monto_abono_pagare;
        $("#monto_abono").val(result_mul.toFixed(2));
        $("#monto_abono_unidad").val(result_mul.toFixed(2));
        $("#monto_abono_general").val(result_mul.toFixed(2));
        $("#monto_general").val(result_mul.toFixed(2));
        $("#serie_general").val("1/1");
        var saldo_pagare = $("#saldo_pagare").val();
        var monto_abono_1 = $("#monto_abono").val();
        res_nuevo_saldo = saldo_pagare-monto_abono_1;
        $("#saldo_nuevo_pagare").val(res_nuevo_saldo);
        //-----------disminuir saldo unidad
        var saldo_unidad = $("#saldo_unidad").val();
        var monto_abono_unidad_x = $("#monto_abono_unidad").val();
        res_unidad = saldo_unidad-monto_abono_unidad_x;
        $("#saldo_nuevo_unidad").val(res_unidad);
        //-----------disminuir saldo general
        var saldo = $("#saldo").val();
        var monto_abono = $("#monto_abono").val();
        res_saldo_general = saldo-monto_abono;
        $("#saldo_nuevo").val(res_saldo_general);

        if ($("#monto_abono_pagare").val().length===0) {
          $('#validamonto').html('<strong class="text-danger">El campo no debe estar vacio</strong>');
          var v = '&nbsp;&nbsp;<i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>';
          $('#check1').html(v);
          $("#monto_abono").val("");
          $("#saldo_nuevo_pagare").val("");
          $("#monto_abono_unidad").val("");
          $("#saldo_nuevo_unidad").val("");
          $("#monto_abono_general").val("");
          $("#saldo_nuevo").val("");
          $("#monto_general").val("");
          $("#serie_general").val("");
        }
        if ($("#monto_abono_pagare").val().length>=1) {
          var v = '&nbsp;&nbsp;<i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;"></i>';
          $('#check1').html(v);
          $('#validamonto').html('');
        }
      });



    });
  </script>
  <script>
    function buscar_letras1() {
      var textoletras = $("#monto_abono_pagare").val();
      var tipo = $("#tipo_moneda1").val();
      if (textoletras != "") {
        $.post("buscar_letras1.php", {valorBusqueda: textoletras, valortipo: tipo}, function(mensaje_letras) {
          $("#letra1").val(mensaje_letras);
        });
      } else {
        $("#letra1").val('');
      };
    };
  </script>
  <script>
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
        return false;
      }
    }
    //<!-----Se utiliza para que el campo de texto solo acepte numeros----->
    function SoloNumeros(evt){
      if(window.event){ //asignamos el valor de la tecla a keynum
        keynum = evt.keyCode; //IE
      }
      else{
        keynum = evt.which; //FF
      }

      //comprobamos si se encuentra en el rango numérico
      if((keynum >= 48 && keynum < 58) || keynum == 8 || keynum == 13 || keynum == 6 || keynum == 46 ){
        return true;
      }
      else{
        return false;
      }

    }
    function mostrar(id) {
      if (id == "") {
        $("#principal").hide();
        $("#secundario").hide();
        $("#concepto_general").val(id);
        $("#concepto_general_venta").val(id);
      }else if (id=="Venta Directa" || id=="Compra Directa" || id=="Venta Permuta" || id=="Compra Permuta") {
        $("#principal").show();
        $("#secundario").hide();
        $("#concepto_general").val(id);
        $("#concepto_general_venta").val(id);
      }else{
        $("#principal").hide();
        $("#secundario").show();
        $("#concepto_general").val(id);
        $("#concepto_general_venta").val(id);
      }
    }

    function ocultar_referencia(id) {
      if (id == "Notificacion") {
        $("#n_referencia").attr("placeholder", "No Aplica");
        $("#n_referencia").prop('disabled', true);
      } else if (id == "Recibo Automático") {
        $("#comprobante_archivo").prop('disabled', true);
      } else {
        $("#n_referencia").prop('disabled', false);
      }
    }

    function ocultar_referencia_venta(id) {
      if (id == "Notificacion") {
        $("#n_referencia_venta").attr("placeholder", "No Aplica");
        $("#n_referencia_venta").prop('disabled', true);
      } else {
        $("#n_referencia_venta").prop('disabled', false);
      }
    }
  </script>
  <script>
    var errores = 0;
    function validateForm() {

      errores++;

      if (errores === 3) {
        alert("Tercera vez que ingresas datos erroneos");
        window.location.reload(history.back());
        return false;
      }else{
        if ($("#fechapago1").val().length===0) {
         $("#fechapago1").focus();
         alert("Ingresa Fecha de Movimiento");
         return false;
       } else if ($("#m_pago").val().length===0) {
         $("#m_pago").focus();
         alert("Ingresa Método de Pago");
         return false;
       } else if ($("#monto_abono").val().length===0) {
         $("#monto_abono").focus();
         alert("Error en el calculo de Cantidad");
         return false;
       } else if ($("#saldo_nuevo_pagare").val().length===0) {
         $("#saldo_nuevo_pagare").focus();
         alert("Error en el Calculo de Nuevo Saldo");
         return false;
       } else if ($("#tipo_moneda1").val().length===0) {
         $("#tipo_moneda1").focus();
         alert("Selecciona un Tipo de Moneda");
         return false;
       } else if ($("#tipo_cambio2").val().length===0) {
         $("#tipo_cambio2").focus();
         alert("Ingresa un Tipo de Cambio");
         return false;
       } else if ($("#monto_abono_pagare").val().length===0) {
         $("#monto_abono_pagare").focus();
         alert("Ingresa las Divisas");
         return false;
       } else if ($("#saldo_unidad").val().length===0) {
         $("#saldo_unidad").focus();
         alert("Error de Saldo de Unidad");
         return false;
       } else if ($("#monto_abono_unidad").val().length===0) {
         $("#monto_abono_unidad").focus();
         alert("Error de Abono a la Unidad");
         return false;
       } else if ($("#saldo_nuevo_unidad").val().length===0) {
         $("#saldo_nuevo_unidad").focus();
         alert("Error de Abono en el Nuevo Saldo a la Unidad");
         return false;
       } else if ($("#saldo").val().length===0) {
         $("#saldo").focus();
         alert("Error en el Saldo General");
         return false;
       } else if ($("#monto_abono_general").val().length===0) {
         $("#monto_abono_general").focus();
         alert("Error en el Abono General");
         return false;
       } else if ($("#saldo_nuevo").val().length===0) {
         $("#saldo_nuevo").focus();
         alert("Error en el Nuevo Saldo General");
         return false;
       } else if ($("#serie_general").val().length===0) {
         $("#serie_general").focus();
         alert("Ingresa una Serie del Abono");
         return false;
       } else if ($("#monto_general").val().length===0) {
         $("#monto_general").focus();
         alert("Ingresa un Monto General");
         return false;
       } else if ($("#emisor").val().length===0) {
         $("#emisor").focus();
         alert("Ingresa Institución Emisora");
         return false;
       } else if ($("#agente_emisor").val().length===0) {
         $("#agente_emisor").focus();
         alert("Ingresa Agente Emisor");
         return false;
       } else if ($("#receptor").val().length===0) {
         $("#receptor").focus();
         alert("Ingresa Institución Receptora");
         return false;
       } else if ($("#agente_receptor").val().length===0) {
         $("#agente_receptor").focus();
         alert("Ingresa Agente Receptor");
         return false;
       } else if ($("#comprobante").val().length===0) {
         $("#comprobante").focus();
         alert("Ingresa Comprobante");
         return false;
       } else if ($("#n_referencia").val().length===0) {
         $("#n_referencia").focus();
         alert("Ingresa Referencia");
         return false;
       } else { return true; }
     }



   }
   </script>
   <script>
         //---------------------------------------------------------------------------------------------------------------------------------------------
         function buscar_referencia() {
          var institucion_receptora = $("#receptor").val();
          var agente_receptor = $("#agente_receptor").val();
          var institucion_emisor = $("#emisor").val();
          var monto_general1 = $("#monto_general").val();
          var n_referencia = $("#n_referencia").val();
          var idco = $("#co").val();

          var monto_cantidad = $("#monto_abono").val();

          if (institucion_emisor === "") {
            alert("Llena el campo indicado");
            $("#emisor").focus();
            $("#emisor").css("border-color","red");
            $("#agente_receptor").css("border-color","#E7E3E2");
            $("#receptor").css("border-color","#E7E3E2");
          }else if (institucion_receptora === "") {
            alert("Llena el campo indicado");
            $("#receptor").focus();
            $("#receptor").css("border-color","red");
            $("#agente_receptor").css("border-color","#E7E3E2");
            $("#emisor").css("border-color","#E7E3E2");

          }
          else if (agente_receptor === "") {
            alert("Llena el campo indicado");
            $("#agente_receptor").focus();
            $("#agente_receptor").css("border-color","red");
            $("#receptor").css("border-color","#E7E3E2");
            $("#emisor").css("border-color","#E7E3E2");
          }
          else if (agente_receptor != "" && institucion_receptora != ""){
            $("#agente_receptor").css("border-color","#E7E3E2");
            $("#receptor").css("border-color","#E7E3E2");
            $("#emisor").css("border-color","#E7E3E2");


            var institucion_emisorx = institucion_emisor.split(".");
            console.log(institucion_emisorx[0]);
            var num1 = institucion_emisorx[0];
            if(isNaN(num1)==true){
            //--------------------------No entraria porque seria una referencia de la empresa

            if (n_referencia == "") {$("#respuesta_referecia").html('<i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>');}else{
              /* $("#respuesta_referecia").html(' <i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;"></i>');*/
              $.post("buscar_referencia.php", {ins_receptora: institucion_receptora, ag_receptor: agente_receptor, ref: n_referencia, ins_e: institucion_emisor, m_g: monto_general1,ic:idco,cantidad: monto_cantidad }, function(respuesta) {


                $("#respuesta_referecia").html(respuesta);

                if(respuesta == ' <i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>'){
                  console.log("hola2 "+respuesta);
                  $("#refe_val").attr("value","NO");


                }else if (respuesta == ' <i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;"></i>'){
                  console.log("hola1 "+respuesta);
                  /*$("#refe_val"). removeAttr("value");*/
                  /*setTimeout('borra_referencia_error()',1000);  */
                  $("#refe_val").attr("value","SI");

                }else if (respuesta == ''){
                  console.log("hola1 "+respuesta);
                  /*$("#refe_val"). removeAttr("value");*/
                  /*setTimeout('borra_referencia_error()',1000);  */
                  $("#refe_val").attr("value","NO");

                }
              });
            }

          }else{
            var n_referencia = $("#n_referencia").val();
            if (n_referencia == "") {
              /* $("#respuesta_referecia").html(' <i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>');*/
            }else{
              $.post("buscar_referencia.php", {ins_receptora: institucion_receptora, ag_receptor: agente_receptor, ref: n_referencia, ins_e: institucion_emisor, m_g: monto_general1,ic:idco,cantidad: monto_cantidad}, function(respuesta) {


                $("#respuesta_referecia").html(respuesta);
                if(respuesta == ' <i class="fa fa-times-circle-o" aria-hidden="true" style="color: red;"></i>'){
                  console.log("hola2 "+respuesta);
                  $("#refe_val").attr("value","NO");


                }else if (respuesta == ' <i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;"></i>'){
                  console.log("hola1 "+respuesta);
                  /*$("#refe_val"). removeAttr("value");*/
                  /*setTimeout('borra_referencia_error()',1000);  */
                  $("#refe_val").attr("value","SI");

                }else if (respuesta == ''){
                  console.log("hola1 "+respuesta);
                  /*$("#refe_val"). removeAttr("value");*/
                  /*setTimeout('borra_referencia_error()',1000);  */
                  $("#refe_val").attr("value","NO");

                }
              });
            }
          }




        }
      };

    /*  function borra_referencia_error() {
        $("#n_referencia").val("");
      }*/
    //---------------------------------------------------------------------------------------------------------------------------------------------
  </script>
@endsection

@section('content')

<div class="row mt-3">
  <div class="col-sm-12">
    <div class="shadow panel-head-primary">
         <center>
            <h5 class="text-center mt-3 mb-3"><?php echo $nombre." ".$apellidos;?></h5><i class="fa fa-car fa-3x" aria-hidden="true"></i><h5 class="text-center mt-3 mb-3"><?php echo $nombre_unidad;?></h5><h4><?php echo $vin_unidad;?></h5>
         </center>
         <!-- <ol class="breadcrumb">
            <li>
               <a href="index.php">Inicio</a>
            </li>
            <li>
               <a href="estado_cuenta.php?idc=<?php //echo $recibido;?>">Estado de Cuenta</a>
            </li>
            <li>Documentos por Cobrar</li>
            <li  class="active">
               <strong>Abono a Documento por Pagar</strong>
            </li>
         </ol> -->
      </div>
   </div>


   <div class="col-lg-12">
      <div class="ibox float-e-margins">
         <div class="ibox-title">
            <h5>Nuevo movimiento</h5>
            <!-- <div class="ibox-tools">
            <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
         </a>
      </div> -->
   </div>
   <div class="ibox-content">
      <div class="row">
         <div class="col-sm-12">
            <div class="form-group">
               <label><strong>Tipo de movimiento</strong></label>
               <select class="form-control" id="muestra" name="muestra" onChange="mostrar(this.value);" required>
                  <option value="">Elige una opción…</option>
                  <?php
                  // $consulta2=mysql_query("SELECT nomeclatura, nombre FROM catalogo_cobranza WHERE idcatalogo_cobranza='3' || idcatalogo_cobranza='24'");
                  foreach($catalogo_cobranza as $registro2){
                     echo "<option value='".$registro2->nombre."'>".$registro2->nomeclatura." ".$registro2->nombre."</option>";
                  }
                  ?>
               </select>
            </div>
         </div>
         <div class="col-sm-12" id="secundario" style="display: none;">
            <form class="row" id="cobranza" name="cobranza" enctype="multipart/form-data" method="post" action="{{route('account_status.savePaymentsPromisoryNotesProviders')}}" onsubmit="return validateForm()">
               @csrf
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Tipo</label>
                     <select class="form-control" id="tipo_general" name="tipo_general" required>
                        <option value="abono">Abono</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Efecto</label>
                     <select class="form-control" id="efecto" name="efecto" required>
                        <option value="resta">Negativo</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Fecha de pago <i id="clean1" class="fa fa-trash-o fa-1x" aria-hidden="true"></i></label>
                     <input class="form-control" type="text" id="fechapago1" name="fechapago1" required="" readonly />
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Método de pago</label>
                     <select class="form-control" id="m_pago" name="m_pago" required>
                        <option value="">Elige una opción…</option>
                        <?php //$consulta2=mysql_query("SELECT nomeclatura, nombre FROM catalogo_metodos_pago");
                        foreach($catalogo_metodos_pago as $registro2) {
                           echo "<option value='".$registro2->nomeclatura."'>".$registro2->nomeclatura." ".$registro2->nombre."</option>";
                        } ?>
                     </select>
                  </div>
               </div>
               <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Saldo</label>
                     <input class="form-control" type="text" id="saldo_pagare" name="saldo_pagare" value="<?php echo $saldo_anterior_pagare;?>" readonly required="" />
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Cantidad</label>
                     <input class="form-control" type="text" id="monto_abono" name="monto_abono" onkeypress="return SoloNumeros(event);" required="" readonly="" />
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Nuevo saldo</label>
                     <input class="form-control" type="text" id="saldo_nuevo_pagare" name="saldo_nuevo_pagare" readonly required="" />
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="form-group">
                     <label>Tipo de moneda</label>
                     <select class="form-control" id="tipo_moneda1" name="tipo_moneda1" onchange="buscar_letras1();" required>
                        <option value="">Elige una opción…</option>
                        <option value="USD">USD</option>
                        <option value="CAD">CAD</option>
                        <option value="MXN">MXN</option>
                     </select>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="form-group">
                     <label>Tipo de cambio</label>
                     <input class="form-control" type="text" id="tipo_cambio2" name="tipo_cambio2" required="" onkeypress="return SoloNumeros(event);" readonly="" />
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="form-group">
                     <label>Monto</label><label id="check1"></label>
                     <input class="form-control" type="text" id="monto_abono_pagare" name="monto_abono_pagare"  required="" onkeypress="return SoloNumeros(event);" onKeyUp="buscar_letras1();" readonly="" />
                     <div id="validamonto"></div>
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label>Monto letra</label>
                     <input type="text" class="form-control" id="letra1" name="letra" required readonly>
                  </div>
               </div>
               <!-- ----------------------------------------------------------------------------------------------------------------------------------------------------------------- -->



               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Saldo unidad</label>
                     <input class="form-control" type="text" id="saldo_unidad" name="saldo_unidad" value="<?php echo $saldo_anterior_unidad;?>" readonly required="" />
                  </div>
               </div>

               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Abono unidad</label>
                     <input class="form-control" type="text" id="monto_abono_unidad" name="monto_abono_unidad" readonly onkeypress="return SoloNumeros(event);" required="" />
                  </div>
               </div>

               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Nuevo saldo unidad</label>
                     <input class="form-control" type="text" id="saldo_nuevo_unidad" name="saldo_nuevo_unidad" readonly required="" />
                  </div>
               </div>

               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Saldo general</label>
                     <input class="form-control" type="text" id="saldo" name="saldo" value="<?php echo $saldo_anterior;?>" readonly required="" />
                  </div>
               </div>

               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Monto general</label>
                     <input class="form-control" type="text" id="monto_abono_general" name="monto_abono" onkeypress="return SoloNumeros(event);" readonly required="" />
                  </div>
               </div>

               <div class="col-sm-4">
                  <div class="form-group">
                     <label>Nuevo saldo general</label>
                     <input class="form-control" type="text" id="saldo_nuevo" name="saldo_nuevo" readonly required="" />
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Serie</label>
                     <input class="form-control" type="text" id="serie_general" name="serie_general" onkeypress="return SoloNumeros(event);" required="" />
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Monto abono general</label>
                     <input class="form-control" type="text" id="monto_general" name="monto_general" onkeypress="return SoloNumeros(event);" required="" />
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Institución emisora</label>
                     <select class="form-control" id="emisor" name="emisor" required>
                        <option value="">Elige una opción…</option>
                        <option value="<?php echo $idconta.".".$iniciales_cliente;?>"><?php echo $idconta.".".$iniciales_cliente;?></option>
                        <?php

                        // $consulta2=mysql_query("SELECT nombre FROM bancos_emisores");
                        foreach($bancos_emisores as $registro2)
                        {
                           echo "<option value='".$registro2->nombre."'>".$registro2->nombre."</option>";
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Agente emisor</label>
                     <select class="form-control" id="agente_emisor" name="agente_emisor" required>
                        <option value="">Elige una opción…</option>
                        <option value="<?php echo $idconta.".".$iniciales_cliente;?>"><?php echo $idconta.".".$iniciales_cliente;?></option>
                        <?php

                        // $consulta2=mysql_query("SELECT nombre,nomeclatura FROM catalogo_tesorerias");
                        foreach($catalogo_tesorerias as $registro2)
                        {
                           echo "<option value='".$registro2->nomeclatura."'>".$registro2->nomeclatura." ".$registro2->nombre."</option>";
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Institución receptora</label>
                     <select class="form-control" id="receptor" name="receptor" required>
                        <option value="">Elige una opción…</option>
                        <option value="<?php echo $idconta.".".$iniciales_cliente;?>"><?php echo $idconta.".".$iniciales_cliente;?></option>
                        <?php

                        // $consulta2=mysql_query("SELECT nombre FROM bancos_emisores");
                        foreach($bancos_emisores as $registro2)
                        {
                           echo "<option value='".$registro2->nombre."'>".$registro2->nombre."</option>";
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Agente receptor</label>
                     <select class="form-control" id="agente_receptor" name="agente_receptor" required>
                        <option value="">Elige una opción…</option>
                        <option value="<?php echo $idconta.".".$iniciales_cliente;?>"><?php echo $idconta.".".$iniciales_cliente;?></option>
                        <?php

                        // $consulta2=mysql_query("SELECT nombre,nomeclatura FROM catalogo_tesorerias");
                        foreach($catalogo_tesorerias as $registro2)
                        {
                           echo "<option value='".$registro2->nomeclatura."'>".$registro2->nomeclatura." ".$registro2->nombre."</option>";
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Tipo de comprobante</label>
                     <select class="form-control" id="comprobante" name="comprobante" onChange="ocultar_referencia(this.value);" required>
                        <option value="">Elige una opción…</option>
                        <?php

                        // $consulta2=mysql_query("SELECT nombre FROM catalogo_comprobantes");
                        foreach($catalogo_comprobantes as $registro2)
                        {
                           echo "<option value='".$registro2->nombre."'>".$registro2->nombre."</option>";
                        }
                        ?>
                     </select>
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Numero de referencia</label> <label id="respuesta_referecia"></label>
                     <input class="form-control" type="text" id="n_referencia" name="n_referencia" minlength="5" required="" onKeyUp="buscar_referencia();"/>
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Evidencia:</label>
                     <input type="file" placeholder="Evidencia de Comprobante" name="uploadedfile" id="comprobante_archivo" class="form-control" required="">
                  </div>
               </div>

               <div class="col-sm-6">
                  <div class="form-group">
                     <label>Comentarios:</label>
                     <textarea class="form-control" rows="2" id="descripcion" name="descripcion" maxlength="8950" required=""></textarea>
                  </div>
               </div>

               <div class="hr-line-dashed"></div>

               <input type="hidden" name="contacto_original" value='<?php echo "$idconta"; ?>'>
               <input type="hidden" id="concepto_general" name="concepto_general">
               <input type="hidden" name="movimiento_general" value='<?php echo "$id_reg_pagare"; ?>'>
               <input type="hidden" name="fecha_inicio" value='<?php echo "$fecha_inicio"; ?>'>
               <input type="hidden" id="refe_val" value="NO">
               <input type="hidden" value="<?php echo $idconta; ?>" id="co">

               <div class="form-group">
                  <div class="col-lg-12">
                     <br>
                     <center>
                        <button class="btn btn-lg btn-primary" id="enviar" type="submit">Guardar</button>
                     </center>

                  </div>
               </div>

         </div>

      </div>

   </div>
</div>
</div>




</div>






@endsection

@section('js')
<script type="text/javascript">
 $(document).ready(function() {
    $('.js-example-basic-single').select2();
    $("#enviar").click(function() {
      if ($("#refe_val").val() =="NO") {
        alert("Favor de verifica la referencia");
        $("#n_referencia").val("");
        return false;
      }else{
        return true;
      }
    });
 });
</script>
@endsection
