<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<style>
	.imgDP{
		animation: animateimgDP 7s linear infinite;
	}
	@keyframes animateimgDP{
		0%{
			transform: rotate3d(0,1,0,0deg);
		}
		50%{
			transform: rotate3d(0,1,0,0deg) scale(1.2);
		}
		100%{
			transform: rotate3d(0,1,0,360deg);
		}
	}
	#primero{
		margin-top: 20px !important;
	}
	.primero,.segundo {

		padding:5px;
		border:0px solid #ccc;
		background-color:#f1f1f1;
		position:relative;
		width:85%;
		height: 0px;
		transform: scaleY(0);
		transition: .5s;
	}
	#segundo {
		position:absolute;
		top:85%;
	}
	.parent a{
		position: relative;
	}
	.parent a .tooltipDP{
		position: absolute;
		background: #000;
		width: 100%;
		text-align: center;
		font-size: 10px;
		padding: 10px 20px;
		left: -500%;
		top: 50%;
		transform: translateY(-50%);
		transition: .5s;
	}
	.parent a:hover .tooltipDP{
		left: 0;
	}
	.menu-icon{
		display: none !important;
	}
	.sidebarDP{
		position: fixed;
		top: 0px !important;
		z-index: 1000;
		width: 200px;
		height: 540px !important;
		overflow-y: scroll !important;
		background: rgba(0,0,0,.6) !important;
	}
	/* Al pasar el mouse por encima del div mostramos el div con la
	clase ".primero". Esta clase, tiene que estar dentro del id
	"primero" para que pueda funcionar
	*/
	#primero:hover .primero {
		height: 100%;
		transform: scaleY(1);
	}
	#segundo:hover .segundo {
		display:block;
	}
	.content-tags {
		padding:1px;
		border:0px solid #ccc;
		background-color:#f1f1f1;
		width:85%;
		/*            height: 100%;*/
		transition: .5s;
		/* position: relative;
		right: -100%;
		top: 0;*/

	}

	.content-tags h6{
		font-size: 12px;
		/*background: #000;*/
		border-radius: 5px;
		margin-top: 2px;
		padding: 2px;
		transform: scale(1) translateX(0px);
		/*animation: animateTags 3s linear infinite alternate;*/
	}

	.estilos_boton{

		width: 200px;
		outline:none !important;
		background: #0D0D0D !important;
		border:0px solid #ccc;
		border-radius: 30px;
		cursor: pointer !important;
		padding: 0px 30px;
		height: 30px;
		animation: animateTags 3s linear infinite alternate;
	}
	.estilos_boton:hover{
		background: #C51E1E !important;
	}
	@keyframes animateTags{
		0%{
			transform: translateX(0px) scale(1);
			}25%{
				transform: translateX(5px) scale(1) ;
				}50%{
					transform: translateX(5px) scale(1.05) ;
					}75%{
						transform: translateX(5px) scale(1);
						}100%{
							transform: translateX(0px) scale(1);
						}
					}

					/* Agregando diseño de buscador pagina direccionador_perfiles.php EAM */
					.buscador-perfiles{
						width: 500px;
					}
					.buscador-perfiles form{
						width: 100%;
					}
					.buscador-perfiles .form-busqueda-perfiles input.txtBuscar{
						background: none;
						font-size: 22px !important;
						color: #fff !important;
						font-weight: 500;
						border: none;
						border-bottom: 2px solid #fff;
						border-top: 2px solid #fff;
						border-left: 2px solid #fff;
						border-top-left-radius: 20px;
						border-bottom-left-radius: 20px;
						padding: 12px 20px;
						width: 70%;
						transition: .5s;
						position: relative;
					}
					.buscador-perfiles input.txtBuscar:before{
						content: '';
						position: absolute;
						width: 100%;
						height: 20px;
						background: #000;
						bottom: 0px;
						left: 0px;
					}
					input.txtBuscar::-webkit-input-placeholder{
						color: rgba(255,255,255,.5);
						transition: .2s;
					}
					input.txtBuscar:focus::-webkit-input-placeholder{
						font-size: 16px;
					}
					.buscador-perfiles .form-busqueda-perfiles input.btnBuscar{
						width: 30%;
						cursor: pointer;
						border-bottom: 2px solid #fff !important;
						border-top: 2px solid #fff !important;
						border-right: 2px solid #fff !important;
						border-top-right-radius: 20px;
						border-bottom-right-radius: 20px;
						font-size: 18px !important;
						color: #080808;
						transition: .5s;
					}
					.buscador-perfiles .form-busqueda-perfiles input.btnBuscar:hover{
						background: #080808;
						color: #fff;
					}
					/* Fin Agregando diseño de buscador pagina direccionador_perfiles.php EAM */
					.footerDP{
						width: 100%;
						background: linear-gradient(0deg,rgba(0,0,0,.8) 60%,transparent);
						padding: 30px 0px;
						margin-top: 370px;
						text-align: center;
						color: #fff;
					}
					.footerDP a{
						color: #882439 !important;
					}
					.footerDP a:hover{
						text-decoration: underline;
					}
					@media only screen and (max-width: 1074px) {
						.menu-icon{
							display: block !important;
						}
						.txt-btn-dp{
							font-size: 12px !important;
						}
						.content-tags h6{
							font-size: 10px;
						}
						.sidebarDP{
							height: 100% !important;
							top: 50px !important;
							overflow-y: scroll !important;
						}
						.parent a .tooltipDP{
							width: 100%;
							font-size: 10px;
						}
						.parent a:hover .tooltipDP{
							left: 0%;
						}
					}
					@media only screen and (max-width: 868px) {
						.primero h6.text-btn{
							font-size: 12px;
						}
					}

					@media only screen and (max-width: 748px) {
						.buscador-perfiles{
							width: 450px;
						}

					}
					@media only screen and (max-width: 580px) {
						.buscador-perfiles{
							width: 400px;
						}
						.buscador-perfiles .form-busqueda-perfiles input.txtBuscar{
							font-size: 18px !important;
						}
					}
					</style>
					<meta charset="utf-8">
					<meta name="description" content="" >
					<meta name="author" content="">
					<meta name="keywords" content="">
					<!--     <meta http-equiv="X-UA-Compatible" content="IE=edge">
				-->
				<!--Meta Responsive tag-->
				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

				<!--Favicon Icon-->
				<link rel="icon" href="favicon.ico" type="image/x-icon">
				<!--Bootstrap CSS-->
				<link rel="stylesheet" href="{{secure_asset('public/css/bootstrap.min.css')}}">
				<!--Custom style.css-->
				<!--  <link rel="stylesheet" href="style_direccionador/assets/css/quicksand.css"> -->
				<link rel="stylesheet" href="{{secure_asset('public/css/style.css')}}">
				<!--Font Awesome-->
				<link rel="stylesheet" href="{{secure_asset('public/css/font-awesome/css/font-awesome.min.css')}}">
				<link rel="stylesheet" href="{{secure_asset('public/css/fontawesome-all.min.css')}}">
				<link rel="stylesheet" href="{{secure_asset('public/css/nice-select.css')}}">
				<!--Nice select -->
				<link rel="stylesheet" href="{{secure_asset('public/login/css/alert_popup.css')}}">

				<!--iziToast -->
				<link rel="stylesheet" href="{{secure_asset('public/css/iziToast.min.css')}}">


				<title>CCP | Perfiles</title>
				<style>
				.confirmar, .denegar{
					color: #fff;
					border: none;
					cursor: pointer;
				}
				.confirmar:focus, .denegar:focus{
					outline: none;
				}
				</style>
			</head>
			<body class="cover" style="background-image: url({{secure_asset('public/style_direccionador/img/empresa2.jpg')}}); background-repeat: no-repeat; background-attachment: fixed;">
				<link rel="stylesheet" href="{{secure_asset('public/css/font-awesome/css/font-awesome.min.css')}}">
			  <link rel="stylesheet" href="{{secure_asset('public/css/fontawesome-all.min.css')}}">
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
				<div class="salir-form" style="background: rgba(255, 255, 255, 1); width: 100%; height: 100vh; position: fixed; z-index: 9999; top: 0px; display: none;">
					<div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%);">
						<div class="popup-mensaje popuperror animatepopup">
							<div style="padding: 10px 20px; background: #F13154;">
								<span style="display: block; color: #fff; text-align: center;">¿Estas seguro(a) que deseas salir?</span>
							</div>
							<div class="text-center mt-2" style="padding: 10px 20px;">
								<div class="d-flex justify-content-between">
									<button class="confirmar" style="width: 47%; display: block; background: #23E1AA; box-shadow: 0px 0px 5px rgba(35,225,170,.5);  padding: 10px 20px; border-radius: 10px;">CONFIRMAR</button>
									<button class="denegar" style="width: 47%; display: block; background: #FF3346; box-shadow: 0px 0px 5px rgba(255,51,70,.5); padding: 10px 20px; border-radius: 10px;">CANCELAR</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--Login Wrapper-->
				<div class="wraper">

					<!--Toggle sidebar-->
					<div class="col-sm-4 col-8 pl-1">
						<span class="menu-icon" onclick="toggle_sidebar()">
							<span id="sidebar-toggle-btn"></span>
						</span>
					</div>
					<!--Toggle sidebar-->

					<!--Main Content-->
					<div class="row">
						<!--Sidebar left-->
						<div class="col-xs-6 sidebar pl-0 sidebarDP">
							<div class="inner-sidebar">

								<!--Sidebar Navigation Menu-->
								<div class="sidebar-menu-container" >
									<ul class="sidebar-menu">



										@foreach ($usuarios as $key => $usuario)
											@if ($usuario->perfiles != null)
												<li class="parent">
													<form class="" action="{{route('admin.profiles_home')}}" method="post">
														@csrf
														<button  type="submit" class="" style="width:100%;background: #4b4b4b;padding: 0px;border: 0px;"  name="id" value="{{$usuario->idusuario}}" id="{{$usuario->idusuario}}">
															<a class="btn btn-outline-light">
																<img src="{{secure_asset('public/style_direccionador/'.$usuario->perfiles->direccion)}}" style="width: 30px; height: 25px;" align="center">
																<p class="tooltipDP" style="color:white;">{{$usuario->perfiles->perfil_nombre}}</p>
															</a>
														</button>
													</form>
												</li>
											@endif
										@endforeach
									</ul>
								</div>
								<!--Sidebar Naigation Menu-->
							</div>
						</div>
						<!--Sidebar left-->
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12 d-flex justify-content-center">
									<center>
										<br>
										<img class="imgDP" src="{{secure_asset('public/style_direccionador/img/grupo_panamotors_b.png')}}" style="width: 400px; height: auto">
										<br>
										<br>
									</center>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 center">
									<center>
										<div>
											@if (sizeof($usuarios) <= 3)

												@foreach ($usuarios as $key => $usuario)
													@if ($usuario->perfiles != null)
														<div id="primero" class="col-lg-4 col-md-4 col-sm-12 col-12 mb-3">
															<div>
																<form class="" action="{{route('admin.profiles_home')}}" method="post">
																	@csrf
																	<button type="submit" name="id" class="btn rol btn-theme btn-round btn-block shadow" value="{{$usuario->idusuario}}" id="{{$usuario->idusuario}}"> <img src="{{secure_asset('public/style_direccionador/'.$usuario->perfiles->direccion)}}" style="width: 50px; height: 50px;"> <br>{{$usuario->perfiles->perfil_nombre}}</button>
																</form>
																<div class="primero" style="background-color: black; opacity: 60%">
																	<img src="{{secure_asset('public/style_direccionador/'.$usuario->perfiles->direccion)}}" style="width: 70px; height: 70px;"> <br>
																	<h6 class="mb-4 text-white center" style="text-align: justify;">{{$usuario->perfiles->descripcion}}</h6>
																</div>
															</div>
														</div>
													@endif
												@endforeach
											@else
												<div class="row">
													<div class="col-sm-12 d-flex justify-content-center mb-4">
														<div class="buscador-perfiles">
															<div class="form-busqueda-perfiles d-flex justify-content-center">
																<input type="text" class="txtBuscar" id="busqueda" placeholder="Ingresa tu búsqueda" name="txtBuscar" onkeyup="enter();" value='{{old('busqueda')}}' required minlength="3"/>
																<input type="hidden" id="idempleados" value="{{$IdEmpleado}}" >
																<input type="submit" class="btnBuscar buscar" id="buscar" value="Buscar" name="btnBuscar" >
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-sm-4"></div>
													<div class="col-sm-4 justify-content-md-center">
														<div class="respuesta"></div>
														<div class="respuesta2"></div>
													</div>
													<div class="col-sm-4"></div>
												</div>
											@endif
										</div>
									</center>
								</div>
							</div>
							<footer class="text-white">
								<center>
									<br>
									<br>
									<div class="col-lg-2 col-md-2 col-sm-12 col-12 mb-1">
										<div >
											<div >
												<button type="button" class="btn sal btn-theme btn-round btn-block shadow" > <img src="{{secure_asset('public/style_direccionador/img/dep/iconosalir.png')}}" style="width: 50px; height: 50px;"> <br> <small class="bc-description text-white">  Salir </small> </button>
											</div>
										</div>

									</div>
								</center>
							</footer>
						</div>
					</div>



					<div class="footerDP">
						Copyright© 2018-2021 Panamotors Center S.A de C.V. Todos los Derechos Reservados |
						<a target="_blank" href="docs/aviso_privacidad.pdf">Política de Privacidad</a>
					</div>
				</div>

				<script src="{{secure_asset('public/js/jquery-3.1.1.min.js')}}"></script>
				<script>
				$(document).ready(function(){
					$(".sal").click(function(){
						$(".salir-form").fadeIn();
						$(".confirmar").click(function(){
							document.location.replace(
								'{{route('logout')}}'
							);
							return false;
						});
						$(".denegar").click(function(){
							$(".salir-form").fadeOut();
						});
					});
				});


				</script>



				<script type="text/javascript">

				function enter(evt){
					if (window.event){
						keynum = event.keyCode;
					} else {
						keynum = evt.which;
					}
					if(keynum == 13 ){
						event.preventDefault();

						var busqueda = $("#busqueda").val();

						busqueda = busqueda.trim()

						if (busqueda.length >=3) {

							console.log(busqueda);
							console.log(idempleados);

							getBotonesPerfiles(busqueda);
							// $.ajax({
							// 	url : '{{route('admin.profiles.buscar')}}',
							// 	data : { busqueda:busqueda },
							// 	type : 'POST',
							//
							// 	beforeSend: function () {
							// 		$(".respuesta").html('<center><i class="fas fa-spinner fa-pulse fa-5x" style="color:red;"></i></center>');                      
							// 	},
							// 	success : function(json2) {
							// 		$(".respuesta").html(json2);
							// 		console.log(json2);
							// 	},
							// 	error : function(xhr, status) {
							// 		// alert('Disculpe, existió un problema');
							// 		$(".error-form").show();
							// 		$(".text-error").html("Disculpe, existió un problema");
							//
							// 		setTimeout(function(){
							// 			$(".error-form").fadeOut(1000);
							// 		}, 1500);
							// 	}
							// });

							$(".otrarespuesta").empty();

							// $.ajax({
							// 	url : 'buscar_sug.php',
							// 	data : { busqueda:busqueda },
							// 	type : 'POST',
							//
							// 	beforeSend: function () {
							// 		$(".otrarespuesta").html('<center><i class="fas fa-spinner fa-pulse fa-5x" style="color:red;"></i></center>');                      
							// 	},
							// 	success : function(json2) {
							// 		$(".otrarespuesta").html(json2);
							// 		console.log(json2);
							// 	},
							// 	error : function(xhr, status) {
							// 		// alert('Disculpe, existió un problema');
							// 		$(".error-form").show();
							// 		$(".text-error").html("Disculpe, existió un problema");
							//
							// 		setTimeout(function(){
							// 			$(".error-form").fadeOut(1000);
							// 		}, 1500);
							// 	}
							// });

							return false;
						} else{
							// alert("Tu busqueda debe tener al menos tres caracteres")
							$(".error-form").show();
							$(".text-error").html("Tu búsqueda debe tener al menos tres caracteres");

							setTimeout(function(){
								$(".error-form").fadeOut(1000);
							}, 1500);
						}
					}
				}
				$(document).ready(function() {


					$(".buscar").click(function(){
						var busqueda = $("#busqueda").val();
						busqueda = busqueda.trim()

						if (busqueda.length >=3) {
							console.log('Busqueda 1');
							// console.log(busqueda);
							// console.log(idempleados);
							$(".otrarespuesta").empty();
							$(".respuesta").empty();
							getBotonesPerfiles(busqueda);
							// $.ajax({
							// 	url : '{{route('admin.profiles.buscar')}}',
							// 	headers: {
							// 		"Content-Type": "application/json",
							// 		"Accept": "application/json",
							// 		"X-Requested-With": "XMLHttpRequest",
							// 		"X-CSRF-Token": '{{csrf_token()}}',
							// 	},
							// 	data : { busqueda:busqueda },
							// 	type : 'POST',
							//
							// 	beforeSend: function () {
							// 		$(".respuesta").html('<center><i class="fas fa-spinner fa-pulse fa-5x" style="color:red;"></i></center>');                      
							// 	},
							// 	success : function(json2) {
							// 		$(".respuesta").html(json2);
							// 		console.log(json2);
							// 	},
							// 	error : function(xhr, status) {
							// 		// alert('Disculpe, existió un problema');
							// 		$(".error-form").show();
							// 		$(".text-error").html("Disculpe, existió un problema");
							//
							// 		setTimeout(function(){
							// 			$(".error-form").fadeOut(1000);
							// 		}, 1500);
							// 	}
							// });
						} else{
							// alert("Tu busqueda debe tener al menos tres caracteres")
							$(".error-form").show();
							$(".text-error").html("Tu búsqueda debe tener al menos tres caracteres");

							setTimeout(function(){
								$(".error-form").fadeOut(1000);
							}, 1500);
						}
					});

				});
				</script>
				<!--Page Wrapper-->

				<script type="text/javascript">
				$(document).ready(function() {
					$(".buscar").click(function(){
						var busqueda = $("#busqueda").val();

						busqueda = busqueda.trim()

						if (busqueda.length >=3) {

							console.log('................',busqueda);
							// console.log(idempleados);

							$(".otrarespuesta").empty();
							fetch("{{route('admin.profiles.buscar')}}", {
								headers: {
									"Content-Type": "application/json",
									"Accept": "application/json",
									"X-Requested-With": "XMLHttpRequest",
									"X-CSRF-Token": '{{csrf_token()}}',
								},
								method: "post",
								credentials: "same-origin",
								body: JSON.stringify({
									bus : busqueda
								})
							}).then(res => res.json())
							.catch(function(error){
								console.error('Error:', error);
								// $("#respuestaVIN").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
								// $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
							})
							.then(function(response){
								$(".otrarespuesta").html('<center><i class="fas fa-spinner fa-pulse fa-5x" style="color:red;"></i></center>');                      
								console.log(response);
								$(".otrarespuesta").html(response);
							});
							// $.ajax({
							// 	url : '{{route('admin.profiles.buscar')}}',
							// 	headers: {
							// 		"Content-Type": "application/json",
							// 		"Accept": "application/json",
							// 		"X-Requested-With": "XMLHttpRequest",
							// 		"X-CSRF-Token": '{{csrf_token()}}',
							// 	},
							// 	data : { busqueda:busqueda },
							// 	type : 'POST',
							//
							// 	beforeSend: function () {
							// 		 $(".otrarespuesta").html('<center><i class="fas fa-spinner fa-pulse fa-5x" style="color:red;"></i></center>');                      
							// 	},
							// 	success : function(json2) {
							// 		$(".otrarespuesta").html(json2);
							// 		console.log(json2);
							// 	},
							// 	error : function(xhr, status) {
							// 		// alert('Disculpe, existió un problema');
							// 		$(".error-form").show();
							// 		$(".text-error").html("Disculpe, existió un problema");
							//
							// 		setTimeout(function(){
							// 			$(".error-form").fadeOut(1000);
							// 		}, 1500);
							// 	}
							// });
						}
					});

				});
				function getBotonesPerfiles(busqueda){
					fetch("{{route('admin.profiles.buscar')}}", {
						headers: {
							"Content-Type": "application/json",
							"Accept": "application/json",
							"X-Requested-With": "XMLHttpRequest",
							"X-CSRF-Token": '{{csrf_token()}}',
						},
						method: "post",
						credentials: "same-origin",
						body: JSON.stringify({
							bus : busqueda
						})
					}).then(res => res.json())
					.catch(function(error){
						console.error('Error:', error);
						// $("#respuestaVIN").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
						// $("#respuesta_referecia_venta").html('<i class="fas fa-times-circle" style="color: red;">Error</i>');
					})
					.then(function(response){
						$(".respuesta").html('<center><i class="fas fa-spinner fa-pulse fa-5x" style="color:red;"></i></center>');                      
						console.log(response);

						$(".respuesta").html(response.profiles);
						$(".respuesta2").html(response.tags);
						// $(".respuesta").html(response.tags);
					});
				}
				</script>

				<!-- Page JavaScript Files-->
				<script src="{{secure_asset('public/js/jquery.min.js')}}"></script>
				<script src="{{secure_asset('public/js/jquery-1.12.4.min.js')}}"></script>
				<!--Popper JS-->
				<script src="{{secure_asset('public/js/popper.min.js')}}"></script>
				<!--Bootstrap-->
				<script src="{{secure_asset('public/js/bootstrap.min.js')}}"></script>
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
				<!--Custom Js Script-->
				<script>
				//Nice select
				$('.bulk-actions').niceSelect();
				</script>

				@if (session('error'))
					<script type="text/javascript">
					var Error_Laravel = '{{ session('error') }}';
					console.error('Error :( ',Error_Laravel);
					iziToast.error({
						title: Error_Laravel,
					});
					</script>
				@endif

				@if (session('success'))
					<script type="text/javascript">
					var Success_Laravel = '{{ session('success') }}';
					console.log('success :) ',Success_Laravel);
					iziToast.success({
						title: Success_Laravel,
					});
					</script>
				@endif
			</body>
			</html>
