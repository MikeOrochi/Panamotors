<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZipController extends Controller
{
    public static function show($zip){
      try {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api-sepomex.hckdrk.mx/query/info_cp/'.$zip.'?token=8ea52221-206e-449a-b938-d1062eb7fc5a');
        $datas = json_decode($response->getBody()->getContents());
        $count = 0;
        foreach ($datas as $data) {
          $colony[$count] = $data->response->asentamiento;
          $count++;
        }
        // return $datas;
        $direction_info = ['zip'=>$datas[0]->response->cp,'state'=>$datas[0]->response->estado,'township'=>$datas[0]->response->municipio,'colony'=>$colony];
        return $direction_info;
      } catch (\Exception $e) {
        return json_encode($e->getMessage());
      }
    }
}
