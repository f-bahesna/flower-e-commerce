@extends('layouts.user.appUser')

@section('title', 'Product Detail')
  <!-- Page Content -->
@section('content')
<div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header text-center">
              <h3>{{ $result["nama_product"] }}</h3>
            </div>
          </div>
          {{-- <img src="{{ url('storage/image/'.$result["gambar_product"]) }}" class="mt-3" height="300px" weight="300px" alt=""> --}}
          <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active" data-interval="10000">
                <img src="{{ url('storage/image/'.$result["gambar_product"]) }}" class="d-block w-100" height="400px" alt="...">
              </div>
              @if($additional_image != null)
                @foreach($additional_image as $key => $value)
                  <div class="carousel-item" data-interval="2000">
                    <img src="{{ url('storage/image/'. $value->additional_product_image ) }}" class="d-block w-100" height="400px" alt="...">
                  </div>
                @endforeach
              @endif
            </div>
            <a class="carousel-control-prev carousel-part" href="#carouselExampleInterval" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next carousel-part" href="#carouselExampleInterval" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header justify-content-center">
              Deskripsi Product 
            </div>
            <div class="card-body">
              <h4 class="font-weight-bold"> RP. {{ number_format($result["harga_product"],0,',','.') }}</h4>
              <hr/>
              <h6>Umur : {{ $result["umur_product"] }} Bulan</h6>
              <h6>Jenis : {{ $result["jenis_product"] }}</h6>
            </div>
            <div class="row float-right">
              <div class="col-md">
                <input type="hidden" value="{{ $result["id"] }}" id="product">
                  @if(Auth::check())
                    <button type="button" class="btn btn-warning btn-rounded float-right btn-masukan-keranjang">+Masukan Keranjang</button>
                    <button type="button" class="btn btn-success btn-rounded float-right btn-beli-langsung">Beli Langsung</button>
                  @else 
                    <button type="button" class="btn btn-warning btn-rounded float-right disabled">+Masukan Keranjang</button>
                    <button type="button" class="btn btn-success btn-rounded float-right btn-beli-langsung">Beli Langsung</button>
                  @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="card">
          <div class="card-body">
            <h5>{{ $result["keterangan_product"] }}</h5>
          </div>
          <div class="card-footer mt-2">
            <p>Product Di Update {{ $result["created_at"] }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

