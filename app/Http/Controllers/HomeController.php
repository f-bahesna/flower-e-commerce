<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Model\Product\products as product;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

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
            return view('welcome',compact('products','countCart','CartAdded','CartProductPriceTotal','user_id'));
        }else{
            $countCart = 0;
            $user_id = 0;
            $CartAdded = 0;
            $products = product::paginate(10)->toArray();
            return view('welcome',compact('products','user_id','countCart','CartAdded','CartProductPriceTotal'));
        }
    }
}
