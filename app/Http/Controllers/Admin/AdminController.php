<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Cache;
use App\Http\Model\Product\ModelProduct as product;
use DB;
use File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
       return view('ADMIN.Dashboard.dashboard');
    }

    public function product()
    {
        Cache::forget('products');
        $seconds = now()->addMinutes(10);
        $productsCached = Cache::get('products');
        // dd($productsCached);
        if($productsCached == false){
            $dataProducts = Cache::remember('products', $seconds, function () {
                return DB::table('products')->get();
            });
            return view('ADMIN.Product.product',compact('dataProducts'));
        }else{
            $dataProducts = $productsCached;
            return view('ADMIN.Product.product',compact('dataProducts'));
        }
    }

    public function getDetailProduct($id)
    {
        $prod = DB::table('products')->Where('id',$id)->get();
        $product = $prod[0];
        $image_count = DB::table('additional_product_image')->Where('id_product',$id)->count();
        $additional_image = DB::table('additional_product_image')->Where('id_product',$id)->select('additional_product_image as gambar','number_pic','id_product')->get()->toArray();
        // dd($image_count);
        return view('ADMIN.Product.editProduct',compact('product','additional_image','id','image_count'));
    }


    public function saveEditProduct(Request $request)
    {
        $image = $request->file('gambar-utama');
        if($image){
            //DELETE
            $imagePrev = DB::table('products')->Where('id', $request->product_id)->select('gambar_product')->first();
            $usersImage = public_path("storage/image/{$imagePrev->gambar_product}"); //get previous image from folder
            if(Storage::disk('images')->exists($imagePrev->gambar_product)) { //unlink or remove previous image from folder
                File::delete($usersImage);   
            }

            $name = rand() . '.' . $image->getClientOriginalExtension();
            Storage::disk('images')->put($name, file_get_contents($image -> getRealPath()));
            DB::table('products')->Where('id', $request->product_id)->update([
                "nama_product" => $request->nama_product,
                "gambar_product" => $name,
                "jenis_product" => $request->jenis_product,
                "umur_product" => $request->umur_product,
                "harga_product" => $request->harga_product,
                "stock_product" => $request->stock_product,
                "berat_product" => $request->berat_product,
                "keterangan_product" => $request->keterangan_product,
            ]);
        }else{
            DB::table('products')->Where('id', $request->product_id)->update([
                "nama_product" => $request->nama_product,
                "jenis_product" => $request->jenis_product,
                "umur_product" => $request->umur_product,
                "harga_product" => $request->harga_product,
                "stock_product" => $request->stock_product,
                "berat_product" => $request->berat_product,
                "keterangan_product" => $request->keterangan_product,
            ]);
        }
        Cache::forget('products');
        return redirect('admin/get-products');
    }

    public function simpanGambarLainnya(Request $request)
    {
        $imagePrev = DB::table('additional_product_image')->Where('id_product', $request->product_id)->where('number_pic', $request->number_pic)->select('additional_product_image')->first();
        if($imagePrev){
            $usersImage = public_path("storage".DIRECTORY_SEPARATOR."additional_image".DIRECTORY_SEPARATOR."{$imagePrev->additional_product_image}"); //get previous image from folder
            if(Storage::disk('additional')->exists($imagePrev->additional_product_image)) { //unlink or remove previous image from folder
                File::delete($usersImage);   
            }
            $image = $request->file('image');
            $name = rand() . '.' . $image->getClientOriginalExtension();
            Storage::disk('additional')->put($name, file_get_contents($image->getRealPath()));
            DB::table('additional_product_image')->Where('id_product',$request->product_id)->where('number_pic',$request->number_pic)->update([
                "additional_product_image" => $name
            ]);
    
            return response()->json([
                "status" => 200 ,  "message" => "Berhasil Di Upload!"
            ]);
        }else{
            $image = $request->file('image');
            $name = rand() . '.' . $image->getClientOriginalExtension();
            Storage::disk('additional')->put($name, file_get_contents($image->getRealPath()));
            DB::table('additional_product_image')->insert([
                "additional_product_image" => $name,
                "number_pic" => $request->number_pic,
                "id_product" => $request->product_id
            ]);
    
            return response()->json([
                "status" => 200 ,  "message" => "Berhasil Di Upload!"
            ]);
        } 
    }
   
    public function delete(Request $request)
    {
        if($request->id){
            DB::table('products')->where('id',$request->id)->delete();
    
            return response()->json([
                "status" => 200 , "message" => "Berhasil Dihapus"
            ]);
        }else{
            return response()->json([
                "status" => 400 , "message" => "gagal"
            ],500);
        }
    }

    public function changePublish(Request $request)
    {
        switch($request->status){
            case 'draft':
                DB::table('products')->where('id',$request->product_id)->update([
                    "status_product" => 'drafted'
                ]);
                return response()->json([
                    "status" => 200 ,"message" => 'Product Drafted', "btn" => 'Drafted'
                ]);
            break;
            case 'publish':
                DB::table('products')->where('id',$request->product_id)->update([
                    "status_product" => 'published'
                ]);
                return response()->json([
                    "status" => 200 ,"message" => 'Product Published', "btn" => 'Published'
                ]);
            break;
        }
    }

}
