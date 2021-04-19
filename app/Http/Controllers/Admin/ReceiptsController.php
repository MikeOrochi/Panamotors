<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\recibos_proveedores;
use Illuminate\Support\Facades\Auth;

class ReceiptsController extends Controller
{

  public function __construct(){
    $this->middleware('auth');
  }

  public function show($id){
    $Recibos =  recibos_proveedores::where('idcontacto', $id)->get();
    return view('admin.receipts.index',compact('Recibos','id'));
  }

}
