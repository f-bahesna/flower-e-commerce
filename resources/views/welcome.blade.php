@extends('layouts.user.appUser')

@section('title', 'Bunga Homepage')
  <!-- Page Content -->
@section('content')
<div class="container" style="margin-top: 15px;">
    <div class="row">

        <div class="col-lg-3" data-aos="fade-right">
  
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
            <input class="form-control mt-4" data-aos="fade-down" id="tableSearch" type="text"
                placeholder="Cari Kebutuhanmu Disini ...">

          <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active">
                <img class="d-block img-fluid" src="{{ url('storage/carousel/guswin1.jpg') }}" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="{{ url('storage/carousel/guswin2.jpg') }}" alt="Second slide">
              </div>
              <div class="carousel-item">
                <img class="d-block img-fluid" src="{{ url('storage/carousel/guswin3.jpg') }}" alt="Third slide">
              </div>
            </div>
            <a class="carousel-control-prev custom-carousel-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next custom-carousel-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
  
          <div class="row mt-3" id="row-product">
            @foreach($products["data"] as $product)
            <div class="col-lg-4 col-md-6 mb-4 jenis" data-aos="zoom-out-right">
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
          <div class="row">
            <div class="col-md text-right">
              <a class="btn btn-md btn-outline-default btn-rounded btn-lainnya waves-effect rounded" data-aos="fade-left" href="{{ route('product.all') }}">Lainnya</a>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class="container-fluid mt-3 bg-light">
      <div class="row">
          <!--Grid column-->
          <div class="col-md-5 mb-4">
            <div class="card mt-4 ml-4 card-image" data-aos="fade-right" style="background-image: url(https://mdbootstrap.com/img/Photos/Horizontal/City/6-col/img%20%2847%29.jpg);">
                <div class="text-white text-center d-flex align-items-center rgba-black-strong py-5 px-4">
                    <div>
                        <h6 class="green-text"><i class="far fa-eye"></i><strong> Tanaman Hias</strong></h6>
                        <h3 class="card-title py-3 font-weight-bold"><strong>Sanseviera</strong></h3>
                        <p class="pb-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat fugiat, laboriosam, voluptatem,
                            optio vero odio nam sit officia accusamus minus error nisi architecto nulla ipsum dignissimos.
                            Odit sed qui, dolorum!</p>
                        <a href="{{ route('product.all') }}" class="btn btn-success btn-rounded"><i class="far fa-clone left"></i> Lihat Semua Product</a>
                    </div>
                </div>
            </div>
        </div>
        <!--Grid column-->
        <div class="col-md-7 mt-5 mb-5">
            <div class="row mt-5 text-center">
              <div class="col-md-4">
                <i class="fas fa-4x fa-money-bill-wave-alt" data-aos="fade-down-right"></i>
              </div>
              <div class="col-md-4">
                <i class="fas fa-4x fa-percent" data-aos="fade-down"></i>
              </div>
              <div class="col-md-4">
                <i class="fas fa-4x fa-shipping-fast" data-aos="fade-down-left"></i>
              </div>
          </div>
            <div class="row mt-2 text-center">
              <div class="col-md-4">
                <h4 class="font-weight-bold" data-aos="zoom-in-up">Gratis Ongkir</h4>
                <p data-aos="fade-up"
                data-aos-anchor-placement="top-bottom">Nikmati Beragam Gratis Ongkir</p>
              </div>
              <div class="col-md-4">
                <h4 class="font-weight-bold" data-aos="zoom-in-up">Banyak Promo</h4>
                <p data-aos="fade-up"
                data-aos-anchor-placement="top-bottom">Daftar dan Klaim Banyak Kupon</p>
              </div>
              <div class="col-md-4">
                <h4 class="font-weight-bold" data-aos="zoom-in-up">Pemesanan Mudah & Cepat</h4>
                <p data-aos="fade-up"
                data-aos-anchor-placement="top-bottom">Nikmati Pemesanan Mudah dan Cepat di Toko Kami</p>
              </div>
          </div>
        </div>
      </div>
  </div>
    @endsection

