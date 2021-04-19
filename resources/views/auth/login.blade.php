<!DOCTYPE html>
<html lang="es">

<head>
	<title>CCP | Bienvenidos</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="{{secure_asset('public/login/css/main.css')}}">
	<!--iziToast -->
	<link rel="stylesheet" href="{{secure_asset('public/css/iziToast.min.css')}}">
	<!--====== Scripts -->
	<script src="{{secure_asset('public/login/js/jquery-3.1.1.min.js')}}"></script>
	<script src="{{secure_asset('public/login/js/bootstrap.min.js')}}"></script>
	<script src="{{secure_asset('public/login/js/material.min.js')}}"></script>
	<script src="{{secure_asset('public/login/js/ripples.min.js')}}"></script>
	<script src="{{secure_asset('public/login/js/sweetalert2.min.js')}}"></script>
	<!-- iziToast -->
	<script src="{{secure_asset('public/js/iziToast.min.js')}}"></script>
	<script src="{{secure_asset('public/login/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
	<script src="{{secure_asset('public/login/js/main.js')}}"></script>
	<link href="{{secure_asset('public/login/js/fontawesome-5/css/all.css')}}" rel="stylesheet">
	<link href="{{secure_asset('public/login/js/fontawesome-5/css/fontawesome.css')}}" rel="stylesheet">
	<link href="{{secure_asset('public/login/js/fontawesome-5/css/brands.css')}}" rel="stylesheet">
	<link href="{{secure_asset('public/login/js/fontawesome-5/css/solid.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{secure_asset('public/login/css/alert_popup.css')}}">



	<link rel="apple-touch-icon" sizes="57x57" href="{{secure_asset('public/login/img/favicon/apple-icon-57x57.png')}}">
	<link rel="apple-touch-icon" sizes="60x60" href="{{secure_asset('public/login/img/favicon/apple-icon-60x60.png')}}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{secure_asset('public/login/img/favicon/apple-icon-72x72.png')}}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{secure_asset('public/login/img/favicon/apple-icon-76x76.png')}}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{secure_asset('public/login/img/favicon/apple-icon-114x114.png')}}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{secure_asset('public/login/img/favicon/apple-icon-120x120.png')}}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{secure_asset('public/login/img/favicon/apple-icon-144x144.png')}}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{secure_asset('public/login/img/favicon/apple-icon-152x152.png')}}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{secure_asset('public/login/img/favicon/apple-icon-180x180.png')}}">
	<link rel="icon" type="image/png" sizes="192x192" href="{{secure_asset('public/login/img/favicon/android-icon-192x192.png')}}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{secure_asset('public/login/img/favicon/favicon-32x32.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{secure_asset('public/login/img/favicon/favicon-96x96.png')}}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{secure_asset('public/login/img/favicon/favicon-16x16.png')}}">
	<!-- <link rel="manifest" href="/manifest.json"> -->
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="{{secure_asset('public/login/img/favicon/ms-icon-144x144.png')}}">

	<style>
	footer {
		color: white;
		position: relative;
		top: 750px;
	}

	footer a {
		color: red;
	}

	#register {
		border-radius: 5px;
		transition: border-radius ease 0.2s;
	}

	#register:hover {
		border-radius: 20px;
		border-color: #80bdff;
		outline: 0;
		box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
	}

	#btn_registrarse {
		border-radius: 15px;
	}
	</style>
</head>

<body class="cover" style="background-image: url({{secure_asset('public/login/img/banner_panamotors.jpg') }});">
	<div class="error-form" style="background: rgba(255, 255, 255, 1); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
		<div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%);">
			<div class="popup-mensaje popuperror animatepopup">
				<div style="padding: 10px 20px; background: #F13154;">
					<div class="error">
						<span class="icono-error"></span>
					</div>
				</div>
				<div class="text-center mt-2" style="padding: 10px 20px;">
					<h1 style="font-size: 22px;" class="text-error"></h1>
				</div>
			</div>
		</div>
	</div>
	<div id="Mensajes" style="color:white;">

	</div>
	<form name="form" id="register" enctype="multipart/form-data" method="POST" autocomplete="off" class="full-box logInForm" action="{{route('login')}}">
		@csrf
		<p class="text-center text-muted"><i class="fas fa-user-lock fa-4x"></i></p>
		<p class="text-center text-muted text-uppercase">Inicia sesión</p>
		<!-- 			<div id="geolocation-test"></div>
	-->
	<div class="form-group label-floating">
		<label class="control-label" for="UserPass">Key Access</label>
		<input class="form-control" id="password" type="password" name="password">
		<center><i class="fa fa-eye fa-2x" id="mostrar"></i></center>

		<p class="help-block">Escribe tú Key Access</p>
	</div>

	<input type="hidden" name="lat_long" id="lat_long" value="">
	<div class="form-group text-center">
		<input type="submit" value="Iniciar sesión" class="btn btn-raised btn-danger btn-login" id="btn_registrarse">
	</div>
