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
              <a href="{{ route('search-welcome-categories',['jenis' => $value->jenis_product]) }}" class="list-group-item search-welcome-categories">{{ ucfirst($value->jenis_product) }}</a>
            @endforeach
          </div>
  
        </div>
        {{-- CAROUSEL --}}
        <div class="col-lg-9">
            {{-- <input class="form-control mt-4" data-aos="fade-down" id="tableSearchWelcome" type="text"
                placeholder="Cari Kebutuhanmu Disini ..."> --}}
          <div data-aos="fade-left" id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
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
        </div>
        {{-- END CAROUSEL --}}
    </div>
  </div>

  <div class="container-fluid mt-3 bg-light">

  {{-- KEUNGGULAN --}}
      <div class="row">
          <div class="col-md-5 mb-4" data-aos="fade-right">
            <div class="card mt-4 ml-4 card-image card-intro-image" data-aos="fade-right">
            {{-- <div class="card mt-4 ml-4 card-image" data-aos="fade-right" style="background-image: {{ public_path('/storage/image_intro/img.jpg') }}"> --}}
                <div class="text-white text-center d-flex align-items-center rgba-black-strong py-5 px-4">
                    <div>
                        <h6 class="green-text"><i class="far fa-eye"></i><strong> Tanaman Hias</strong></h6>
                        <h3 class="card-title py-3 font-weight-bold"><strong>Sanseviera</strong></h3>
                        <p class="pb-3">Sanseviera tak hanya sebagai tanaman hias, tapi juga memiliki manfaat untuk menyuburkan rambut, mengobati diabetes, wasir, hingga kanker ganas. 
                          Sementara seratnya digunakan sebagai bahan pakaian. <br/>
                          Di Jepang, Sanseviera digunakan untuk menghilangkan bau perabotan rumah di ruangan</p>
                            <a href="https://id.wikipedia.org/wiki/Sansevieria">https://id.wikipedia.org/wiki/Sansevieria</a>
                        <a href="{{ route('product.all') }}" class="btn btn-success btn-rounded"><i class="far fa-clone left"></i> Lihat Semua Product</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 mt-5 mb-5">
            <div class="row mt-5 text-center">
              <div class="col-md-4 mt-5">
                <i class="fas fa-4x fa-money-bill-wave-alt" data-aos="fade-down-right"></i>
                  <h4 class="font-weight-bold mt-2" data-aos="zoom-in-up">Gratis Ongkir</h4>
                  <p data-aos="fade-up"
                  data-aos-anchor-placement="top-bottom">Nikmati Beragam Gratis Ongkir</p>
              </div>
              <div class="col-md-4 mt-5">
                <i class="fas fa-4x fa-percent" data-aos="fade-down"></i>
                  <h4 class="font-weight-bold mt-2" data-aos="zoom-in-up">Banyak Promo</h4>
                  <p data-aos="fade-up"
                  data-aos-anchor-placement="top-bottom">Daftar dan Klaim Banyak Kupon</p>
              </div>
              <div class="col-md-4 mt-5">
                <i class="fas fa-4x fa-shipping-fast" data-aos="fade-down-left"></i>
                  <h4 class="font-weight-bold mt-2" data-aos="zoom-in-up">Pemesanan Mudah & Cepat</h4>
                <p data-aos="fade-up"
                data-aos-anchor-placement="top-bottom">Nikmati Pemesanan Mudah dan Cepat di Toko Kami</p>
              </div>
            </div>
        </div>
      </div>
  </div>
{{-- END KEUNGGULAN --}}


{{-- PRODUCTS --}}
  <div class="container-fluid bg-white">
    <div class="row">
      <div class="col-md-8 offset-2 offset-1">
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
            <div class="col-md text-center">
              <a class="btn btn-lg btn-outline-default btn-rounded btn-lainnya waves-effect rounded" data-aos="fade-left" href="{{ route('product.all') }}">Lainnya</a>
            </div>
          </div>
      </div>
    </div>
  </div>
{{-- END PRODUCTS --}}

{{-- TESTIMONIALS --}}
  <div class="container-fluid bg-light" data-aos="fade-up">
      <div id="carouselExampleControls" class="carousel slide p-3 mt-3 shadow p-3 mb-5 bg-white rounded" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="carousel-image">
              <img data-aos="fade-right" data-aos="fade-right" class="d-block rounded img-rounded" height="200" width="200"  src="{{ asset('storage/testimoni/testi1.jpg') }}" alt="First slide">
            </div>
            <div class="carousel-caption d-none d-md-block text-dark">
              <h3 data-aos="flip-right">Pak Julkipli</h3>
              <h4 data-aos="flip-right">Petani</h4>
              <p data-aos="flip-right">Banyak promonya jadi belanja disini irit terus!</p>
            </div>
          </div>
          <div class="carousel-item">
            <img data-aos="fade-right" class="d-block rounded img-rounded" height="200" width="200" src="{{ asset('storage/testimoni/testi2.jpg') }}" alt="Second slide">
            <div class="carousel-caption d-none d-md-block text-dark">
              <h3 data-aos="flip-right">Pak Diwid</h3>
              <h4 data-aos="flip-right">Peternak Lele</h4>
              <p data-aos="flip-right">Penjual ramah , admin 24 jam online.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img data-aos="fade-right" class="d-block rounded img-rounded" height="200" width="200" src="{{ asset('storage/testimoni/testi3.jpg') }}" alt="Third slide">
            <div class="carousel-caption d-none d-md-block text-dark">
              <h3 data-aos="flip-right">Pak diudik</h3>
              <h4 data-aos="flip-right">Rentenir</h4>
              <p data-aos="flip-right">Harga murah-murah banyak pilihan dan keren keren</p>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span  aria-hidden="true"><i class="fas fa-3x fa-chevron-left testi-prev"></i></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span  aria-hidden="true"><i class="fas fa-3x fa-chevron-right testi-next"></i></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
  </div>
  {{-- END TESTIMONIALS --}}
</div>

@endsection

