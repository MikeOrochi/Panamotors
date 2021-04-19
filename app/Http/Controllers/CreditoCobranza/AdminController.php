<?php

namespace App\Http\Controllers\CreditoCobranza;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function __construct(){
    $this->middleware('auth');
  }
  public function index(){
    // return \Auth::user()->idempleados==257;
    return view('CreditoCobranza.dashboard.index');
  }
}
