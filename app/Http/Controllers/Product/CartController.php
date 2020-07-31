<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

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
                //update total product
                    DB::table('carts')
                        ->where("id_user",$id_user)->where("id_product",$id_product)
                        ->update([
                            "total" => $total->total + 1
                        ]);

                // //create log
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
                // //create log
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
    
            } catch (\Exception $th) {
                DB::rollback();
                return response()->json([
                    "status" => 401 , "message" => "Maaf belum dapat diproses, mohon kontak admin.Terima Kasih. ".$th.""
                ],500);
            }
        }  
    }

    protected function updateKeranjang($params)
    {
        $data =  DB::table('carts as c')
            ->Join('users as u','c.id_user','=','u.id')
            ->Join('products as p' , 'c.id_product' , '=','p.id')
            ->where('c.id_user',$params['id_user'])
            ->where('c.id_product',$params['id_product'])
            ->select(
                'p.nama_product as nama_product',
                'p.gambar_product as gambar_product',
                'p.harga_product as harga_product',
                'c.total as total'
            )->get();
            $updateCart = [];
            foreach($data as $value){
                $updateCart[] = $value->harga_product * $value->total;
            }

            $result = [
                "data" => $data,
                "total" => $updateCart
            ];
            return $result;
    
    }
}
