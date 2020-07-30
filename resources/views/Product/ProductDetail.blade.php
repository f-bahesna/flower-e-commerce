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
          <img src="{{ url('storage/image/'.$result["gambar_product"]) }}" class="mt-3" height="300px" weight="300px" alt="">
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header justify-content-center">
              Deskripsi Product 
            </div>
            <div class="card-body">
              <h5>Umur : {{ $result["umur_product"] }} Bulan</h5>
              <h5>Jenis : {{ $result["jenis_product"] }}</h5>
              <h5>Harga : RP. {{ number_format($result["harga_product"],0,',','.') }}</h5>
            </div>
            <div class="row float-right">
              <div class="col-md">
                <button type="button" class="btn btn-warning btn-rounded float-right">+Masukan Keranjang</button>
                <button type="button" class="btn btn-success btn-rounded float-right">Beli Langsung</button>
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

