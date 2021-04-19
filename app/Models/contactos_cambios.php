<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\asesores;
use App\Models\clientes_tipos;
use App\Models\credito_tipos;

class contactos_cambios extends Model
{
  protected $table = 'contactos_cambios';
  public $timestamps = false;
  protected $primaryKey = 'idcontactos_cambios';
  protected $fillable = [
    'contactos_cambios', 'nomeclatura', 'nombre', 'apellidos', 'sexo', 'rfc', 'alias', 'trato', 'telefono_otro', 'telefono_celular', 'email', 'referencia_nombre', 'referencia_celular', 'referencia_fijo', 'referencia_nombre2', 'referencia_celular2', 'referencia_fijo2', 'referencia_nombre3', 'referencia_celular3', 'referencia_fijo3', 'tipo_registro', 'recomendado', 'entrada', 'asesor', 'tipo_cliente', 'tipo_credito', 'linea_credito', 'codigo_postal', 'estado', 'delmuni', 'colonia', 'calle', 'foto_perfil', 'fecha_nacimiento', 'usuario_creador', 'fecha_creacion'
  ];
}
