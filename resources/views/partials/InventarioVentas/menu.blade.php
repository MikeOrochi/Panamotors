<style>
	.sugerencias a {
		color: white;
	}

	.resultadoBusqueda {
		color: white;
	}

	.sugerencias:hover {
		background-color: #B6B5B5;
		cursor: default;
	}

	#contenedor-busqueda {
		position: absolute;
		left: 50%;
		transform: translateX(-50%);
		background: rgb(47, 47, 47);
		width: 70%;
		bottom: 0;
		z-index: 1000;
	}

	#resultadoBusqueda {
		border: 0px outset gray;
		background-color: rgb(47, 47, 47);
		text-align: center;
		position: absolute;
		width: 100%;
		left: 50%;
		transform: translateX(-50%);
	}

	.buscar1 {
		-webkit-appearance: none;
		width: 0px;
		height: 38px;
		border-radius: 50%;
		opacity: 0;
		transition: .5s;
	}

	.mSearch {
		width: 100%;
		opacity: 1;
		border-radius: 10px;
		border: 2px solid #ced4da;

	}

	.mSearch:focus {
		border: 2px solid #555;
	}

</style>

<!--Header-->


<div class="row header shadow-sm" style="margin:0px;">

	<!--Logo-->
	<div class="col-sm-3 pl-0 text-center header-logo" style="display: flex;">
		<div style="width: 50%;">
			<div class="bg-theme pt-3 pb-2 mb-0">
				<h3 class="logo">
					<a href="#" class="text-secondary logo">
						<img src="{{secure_asset('public/img/logo_gran_pana.png')}}" alt="" style="width: 80px;height: 80px;display: inline;">
						<br>
						CCP
					</a>
				</h3>
			</div>
		</div>
		<div class="mr-3" style="width: 50%; background: #333;">
			<div class="avatar text-center">
				@php
	 				use App\Http\Controllers\Admin\AdminController;
					$usuario = AdminController::DatosUsuario();
				@endphp

				<img src="{{secure_asset('public/'.substr($usuario->foto_perfil, 6))}}" alt="" class="rounded-circle" />
				<p>{{$usuario->usuario}}</p>
				<span class=" small" style="color:white;"><strong>{{$usuario->nombre_usuario}}</strong></span>

			</div>
		</div>
	</div>
	<!--Fin Logo-->

	<!--Header Menu-->
	<div class="col-sm-9 header-menu pt-2 pb-0 pr-0 pl-0">
		<div class="row" style="margin: 0;padding: 0;">

			<!--Menu Icons-->
			<div class="pl-0 pr-0 col-12 col-sm-4 col-md-4 col-lg-2">
				<!--Toggle sidebar-->
				<span class="menu-icon" onclick="toggle_sidebar()">
					<span id="sidebar-toggle-btn"></span>
				</span>
				<!--Toggle sidebar-->
				<!--Notification icon-->
				<div class="menu-icon">
					<a class="" href="#" onclick="toggle_dropdown(this); return false" role="button" class="dropdown-toggle">
						<i class="fa fa-bell"></i>
						<span class="badge" id="Notificaciones">0</span>
					</a>
					<div class="dropdown dropdown-left bg-white shadow border">
						<a class="dropdown-item" href="#"><strong>Notificaciones</strong></a>
						<div class="dropdown-divider"></div>
						<!--
							<a class="dropdown-item text-center link-all" href="#">Ver Notificaciones</a>
						-->
						<div id="MisNotificaciones">

						</div>
					</div>
				</div>
				<!--Notication icon-->

				<!--Inbox icon-->
				<span class="menu-icon inbox">
					<a class="" href="#" role="button" id="dropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

						<?php
						$tiempo_restante = 2881;
						if ($tiempo_restante <= 2880): ?>
						<i class="fas fa-key fa-2x"></i>
						<span class="badge badge-danger">1</span>
					<?php else: ?>
						<i class="fas fa-key"></i>
						<span class="badge" id="num-notification-password">0</span>
					<?php endif ?>
				</a>
				<div class="dropdown-menu dropdown-menu-left mt-10 animated zoomInDown" aria-labelledby="dropdownMenuLink3" style="width:auto;">
					<a class="dropdown-item" href="#"><strong>Key Acces</strong></a>

					<div class="dropdown-divider"></div>
					<?php// if ($tiempo_restante <= 2880): ?>
						<a href="{{route('change_password_automatic.changePassword')}}" class="dropdown-item" id="notification-password">
							<div class="media">
								<i class="fas fa-key fa-4x"></i>
								<div class="media-body" id="body-notification-password">

								</div>
							</div>
						</a>
						<?php //endif ?>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item text-center link-all" href="{{route('change_password_automatic.changePassword')}}">Actualizar Contraseña</a>
					</div>
				</span>
				<!--Inbox icon-->
				<span class="menu-icon">
					<i class="fa fa-th-large"></i>
				</span>


			</div>
			<!--Menu Icons-->


			<!--Search box and avatar-->
			<!-- <div class="flex-header-menu justify-content-end col-12 col-sm-8 col-md-8 col-lg-10 pt-1">
					<div class="" style="width:25%;">
						<select class="js-example-basic-single" style="width: 100%;">
							<option value="contactos" selected>Contactos</option>
							<option value="carros">VIN</option>
						</select>
					</div>
					<div class=""  style="width:75%;">
						<select class="js-example-basic-single form-control buscar1 mSearch" style="width: 100%;"></select>
						<div class="IconoBuscador">
								<i class="fas fa-search" id="btnSearch"></i>
						</div>
					</div>
			</div> -->
			<!--Search box and avatar-->
		</div>
		<!--    <center>
    	<div id="resultadoBusqueda" style="z-index:3; opacity:1;"></div>
    </center>  -->
		<div class="text-center">
			<h5 class="mt-3 mb-3">
				<strong>
					@yield('titulo')
				</strong>
			</h5>
		</div>

	</div>

	<!--Header Menu-->
