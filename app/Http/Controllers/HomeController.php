<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Model\Product\products as product;
use DB;
use Auth;
use App\Http\Model\product\CartModel as cartModel;

class HomeController extends Controller
{

    public function __construct(CartModel $cartModel)
    {
        $this->cartModel = $cartModel;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $Cart = DB::table('carts')->where('id_user',$user_id)->sum('total');
            $countCart = preg_replace("/\.?0+$/", "", $Cart);

            //getCardAdded from CartModel
            $CartAdded = $this->cartModel->getCardAdded($user_id);
            //Count langsung total harga di keranjang
            $CartProductPriceTotal = [];
            $Get = DB::table('carts as c')->where('id_user',$user_id)
                        ->Join('products as p','c.id_product','=','p.id')
                        ->select('p.harga_product as harga_product','c.total as total')->get();
                      
            foreach($Get as $value){
                $CartProductPriceTotal[] = $value->harga_product * $value->total;
            }
            
            $products = product::paginate(6)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->paginate(6);
            return view('welcome',compact('products','countCart','CartAdded','CartProductPriceTotal','user_id','jenis'));
        }else{
            $countCart = 0;
            $user_id = 0;
            $CartAdded = 0;
            $products = product::paginate(6)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
            return view('welcome',compact('products','user_id','countCart','CartAdded','CartProductPriceTotal','jenis'));
        }
    }

    // public function searchByCategorie(Request $request)
    // {
    //     $url = ENV('APP_URL') . "/search-by-categorie"; 
    //     $data = DB::table('products')->where('jenis_product', $request->jenis_product)->get();

    //     $view = view('Product.product',compact('data'))->render();

    //     return response()->json([
    //         "status" => 200 , "view" => $view 
    //     ]);
    // }
    public function searchByCategorie($jenis)
    {
        if(Auth::check()){
            $products = products::all();
            $user_id = Auth::user()->id;
            $Cart = DB::table('carts')->where('id_user',$user_id)->sum('total');
            $countCart = preg_replace("/\.?0+$/", "", $Cart);
    
            // $products = product::where('status_product','published')->paginate(10)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->where('jenis_product', $jenis)->get();
            dd($jenis);
            return view('Product.product',compact('products','user_id','Cart','countCart','jenis'));
        }else{
            $products = products::all();
            $user_id = 0;
            $Cart = DB::table('carts')->where('id_user',$user_id)->sum('total');
            $countCart = preg_replace("/\.?0+$/", "", $Cart);
    
            // $products = product::where('status_product','published')->paginate(10)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->where('jenis', $jenis)->get();
            
            return view('Product.product',compact('products','user_id','Cart','countCart','jenis'));
        }
    }
}
