<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Http\Model\Product\products as product;
use GuzzleHttp\Client;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class PaymentController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $Cart = DB::table('carts')->where('id_user',$user_id)->sum('total');
            $countCart = preg_replace("/\.?0+$/", "", $Cart);

            $CartAdded = DB::table('carts as c')
                        ->Join('users as u','c.id_user','=','u.id')
                        ->Join('products as p','c.id_product','=','p.id')
                        ->select(
                            'p.gambar_product as gambar_product',
                            'p.nama_product as nama_product',
                            'p.harga_product as harga_product',
                            'c.total as total',
                            'c.id_user as user_id'
                        )
            ->where('id_user',$user_id)->paginate(4);
            //Count langsung total harga di keranjang
            $CartProductPriceTotal = [];
            $Get = DB::table('carts as c')->where('id_user',$user_id)
                        ->Join('products as p','c.id_product','=','p.id')
                        ->select('p.harga_product as harga_product','c.total as total')->get();
            foreach($Get as $value){
                $CartProductPriceTotal[] = $value->harga_product * $value->total;
            }
            
            $products = product::paginate(10)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
            return view('Payment.PaymentConfirmation',compact('products','countCart','CartAdded','CartProductPriceTotal','user_id','jenis'));
        }else{
            $countCart = 0;
            $user_id = 0;
            $CartAdded = 0;
            $products = product::paginate(10)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
            return view('Payment.PaymentConfirmation',compact('products','user_id','countCart','CartAdded','CartProductPriceTotal','jenis'));
        }
    }

    public function checkout(Request $request)
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $Cart = DB::table('carts')->where('id_user',$user_id)->sum('total');
            $countCart = preg_replace("/\.?0+$/", "", $Cart);

            $CartAdded = DB::table('carts as c')
                        ->Join('users as u','c.id_user','=','u.id')
                        ->Join('products as p','c.id_product','=','p.id')
                        ->select(
                            'p.gambar_product as gambar_product',
                            'p.nama_product as nama_product',
                            'p.harga_product as harga_product',
                            'c.total as total',
                            'c.id_user as user_id'
                        )
            ->where('id_user',$user_id)->paginate(4);
            //Count langsung total harga di keranjang
            $CartProductPriceTotal = [];
            $Get = DB::table('carts as c')->where('id_user',$user_id)
                        ->Join('products as p','c.id_product','=','p.id')
                        ->select('p.harga_product as harga_product','c.total as total')->get();
            foreach($Get as $value){
                $CartProductPriceTotal[] = $value->harga_product * $value->total;
            }
            
            $products = product::paginate(10)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
            $view =  view('Payment.checkout',compact('products','countCart','CartAdded','CartProductPriceTotal','user_id','jenis'))->render();

            return response()->json([
                "status" => 200 , "view" => $view
            ]);
            
        }else{
            $countCart = 0;
            $user_id = 0;
            $CartAdded = 0;
            $products = product::paginate(10)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
            $view =  view('Payment.checkout',compact('products','user_id','countCart','CartAdded','CartProductPriceTotal','jenis'))->render();

            return response()->json([
                "status" => 200 , "view" => $view
            ]);
            
        }
    }
    
    public static function getProvince()
    {
        $data =
        ['query' => [
                "key" => env('RAJAONGKIR_APIKEY'),
        ]];
        $client = new \GuzzleHttp\Client();
        $url = env('RAJAONGKIR_ENDPOINTAPI') . 'province';
        $request = $client->get($url , $data);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);
        
        return $result->rajaongkir->results;
    }

    public static function getCityByID(Request $request)
    {
        $data =
        ['query' => [
                "key" => env('RAJAONGKIR_APIKEY'),
                "province" => $request->id
        ]];
        $client = new \GuzzleHttp\Client();
        $url = env('RAJAONGKIR_ENDPOINTAPI') . 'city';
        $request = $client->get($url , $data);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);
        $getResult = $result->rajaongkir->results;
        
        $endResultCity = ['<option selected value="#">Pilih...</option>'];   
        foreach($getResult as $key => $value){  
            $endResultCity[] = '<option value='.$value->city_id.'>'. $value->type .' '. $value->city_name .'</option>'; 
        }

        return response()->json([
            "status" => 200 , "city" => $endResultCity
        ]);
    }

    public static function cost(Request $request)
    {
        $daftarProvinsi = RajaOngkir::ongkir([
            'origin'        => 492,     // ID kota/kabupaten asal TULUNGAGUNG
            // 'origin'        => 247,     // ID kota/kabupaten asal MADIUN
            'destination'   => $request->city_id,      // ID kota/kabupaten tujuan
            'weight'        => $request->weight,    // berat barang dalam gram
            'courier'       => $request->courier    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ]);
        $a = (array)$daftarProvinsi;
        $resultGet = $a["\x00*\x00result"][0]['costs'];
        $resultServiceAndCost = ['<p class="bg-warning rounded border">Pilih Service Kurirmu :</p>']; 
        foreach($resultGet as $key => $value){
            $resultServiceAndCost[] = '<div class="form-check border courier_service_child rounded mt-1">
                                        <input type="radio" biaya="'.$value['cost'][0]['value'].'" class="form-check-input input-courier-service" name="radio2" value="'.$value['service'].'">
                                        <label class="form-check-label" for="courier">'.$value['service'].'</label>
                                        <p>Biaya: <p class="biaya"> ' .$value['cost'][0]['value']. ' </p></p>
                                        <p>Perkiraan Tiba : '.$value['cost'][0]['etd'].' Hari</p>
                                    </div>';
        }

        return response()->json([
            "status" => 200 , "courier_service" => $resultServiceAndCost
        ]);
    }

    public function zipCode(Request $request)
    {
        $data =
        ['query' => [
                "key" => env('RAJAONGKIR_APIKEY'),
                // id province
                "province" => $request->province_id,
                //id city
                "id" => $request->city_id
        ]];
        $client = new \GuzzleHttp\Client();
        $url = env('RAJAONGKIR_ENDPOINTAPI') . 'city';
        $request = $client->get($url , $data);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);
        $getResult = $result->rajaongkir->results;

        return response()->json([
            "status" => 200 , "postal_code" => $getResult->postal_code
        ]);
    }

    public static function getCity()
    {
        $data =
        ['query' => [
                "key" => env('RAJAONGKIR_APIKEY'),
        ]];
        $client = new \GuzzleHttp\Client();
        $url = env('RAJAONGKIR_ENDPOINTAPI') . 'city';
        $request = $client->get($url , $data);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);

        return $result->rajaongkir->results;
    }
}
