@extends('layouts.appAdmin')

@section('titulo', 'Buscar balance')


@section('head')

<style media="screen">

.tooltipDetalleOrden{
  text-align: center;
}
.tooltipDetalleOrden p{
  position: relative;
  opacity: 0;
  visibility: hidden;
  font-size: 20px;
  font-weight: bold;
  color: #882439;
  transition: .5s;
  transform: translateY(10px);
}
.tooltipDetalleOrden p:before{
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  background: #882439;
  bottom: -8px;
  left: 0;
  transition: .5s;
}
.icon-DOrden{
  width: 100%;
  text-align: center;
}
.icon-DOrden:hover ~ .tooltipDetalleOrden p:before{
  width: 100%;
}
.icon-DOrden:hover ~ .tooltipDetalleOrden p{
  opacity: 1;
  visibility: visible;
  transform: translateY(0px);
}
.font-icong, .font-iconr, .font-iconb{
  margin-bottom: 10px;
  font-size: 100px;
  cursor: pointer;
}
.font-icong{
  color: green;
}
.font-iconr{
  color: #E11515;
}
.font-iconb{
  color: #3A53A8;
}
.font-icong:hover, .font-iconr:hover, .font-iconb:hover{
  color: #882439;
}
.height-r{
  height: 300px;
}
@media only screen and (max-width: 868px){
  .height-r{
    height: 400px;
  }
}
@media only screen and (max-width: 580px){
  .height-r{
    height: 500px;
  }
}
a.iconos-estatus{
  display: inline-block;
  text-align: center;
  padding: 20px 25px;
  line-height: 50px;
  cursor: pointer;
  position: relative;
  margin: 0 auto;
}
/* Agregando estilo de Tooltip a iconos pagina atencion_talleres_detalle (Modulo Ordenes de Proveedores Detallado) EAM */
a.tooltip_pdf_externo:after,
a.tooltip_pdf_interno:after,
a.tooltip_pdf_filtrado:after,
a.tooltip_abono_cargo:after,
a.tooltip_abono_especifico:after,
a.tooltip_mas_recibo:after,
a.tooltip_mas_referencias:after,
a.tooltip_pdf_cja_logis:after{
  position: absolute;
  top: -10px;
  left: 50%;
  transform: translateX(-50%);
  background: #444;
  opacity: 0;
  visibility: hidden;
  transition: .5s;
  font-size: 12px;
  line-height: 30px;
  color: #ccc;
  height: 30px;
  border-radius: 10px;
}
a.tooltip_pdf_externo:after{
  content: 'Externo';
  width: 200px;
}
a.tooltip_pdf_interno:after{
  content: 'Interno';
  width: 200px;
}
a.tooltip_pdf_cja_logis:after{
  content: 'Caja Chica - Logistica';
  width: 250px;
}
a.tooltip_pdf_filtrado:after{
  content: 'Filtrado';
  width: 250px;
}

a.tooltip_abono_especifico:after{
  content: 'Abono especifico';
  width: 250px;
}
a.tooltip_abono_cargo:after{
  content: 'Cargo / Abono sin aplicar';
  width: 250px;
}
a.tooltip_mas_recibo:after{
  content: 'Recibos';
  width: 250px;
}
a.tooltip_mas_referencias:after{
  content: 'Referencias';
  width: 250px;
}




a.tooltip_pdf_externo:hover:after,
a.tooltip_pdf_interno:hover:after,
a.tooltip_pdf_filtrado:hover:after,
a.tooltip_abono_especifico:hover:after,
a.tooltip_abono_cargo:hover:after,
a.tooltip_mas_recibo:hover:after,
a.tooltip_mas_referencias:hover:after,
a.tooltip_pdf_cja_logis:hover:after
{
  opacity: 1;
  visibility: visible;
  top: -20px;
}
a.iconos-estatus:before{
  content: '';
  position: absolute;
  width: 10px;
  height: 10px;
  top: 10px;
  background: white;
  left: 50%;
  transform: translateX(-50%) rotate(45deg);
  opacity: 0;
  visibility: hidden;
  transition: .5s;
}
a.iconos-estatus:hover:before{
  opacity: 1;
  visibility: visible;
  top: 5px;
}

.font-icong{
  color:gray !important;
}
.font-iconr{
  color:gray !important;
}
.font-iconb{
  color:gray !important;
}

