<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Bootstrap core CSS -->
  <link href="{{ asset('template/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="{{ asset('template/css/shop-homepage.css') }}" rel="stylesheet">

  {{-- mdb --}}
  <!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
{{-- google font --}}
<link href="https://fonts.googleapis.com/css?family=Lora:400,700|Montserrat:300" rel="stylesheet">

</head>

<body>
  <nav class="navbar navbar-light navbar-add">
    <a class="navbar-brand float-left ml-5" href="{{ route('home-page') }}"><img class="img-logo-top" src="{{ url('storage/image/guswinsanse.png') }}" alt=""></a>
    <a class="navbar-brand float-right Telp" href="#">No Telf :0842333444555</a>
  </nav>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">

      <button class="navbar-toggler btn-collapse-left" type="button" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon icon-left"><i class="fas fa-align-justify"></i></span>
      </button>
      <button class="navbar-toggler float-right btn-collapse-right" type="button"  aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="fas fa-times"></i></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link navbar-text" href="{{ route('home-page') }}">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link navbar-text" href="{{ route('about') }}">About</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link navbar-text" href="{{ route('product.all') }}">Product</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link navbar-text" href="#">Contact</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link navbar-text" href="#">Konfirmasi Pembayaran</a>
          </li>
          
          @if(Auth::check())
          <li class="nav-item navbar-right">
             <!-- Button trigger modal-->
            <button type="button" class="btn btn-info btn-sm shopping-cart" data-toggle="modal"> <i class="fas fa-2x fa-shopping-cart"></i> 
              @if($countCart)
                <span style="font-size: 10px;" class="badge badge-danger ml-2 countCart">{{ $countCart }}</span>
              @else
                <span class="badge badge-danger ml-2 countCart"></span>
              @endif
            </button>

            <!-- Modal: modalAbandonedCart-->
            <div class="modal fade right" id="modalAbandonedCart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
              aria-hidden="true" data-backdrop="false">
              <div class="modal-dialog modal-side modal-bottom-right modal-notify modal-info" role="document">
                <!--Content-->
                <div class="modal-content target-modal-content">
                  <!--Header-->
                  <div class="modal-header">
                    <p class="heading">Product Di Keranjang
                    </p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                  </div>

                  <!--Body-->
                  @if($CartAdded)
                    <div class="modal-body target-modal-body">
                        @foreach($CartAdded as $key => $product)
                            <div class="row">
                              <div class="col-md-3">
                                <img class="img-cart" src="{{ url('storage/image/'.$product->gambar_product) }}" height="50" width="50" alt="">
                              </div>
                              <div class="col-md-4 nama-product-cart">{{ $product->nama_product }} <h6 class="font-weight-bold jumlah-cart">X{{ $product->total }}</h6></div>
                              <div class="col-md-5 total-cart">Rp. {{ number_format($CartProductPriceTotal[$key],0,',','.') }}</div>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endforeach
                      <div class="dropdown-divider"></div>
                      <p>*Klik ke keranjang untuk melihat yang lainnya</p>
                    </div>
                  @endif
                  <!--Footer-->
                  <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-info">Ke Keranjang</a>
                    {{-- <a type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">Cancel</a> --}}
                  </div>
                </div>
                <!--/.Content-->
              </div>
            </div>
            <!-- Modal: modalAbandonedCart-->
          </li>
          <li class="nav-item ">
            <div class="dropdown">
              <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <button class="dropdown-item" type="button">Profile</button>
                <button class="dropdown-item" type="button">Payment</button>
                  <a href="{{ route('user.logout') }}">
                    <button type="button" class="btn btn-danger btn-sm rounded" id="btn-logout">Logout</button>          
                  </a>
              </div>
            </div>
          </li>
          @else
          <li class="nav-item navbar-right">
              <a href="{{ route('login') }}">
                <button type="button" class="btn btn-info btn-sm btn-rounded">Login</button>          
            </a>
          </li>
          <li class="nav-item">
              <a href="{{ route('register') }}">
                <button type="button" class="btn btn-success btn-sm btn-rounded">Register</button>
            </a>
          </li>
          @endif
        </ul>
      </div>
    </div>
  </nav>

  <div class="container" style="margin-top: 20px;">
    @yield('content')
</div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  {{-- mdb --}}
  <!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

@include('utilities.scriptHome')

</body>

</html>
