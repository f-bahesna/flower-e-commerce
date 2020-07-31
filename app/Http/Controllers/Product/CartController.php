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
        $this->middleware('guest')->except('register');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function addProduct(Request $request)
    {
        dd($request);
        $id_user = Auth::user()->id;
        $id_product = $request->id;
        setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
        // date_default_timezone_set('Asia/Jakarta');
        $date = strftime( "%A, %d %B %Y %H:%M", time());

        // $total = DB::table('carts')->where('id_product',$id_product)->first();

        try {
            DB::beginTransaction();
            // add product to cart
            //    DB::table('carts')
            //         ->insert([
            //             "id_product" => $id_product,
            //             "id_user" => $id_user
            //         ]);
            //create log
                // DB::table('activitys')
                //     ->insert([
                //         "id_product" => $id_product,
                //         "id_user" => $id_user,
                //         "pesan_log" => "Menambahkan Ke Keranjang",
                //         "created_at" => $date
                //     ]);

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
