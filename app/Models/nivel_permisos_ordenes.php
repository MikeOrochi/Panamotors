<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nivel_permisos_ordenes extends Model
{
   protected $table = 'nivel_permisos_ordenes';
   public $timestamps = false;
   protected $primaryKey = 'idnivel_permisos_ordenes';

   protected $fillable = [
       'idcatalogo_departamento','idempleado','nivel1','nivel2','nivel3'
   ];


   public static function createNivelPermisosOrdenes(
       $idcatalogo_departamento, $idempleado, $nivel1, $nivel2, $nivel3
     ){
     return nivel_permisos_ordenes::create([
         'idcatalogo_departamento'=>$idcatalogo_departamento,
         'idempleado'=>$idempleado,
         'nivel1'=>$nivel1,
         'nivel2'=>$nivel2,
         'nivel3'=>$nivel3
     ]);
   }


}
