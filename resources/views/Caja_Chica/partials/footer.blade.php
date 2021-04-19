<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<style>
	.footer{
		width: 100%;
		margin-top: 40px;
		background: #000000;
		text-align: center;
		padding: 40px;
		position: relative;
	}
	.footer:before, .footer:after{
		content: '';
		position: absolute;
		width: 20%;
		height: 1px;
		background: #c3c7cc;
		top: 50%;
		transform: translateY(-50%);
	}
	.footer:before{
		left: 0;
	}
	.footer:after{
		right: 0;
	}
	.footer p{
		color: #fff;
	}
	.footer a{
		color: #882439;
	}
	.footer a:hover{
		text-decoration: underline;
	}

	@media only screen and (max-width: 1074px){
		.footer:before, .footer:after{
			width: 20%;
		}
	}
	@media only screen and (max-width: 906px) {
        .footer:before, .footer:after{
			width: 20%;
		}
	}

    @media only screen and (max-width: 868px) {
		.footer:before, .footer:after{
			width: 15%;
		}
    }

    @media only screen and (max-width: 748px) {
		.footer:before, .footer:after{
			width: 10%;
		}
    }

	@media only screen and (max-width: 580px) {
		.footer:before, .footer:after{
			width: 5%;
		}
	}

</style>
<div class="respuestas_me"></div>
<footer class="footer">
	<p>Copyright© 2018-2021 Panamotors Center, S.A. de C.V.
		<br>
		Todos los Derechos Reservados |
		<a target="_blank" href="../../docs/aviso_privacidad.pdf">Política de Privacidad</a>
	</p>
</footer>

<input type="hidden" class="empleado" value="******">

<script type="text/javascript">
	$(document).ready(function() {
		/*
		function doSomething() {
			var idrece = $(".empleado").val();

			$.post('../consulta_registros_mensajes.php', {idempleador_receptor: idrece}, function(data4) {
				$(".respuestas_me").html(data4);
			});
		}
		setInterval(doSomething,20000);
		*/
	});
</script>
