<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--    <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache"> -->
  <!--Meta Responsive tag-->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,user-scalable=no">

  <!--Validation-->
  <link rel="stylesheet" href="{{secure_asset('public/css/validation.css')}}">
  <!--Bootstrap CSS-->
  <link rel="stylesheet" href="{{secure_asset('public/css/bootstrap.min.css')}}" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!--Custom style.css-->
  <link rel="stylesheet" href="{{secure_asset('public/css/quicksand.css')}}">
  <link rel="stylesheet" href="{{secure_asset('public/css/style.css')}}">
  <!--Font Awesome-->
  <script src="{{secure_asset('public/js/41997afa71.js')}}" crossorigin="anonymous"></script>
  <!--Animate CSS-->
  <link rel="stylesheet" href="{{secure_asset('public/css/animate.min.css')}}">

  <!--Map-->
  <link rel="stylesheet" href="{{secure_asset('public/css/jquery-jvectormap-2.0.2.css')}}">
  <!--Nice select -->
  <link rel="stylesheet" href="{{secure_asset('public/css/nice-select.css')}}">

  <link rel="stylesheet" href="{{secure_asset('public/datapicker_moder/lib/compressed/themes/classic.css')}}">
  <link rel="stylesheet" href="{{secure_asset('public/datapicker_moder/lib/compressed/themes/classic.date.css')}}">
  <link rel="stylesheet" href="{{secure_asset('public/datapicker_moder/lib/compressed/themes/classic.time.css')}}">
  <link rel="stylesheet" href="{{secure_asset('public/Tokenfield/bootstrap-tokenfield.min.css')}}">


  <style media="screen">
  .select2-results__options > li {
    color: #437ae0;
    font-size: 14px;
  }
  .select2-selection__rendered {
    font-size: 12px;
  }

  .modal{
    -webkit-animation: iziT-fadeIn .5s ease both;
    animation: iziT-fadeIn .5s ease both;
  }

  .btn-back:hover {
    color: blue;
  }

  .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
    background-color: #882439 !important;
    color: white !important;
  }
  .my-class-izzi{
      overflow: scroll !important;
      height: 100vh;
  }
  .iziToast > .iziToast-close{
      height: 40px !important;
      background-size: 15px !important;
  }
  .my-class-izzi-json{
      /* display: contents !important; */
      height: 80px;
  }
  </style>

  <!--iziToast -->
  <link rel="stylesheet" href="{{secure_asset('public/css/iziToast.min.css')}}">


  <!--Data Table -->

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="{{secure_asset('public/img/favicon/apple-icon-57x57.png')}}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{secure_asset('public/img/favicon/apple-icon-60x60.png')}}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{secure_asset('public/img/favicon/apple-icon-72x72.png')}}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{secure_asset('public/img/favicon/apple-icon-76x76.png')}}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{secure_asset('public/img/favicon/apple-icon-114x114.png')}}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{secure_asset('public/img/favicon/apple-icon-120x120.png')}}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{secure_asset('public/img/favicon/apple-icon-144x144.png')}}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{secure_asset('public/img/favicon/apple-icon-152x152.png')}}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{secure_asset('public/img/favicon/apple-icon-180x180.png')}}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{secure_asset('public/img/favicon/android-icon-192x192.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{secure_asset('public/img/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{secure_asset('public/img/favicon/favicon-96x96.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{secure_asset('public/img/favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{secure_asset('public/img/favicon/manifest.json')}}">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{secure_asset('public/img/favicon/ms-icon-144x144.png')}}">


  <title>CCP | Home</title>
  @yield('head')
</head>