</div>
<!--Header-->


<!--Main Content-->

<div class="row main-content" style="margin:0px;">
	<!--Sidebar left-->
	<div class="col-sm-3 col-xs-6 sidebar pl-0">
		<div class="inner-sidebar mr-3">
			<!--Image Avatar-->

			<!--Image Avatar-->

			<!--Sidebar Navigation Menu-->

			<div class="sidebar-menu-container">
				<ul class="sidebar-menu mb-4">

					<li class="parent">
						<a href="{{route('Inv_Ventas.index')}}" class=""><i class="fas fa-home mr-3"></i>
							<span class="none">Dashboard Ventas </span>
						</a>
					</li>

					<li class="parent">
						<a href="{{route('Inv_Ventas.check',['Todas','0'])}}" class=""><i class="fas fa-home mr-3"></i>
							<span class="none">Inventario Unidades </span>
						</a>
					</li>

					<li class="parent">
						<a href="{{route('Inv_Ventas_Trucks.check',['Todas','1'])}}" class=""><i class="fas fa-home mr-3"></i>
							<span class="none">Inventario Tractocamiones</span>
						</a>
					</li>


					<li class="parent">
						<a href="{{route('admin.profiles')}}" class=""><i class="fas fa-exchange-alt mr-3"></i>
							<span class="none">Cambiar de módulo </span>
						</a>
					</li>

					<li class="parent">
						<a href="{{route('logout')}}" class=""><i class="fas fa-door-open mr-3"></i>
							<span class="none">Salir</span>
						</a>
					</li>
					</li>
				</ul>
			</div>
			<!--Sidebar Naigation Menu-->
		</div>
	</div>





	<!--Sidebar left-->
	<script type="text/javascript">

	let input_select_search = null;
	var Temporizador;
	var BusquedaAnterior = null;
	var SelectVacio = true;

	$( document ).ready(function() {



		$('#search_contacts_cars').select2({
	    language: {
	      "noResults": function(){
					SelectVacio = true;
	        return "Sin resultados";
	       }
	    },
	    placeholder: "Buscar",
	  });

		$('#btnSearch').click(function(){
			$('#search_contacts_cars').select2('open');
		});

		$('#search_contacts_cars').on('select2:open', function (e) {


      if(input_select_search == null){

        input_select_search = document.querySelector('.select2-search__field');
        input_select_search.addEventListener('input', updateValueSearch);

        function updateValueSearch(e) {

					clearTimeout(Temporizador);
					var palabra = e.target.value.trim();

					if( (BusquedaAnterior != palabra && palabra != '') && SelectVacio){


						document.getElementById('btnSearch').classList.add('fa-spin');
						document.getElementById('btnSearch').classList.remove('fa-search');
						document.getElementById('btnSearch').classList.add('fa-spinner');
						$('.IconoBuscador').css('background','#4b4b4b');

						BusquedaAnterior = palabra;
						Temporizador = setTimeout(function(){
							RealizarBusqueda(palabra,input_select_search);
						}, 300);
					}

        }
      }
  	});

		$('#search_contacts_cars').on('select2:select', function (e) {
			let Busc = e.target.value;
			if(Busc != "" && Busc != null){
				var textoSelect = $("#buscador option:selected").val();
				if (textoSelect == "contactos") {
						window.location.href = 'https://www.dualtrucks.com/Des/CCDT/Perfiles2/CCP/cartera/proveedor/detalles/'+Busc;
				}else if (textoSelect == "carros") {
					window.location.href = 'https://www.dualtrucks.com/Des/CCDT/Perfiles2/CCP/cartera/proveedor/estado_cuenta/'+Busc;
				}

			}

	  });

	});


		function RealizarBusqueda(textoBusqueda,input) {

			$('.IconoBuscador').css('color','#92beff');
			SelectVacio = false;
			//console.log('Haciendo consulta',textoBusqueda);

			var textoSelect = $("#buscador option:selected").val();

			fetch("{{route('admin.search')}}", {
					headers: {
						"Content-Type": "application/json",
						"Accept": "application/json",
						"X-Requested-With": "XMLHttpRequest",
						"X-CSRF-Token": '{{csrf_token()}}',
					},
					method: "post",
					credentials: "same-origin",
					body: JSON.stringify({
						Buscar: textoBusqueda,
						Tipo: textoSelect
					})
				}).then(res => res.json())
				.catch(function(error) {
					console.error(error);

					document.getElementById('btnSearch').classList.remove('fa-spin');
					document.getElementById('btnSearch').classList.remove('fa-spinner');
					document.getElementById('btnSearch').classList.add('fa-search');
					$('.IconoBuscador').css('background','#bf1919');
					$('.IconoBuscador').css('color','black');

				})
				.then(function(response) {

					//console.log(response);
					$('.IconoBuscador').css('background','#bf1919');
					$('.IconoBuscador').css('color','white');
					$('#search_contacts_cars').empty();


					if (textoSelect == "contactos") {
						document.getElementById("search_contacts_cars").innerHTML += "<option value=''>Seleccione una opción</option>";
						response.forEach(function logArrayElements(element, index, array) {
							document.getElementById("search_contacts_cars").innerHTML += "<option value="+element.idproveedores+">"+element.col2+' '+element.idproveedores+' '+element.nombre+' '+element.apellidos +"</option>";
						});
					}else if (textoSelect == "carros") {
						document.getElementById("search_contacts_cars").innerHTML += "<option value=''>Seleccione una opción</option>";
						response.forEach(function logArrayElements(element, index, array) {
							document.getElementById("search_contacts_cars").innerHTML += "<option value="+element.Proveedor.idproveedores+"><b>("
							+element.ECP.datos_vin+")</b> "+element.ECP.datos_marca+" "+element.ECP.datos_version+" "
							+element.ECP.datos_modelo+" "+element.ECP.datos_color+" "
							+"<em>"+element.ECP.idcontacto+" "+element.Proveedor.nombre+" "+element.Proveedor.nombre+"</em></option>";
						});
					}

					if(response.length > 0){
						SelectVacio = false;
					}else{
						SelectVacio = true;
					}



					input.dispatchEvent(new Event('input'));

					document.getElementById('btnSearch').classList.remove('fa-spin');
					document.getElementById('btnSearch').classList.remove('fa-spinner');
					document.getElementById('btnSearch').classList.add('fa-search');



				});


			/*
			$("#resultadoBusqueda").html('');
			if (textoBusqueda != "") {
				$.post("buscar_orden_universal.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
					$("#resultadoBusqueda").html(mensaje);
					$("#contenedor-busqueda").show();
					$("#resultadoBusqueda").show();
				});
			} else {
				$("#resultadoBusqueda").html('');
				$("#contenedor-busqueda").hide();
				$("#resultadoBusqueda").hide();
				$("#busqueda").val("");
			};

			$(document).on("click",function(e) {
				var container = $("#contenedor-busqueda");

				if (!container.is(e.target) && container.has(e.target).length === 0) {
					container.hide();
					$("#busqueda").val("");
					$("#resultadoBusqueda").html('');
				}
			});*/
		};
	</script>

	<style>
		/*a:hover {
        color:#2196f3;
        font-size: 15px;
        cursor: pointer;
        }*/
		.c-datos a:hover i {
			color: #2196f3;
		}


		.tooltip-inner {
			background-color: #882439;
			color: white;
		}

		.tooltip.bs-tooltip-right .arrow:before {
			border-right-color: #882439 !important;
			color: white;
		}

		.tooltip.bs-tooltip-left .arrow:before {
			border-right-color: #882439 !important;
			color: white;
		}

		.tooltip.bs-tooltip-bottom .arrow:before {
			border-right-color: #882439 !important;
			color: white;
		}

		.tooltip.bs-tooltip-top .arrow:before {
			border-right-color: #882439 !important;
			color: white;
		}
	</style>
