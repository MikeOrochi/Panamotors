<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asesores extends Model
{
  protected $table = 'asesores';
  public $timestamps = false;
  protected $primaryKey = 'idasesores';

  protected $fillable = [
  'idasesores', 'nombre', 'nomeclatura', 'puesto', 'estatus', 'idusuarios', 'visible', 'idenlace_seguimiento'
  ];
  public function contactos(){
      return $this->belongsTo('\App\Models\contactos');
  }
  public static function createAsesores($idasesores, $nombre, $nomeclatura, $puesto, $estatus, $idusuarios, $visible, $idenlace_seguimient){
    return asesores::create([
      'idasesores' => $idasesores,
      'nombre' => $nombre,
      'nomeclatura' => $nomeclatura,
      'puesto' => $puesto,
      'estatus' => $estatus,
      'idusuarios' => $idusuarios,
      'visible' => $visible,
      'idenlace_seguimiento' => $idenlace_seguimient
    ]);
  }
}
