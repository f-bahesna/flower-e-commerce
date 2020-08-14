<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Product\products as product;
use DB;
use Auth;
use App\Http\Model\Product\products;
use App\Http\Controllers\Payment\PaymentController as payment;



class ProductController extends Controller
{
    public function __construct()
    {

    }

    public function getAllProduct()
    {
        if(Auth::check()){
            $products = products::all();
            $user_id = Auth::user()->id;
            $Cart = DB::table('carts')->where('id_user',$user_id)->sum('total');
            $countCart = preg_replace("/\.?0+$/", "", $Cart);
    
            $products = product::where('status_product','published')->paginate(10)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
    
            return view('Product.product',compact('products','user_id','Cart','countCart','jenis'));
        }else{
            $products = products::all();
            $user_id = 0;
            $Cart = DB::table('carts')->where('id_user',$user_id)->sum('total');
            $countCart = preg_replace("/\.?0+$/", "", $Cart);
    
            $products = product::where('status_product','published')->paginate(10)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
            
            return view('Product.product',compact('products','user_id','Cart','countCart','jenis'));
        }
    }

    public function searchProductByCategories(Request $request)
    {
        $value = self::sanitize($request->value);
        $resultProduct = DB::table('products')->where('jenis_product',$value)->get();
        
        $returnView = [];
        foreach($resultProduct as $key => $value){
            $returnView[] = '<div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <a href="product/product-detail/'. $value->id .'"><img class="card-img-top" src="images/image/'. $value->gambar_product . '" style="height: 200px" alt=""></a>
                    <div class="card-body">
                    <h4 class="card-title">
                        <a href="product/product-detail/'. $value->id .'"> '. $value->nama_product .' </a>
                    </h4>
                    <h6>Rp '. number_format($value->harga_product,2,',','.') .' </h6>
                    </div>
                    <div class="card-footer">
                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                    </div>
                </div>
            </div>' ;
        }

        return response()->json([
            "status" => 200 , "view" => $returnView , "categorie" => $value
        ]);
    }



    public function getProductDetail($id)
    { 
        //get raja ongkir
        $province = payment::getProvince();
        $city = payment::getCity();
        $shipment = [
            "province" => $province,
            "city" => $city
        ];
        // dd($shipment);
        if(Auth::check()){
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
            return view('Product.ProductDetail',compact('result','user_id','additional_image','countCart','CartAdded','CartProductPriceTotal','shipment'));
        }else{
            $CartAdded = 0;
            $countCart = 0;
            $CartProductPriceTotal = 0;
            $user_id = 0;
    
            $additional_image = DB::table('additional_product_image')->where('id_product',$id)->get();
            $result = products::find($id);
            return view('Product.ProductDetail',compact('result','user_id','additional_image','countCart','CartAdded','CartProductPriceTotal','shipment'));
        }
    }

    public function searchProduct(Request $request)
    {
        $result = DB::table('products')->where('nama_product','LIKE',"%$request->value%")->where('status_product','published')->get();
        $resultData = [];
        if($result){
            foreach($result as $key => $value){
                $resultData [] = 
                '<div class="col-lg-4 col-md-6 mb-4">
                         <div class="card h-100">
                             <a href="product/product-detail/'.$value->id.'"><img class="card-img-top" src="images/image/'. $value->gambar_product .'" style="height: 200px" alt=""></a>
                             <div class="card-body">
                             <h4 class="card-title">
                                 <a href="product/product-detail/'.$value->id.'"> '.$value->nama_product.' </a>
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

    public static function sanitize($params)
    {
        $lower = strtolower($params);
        return str_replace(' ', '_', $lower);
    }
}
