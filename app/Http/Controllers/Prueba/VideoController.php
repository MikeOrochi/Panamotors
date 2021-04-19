<?php

namespace App\Http\Controllers\Prueba;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class VideoController extends Controller
{
  public function __construct()
  {
    set_time_limit(8000000);
  }
  public function index(){
    // return 'xD';
    return view('partials.menus');
  }
  public function store(Request $request){
    try {
      $file = $request->file('file');
      $nombre = $file->getClientOriginalName();
      \Storage::disk('local')->put('/video/'.$nombre,  \File::get($file));
      return $nombre;
    } catch (\Exception $e) {
      return json_encode($e->getMessage());
    }

  }
}
