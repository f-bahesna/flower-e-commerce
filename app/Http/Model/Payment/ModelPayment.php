<?php

namespace App\Http\Model\Payment;

use Illuminate\Database\Eloquent\Model;
use DB;

class ModelPayment extends Model
{
    public function getProductAddedInCartByUser($user_id)
    {
        return DB::table('carts as c')
        ->Join('users as u','c.id_user','=','u.id')
        ->Join('products as p','c.id_product','=','p.id')
        ->select(
            'p.gambar_product as gambar_product',
            'p.nama_product as nama_product',
            'p.harga_product as harga_product',
            'c.total as total',
            'c.id_user as user_id'
        )->where('id_user',$user_id)->paginate(4);
    }

    public function getTotalValueByUserId($user_id)
    {
        return DB::table('carts as c')->where('id_user',$user_id)
            ->Join('products as p','c.id_product','=','p.id')
            ->select('p.harga_product as harga_product','c.total as total')->get();
    }
}