.font-icong:hover{
  color:#882439 !important;
}
.font-iconr:hover{
  color:#882439 !important;
}
.font-iconb:hover{
  color:#882439 !important;
}

.font-iconrojo{
  color:gray !important;
}
.font-iconrojo:hover{
  color:#882439 !important;
}

table td {
  vertical-align: middle;
}
</style>
@endsection



@section('content')

<div class="row mt-3">
  <div class="col-sm-12">
    <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
      <span class="text-secondary"> <a href=""><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
      <span class="text-secondary"> Auxiliares</span>
      <br>
      <br>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="">Buscar Auxiliar</label>
            <input type="text" class="form-control" id="buscar_aux" onkeyup="enter(this);">
          </div>
        </div>

        <div class="col-sm-12">
          <div class="form-group">
            <center>
              <button class="btn btn-lg btn-primary buscar">Buscar</button>
            </center>
          </div>
        </div>
      </div>


      <div class="row" style="display:none;" id="ocultar">
        <div class="col-sm-12">
          <div class="form-group">
            <div class="ocultar" style="display: none;margin-bottom:  70px;"><center><i class='fas fa-spinner fa-pulse fa-8x' style='color:#00b0ff;position=absolute;right:45%;top:-20%'></i></center>
            </div>

            <div class="table-responsive">
              <table id="example" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Balance</th>
                    <th>Encabezados</th>
                    <th>Cuenta</th>
                    <th>PDF</th>
                    <th>Más</th>
                  </tr>
                </thead>
                <tbody class="respuesta">
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Balance</th>
                    <th>Encabezados</th>
                    <th>Cuenta</th>
                    <th>PDF</th>
                    <th>Más</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

@endsection
@section('js')
<script>

