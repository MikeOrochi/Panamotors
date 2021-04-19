@extends('layouts.appAdmin')
@section('titulo', 'CCP | Documentos por pagar proveedor')
@section('content')
@php use App\Http\Controllers\Admin\TransferController; @endphp
@php use App\Models\usuarios; @endphp
<div class="row mt-3">
  <div class="col-sm-12">
    <div class="shadow panel-head-primary">
      <a class="btn-back" style="margin-left:1px;" href="{{ route('account_status.promisoryNotesProvider',$perfil) }}"><i class="fas fa-chevron-left"></i> Resumen de abonos a movimientos</a>

      <center>
          <h2>{{$nombre." ".$apellidos}}</h2>
          <p style="font-size: 18px;">{{$folio."-".$folio_anterior}}</p>
          <i class="fa fa-archive fa-3x" aria-hidden="true"></i>
          <p style="font-size: 14px;">{{$nombre_unidad}}</p>
          <p>{{"$ ".number_format($precio_unidad, 2, '.', '')}}</p>
          <p style="font-size: 18px;">Vin: {{$vin_unidad}}</p>
      </center>
      </div>
   </div>
   <div class="col-sm-12">
      <!-- row -->
      <div class="row">
         <div class="col-lg-12">
            <div class="ibox float-e-margins">
               <div class="ibox-title" align='center'>
                  <h5 class="mt-3 mb-3">Resumen de abonos a documentos por pagar</h5>
               </div>
               <div class="ibox-content">
                  <div class="panel-body datatable-panel">
                     <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example">
                        <thead>
                           <tr>
                             <th>#</th>
                             <th>Saldo anterior</th>
                             <th>Monto</th>
                             <th>Saldo</th>
                             <th>Fecha movimiento</th>
                             <th>Método de pago</th>
                             <th>Institución emisora</th>
                             <th>Agente emisor</th>
                             <th>Institución receptora</th>
                             <th>Agente receptor</th>
                             <th>Tipo comprobante</th>
                             <th>Referencia</th>
                             <th>Archivo</th>
                             <th>Comentarios</th>
                             <th>Usuario guardo</th>
                             <th>Fecha guardado</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($abonos_pagares_proveedores as $key => $abono_pagare_proveedor)
                             <tr>
                               <td>{{$key+1}}</td>
                               <td>${{number_format($abono_pagare_proveedor->cantidad_inicial,2)}}</td>
                               <td>${{number_format($abono_pagare_proveedor->cantidad_pago,2)}}</td>
                               <td>
                                 ${{number_format($abono_pagare_proveedor->cantidad_pendiente,2)}}<br>
                                 ({{TransferController::getNumberToLetters($abono_pagare_proveedor->cantidad_pendiente,$moneda)['info']}})
                               </td>
                               <td>{{$abono_pagare_proveedor->fecha_pago}}</td>
                               <td>{{$abono_pagare_proveedor->metodo_pago}}</td>
                               <td>{{$abono_pagare_proveedor->emisora_institucion}}</td>
                               <td>{{$abono_pagare_proveedor->emisora_agente}}</td>
                               <td>{{$abono_pagare_proveedor->receptora_institucion}}</td>
                               <td>{{$abono_pagare_proveedor->receptora_agente}}</td>
                               <td>{{$abono_pagare_proveedor->tipo_comprobante}}</td>
                               <td>{{$abono_pagare_proveedor->referencia}}</td>
                               <td>
                                 @php
                                   if (strpos($abono_pagare_proveedor->archivo, '/var/www/html')===0) {
                                     $ruta = str_replace("/var/www/html", "", $abono_pagare_proveedor->archivo);;
                                   }else { $ruta = $abono_pagare_proveedor->archivo; }
                                 @endphp
                                 @if ($abono_pagare_proveedor->archivo == '' || $abono_pagare_proveedor->archivo == null || $abono_pagare_proveedor->archivo == '#')
                                   N/A
                                 @else
                                   <a href="{{$ruta}}" target="_blank"><i class='fa fa-file'></i></a>
                                 @endif
                               </td>
                               <td>{{$abono_pagare_proveedor->comentarios}}</td>
                               <td>
                                 {{usuarios::where('idusuario',$abono_pagare_proveedor->usuario_guardo)->get('nombre_usuario')->first()->nombre_usuario}}
                               </td>
                               <td>{{$abono_pagare_proveedor->fecha_guardado}}</td>
                             </tr>
                           @endforeach
                        </tbody>
                     </table>
                     <!-- /.table-responsive -->
                  </div>
                  <!-- /.panel-body -->
               </div>
               <!-- Fin | ibox-content -->
            </div>
         </div>
      </div>
      <!-- fin | row -->
   </div>
</div>




@endsection



@section('js')


<script>
   $(document).ready(function() {
     /*
      $('#dataTables-example').DataTable({
         "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
               return typeof i === 'string' ?
               i.replace(/[\$,]/g, '')*1 :
               typeof i === 'number' ?
               i : 0;
            };

            // Total over all pages
            total = api
            .column( 6 )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 6, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            $( api.column( 6 ).footer() ).html(
               '$ '+formatNumber.new(pageTotal.toFixed(2))+' (Deuda Total: $ '+formatNumber.new(total.toFixed(2))+' )'
            );
         },
         responsive: true,
         lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
         dom: 'Blfrtip',
         buttons: [
            'copy', 'excel'
         ]

      });*/

      /*var table = $('#dataTables-example').DataTable();

      table.order([ 0, 'asc' ]).draw();
      */
    });

   /*$(function() {
      otable = $('#dataTables-example').dataTable();
   })*/

   function filterme() {
      //build a regex filter string with an or(|) condition
      var types = $('input:checkbox[name="ases"]:checked').map(function() {
         return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      otable.fnFilter(types, 6, true, false, false, false);

      var types = $('input:checkbox[name="cred"]:checked').map(function() {
         return '^' + this.value + '\$';
      }).get().join('|');
      //filter in column 0, with an regex, no smart filtering, no inputbox,not case sensitive
      otable.fnFilter(types, 8, true, false, false, false);

   }


   var formatNumber = {
      separador: ",", // separador para los miles
      sepDecimal: '.', // separador para los decimales
      formatear:function (num){
         num +='';
         var splitStr = num.split('.');
         var splitLeft = splitStr[0];
         var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
         var regx = /(\d+)(\d{3})/;
         while (regx.test(splitLeft)) {
            splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
         }
         return this.simbol + splitLeft  +splitRight;
      },
      new:function(num, simbol){
         this.simbol = simbol ||'';
         return this.formatear(num);
      }
   }
</script>

<script type="text/javascript">


   // In your Javascript (external .js resource or <script> tag)
   $(document).ready(function() {
      $('.js-example-basic-single').select2();
   });



</script>

@endsection