<body>

  <script src="{{secure_asset('public/js/jquery-3.5.1.min.js')}}" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <script src="{{secure_asset('public/js_1_10_2/jquery-ui.js')}}"></script>


  <style media="screen">

  .pagination{
    flex-wrap: wrap;
  }

  #Myloader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background-color: rgba(0,0,0,0.8);
    display: none;
  }
  @keyframes animatellanta{
			0%{
				transform: rotate(0deg);
				}100%{
					transform: rotate(365deg);
				}
			}
  </style>
  <div id="Myloader">
    <div class="text-center text-light" style="margin-top:25%;">
      <div class="row" style="justify-content: center;">
        <h3 class="">Cargando.....</h3>
          <img src="{{secure_asset('public/img/logo_gran_pana.png')}}" alt="" style="height: 30px;">
      </div>

      <img src="{{secure_asset('public/img/404llanta.webp')}}" alt="" style="height: 70px;animation: animatellanta 1s linear infinite;">

    </div>
  </div>

  <!--Page loader-->
  <div class="loader-wrapper">
    <div class="loader-circle">
      <div class="loader-wave"></div>
    </div>
  </div>
  <!--Page loader-->

  <!--Page Wrapper-->

  <div class="container-fluid" style="padding: 0px;">

    <!-- Menu  -->
    @include('partials.menus')
    {{-- @include('admin.partials.menu') --}}
    <!-- Menu  -->

    <!--Content right-->
    <div class="col-sm-9 col-xs-12 content pt-3" style="">
      @yield('content')
      <!--Footer-->
      @include('admin.partials.footer')
      <!--Footer-->
    </div>
  </div>

  <!--Main Content-->

</div>

<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="{{secure_asset('public/css/datatables.min.css')}}"/>
<script type="text/javascript" src="{{secure_asset('public/js/pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{secure_asset('public/js/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{secure_asset('public/js/datatables.min.js')}}"></script>

<!-- Page JavaScript Files-->

<link href="{{secure_asset('public/css/select2.min.css')}}" rel="stylesheet" />
<script src="{{secure_asset('public/js/select2.min.js')}}"></script>
<!--Popper JS-->
<script src="{{secure_asset('public/js/popper.min.js')}}"></script>
<!--Bootstrap-->
<script src="{{secure_asset('public/js/bootstrap.min.js')}}" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!--Sweet alert JS-->
<script src="{{secure_asset('public/js/sweetalert.js')}}"></script>
<!--Progressbar JS-->
<script src="{{secure_asset('public/js/progressbar.min.js')}}"></script>

<!-- iziToast -->
<script src="{{secure_asset('public/js/iziToast.min.js')}}"></script>



<!--Nice select-->
<script src="{{secure_asset('public/js/jquery.nice-select.min.js')}}"></script>

<!--Custom Js Script-->
<script src="{{secure_asset('public/js/custom.js')}}"></script>

<script src="{{secure_asset('public/datapicker_moder/lib/compressed/picker.js')}}"></script>
<script src="{{secure_asset('public/datapicker_moder/lib/compressed/picker.date.js')}}"></script>
<script src="{{secure_asset('public/datapicker_moder/lib/compressed/picker.time.js')}}"></script>
<script src="{{secure_asset('public/Tokenfield/bootstrap-tokenfield.js')}}"></script>

<script type="text/javascript">
function datatime_global(arg){
  $(arg).pickadate({

    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Otu', 'Nov', 'Dic'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    showMonthsShort: false,
    showWeekdaysFull: false,
  // Buttons
  today: 'Hoy',
  clear: 'Limpiar',
  close: 'Cerrar',

  labelMonthNext: 'Siguiente Mes',
  labelMonthPrev: 'Anterior Mes',
  labelMonthSelect: 'Selecciona un mes',
  labelYearSelect: 'Selecciona un año',

  format: 'yyyy-mm-dd',
  selectMonths: true,
  selectYears: true,
  min:[2015,01,01],
  max:true
});
}
</script>

@if (session('error'))
  <script type="text/javascript">
  var Error_Laravel = '{{ session('error') }}';
  console.error('Error :( ',Error_Laravel);
  var message="{!!session('error')!!}";
  iziToast.error({
    title: 'Error',
    message: message,
    timeout: false,
  });
  </script>
@endif
@if (session('error_array'))
  <script type="text/javascript">
  var Error_Laravel = '{{ session('error_array') }}';
  console.error('Error :( ',Error_Laravel);
  var message = "";
  @foreach(session('error_array') as $value)
        message += '{!!$value!!}<br>';
  @endforeach
  iziToast.error({
      title: 'Error',
      message: message,
      timeout: false,
      class: 'my-class-izzi',
      position: 'center',
      closeOnClick: true,
      closeOnEscape: true,
  });
  </script>