function buscar_aux(){
  $("#example").dataTable().fnDestroy();
  $(".respuesta").empty();
  $("#buscar_aux").hide();
  $(".buscar").hide();
  let texto = document.getElementById("buscar_aux").value;
  let ocultar = document.getElementById("ocultar");
  ocultar.style.display="none";
  ocultar.style.display="block";
  fetch("{{route('Caja_Chica.auxiliares_buscar')}}", {
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-Requested-With": "XMLHttpRequest",
      "X-CSRF-Token": '{{csrf_token()}}',
    },
    method: "post",
    credentials: "same-origin",
    body: JSON.stringify({
      auxiliar:texto
    })
  }).then(res => res.json())
  .catch(function(error){
    console.error('Error:', error);
  }).then(function(response){
    console.log(response);
    response.forEach(function array(element, index, array) {
      let ruta = "{{route('Caja_Chica.detalle_auxiliares','')}}/"+element.nombre_encriptado;
      let ruta2 = "{{route('Caja_Chica.agregar_cargo_auxiliar_secundario','')}}/"+element.nombre_encriptado;
      let ruta3 = "{{route('Caja_Chica.PDF.interno','')}}/"+element.nombre_encriptado;
      let ruta4 = "{{route('Caja_Chica.PDF.externo','')}}/"+element.nombre_encriptado;
      let ruta5 = "{{route('Caja_Chica.PDF.balance_logistica','')}}/"+element.nombre_encriptado;
      let ruta6 = "{{route('Caja_Chica.PDF.filtrado','')}}/"+element.nombre_encriptado;

      let ruta7 = "{{route('Caja_Chica.PDF.detalle_recebos_auxliar','')}}/"+element.nombre_encriptado;
      let ruta8 = "{{route('Caja_Chica.referencias_coincidencias','')}}/"+element.nombre_encriptado;
      let ruta9 = "{{route('Caja_Chica.registrar_auxiliar','')}}/"+element.nombre_encriptado;
      let encabezados = element.encabezados;
      let idname = element.idname;
      let balance = element.balance;
      let tipo_auxliar = element.tipo_auxliar;
      let beneficiario = element.beneficiario;
      let agregar_encabezados = "";
      if (encabezados == "NO") {
        agregar_encabezados =`<a href='`+ruta9+`' style='color:red !important;'><i class='fa fa-exclamation-triangle fa-2x' aria-hidden='true'></i></a>`;
      }else{
        agregar_encabezados =`<i class='far fa-check-circle fa-2x' aria-hidden='true' style='color:green !important;'></i> <br>
        ID: <b>`+idname+`</b><br>
        Balance: <b>`+balance+`</b><br>
        Tipo: <b>`+tipo_auxliar+`</b><br>
        Beneficiario: <b>`+beneficiario+`</b><br>`;
      }

      let modal_abono_cargo = `<i class=""  data-toggle="modal" data-target="#exampleModalCenter1`+(index+1)+`" style="color:#0B68DD;cursor:pointer;text-aling:center;">`+element.nombre+`</i>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter1`+(index+1)+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Movimientos</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <div class="container">
      <div class="row ">

      <div class="col-sm-6 d-flex align-items-center">
      <a href="`+ruta+`" target="_blank" class="iconos-estatus tooltip_abono_especifico"><span><i class="fa fa-money fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></span></a>
      </div>

      <div class="col-sm-6  d-flex align-items-center">
      <a href="`+ruta2+`" target="_blank" class="iconos-estatus tooltip_abono_cargo"><span><i class="fa fa-money fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></span></a>
      </div>

      </div>
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </div>
      </div>
      </div>`;

      let modal_pdfs = `
      <i class="fas fa-file-pdf fa-2x"  data-toggle="modal" data-target="#exampleModalCenter`+(index+1)+`" style="color:#0B68DD;cursor:pointer;"></i>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter`+(index+1)+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">PDF</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <div class="container">
      <div class="row ">
      <div class="col-sm-3  d-flex align-items-center">
      <a href="`+ruta3+`" target="_blank"  class="iconos-estatus tooltip_pdf_externo"><span><i class="fa fa-file-pdf-o fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></span></a>
      </div>

      <div class="col-sm-3  d-flex align-items-center">
      <a href="`+ruta4+`" target="_blank"  class="iconos-estatus tooltip_pdf_interno"><span><i class="far fa-file fa-2x con-DOrden font-icond font-iconrojo"></i></span></a>
      </div>

      <div class="col-sm-3  d-flex align-items-center">
      <a href="`+ruta5+`" target="_blank"  class="iconos-estatus tooltip_pdf_cja_logis"><span><i class="fa fa-file-pdf-o fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></span></a>
      </div>

      <div class="col-sm-3  d-flex align-items-center">
      <a href="`+ruta6+`" target="_blank" class="iconos-estatus tooltip_pdf_filtrado"><i class="fa fa-filter fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></a>
      </div>
      </div>
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </div>
      </div>
      </div>
      `;

      let modal_mas =`
      <i class="fas fa-plus fa-2x"  data-toggle="modal" data-target="#exampleModalCenter2`+(index+1)+`" style="color:#0B68DD;cursor:pointer;"></i>
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter2`+(index+1)+`" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Más</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body">
      <div class="container">
      <div class="row ">

      <div class="col-sm-6 d-flex align-items-center">
      <a href="`+ruta7+`" target="_blank" class="iconos-estatus tooltip_mas_recibo"><i class="fa fa-files-o fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></a>
      </div>

      <div class="col-sm-6  d-flex align-items-center">
      <a href="`+ruta8+`" target="_blank" class="iconos-estatus tooltip_mas_referencias"><i class="far fa-address-card fa-2x con-DOrden font-icond font-iconrojo" aria-hidden="true"></i></a>
      </div>

      </div>
      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </div>
      </div>
      </div>
      `;

      $(".respuesta").append(`
        <tr>
        <td>`+(index+1)+`</td>
        <td>`+modal_abono_cargo+`</td>
        <td>`+agregar_encabezados+`</td>
        <td>Cargos: <b>$ `+element.montos_cargo+`</b> <br>
        Abonos: <b>$ `+element.montos_abono+`</b> <br>
        Saldo: <b>$ `+element.saldo+`</b> <br>
        </td>
        <td>`+modal_pdfs+`</td>
        <td>`+modal_mas+`</td>
        </tr>
        `);
        $("#buscar_aux").show();
        $(".buscar").show();
      });
      CrearDataT('example')
    });
  }
  function enter(evt){
    let texto = document.getElementById("buscar_aux").value;
    if (texto !="") {
      if (window.event){
        keynum = event.keyCode;
      } else {
        keynum = evt.which;
      }
      if(keynum == 13 ){
        event.preventDefault();
        buscar_aux();
      }
    }
  }

  $(document).ready(function() {
    $(".buscar").click(function() {
      let texto = document.getElementById("buscar_aux").value;
      if (texto !="") {
        buscar_aux();
      }
    });

  });
  </script>
  @endsection
