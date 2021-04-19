<?php

namespace App\Http\Controllers\TallerTracktocamiones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Models\SolicitudTallerTrucksHistorial;
use App\Models\LiberarSolicitudTallerTrucks;
use App\Models\SolicitudTallerTrucks;
use App\Models\inventario_trucks;
use App\Models\inventario;
use App\Models\empleados;

class SalidasTallerTracktoController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  public function index(){
    // return 'hola';
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','AN289035','International','Pro star','','Gris','Validacion','0.30', 'Ajuste de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('19-03-2021'), '00/00/0000', '','Asignado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','CN544282','International','Pro star','','Blanco','Validacion','0.50%', 'Reparacion de turbos', 0,'', '', 0, '', \Carbon\Carbon::parse('19-03-2021'), '00-00-0000', '','Asignado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','5473065','Kenworth','Volteo','','Rojo','Validacion','0.40%', 'Reparacion de inyectores, bomba y diferenciales', 0,'', '', 0, '', \Carbon\Carbon::parse('19-03-2021'), '00-00-0000', '','Asignado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','CSBC5224','Freightliner','Cascadia','','Verde','3','0.50%', 'Conversión de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','DLBT9513  ','Freightliner','Cascadia','','Café','1','0.60%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Entregado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','AN289722','International','Pro star','','Blanco','Validacion','0.10%', 'Reemplazo de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('16-03-2021'), '00-00-0000', '','Asignado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','DJ352110','Kenworth','T680','','Blanco','Validacion','0.40%', 'Reemplazo de cilindros de clutch', 0,'', '', 0, '', \Carbon\Carbon::parse('16-03-2021'), '00-00-0000', '','Asignado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','DJ29251','International','Pro star','','Blanco','Validacion','0.30%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('16-03-2021'), '00-00-0000', '','Asignado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','AN008643','Mack','','','Blanco','Validacion','0.20%', 'Media de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('16-03-2021'), '00-00-0000', '','Pendiente', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','CJ954419','Kenworth','T700','','Blanco','2','0.40%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Alejandro Sánchez López');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','GDHD0921','Freightliner','Cascadia day cab','','Azul','Validacion','0.50%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','FSFU4972','Freightliner','Cascadia','','Azul','Validacion','0.50%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Pendiente', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Alejandro Sánchez López');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','AD103602','Peterbill','387','','Rojo','Validacion','0.70%', 'Media de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Pendiente', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','BD115803','Peterbill','','','Rojo','1','0.70%', 'Media de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','CSBD2894','Freightliner','Cascadia','','Amarillo','Validacion','0.30%', 'Media de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Pendiente', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','7L544527','International','CF600','','Blanco','Validacion','0.40%', 'Ajuste de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Pendiente', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Martin Abel Hernandez Barrera');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','CSBD2185','Freightliner','Cascadia','','Blanco','Validacion','0.85%', 'Bomba de alta presion combustible', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','432043','Kenworth','T680','','Blanco','1','0.50%', 'Servicio general', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Alejandro Sánchez López');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','BD113724','Peterbill','','','Blanco','2','0.60%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','DH362342','International','4300','','Blanco','Validacion','0.60%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','AN262236','International','Pro star','','Blanco','2','0.70%', 'Revision general lineas de combustible', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','302973','Kenworth','T700','','Vino','Validacion','0.40%', 'Media de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Pendiente', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','288120','Kenworth','T660','','Blanco','Validacion','0.40%', 'Media de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Pendiente', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','BN337407','International','Pro star','','Blanco','2','0.40%', 'Servicio general', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','FDGJ0781','Freightliner','Cascadia day cab','','Azul','1','0.40%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','CDHN2663','International','M2','','Blanco','3','0.90%', 'Frenos', 0,'', '', 0, '', \Carbon\Carbon::parse('22-03-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','SSA1272','Freightliner','Cascadia','','Rojo','Validacion','', 'Eliminacion de DPF', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Pendiente');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','420265','Kenworth','T680','','Rojo','Validacion','0.00%', 'Servicio general', 0,'', '', 0, '', \Carbon\Carbon::parse('16-03-2021'), '00-00-0000', '','Entregado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Alejandro Sánchez López');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','426750','Kenworth','T680','','Blanco','Validacion','0.00%', 'Servicio general', 0,'', '', 0, '', \Carbon\Carbon::parse('16-03-2021'), '00-00-0000', '','Entregado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Alejandro Sánchez López');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','BJ337434','International','Pro star','','Blanco','Validacion','0.80%', 'Eliminacion de DPF', 0,'', '', 0, '', \Carbon\Carbon::parse('00-00-0000'), '00-00-0000', '','Pendiente', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Pendiente');
    // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','CD133243','Peterbill','','','Vino','Validacion','0.80%', 'Freno de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('04-01-2021'), '00-00-0000', '','Trabajando', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez');
    // // SolicitudTallerTrucks::createSolicitudTallerTrucks2('','AN289035','International','Pro star','','Validacion','0.30', 'Ajuste de motor', 0,'', '', 0, '', \Carbon\Carbon::parse('19-03-2021'), '00/00/0000', '','Asignado', 1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now());
    // return SolicitudTallerTrucks::get();

    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','CSBC5224','Freightliner','Cascadia','','Verde','Pendiente','0.50%', 'Conversión de transmisión', 0,'', '', 0, 'Radiador en reparacion', \Carbon\Carbon::parse('22-03-2021'), '27-03-2021', '','Trabajando',3, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca','Amortiguadores de suspensión de cabina, baterias y transmisión','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DLBT9513','Freightliner','Cascadia','','Café','Pendiente','0.60%', 'Modificacion de transmisión', 0,'', '', 0, 'considerar la calidad del clutch como sistema', \Carbon\Carbon::parse('22-03-2021'), '24-03-2021', '','Entregado',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca','','2');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','CJ954419','Kenworth','T700','','Blanco','Pendiente','0.40%', 'Modificacion de transmisión', 0,'', '', 0, 'Detalles en el servicio', \Carbon\Carbon::parse('22-03-2021'), '27-03-2021', '','Trabajando',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Alejandro Sánchez López','Reten sigueñal','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','GDHD0921 ','Freightliner','Cascadia day cab','','Azul','Pendiente','0.50%', 'Modificacion de transmisión', 0,'', '', 0, 'Unidad ya tiene servicio realizado', \Carbon\Carbon::parse('22-03-2021'), '27-03-2021', '','Entregado',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','Cilindro esclavo, sistema de clutch y volanta, perilla, mangueras, conexiones, torre y baston.','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','BD11 5803 ','Peterbill','','','Rojo','Pendiente','0.70%', 'Media de motor', 0,'', '', 0, 'Concluir trabajo', \Carbon\Carbon::parse('22-03-2021'), '25-03-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez','','3');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','432043','Kenworth','T680','','Blanco','Pendiente','0.50%', 'Servicio general', 0,'', '', 0, 'Servicio pendiente de orden con KW anahuac, se realiza caja de baterias hechiza, bolsas de aire, aceites diferenciales', \Carbon\Carbon::parse('22-03-2021'), '23-03-2021', '','Entregado',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Alejandro Sánchez López','Servicio completo','1');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','BD113724','Peterbill','','','Blanco','Pendiente','0.60%', 'Modificacion de transmisión', 0,'', '', 0, 'Detalles en el servicio, validacion de pago a torno lupita', \Carbon\Carbon::parse('22-03-2021'), '27-03-2021', '','Trabajando',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez','Turbo cargador, pedales','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DH362342','International','4300','','Blanco','Pendiente','0.60%', 'Modificacion de transmisión', 0,'', '', 0, 'tornilleria pendinete de recoger en sitio, pendiente servicio en dacsa con cotizacion', \Carbon\Carbon::parse('22-03-2021'), '25-03-2021', '','Trabajando',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','Tornilleria, servicio.','3');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','AN262236','International','Pro star','','Blanco','Pendiente','0.70%', 'Revision general lineas de combustible', 0,'', '', 0, 'Detalles de descarga de combustible, pendiente diagnostico', \Carbon\Carbon::parse('22-03-2021'), '27-03-2021', '','Entregado',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán','','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('',' BN337407','International','Pro star','','Blanco','Pendiente','0.40%', 'Servicio general', 0,'', '', 0, 'Motor maxxforce, servicio no comprado en DACSA, revision de alternador.', \Carbon\Carbon::parse('22-03-2021'), '27-03-2021', '','Entregado',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca','Servicio completo y baleros para masas traseras, perilla de cambios y manguera, conexiones. 3 baterias. Alternador.','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','FDGJ0781','Freightliner','Cascadia day cab','','Azul','Pendiente','0.40%', 'Modificacion de transmisión', 0,'', '', 0, 'servicio ya realizado', \Carbon\Carbon::parse('22-03-2021'), '27-03-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán','accesorios de cilindro, Cilindro esclavo, sistema de clutch','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','CDHN2663','International','M2','','Blanco','Pendiente','0.90%', 'Frenos', 0,'', '', 0, 'Problemas con frenos, revision general', \Carbon\Carbon::parse('22-03-2021'), '25-03-2021', '','Trabajando',3, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán','valvula para pfreno de escape y valulva de manipulacion de equipo aliado','3');
    
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','CSBC5224','Freightliner','Cascadia','','Verde','Pendiente','0.50%', 'Conversión de transmisión', 0,'', '', 0, 'Radiador en reparacion, Falta de orden, radiador con proveedor, sin presupuesto', \Carbon\Carbon::parse('27-03-2021'), '30-03-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca','Amortiguadores de suspensión de cabina, baterias y transmisión','3');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','BD113724','Peterbill','','','Blanco','Pendiente','0.60%', 'Modificacion de transmisión', 0,'', '', 0, 'Detalles en el servicio, validacion de pago a torno lupita, Torno lupita no entrego pedales', \Carbon\Carbon::parse('27-03-2021'), '30-03-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez','Turbo cargador, pedales','3');
    // return SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','FDGJ0781 ','Freightliner','Cascadia day cab','','Azul','Pendiente','0.40%', 'Modificacion de transmisión', 0,'', '', 0, 'servicio ya realizado, Detalle en el arranque', \Carbon\Carbon::parse('27-03-2021'), '31-03-2021', '','Entregado',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán','accesorios de cilindro, Cilindro esclavo, sistema de clutch','4');

    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','AN008643','Mack','','','Blanco','Pendiente','0.60%', 'Media de motor', 0,'', '', 0, '2 semanas, Validacion de arranque', \Carbon\Carbon::parse('05-04-2021'), '30-03-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán','No se han comprado piezas porque no se ha terminado de desarmar','0');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','FSFU4972','Freightliner','Cascadia','','Azul','Pendiente','0.60%', 'Modificacion de transmision', 0,'', '', 0, '', \Carbon\Carbon::parse('05-04-2021'), '30-03-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca','realizar servicio','0');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','BD113724','Peterbill','','','Blanco','Pendiente','0.60%', 'Modificacion de transmisión', 0,'', '', 0, 'Detalles en el servicio, validacion de pago a torno lupita, Torno lupita no entrego pedales', \Carbon\Carbon::parse('27-03-2021'), '30-03-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez','Turbo cargador, pedales','3');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','HF402466','Kenworth','T680','','Naranja','Pendiente','0.60%', 'Servicio general', 0,'', '', 0, '', \Carbon\Carbon::parse('05-04-2021'), '30-03-2021', '','Entregado',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','','0');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','KF507196','Kenworth','T680','','Rojo','Pendiente','0.60%', 'Servicio general', 0,'', '', 0, '', \Carbon\Carbon::parse('05-04-2021'), '30-03-2021', '','Entregado',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','','0');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DJ961085','Kenworth','W900','','Azul','Pendiente','0.60%', 'Servicio general', 0,'', '', 0, 'Falta servicio, ya se encuentra en estetica', \Carbon\Carbon::parse('05-04-2021'), '30-03-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','','0');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','BD11 5803 ','Peterbill','','','Rojo','Pendiente','0.60%', 'Media de motor', 0,'', '', 0, 'Concluir trabajo 10 de Abril de 2021', \Carbon\Carbon::parse('22-03-2021'), '25-03-2021', '','Entregado',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Carlos Godinez Godinez','','5');
    // return SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DH175529','International','Pipa 20 mil','','Rojo','Pendiente','0.60%', 'Reemplazo de clutch', 0,'', '', 0, '', \Carbon\Carbon::parse('05-04-2021'), '30-03-2021', '','Trabajando',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','Sistema de clutch ','0');
    
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DJ29251','International','Pro star','','Blanco','Pendiente','0.30%', 'Modificacion de transmision', 0,'', '', 0, 'Reparacion de radiador y post enfriador, Correccion de frenos, servicio ya comprado pero sin realizar,Compra de post enfriador,  tranmision de 18 y accesorios (torre, baston, perilla, conexiones) clutch, tuberia de lado derecho, ', \Carbon\Carbon::parse('22-03-2021'), '16-03-2021', '','Asignado',0, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'José Israel Ceja Menchaca','','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DH175529','International','Pipa 20 mil','','Rojo','Pendiente','0%', 'Reemplazo de clutch', 0,'', '', 0, 'Sistema de clutch ', \Carbon\Carbon::parse('22-03-2021'), '05-04-2021', '','Trabajando',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DH362342','International','4300','','Blanco','Pendiente','0.60%', 'Modificacion de transmisión', 0,'', '', 0, '5, Bomba de combustible, inyectores, Servicio realizado, Kit de lainas para ajuste comprar con valencia, tornilleria pendinete de recoger en sitio, pendiente servicio en dacsa con cotizacion', \Carbon\Carbon::parse('22-03-2021'), '22-03-2021', '','Trabajando',2, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DJ961085','Kenworth','W900','','Azul','Pendiente','0%', 'Servicio general', 0,'', '', 0, 'Falta servicio, ya se encuentra en estetica', \Carbon\Carbon::parse('22-03-2021'), '05-04-2021', '','Trabajando',1, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Gerardo Eugenio Gonzales Cancino','','5');
    // SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','5473065','Kenworth','Volteo','','Rojo','Pendiente','0.40%', 'Reparacion de inyectores, bomba y diferenciales', 0,'', '', 0, 'Bombra de combustible, inyectores', \Carbon\Carbon::parse('19-03-2021'), '25-03-2021', '','Asignado',0, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán','','5');
    // return SolicitudTallerTrucksHistorial::createSolicitudTallerTrucks2('','DJ352110','Kenworth','T680','','Blanco','Pendiente','0.40%', 'Reemplazo de cilindros de clutch', 0,'', '', 0, 'Cilindros maestro  y esclavo, fan cluth, radiador, junta trasera del motor, clutch y sistema de clutch', \Carbon\Carbon::parse('22-03-2021'), '16-03-2021', '','Asignado',0, '100923', \Carbon\Carbon::now(), \Carbon\Carbon::now(),'Oscar Martínez Santillán','','5');

    $solicitud_taller_trucks_pendientes = SolicitudTallerTrucks::where('status', 'Pendiente')->where('visible','SI')->get();
    $solicitud_taller_trucks = SolicitudTallerTrucks::where('status', 'Asignado')->where('visible','SI')->get();
    $solicitud_taller_trucks_validando = SolicitudTallerTrucks::where('status', 'Trabajando')->where('visible','SI')->get();
    $solicitud_taller_trucks_liberado = SolicitudTallerTrucks::where('status', 'Entregado')->where('visible','SI')->get();
    // return $solicitud_taller_trucks;
    return view('TallerTracktocamiones.salidas.index', compact('solicitud_taller_trucks','solicitud_taller_trucks_validando','solicitud_taller_trucks_liberado','solicitud_taller_trucks_pendientes'));
  }
  public function new($id){
    $id = Crypt::decrypt($id);
    $solicitud_taller_trucks = SolicitudTallerTrucks::where('id', $id)
    ->get(['idinventario_trucks','descripcion','porcentaje_estetica','descripcion_estetica','descripcion_extra','combustible','comentarios','fecha_ingreso','fecha_estimada','idempleado'])
    ->last();
    $empleados = empleados::where('visible', 'SI')
    ->where('puesto','like', '%mecanico%')
    ->orWhere('puesto','like', '%taller%')
    ->orWhere('puesto','like', '%dissel%')
    ->orWhere('puesto','like', '%electrico%')
    ->orderBy('idempleados','desc')
    ->get(['idempleados','nombre','apellido_paterno','apellido_materno','puesto']);
    return view('TallerTracktocamiones.salidas.new', compact('empleados','solicitud_taller_trucks','id'));
  }
  public function store(Request $request){
    // return request();
    try {
      LiberarSolicitudTallerTrucks::createSolicitudTallerTrucks($request->id, '',$request->stetic_range,
      $request->description_stetic,$request->description_other, $request->petrol_range,$request->comments,
      $request->date_estimated, 'validando', '100923', $request->date_start, \Carbon\Carbon::now());
      $solicitud_taller_trucks = SolicitudTallerTrucks::where('id', $request->id)->get('id','status')->last();
      $solicitud_taller_trucks->status = 'validando';
      $solicitud_taller_trucks->saveOrFail();
      return redirect()->route('SalidasTallerTrackto.index')->with('success', 'Solicitud de salida de taller generada correctamente');

    } catch (\Exception $e) {
      return $e->getMessage();
    }

  }
  // public function historial(){
  //   return view('salidas.historial');
  // }
  public function BusquedaVIN(){

    $Busqueda = '%'.request()->valorBusqueda.'%';

    $Inventario = inventario_trucks::select('idinventario_trucks','marca','version','color','modelo','vin_numero_serie')->where(function ($query)  {
      $query->where('visible','SI');
    })->where(function ($query) use ($Busqueda) {
      $query->where('vin_numero_serie', 'like' , $Busqueda )
      ->orWhere('marca', 'like' , $Busqueda )
      ->orWhere('version', 'like' , $Busqueda )
      ->orWhere('color', 'like' , $Busqueda )
      ->orWhere('modelo', 'like' , $Busqueda );
    })->limit(5)->get();
    foreach ($Inventario as $Inv) {
      if (SolicitudTallerTrucks::where('idinventario_trucks', $Inv->idinventario_trucks)->count()==0) {
        $Inventario->pop()->where('idinventario_trucks', $Inv->idinventario_trucks);
      }
    }
    if(sizeof($Inventario) == 0){
      return json_encode(null);
    }else{
      return $Inventario;
    }
  }
  public function historial(){
    $historiales = SolicitudTallerTrucksHistorial::orderBy('id','asc')->get();
    return view('TallerTracktocamiones.salidas.historial', compact('historiales'));
  }
}
