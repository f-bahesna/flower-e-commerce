<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CartController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function showProduct(Request $request)
    {
        $user_id = Auth::user()->id;
        $product_id = $request->id;
        //get cart
        $data =  DB::table('carts as c')
                    ->Join('users as u','c.id_user','=','u.id')
                    ->Join('products as p' , 'c.id_product' , '=','p.id')
                    ->where('c.id_user',$user_id)
                    ->select(
                        'p.nama_product as nama_product',
                        'p.gambar_product as gambar_product',
                        'p.harga_product as harga_product',
                        'c.total as total'
                    )->get();
        //update total
                    $updateCart = [];
                        foreach($data as $value){
                            $updateCart[] = $value->harga_product * $value->total;
                        }
                $res = [];
                foreach($data as $key => $value){
                    $res[] ='    
                        <div class="row">
                            <div class="col-md-3">
                                <img class="img-cart" src="'. asset('storage/image/'.$value->gambar_product).'" height="50" width="50" alt="">
                            </div>
                                <div class="col-md-4 nama-product-cart">'.$value->nama_product.'<h6 class="font-weight-bold jumlah-cart">X '. $value->total .' </h6></div>
                                <div class="col-md-5 total-cart">Rp '. number_format($updateCart[$key],2,',','.') .'  </div>
                            </div>
                        <div class="dropdown-divider"></div>
                    ';
                }

            return response()->json([
                "status" => 200 , "data" => $res
            ]);
    }

    public function addProduct(Request $request)
    {
        $id_user = Auth::user()->id;
        $id_product = $request->id;
        setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
        // date_default_timezone_set('Asia/Jakarta');
        $date = strftime( "%A, %d %B %Y %H:%M", time());

        $total = DB::table('carts')->where('id_product',$id_product)->where('id_user',$id_user)->first();
        if($total){
            try {
                DB::beginTransaction();
                //UPDATE total product
                    DB::table('carts')
                        ->where("id_user",$id_user)->where("id_product",$id_product)
                        ->update([
                            "total" => $total->total + 1
                        ]);

                //CREATE log
                    DB::table('activitys')
                        ->insert([
                            "id_product" => $id_product,
                            "id_user" => $id_user,
                            "pesan_log" => "Menambahkan Ke Keranjang",
                            "created_at" => $date
                        ]);
                DB::commit();

                return response()->json([
                    "status" => 201 , "message" => "Berhasil Ditambah ke Keranjang" 
                ]);

            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json([
                    "status" => 401 , "message" => "Maaf belum dapat diproses, mohon kontak admin.Terima Kasih. ".$th.""
                ],500);
            }
            
        }else{
            try {
                DB::beginTransaction();
                // add product to cart
                   DB::table('carts')
                        ->insert([
                            "id_product" => $id_product,
                            "id_user" => $id_user,
                            "total" => 1
                        ]);
                //create log
                    DB::table('activitys')
                        ->insert([
                            "id_product" => $id_product,
                            "id_user" => $id_user,
                            "pesan_log" => "Menambahkan Ke Keranjang",
                            "created_at" => $date
                        ]);
    
                DB::commit();

                return response()->json([
                    "status" => 201 , "message" => "Berhasil Ditambah ke Keranjang" ,
                ]);
    
            } catch (\Exception $th) {
                DB::rollback();
                return response()->json([
                    "status" => 401 , "message" => "Maaf belum dapat diproses, mohon kontak admin.Terima Kasih. ".$th.""
                ],500);
            }
        }  
    }
//see cart
    public function showProductDetail(Request $request)
    {
        if($request->id_user != null){
            $user_id = $request->id_user;

            $carts =  DB::table('carts as c')
                ->Join('users as u','c.id_user','=','u.id')
                ->Join('products as p' , 'c.id_product' , '=','p.id')
                ->where('c.id_user', $request->id_user)
            ->select(
                'p.nama_product as nama_product',
                'p.jenis_product as jenis_product',
                'p.gambar_product as gambar_product',
                'p.harga_product as harga_product',
                'c.total as total',
                'c.id_product as id_product'
            )->get();

            $total= [];
            foreach($carts as $value){
                $total[] = $value->harga_product * $value->total;
            }
            //sub total
            $subTotal = array_sum($total);
            if($carts[0]){
               $view = view('cart.cart-details',compact('carts','user_id','total','subTotal'))->render();       
               return response()->json($view);        
            }else{
                return response()->json([
                    "status" => 500
                ],500);
            }
        }
    }

    public function calculateTotal(Request $request)
    {
        $data = DB::table('carts as c')
                ->Join('products as p','c.id_product','=','p.id')
                ->Join('users as u','c.id_user','=','u.id')
            ->select(
                'p.harga_product as harga_product',
                'c.total as total_product',
                'c.id_product as id_product'
            )
            ->where('c.id_user',$request->user_id)
            ->where('c.id_product',$request->id_product)
            ->get();

 
        switch($request->type){
            case "manual" :
                try {
                    DB::beginTransaction();
                    DB::table('carts')->where('id_user', $request->user_id)->where('id_product',$request->id_product)->update([
                        "total" => $request->value
                    ]);
                    DB::commit();

            $output = DB::table('carts as c')->where('c.id_user', $request->user_id)->where('c.id_product',$request->id_product)
                        ->Join('products as p','c.id_product','=','p.id')
                        ->select('c.total as total_product','p.harga_product')->first();

            $resultCalculate = $output->harga_product * $output->total_product;

            $getSubtotal = DB::table('carts as c')->where('c.id_user', $request->user_id)
                                    ->Join('products as p','c.id_product','=','p.id')
                                    ->select('c.total as total_product','p.harga_product')->get();
                                    
            //COUNT QTY & Product PRICE
            $subTotal = [];
            foreach($getSubtotal as $value){
                $subTotal[] = $value->total_product * $value->harga_product;
            }

            return response()->json([
                "status" => 200 , "resultCalculate" => "<h5>RP.".number_format($resultCalculate,0,',','.')."</h5>" ,
                "subTotal" => "<h3>RP.".number_format(array_sum($subTotal),0,',','.')."</h3>"
            ]);
                } catch (\Throwable $th) {
                    DB::rollback();
                }

            break;

            case "minus" :
                dd("click minus , total di kurangi");
            break;

            case "plus" : 
                dd("click plus , total di tambah");
            break;

            default:
                return response()->json([
                    "status" => 500 , "message" => "Tipe tidak terdefinisi"
                ]);
        }
    }

    public function deleteCart(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->id_product;

        DB::table('carts')->where('id_user',$user_id)->where('id_product',$product_id)->delete();

        
        $getSubtotal = DB::table('carts as c')->where('c.id_user', $request->user_id)
                    ->Join('products as p','c.id_product','=','p.id')
                    ->select('c.total as total_product','p.harga_product')->get();

        $subTotal = [];
        foreach($getSubtotal as $value){
            $subTotal[] = $value->total_product * $value->harga_product;
        }

        return response()->json([
            "status" => 200 , "subTotal" => "<h3>RP.".number_format(array_sum($subTotal),0,',','.')."</h3>"
        ]);
    }

    public function cartPayment(Request $req)
    {
        dd(1);
       // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_URL');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            )
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        dd($snapToken);
    }
}
