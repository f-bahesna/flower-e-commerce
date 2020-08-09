<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('Payment.userCheckOrder');
    }

    public function storeOrder(Request $request)
    {   
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|max:40|regex:[A-Za-z1-9 ]",
                "nomor_telepon" => "required|regex:[A-Za-z1-9 ]|size:20",
                "email" => "string|email|regex:[A-Za-z1-9 ]",
                "address" => "required|regex:[A-Za-z1-9 ]",
                "province" => "required",
                "city" => "required",
                "courier" => "required",
                "courier_service" => "required",
                "product_id" => "required",
                "harga" => "required",
                "qty" => "required",
                "notes" => "regex:[A-Za-z1-9 ]|max:100"
            ],[
                "name.required" => "Nama Tidak Boleh Kosong.",
                "nomor_telepon.required" => "Nomor Telepon Harus Diisi,Karena untuk validasi order.",
                "province.required" => "Harus Pilih Provinsi Dulu",
                "city.required" => "Harus Pilih Kota atau Kabupaten",
                "courier_service" => "Harus Pilih Service Kurir",
            ]);

            $total_price = $request->harga * $request->qty;
            DB::beginTransaction();
            DB::table('orders_manual')->insert([
                "nomor_telepon" => intval($request->nomor_telephone),
                "address" => $request->address,
                "province" => $request->province,
                "city" => $request->city,
                "courier" => $request->courier,
                "courier_service" => $request->courier_service,
                "product_id" => intval($request->product_id),
                "qty" => $request->qty,
                "total_price" => intval($total_price),
                "status" => "verification",
                "notes" => $request->notes
            ]);
            DB::commit();
            
            createLog($request->product_id ,$request->nomor_telephone,"Memesan");
            $url = "orders_manual/index";

            return response()->json([
                "status" => 200 , "url" => $url
            ]);


        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                "status" => 400 ,  "message" => $ex->errorInfo
            ],500);
        }    


    }
}
