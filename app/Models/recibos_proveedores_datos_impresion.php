<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class recibos_proveedores_datos_impresion extends Model
{
   protected $table = 'recibos_proveedores_datos_impresion';
   // public $timestamps = false;

   protected $fillable = [
      'id_recibos_proveedores', 'qrcode_url', 'id_generic_voucher', 'nombre_usuario_recepcionista', 'estatus'
   ];

   public static function createRecibosProveedoresDatosImpresion($id_recibos_proveedores, $qrcode_url, $id_generic_voucher, $nombre_usuario_recepcionista, $estatus){
     return recibos_proveedores_datos_impresion::create([
        'id_recibos_proveedores' => $id_recibos_proveedores,
        'qrcode_url' => $qrcode_url,
        'id_generic_voucher' => $id_generic_voucher,
        'nombre_usuario_recepcionista' => $nombre_usuario_recepcionista,
        'estatus' => $estatus,
     ]);
   }
}
