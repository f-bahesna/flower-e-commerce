@extends('layouts.user.appCart')
@section('title','KERANJANG KAMU')

@section('content')
<div class="row row-cart mt-2 mb-3">
    <div class="col-lg-8">
        @foreach($carts as $key => $value)
        <input type="hidden" class="id_product" value="{{ $value->id_product }}">
        <div class="row bg-light p-1 rounded mb-3 border">
            <div class="col-md-2">
                <img height="100" width="100" class="img-thumbnail img-cart-details" src="{{ url('storage/image/'.$value->gambar_product) }}" alt="">
            </div>
            <div class="navbar-text col-md-3 mt-4 title-cart-details">
                @if (strlen($value->nama_product) > 15)
                    <h5>{{ substr($value->nama_product, 0, 14) . '...' }}</h5>
                @else
                    <h5>{{ $value->nama_product }}</h5>
                @endif
            </div>
            <div class="navbar-text col-md-2 mt-4 jenis-cart-details">
                <h5>Bunga</h5>
            </div>
            <div class="col-md-2 mt-4 qty-cart-details">
                <div class="row">
                    {{-- <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"><i class="fas fa-minus"></i></button> --}}
                        <input class="quantity form-control ml-5 qty-cart text-center" min="0" name="quantity" value="{{ $value->total }}" type="number">
                    {{-- <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"><i class="fas fa-plus"></i></button> --}}
                </div>
            </div>
                <div class="col-md-2 mt-4 navbar-text total-cart-details"><h5>RP.{{ number_format($total[$key],0,',','.') }}</h5></div>
                <div class="col-md-1 mt-4 navbar-text">
                    <i class="far float-right mt-2 trash-cart-details fa-1x fa-trash-alt"></i>
                </div>
        </div>
        @endforeach
    </div>
        <div class="col-lg-4 pembayaran-section">
            <div class="card">
                <div class="card-header">
                    <h4>Rincian</h4>
                </div>
                <div class="card-body">
                    <h5>Voucher : <h4>-</h4></h5>
                    <h5>Discount: <h4>20%</h4></h5>
                    <h5>Subtotal: <h3 class="text-success subTotal">RP {{ number_format($subTotal,0,',','.') }}</h3><span><i class="fas fa-shipping-fast"></i> Free Ongkir</span></h5>
                    <div class="dropdown-divider"></div>
                </div>
                <div class="p-1 mt-2 bg-warning btn-pembayaran">
                    <h2 class="text-center btn-pembayaran-child font-weight-bold p-3">PEMBAYARAN</h2>
                </div>
            </div>
        </div>
</div>
<div class="row">
    <div class="card">
        <div class="card-body">

        </div>
    </div>
</div>
@endsection

