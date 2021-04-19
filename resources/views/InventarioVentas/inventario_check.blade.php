@extends('layouts.appAdmin')
@section('titulo', 'CCP | Pagares')

@section('js')

@endsection

@section('content')


  <style media="screen">
  .content {
    padding-left: 0px !important;
  }
  .container {
    padding-left: 0px !important;
  }

  tr > td {
    text-align: center;
  }
  .tagrojo, .tagverde{
    text-align: center;
    color: #fff;
    padding: 4px;
    border: 1px solid #ffffffB3;
    border-radius: 10px;
    font-size: 8px;
  }
  .tagrojo{
    background: #ef5353;
    box-shadow: 5px 5px 5px #ef535380, inset 0px 0px 6px #ffffff80;
    animation: animatetagvin 1s linear infinite alternate;
  }
  @keyframes animatetagvin{
    0%{
      box-shadow: 5px 5px 5px #ef535380, inset 0px 0px 0px #00000080;
      }100%{
        box-shadow: 5px 5px 5px #ef535380, inset 0px 0px 20px #00000080;
      }
    }
    .tagverde{
      background: #38AC66;
      box-shadow: 5px 5px 5px #38AC6680, inset 0px 0px 6px #ffffff80;
      animation: animatetagvin2 1s linear infinite alternate;
    }
    @keyframes animatetagvin2{
      0%{
        box-shadow: 5px 5px 5px #38AC6680, inset 0px 0px 0px #00000080;
      }
      100%{
        box-shadow: 5px 5px 5px #38AC6680, inset 0px 0px 20px #00000080;
      }
    }
    </style>


    <div class="container">
      <div class="col-sm-12 col-xs-12 content pt-3 pl-0">

        <div class="row mt-3">
          <div class="col-sm-12">
            <!--Datatable-->
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
              <span class="text-secondary"> <a href="index.php"><i class="fa fa-dashboard fa-2x"></i></a> <i class="fa fa-angle-right"></i> </span>
              <span class="text-secondary"> Inventario Unidades</span>
              <br>
              <div class="col-lg-12">

                <center>
                  <h2> <b>{{sizeof($Inventario)}}</b> Unidad{{sizeof($Inventario) > 1 ? 'es':''}}</h2> <i class="fa fa-car fa-3x" aria-hidden="true"></i>
                </center>
                <br>
                <ol class="breadcrumb">

                  <br>
                  <li  class="active">
                    <strong>Actualización: </strong>{{\Carbon\Carbon::parse($LastUpdate)->format('d/m/Y H:i:s')}}
                  </li>
                </ol>
              </div>


              <div class="col-sm-12">
                <br>
                <i class="fa fa-chevron-circle-down fa-2x fa-fw" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></i><b data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Estatus Unidad</b>
                <span>
                  <div class="collapse" id="collapseExample">
                    @foreach ($Estatus_unidad as $estatus)
                      <input onchange='filterme()' type='checkbox' class='filtros' name='tcli'
                      @if ($estatus == 'Taller' || $estatus == 'TALLER' || $estatus == 'taller')
                        value='{{'Taller'}}'
                      @else
                        value='{{strtoupper($estatus)}}'
                      @endif
                      > {{strtoupper($estatus)}}
                    @endforeach
                  </div>
                </span><br><br>

                @if (sizeof($Marcas)>1 )
                  <i class="fa fa-chevron-circle-down fa-2x fa-fw" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample"></i><b data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">Marca</b>
  								<span>
  									<div class="collapse" id="collapseExample1">
                      @foreach ($Marcas as $mar)
                        <input onchange='filterme()' type='checkbox' class='filtros' name='cred' value='{{$mar}}'>&nbsp;{{$mar}} &nbsp; &nbsp;
                      @endforeach
  									</div>
  								</span><br><br>
                @endif

                <i class="fa fa-chevron-circle-down fa-2x fa-fw" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample"></i><b data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">Modelo</b>
                <span>
                  <div class="collapse" id="collapseExample2">
                    @foreach ($Modelos as $key => $m)
                      <input onchange='filterme()' type='checkbox' class='filtros' name='modelo' value='{{$m}}'> {{$m}}
                    @endforeach
                  </div>
                </span>
                <br><br>

                <i class="fa fa-chevron-circle-down fa-2x fa-fw" data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample"></i><b data-toggle="collapse" data-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">Kilometraje</b>
                <span>
                  <div class="collapse" id="collapseExample3">
                    @foreach ($Kilometraje as $key => $k)
                      <input onchange='filterme()' type='checkbox' class='filtros' name='km' value='{{$k.' Km'}}'> {{$k.' Km'}}
                    @endforeach
                  </div>
                </span>
                <br><br>

                <!--
                <i class="fa fa-chevron-circle-down fa-2x fa-fw" data-toggle="collapse" data-target="#collapseExample7" aria-expanded="false" aria-controls="collapseExample"></i><b data-toggle="collapse" data-target="#collapseExample7" aria-expanded="false" aria-controls="collapseExample">Dias de inventario</b>


                <div class="collapse" id="collapseExample7">
                  <div class="row">

                    <input type="hidden" id="min1interno" name="min1interno">
                    <input type="hidden" id="max1interno" name="max1interno">


                    <div class="col-lg-3 floating-label">
                      <input type="radio" name="dias_inventario" value="1-30">
                      <label for="">&nbsp;&nbsp;1 - 30 dias</label>
                    </div>
                    <div class="col-lg-3 floating-label">
                      <input type="radio" name="dias_inventario" value="31-60">
                      <label for="">&nbsp;&nbsp;31 - 60 dias</label>
                    </div>
                    <div class="col-lg-3 floating-label">
                      <input type="radio" name="dias_inventario" value="61-90">
                      <label for="">&nbsp;&nbsp;61 - 90 dias</label>
                    </div>
                    <div class="col-lg-3 floating-label">
                      <input type="radio" name="dias_inventario" value="91-2000000">
                      <label for="">&nbsp;&nbsp;91 + dias</label>
                    </div>
                  </div>
                </div>
              -->


                @if ($Id_Empleado == 88 || $Id_Empleado == 91 || $Id_Empleado == 257 || $Id_Empleado == 258 || $Id_Empleado == 259)


                <i class="fa fa-chevron-circle-down fa-2x fa-fw" data-toggle="collapse" data-target="#collapseExample9" aria-expanded="false" aria-controls="collapseExample"></i>
                <b data-toggle="collapse" data-target="#collapseExample9" aria-expanded="false" aria-controls="collapseExample">Expediente</b>
                <span>
                  <div class="collapse" id="collapseExample9">
                    <input onchange='filterme()' type='checkbox' class='filtros' name='expediente' value='Expediente'> SI&nbsp; &nbsp;
                    <input onchange='filterme()' type='checkbox' class='filtros' name='expediente' value='Sin Expediente'> NO&nbsp; &nbsp;


                  </div>
                </span>
                <br><br>
                @endif

                <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>VIN</th>
                        <th>Marca</th>
                        <th>Versión</th>
                        <th>Color</th>
                        <th>Modelo</th>
                        <th>Precio Piso</th>
                        <th>Precio Digital</th>
                        <th>Kilometraje</th>
                        <th>Tipo Factura</th>
                        <th>Dueño</th>
                        <th>Ubicación</th>
                        <th>Ficha Tecnica</th>
                        <th>Estatus Unidad</th>
                        <th>?</th>
                        @if ($Id_Empleado == 88 || $Id_Empleado == 91 || $Id_Empleado == 257 || $Id_Empleado == 258 || $Id_Empleado == 259)
                        <th>Expediente</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($Inventario as $key => $Vehiculo)
                        <tr class='odd gradeX'>

                          <td data-toggle='tooltip' data-placement='top' title='Clic'><a href="{{route('Inv_Ventas.details',Crypt::encrypt($Vehiculo->vin_numero_serie))}}">{{$Vehiculo->vin_numero_serie}} {!!$Vehiculo->se!!} <br>{!!$Vehiculo->doc!!}</a></td>
                          <td>{{$Vehiculo->marca}}</td>
                          <td>{{$Vehiculo->version}}</td>
                          <td>{{$Vehiculo->color}}</td>
                          <td>{{$Vehiculo->modelo}}</td>
                          <td>${{number_format($Vehiculo->precio_piso,2)}}</td>
                          <td>${{number_format($Vehiculo->precio_digital,2)}}</td>
                          <td>{{number_format($Vehiculo->kilometraje,2)}} Km</td>
                          <td>{{$Vehiculo->tipo_fa}}</td>
                          <td>{{$Vehiculo->dueno}}</td>
                          <td>{{$Vehiculo->ubicacion}}</td>
                          <td>{!!$Vehiculo->pdf_detalle!!}</td>
                          <td>
                            @if ($Vehiculo->estatus_unidad == 'Taller' || $Vehiculo->estatus_unidad == 'TALLER' || $Vehiculo->estatus_unidad == 'taller')
                              {{'Taller'}}
                            @else
                              {{strtoupper($Vehiculo->estatus_unidad)}}
                            @endif
                          </td>
                          <td>{{$Vehiculo->days}}</td>
                          @if ($Id_Empleado == 88 || $Id_Empleado == 91 || $Id_Empleado == 257 || $Id_Empleado == 258 || $Id_Empleado == 259)
                          <td>{{$Vehiculo->doc_p}}</td>
                          @endif
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>VIN</th>
                        <th>Marca</th>
                        <th>Versión</th>
                        <th>Color</th>
                        <th>Modelo</th>
                        <th>Precio Piso</th>
                        <th>Precio Digital</th>
                        <th>Kilometraje</th>
                        <th>Tipo Factura</th>
                        <th>Dueño</th>
                        <th>Ubicación</th>
                        <th>Ficha Tecnica</th>
                        <th>Estatus Unidad</th>
                        <th>?</th>
                        @if ($Id_Empleado == 88 || $Id_Empleado == 91 || $Id_Empleado == 257 || $Id_Empleado == 258 || $Id_Empleado == 259)
                        <th>Expediente</th>
                        @endif
                      </tr>
                    </tfoot>
                  </table>
                </div>
                @if ($Id_Empleado == 88 || $Id_Empleado == 91 || $Id_Empleado == 257 || $Id_Empleado == 258 || $Id_Empleado == 259)
  								<label for="">Precio Piso</label>
  								<b>
                    ${{number_format($suma_pis,2)}}
  								</b><br>
  								<label for="">Precio Digital</label>
                  <b>
                    ${{number_format($suma_digi,2)}}
  								</b>
  								@endif

              </div>
              <!--/Datatable-->

            </div>


            <!-- row -->
            <div class="row mt-3">
              <div class="col-lg-12">
                <div class="ibox float-e-margins mt-1 mb-3 p-3 button-container bg-white border shadow-sm">


                </div>
              </div>
            </div>
            <!-- row fin -->
          </div>



        </div>
      </div>
    </div>

    <script type="text/javascript">
    function VerDetalles(vin){
      var RutaDetalles = '{{route('Inv_Ventas.details','')}}';
      document.location = RutaDetalles+"/"+vin;
    }


    function filterme() {
      //build a regex filter string with an or(|) condition
      var types = $('input:checkbox[name="tcli"]:checked').map(function() {
        return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      $('#example').dataTable().fnFilter(types, 12, true, false, false, false);

      var types = $('input:checkbox[name="cred"]:checked').map(function() {
        return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      $('#example').dataTable().fnFilter(types, 1, true, false, false, false);

      var types = $('input:checkbox[name="km"]:checked').map(function() {
        return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      $('#example').dataTable().fnFilter(types, 7, true, false, false, false);

      var types = $('input:checkbox[name="modelo"]:checked').map(function() {
        return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      $('#example').dataTable().fnFilter(types, 4, true, false, false, false);

      /*
      var types = $('input:checkbox[name="color"]:checked').map(function() {
        return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      $('#example').dataTable().fnFilter(types, 10, true, false, false, false);

      var types = $('input:checkbox[name="mercado"]:checked').map(function() {
        return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      $('#example').dataTable().fnFilter(types, 11, true, false, false, false);
      */


      var types = $('input:checkbox[name="expediente"]:checked').map(function() {
        return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      $('#example').dataTable().fnFilter(types, 14, true, false, false, false);

    }
    /*
    $('input[type=radio][name=dias_inventario]').change( function() {

      if ($("input[name='dias_inventario']:checked").val() == '1-30') {
        $("#min1interno").val('1');
        $("#max1interno").val('30');
      } else if ($("input[name='dias_inventario']:checked").val() == '31-60') {
        $("#min1interno").val('31');
        $("#max1interno").val('60');
      } else if ($("input[name='dias_inventario']:checked").val() == '61-90') {
        $("#min1interno").val('61');
        $("#max1interno").val('90');
      } else if ($("input[name='dias_inventario']:checked").val() == '91-2000000') {
        $("#min1interno").val('91');
        $("#max1interno").val('2000000');
      }

      $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
          var min = parseInt( $('#min1interno').val(), 10 );
          var max = parseInt( $('#max1interno').val(), 10 );
          var age = parseFloat( data[9] ) || 0;

          if ( ( isNaN( min ) && isNaN( max ) ) ||
          ( isNaN( min ) && age <= max ) ||
          ( min <= age   && isNaN( max ) ) ||
          ( min <= age   && age <= max ) )
          {
            return true;
          }
          return false;
        }
      );


      $('#example').dataTable().fnDraw();

    } );*/
    </script>

  @endsection
