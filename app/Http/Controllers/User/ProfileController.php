<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Http\Model\Product\products as product;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = DB::table('users as u')
            ->LeftJoin('user_informations as ui','u.id','=','ui.user_id')
            ->select('ui.*')
            ->where('ui.user_id',Auth::user()->id)
            ->first();

        if(Auth::check() && $profile){
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
            
            $products = product::paginate(6)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
            return view('User.Profile.Profile',compact('products','countCart','CartAdded','CartProductPriceTotal','user_id','jenis','profile'));
        }else{
            $countCart = 0;
            $profile = "Belum Di Isi";
            $user_id = 0;
            $CartAdded = 0;
            $products = product::paginate(6)->toArray();
            $jenis = DB::table('products')->select('jenis_product')->distinct()->get();
            return view('User.Profile.Profile',compact('products','user_id','countCart','CartAdded','CartProductPriceTotal','jenis','profile'));
        }
    }

    public function saveEditProfile()
    {

    }

    public function deleteAccount()
    {

    }
    
}
