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
        if($request->all()){
            $url = env('APP_URL') ."/payments/index";
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
                   "courier_price" => "required",
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
               $char = "ORD";
               $kodeBarang = $char .date('d')."M".$request->nomor_telephone;
            
               DB::table('orders_manual')->insert([
                   "order_code" => $kodeBarang,
                   "nomor_telepon" => $request->nomor_telephone,
                   "address" => $request->address,
                   "province" => $request->province,
                   "city" => $request->city,
                   "courier" => $request->courier,
                   "courier_service" => $request->courier_service,
                   "courier_price" => $request->courier_price,
                   "product_id" => intval($request->product_id),
                   "qty" => $request->qty,
                   "total_price" => intval($total_price),
                   "status" => "verification",
                   "notes" => $request->notes
               ]);
               DB::commit();
               
               createLog($request->product_id ,$request->nomor_telephone,"Memesan");
         
               return response()->json([
                   "status" => 200 , "url" => $url
               ]);
   
   
           } catch (\Exception $ex) {
               DB::rollback();
               return response()->json([
                   "status" => 400 ,  "message" => $ex
               ],500);
           }    
       }else{
            return response()->json([
                "status" => 400 ,  "message" => "error, Mohon Hubungi Admin"
            ],500);
       }
    }

    public function checkOrderManual(Request $request)
    {
        if($request->ajax()){
            $searchOrder = DB::table('orders_manual as om')
            ->Join('products as p','om.product_id','=','p.id')
            ->where('nomor_telepon', $request->nomor_telephone)
            ->select('om.*','p.nama_product as nama_product')
            ->first();
            $layout = ' 
                    <div class="card" style="min-height: 200px">
                        <div class="card-header">
                            <p class="text-muted">Kode Pesanan :'.$searchOrder->order_code.'</p>
                        </div>
                        <div class="row ml-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Product Yang Dipesan: <p class="font-weight-bold">'. $searchOrder->nama_product .'</p></li>
                                <li class="list-group-item">Nomor Telephone :<p class="font-weight-bold">'.$searchOrder->nomor_telepon.'</p></li>
                                <li class="list-group-item">Quantity: <p class="font-weight-bold">'.$searchOrder->qty.'</p></li>
                                <li class="list-group-item">Kurir : '.strtoupper($searchOrder->courier) .' <p class="text-info">'.$searchOrder->courier_service.'</p></li>
                                <li class="list-group-item">Total : <p class="font-weight-bold">Rp.'.number_format($searchOrder->total_price,0,',','.').'</p></li>
                            </ul>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Status : <p class="font-weight-bold bg-success rounded p-1 mb-2">'.ucfirst($searchOrder->status).'</p></li>
                                <li class="list-group-item">Alamat : <p class="font-weight-bold">'. $searchOrder->address.'</p></li>
                                <li class="list-group-item">Provinsi : <p class="font-weight-bold">'.$searchOrder->province.'</p></li>
                                <li class="list-group-item">Kota : <p class="font-weight-bold">'.$searchOrder->city.'</p></li>
                            </ul>
                        </div>
                            <button class="btn btn-lg btn-warning btn-check-pesanan">Cari</button>
                        </div>
                    ';

            if($searchOrder){
                return response()->json([
                    "status" => 200 , "message" => "Data Order Ditemukan" , "data" => $layout
                ]);
            }else{
                return response()->json([
                    "status" => 400 , "message" => "Data Order Tidak Ditemukan" , "data" => ""
                ]);
            }
        }
    }
}
