@extends('layouts.admin.appAdmin')

@section('title','Edit Product')

@section('content')
    <div class="card shadow-lg p-3 mb-5 bg-white rounded">
        <div class="card-body">
            <form method="POST" action="{{ route('save.edit.product') }}" enctype="multipart/form-data">
                @csrf
                <div class="row alert-gambar-lainnya">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_product">Nama Product</label>
                            <input type="text" class="form-control" id="nama_product" name="nama_product"  placeholder="{{ $product->nama_product }}" value="{{ $product->nama_product }}">
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" id="product-id" name="product_id" value="{{ $product->id }}">
                                    <label for="jenis_product">Jenis</label>
                                    <input type="text" class="form-control" id="jenis_product" name="jenis_product"  placeholder="{{ $product->jenis_product }}" value="{{ $product->jenis_product }}">
                                  </div>
                                  <div class="form-group">
                                    <label for="harga_product">Harga</label>
                                    <input type="text" class="form-control" id="harga_product" name="harga_product"  placeholder="{{ $product->harga_product }}" value="{{ $product->harga_product }}">
                                  </div>
                                  <div class="form-group">
                                    <label for="berat_product">Berat</label>
                                    <input type="text" class="form-control" id="berat_product" name="berat_product"  placeholder="{{ $product->berat_product }}" value="{{ $product->berat_product }}">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="umur_product">Umur</label>
                                    <input type="text" class="form-control" id="umur_product" name="umur_product"  placeholder="{{ $product->umur_product }}" value="{{ $product->umur_product }}">
                                  </div>
                                <div class="form-group">
                                    <label for="stock_product">Stock</label>
                                    <input type="text" class="form-control" id="stock_product" name="stock_product"  placeholder="{{ $product->stock_product }}" value="{{ $product->stock_product }}">
                                </div>
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan_product" rows="3">{{ $product->keterangan_product }}</textarea>
                          </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card p-2 shadow p-3 mb-5 bg-white rounded rounded">
                                    <h6 for="nama_product" class="text-weight-bold">Gambar Utama</h6>
                                    <div class="form-group">
                                        <img class="bordered rounded img-gambar-utama" src="{{ asset('images/image/'.$product->gambar_product) }}" height="150" width="150" alt="">
                                        <input type="file" name="gambar-utama" class=" btn-warning mt-3 mr-3 gambar-utama">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 border bg-light rounded gambar_lainnya">
                                <h6 for="nama_product" class="text-weight-bold">Gambar Lainnya</h6>
                                <p class="text-danger">*Setelah memilih untuk mengedit gambar,Mohon Untuk Menyimpan Gambar Lainnnya terlebih dahulu</p>
                                <p class="text-danger">*Setelah gambar tersimpan maka otomatis gambar di simpan di Database</p>
                                @if($image_count > 3)
                                    @foreach($additional_image as $item)
                                        <div class="form-group">
                                            <img class="bordered rounded" src="{{ asset('images/additional_image/'.$item->gambar) }}" height="150" width="150" alt="">
                                            <input type="file" name="gambar-lainnya[]" class="btn btn-sm btn-warning mt-3 gambar-lainnya">
                                            <input type="hidden" class="product_id" name="product_id" value="{{ $item->id_product }}">
                                            <input type="hidden" class="number_pic" name="number_pic" value="{{ $item->number_pic }}">
                                            {{-- 1 --}}
                                        </div>
                                        {{-- input append in here --}}
                                    @endforeach
                                @else  
                                    <div class="form-group">
                                        <img class="bordered rounded" src="{{ isset($additional_image[0]->gambar) ? asset('images/additional_image/'.$additional_image[0]->gambar) : "#" }}" height="150" width="150" alt="" placeholder="Image">
                                        <input type="file" name="gambar-lainnya[]" class="btn btn-sm btn-warning mt-3 gambar-lainnya">
                                        <input type="hidden" class="product_id" name="product_id" value="{{ $id }}">
                                        <input type="hidden" class="number_pic" name="number_pic" value="1">
                                        {{-- 1 --}}
                                    </div>
                                    <div class="form-group">
                                        <img class="bordered rounded" src="{{ isset($additional_image[1]->gambar) ? asset('images/additional_image/'.$additional_image[1]->gambar) : "#" }}" height="150" width="150" alt="" placeholder="Image">
                                        <input type="file" name="gambar-lainnya[]" class="btn btn-sm btn-warning mt-3 gambar-lainnya">
                                        <input type="hidden" class="product_id" name="product_id" value="{{ $id }}">
                                        <input type="hidden" class="number_pic" name="number_pic" value="2">
                                        {{-- 1 --}}
                                    </div>
                                    <div class="form-group">
                                        <img class="bordered rounded" src="{{ isset($additional_image[2]->gambar) ? asset('images/additional_image/'.$additional_image[2]->gambar) : "#" }}" height="150" width="150" alt="" placeholder="Image">
                                        <input type="file" name="gambar-lainnya[]" class="btn btn-sm btn-warning mt-3 gambar-lainnya">
                                        <input type="hidden" class="product_id" name="product_id" value="{{ $id }}">
                                        <input type="hidden" class="number_pic" name="number_pic" value="3">
                                        {{-- 1 --}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success btn-lg mt-2 btn-save-edit justify-content-center">Save</button>
                    </div>
                    <div class="col-md-1">
                        <a href="{{ route('get.products') }}" class="btn mt-2 btn-danger btn-lg">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection