<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\asesores;
use App\Models\clientes_tipos;
use App\Models\credito_tipos;

class contactos extends Model
{
  protected $table = 'contactos';
  public $timestamps = false;
  protected $primaryKey = 'idcontacto';
  protected $fillable = [
    'idcontacto', 'nomeclatura', 'nombre', 'apellidos', 'sexo', 'rfc', 'alias', 'trato', 'telefono_otro', 'telefono_celular', 'email', 'referencia_nombre', 'referencia_celular', 'referencia_fijo', 'referencia_nombre2', 'referencia_celular2', 'referencia_fijo2', 'referencia_nombre3', 'referencia_celular3', 'referencia_fijo3', 'tipo_registro', 'recomendado', 'entrada', 'asesor', 'tipo_cliente', 'tipo_credito', 'linea_credito', 'codigo_postal', 'estado', 'delmuni', 'colonia', 'calle', 'foto_perfil', 'fecha_nacimiento', 'usuario_creador', 'fecha_creacion'
  ];
  public function asesor_nomenclatura($idasesores){
    return asesores::where('idasesores', $idasesores)->get(['idasesores','nomeclatura'])->first();
  }
  public function tipo_cliente_nombre($idclientes_tipos){
    return clientes_tipos::where('idclientes_tipos', $idclientes_tipos)->get(['idclientes_tipos','nombre'])->first();
  }
  public function tipo_credito_nombre($idcredito_tipos){
    return credito_tipos::where('idcredito_tipos', $idcredito_tipos)->get(['idcredito_tipos','nombre'])->first();
  }
  public static function createContactos($nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $usuario_creador, $fecha_creacion){
    return contactos::create([
      'nomeclatura' => $nomeclatura,
      'nombre' => $nombre,
      'apellidos' => $apellidos,
      'sexo' => $sexo,
      'rfc' => $rfc,
      'alias' => $alias,
      'trato' => $trato,
      'telefono_otro' => $telefono_otro,
      'telefono_celular' => $telefono_celular,
      'email' => $email,
      'referencia_nombre' => $referencia_nombre,
      'referencia_celular' => $referencia_celular,
      'referencia_fijo' => $referencia_fijo,
      'referencia_nombre2' => $referencia_nombre2,
      'referencia_celular2' => $referencia_celular2,
      'referencia_fijo2' => $referencia_fijo2,
      'referencia_nombre3' => $referencia_nombre3,
      'referencia_celular3' => $referencia_celular3,
      'referencia_fijo3' => $referencia_fijo3,
      'tipo_registro' => $tipo_registro,
      'recomendado' => $recomendado,
      'entrada' => $entrada,
      'asesor' => $asesor,
      'tipo_cliente' => $tipo_cliente,
      'tipo_credito' => $tipo_credito,
      'linea_credito' => $linea_credito,
      'codigo_postal' => $codigo_postal,
      'estado' => $estado,
      'delmuni' => $delmuni,
      'colonia' => $colonia,
      'calle' => $calle,
      'foto_perfil' => $foto_perfil,
      // 'fecha_nacimiento' => $fecha_nacimiento,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,

    ]);
  }
}
