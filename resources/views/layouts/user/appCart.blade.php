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
            <a class="nav-link navbar-text" href="{{ route('home-page') }}"><i class="fas fa-2x fa-arrow-left"></i>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item active mt-1">
            <h2>@yield('title')</h2>
          </li>
     
          
          @if(Auth::check())
          <input type="hidden" id="user_id" value="{{ $user_id }}">
          <li class="nav-item navbar-right">
            <!-- Modal: modalAbandonedCart-->
            <!-- Modal: modalAbandonedCart-->
          </li>
          <li class="nav-item navbar-right user-name-cart">
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

  <div class="container" id="main-container">
    {{-- STEPPER --}}
    <div class="container">
      <!-- Horizontal Steppers -->
      <div class="row">
        <div class="col-md-12">

          <!-- Stepers Wrapper -->
          <ul class="stepper stepper-horizontal">
            <!-- First Step -->
            <li class="completed bg-light">
              <a href="#!">
                <span><i class="fas fa-2x fa-cart-arrow-down"></i></span>
                <span class="label">Cek Keranjangmu</span>
              </a>
            </li>
            <!-- Second Step -->
            <li class="active">
              <a href="#!">
                <span><i class="far fa-2x fa-money-bill-alt"></i></span>
                <span class="label">Pembayaran</span>
              </a>
            </li>
            <!-- Third Step -->
            <li class="warning">
              <a href="#!">
                <span><i class="far fa-2x fa-calendar-check"></i></span>
                <span class="label">Konfirmasi</span>
              </a>
            </li>
          </ul>
          <!-- /.Stepers Wrapper -->

        </div>
      </div>
    <!-- /.Horizontal Steppers -->
  </div>
    @yield('content')
</div>
  <!-- /.container -->

 <!-- Footer -->
 <footer class="page-footer font-small bg-dark pt-4">

  <!-- Footer Links -->
  <div class="container-fluid text-center">
    <div class="row">
      <div class="col-md-6 mt-md-0 mt-3">
        <h5 class="text-uppercase">Guswin Sanse</h5>
        <p>Toko yang menjual berbagai Tanaman Hias</p>
      </div>
      <hr class="clearfix w-100 d-md-none pb-3">
      <!-- Grid column -->
      <div class="col-md-6 mb-md-0 mb-3">
        <ul class="list-unstyled">
          {{-- Facebook --}}
          <a href="https://web.facebook.com/etwin.brcama" class="fb-ic">
            <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
          </a>
          <!-- Twitter -->
          <a class="tw-ic">
            <i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
          </a>
          <!--Instagram-->
          <a class="ins-ic">
            <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
          </a>
        </div>
      </div>
      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© {{ date('Y') }} Copyright:
    <a href="{{ route('home-page') }}">Guswinsanse.com</a>
  </div>
  <!-- Copyright -->

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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@include('utilities.scriptHome')

</body>

</html>
