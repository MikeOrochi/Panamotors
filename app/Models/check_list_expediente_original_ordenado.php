<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class check_list_expediente_original_ordenado extends Model
{
  protected $table = 'check_list_expediente_original_ordenado';
  public $timestamps = false;
  protected $primaryKey = 'idcheck_list_expediente_original_ordenado';

  protected $fillable = [
      'idcheck_list_expediente_original_ordenado', 'idcheck_list_expediente_original','tipo','tipo_check_list','entrega','descripcion',
      'orden','orden_nombre','fecha_guardado','idorden_compra_unidades'
  ];

  public static function createCLEOO($idcheck_list_expediente_original ,$tipo, $tipo_check_list,$entrega,$descripcion ,
  $orden,$orden_nombre,$fecha_guardado,$idorden_compra_unidades){
    return check_list_expediente_original_ordenado::create([
      'idcheck_list_expediente_original' => $idcheck_list_expediente_original,
      'tipo' => $tipo,
      'tipo_check_list' => $tipo_check_list,
      'entrega' => $entrega,
      'descripcion' => $descripcion,
      'orden' => $orden,
      'orden_nombre' => $orden_nombre,
      'fecha_guardado' => $fecha_guardado,
      'idorden_compra_unidades' => $idorden_compra_unidades
    ]);
  }
}
