<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bancos_emisores extends Model
{
  protected $table = 'bancos_emisores';
  public $timestamps = false;

  protected $fillable = [
    'idbancos_emisores', 'nombre'
  ];

  public static function createBancosEmisores($idbancos_emisores, $nombre){
    return bancos_emisores::create([
      'idbancos_emisores' => $idbancos_emisores,
      'nombre' => $nombre
    ]);
  }
}
