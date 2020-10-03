<?php

namespace App\Http\Model\Product;
use DB;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    protected $guarded = [];

    public function getCardAdded($user_id)
    {
        return  DB::table('carts as c')
                        ->Join('users as u','c.id_user','=','u.id')
                        ->Join('products as p','c.id_product','=','p.id')
                        ->select(
                            'p.gambar_product as gambar_product',
                            'p.nama_product as nama_product',
                            'p.harga_product as harga_product',
                            'c.total as total',
                            'c.id_user as user_id'
                        )
            ->where('id_user',$user_id)->paginate(4);
    }
}
