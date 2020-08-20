<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SendWhatsapp extends Controller
{

    public function index()
    {
        return view('ADMIN.settings.message');
    }

    public function send(Request $request)
    {
        $output = sendWhatsappMessage($request->nomor , $request->message);
        $res = json_decode($output);
        if($res->status == 'true'){
            return response()->json([
                "status" => 200 , "message" => "Berhasil Mengirim Pesan"
            ]);
        }else{
            return response()->json([
                "status" => 400 , "message" => json_decode($output)
            ],500);
        }
    }
}