</form>
<footer>

	<center>
		Copyright© 2018-2021 Panamotors Center S.A de C.V. Todos los Derechos Reservados | <a target="_blank" href="docs/aviso_privacidad.pdf">Política de Privacidad</a>
	</center>

</footer>
<script>
$.material.init();


$(document).ready(function() {

	$('#mostrar').click(function() {
		if ($(this).hasClass('fa-eye')) {
			$('#password').removeAttr('type');
			$('#mostrar').addClass('fa-eye-slash').removeClass('fa-eye');
		} else {

			$('#password').attr('type', 'password');
			$('#mostrar').addClass('fa-eye').removeClass('fa-eye-slash');
		}
	});

	Localizacion();
});

//****************************************************************************
function Localizacion() {

	var content = document.getElementById("Mensajes");

	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(objPosition) {
			var longitud = objPosition.coords.longitude;
			var latitud = objPosition.coords.latitude;
			var Coordenadas = latitud + ", " + longitud;

			document.getElementById("lat_long").value = Coordenadas;
			

			// content.innerHTML = "<p><strong>Latitud:</strong> " + latitud + "</p><p><strong>Longitud:</strong> " + latitud + "</p>";

		}, function(objPositionError) {
			switch (objPositionError.code) {
				case objPositionError.PERMISSION_DENIED:
				content.innerHTML = "No se ha permitido el acceso a la posición del usuario.";
				break;
				case objPositionError.POSITION_UNAVAILABLE:
				content.innerHTML = "No se ha podido acceder a la información de su posición.";
				break;
				case objPositionError.TIMEOUT:
				content.innerHTML = "El servicio ha tardado demasiado tiempo en responder.";
				break;
				default:
				content.innerHTML = "Error desconocido.";
			}
		}, {
			maximumAge: 75000,
			timeout: 15000
		});
	} else {
		content.innerHTML = "Su navegador no soporta la API de geolocalización.";
	}
}
//****************************************************************************



$('#register').submit(function(e){

	// var lat_logi  = lon2 + lat2;*/
	var lat_logi = $("#lat_long").val();
	var x = document.getElementById("password").value;
	if (lat_logi == "") {

		e.preventDefault(); // Cancel the submit

		$(".error-form").show();
		$(".text-error").html("Activa tu ubicación");


		setTimeout(function() {
			$(".error-form").fadeOut(1000);
			Localizacion();
		}, 1500);

	}


	if (lat_logi != "") {
		if (x.length == 0) {

			e.preventDefault(); // Cancel the submit

			$(".error-form").show();
			$(".text-error").html("No haz digitado ninguna password");


			setTimeout(function() {
				$(".error-form").fadeOut(1000);
			}, 1500);
			return;
		}
	}
});



$(document).ready(function() {

	var ventana_ancho = $(window).width();
	var ventana_alto = $(window).height();

	//console.log(ventana_alto);
	//alert(ventana_alto);

	if (ventana_alto > 900) {
		$("#contenedor").attr("style", "margin-top:30%;");
	} else if (ventana_alto < 899 && ventana_alto > 800) {
		$("#contenedor").attr("style", "margin-top:135%;");
	} else if (ventana_alto < 799 && ventana_alto > 700) {
		$("#contenedor").attr("style", "margin-top:105%;");
	}

});
</script>

@if (session('error'))
	<script type="text/javascript">
	var Error_Laravel = '{{ session('error') }}';
	console.error('Error :( ',Error_Laravel);
	iziToast.error({
		title: 'Error',
		message: Error_Laravel,
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
	});
	</script>
@endif

</body>

</html>
