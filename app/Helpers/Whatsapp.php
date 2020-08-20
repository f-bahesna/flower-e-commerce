<?php

function sendWhatsappMessage($nomor , $message)
{
    // dd([$nomor, $message]);
    $curl = curl_init();
    $token = env('FONNTE_TOKEN');
    $pesan = $message; //pesannya
    $target = preg_replace('/^0/','62',$nomor);
    $data = [
        'phone' => $target,
        'type' => 'text',
        // 'delay' => 2, // delay 2 detik (optional)
        // 'delay_req' => 2, // delay 2 detik setiap request (optional)
        // 'schedule' => 1591717520 (optional)
        'text' => $pesan
    ];
    //nomer target gunakan 628
    //gunakan koma " , " untuk multi nomer 6283xxxx,6281xxxxx
    
    curl_setopt($curl, CURLOPT_HTTPHEADER,
        array(
            "Authorization: $token"
        ));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_URL, env('FONNTE_URL'));
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($curl);
    curl_close($curl);
    
    return $result;

}

function sendWhatsappFile($nomor)
{

}