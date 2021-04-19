<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class orden_compra_unidades extends Model
{
  protected $table = 'orden_compra_unidades';
  public $timestamps = false;
  protected $primaryKey = 'idorden_compra_unidades';

  protected $fillable = [
    'idorden_compra_unidades', 'folio', 'idinventario', 'vin', 'marca', 'version', 'modelo', 'color', 'tipo_unidad',
    'km','placa','folio_factura','agencia','precio','fecha_orden','tipo_movimiento','tipo_adquisicion','tipo_contable',
    'idproveedor','idvalidacion_proveedor','estatus','archivo','comentarios','visible','usuario_creador',
    'fecha_creacion','fecha_guardado','fecha_estimada_solucion','fecha_real_solucion','usuario_cerro','asignacion',
    'responsable','fuente_informacion','master','col1','col2','col3','col4','col5','col6','col7','col8','col9','col10',
    'tipo_compra','area','tipo_id','idcontacto','nombre','apellidos','alias','estatus_orden','idinventario_venta',
    'vin_venta','tipo_moneda','tipo_cambio','monto_entrada','gran_total','url_referencia_mercado_libre',
    'imagen_mercado_libre','monto_max_mercado_libre','monto_min_mercado_libre','referencia_mercantil','pagina_libro',
    'mes_libro','year_libro','archivo_libro','comision_externa','tipo_moneda_comision','tipo_cambio_comision',
    'monto_entrada_comision','gran_total_comision','area_comision','idcontacto_comision','procedencia',
    'tipo_moneda_gastos_importado','tipo_cambio_gastos_importado','monto_entrada_gastos_importado',
    'gran_total_gastos_importado','tipo_moneda_honorarios','tipo_cambio_honorarios','monto_entrada_honorarios',
    'gran_total_honorarios','comision_interna','precio_agencia'
  ];




}
