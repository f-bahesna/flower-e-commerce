<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders_manual = DB::table('orders_manual as om')
            ->Join('products as p','om.product_id','=','p.id')
            ->leftJoin('payment_confirmation as pc','om.nomor_telephone','=','pc.nomor_telephone')
            ->select('om.*','p.*','pc.*','om.nomor_telephone as nomor_telephone','om.id as id_order')
        ->get()->toArray();
        
        return view('ADMIN.Order.OrderAdmin',compact('orders_manual'));
    }

    public function tolakOrder(Request $request)
    {
        $validation = Validator::make($request->all(),[
            "notes" => "required"
        ]);
        if($validation->passes()){
            DB::table('orders_manual')->where('order_code',$request->order_code)->update([
                "notes" => $request->notes,
                "status" => 'cancel_process'
            ]);
            return response()->json([
                "status" => 200 , "message" => "Berhasil Di Cancel"
            ]);
        }else{
            return response()->json([
                "status" => 400 , "message" => "Alasan Cancel Harus Di Isi"
            ],500);
        }
    }
}
