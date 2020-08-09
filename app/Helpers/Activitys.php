<?php

function createLog($product,$user,$message)
{ 
    setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
    // date_default_timezone_set('Asia/Jakarta');
    $date = strftime( "%A, %d %B %Y %H:%M", time());

    DB::table('activitys')
    ->insert([
        "id_product" => $product,
        "id_user" => $user,
        "pesan_log" => $message,
        "created_at" => $date
    ]);
}