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
               DB::table('products')->where('id', $request->product_id)->decrement('stock_product', $request->qty);
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
            //Not Pay Yet
            $searchOrder = DB::table('orders_manual as om')
                ->Join('products as p','om.product_id','=','p.id')
                ->where('om.nomor_telephone', $request->nomor_telephone)
                ->select('om.*','p.nama_product as nama_product','om.nomor_telephone as nomor_telephone','om.status as status','om.courier_price as ongkir')
                ->first(); 
            //Jika nomor telephone tidak ada
            if($searchOrder === null || $searchOrder->status === 'canceled'){
                return response()->json([
                    "status" => 400 , "message" => "Data Order Tidak Ditemukan" , "data" => ""
                ],500);
            }

            //Check If user has been pay
            $addPaymentConfirmation = DB::table('orders_manual as om')
                ->Join('products as p','om.product_id','=','p.id')
                ->Join('payment_confirmation as pc','om.nomor_telephone','=','pc.nomor_telephone')
                ->where('om.nomor_telephone', $request->nomor_telephone)
                ->select('om.*','p.nama_product as nama_product','pc.image as image','om.nomor_telephone as nomor_telephone','om.courier_price as ongkir')
                ->first();

            if($addPaymentConfirmation === null){
                $layout =' 
                <div class="card" style="min-height: 200px">
                    <div class="card-header">
                        <p class="text-muted">Kode Pesanan :'.$searchOrder->order_code.'</p>
                        <h4 class="font-weight-bold">Status : <badge class="bg-success rounded p-1 mb-2">'.ucfirst($searchOrder->status).'</badge></h4>
                        <span class="text-warning">Anda Belum Mengupload Bukti Pembayaran ...</span>
                    </div>
                    <div class="row ml-2">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <img class="border mt-2" src="" height="300" width="300" alt="">
                            <li class="list-group-item">Product Yang Dipesan: <p class="font-weight-bold">'. $searchOrder->nama_product .'</p></li>
                            <li class="list-group-item">Nomor Telephone :<p class="font-weight-bold">'.$searchOrder->nomor_telephone.'</p></li>
                            <li class="list-group-item">Quantity: <p class="font-weight-bold">'.$searchOrder->qty.'</p></li>
                            <li class="list-group-item">Kurir : '.strtoupper($searchOrder->courier) .' <p class="text-info">'.$searchOrder->courier_service.'</p></li>
                            <li class="list-group-item">Ongkir :Rp.'.number_format($searchOrder->ongkir,0,',','.').' </li>
                            <li class="list-group-item">Total : <p class="font-weight-bold">Rp.'.number_format($searchOrder->total_price,0,',','.').'</p></li>
                            <li class="list-group-item">Alamat : <p class="">'. $searchOrder->address.'</p></li>
                            <li class="list-group-item">Provinsi : <p class="">'.$searchOrder->province.'</p></li>
                            <li class="list-group-item">Kota : <p class="">'.$searchOrder->city.'</p></li>
                        </ul>
                    </div>
                    </div>
                        <h6 class="text-danger ml2">*Anda Dapat Membatalkan Pesanan Jika Status Pesanan Dalam Proses <u class="text-success text-center">Verification</u> </h6>
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm">Batalkan Pesanan</button>
                    </div>
                ';

                return response()->json([
                    "status" => 200 , "message" => "Data Order Ditemukan" , "data" => $layout , "status" => $searchOrder->status
                ]);
            }else{
                $layout = ' 
                <div class="card" style="min-height: 200px">
                    <div class="card-header">
                        <p class="text-muted">Kode Pesanan :'.$addPaymentConfirmation->order_code.'</p>
                        <h4 class="font-weight-bold">Status : <badge class="bg-success rounded p-1 mb-2">'.ucfirst($addPaymentConfirmation->status).'</badge></h4>
                        <textarea disabled name="" id="notes-for-user-declined" cols="40" rows="3" class="border border-warning">'.$addPaymentConfirmation->notes.'</textarea>
                    </div>
                    <div class="row ml-2">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <img class="border mt-2" src="'. asset('images/paymentConfirmation/'.$addPaymentConfirmation->image).'" height="300" width="300" alt="">
                            <li class="list-group-item">Product Yang Dipesan: <p class="font-weight-bold">'. $addPaymentConfirmation->nama_product .'</p></li>
                            <li class="list-group-item">Nomor Telephone :<p class="font-weight-bold">'.$addPaymentConfirmation->nomor_telephone.'</p></li>
                            <li class="list-group-item">Quantity: <p class="font-weight-bold">'.$addPaymentConfirmation->qty.'</p></li>
                            <li class="list-group-item">Kurir : '.strtoupper($addPaymentConfirmation->courier) .' <p class="text-info">'.$addPaymentConfirmation->courier_service.'</p></li>
                            <li class="list-group-item">Ongkir :Rp.'.number_format($searchOrder->ongkir,0,',','.').' </li>
                            <li class="list-group-item">Total : <p class="font-weight-bold">Rp.'.number_format($addPaymentConfirmation->total_price,0,',','.').'</p></li>
                            <li class="list-group-item">Alamat : <p class="">'. $addPaymentConfirmation->address.'</p></li>
                            <li class="list-group-item">Provinsi : <p class="">'.$addPaymentConfirmation->province.'</p></li>
                            <li class="list-group-item">Kota : <p class="">'.$addPaymentConfirmation->city.'</p></li>
                        </ul>
                    </div>
                    </div>
                        <h6 class="text-danger ml-2">*Anda Dapat Membatalkan Pesanan Jika Status Pesanan Dalam Proses <u class="text-success text-center">Verification</u> </h6>
                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm">Batalkan Pesanan</button>
                    </div>
                ';

                return response()->json([
                    "status" => 200 , "message" => "Data Order Ditemukan" , "data" => $layout , "status" => $searchOrder->status
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
        // $checkNumber = DB::table('payment_confirmation')->where('nomor_telephone', $request->nomor)->first();
        $checkOrderStatus = DB::table('orders_manual')->where('nomor_telephone', $request->nomor)->first();

        //Check If Orders manual have status CANCEL_PROCESS
        if($checkOrderStatus->status === 'waiting'){
            return response()->json([
                "message" => "Pesananmu Dalam Persetujuan Cancel Oleh Admin"
            ],500);
        }
        if($checkOrderStatus->status === 'cancel_process'){
            $image = $request->file('image');
            $name = rand(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/paymentConfirmation'), $name);
                DB::beginTransaction();
                    DB::table('payment_confirmation')->update([
                        "nomor_telephone" => $request->nomor,
                        "image" => $name,
                        "created_at" => $this->date
                    ]);
                    DB::table('orders_manual')->where('nomor_telephone', $request->nomor)->update([
                        "status" => "waiting"
                    ]);
                DB::commit();
            return response()->json([
                'message'   => 'Upload Image Sukses',
            ]);
        }

        //If User Already upload the Payment Confirmation
        // if($checkNumber){
        //     return response()->json([
        //         "message" => "Pesananmu Sedang Dalam Antrian, Mohon Cek Status Pesanan Secara Berkala"
        //     ]);
        // }

        $validation = Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nomor' => 'required|max:17'
        ]);

        if($validation->passes()){
            $image = $request->file('image');
            $name = rand(). '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/paymentConfirmation'), $name);
                DB::beginTransaction();
                    DB::table('payment_confirmation')->insert([
                        "nomor_telephone" => $request->nomor,
                        "image" => $name,
                        "created_at" => $this->date
                    ]);
                    DB::table('orders_manual')->where('nomor_telephone', $request->nomor)->update([
                        "status" => "waiting"
                    ]);
                DB::commit();
            return response()->json([
                'message'   => 'Upload Image Sukses',
            ]);
        }else{
            DB::rollback();
            return response()->json([
                'message'   => $validation->errors()->all(),
            ],500);
        }  
    }

    public function cancelOrder(Request $request)
    {
        $checkStatus =  DB::table('orders_manual')->where('nomor_telephone',$request->nomor_telephone)->first();
        if($checkStatus->status !== 'verification'){
            return response()->json([
                "message" => "Pesanan Tidak Dapat Dibatalkan Atau Dalam Proses Pembatalan"
            ],500); 
        }    

        $validation = Validator::make($request->all(),[
            "alasan" => 'required|max:30',
            "nomor_telephone" => 'required'
        ]);

        if($validation->passes()){
            DB::table('orders_manual')->where('nomor_telephone', $request->nomor_telephone)->update([
                "notes" => $request->alasan,
                "status" => "cancel_process"
            ]);

            return response()->json([
                "message" => "Pesanan Berhasil Dibatalkan"
            ]);  
        }else{
            if($validation->errors()->all()[0] == 'The alasan field is required.'){
                return response()->json([
                    'message'   => "Alasan Anda Membatalkan Pesanan?",
                ],500);
            }
        }
    }
}
