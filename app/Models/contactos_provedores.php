<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contactos_provedores extends Model
{
  protected $table = 'contactos_provedores';
  public $timestamps = false;
  protected $primaryKey = 'idcontactos_provedores';
  protected $fillable = [
    'idcontactos_provedores', 'idcontacto', 'idprovedor'
  ];

  public static function createContactosProvedores($idcontacto, $idprovedor){
    return contactos_provedores::create([
      'idcontacto' => $idcontacto,
      'idprovedor' => $idprovedor
    ]);
  }
}