@endif

@if (session('success'))
  <script type="text/javascript">
  var Success_Laravel = '{{ session('success') }}';
  console.log('success :) ',Success_Laravel);
  iziToast.success({
    title: 'OK',
    message: Success_Laravel,
    timeout: 8000,
  });
  </script>
@endif

@if (session('sql'))
  <script type="text/javascript">
  var Queries = '{{ session('sql') }}';
  Queries = Queries.replaceAll('&quot;','');
  console.log(Queries);
  iziToast.info({
    title: 'Hay queries disponibles',
    message: 'En consola',
  });
  </script>
@endif




<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {

      var boton = $(form).find('button:submit');

      boton.click(function(event){


        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();

          iziToast.info({
            title: 'Revisa los campos de tu formulario',
          });
          $(form).find('.form-control:invalid').first()[0].reportValidity();

        }else if($(form).hasClass("confirmation")){

          event.preventDefault();
          event.stopPropagation();


          swal({
            title: "¿Desea guardar los cambios?",
            //text: "",
            icon: "warning",
            buttons: ["No", "Si"],
          }).then((doSubmit) => {
            if (doSubmit) {
              $('#Myloader').fadeIn();
              $(form).submit();
            }
          });
        }
        form.classList.add('was-validated');
      });

      form.addEventListener('submit', function(event) {

        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
          iziToast.info({
            title: 'Revisa los campos de tu formulario',
          });
          $(form).find('.form-control:invalid').first()[0].reportValidity();
        }else if($(form).hasClass("confirmation")){

          event.preventDefault();
          event.stopPropagation();

          swal({
            title: "¿Estas seguro?",
            text: "¿Confirmas que todos los campos son correctos?",
            icon: "warning",
            buttons: ["No - Cancelar", "Si - Confirmar"],
          }).then((doSubmit) => {
            if (doSubmit) {
              $('#Myloader').fadeIn();
              $(form).submit();
            }
          });
        }
        form.classList.add('was-validated');
      }, false);

    });
  }, false);
})();

function CrearDataT(id){
  $('#'+id).dataTable({
    "responsive": true,
    "ordering": true,
    language: {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    dom: 'Blfrtip',
    buttons: [

      'csv', 'excel', 'pdf',
      { extend: 'copy', text: 'Copiar' },
      { extend: 'print', text: 'Imprimir' }

    ]
  });
}

window.onload = function() {
  getLocation();



  $('table:not(.not-dataTable)').dataTable({
    "responsive": true,
    "ordering": true,
    language: {
      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    },
    dom: 'Blfrtip',
    buttons: [

       'csv', 'excel', 'pdf',
       { extend: 'copy', text: 'Copiar' },
       { extend: 'print', text: 'Imprimir' }

    ],
    "initComplete": function(settings, json) {
      $('.dtr-control').click(function(){
        setTimeout(function() {
          $('[data-toggle="tooltip"]').tooltip();          
        }, 300);
      });


    }
  });


}
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}


function showPosition() {



	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(objPosition) {
			var longitud = objPosition.coords.longitude;
			var latitud = objPosition.coords.latitude;
			var Coordenadas = latitud + ", " + longitud;
      console.log(Coordenadas);
			//document.getElementById("lat_long").value = Coordenadas;

			// content.innerHTML = "<p><strong>Latitud:</strong> " + latitud + "</p><p><strong>Longitud:</strong> " + latitud + "</p>";

      var x = latitud + ", " + longitud;
      parametros = {
        "x": x
      };
      /*
      $.ajax({
        data: parametros,
        url: 'guardar_inicio_sesion.php',
        type: 'post',
        success: function(mensaje) {
          response = $.trim(mensaje);

        }
      });*/

		}, function(objPositionError) {
			switch (objPositionError.code) {
				case objPositionError.PERMISSION_DENIED:
				//content.innerHTML = "No se ha permitido el acceso a la posición del usuario.";
				break;
				case objPositionError.POSITION_UNAVAILABLE:
				//content.innerHTML = "No se ha podido acceder a la información de su posición.";
				break;
				case objPositionError.TIMEOUT:
				//content.innerHTML = "El servicio ha tardado demasiado tiempo en responder.";
				break;
				default:
				//content.innerHTML = "Error desconocido.";
			}
		}, {
			maximumAge: 75000,
			timeout: 15000
		});
	} else {
		content.innerHTML = "Su navegador no soporta la API de geolocalización.";
	}
}





