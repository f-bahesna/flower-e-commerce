@extends('layouts.user.appUser')

@section('title', 'Bunga Homepage')
  <!-- Page Content -->
@section('content')
<div class="container" style="margin-top: 15px;">
    <div class="row">

        <div class="col-lg-3">
          <h4 class="my-4 text-center categories-title">Kategori</h4>
          <div class="list-group my-4 categories-list">
            @foreach($jenis as $key => $value)
              <input type="hidden" class="jenis_product" value="{{ $value->jenis_product }}">
              <a href="#" class="list-group-item categories-list-a">{{ ucfirst($value->jenis_product) }}</a>
            @endforeach
          </div>
  
  
        </div>
        <!-- /.col-lg-3 -->
  
        <div class="col-lg-9">
            <input class="form-control mt-4" id="tableSearch" type="text"
                placeholder="Cari Kebutuhanmu Disini ...">
  
          <div class="row mt-3" id="row-product">
            @foreach($products["data"] as $product)
            <div class="col-lg-4 col-md-6 mb-4 .jenis">
              <div class="card h-100">
                <a href="{{ route('product.detail',["id" => $product["id"]]) }}"><img class="card-img-top" src="{{ url('storage/image/'.$product["gambar_product"]) }}" style="height: 200px" alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="{{ route('product.detail',["id" => $product["id"]]) }}">{{ $product["nama_product"] }}</a>
                  </h4>
                  <h6>{{ "Rp " . number_format($product["harga_product"],2,',','.') }}</h6>
                </div>
                <div class="card-footer">
                  <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
    </div>
    </div>
    @endsection

