<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventario_cortes_trucks extends Model
{
  protected $table = 'inventario_cortes_trucks';
  public $timestamps = false;
  protected $primaryKey = 'idinventario_cortes_trucks';

  protected $fillable = [
    'idinventario_cortes_trucks','folio','marca','submarca','version','color','modelo',
    'precio_piso','precio_digital','transmision','vin_numero_serie','procedencia','matricula',
    'entidad','fecha_apertura','fecha_ingreso','fecha_ingreso_taller','fecha_salida_piso',
    'razon_social_ingreso','tipo_impuesto','tipo_venta','kilometraje','segmentacion',
    'estatus_unidad','ubicacion','descripcion_diferenciales','estatus_expediente_original',
    'estatus_seguro','comentarios','mercadolibre','publicado','consignacion','visible',
    'usuario_creador','fecha_creacion','fecha_guardado'
  ];


}
