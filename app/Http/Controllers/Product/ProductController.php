<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Http\Model\Product\products;

class ProductController extends Controller
{
    public function __construct()
    {

    }

    public function getAllProduct()
    {
        $products = products::all();
        dd($products);
    }

    public function getProductDetail($id)
    { 
        $user_id = Auth::user()->id;
        $Cart = DB::table('carts')->where('id_user',$user_id)->sum('total');
        $countCart = preg_replace("/\.?0+$/", "", $Cart);

        //Cart Details
        $qty = DB::table('carts')->where('id_user',$user_id)->get();
        $product = DB::table('carts as c')
            ->Join('users as u','c.id_user','=','u.id')
            ->Join('products as p' , 'c.id_product' , '=','p.id')
        ->select(
            'p.nama_product as nama_product',
            'p.gambar_product as gambar_product',
            'p.harga_product as harga_product'
        )->get();

        $CartAdded = DB::table('carts as c')
                    ->Join('users as u','c.id_user','=','u.id')
                    ->Join('products as p','c.id_product','=','p.id')
                    ->select(
                        'p.gambar_product as gambar_product',
                        'p.nama_product as nama_product',
                        'p.harga_product as harga_product',
                        'c.total as total'
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


        $additional_image = DB::table('additional_product_image')->where('id_product',$id)->get();
        $result = products::find($id);
        return view('Product.ProductDetail',compact('result','additional_image','countCart','CartAdded','CartProductPriceTotal'));
    }

    public function searchProduct(Request $request)
    {
        $result = DB::table('products')->where('nama_product','LIKE',"%$request->value%")->get();
        $resultData = [];
        if($result){
            foreach($result as $key => $value){
                $resultData [] = 
                '<div class="col-lg-4 col-md-6 mb-4">
                         <div class="card h-100">
                             <a href="/product-detail/'.$value->id.'"><img class="card-img-top" src="storage/image/'. $value->gambar_product .'" style="height: 200px" alt=""></a>
                             <div class="card-body">
                             <h4 class="card-title">
                                 <a href="/product-detail/'.$value->id.'"> '.$value->nama_product.' </a>
                             </h4>
                             <h6>Rp '. number_format($value->harga_product,2,',','.') .' </h6>
                             </div>
                             <div class="card-footer">
                             <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                             </div>
                         </div>
                     </div>
                ';
            }
        }

        if($resultData){
            return response()->json([
                "status" => 200 , "result" => $resultData
            ]);
        }else{
            return response()->json([
                "status" => 401 , "result" => "Maaf Stock Kosong"
            ],401);
        }
    }

    public function showCart()
    {
      
    }
}
