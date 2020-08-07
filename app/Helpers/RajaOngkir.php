<?php
 namespace App\Helpers;
 use DB;

 class RajaOngkir {
     public static function get($type , $id) {
        $data =
        ['query' => [
                "key" => env('RAJAONGKIR_APIKEY'),
        ]];
        $client = new \GuzzleHttp\Client();
        $url = env('RAJAONGKIR_ENDPOINTAPI') . $type;
        $request = $client->get($url , $data);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);
     }

     public static function post($type) {
        $data =
        ['query' => [
                "key" => env('RAJAONGKIR_APIKEY'),
        ]];
        $client = new \GuzzleHttp\Client();
        $url = env('RAJAONGKIR_ENDPOINTAPI') . $type;
        $request = $client->post($url , $data);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);
     }
 }