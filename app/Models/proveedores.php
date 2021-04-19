<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
  protected $table = 'proveedores';
  public $timestamps = false;
  protected $primaryKey = 'idproveedores';
  protected $fillable = [
    'idproveedores', 'idprovedores_compuesto', 'nomeclatura', 'nombre', 'apellidos', 'sexo', 'rfc', 'alias', 'trato', 'telefono_otro', 'telefono_celular', 'email', 'referencia_nombre', 'referencia_celular', 'referencia_fijo', 'referencia_nombre2', 'referencia_celular2', 'referencia_fijo2', 'referencia_nombre3', 'referencia_celular3', 'referencia_fijo3', 'tipo_registro', 'recomendado', 'entrada', 'asesor', 'tipo_cliente', 'tipo_credito', 'linea_credito', 'codigo_postal', 'estado', 'delmuni', 'colonia', 'calle', 'foto_perfil', 'visible', 'usuario_creador', 'fecha_creacion', 'fecha_guardado', 'metodo_pago', 'col1', 'col2', 'col3', 'col4', 'col5', 'col6', 'col7', 'col8', 'col9', 'col10', 'archivo_ine', 'archivo_comprobante'
  ];

  public static function createProveedores($idprovedores_compuesto, $nomeclatura, $nombre, $apellidos, $sexo, $rfc, $alias, $trato, $telefono_otro, $telefono_celular, $email, $referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3, $tipo_registro, $recomendado, $entrada, $asesor, $tipo_cliente, $tipo_credito, $linea_credito, $codigo_postal, $estado, $delmuni, $colonia, $calle, $foto_perfil, $visible, $usuario_creador, $fecha_creacion, $fecha_guardado, $metodo_pago, $col1, $col2, $col3, $col4, $col5, $col6, $col7, $col8, $col9, $col10, $archivo_ine, $archivo_comprobante){
    return proveedores::create([
      // 'idproveedores' => $idproveedores,
      'idprovedores_compuesto' => $idprovedores_compuesto,
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
      'visible' => $visible,
      'usuario_creador' => $usuario_creador,
      'fecha_creacion' => $fecha_creacion,
      'fecha_guardado' => $fecha_guardado,
      'metodo_pago' => $metodo_pago,
      'col1' => $col1,
      'col2' => $col2,
      'col3' => $col3,
      'col4' => $col4,
      'col5' => $col5,
      'col6' => $col6,
      'col7' => $col7,
      'col8' => $col8,
      'col9' => $col9,
      'col10' => $col10,
      'archivo_ine' => $archivo_ine,
      'archivo_comprobante' => $archivo_comprobante,

    ]);

  }
  public static function updateNewProvider($idproveedores,$referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2, $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3,$codigo_postal, $estado, $delmuni, $colonia, $calle,$usuario_creador,$fecha_guardado, $col6, $col7, $col8, $col9, $col10,$col1,$col2){
    // return 'xD';

    $today = Carbon::now();
    $provider = proveedores::get()->where('idproveedores', $idproveedores)->last();
    $provider->referencia_nombre = $referencia_nombre;
    $provider->referencia_celular = $referencia_celular;
    $provider->referencia_fijo = $referencia_fijo;
    $provider->referencia_nombre2 = $referencia_nombre2;
    $provider->referencia_celular2 = $referencia_celular2;
    $provider->referencia_fijo2 = $referencia_fijo2;
    $provider->referencia_nombre3 = $referencia_nombre3;
    $provider->referencia_celular3 = $referencia_celular3;
    $provider->referencia_fijo3 = $referencia_fijo3;
    $provider->codigo_postal = $codigo_postal;
    $provider->estado = $estado;
    $provider->delmuni = $delmuni;
    $provider->colonia = $colonia;
    $provider->calle = $calle;
    $provider->usuario_creador = $usuario_creador;
    $provider->fecha_guardado = $today;
    $provider->col6 = $col6;
    $provider->col7 = $col7;
    $provider->col8 = $col8;
    $provider->col9 = $col9;
    $provider->col10 = $col10;
    $provider->col1 = $col1;
    $provider->col2 = $col2;
    $provider->saveOrFail();
    return $provider;
  }
  public static function updateProvider($idproveedores,$nombre,$apellidos,$sexo,$rfc,$alias,$telefono_otro,
    $telefono_celular,$email,$referencia_nombre, $referencia_celular, $referencia_fijo, $referencia_nombre2,
    $referencia_celular2, $referencia_fijo2, $referencia_nombre3, $referencia_celular3, $referencia_fijo3,
    $codigo_postal, $estado, $delmuni, $colonia, $calle,$usuario_creador,$fecha_guardado, $col6, $col7, $col8,
    $col9, $col10 , $col2){
    $today = Carbon::now();
    $provider = proveedores::get()->where('idproveedores', $idproveedores)->last();
    $provider->nombre = $nombre;
    $provider->apellidos = $apellidos;
    $provider->sexo = $sexo;
    $provider->rfc = $rfc;
    $provider->alias = $alias;
    $provider->telefono_otro = $telefono_otro;
    $provider->telefono_celular = $telefono_celular;
    $provider->email = $email;
    $provider->referencia_nombre = $referencia_nombre;
    $provider->referencia_celular = $referencia_celular;
    $provider->referencia_fijo = $referencia_fijo;
    $provider->referencia_nombre2 = $referencia_nombre2;
    $provider->referencia_celular2 = $referencia_celular2;
    $provider->referencia_fijo2 = $referencia_fijo2;
    $provider->referencia_nombre3 = $referencia_nombre3;
    $provider->referencia_celular3 = $referencia_celular3;
    $provider->referencia_fijo3 = $referencia_fijo3;
    $provider->codigo_postal = $codigo_postal;
    $provider->estado = $estado;
    $provider->delmuni = $delmuni;
    $provider->colonia = $colonia;
    $provider->calle = $calle;
    $provider->usuario_creador = $usuario_creador;
    $provider->fecha_guardado = $today;
    $provider->col2 = $col2;
    $provider->col6 = $col6;
    $provider->col7 = $col7;
    $provider->col8 = $col8;
    $provider->col9 = $col9;
    $provider->saveOrFail();
    return $provider;
  }
}
