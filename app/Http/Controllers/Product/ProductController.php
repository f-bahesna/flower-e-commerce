<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ProductController extends Controller
{
    public function __construct()
    {

    }

    public function getProductDetail()
    {
        return view('Product.ProductDetail');
    }

    public function searchProduct(Request $request)
    {
        $result = DB::table('products')->where('nama_product','LIKE',"%$request->value%")->get();
        $resultData = [];
        if($result){
            foreach($result as $key => $value){
                $resultData [] = 
                ' <div class="col-lg-4 col-md-6 mb-4">
                         <div class="card h-100">
                             <a href="#"><img class="card-img-top" src="storage/image/'. $value->gambar_product .'" style="height: 200px" alt=""></a>
                             <div class="card-body">
                             <h4 class="card-title">
                                 <a href="#"> '.$value->nama_product.' </a>
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
}
