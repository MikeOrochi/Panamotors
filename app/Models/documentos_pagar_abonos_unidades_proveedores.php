<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentos_pagar_abonos_unidades_proveedores extends Model
{
  protected $table = 'documentos_pagar_abonos_unidades_proveedores';
  public $timestamps = false;
  protected $primaryKey = 'iddocumentos_pagar_abonos_unidades_proveedores';

  protected $fillable = [
    'iddocumentos_pagar_abonos_unidades_proveedores', 'iddocumentos_pagar', 'idabonos_unidades_proveedores', 'monto_esperado', 'monto_alcanzado', 'fecha_creacion',
  ];
  public static function createDocumentosPagarAbonosUnidadesProv($iddocumentos_pagar, $idabonos_unidades_proveedores, $monto_esperado, $monto_alcanzado, $fecha_creacion){
    return documentos_pagar_abonos_unidades_proveedores::create([
      'iddocumentos_pagar' => $iddocumentos_pagar,
      'idabonos_unidades_proveedores' => $idabonos_unidades_proveedores,
      'monto_esperado' => $monto_esperado,
      'monto_alcanzado' => $monto_alcanzado,
      'fecha_creacion' => $fecha_creacion
    ]);
  }
}