$(document).ready(function() {

  $('.Capitalizar').keyup(function(event){
    //console.log("El código de la tecla " + String.fromCharCode(event.which) + " es: " + event.which);
    if(event.which != 32){
      var miString = $(this).val();
      var Capitalizado = miString.trim().toLowerCase().replace(/\w\S*/g, (w) => (w.replace(/^\w/, (c) => c.toUpperCase())));
      $(this).val(Capitalizado);
    }
  });



        fetch("{{route('change_password_automatic.verifyTimePassword')}}", {
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": '{{csrf_token()}}',
            },
            method: "post",
            credentials: "same-origin",
            body: JSON.stringify({
                id : null
            })
        }).then(res => res.json())
        .catch(function(error){
            console.error('Error:', error);
        })
        .then(function(response){

            //console.log(response);
            if (response.tiempo_restante != "" ) {
              var NumNotificaciones = 1;
              $('#body-notification-password').append('<h6 class="mt-0"><strong>Tu Key Access esta por expirar, favor de renovarla.</strong></h6><p>Ver</p><small class="text-success">Tiempo Restante: '+response.tiempo_restante+' </small>');
              document.getElementById('num-notification-password').style.background  = '#ff7575';
              document.getElementById('num-notification-password').textContent = NumNotificaciones;

              iziToast.error({
                  title: '¡La contraseña está por expirar!',
                  message: response.tiempo_restante,
                  timeout: false,
                  class: 'my-class-izzi-json',
                  titleSize: '25px',
                  messageSize: '20px',
                  // backgroundColor: 'rgba(100, 8, 12, 0.9)',
                  // backgroundColor: 'rgb(152 154 13 / 90%)',
                  backgroundColor: response.color_message,
                  // position: 'center',
                  closeOnClick: true,
                  closeOnEscape: true,
              });
            }

        });









  $('.js-example-basic-single:not(#search_contacts_cars)').select2({
    language: {
      "noResults": function(){
           return "Sin resultados";
       }
    },
    placeholder: "Buscar",
  });

  let input_select_providers = null;
  var Temporizador_providers;

  $('#search_provider_client').on('select2:open', function(e) {
    if (input_select_providers == null) {
      input_select_providers = document.querySelector('.select2-search__field');
      input_select_providers.addEventListener('input', updateValue);

      function updateValue(e) {
        clearTimeout(Temporizador_providers);
        Temporizador_providers = setTimeout(function() {
          searchClientProvider(e.target.value)
        }, 3);
      }
    }
  });
  let input_select_contacts = null;
  var Temporizador_contacts;

  $('#search_contact').on('select2:open', function(e) {
    if (input_select_contacts == null) {
      input_select_contacts = document.querySelector('.select2-search__field');
      input_select_contacts.addEventListener('input', updateValue);

      function updateValue(e) {
        clearTimeout(Temporizador_contacts);
        Temporizador_contacts = setTimeout(function() {
          searchContact(e.target.value)
        }, 0);
      }
    }
  });
  $('#search_contact').on('select2:close', function(e) {
    // console.log(e);
    getClient(e.target.value);


  });
  $('#search_provider_client').on('select2:close', function(e) {
    // console.log(e);
    getClientProvider(e.target.value);

  });
  // $('#search_provider_client').on('select2:selecting', function (e) {
  //   // console.log(e);
  //     getClientProvider(e.target.value);
  //
  // });
});
</script>


  @yield('js')


</body>
</html>
