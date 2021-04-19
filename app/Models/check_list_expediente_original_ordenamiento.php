<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class check_list_expediente_original_ordenamiento extends Model
{
  protected $table = 'check_list_expediente_original_ordenamiento';
  public $timestamps = false;
  protected $primaryKey = 'idcheck_list_expediente_original_ordenamiento';

  protected $fillable = [
    'idcheck_list_expediente_original_ordenamiento','nombre','tipo','orden','orden_nombre','orden_tipo','visible'
  ];


}
