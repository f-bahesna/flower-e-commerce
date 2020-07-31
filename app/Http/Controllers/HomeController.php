<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

            $products = product::paginate(10)->toArray();
            return view('welcome',compact('products','countCart'));
        }else{
            $countCart = 0;
            $products = product::paginate(10)->toArray();
            return view('welcome',compact('products','countCart'));
        }
    }
}
