<!DOCTYPE HTML>
<html>
<head>
	<title>Error 404 Not Found</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="57x57" href="../../img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../../img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../../img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../../img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../../img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../../img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../../img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../../img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../../img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="../../img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../../img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../../img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../../img/favicon/favicon-16x16.png">
	<link rel="manifest" href="../../img/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="../../img/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<style>
		@import url("https://fonts.googleapis.com/css?family=Scope+One|Trocchi");
		@import url("https://fonts.googleapis.com/css2?family=Hind:wght@400;500;600;700&display=swap");
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		body{
			font-family: "Hind", sans-serif;
		}

		#banner {
			background: url("{{asset('public/img/errors/404fondo.webp')}}");
			background-position: center;
			background-size: cover;
			background-repeat: no-repeat;
			min-height: 100vh;
			height: 100vh !important;
			position: relative;
			text-align: center;
			overflow: hidden;
		}
		.content-img-logo{
		}
		.content-img-logo img{
			width: 300px;
		}

		.img-llanta{
			width: 370px;
			animation: animatellanta 1s linear infinite;
		}
		@keyframes animatellanta{
			0%{
				transform: rotate(0deg);
				}100%{
					transform: rotate(365deg);
				}
			}
			.btnnot{
				text-decoration: none;
				display: block;
				width: 230px;
				height: 60px;
				margin: auto;
				background: linear-gradient(45deg,#882439,#d43759);
				border-radius: 5px;
				box-shadow: 0px 0px 20px rgba(237, 56, 94, .5);
				text-align: center;
				line-height: 60px;
				font-size: 24px;
				color: #fff;
				text-transform: uppercase;
				position: relative;
				z-index: 1;
			}
			.btnnot:hover{
				color: #fff;
			}
			.btnnot:before{
				content: '';
				position: absolute;
				top: 30px;
				left: 30px;
				right: 30px;
				bottom: 30px;
				visibility: hidden;
				background: linear-gradient(45deg,#d43759,#882439);
				border-radius: 5px;
				transition: .3s;
				z-index: -1;
			}
			.btnnot:hover:before{
				top: 10px;
				left: 10px;
				bottom: 10px;
				right: 10px;
				visibility: visible;
				border-radius: 0px;
			}
			.content-imgllanta{
				position: relative;
			}
			.content-imgllanta:before{
				content: '';
				position: absolute;
				width: 100%;
				height: 60px;
				background: rgba(0,0,0,1);
				bottom: -10px;
				box-shadow: 0px 0px 30px rgba(0,0,0,.5);
				border-radius: 50%;
			}
			.content-imgnumero{
				position: relative;
			}
			.content-imgnumero img{
				position: relative;
				width: 250px;
			}
			.text-not{
				color: #212121;
				font-size: 100px;
				font-weight: bold;
			}
			#footer{
				background: #E6E6E6;
				padding: 20px;
				text-align: center;
				font-weight: 600;
			}
			@media (max-width: 1200px){
				.content-imgnumero img{
					width: 240px;
				}
				.img-llanta{
					width: 340px;
				}
				.text-not{
					font-size: 90px;
				}
			}
			@media (max-width: 991px){
				.content-imgnumero img{
					width: 220px;
				}
				.img-llanta{
					width: 320px;
				}
				.text-not{
					font-size: 80px;
				}
			}
			@media (max-width: 767px){
				.content-imgnumero img{
					width: 160px;
				}
				.img-llanta{
					width: 260px;
				}
				.text-not{
					font-size: 60px;
					margin-top: 20px;
				}
			}
			@media (max-width: 575px){
				.content-imgnumero img{
					width: 140px;
				}
				.img-llanta{
					width: 210px;
				}
				.text-not{
					font-size: 50px;
					margin-top: 20px;
				}
			}
			@media (max-width: 480px){
				.content-img-logo img{
					width: 200px;
				}
				.content-imgnumero img{
					width: 120px;
				}
				.img-llanta{
					width: 170px;
				}
				.content-imgllanta:before{
					height: 40px;
				}
				.text-not{
					font-size: 40px;
				}
			}
			@media (max-width: 380px){
				.content-imgnumero img{
					width: 80px;
				}
				.img-llanta{
					width: 130px;
				}
				.text-not{
					font-size: 32px;
				}
			}
		</style>
	</head>
	<body>

		<section id="banner">
			<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);">
				<div class="content-img-logo">
					<img src="{{asset('public/img/errors/GRUPOPANAMOTORS.png')}}">
				</div>
				<div>
					<div style="display: flex;">
						<div class="content-imgnumero">
							<img src="{{asset('public/img/errors/404numero.webp')}}" alt="">
						</div>
						<div class="content-imgllanta">
							<img src="{{asset('public/img/errors/404llanta.webp')}}" alt="" class="img-llanta">
						</div>
						<div class="content-imgnumero">
							<img src="{{asset('public/img/errors/404numero.webp')}}" alt="">
						</div>
					</div>
				</div>
				<div>
					<h1 class="text-not">PAGE NOT FOUND</h1>
				</div>
				<div>
					<a href="https://www.panamotorscenter.com" class="btnnot">Ir</a>
				</div>
			</div>
		</section>
		<footer id="footer">
			<div class="copyright">
				<p>Copyright© 2020 Panamotors Center S.A DE C.V. Todos los Derechos Reservados</p>
			</div>
		</footer>
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/skel/3.0.1/skel.min.js"></script>
	</body>
	</html>
