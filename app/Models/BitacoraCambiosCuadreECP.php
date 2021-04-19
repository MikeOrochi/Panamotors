<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BitacoraCambiosCuadreECP extends Model
{
  protected $table = 'BitacoraCambiosCuadreECP';
  public $timestamps = false;

  protected $fillable = [
      'id','Tabla','Columna','idTablaModificada','ValorAnterior','ValorNuevo','Comentarios','FechaCreacion'
  ];

  public static function createRegistroCambio($Tabla,$Columna,$idTablaModificada,$ValorAnterior,$ValorNuevo,$Comentarios){
    return BitacoraCambiosCuadreECP::create([
      'Tabla' => $Tabla,
      'Columna' => $Columna,
      'idTablaModificada' => $idTablaModificada,
      'ValorAnterior' => $ValorAnterior,
      'ValorNuevo' => $ValorNuevo,
      'Comentarios' => $Comentarios,
      'FechaCreacion' => \Carbon\Carbon::now()
    ]);
  }
}
