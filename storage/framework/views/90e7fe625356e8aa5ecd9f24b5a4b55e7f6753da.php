<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $__env->yieldContent('title'); ?></title>
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
  <!-- Bootstrap core CSS -->
  <link href="<?php echo e(asset('template/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

  <!-- Custom styles for this template -->
  <link href="<?php echo e(asset('template/css/shop-homepage.css')); ?>" rel="stylesheet">

  
  <!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css?family=Lora:400,700|Montserrat:300" rel="stylesheet">

</head>

<body>
  
  <nav class="navbar navbar-light navbar-add">
    <a class="navbar-brand float-left ml-5" href="<?php echo e(route('home-page')); ?>"><img class="img-logo-top" src="<?php echo e(url('storage/image/guswinsanse.png')); ?>" alt=""></a>
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
            <a class="nav-link navbar-text" href="<?php echo e(route('home-page')); ?>">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link navbar-text" href="<?php echo e(route('about')); ?>">About</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link navbar-text" href="<?php echo e(route('product.all')); ?>">Product</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link navbar-text" href="#">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link navbar-text" href="<?php echo e(route('payment.index')); ?>">Konfirmasi & Check Pesanan</a>
          </li>
          
          <?php if(Auth::check()): ?>
          <input type="hidden" id="user_id" value="<?php echo e($user_id); ?>">
          <input type="hidden" id="count_cart" value="<?php echo e($countCart); ?>">
          <li class="nav-item navbar-right">
             <!-- Button trigger modal-->
            <?php if($countCart): ?>
              <button type="button" class="btn btn-info btn-sm shopping-cart"> 
                  <i class="fas fa-2x fa-shopping-cart"></i>
                  <span style="font-size: 10px;" class="badge badge-danger ml-2 countCart"><?php echo e($countCart); ?></span> 
              </button>
              <?php else: ?>
              <button type="button" class="btn btn-info btn-sm shopping-cart">
                <i class="fas fa-2x fa-shopping-cart"></i>
                <span class="badge badge-danger ml-2 countCart"></span>
              </button>
              <?php endif; ?>

            <!-- Modal: modalAbandonedCart-->
            <div class="modal fade right" id="modalAbandonedCart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
              aria-hidden="true" data-backdrop="false">
              <div class="modal-dialog modal-side modal-bottom-right modal-notify modal-info" role="document">
                <!--Content-->
                <div class="modal-content target-modal-content">
                  <!--Header-->
                  <div class="modal-header header-cart">
               
                  </div>

                  <!--Body-->
             
                    <div class="modal-body target-modal-body">
                  
                      <div class="dropdown-divider" id="divider"></div>
                    </div>
           
              
                  <div id="target-modal-body">

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
                <?php echo e(Auth::user()->name); ?>

              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <?php if(Auth::user()->user_role != 'user'): ?>
                <button class="dropdown-item mb-2" type="button"><a href="<?php echo e(route('admin')); ?>">Dashboard</a></button>
                <?php else: ?>
                <button class="dropdown-item mb-2" type="button"><a href="<?php echo e(route('index.profile')); ?>">Profile</a></button>
                <button class="dropdown-item mb-2" type="button"><a href="">Order Status</a></button>
                <?php endif; ?>
                  <a href="<?php echo e(route('user.logout')); ?>">
                    <button type="button" class="btn btn-danger btn-sm rounded" id="btn-logout">Logout</button>          
                  </a>
              </div>
            </div>
          </li>
          <?php else: ?>
          <li class="nav-item navbar-right">
              <a href="<?php echo e(route('login')); ?>">
                <button type="button" class="btn btn-info btn-sm btn-rounded">Login</button>          
            </a>
          </li>
          <li class="nav-item">
              <a href="<?php echo e(route('register')); ?>">
                <button type="button" class="btn btn-success btn-sm btn-rounded">Register</button>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
      
    </div>
  </nav>

  <div class="div" id="main-container"> 
    <div class="loader">
      <img src="<?php echo e(asset('loader/loader.gif')); ?>" alt="Loading...">
    </div>
    <?php echo $__env->yieldContent('content'); ?>
  </div>
  <!-- /.container -->

  <!-- Footer -->
 <!-- Footer -->
<footer class="page-footer font-small bg-dark pt-4">

  <!-- Footer Links -->
  <div class="container-fluid text-center">
    <div class="row">
      <div class="col-md-6 mt-md-0 mt-3">
        <h5 class="text-uppercase">Guswin Sanse</h5>
        <p>Toko yang menjual Tanaman Hias & Tanaman Koleksi khususnya Sanseviera</p>
      </div>
      <hr class="clearfix w-100 d-md-none pb-3">
      <!-- Grid column -->
      <div class="col-md-6 mb-md-0 mb-3">
        <ul class="list-unstyled">
          
          <a class="fb-ic">
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
  <div class="footer-copyright text-center py-3">© <?php echo e(date('Y')); ?> Copyright:
    <a href="<?php echo e(route('home-page')); ?>">Guswinsanse.com</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo e(asset('template/vendor/jquery/jquery.min.js')); ?>"></script>
  <script src="<?php echo e(asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  
  <!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php echo $__env->make('utilities.scriptHome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('utilities.scriptCard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init();
</script>
</body>

</html>
<?php /**PATH E:\Coding\Portfolio\bunga\resources\views/layouts/user/appUser.blade.php ENDPATH**/ ?>