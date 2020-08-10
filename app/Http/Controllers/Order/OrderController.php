<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct()
    {
        setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
        // date_default_timezone_set('Asia/Jakarta');
        $this->date = strftime( "%A, %d %B %Y %H:%M", time());
    }

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
                   "nomor_telephone" => "required|regex:[A-Za-z1-9 ]|size:20",
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
                   "nomor_telephone.required" => "Nomor Telepon Harus Diisi,Karena untuk validasi order.",
                   "province.required" => "Harus Pilih Provinsi Dulu",
                   "city.required" => "Harus Pilih Kota atau Kabupaten",
                   "courier_service" => "Harus Pilih Service Kurir",
               ]);
   
               $countQtyAndProductPrice = $request->harga * $request->qty;
               $total_price = $countQtyAndProductPrice + $request->courier_price;
               DB::beginTransaction();
               $char = "ORD";
               $kodeBarang = $char .date('d')."M".$request->nomor_telephone;
            
               DB::table('orders_manual')->insert([
                   "order_code" => $kodeBarang,
                   "nomor_telephone" => $request->nomor_telephone,
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
            ->Join('payment_confirmation as pc','om.nomor_telephone','=','pc.nomor_telephone')
            ->where('om.nomor_telephone', $request->nomor_telephone)
            ->select('om.*','p.nama_product as nama_product','pc.image as image')
            ->first();
            
            $layout = ' 
                    <div class="card" style="min-height: 200px">
                        <div class="card-header">
                            <p class="text-muted">Kode Pesanan :'.$searchOrder->order_code.'</p>
                            <h4 class="font-weight-bold">Status : <badge class="bg-success rounded p-1 mb-2">'.ucfirst($searchOrder->status).'</badge></h4>
                        </div>
                        <div class="row ml-2">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <img class="border mt-2" src="'. asset('storage/paymentConfirmation/'.$searchOrder->image).'" height="300" width="300" alt="">
                                <li class="list-group-item">Product Yang Dipesan: <p class="font-weight-bold">'. $searchOrder->nama_product .'</p></li>
                                <li class="list-group-item">Nomor Telephone :<p class="font-weight-bold">'.$searchOrder->nomor_telephone.'</p></li>
                                <li class="list-group-item">Quantity: <p class="font-weight-bold">'.$searchOrder->qty.'</p></li>
                                <li class="list-group-item">Kurir : '.strtoupper($searchOrder->courier) .' <p class="text-info">'.$searchOrder->courier_service.'</p></li>
                                <li class="list-group-item">Total : <p class="font-weight-bold">Rp.'.number_format($searchOrder->total_price,0,',','.').'</p></li>
                            </ul>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Alamat : <p class="font-weight-bold">'. $searchOrder->address.'</p></li>
                                <li class="list-group-item">Provinsi : <p class="font-weight-bold">'.$searchOrder->province.'</p></li>
                                <li class="list-group-item">Kota : <p class="font-weight-bold">'.$searchOrder->city.'</p></li>
                            </ul>
                        </div>
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

    public function checkNumber(Request $request)
    {
        $checkPhoneNumber = DB::table('orders_manual')->where('nomor_telephone',$request->nomor_telephone)->first();
        if($checkPhoneNumber != null){
            return response()->json([
                "status" => 200 , "message" => "Phone Number Found"
            ]);
        }else{
            return response()->json([
                "status" => 500 , "message" => "Phone Number Not Found"
            ],500);
        }
    }
    public function uploadPaymentConfirmation(Request $request)
    {

        $validation = Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nomor' => 'required'
        ]);

        if($validation->passes()){
            $image = $request->file('image');
            $name = rand(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/paymentConfirmation'), $name);
                DB::beginTransaction();
                    DB::table('payment_confirmation')->insert([
                        "nomor_telephone" => $request->nomor,
                        "image" => $name,
                        "created_at" => $this->date
                    ]);
                DB::commit();
            return response()->json([
                'message'   => 'Image Upload Successfully',
            ]);
        }else{
            DB::rollback();
            return response()->json([
                'message'   => $validation->errors()->all(),
            ],500);
        }  
    }
}
