<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Comprobante de Egreso</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        .content-formato-pdf{
            width: 800px;
            margin: auto;
        }
        .header, .footer{
            width: 100%;
        }
        .header img, .footer img{
            width: 100%;
        }
        .datos-personales, .content-tablas, .dato-user-impresion{
            margin-top: 30px;
        }
        .content-dato{
            width: 100px;
        }
        .content-dato h6{
            text-align: right;
            font-weight: bold;
        }
        .content-dato-base{
            margin-left: 10px;
        }
        .content-dato-base h6{
            color: #616161;
        }
        .tabla-1{
            width: 100%;
            border: 2px solid #cdcdcd;
        }
        .tabla-1 tr td{
            padding: 10px;
        }
        .tabla-1 tr:nth-child(even){
            background: #F3F3F3;
        }
        .dato-user-impresion p{
            font-weight: bold;
        }
        .dato-user-impresion span{
            font-weight: normal;
            color: #616161;
        }
        .leyenda{
            text-align: center;
            color: #836C71;
            margin-top: 80px;
        }
        @media (max-width: 767px){
            .content-formato-pdf{
                width: 100%;
            }
            .content-center-flex{
                display: flex;
                justify-content: center;
            }
            .content-datos-adicional{
                margin-top: 30px;
            }
            .content-tablas, .dato-user-impresion, .content-leyenda-qr{
                padding: 0px 10px;
            }
        }
        @media (max-width: 575px){
            .content-dato h6, .content-dato-base h6, .content-datos-adicional h6, .dato-user-impresion p, .leyenda{
                font-size: 12px;
            }
            .tabla-1 tbody tr td{
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="content-formato-pdf">
        <picture class="header">
            <img src="{{asset('public/img/mpdf/head_recibo.png')}}" alt="">
        </picture>
        <div class="datos-personales">
            <div class="row m-0">
                <div class="col-md-6 content-center-flex p-0">
                    <div>
                        <div class="d-flex">
                            <div class="content-dato">
                                <h6>Transferencia realizada por: </h6>
                            </div>
                            <div class="content-dato-base">
                                <h6>@if(!empty($proveedor->idproveedores)){{$proveedor->idproveedores}}@else
                                   {{"Sin ID"}}@endif</h6>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="content-dato">
                                <h6>Efectivo: </h6>
                            </div>
                            <div class="content-dato-base">
                                <h6>@if(!empty($proveedor->estado)){{$proveedor->estado}}@else{{"N/A"}}@endif</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="content-datos-adicional content-center-flex">
                        <div>
                            <div class="d-flex">
                                <div class="content-dato">
                                    <h6>Fecha: </h6>
                                </div>
                                <div class="content-dato-base">
                                    <h6>@if(!empty($fecha_recibo_encabezado)){{$fecha_recibo_encabezado}}@else{{"Sin fecha"}}@endif</h6>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="content-dato">
                                    <h6>Recibo: </h6>
                                </div>
                                <div class="content-dato-base">
                                    <h6>@if(!empty($id_generic_voucher)){{$id_generic_voucher}}@else{{"Sin ID"}}@endif</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-tablas">
            <div class="table-responsive">
                <table class="tabla-1 table">
                    <tr>
                        <td style="width: 33%; background: #ECECEC;"><b>Movimiento</b></td>
                        <td style="width: 33%; background: #ECECEC;"><b>Forma de pago</b></td>
                        <td style="width: 33%; background: #ECECEC;"><b>Tipo de cambio</b></td>
                    </tr>
                    <tr>
                        <td>@if(!empty($recibo->concepto)){{$recibo->concepto}}@else{{"Sin concepto"}} @endif</td>
                        <td>@if(!empty($metodo_pago)){{$metodo_pago->nombre}}@else{{"Sin registro"}}@endif</td>
                        <td>@if(!empty($recibo->tipo_cambio)){{$recibo->tipo_cambio}}@else{{"Sin tipo de cambio"}}@endif</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="content-tablas">
            <div class="table-responsive">
                <table class="tabla-1 table">
                    <tr>
                        <td style="width: 20%;">TOTAL: </td>
                        <td style="width: 80%;">$@if(!empty($total)){{$total}}@else{{"0.00"}}@endif</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>@if(!empty($total_text)){{$total_text}}@else{{"CERO PESOS 00/100 M.N"}}@endif</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="dato-user-impresion">
            <p>Recibido por: <span>@if(!empty($nombre_usuario)){{$nombre_usuario}}@else{{"Sin receptor"}}@endif</span></p>
            <p>Fecha impresión: <span>@if(!empty($string_fecha)){{$string_fecha}}@else{{'Error al obtener fecha'}}@endif</span></p>
        </div>
        <div class="content-leyenda-qr d-flex">
            <div style="width: 80%;">
                <p class="leyenda" style="width: 100%;">El presente recibo no es válido si los datos desplegados con la lectura del QR son diferentes al impreso. Valide la información y asegúrese de recibir un comprobante válido.</p>
            </div>
            <div class="d-flex justify-content-end" style="width: 20%;">
                <!-- <img src="../../Codigos_qr_recibos/codigoqr2.png" style="width: 100px; height: 100px;"> -->
                {{----!!$newqrcode_explode[1] !!---}}
            </div>
        </div>
        <picture class="footer">
            <!-- <img src="../../img/estado-cuenta-panamotors/footer2.png" alt=""> -->
            <img src="{{asset('public/img/mpdf/footer.png')}}" class="img_footer" alt="">
        </picture>
    </div>
</body>
</html>
