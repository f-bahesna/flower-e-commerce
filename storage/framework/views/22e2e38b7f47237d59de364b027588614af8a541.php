<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  
    <title><?php echo $__env->yieldContent('title'); ?></title>


    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="<?php echo e(asset('css/dashboard.css')); ?>" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a href="<?php echo e(route('home-page')); ?>">Back to HOME</a>
  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Guswin Sanse</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Belum Berfungsi" aria-label="Search">
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Sign out</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-2 col-lg-1 d-md-block bg-light sidebar collapse">
      <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="<?php echo e(route('admin')); ?>">
              <span data-feather="home"></span>
              Dashboard <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('settings')); ?>">
              <span data-feather="file"></span>
              Settings
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('show')); ?>">
              <span data-feather="shopping-cart"></span>
              Message
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="shopping-cart"></span>
              Akun
            </a>
          </li>
        </ul>

        
        <ul class="nav flex-column mb-2">
          
          
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-10 ml-sm-auto col-lg-11 px-md-4">
      <h2><?php echo $__env->yieldContent('title'); ?></h2>
      <div class="table-responsive">
        <?php echo $__env->yieldContent('content'); ?>
      </div>
    </main>
  </div>
</div>
  <!-- JQuery -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo e(asset('template/vendor/bootstrap/js/bootstrap.bundle.js')); ?>"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>
        <?php echo $__env->make('utilities.scriptAdmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</html>
<?php /**PATH E:\Coding\Portfolio\bunga\resources\views/layouts/admin/appAdmin.blade.php ENDPATH**/ ?>