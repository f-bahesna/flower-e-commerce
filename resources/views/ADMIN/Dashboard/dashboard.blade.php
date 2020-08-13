@extends('layouts.admin.appAdmin')
@section('title','Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-4 mt-4">
          <a href="{{ route('order') }}">
            <div class="card bg-success">
                <div class="card-body text-center">
                <i class="fas fa-3x fa-cart-arrow-down"></i>
                  <h4 class="card-text text-dark">Pesanan Baru</h4>
                </div>
            </div>
          </a>
        </div>
        <div class="col-md-4 mt-4">
          <a href="{{ route('get.products') }}">
            <div class="card bg-success" id="btn-product">
                <div class="card-body text-center">
                <i class="fas fa-dark fa-3x fa-align-justify"></i>
                  <h4 class="card-text text-dark">Produk</h4>
                </div>
            </div>
          </a>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card bg-success">
                <div class="card-body text-center">
                    <i class="fas fa-3x fa-user-plus"></i>
                  <h4 class="card-text">Pelanggan</h4>
                </div>
              </div>
        </div>
        {{-- <div class="col-md-4 mt-4">
            <div class="card bg-success">
                <div class="card-body text-center">
                  <p class="card-text">Some text inside the third card</p>
                </div>
              </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card bg-success">
                <div class="card-body text-center">
                  <p class="card-text">Some text inside the third card</p>
                </div>
              </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card bg-success">
                <div class="card-body text-center">
                  <p class="card-text">Some text inside the third card</p>
                </div>
              </div>
        </div> --}}
    </div>
@endsection