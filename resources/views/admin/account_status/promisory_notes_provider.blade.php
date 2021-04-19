@extends('layouts.appAdmin')
@section('titulo', 'CCP | Documentos por pagar')
@section('content')

<div class="row mt-3">
  <div class="col-sm-12">
    <div class="shadow panel-head-primary">
      <a class="btn-back" style="margin-left:1px;" href="{{ route('account_status.showAccountStatus',$id_contacto) }}"><i class="fas fa-chevron-left"></i> Resumen de movimientos</a>

         <center>
            <h5 class="text-center mt-3 mb-3"><?php echo $proveedor->nombre." ".$proveedor->apellidos;?></h5><i class="fa fa-archive fa-3x" aria-hidden="true"></i>
         </center>
      </div>
   </div>
   <div class="col-sm-12">
      <!-- row -->
      <div class="row">
         <div class="col-lg-12">
            <div class="ibox float-e-margins">
               <div class="ibox-title">
                  <h5 class="mt-3 mb-3">Resumen</h5>
               </div>
               <div class="ibox-content">
                  <div class="panel-body datatable-panel">
                     <table width="100%" class="table table-striped table-bordered table-hover panel-body-center-table" id="dataTables-example">
                        <thead>
                           <tr>
                              <th></th>
                              <th>Serie</th>
                              <th>Monto</th>
                              <th>Fecha Vencimiento</th>
                              <th>Tipo</th>
                              <th>Estatus</th>
                              <th>Saldo</th>
                              <th>Unidad</th>
                              <th>VIN</th>
                              <th>Comentarios</th>
                              <th>Archivo</th>
                              <th>Evidencia entrega</th>
                              <th>Historial</th>
                           </tr>
                        </thead>
                        <tbody>
                           {!!$contenido!!}
                        </tbody>
                        <tfoot>
                           <tr>
                              <th colspan="6" style="text-align:right">Total:</th>
                              <th colspan="7"></th>
                           </tr>
                        </tfoot>
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
